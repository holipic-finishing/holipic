<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;
use DB ;
use App\Models\Email;
use App\Mail\SendMailCustomers;
/**
 * Class CompanyRepository
 * @package App\Repositories
 * @version December 10, 2018, 3:23 am UTC
 *
 * @method Company findWithoutFail($id, $columns = ['*'])
 * @method Company find($id, $columns = ['*'])
 * @method Company first($columns = ['*'])
*/
class CompanyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'address',
        'user_id',
        'logo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
    }

    /**
    
        TODO:
        - function to get list companies 
    
    */
    
    public function getCompanies(){
        
        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id')
                    ->select('c.id as id', 'c.name','c.phone' ,'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', 'p.file_upload' ,'u.last_name', 'u.first_name','c.owner_id', 'c.coupon_codes_id')
                    ->whereNull('c.deleted_at')
                    ->orderBy('c.id', 'desc')
                    ->get();
       
        $results = $this->transform($results);

        return $results;
    }

    /**
        TODO:
        - function to search companies by company_name, fullname, email ;  filter package name
        -@param : keywords search, package_name

    */
    
    public function search($input){

        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id');


        if($input['keywords'] != null){
            $results = $results->where(function($query) use ($input){
                $query->orwhere('name', 'like', '%'.$input['keywords'].'%')
                                ->orwhere('email', 'like', '%'.$input['keywords'].'%')
                                ->orWhereRaw("concat(first_name,' ', last_name) like '%{$input['keywords']}%' ");
            });
            if($input['filterPackage'] != null){
                if($input['filterPackage'] != "All"){
                    $results = $results->where('p.package_name','=', $input['filterPackage']);
                }
            }
                               
        }else{
            if($input['filterPackage'] != null){
                if($input['filterPackage'] != "All"){
                    $results = $results->where('p.package_name','=', $input['filterPackage']);
                }
            }
        }
  
        $results = $results->select('c.id as id', 'c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', 'p.file_upload' , 'u.last_name', 'u.first_name')->get();
        

        $results = $this->transform($results);

        return $results;
    }


    // public function handleTransaction($companyId){
    //      $results = DB::table('transactions as t')
    //                 ->rightJoin('companies as c', 't.company_id', '=', 'c.id')
    //                 ->join('users as u', 'u.id', '=', 'c.owner_id')
    //                 ->join('packages as p', 'p.id', '=', 'u.package_id')
    //                 ->select('c.id as company_id', 't.amount', 'p.fee','c.name', 'c.description', 'c.address', 'c.logo', 'u.email', 'p.package_name', DB::raw('(t.amount * p.fee /100) as system_fee'), 'u.first_name', 'u.last_name' )
    //                 ->where('t.company_id', $companyId)
    //                 ->get();


    //     return $results;
    // }

    /**
    
       TODO:
        - create new_field from old_filed
       
     */
    
    public function transform($results){
        
        foreach ($results as $key => $result) {      
            $results[$key]->fullname = $result->first_name ." ".$result->last_name;             
        }

        $results = $this->total($results);

        return $results;
    } 


    public function total($input){
        $listID = [];

        foreach ($input as $key => $value) {
            array_push($listID, $value->id);
        }
        
        $results = $this->model->with(['files','user.package','transactions'])->whereIn('id',$listID)->get(); 


        foreach ($results as $key => $value) {
            $total_file_size = 0;
            $total_system_fee = 0;
            $total_amount = 0;
            foreach ($value->files as $item) {
                $total_file_size += $item->file_size;
            }
            foreach ($value->transactions as $item) {
                $total_system_fee += $item->system_fee;
                $total_amount += $item->amount;
            }
            $input[$key]->total_file_size = $total_file_size;
            $input[$key]->total_income_fee = $total_system_fee;
            $input[$key]->total_income = $total_amount - $total_system_fee;

        }

        return $input;
    }


    public function handleShowInformationCompany($companyId)
    {

        $totalSize = DB::table('files')->where('company_id', $companyId)
                    ->select(DB::raw("sum(file_size) as total"))->groupBy('company_id')->first();

        $company = $this->model
                    ->join('users', 'users.id', 'companies.owner_id')
                    ->join('packages', 'packages.id', 'users.package_id')
                    ->select('companies.id', 'companies.description', 'companies.name', 'companies.address', 'packages.package_name', 'users.first_name', 'users.last_name', 'users.email', 'users.created_at', 'packages.file_upload', 'companies.coupon_codes_id')
                    ->where('companies.id', $companyId)
                    ->first()->toArray();

        if(empty($totalSize)) {
            $company['total_upload'] = 0;
        } else{

            $company['total_upload'] = number_format($totalSize->total/1024, 4);
        }    

        $company['capacity'] = number_format($company['file_upload'] - $company['total_upload']/1024, 2);

        $company['fullname'] = $company['first_name'] ." ".$company['last_name'];

        $companyRelationship = $this->model->with('user.package')
                            ->with(['files' => function($query) use($companyId){
                                $query->where('files.company_id', $companyId);
                            }])
                            ->with(['transactions' => function($query) use($companyId) {
                                $query->where('transactions.company_id', $companyId);
                            }])
                            ->where([['companies.id', $companyId]])
                            ->get()->toArray(); 

        foreach ($companyRelationship as $key => $value) 
        {

            $totalFileSize = 0;

            $totalSystemFee = 0;

            $totalAmount = 0;

            foreach ($value['files'] as $item) {
                $totalFileSize += $item['file_size'];
            }

            foreach ($value['transactions'] as $item) {

                $totalSystemFee += $item['system_fee'];

                $totalAmount += $item['amount'];
            }
            
        }

        $company['total_income_fee'] = $totalSystemFee;

        $company['total_income'] = $totalAmount - $totalSystemFee;

        $couponCode = DB::table('coupon_codes')->where('id', $company['coupon_codes_id'])->where('active', 1)->get();

        return [$company, $couponCode];
        
    }

    //  show email customer by company id
    //  @From : func: handleExportCustomerByCompanyId()
    public function getCustomerByCompanyId($company_id){
        $results = $this->scopeQuery(function($query) use ($company_id){
            $query = $query->whereHas('branchs', function($q) use ($company_id) {
                        $q->where('company_id',$company_id);
                      })
                        ->with('branchs.customers');

             return $query;
         })->get();
        
        $results = $this->getEmailCustomer($results);

        return $results;
    }

    // get email customer
    //  @From : func: getCustomerByCompanyId()
    public function getEmailCustomer($attributes){
        $data = [];
        foreach ($attributes[0]['branchs'] as $branch) 
        { 
            foreach ($branch['customers'] as $customer) 
            {
                $email = $customer->user['email'];

                array_push($data, $email);
            }
        }

        return $data;
    }

    // export email file CSV customer by company id
    public function handleExportCustomerByCompanyId($company_id) {

        $results = $this->getCustomerByCompanyId($company_id);

        if(!$results)
            return false;

        $pathPublic = public_path() . '/files' . DIRECTORY_SEPARATOR;

        $filename =  $company_id . '_Customer_email.csv';
       
        $file = fopen($pathPublic . $filename,"a+");

        try{

            foreach ($results as $key => $value) {

                $data = [];
                $data[] = $key;
                $data[] = $value;
                fputcsv($file, $data);
            }

            fclose($file);
        }catch (Exception $e)
        {
            \Log::info(' Errors to insert csv file - '.$e->getMessage());
        }
    
    }

    public function handleSendMailToCustomers()
    {
        $template = Email::findOrFail(request('templateId'));
        $emails = [];

        if(request('email') == 'all') {
            if(!empty(request('companyId'))) {

                $emails = $this->getCustomerByCompanyId(request('companyId'));
            }

        } else {
                $emails = request('email'); 
        }

        if(isset($template) && !empty($template)) {
            foreach($emails as $email) {
                \Mail::to($email)->queue(new SendMailCustomers($template)); 
            }

            return true;
        }

        return false;
    }
}
