<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;

class UpgradeController extends Controller
{
    public function create()
    {
        if( auth()->check() ){
            return view('upgrade');
        }else{
            return redirect()->to('/');
        }

    }
    
	public function update()
	{
		$fault_msg = "";
		$country = session('country_name');
		$c_id = DB::table('S01_countries')->where([
			['country_name', '=', $country],
		])->get();
		$country_id = $c_id[0]->country_id;
		$uid = auth()->user()->id;
		$materials = DB::table('S01_materials')->where([
			['user_id', '=', $uid],
		])->get();
		if(isset($_POST['agriculture_level'])){
			switch ($_POST['agriculture_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'agriculture'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['agriculture_level' => 1]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$food_production = ($productions[0]->food_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['food_production' => $food_production]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'agriculture'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['agriculture_level' => 2]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$food_production = ($productions[0]->food_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['food_production' => $food_production]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'agriculture'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['agriculture_level' => 3]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$food_production = ($productions[0]->food_production + 4);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['food_production' => $food_production]);
				}
				break;
			}
		}elseif(isset($_POST['oil_industry_level'])){
			switch ($_POST['oil_industry_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'oil_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['oil_industry_level' => 1]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$oil_production = ($productions[0]->oil_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['oil_production' => $oil_production]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'oil_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['oil_industry_level' => 2]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$oil_production = ($productions[0]->oil_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['oil_production' => $oil_production]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'oil_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['oil_industry_level' => 3]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$oil_production = ($productions[0]->oil_production + 4);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['oil_production' => $oil_production]);
				}
				break;
			}
		}elseif(isset($_POST['metal_industry_level'])){
		switch ($_POST['metal_industry_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'metal_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['metal_industry_level' => 1]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$metal_production = ($productions[0]->metal_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['metal_production' => $metal_production]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'metal_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['metal_industry_level' => 2]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$metal_production = ($productions[0]->metal_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['metal_production' => $metal_production]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'metal_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['metal_industry_level' => 3]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$metal_production = ($productions[0]->metal_production + 4);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['metal_production' => $metal_production]);
				}
				break;
			}
		}elseif(isset($_POST['timber_industry_level'])){
		switch ($_POST['timber_industry_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'timber_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['timber_industry_level' => 1]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$wood_production = ($productions[0]->wood_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['wood_production' => $wood_production]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'timber_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['timber_industry_level' => 2]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$wood_production = ($productions[0]->wood_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['wood_production' => $wood_production]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'timber_industry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['timber_industry_level' => 3]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$wood_production = ($productions[0]->wood_production + 4);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['wood_production' => $wood_production]);
				}
				break;
			}
		}elseif(isset($_POST['quarry_level'])){
		switch ($_POST['quarry_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'quarry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['quarry_level' => 1]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$stone_production = ($productions[0]->stone_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['stone_production' => $stone_production]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'quarry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['quarry_level' => 2]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$stone_production = ($productions[0]->stone_production + 3);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['stone_production' => $stone_production]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'quarry'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['quarry_level' => 3]);
					$productions = DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->get();
					$stone_production = ($productions[0]->stone_production + 4);
					DB::table('S01_countries_productions')->where([
						['country_id', '=', $country_id],
					])->update(['stone_production' => $stone_production]);
				}
				break;
			}
		}elseif(isset($_POST['barrack_level'])){
		switch ($_POST['barrack_level']) {
			case 0:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'barrack'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['barrack_level' => 1]);
					$max_population_array = DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->get();
					$max_population = ($max_population_array[0]->max_population +500);
					DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->update(['max_population' => $max_population]);
				}
				break;
			case 1:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'barrack'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['barrack_level' => 2]);
					$max_population_array = DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->get();
					$max_population = ($max_population_array[0]->max_population +500);
					DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->update(['max_population' => $max_population]);
				}
				break;
			case 2:
				$update_costs = DB::table('S01_update_costs')->where([
					['item', '=', 'barrack'],
				])->get();
				$db_food_after = ($materials[0]->food - $update_costs[0]->food_cost);
				$db_wood_after = ($materials[0]->wood - $update_costs[0]->wood_cost);
				$db_oil_after = ($materials[0]->oil - $update_costs[0]->oil_cost);
				$db_metal_after = ($materials[0]->metal - $update_costs[0]->metal_cost);
				$db_stone_after = ($materials[0]->stone - $update_costs[0]->stone_cost);
				if(( $db_food_after < 0) || ( $db_wood_after < 0) || ( $db_oil_after < 0) || ( $db_metal_after < 0) || ( $db_stone_after < 0)){
					$fault_msg = "materials";
				}else{
					DB::table('S01_materials')->where([
						['user_id', '=', $uid],
					])->update(['food' => $db_food_after, 'wood' => $db_wood_after, 'oil' => $db_oil_after, 'metal' => $db_metal_after, 'stone' => $db_stone_after]);
					DB::table('S01_update_levels')->where([
						['country_id', '=', $country_id],
					])->update(['barrack_level' => 3]);
					$max_population_array = DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->get();
					$max_population = ($max_population_array[0]->max_population +1000);
					DB::table('S01_populations')->where([
						['country_id', '=', $country_id],
					])->update(['max_population' => $max_population]);
				}
				break;
			}
		}
		return $fault_msg;
	}
}
