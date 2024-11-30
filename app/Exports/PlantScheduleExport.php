<?php

namespace App\Exports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Auth;

class PlantScheduleExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
       return $this->getData();
    }

    public function getData()
    {
    	if(Auth::user()->is_admin == 'Y'){
    	
    	$data = Schedule::with('users','plants')->get();
        
        }else{

    	$data = Schedule::where('user_id',Auth::user()->id)->with('users','plants')->get();

       }

        return $data;
    }

    public function map($getData): array
    {
        return [
            $getData->users->name,
            $getData->plants->name,
            $getData->date,
            $getData->created_at,
            $getData->updated_at,
        ];
    }

        // this is heading
    public function headings(): array
    {
        return [
            'User Name',
            'Plant Name',
            'Date',
            'Created At',
            'Updated At',
        ];
    }
}
