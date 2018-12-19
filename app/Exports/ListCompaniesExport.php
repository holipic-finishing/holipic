<?php

namespace App\Exports;

use DB;
use App\Models\Company;
use App\Models\User;
use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ListCompaniesExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($input)
    {
        $this->input = $input;

    }
    public function collection()
    {
        $input = $this->input;
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

    public function headings(): array
    {
        return [
            'ID',
            'Company Name',
            'Fullname',
            'Email',
            'Package Name',
            'Address',
            'Description',
            'Total File Size',
            'Total Income Fee',
            'Total Income',
            'Logo'
            
        ];
    } 

    /**
    
       TODO:
        - create new_field from old_filed
       
     */
    
    public function transform($results){
        $results = $this->total($results);

    	$results2 = collect();
        foreach ($results as $key => $result) {
        	$results2->push([
        		'id' => $result->id,
        		'name' => $result->name,
        		'full_name' => $result->first_name . ' ' . $result->last_name,
        		'email' => $result->email,
        		'package_name' => $result->package_name,
        		'address' => $result->address,
        		'description' => $result->description,
                'total file size'=> $result->total_file_size,
                'total income fee'=> $result->total_income_fee,
                'total income'=> $result->total_income,
        		'logo' => $result->logo,
        	]);            
        }
   	
        return $results2;
    } 

    public function total($input){
        $listID = [];

        foreach ($input as $key => $value) {
            array_push($listID, $value->id);
        }


        $results = Company::with(['files','user.package','transactions'])->whereIn('id',$listID)->get(); 

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

}
