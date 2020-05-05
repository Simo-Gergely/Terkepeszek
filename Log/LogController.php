<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class LogController extends Controller
{
	public function countrychoose(){
		if(isset($_POST['countryname'])){
			session()->forget('country_name');
			session()->put('country_name', $_POST['countryname']);
		}
		return redirect()->to('/country');
	}
	public function ajaxRequestPost2(){
		if(isset($_POST['name']) && isset($_POST['pw'])){
			$name=$_POST['name'];
			$fault_msg="";
			$count_user_val = DB::table('users')->where([
						['username', '=', $name],
			])->count();
			if($count_user_val > 0){
				$user_val = DB::table('users')->where([
							['username', '=', $name],
				])->get();
				$hasedpw=$user_val[0]->password;
				$password = $_POST['pw'];
				if(Hash::check($password, $hasedpw) == true){
					$user_id=$user_val[0]->id;
					$count_server_player = DB::table('S01_players')->where([
							['user_id', '=', $user_id],
					])->count();
					if($user_val[0]->user_status != 'Ban'){
						if($count_server_player > 0){
							$server_player = DB::table('S01_players')->where([
								['user_id', '=', $user_id],
							])->get();
							if($server_player[0]->game_status != 'Active'){
								$fault_msg="Vesztettél a szerveren!";
							}
						}else{
							$count_server_country = DB::table('S01_countries')
								->whereNull('country_owner_id')
								->count();
							if($count_server_country > 0){
								DB::table('S01_players')->insert([
									['user_id' => $user_id],
								]);
								$server_countries = DB::table('S01_countries')
									->whereNull('country_owner_id')
									->get();
								$server_country_number = rand(0, sizeof($server_countries)-1);
								DB::table('S01_countries')->where([
									['country_id', '=', $server_countries[$server_country_number]->country_id],
								])->update(['country_owner_id' => $user_id]);
								DB::table('S01_materials')->insert([
									['user_id' => $user_id],
								]);
							}else{
								$fault_msg="A szerver megtelt!";
							}
						}
					}else{
						$fault_msg="A felhasználói fiókot véglegesen kitiltották!";
					}
				}else{
					$fault_msg="Hibás a felhasználónév vagy a jelszó!";
				}
			}else{
				$fault_msg="Hibás a felhasználónév vagy a jelszó!";
			}
		}else{
			$fault_msg="Kritikus hiba!";
		}
		return $fault_msg;
    }
}