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
	$country_names = DB::table('S01_countries')->where([
		['country_owner_id', '=', auth()->user()->id],
	])->get();
	$country_name_array = array();
	$i=sizeof($country_names);
	for($y=0; $y<$i; $y++){
		$country_name_array[$y] = $country_names[$y]->country_name;
	}
	$country_bots = DB::table('S01_countries')->where([
		['country_owner_id', '=', null],
	])->get();
	$country_bot_array = array();
	$j=sizeof($country_bots);
	for($y=0; $y<$j; $y++){
		$country_bot_array[$y] = $country_bots[$y]->country_name;
	}
	$country_attack = session('country_name');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		.modal {
		  display: none; /* Hidden by default */
		  position: fixed; /* Stay in place */
		  z-index: 1; /* Sit on top */
		  padding-top: 140px; /* Location of the box */
		  left: 0;
		  top: 0;
		  width: 100%; /* Full width */
		  height: 100%; /* Full height */
		  overflow: auto; /* Enable scroll if needed */
		  background-color: rgb(0,0,0); /* Fallback color */
		  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}
		.modal-content {
		  background-color: #fefefe;
		  margin: auto;
		  padding: 20px;
		  border: 1px solid #888;
		  width: 48%;
		  height: 52%;
		}
	</style>
</head>
<body>
@include('layout.partials.header')
@include('layout.partials.nav')

<div class="bg-light main-container pb-3 pt-3" style="text-align: center;">
<table align="center">
					<th style="min-width: 570px">
						<div class="container_map" style="min-width: 570px">
							<img src="{{ asset('/src/europe.png') }}" width="570" height="510" onclick="mindet_rejt()">
							<button id="Svédország" class="svedorszag" onclick="svedorszag()"></button>
								<button id="map1a" class="svedorszag_p1" onclick="opentable('Svédország')">Támadás</button>
							<button id="Norvégia" class="norvegia" onclick="norvegia()"></button>
								<button id="map2a" class="norvegia_p1" onclick="opentable('Norvégia')">Támadás</button>
							<button id="Egyesült Királyság" class="US" onclick="US()"></button>
								<button id="map3a" class="US_p1" onclick="opentable('Egyesült Királyság')">Támadás</button>
							<button id="Oroszország" class="russia" onclick="russia()"></button>
								<button id="map4a" class="russia_p1" onclick="opentable('Oroszország')">Támadás</button>
							<button id="Magyarország" class="magyar" onclick="magyar()"></button>
								<button id="map5a" class="magyar_p1" onclick="opentable('Magyarország')">Támadás</button>
							<button id="Németország" class="german" onclick="german()"></button>
								<button id="map6a" class="german_p1" onclick="opentable('Németország')">Támadás</button>
							<button id="Spanyolország" class="spain" onclick="spain()"></button>
								<button id="map7a" class="spain_p1" onclick="opentable('Spanyolország')">Támadás</button>
							<button id="Olaszország" class="italy" onclick="italy()"></button>
								<button id="map8a" class="italy_p1" onclick="opentable('Olaszország')">Támadás</button>
							<button id="Lengyelország" class="poland" onclick="poland()"></button>
								<button id="map9a" class="poland_p1" onclick="opentable('Lengyelország')">Támadás</button>
							<button id="Franciaország" class="france" onclick="france()"></button>
								<button id="map10a" class="france_p1" onclick="opentable('Franciaország')">Támadás</button>
							<button id="Finnország" class="finn" onclick="finn()"></button>
								<button id="map11a" class="finn_p1" onclick="opentable('Finnország')">Támadás</button>
							<button id="Jugoszlávia" class="jugo" onclick="jugo()"></button>
								<button id="map12a" class="jugo_p1" onclick="opentable('Jugoszlávia')">Támadás</button>
							<button id="Csehszlovákia" class="cz_slo" onclick="cz_slo()"></button>
								<button id="map13a" class="cz_slo_p1" onclick="opentable('Csehszlovákia')">Támadás</button>
							<button id="Románia" class="romania" onclick="romania()"></button>
								<button id="map14a" class="romania_p1" onclick="opentable('Románia')">Támadás</button>
							<button id="Bulgária" class="bulgaria" onclick="bulgaria()"></button>
								<button id="map15a" class="bulgaria_p1" onclick="opentable('Bulgária')">Támadás</button>
							<button id="Törökország" class="turkey" onclick="turkey()"></button>
								<button id="map16a" class="turkey_p1" onclick="opentable('Törökország')">Támadás</button>
							<button id="Görögország" class="greece" onclick="greece()"></button>
								<button id="map17a" class="greece_p1" onclick="opentable('Görögország')">Támadás</button>
							<button id="Ausztria" class="austria" onclick="austria()"></button>
								<button id="map18a" class="austria_p1" onclick="opentable('Ausztria')">Támadás</button>
							<button id="Svájc" class="swajc" onclick="swajc()"></button>
								<button id="map19a" class="swajc_p1" onclick="opentable('Svájc')">Támadás</button>
							<button id="Portugália" class="portugal" onclick="portugal()"></button>
								<button id="map20a" class="portugal_p1" onclick="opentable('Portugália')">Támadás</button>
							<button id="Írország" class="ireland" onclick="ireland()"></button>
								<button id="map21a" class="ireland_p1" onclick="opentable('Írország')">Támadás</button>
							<button id="Dánia" class="dania" onclick="dania()"></button>
								<button id="map22a" class="dania_p1" onclick="opentable('Dánia')">Támadás</button>
						</div>
					</th>
			</table>
