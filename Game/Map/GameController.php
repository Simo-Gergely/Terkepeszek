<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;

class GameController extends Controller
{
    public function create()
    {
        if( auth()->check() ){
            return view('game');
        }else{
            return redirect()->to('/');
        }

    }
	public function pvp()
    {
		if(isset($_POST['country_attack']) && isset($_POST['country_deff'])){
			$country_id_attack = DB::table('S01_countries')->where([
				['country_name', '=', $_POST['country_attack']],
			])->get();
			$attack_army = DB::table('S01_militaries')->where([
				['country_id', '=', $country_id_attack[0]->country_id],
			])->get();
			$soldier_attack = $attack_army[0]->soldier;
			$tank_attack = $attack_army[0]->tank;
			$fighter_attack = $attack_army[0]->fighter;
			$airdef_attack = $attack_army[0]->airdef;
			$attack_sum = $soldier_attack + $tank_attack + $fighter_attack + $airdef_attack;
			if($attack_sum < 10000){
				return "Minimum 10000 egységgel kell támadnod!";
			}
			$country_deff_owner = DB::table('S01_countries')->where([
				['country_name', '=', $_POST['country_deff']],
			])->get();
			$attack_points = ($soldier_attack * 3) + ($tank_attack * 5) + ($fighter_attack * 4) + ($airdef_attack * 2);
			if($country_deff_owner[0]->country_owner_id == null){
				$deff_points = 45000;
			}else{
				$deff_army = DB::table('S01_militaries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->get();
				$soldier_deff = $deff_army[0]->soldier;
				$tank_deff = $deff_army[0]->tank;
				$fighter_deff = $deff_army[0]->fighter;
				$airdef_deff = $deff_army[0]->airdef;
				$deff_points = ($soldier_deff * 2) + ($tank_deff * 4) + ($fighter_deff * 6) + ($airdef_deff * 5);
			}
			$result = $attack_points - $deff_points;
			if($result <= 0){
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['soldier' => 0, 'tank' => 0, 'fighter' => 0, 'airdef' => 0]);
				DB::table('S01_populations')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['current_population' => 0]);
				$deff_army = DB::table('S01_militaries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->get();
				$soldier_deff = $deff_army[0]->soldier;
				$tank_deff = $deff_army[0]->tank;
				$fighter_deff = $deff_army[0]->fighter;
				$airdef_deff = $deff_army[0]->airdef;
				$soldier_deff_back = intval($soldier_deff * 0.8);
				$tank_deff_back = intval($tank_deff * 0.8);
				$fighter_deff_back = intval($fighter_deff * 0.8);
				$airdef_deff_back = intval($airdef_deff * 0.8);
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['soldier' => $soldier_deff_back, 'tank' => $tank_deff_back, 'fighter' => $fighter_deff_back, 'airdef' => $airdef_deff_back]);
				return "Vesztettél!";
			}else if(($result > 0) && ($result < 20000)){
				$soldier_attack_back = intval($soldier_attack * 0.2);
				$tank_attack_back = intval($tank_attack * 0.2);
				$fighter_attack_back = intval($fighter_attack * 0.2);
				$airdef_attack_back = intval($airdef_attack * 0.2);
				$military_back = $soldier_attack_back + $tank_attack_back + $fighter_attack_back + $airdef_attack_back;
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['soldier' => $soldier_attack_back, 'tank' => $tank_attack_back, 'fighter' => $fighter_attack_back, 'airdef' => $airdef_attack_back]);
				DB::table('S01_populations')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['current_population' => $military_back]);
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['soldier' => 0, 'tank' => 0, 'fighter' => 0, 'airdef' => 0]);
				DB::table('S01_populations')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['current_population' => 0]);
				return "Győzelem!";
			}else{
				$soldier_attack_back = intval($soldier_attack * 0.6);
				$tank_attack_back = intval($tank_attack * 0.6);
				$fighter_attack_back = intval($fighter_attack * 0.6);
				$airdef_attack_back = intval($airdef_attack * 0.6);
				$military_back = $soldier_attack_back + $tank_attack_back + $fighter_attack_back + $airdef_attack_back;
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['soldier' => $soldier_attack_back, 'tank' => $tank_attack_back, 'fighter' => $fighter_attack_back, 'airdef' => $airdef_attack_back]);
				DB::table('S01_populations')->where([
					['country_id', '=', $country_id_attack[0]->country_id],
				])->update(['current_population' => $military_back]);
				$counter = DB::table('S01_countries')->where([
					['country_owner_id', '=', $country_deff_owner[0]->country_owner_id],
				])->count();
				if($counter == 1){
					DB::table('S01_players')->where([
						['user_id', '=', $country_deff_owner[0]->country_owner_id],
					])->update(['game_status' => 'Lost']);
				}
				DB::table('S01_militaries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['soldier' => 0, 'tank' => 0, 'fighter' => 0, 'airdef' => 0]);
				DB::table('S01_populations')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['current_population' => 0]);
				DB::table('S01_countries')->where([
					['country_id', '=', $country_deff_owner[0]->country_id],
				])->update(['country_owner_id' => $country_id_attack[0]->country_owner_id]);
				$win_counter = DB::table('S01_countries')->where([
					['country_owner_id', '=', $country_id_attack[0]->country_owner_id],
				])->count();
				if($win_counter > 16){
					DB::table('servers')->where([
						['server_name', '=', 'S01'],
					])->update(['server_status' => 'End']);
				}
				return "Győzelem és elfoglaltad az országot!";
			}
		}
	}
}
		/*
			katona: 3dmg 2deff
			tank: 5dmg 4deff
			repulo: 4dmg 6deff
			legvedelem: 2dmg 5deff
		*/