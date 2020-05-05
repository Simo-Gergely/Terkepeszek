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
$country_id = DB::table('S01_countries')->where([
				['country_name', '=', session('country_name')],
])->get();
$country_population_current = DB::table('S01_populations')->where([
				['country_id', '=', $country_id[0]->country_id],
])->get();
$country_military = DB::table('S01_militaries')->where([
				['country_id', '=', $country_id[0]->country_id],
])->get();
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}
		return true;
	}
	</script>
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
	#alert{
		width: 60%;
		margin-left: auto;
		margin-right: auto;
	}
	</style>
</head>
<body onload="DataLoad()">
@include('layout.partials.header')
@include('layout.partials.nav')
<div class="bg-light main-container pb-3 pt-3">
		<h1 style="width: 60%; margin-right: auto; margin-left: auto;">Hadsereg</h1>
		<p style="width: 60%; margin-right: auto; margin-left: auto;">Az Hadsereg menüpontban tudod növelni az országod katonáinak számát.</p>
		<div id="alert" class="div_alert">
			<span class="Close_btn" onclick="this.parentElement.style.display='none';">&times;</span>
			<p id="alert_msg"></p>
		</div>
		<form onsubmit="return mySubmitFunction(event)">
		{{ csrf_field() }}
		<table border=1 border=1 style="margin-right: auto; margin-left: auto;">
				<thead>
					<tr>
						<th>Egység</th>
						<th>Szükséglet</th>
						<th>Jelenlegi</th>
						<th style="width: 60px;">Kiképez</th>
					</tr>
					<tr>
						<td>Katona</td>
						<td>Élelem: <?php echo $cost_soldier[0]->food;?> Olaj: <?php echo $cost_soldier[0]->oil;?> Fém: <?php echo $cost_soldier[0]->metal;?> Fa: <?php echo $cost_soldier[0]->wood;?> Kő: <?php echo $cost_soldier[0]->stone;?></td>
						<td><p id = "s" style="margin: 0px;"></p></td>
						<td><input type="text" name="soldier" id="soldier" onkeypress="return isNumberKey(event)" style="width: 60px;" maxlength="4"/></td>
					</tr>
					<tr>
						<td>Tank</td>
						<td>Élelem: <?php echo $cost_tank[0]->food;?> Olaj: <?php echo $cost_tank[0]->oil;?> Fém: <?php echo $cost_tank[0]->metal;?> Fa: <?php echo $cost_tank[0]->wood;?> Kő: <?php echo $cost_tank[0]->stone;?></td>
						<td><p id = "t" style="margin: 0px;"></p></td>
						<td><input type="text" name="tank" id="tank" onkeypress="return isNumberKey(event)" style="width: 60px;" maxlength="4"/></td>
					</tr>
					<tr>
						<td>Vadászgép</td>
						<td>Élelem: <?php echo $cost_fighter[0]->food;?> Olaj: <?php echo $cost_fighter[0]->oil;?> Fém: <?php echo $cost_fighter[0]->metal;?> Fa: <?php echo $cost_fighter[0]->wood;?> Kő: <?php echo $cost_fighter[0]->stone;?></td>
						<td><p id = "f" style="margin: 0px;"></p></td>
						<td><input type="text" name="fighter" id="fighter" onkeypress="return isNumberKey(event)" style="width: 60px;" maxlength="4"/></td>
					</tr>
					<tr>
						<td>Légvédelmi löveg</td>
						<td>Élelem: <?php echo $cost_airdef[0]->food;?> Olaj: <?php echo $cost_airdef[0]->oil;?> Fém: <?php echo $cost_airdef[0]->metal;?> Fa: <?php echo $cost_airdef[0]->wood;?> Kő: <?php echo $cost_airdef[0]->stone;?></td>
						<td><p id = "a" style="margin: 0px;"></p></td>
						<td><input type="text" name="airdef" id="airdef" onkeypress="return isNumberKey(event)" style="width: 60px;" maxlength="4"/></td>
					</tr>
					<tr>
						<td colspan=3></td>
						<td><input type="submit" value="Kiképez"></td>
					</tr>
		</table>
		</form>
