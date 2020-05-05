<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;

class RegController extends Controller
{
	public function ajaxRequestPost(){
		if(isset($_POST['name']) && isset($_POST['email'])){
			$fault_msg="";
			$name=$_POST['name'];
			$email=$_POST['email'];
			$count_name = DB::table('users')->where([
						['username', '=', $name],
			])->count();
			if($count_name > 0){
				$fault_msg = "A felhasználónév már foglalt!";
			}else{
			$count_email = DB::table('users')->where([
						['email', '=', $email],
			])->count();
			if($count_email > 0){
				$fault_msg = "Ezzel az email címmel már regisztráltak!";
			}
			}
		}else{
			$fault_msg = "Kritikus hiba!";
		}
		return $fault_msg;
    }
}
