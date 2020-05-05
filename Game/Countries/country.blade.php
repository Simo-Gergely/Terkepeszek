<?php
$player_status = DB::table('S01_players')->where([
	['user_id', '=', auth()->user()->id],
])->get();
$server_status = DB::table('servers')->where([
	['server_name', '=', 'S01'],
])->get();
$logout = "none";
if($player_status[0]->game_status == "Lost"){
	$logout = "yes";
}
if($server_status[0]->server_status == "End"){
	$logout = "yes";
}
$country_table = DB::table('S01_countries')->where([
				['country_owner_id', '=', auth()->user()->id],
])->get();
$country_name_array = array();
$country_id_array = array();
$i=sizeof($country_table);
for($y=0; $y<$i; $y++){
	$country_name_array[$y] = $country_table[$y]->country_name;
	$country_id_array[$y] = $country_table[$y]->country_id;
}
$country_material = DB::table('S01_countries_productions')
					->whereIn('country_id', $country_id_array)
					->get();
$country_food = array();
$country_oil = array();
$country_metal = array();
$country_stone = array();
$country_wood = array();
for($y=0; $y<$i; $y++){
	$country_food[$y] = $country_material[$y]->food_production;
	$country_oil[$y] = $country_material[$y]->oil_production;
	$country_metal[$y] = $country_material[$y]->metal_production;
	$country_stone[$y] = $country_material[$y]->stone_production;
	$country_wood[$y] = $country_material[$y]->wood_production;
}
$country_military = DB::table('S01_militaries')
					->whereIn('country_id', $country_id_array)
					->get();
$country_soldier = array();
$country_tank = array();
$country_fighter = array();
$country_airdef = array();
for($y=0; $y<$i; $y++){
	$country_soldier[$y] = $country_military[$y]->soldier;
	$country_tank[$y] = $country_military[$y]->tank;
	$country_fighter[$y] = $country_military[$y]->fighter;
	$country_airdef[$y] = $country_military[$y]->airdef;
}
$country_populations = DB::table('S01_populations')
					->whereIn('country_id', $country_id_array)
					->get();
$country_population_current = array();
$country_population_max = array();
for($y=0; $y<$i; $y++){
	$country_population_current[$y] = $country_populations[$y]->current_population;
	$country_population_max[$y] = $country_populations[$y]->max_population;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
	<style>
	table {
		width: 60%;
		align: center;
	}
	td, th {
		border: 1px solid #cccccc;
		padding: 5px;
		text-align: center;
	}
	</style>
</head>
<body>
@include('layout.partials.header')
@include('layout.partials.nav')
<script>
var logout = <?php echo json_encode($logout);?>;
if(logout == "yes"){
	window.location=document.getElementById('logoutid').href;
}
	function ChooseFunction(country_name_data){
		countryname.value=country_name_data;
		document.getElementById('form-id').submit();
	}
	var sortDirection = false;
	window.onload = () => {
		loadTableData();
	}
	function loadTableData(){
		const tableBody = document.getElementById('tableData');
		var dataHtml = '';
		var country_name_array = <?php echo json_encode($country_name_array);?>;
		var country_food_array = <?php echo json_encode($country_food);?>;
		var country_oil_array = <?php echo json_encode($country_oil);?>;
		var country_metal_array = <?php echo json_encode($country_metal);?>;
		var country_wood_array = <?php echo json_encode($country_wood);?>;
		var country_stone_array = <?php echo json_encode($country_stone);?>;
		var country_soldier_array = <?php echo json_encode($country_soldier);?>;
		var country_tank_array = <?php echo json_encode($country_tank);?>;
		var country_fighter_array = <?php echo json_encode($country_fighter);?>;
		var country_airdef_array = <?php echo json_encode($country_airdef);?>;
		var country_population_current_array = <?php echo json_encode($country_population_current);?>;
		var country_population_max_array = <?php echo json_encode($country_population_max);?>;
		var y = <?php echo $i;?>;
		var i;
		for(i = 0; i < y; i++){
		dataHtml += `<tr><td onclick="ChooseFunction('${country_name_array[i]}')">${country_name_array[i]}</td><td>Élelem: ${country_food_array[i]} Olaj: ${country_oil_array[i]} Fém: ${country_metal_array[i]} Fa: ${country_wood_array[i]} Kő: ${country_stone_array[i]}</td><td>Katona: ${country_soldier_array[i]} Tank: ${country_tank_array[i]} Vadászgép: ${country_fighter_array[i]} Légvédelmi löveg: ${country_airdef_array[i]}</td><td>${country_population_current_array[i]} / ${country_population_max_array[i]}</td></tr>`;
		}
		tableBody.innerHTML = dataHtml;
	}
</script>
	<div class="bg-light main-container pb-3 pt-3">
        <div>
		<h1 style="width: 60%; margin-right: auto; margin-left: auto;">Országaim</h1>
		<p style="width: 60%; margin-right: auto; margin-left: auto;">Az Országaim menüpontban kitudod választani, hogy melyik országod szeretnéd irányítani.</p>
		<form id="form-id" method="POST" action="{{ action('LogController@countrychoose') }}" >
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
			<input id="countryname" name="countryname" type="hidden" />
			<table border=1 style="margin-right: auto; margin-left: auto;">
				<thead>
					<tr>
						<th>Országnév</th>
						<th>Termelés</th>
						<th>Egységek</th>
						<th>Hadsereg létszám</th>
					</tr>
				<thead>
				<tbody id="tableData"></tbody>
			</table>
        </form>
		</div>
	</div>
@include('layout.partials.footer')
</body>
</html>