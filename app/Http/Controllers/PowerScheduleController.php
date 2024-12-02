<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\PowerPlant;
use App\Models\BlockNumber;
use App\User;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Requests\Frontend\PowerScheduleRequest;
use Carbon\Carbon;
use Auth;
use App\Jobs\SendSchduledNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlantScheduleExport;

class PowerScheduleController extends Controller
{

	public function index(Request $request){

		if($request->ajax()){

			$row = Schedule::with('users','plants')->OrderBy('id','desc')->where('user_id',Auth::user()->id)->latest();

			return DataTables::of($row)

			->addIndexColumn()

			->addColumn('plantname',function($row){
				return $row->plants->name;
			})

			->addColumn('scheduled_power',function($row){
				return $row->scheduled_power." MW";
			})

			->addColumn('date',function($row){
				return Carbon::parse($row->date)->format('d-m-Y');
			})

			->addColumn('created_at',function($row){
				return Carbon::parse($row->created_at)->format('d-m-Y h:i A');
			})

			->addColumn('action', function($row){

				$btn = '';

				$btn .= '<a href="'.route("schedule.edit", $row->id).'" class="edit-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>';

				$btn .= '<a href="javascript:;" data-url="'.route('schedule.destroy', $row->id).'" class="delete-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
				return $btn;
			})

			->rawColumns(['created_at','action','is_active','plantname','scheduled_power','date'])
			->make(true);
		}
		return view('power_schdule.index');
	}

	public function create(Request $request){

		$data['plants'] = PowerPlant::all();

		return view('power_schdule.create',$data);
	}

	public function store(PowerScheduleRequest $request)
	{
		try {

			$insert = Schedule::create([
				'user_id' => Auth::user()->id,
				'plant_id' => $request->plant_id,
				'date' => $request->date,
				'scheduled_power' => $request->scheduled_power,
			]);

			$blocks = $request->block_range;

			$block_array = [];

			for($i=1;$i<=$blocks;$i++){

				$block_array[$i]['block_number'] = $i;
				$block_array[$i]['schdule_id'] = $insert->id;
				$block_array[$i]['created_at'] = now();

			}

			/* insert block number */             
			BlockNumber::insert($block_array);


			$email = Auth::user()->email;
			$name = Auth::user()->name;

			dispatch(new SendSchduledNotification($email,$name,$request->scheduled_power));

			if($request->ajax()){

				return response()->json(['status' => 'success', 'message' => 'Schedule created successfully.']);

			}else{
				return redirect()->route('schedule.index')->with(['status' => 'success', 'message' => 'Schedule created successfully.']);
			}

		}catch (\Exception $e) {

			if($request->ajax()){

				return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

			}else{

				return redirect()->route('schedule.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
			}
		}
	}

	public function edit(Request $request,$id)
	{

		$data['record'] = Schedule::find($id);
		$data['plants'] = PowerPlant::all();

		if($request->ajax()){

			$view = view('power_schdule.ajax_edit_form', $data)->render();

			return response()->json(['status'=>'success','data'=>$view,'message'=>'']);

		}else{

			return view('power_schdule.edit', $data);

		}

	}

	public function update(PowerScheduleRequest $request,$id)
	{
		try {

			$record = array(
				'user_id' => Auth::user()->id,
				'plant_id' => $request->plant_id,
				'date' => $request->date,
				'scheduled_power' => $request->scheduled_power,
			);

			$blocks = $request->block_range;

			for($i=1;$i<=$blocks;$i++){

				$block_array[$i]['block_number'] = $i;
				$block_array[$i]['schdule_id'] = $id;
				$block_array[$i]['created_at'] = now();

			}

			/* remove previous record */
			BlockNumber::where('schdule_id',$id)->delete();


			/* insert block number */             
			BlockNumber::insert($block_array);


			Schedule::where('id',$id)->update($record);

			if($request->ajax()){

				return response()->json(['status' => 'success', 'message' => 'Schedule updated successfully.']);

			}else{

				return redirect()->route('schedule.index')->with(['status' => 'success', 'message' => 'Schedule updated successfully.']);	
			}

		} catch (\Exception $e) {

			if($request->ajax()){

				return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

			}else{

				return redirect()->route('schedule.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
			}
			
		}
	}

	public function destroy($id)
	{
		try{
			Schedule::find($id)->delete();
			return response()->json(['status' => 'success', 'message' => 'Schedule deleted successfully.']);
		}catch(\Exception $e){
			return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function getCSV()
	{
		return Excel::download(new PlantScheduleExport, 'power-scheduling-report.xlsx');
	}

	public function withAjaxSchedule(){
		$data['plants'] = PowerPlant::all();

		return view('power_schdule.create_power_schedule_with_ajax',$data);
	}


	public function ajaxListing(Request $request){

		if($request->ajax()){

			$row = Schedule::with('users','plants')->OrderBy('id','desc')->where('user_id',Auth::user()->id)->latest();

			return DataTables::of($row)

			->addIndexColumn()

			->addColumn('plantname',function($row){
				return $row->plants->name;
			})

			->addColumn('scheduled_power',function($row){
				return $row->scheduled_power." MW";
			})

			->addColumn('date',function($row){
				return Carbon::parse($row->date)->format('d-m-Y');
			})

			->addColumn('created_at',function($row){
				return Carbon::parse($row->created_at)->format('d-m-Y h:i A');
			})

			->addColumn('action', function($row){

				$btn = '';

				$btn .= '<a href="javascript:;" data-url="'.route("schedule.edit", $row->id).'" class="edit-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>';

				$btn .= '<a href="javascript:;" data-url="'.route('schedule.destroy', $row->id).'" class="delete-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
				return $btn;
			})

			->rawColumns(['created_at','action','is_active','plantname','scheduled_power','date'])
			->make(true);
		}
	}

}
?>