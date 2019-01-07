<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Package;
use InfyOm\Generator\Common\BaseRepository;
use DB;
use Carbon\Carbon;

/**
 * Class TransactionRepository
 * @package App\Repositories
 * @version December 10, 2018, 4:42 am UTC
 *
 * @method Transaction findWithoutFail($id, $columns = ['*'])
 * @method Transaction find($id, $columns = ['*'])
 * @method Transaction first($columns = ['*'])
*/
class TransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'type',
        'amount',
        'status',
        'company_id',
        'dated'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Get Information Company And Total Amount Default
     * @param  int $companyId
     * @return Array
     */
    public function getInformationCompanyAndTotalAmountDefault($companyId)
    {
       
        $companies = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                    ->join('companies', 'companies.id', '=', 'transactions.company_id')
                    ->join('users', 'users.id', '=', 'companies.owner_id')
                    ->join('packages', 'packages.id', '=', 'users.package_id')
                    ->select(DB::raw("sum(amount * packages.fee /100) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol' ) 
                    ->where('transactions.company_id', $companyId)
                    ->where(DB::raw('dated'), '>=', Carbon::now()->subDays(10)->toDateString())
                    ->where(DB::raw('dated'), '<=', Carbon::now()->toDateString())
                    ->where('type', 1)
                    ->groupBy('date', 'currency_id')
                    ->orderBy('date', 'asc')
                    ->get()->toArray();
        
        $data = [];

        $labels = $this->createLabels(null, $companyId);

        $length = count($labels);

        foreach($companies as $company){
            $date = str_replace(' 00:00:00', '', $company['date']);
            $key = $company['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {
                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$date] = $company['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    /**
     * Create Labels
     */
    private function createLabels($date = null, $companyId)
    {
        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"))->where('company_id', $companyId)
                            ->where(DB::raw('dated'), '>=', Carbon::now()->subDays(10)->toDateString())
                            ->where(DB::raw('dated'), '<=', Carbon::now()->toDateString())
                            ->groupBy('dated')->orderBy('dated', 'asc')->get()->toArray();

        return $date;
    }

    //function show label date default with time for chart

    private function createLabelsByTime($time,$timeBefore ,$companyId)
    {

        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"))
                            ->where('company_id', $companyId)
                            ->where(DB::raw('dated'), '>=', $timeBefore)
                            ->where(DB::raw('dated'), '<=', $time)
                            ->groupBy('dated')->orderBy('dated', 'asc')->get()->toArray();

        return $date;
    }

    //function show chart with day or month

    public function getInformationCompanyAndTotalAmountByTime($request)
    {   
        $companies = $this->model;

        if($request['type'] == 'Day') {
            
            $time = explode("-", $request['date']);
            $date = Carbon::create($time[0], $time[1], $time[2]);

            $dateBefore = Carbon::create($time[0], $time[1], $time[2])->subDays(10)->toDateString();

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol');

        } else {

            $timeMonth = explode("-", $request['date']);
            $date = Carbon::create($timeMonth[0], $timeMonth[1], 31 );

            $dateBefore = Carbon::create($timeMonth[0], $timeMonth[1], 1)->subMonths(12);

            $companies = $companies->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->select(DB::raw("sum(amount) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol'); 
        }

        $companies = $companies->where('company_id', $request['companyId'])
                            ->where(DB::raw('dated'), '>=', $dateBefore)
                            ->where(DB::raw('dated'), '<=', $date)
                            ->groupBy('date', 'currency_id')->orderBy('date', 'asc')
                            ->get()->toArray();

        $data = [];

        $labels = $this->createLabelsByTime($date, $dateBefore, $request['companyId']);

        $length = count($labels);

        foreach($companies as $company){
            $date = str_replace(' 00:00:00', '', $company['date']);
            $key = $company['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$date] = $company['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    public function handleChartCompanyWithTime($request)
    { 
        if($request['type'] == '' || $request['companyId'] = '') {
            return false;
        }
        
        $companyId = $request['company'];

        $company = $this->model;

        if($request['type'] == 'day') {
            $fromDate = Carbon::parse($request['startTime']);
            
            $toDate = Carbon::parse($request['endTime']);
            
            $diffDate = $fromDate->diffInDays($toDate);

            if($fromDate > $toDate) {
                return [
                    'success' => false, 
                    'message' => 'Start date must be less than end date or end date must be greater than start date'
                ];
            }

            if($diffDate < 10 || $diffDate > 10) {
                return [
                    'success' => false, 
                    'message' => 'Start day to End day must 10 days'
                ];
            }

            return $this->loadChartWithFromDateToDate($fromDate->toDateString(), $toDate->toDateString(), $companyId);
        }

        if($request['type'] == 'revenue') {
            return $this->getInformationCompanyAndTotalAmountDefault($companyId);
        }

        if($request['type'] == 'month') {
            if(!isset($request['startTime']) && !isset($request['endTime'])) {
                return $this->loadChartWithMonthDefault($companyId);
            } else {

                $fromMonth = Carbon::parse($request['startTime']);
                
                $toMonth = Carbon::parse($request['endTime']);
                
                $diffMonth = $fromMonth->diffInMonths($toMonth);

                if($fromMonth > $toMonth) {
                    return [
                        'success' => false, 
                        'message' => 'Start month must be less than End month or End month must be greater than Start month'
                    ];
                }

                if($diffMonth > 12) {
                    return [
                        'success' => false, 
                        'message' => 'Just choose show with 12 months'
                    ];
                }

                return $this->loadChartWithFromMonthToMonth($request['startTime'], $request['endTime'], $companyId);
            }
        } 

        if($request['type'] == 'year') {
            if(!isset($request['startTime']) && !isset($request['endTime'])) {
                return $this->loadChartWithYearDefault($companyId);
            } else {

                if($request['startTime'] >= $request['endTime']) {
                    return [
                        'success' => false, 
                        'message' => 'Start Year must be less than End Year or End Year must be greater than Start Year'
                    ];
                }

                return $this->loadChartWithFromYearToYear($request['startTime'], $request['endTime'], $companyId);
                
            } 
        }

        if($request['type'] == 'week') {
            $weeks = $this->initWeekDays();

            return $this->loadChartWithWeekDefault($weeks, $companyId);
        }
    }

    public function initWeekDays()
    {
        $today = Carbon::today();

        $arrayWeek = [];

        for ($i=0; $i <=5 ; $i++) { 

            $arrayWeek[$i]['endOfWeek'] = Carbon::parse($today)->format('Y-m-d');

            $arrayWeek[$i]['startOfWeek'] = Carbon::parse($today)->subDays(6)->format('Y-m-d');

            $today = Carbon::parse($today)->subDays(7)->format('Y-m-d');
        }
        return $arrayWeek;
    }

    public function loadChartWithWeekDefault($dayWeek, $companyId)
    {
        $startDay   = Carbon::today()->subDays(41)->format('Y-m-d');

        $endDay     = Carbon::today()->format('Y-m-d');

        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->join('companies', 'companies.id', '=', 'transactions.company_id')
                                    ->join('users', 'users.id', '=', 'companies.owner_id')
                                    ->join('packages', 'packages.id', '=', 'users.package_id')
                                    ->select(DB::raw("sum(amount * packages.fee /100) as total"), DB::raw("DATE_FORMAT(dated,'%Y-%m-%d') as date"), 'currencies.id','currencies.symbol') 
                                    ->where('transactions.company_id', $companyId)
                                    ->where(DB::raw("date(dated)"), '>=', $startDay)
                                    ->where(DB::raw("date(dated)"), '<=', $endDay)
                                    ->where('type', 1)
                                    ->groupBy('date', 'currency_id')
                                    ->orderBy('date', 'asc')
                                    ->get()->toArray(); 

        $arrayCompanyWithKey = [];

        foreach($company as $value) {
            $arrayCompanyWithKey[$value['symbol']];
        }
        $data = [];             

        foreach ($dayWeek as $key => $date) {

            $total = 0;

            foreach ($company as $index=>$value) {
                $symbol = $value['symbol'];
                
                $day = Carbon::parse($value['date'])->format('Y-m-d');

                if($date['startOfWeek'] <= $day && $day <= $date['endOfWeek']) {
                    $total = $total + $value['total'];  
                } 
                else {
                    if(!isset($data[$symbol][$date['startOfWeek'].'-'.$date['endOfWeek']])) {
                        $data[$symbol][$date['startOfWeek'].'-'.$date['endOfWeek']] = 0;    
                    }
                    $data[$symbol][$date['startOfWeek'].'-'.$date['endOfWeek']] = $total;  
                }
            }

            //$dayWeek[$key]['total'] = $total;

        }

        $weeks = $this->initWeekDays();  
        
        return  [  
            'labels' => $weeks,
            'data' => $dayWeek 
        ];        

    }

    private function createLabelsByYear($year, $yearBefore ,$companyId)
    {
        $length = $year - $yearBefore;

        $array = [];

        for($i = 0 ; $i<= $length; $i++) {

            $yearNew = $yearBefore;

            $array[$i]['date'] = $yearNew;

            $yearBefore = $yearBefore + 1;
        }

        // $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y') as date"))
        //                     ->where('company_id', $companyId)
        //                     ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $yearBefore)
        //                     ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $year)
        //                     ->groupBy('date')->orderBy('date', 'asc')->get()->toArray();

        return $array;
    }   

    private function createLabelsByMonth($month, $monthBefore ,$companyId)
    {
        $date = $this->model->select(DB::raw("DATE_FORMAT(dated,'%Y-%m') as date"))
                            ->where('company_id', $companyId)
                            ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $monthBefore)
                            ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $month)
                            ->groupBy('date')->orderBy('date', 'asc')->get()->toArray();

        return $date;
    }

    public function loadChartWithFromMonthToMonth($fromMonth, $toMonth, $companyId)
    {
        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                    ->join('companies', 'companies.id', '=', 'transactions.company_id')
                                    ->join('users', 'users.id', '=', 'companies.owner_id')
                                    ->join('packages', 'packages.id', '=', 'users.package_id')
                                    ->select(DB::raw("sum(amount * packages.fee /100) as total"), DB::raw("DATE_FORMAT(dated,'%Y-%m') as date"), 'currencies.id','currencies.symbol') 
                                    ->where('transactions.company_id', $companyId)
                                    ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                                    ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth)
                                    ->where('type', 1)
                                    ->groupBy('date', 'currency_id')
                                    ->orderBy('date', 'asc')
                                    ->get()->toArray();

        $data = [];

        $labels = $this->createLabelsByMonth($toMonth, $fromMonth, $companyId);

        $length = count($labels);

        foreach($company as $companyValue){
            $key = $companyValue['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$companyValue['date']] = $companyValue['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    public function loadChartWithMonthDefault($companyId)
    {
        $month = Carbon::now()->format('Y-m');

        // $explodeMonth = explode('-', $month);

        $monthBefore = Carbon::now()->subMonths(12)->format('Y-m');

        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                    ->join('companies', 'companies.id', '=', 'transactions.company_id')
                    ->join('users', 'users.id', '=', 'companies.owner_id')
                    ->join('packages', 'packages.id', '=', 'users.package_id')
                    ->select(DB::raw("sum(amount * packages.fee /100) as total"),DB::raw("DATE_FORMAT(dated,'%Y-%m') as date"), 'currencies.id','currencies.symbol' ) 
                    ->where('transactions.company_id', $companyId)
                    ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $monthBefore)
                    ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $month)
                    ->where('type', 1)
                    ->groupBy('date', 'currency_id')
                    ->orderBy('date', 'asc')
                    ->get()->toArray();

        $data = [];

        $labels = $this->createLabelsByMonth($month, $monthBefore, $companyId);

        $length = count($labels);

        foreach($company as $companyValue){
            $key = $companyValue['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$companyValue['date']] = $companyValue['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    public function loadChartWithYearDefault($companyId)
    {
        $year = Carbon::now()->year;

        $yearBefore = Carbon::now()->subYears(4)->year;

        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                ->join('companies', 'companies.id', '=', 'transactions.company_id')
                                ->join('users', 'users.id', '=', 'companies.owner_id')
                                ->join('packages', 'packages.id', '=', 'users.package_id')
                                ->select(DB::raw("sum(amount * packages.fee /100) as total"), DB::raw("DATE_FORMAT(dated,'%Y') as date"), 'currencies.id','currencies.symbol') 
                                ->where('transactions.company_id', $companyId)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $yearBefore)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $year)
                                ->where('type', 1)
                                ->groupBy('date', 'currency_id')
                                ->orderBy('date', 'asc')
                                ->get()->toArray();
        $data = [];

        $labels = $this->createLabelsByYear($year, $yearBefore, $companyId);

        $length = count($labels);

        foreach($company as $companyValue){
            $key = $companyValue['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$companyValue['date']] = $companyValue['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    public function loadChartWithFromYearToYear($startYear, $endYear, $companyId) 
    {
        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                                ->join('companies', 'companies.id', '=', 'transactions.company_id')
                                ->join('users', 'users.id', '=', 'companies.owner_id')
                                ->join('packages', 'packages.id', '=', 'users.package_id')
                                ->select(DB::raw("sum(amount * packages.fee /100) as total"), DB::raw("DATE_FORMAT(dated,'%Y') as date"), 'currencies.id','currencies.symbol') 
                                ->where('transactions.company_id', $companyId)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $startYear)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $endYear)
                                ->where('type', 1)
                                ->groupBy('date', 'currency_id')
                                ->orderBy('date', 'asc')
                                ->get()->toArray();
        $data = [];

        $labels = $this->createLabelsByYear($endYear, $startYear, $companyId);

        $length = count($labels);

        foreach($company as $companyValue){
            $key = $companyValue['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$companyValue['date']] = $companyValue['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }

    public function loadChartWithFromDateToDate($fromDate, $toDate, $companyId)
    {
        $company = $this->model->join('currencies','currencies.id', '=', 'transactions.currency_id')
                               ->join('companies', 'companies.id', '=', 'transactions.company_id')
                               ->join('users', 'users.id', '=', 'companies.owner_id')
                               ->join('packages', 'packages.id', '=', 'users.package_id')
                               ->select(DB::raw("sum(amount * packages.fee /100) as total"), DB::raw("DATE_FORMAT(dated,'%Y-%c-%d') as date"), 'currencies.id','currencies.symbol')
                               ->where('transactions.company_id', $companyId)
                               ->where(DB::raw('dated'), '>=', $fromDate)
                               ->where(DB::raw('dated'), '<=', $toDate)
                               ->groupBy('date', 'currency_id')->orderBy('date', 'asc')
                               ->get()->toArray();

        $data = [];

        $labels = $this->createLabelsByTime($toDate, $fromDate, $companyId);

        $length = count($labels);

        foreach($company as $companyValue){
            $key = $companyValue['symbol'];
            
            for($i = 0; $i < $length; $i++){
                if(!isset($data[$key][$labels[$i]['date']])) {

                    $data[$key][$labels[$i]['date']] = 0;
                }
            }
            $data[$key][$companyValue['date']] = $companyValue['total'];
        }

        return [
            'labels' => $labels,
            'data' => $data 
        ]; 
    }


    public function reportTransactionrDaily($attributes,$dates){

        if(isset($attributes['start_day']) && isset($attributes['end_day']) )
        {
            $startDay = Carbon::parse($attributes['start_day'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day'])->format('Y-m-d');

        }else {

            $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');
        }
       

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();


        $dates = $this->sumSystemFee($dates, $transactions, 'day');
       
        return $dates;
    }

    public function reportTransactionMonth($attributes,$InMonth){

        if(isset($attributes['start_month']) && isset($attributes['end_month']))
        {
            $fromMonth = Carbon::parse($attributes['start_month'])->format('Y-m');

            $toMonth = Carbon::parse($attributes['end_month'])->format('Y-m');
        }
        else {

            $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');

            $toMonth = Carbon::today()->format('Y-m');
        }

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth)
                        ->get()->toArray();


        $InMonth = $this->sumSystemFee($InMonth, $transactions, 'month');

        return $InMonth;
    }

    public function reportTransactionYear($attributes,$InYear){

        if(isset($attributes['start_year']) && isset($attributes['end_year']))
        {
            $from_year = Carbon::parse($attributes['start_year'])->format('Y');

            $to_year = Carbon::parse($attributes['end_year'])->format('Y');
        }
        else {

            $from_year = Carbon::today()->subYears(2)->format('Y-m');

            $to_year = Carbon::today()->format('Y-m');
        }


        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $from_year)
                        ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $to_year)
                        ->get()->toArray();

        $InYear = $this->sumSystemFee($InYear, $transactions, 'year');
 

        return $InYear;

    }

    public function reportTransactionWeek($attributes,$dayWeek){


        if(isset($attributes['start_day_week']) && isset($attributes['end_day_week']))
        {
            $startDay = Carbon::parse($attributes['start_day_week'])->format('Y-m-d');

            $endDay = Carbon::parse($attributes['end_day_week'])->format('Y-m-d');
        }
        else {

            $startDay   = Carbon::today()->subDays(42)->format('Y-m-d');

            $endDay     = Carbon::today()->format('Y-m-d');
        }
      


        $transactions = $this->model->select(DB::raw('SUM(system_fee) AS total, dated'))
                                ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                                ->groupBy('dated')
                                ->where('type','1')
                                ->where('status','RECIVED')
                                ->get();                

        $transactions = Transaction::with('transactionexchange')
                        ->where('status','RECIVED')
                        ->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                        ->get()->toArray();                       


        foreach ($dayWeek as $key => $date) {

            $count=0;
            if(count($transactions)) {
                foreach ($transactions as $k_v => $value) {
                    
                    $day = Carbon::parse($value['dated'])->format('Y-m-d');

                    if($date['startOfWeek'] <= $day && $day <= $date['endOfWeek']) {

                        $system_fee = $value['system_fee'];

                        $exchange_rate_to_dollar =  $value['transactionexchange']['exchange_rate_to_dollar'];

                        $count = $count + $system_fee *  $exchange_rate_to_dollar;  
                    } 
                    else {
                        $dayWeek[$key]['total'] = 0;
                       
                    }
                }

                $dayWeek[$key]['total'] = round($count,3);
            }  else {
                $dayWeek[$key]['total'] = 0;
            }

           
       
        }    
    

        return $dayWeek;
    }

    /**
    
        TODO:
        - Get Lists Histories Transaction
    
     */
    
    public function getHistoriesTransaction($params){
        $results = $this->scopeQuery(function($query) use($params){

            $query = $query->with(['user' => function($q) {
                                $q->with('package')->with('company');
                            }])
                        ->with('currency')
                        ->with('transactionexchange');
          
            if (!empty($params['defaultDay'])) {

                $startDay   = Carbon::today()->subDays(7)->format('Y-m-d');
                $endDay     = Carbon::today()->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if(!empty($params['start_day']) && !empty($params['end_day']) ){

                $startDay = Carbon::parse($params['start_day'])->format('Y-m-d');
                $endDay = Carbon::parse($params['end_day'])->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if (!empty($params['defaultWeek'])) {

                $startDay = Carbon::today()->subDays(42)->format('Y-m-d');
                $endDay = Carbon::today()->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if(!empty($params['start_day_week']) && !empty($params['end_day_week']) ){

                $startDay = Carbon::parse($params['start_day_week'])->format('Y-m-d');
                $endDay = Carbon::parse($params['end_day_week'])->format('Y-m-d');

                $query = $query->whereBetween(DB::raw('date(dated)'), [$startDay,$endDay]);
            }

            if (!empty($params['defaultMonth'])) {

                $fromMonth = Carbon::today()->subMonth(12)->format('Y-m');
                $toMonth = Carbon::today()->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth);
            }

            if(!empty($params['start_month']) && !empty($params['end_month'])){

                $fromMonth = Carbon::parse($params['start_month'])->format('Y-m');
                $toMonth = Carbon::parse($params['end_month'])->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $fromMonth)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $toMonth);
            }

            if (!empty($params['defaultYear'])) {

                $from_year = Carbon::today()->subYears(2)->format('Y-m');
                $to_year = Carbon::today()->format('Y-m');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '>=', $from_year)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y')"), '<=', $to_year);
            }

            if(!empty($params['start_year']) && !empty($params['end_year']) ){

                $from_year = Carbon::parse($params['start_year'])->format('Y');
                $to_year = Carbon::parse($params['end_year'])->format('Y');

                $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '>=', $from_year)
                                ->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), '<=', $to_year);
            }

            return $query;
        })->all();

        $results = $this->transform($results);

        return $results; 
    }  

    /**
     * Transfrom transaction data
     */
    
    public function transform($results){

        foreach ($results as $key => $result) {

            $results[$key]->company_name = $result->user->company->name;
            $results[$key]->amount_with_symbol = $result->amount ." ".$result->symbol;             
            $results[$key]->system_fee_with_symbol = $result->system_fee ." ".$result->symbol;         
            $results[$key]->credit_card_fee_with_symbol = $result->credit_card_fee ." ".$result->symbol;

            $results[$key]->amount_with_symbol = round(($result->amount * $result->transactionexchange->exchange_rate_to_dollar),3)." ".$result->symbol; 

            $results[$key]->system_fee_with_symbol = round(($result->system_fee * $result->transactionexchange->exchange_rate_to_dollar),3)." ".$result->symbol;         
            $results[$key]->credit_card_fee_with_symbol = round(($result->credit_card_fee * $result->transactionexchange->exchange_rate_to_dollar),3) ." ".$result->symbol;

            $results[$key]->fullname = $result->user->first_name . " " . $result->user->last_name;
                    
        }

        return $results;
    } 


    /*
    *  Target  : Function get all data in table transactions history by Day and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryDay($attributes,$perPage,$searchBy) {

        $now     = \Carbon\Carbon::today()->format('Y-m-d');
        $user_id = $attributes['userId'];
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $now){

            $query = $query->select('id','title','dated','amount','type','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {
                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw('date(dated)'),$now)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage);                            

    }

    /*
    *  Target  : Function get all data in table transactions history by week and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryWeek($attributes,$perPage ,$searchBy) {

        $startDay   = \Carbon\Carbon::today()->subDays(7)->format('Y-m-d');
        $endDay     = \Carbon\Carbon::today()->format('Y-m-d');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $startDay, $endDay){

            $query = $query->select('id','title','dated','amount','type','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {

                $query = $query->where(function($query) use ($search){
                                        $query->where('title','LIKE', '%'. $search . '%')
                                            ->orWhere('dated','LIKE', '%'. $search . '%');
                                    });
            }


            $query = $query->whereBetween(DB::raw('date(dated)'),[$startDay,$endDay])
                                    ->orderBy('dated', 'desc');

            return $query;

        });
        
        return $transactions->paginate($perPage);                            

    }


    /*
    *  Target  : Function get all data in table transactions history by Month and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryMonth($attributes,$perPage, $searchBy) {

        $month = \Carbon\Carbon::today()->format('Y-m');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }
      
        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $month){

            $query = $query->select('id','title','dated','amount','type','status')
                            ->with(['transactionexchange' => function($query){
                                $query->select(['exchange_rate_to_dollar','transaction_id']);
                            }])
                            ->whereHas('companyUser', function($query) use ($user_id){
                                $query->where('owner_id',$user_id);
                            });
            
            if(!empty($search)){

                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y-%m')"), $month)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage); 

    }


    /*
    *  Target  : Function get all data in table transactions history by Year and, user_id
    *  @params : array $attribute, int $perPage, array $serchBy
    *  @return : Collection
    */
    public function transactionHistoryYear($attributes,$perPage, $searchBy) {

        $year = \Carbon\Carbon::today()->format('Y');
        $user_id = $attributes['userId'];
        
        $search = '';

        if (!empty($searchBy['title'])) {
            $search = $searchBy['title'];
        }

        $transactions = $this->scopeQuery(function($query) use($search, $user_id, $year){

            $query = $query->select('id','title','dated','amount','type','status')
                                ->with(['transactionexchange' => function($query){
                                    $query->select(['exchange_rate_to_dollar','transaction_id']);
                                }])
                                ->whereHas('companyUser', function($query) use ($user_id){
                                    $query->where('owner_id',$user_id);
                                });

            if (!empty($search)) {
                $query = $query->where(function($query) use ($search){
                                    $query->where('title','LIKE', '%'. $search . '%')
                                        ->orWhere('dated','LIKE', '%'. $search . '%');
                                });
            }


            $query = $query->where(DB::raw("DATE_FORMAT(dated,'%Y')"), $year)
                                    ->orderBy('dated', 'desc');

            return $query;

        });

        return $transactions->paginate($perPage); 

    }

    /*
    *  Target : Get all data in transaction history in array with key by "Day", "Week", "Month", "Year"
    *  From : func: transactionHistoryDay, func:transactionHistoryWeek, func:transactionHistoryMonth, func:transactionHistoryYear
    *  To : array $attributes, int $prerPage, array $searchBy
    */ 
    public function transactionHistory($attributes, $perPage, $searchBy){

        switch ($attributes['time']) {
            case 'Day':
                $result = $this->transactionHistoryDay($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Week':
                $result = $this->transactionHistoryWeek($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Month':
                $result = $this->transactionHistoryMonth($attributes,$perPage, $searchBy);
                return $result;
                break;

            case 'Year':
                $result = $this->transactionHistoryYear($attributes,$perPage, $searchBy);
                return $result;
                break;
            
            default:
                # code...
                break;
        }
    }

    public function checkValueTime($request)
    {
        if($request['toTime'] != null && $request['toTime'] != null) {

        }
    }

    public function sumSystemFee($dates, $transactions, $timevalue){

        foreach ($dates as $key => $date) {
            $count=0;
            if(count($transactions)){
                foreach ($transactions as $k_v => $value) {

                        if($timevalue == 'day'){

                            $time_value = Carbon::parse($value['dated'])->format('Y-m-d');
                        }
                        if($timevalue == 'month'){
                            $time_value = Carbon::parse($value['dated'])->format('Y-m');
                        }
                        if($timevalue == 'year'){
                            $time_value = Carbon::parse($value['dated'])->format('Y');
                        }                    
                    
                    if($key == $time_value) {

                        $system_fee = $value['system_fee'];

                        $exchange_rate_to_dollar =  $value['transactionexchange']['exchange_rate_to_dollar'];

                        $count = $count + $system_fee *  $exchange_rate_to_dollar;
                                     

                    } else {
                        $dates[$key]['total'] = 0;
                    }
                }  
                 $dates[$key]['total'] = round($count,3);
                    
            } else {
                 $dates[$key]['total'] = 0;
            }           
        }
        return $dates;
    }

}
