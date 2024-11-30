<?php

namespace App\Http\Controllers\Superadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\PowerPlant;
use DataTables;
use App\User;
use Illuminate\Support\Str;
use App\Http\Requests\Backend\PowerPlantRequest;
use Carbon\Carbon;

class PowerPlantController extends Controller
{

	public function index(Request $request){
        
		if($request->ajax()){

			$row = PowerPlant::OrderBy('id','desc')->latest()->get();

			return DataTables::of($row)

			->addIndexColumn()

			->addColumn('username',function($row){
				return $row->users->name;
			})

			->addColumn('capacity',function($row){
				return $row->capacity." MW";
			})

			->addColumn('created_at',function($row){
				return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
			})

			->addColumn('is_active', function($row){
				if($row->is_active == 'Y'){
					return '<span class="btn btn-outline-success m-btn m-btn--custom change-status" data-value="Y" data-url="'.route('superadmin.powerplant.change-status', $row->id).'">Avtive</span>';
				}else{
					return '<span class="btn btn-outline-warning m-btn m-btn--custom change-status" data-value="N" data-url="'.route('superadmin.powerplant.change-status', $row->id).'">InActive</span>';
				}
			})

			->addColumn('action', function($row){

				$btn = '';

				$btn .= '<a href="'.route("superadmin.powerplant.edit", $row->id).'" class="edit-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>';

				$btn .= '<a href="javascript:;" data-url="'.route('superadmin.powerplant.destroy', $row->id).'" class="delete-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
				return $btn;
			})

			->rawColumns(['created_at','action','is_active','username','capacity'])
			->make(true);
		}
		return view('backend.power_plant.index');
	}

	public function create(Request $request){
         
		$data['users'] = User::where('is_admin','N')->get();
		return view('backend.power_plant.create',$data);
	}

	public function store(PowerPlantRequest $request)
	{
		try {

			PowerPlant::create([
				'user_id' => $request->user_id,
				'name' => $request->name,
				'category' => $request->category,
				'technology' => $request->technology,
				'capacity' => $request->capacity,
			]);
			return redirect()->route('superadmin.powerplant.index')->with(['status' => 'success', 'message' => 'Credit Faq created successfully.']);

		} catch (\Exception $e) {
			return redirect()->route('superadmin.powerplant.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function edit($id)
	{

		$data['record'] = PowerPlant::find($id);
		$data['users'] = User::where('is_admin','N')->get();
		return view('backend.faq.article.edit', $data);

	}

	public function update(PowerPlantRequest $request,$id)
	{
		try {

			$record = array(
				'user_id' => $request->user_id,
				'name' => $request->name,
				'category' => $request->category,
				'technology' => $request->technology,
				'capacity' => $request->capacity,
			);

			PowerPlant::where('id',$id)->update($record);

			return redirect()->route('superadmin.powerplant.index')->with(['status' => 'success', 'message' => 'Credit Faq created successfully.']);

		} catch (\Exception $e) {
			return redirect()->route('superadmin.powerplant.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function destroy($id)
	{
		try{
			PowerPlant::find($id)->delete();
			return response()->json(['status' => 'success', 'message' => 'Power Plant deleted successfully.']);
		}catch(\Exception $e){
			return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function changeStatus($id){
        
		try{
            
			$record = PowerPlant::find($id);

			if($record->is_active == 'N'){
				$record->is_active = 'Y';
				$message = 'Power Plant activated successfully.';
			}else{
				$record->is_active = 'N';
				$message = 'Power Plant deactivated successfully.';
			}

			$record->save();

			return response()->json(['status' => 'success', 'message' => $message]);
		}catch(\Exception $e){
			return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

}
?>