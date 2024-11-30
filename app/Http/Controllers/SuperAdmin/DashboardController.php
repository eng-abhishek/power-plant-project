<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	 public function __construct() {
     
        }

   public function index(){
        
       return view('backend.dashboard');
       //echo"Welcome on admin dashboard...";
   }
}
?>