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

        $results = DB::table('companies as c')
                    ->join('users as u', 'u.id', '=', 'c.owner_id')
                    ->join('packages as p', 'p.id', '=', 'u.package_id');

        if($this->input['keywords'] != null){
            $results = $results->where('name', 'like', '%'.$this->input['keywords'].'%')
                                ->orwhere('email', 'like', '%'.$this->input['keywords'].'%')
                                ->orWhereRaw("concat(first_name, ' ', last_name) like '%{$this->input['keywords']}%' ");
        }

        elseif($this->input['filterPackage'] != null){
            if($this->input['filterPackage'] != "All"){
                $results = $results->where('p.package_name','=', $this->input['filterPackage']);
            }
        }
        

        $results = $results->select('c.id as id', 'c.name', 'u.email' ,'u.first_name', 'u.last_name',  'p.package_name',  'c.address', 'c.description', 'c.logo')
                            ->get();

        $results = $this->transform($results);

        return $results;
    }

    public function headings(): array
    {
        return [
            '#',
            'Company Name',
            'Fullname',
            'Email',
            'Package Name',
            'Address',
            'Description',
            'Logo'
            
        ];
    } 

    /**
    
       TODO:
        - create new_field from old_filed
       
     */
    
    public function transform($results){

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
        		'logo' => $result->logo,
        	]);            
        }
   	
        return $results2;
    } 

    

}