</div>
<div  id="myModal" class="modal">
	  <div class="modal-content" align="center">
	  <form onsubmit="return mySubmitFunction(event)" align="center" style="width: 100%; height: 100%;">
	  {{ csrf_field() }}
	  <table align="center" style="width: 100%; height: 100%;">
		<tr style="text-align: center;">
			<th colspan=3>Támadás</th>
		</tr>
		<tr style="text-align: center;">
			<td>Támadó</td>
			<td></td>
			<td>Védő</td>
		</tr>
		<tr style="text-align: center;">
			<td id="attack"></td>
			<td><img src="{{ asset('/src/pvp.jpg') }}"></td>
			<td id="deff"></td>
		</tr>
		<tr>
			<td colspan=3 style="text-align: right;"><input type="submit" value="Támadás" /></td>
		</tr>
	  </table>
	  </form>
	  </div>
</div>
<script>
var logout = <?php echo json_encode($logout);?>;
if(logout == "yes"){
	window.location=document.getElementById('logoutid').href;
}
var modal = document.getElementById("myModal");
var country_attack = <?php echo json_encode($country_attack);?>;
var country_deff;
function opentable(country){
	document.getElementById('attack').innerHTML = country_attack;
	document.getElementById('deff').innerHTML = country;
	modal.style.display = "block";
	country_deff = country;
}
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}
var country_name_array = <?php echo json_encode($country_name_array);?>;
var country_bot_array = <?php echo json_encode($country_bot_array);?>;
var y = <?php echo $i;?>;
var j = <?php echo $j;?>;
for(i = 0; i < y; i++){
	if(country_name_array[i]==country_attack){
		document.getElementById(country_name_array[i]).style.backgroundColor = "green";
	}else{
		document.getElementById(country_name_array[i]).style.backgroundColor = "blue";
	}
	document.getElementById(country_name_array[i]).disabled = true;
}
for(i = 0; i < j; i++){
	document.getElementById(country_bot_array[i]).style.backgroundColor = "gray";
}
function useReturnData(data){
	window.alert(data);
}
function mySubmitFunction(){
	$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
	});
	$.ajax({
		type:"post",
		url:"pvp",
		async:false,
		data:{ country_attack: country_attack, country_deff: country_deff },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	return true;
}



function mindet_rejt(){	
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function svedorszag(){
	document.getElementById("map1a").style.visibility = "visible";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function norvegia(){
	document.getElementById("map2a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function US(){
	document.getElementById("map3a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function russia(){
	document.getElementById("map4a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function magyar(){
	document.getElementById("map5a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function german(){
	document.getElementById("map6a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function spain(){
	document.getElementById("map7a").style.visibility = "visible";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function italy(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "visible";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function poland(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "visible";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function france(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "visible";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function finn(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "visible";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function jugo(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "visible";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function cz_slo(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "visible";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function romania(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "visible";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function bulgaria(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "visible";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function turkey(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "visible";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function greece(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "visible";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function austria(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "visible";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function swajc(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "visible";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function portugal(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "visible";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "hidden";
}
function ireland(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "visible";
	document.getElementById("map22a").style.visibility = "hidden";
}
function dania(){
	document.getElementById("map7a").style.visibility = "hidden";
	document.getElementById("map1a").style.visibility = "hidden";
	document.getElementById("map2a").style.visibility = "hidden";
	document.getElementById("map3a").style.visibility = "hidden";
	document.getElementById("map4a").style.visibility = "hidden";
	document.getElementById("map5a").style.visibility = "hidden";
	document.getElementById("map6a").style.visibility = "hidden";
	document.getElementById("map8a").style.visibility = "hidden";
	document.getElementById("map9a").style.visibility = "hidden";
	document.getElementById("map10a").style.visibility = "hidden";
	document.getElementById("map11a").style.visibility = "hidden";
	document.getElementById("map12a").style.visibility = "hidden";
	document.getElementById("map13a").style.visibility = "hidden";
	document.getElementById("map14a").style.visibility = "hidden";
	document.getElementById("map15a").style.visibility = "hidden";
	document.getElementById("map16a").style.visibility = "hidden";
	document.getElementById("map17a").style.visibility = "hidden";
	document.getElementById("map18a").style.visibility = "hidden";
	document.getElementById("map19a").style.visibility = "hidden";
	document.getElementById("map20a").style.visibility = "hidden";
	document.getElementById("map21a").style.visibility = "hidden";
	document.getElementById("map22a").style.visibility = "visible";
}
</script>
@include('layout.partials.footer')
</body>
</html>