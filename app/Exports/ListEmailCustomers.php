<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Customer;
use App\Models\Company;
use DB;
use Illuminate\Support\collection;

class ListEmailCustomers implements FromCollection, WithHeadings
{
	protected $input;

	public function __construct($input=null) 
	{
		$this->input = $input;

	}

	public function collection()
	{
		$input = $this->input;

        $data = [];
        
        if($input && $input != '') {
            $customers = Customer::with('user')->with(['branch' => function($q) use ($input) {
                                     $q->whereCompanyId($input);
            }])->get();

            $n = 1;
            foreach($customers as $customer) 
            {
                if($customer['branch'] != null)
                {
                    $data[] = ['number' => $n, 'name' => $customer['name'],  'email' => $customer['user']['email']];
                    $n++;
                }
            }

        }

        $data = collection::make($data);

        return $data;
	}

	public function headings(): array
    {
        return [
            'Number',
            'Name',
            'Email'  
        ];
    } 
}

