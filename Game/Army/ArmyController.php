<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;

class ArmyController extends Controller
{
    public function create()
    {
        if( auth()->check() ){
            return view('army');
        }else{
            return redirect()->to('/');
        }

    }
    
	public function update()
	{
		if(isset($_POST['soldier']) && isset($_POST['tank']) && isset($_POST['fighter']) && isset($_POST['airdef'])){
			$fault_msg = "";
			$country_name = session('country_name');
			$country_id = DB::table('S01_countries')->where([
				['country_name', '=', $country_name],
			])->get();
			$country_population = DB::table('S01_populations')->where([
				['country_id', '=', $country_id[0]->country_id],
			])->get();
			$soldier = $_POST['soldier'];
			$tank = $_POST['tank'];
			$fighter = $_POST['fighter'];
			$airdef = $_POST['airdef'];
			$population_update = $country_population[0]->current_population + $soldier + $tank + $fighter + $airdef;
			if($population_update > $country_population[0]->max_population){
				$fault_msg = "population";
			}else{
				$cost_soldier = DB::table('S01_costs')->where([
					['item', '=', 'soldier'],
				])->get();
				$cost_tank = DB::table('S01_costs')->where([
					['item', '=', 'tank'],
				])->get();
				$cost_fighter =  DB::table('S01_costs')->where([
					['item', '=', 'fighter'],
				])->get();
				$cost_airdef = DB::table('S01_costs')->where([
					['item', '=', 'airdef'],
				])->get();
				$amount_food = (($cost_soldier[0]->food) * $soldier) + (($cost_tank[0]->food) * $tank) + (($cost_fighter[0]->food) * $fighter) + (($cost_airdef[0]->food) * $airdef);
				$amount_wood = (($cost_soldier[0]->wood) * $soldier) + (($cost_tank[0]->wood) * $tank) + (($cost_fighter[0]->wood) * $fighter) + (($cost_airdef[0]->wood) * $airdef);
				$amount_oil = (($cost_soldier[0]->oil) * $soldier) + (($cost_tank[0]->oil) * $tank) + (($cost_fighter[0]->oil) * $fighter) + (($cost_airdef[0]->oil) * $airdef);
				$amount_metal = (($cost_soldier[0]->metal) * $soldier) + (($cost_tank[0]->metal) * $tank) + (($cost_fighter[0]->metal) * $fighter) + (($cost_airdef[0]->metal) * $airdef);
				$amount_stone = (($cost_soldier[0]->stone) * $soldier) + (($cost_tank[0]->stone) * $tank) + (($cost_fighter[0]->stone) * $fighter) + (($cost_airdef[0]->stone) * $airdef);
				$uid = auth()->user()->id;
				$materials = DB::table('S01_materials')->where([
					['user_id', '=', $uid],
				])->get();
				$db_food_after = ($materials[0]->food - $amount_food);
				$db_wood_after = ($materials[0]->wood - $amount_wood);
				$db_oil_after = ($materials[0]->oil - $amount_oil);
				$db_metal_after = ($materials[0]->metal - $amount_metal);
				$db_stone_after = ($materials[0]->stone - $amount_stone);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_populations')->where([
						['country_id', '=', $country_id[0]->country_id],
					])->update(['current_population' => $population_update]);
					$army = DB::table('S01_militaries')->where([
						['country_id', '=', $country_id[0]->country_id],
					])->get();
					$db_soldier_after = ($soldier + $army[0]->soldier);
					$db_tank_after = ($tank + $army[0]->tank);
					$db_fighter_after = ($fighter + $army[0]->fighter);
					$db_airdef_after = ($airdef + $army[0]->airdef);
					DB::table('S01_militaries')->where([
						['country_id', '=', $country_id[0]->country_id],
					])->update(['soldier' => $db_soldier_after, 'tank' => $db_tank_after, 'fighter' => $db_fighter_after, 'airdef' => $db_airdef_after]);
					$fault_msg = "success";
				}
			}
			$army_count = $soldier + $tank + $fighter + $airdef;
			if($army_count == 0){
				$fault_msg = "";
			}
			return $fault_msg;
		}
	}
}
