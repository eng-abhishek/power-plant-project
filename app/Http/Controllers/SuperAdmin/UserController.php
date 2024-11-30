<?php

namespace App\Http\Controllers\Superadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DataTables;
use Illuminate\Support\Str;
use App\Http\Requests\Backend\UserRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Events\SendUserEmail;

class UserController extends Controller
{

	public function index(Request $request){

		if($request->ajax()){

			$row = User::where('is_admin','N')->OrderBy('id','desc')->latest()->get();

			return DataTables::of($row)

			->addIndexColumn()

			->addColumn('created_at',function($row){
				return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
			})

			->addColumn('action', function($row){

				$btn = '';

				$btn .= '<a href="'.route("superadmin.user.edit", $row->id).'" class="edit-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="la la-edit"></i></a>';

				$btn .= '<a href="javascript:;" data-url="'.route('superadmin.user.destroy', $row->id).'" class="delete-record m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Delete"><i class="la la-trash"></i></a>';
				return $btn;
			})

			->rawColumns(['created_at','action'])
			->make(true);
		}
		return view('backend.user.index');
	}

	public function create(Request $request){

		$data['users'] = User::where('is_admin','N')->get();

		return view('backend.user.create');
	}

	public function store(UserRequest $request)
	{
		try {

			User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'role' => $request->role,
			]);

            event( new SendUserEmail($request->name,$request->password,$request->email));

			return redirect()->route('superadmin.user.index')->with(['status' => 'success', 'message' => 'User created successfully.']);

		}catch (\Exception $e) {
			return redirect()->route('superadmin.user.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function edit($id)
	{
		$record = User::find($id);
		return view('backend.user.edit', ['record' => $record]);
	}

	public function update(UserRequest $request,$id)
	{
		try {

			$record = array(
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'role' => $request->role,
			);

			User::where('id',$id)->update($record);

			return redirect()->route('superadmin.user.index')->with(['status' => 'success', 'message' => 'User Updated successfully.']);

		} catch (\Exception $e) {
			return redirect()->route('superadmin.user.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}

	public function destroy($id)
	{
		try{
			User::find($id)->delete();
			return response()->json(['status' => 'success', 'message' => 'User deleted successfully.']);
		}catch(\Exception $e){
			return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
		}
	}
}
?>