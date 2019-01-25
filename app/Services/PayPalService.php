<?php

namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Api\PaymentCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;
use Request;

class PayPalService
{
    private $apiContext;

    private $mode;

    private $client_id;

    private $secret;

    private $itemList;

    private $paymentCurrency;

    private $totalAmount;
    // URL that redirect to if payment succeed
    private $returnUrl;
    // URL that redirect to if user cancel payment
    private $cancelUrl;

    private $card;

    public function __construct()
    {

        // Detect if we are running in live mode or sandbox
        if(config('paypal.settings.mode') == 'live'){
            $this->client_id = config('paypal.live_client_id');
            $this->secret = config('paypal.live_secret');
        } else {
            $this->client_id = config('paypal.sandbox_client_id');
            $this->secret = config('paypal.sandbox_secret');
        }

        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));

        $this->apiContext->setConfig(config('paypal.settings'));

        $this->paymentCurrency = "USD";

        $this->totalAmount = 0;
    }

    /**
     * Set payment currency
     *
     * @param string $currency String name of currency
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->paymentCurrency = $currency;

        return $this;
    }

    /**
     * Get current payment currency
     *
     * @return string Current payment currency
     */
    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    public function setCard($cardInfo = null)
    {
        $card = new PaymentCard();
        $card->setType("visa")
            ->setNumber("4032038484322114")
            ->setExpireMonth("02")
            ->setExpireYear("2024")
            ->setCvv2("012")
            ->setFirstName("Joe")
            ->setBillingCountry("US")
            ->setLastName("Shopper");

        $this->card = $card;

        return $this;
    }

    /**
     * Add item to list
     *
     * @param array $itemData Array item data
     * @return self
     */
    public function setItem($itemData)
    {

        if (count($itemData) === count($itemData, COUNT_RECURSIVE)) {
            $itemData = [$itemData];
        }

        foreach ($itemData as $data) {

            $item = new Item();

            $item->setName($data['name'])
                 ->setCurrency($this->paymentCurrency)
                 ->setSku($data['sku'])
                 ->setQuantity($data['quantity'])
                 ->setPrice($data['price']);

            $this->itemList[] = $item;

            $this->totalAmount += $data['price'] * $data['quantity'];
        }

        return $this;
    }

    /**
     * Get list item
     *
     * @return array List item
     */
    public function getItemList()
    {
        return $this->itemList;
    }

    /**
     * Get total amount
     *
     * @return mixed Total amount
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set return URL
     *
     * @param string $url Return URL for payment process complete
     * @return self
     */
    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;

        return $this;
    }

    /**
     * Get return URL
     *
     * @return string Return URL
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * Set cancel URL
     *
     * @param $url Cancel URL for payment
     * @return self
     */
    public function setCancelUrl($url)
    {
        $this->cancelUrl = $url;

        return $this;
    }

    /**
     * Get cancel URL of payment
     *
     * @return string Cancel URL
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * Create payment
     *
     * @param string $transactionDescription Description for transaction
     * @return mixed Paypal checkout URL or false
     */
    // public function createPayment($transactionDescription, $webProfileId)
    public function createPayment($transactionDescription)

    {
        $checkoutUrl = false;

        // set type payment
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        // $payer->setPaymentMethod('credit_card')
        //     ->setFundingInstruments(array($fi));

        // create item list
        $itemList = new ItemList();
        $itemList->setItems($this->itemList);

        // set total amount
        $amount = new Amount();
        $amount->setCurrency($this->paymentCurrency)
               ->setTotal($this->totalAmount);

        // Transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription($transactionDescription);

        // create redirect
        $redirectUrls = new RedirectUrls();

        if (is_null($this->cancelUrl)) {
            $this->cancelUrl = $this->returnUrl;
        }

        $redirectUrls->setReturnUrl($this->returnUrl)
                     ->setCancelUrl($this->cancelUrl);

        // create new payment instance
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);
                // ->setExperienceProfileId($webProfileId);

        // Execute create payment
        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $paypalException) {
            \Log::error('Paypal: Could not create payment!');
            \Log::error($paypalException->getCode());
            \Log::error($paypalException->getData());
            report($paypalException);
            throw $paypalException;

        } catch (\Exception $e){
            throw $e;
        }

        // If payment method = paypal => return url
        $approvalUrl = $payment->getApprovalLink();

        return $approvalUrl;
        // return $payment;
    }

    /**
     * Get payment status
     *
     * @return mixed Object payment details or false
     */
    public function getPaymentStatus()
    {

        $request = Request::all();

        if (empty($request['paymentId']) || empty($request['PayerID']) || empty($request['token'])) {
            return false;
        }

        $payment = Payment::get($request['paymentId'], $this->apiContext);

        $paymentExecution = new PaymentExecution();
        $paymentExecution->setPayerId($request['PayerID']);

        try{

            $paymentStatus = $payment->execute($paymentExecution, $this->apiContext);

        } catch (\PayPal\Exception\PayPalConnectionException $paypalException) {
            \Log::error('Paypal: Could not execute payment!');
            \Log::error($paypalException->getCode());
            \Log::error($paypalException->getData());
            report($paypalException);
            throw $paypalException;

        } catch (\Exception $e){
            throw $e;
        }

        return $paymentStatus;
    }

    /**
     * Get payment list
     *
     * @param int $limit Limit number payment
     * @param int $offset Start index payment
     * @return mixed Object payment list
     */
    public function getPaymentList($limit = 10, $offset = 0)
    {
        $params = [
            'count' => $limit,
            'start_index' => $offset
        ];

        try {
            $payments = Payment::all($params, $this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $paypalException) {
            throw $paypalException;
        }

        return $payments;
    }

    /**
     * Get payment details
     *
     * @param string $paymentId PayPal payment Id
     * @return mixed Object payment details
     */
    public function getPaymentDetails($paymentId)
    {
        try {
            $paymentDetails = Payment::get($paymentId, $this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $paypalException) {
            \Log::error('Paypal: Could not get payment details!');
            report($paypalException);
            throw $paypalException;
        } catch (\Exception $e){
            throw $e;
        }

        return $paymentDetails;
    }


    /**
     * Get sale from payment id
     * @param  integer $paymentId
     * @return Paypal\Api\Sale
     */
    public function getSaleFromPaymentId($paymentId)
    {
        try{
            $payment = $this->getPaymentDetails($paymentId);

            if($payment){
                $transactions = $payment->getTransactions();
                if(count($transactions)){
                    $relatedResources = $transactions[0]->getRelatedResources();
                    $sale = $relatedResources[0]->getSale();
                    return $sale;
                }else{
                    throw new \Exception("Could not get transactions.");
                }
            }
        } catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Refund a Sale
     * @param  PayPal\Api\Sale $sale
     * @return PayPal\Api\DetailedRefund
     */
    public function refundSale($sale)
    {

        $refundRequest = new RefundRequest();

        try{

            $refundedSale = $sale->refundSale($refundRequest, $this->apiContext);

        } catch(\PayPal\Exception\PayPalConnectionException $paypalException){
            \Log::error('Paypal: Could not refund!');
            report($paypalException);
            throw $paypalException;
        } catch(\Exception $e){
            throw $e;
        }

        return $refundedSale;
    }

    /**
     * Create a web experience profile
     * @return \PayPal\Api\WebProfile
     */
    public function createWebProfile(){

        $inputFields = new \PayPal\Api\InputFields();
        $inputFields->setNoShipping(1);

        $webProfile = new \PayPal\Api\WebProfile();
        $webProfile->setName("Ofpeak" . uniqid())
                ->setInputFields($inputFields);

        try {

            $createProfileResponse = $webProfile->create($this->apiContext);

        } catch(\PayPal\Exception\PayPalConnectionException $paypalException){
            \Log::error('Paypal: Could not create webprofile!');
            report($paypalException);
            throw $paypalException;
        } catch(\Exception $e){
            throw $e;
        }

        return $createProfileResponse;
    }

    /**
     * Get a web profile by ID
     * @param  string $webProfileId
     * @return \PayPal\Api\WebProfile
     */
    public function getWebProfile($webProfileId){
        try{

            $webProfile = \PayPal\Api\WebProfile::get($webProfileId, $this->apiContext);

        } catch(\PayPal\Exception\PayPalConnectionException $paypalException){
            \Log::error('Paypal: Could not get webprofile: '. $webProfileId);
            report($paypalException);
            throw $paypalException;
        } catch(\Exception $e){
            throw $e;
        }

        return $webProfile;
    }

    /**
     * List web experience profiles
     * @return array
     */
    public function getListWebProfiles(){
        try{

            $list = \PayPal\Api\WebProfile::get_list($this->apiContext);

        } catch(\PayPal\Exception\PayPalConnectionException $paypalException){
            \Log::error('Paypal: Could not get list webprofiles!');
            report($paypalException);
            throw $paypalException;
        } catch(\Exception $e){
            throw $e;
        }

        return $list;
    }

    /**
     * Delete a web profile
     * @param  string $webProfileId
     * @return void
     */
    public function deleteWebProfile($webProfileId){
        $webProfile = new \PayPal\Api\WebProfile();
        $webProfile->setId($webProfileId);

        try{
            $webProfile->delete($this->apiContext);
        } catch(\PayPal\Exception\PayPalConnectionException $paypalException){
            \Log::error('Paypal: Could not delete webprofiles: '. $webProfileId);
            report($paypalException);
            throw $paypalException;
        } catch(\Exception $e){
            throw $e;
        }
    }
}