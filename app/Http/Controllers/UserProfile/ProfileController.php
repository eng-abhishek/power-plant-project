<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Frontend\Auth\ChangePasswordRequest;
use App\Http\Requests\Frontend\Auth\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;
//use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * view profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct() {
        $this->middleware(['auth','verified']);
    }
 
    public function viewProfile()
    {
        $user = \Auth::user();
        $record = User::find($user->id);
        return view('account.profile', ['record' => $record]);
    }
 
}
