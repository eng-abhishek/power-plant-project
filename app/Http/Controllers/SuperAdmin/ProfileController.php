<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Backend\UpdateProfileRequest;
use App\Http\Requests\Backend\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * view profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewProfile()
    {
        $user = \Auth::guard('superadmin')->user();

        $record = User::find($user->id);

        return view('superadmin.account.profile', ['record' => $record]);
    }

    /**
     * view change password.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewChangePassword()
    {
        return view('superadmin.account.change-password');
    }

        /**
     * Save change password.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveChangePassword(ChangePasswordRequest $request)
    {
        try{
            
            $user = \Auth::guard('superadmin')->user();

            User::where('id', $user->id)->update(['password' => Hash::make($request->get('password'))]);

            \Auth::guard('superadmin')->logoutOtherDevices($request->get('password'));
            
            return redirect()->route('superadmin.account.change-password.view')->with(['status' => 'success', 'message' => 'Password has changed successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('superadmin.account.change-password.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            \DB::beginTransaction();

            $user = \Auth::guard('superadmin')->user();

            $user->name = $request->get('name');

            $user->save();

            \DB::commit();

            return redirect()->route('superadmin.account.profile.view')->with(['status' => 'success', 'message' => 'Profile updated successfully.']);

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->route('superadmin.account.profile.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
?>