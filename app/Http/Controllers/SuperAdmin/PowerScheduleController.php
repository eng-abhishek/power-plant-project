<?php

namespace App\Http\Controllers\Superadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\PowerPlant;
use App\Models\BlockNumber;
use App\User;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Requests\Backend\PowerScheduleRequest;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlantScheduleExport;

class PowerScheduleController extends Controller
{

	public function index(Request $request){

		if($request->ajax()){

			$row = Schedule::with('users','plants')->OrderBy('id','desc')->latest();

			return DataTables::of($row)

			->addIndexColumn()

			->addColumn('username',function($row){
				return $row->users->name;
			})

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

				$btn .= '<a href="'.route("superadmin.schedule.edit", $row->id).'" class="edit-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>';

				$btn .= '<a href="javascript:;" data-url="'.route('superadmin.schedule.destroy', $row->id).'" class="delete-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
				return $btn;
			})

			->rawColumns(['created_at','action','is_active','username','plantname','scheduled_power','date',''])
			->make(true);
		}
		return view('backend.power_schdule.index');
	}

	public function create(Request $request){

		$data['users'] = User::where('is_admin','N')->get();
		$data['plants'] = PowerPlant::all();

		return view('backend.power_schdule.create',$data);
	}

	public function store(PowerScheduleRequest $request)
	{
		try {

			Schedule::create([
				'user_id' => $request->user_id,
				'plant_id' => $request->plant_id,
				'date' => $request->date,
				'scheduled_power' => $request->scheduled_power,
			]);
			return redirect()->route('superadmin.schedule.index')->with(['status' => 'success', 'message' => 'Schedule created successfully.']);

		} catch (\Exception $e) {
			return redirect()->route('superadmin.schedule.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function edit($id)
	{
		$data['record'] = Schedule::find($id);
		$data['users'] = User::where('is_admin','N')->get();
		$data['plants'] = PowerPlant::all();

		return view('backend.power_schdule.edit', $data);

	}

	public function update(PowerScheduleRequest $request,$id)
	{
		try {

			$record = array(
			    'user_id' => $request->user_id,
				'plant_id' => $request->plant_id,
				'date' => $request->date,
				'scheduled_power' => $request->scheduled_power,
			);

			Schedule::where('id',$id)->update($record);

			return redirect()->route('superadmin.schedule.index')->with(['status' => 'success', 'message' => 'Schedule created successfully.']);

		} catch (\Exception $e) {
			return redirect()->route('superadmin.schedule.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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

    public function showGraph(){
     return view('backend.power_schdule.showgraph');
    }
    
    public function getGraphData(){
      
        $data = BlockNumber::whereHas('schedules',function($q){
        	$q->where('id',1);
        })->get();
        
        $arr = [];

        foreach ($data as $key => $value) {
        
        $arr['power'][] = (int)$value->schedules->scheduled_power;
        $arr['block'][] = (int)$value->block_number;

        }

       return json_encode($arr);
    }

}
?>