</div>
<script>
var logout = <?php echo json_encode($logout);?>;
if(logout == "yes"){
	window.location=document.getElementById('logoutid').href;
}
var army_pop_var = <?php echo $country_population_current[0]->current_population;?>;
var soldier_var = <?php echo $country_military[0]->soldier;?>;
var tank_var = <?php echo $country_military[0]->tank;?>;
var fighter_var = <?php echo $country_military[0]->fighter;?>;
var airdef_var = <?php echo $country_military[0]->airdef;?>;
soldier_var += '/';
soldier_var += army_pop_var;
tank_var += '/';
tank_var += army_pop_var;
fighter_var += '/';
fighter_var += army_pop_var;
airdef_var += '/';
airdef_var += army_pop_var;
function DataLoad() {
	document.getElementById("s").innerHTML = soldier_var;
	document.getElementById("t").innerHTML = tank_var;
	document.getElementById("f").innerHTML = fighter_var;
	document.getElementById("a").innerHTML = airdef_var;
}

function mySubmitFunction(){
	var alert = document.getElementById("alert");
	var soldier = document.getElementById("soldier").value;
	if(soldier == "" || soldier == null){
		var soldier = 0;
	}
	var tank = document.getElementById("tank").value;
	if(tank == "" || tank == null){
		var tank = 0;
	}
	var fighter = document.getElementById("fighter").value;
	if(fighter == "" || fighter == null){
		var fighter = 0;
	}
	var airdef = document.getElementById("airdef").value;
	if(airdef == "" || airdef == null){
		var airdef = 0;
	}
	/*
	var army_pop_var2 = <?php echo $country_population_current[0]->current_population;?>;
	var soldier_var2 = <?php echo $country_military[0]->soldier;?>;
	var tank_var2 = <?php echo $country_military[0]->tank;?>;
	var fighter_var2 = <?php echo $country_military[0]->fighter;?>;
	var airdef_var2 = <?php echo $country_military[0]->airdef;?>;
	function Sum(){
		soldier_var2 = Number(soldier_var2) + Number(soldier);
		tank_var2 = Number(tank_var2) + Number(tank);
		fighter_var2 = Number(fighter_var2) + Number(fighter);
		airdef_var2 = Number(airdef_var2) + Number(airdef);
		army_pop_var2 = Number(army_pop_var2) + Number(soldier) + Number(tank) + Number(fighter) + Number(airdef);
		soldier_var2 += '/';
		soldier_var2 += army_pop_var2;
		tank_var2 += '/';
		tank_var2 += army_pop_var2;
		fighter_var2 += '/';
		fighter_var2 += army_pop_var2;
		airdef_var2 += '/';
		airdef_var2 += army_pop_var2;
	}*/
	function useReturnData(data){
		var myvar = data;
		if(myvar == "success"){
			/*
			Sum();
			document.getElementById("s").innerHTML = soldier_var2;
			document.getElementById("t").innerHTML = tank_var2;
			document.getElementById("f").innerHTML = fighter_var2;
			document.getElementById("a").innerHTML = airdef_var2;*/
			document.getElementById("alert_msg").innerHTML="Sikeres kiképzés!";
			alert.style.display = "block";
			alert.style.backgroundColor = "green";
			location.reload();
		}else if(myvar == "population"){
			document.getElementById("alert_msg").innerHTML="Nincs több hely a laktanyán!";
			alert.style.display = "block";
			alert.style.backgroundColor = "red";
		}else if(myvar == "materials"){
			document.getElementById("alert_msg").innerHTML="Nincs elég nyersanyag!";
			alert.style.display = "block";
			alert.style.backgroundColor = "red";
		}else{
			alert.style.display = "none";
		}
	}
	$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
	$.ajax({
		type:"post",
		url:"armyupdate",
		async:false,
		data:{ soldier: soldier, tank: tank, fighter: fighter, airdef: airdef },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	return false;
}
</script>

@include('layout.partials.footer')

</body>
</html>