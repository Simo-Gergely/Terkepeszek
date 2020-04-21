<?php
$country = session('country_name');
$country_id = DB::table('S01_countries')->where([
	['country_name', '=', $country],
])->get();
$update_level = DB::table('S01_update_levels')->where([
	['country_id', '=', $country_id[0]->country_id],
])->get();
$barrack = DB::table('S01_update_costs')->where([
	['item', '=', 'barrack'],
])->get();
$agriculture = DB::table('S01_update_costs')->where([
	['item', '=', 'agriculture'],
])->get();
$oil_industry = DB::table('S01_update_costs')->where([
	['item', '=', 'oil_industry'],
])->get();
$timber_industry = DB::table('S01_update_costs')->where([
	['item', '=', 'timber_industry'],
])->get();
$metal_industry = DB::table('S01_update_costs')->where([
	['item', '=', 'metal_industry'],
])->get();
$quarry = DB::table('S01_update_costs')->where([
	['item', '=', 'quarry'],
])->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
<body>
@include('layout.partials.header')
@include('layout.partials.nav')
<div class="bg-light main-container pb-3 pt-3">
		<h1 style="width: 60%; margin-right: auto; margin-left: auto;">Fejlesztés</h1>
		<p style="width: 60%; margin-right: auto; margin-left: auto;">Az Fejlesztés menüpontban az ágazatok erősítésével növelni tudod az országod termelését.</p>
		<div id="alert" class="div_alert">
			<span class="Close_btn" onclick="this.parentElement.style.display='none';">&times;</span>
			<p id="alert_msg"></p>
		</div>
		<table border=1 border=1 style="margin-right: auto; margin-left: auto;">
				<thead>
					<tr>
						<th>Ágazat</th>
						<th>Szükséglet</th>
						<th>Szint</th>
						<th width="60px">Fejlesztés</th>
					</tr>
					<tr>
						<td>Mezőgazdaság</td>
						<td>Élelem: <?php echo $agriculture[0]->food_cost;?> Olaj: <?php echo $agriculture[0]->oil_cost;?> Fém: <?php echo $agriculture[0]->metal_cost;?> Fa: <?php echo $agriculture[0]->wood_cost;?> Kő: <?php echo $agriculture[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->agriculture_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="agriculture()"/></td>
					</tr>
					<tr>
						<td>Olajipar</td>
						<td>Élelem: <?php echo $oil_industry[0]->food_cost;?> Olaj: <?php echo $oil_industry[0]->oil_cost;?> Fém: <?php echo $metal_industry[0]->food_cost;?> Fa: <?php echo $oil_industry[0]->wood_cost;?> Kő: <?php echo $oil_industry[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->oil_industry_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="oil_industry()"/></td>
					</tr>
					<tr>
						<td>Fémipar</td>
						<td>Élelem: <?php echo $metal_industry[0]->food_cost;?> Olaj: <?php echo $metal_industry[0]->oil_cost;?> Fém: <?php echo $metal_industry[0]->metal_cost;?> Fa: <?php echo $metal_industry[0]->wood_cost;?> Kő: <?php echo $metal_industry[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->metal_industry_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="metal_industry()"/></td>
					</tr>
					<tr>
						<td>Faipar</td>
						<td>Élelem: <?php echo $timber_industry[0]->food_cost;?> Olaj: <?php echo $timber_industry[0]->oil_cost;?> Fém: <?php echo $timber_industry[0]->metal_cost;?> Fa: <?php echo $timber_industry[0]->wood_cost;?> Kő: <?php echo $timber_industry[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->timber_industry_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="timber_industry()"/></td>
					</tr>
					<tr>
						<td>Kőfejtő</td>
						<td>Élelem: <?php echo $quarry[0]->food_cost;?> Olaj: <?php echo $quarry[0]->oil_cost;?> Fém: <?php echo $quarry[0]->metal_cost;?> Fa: <?php echo $quarry[0]->wood_cost;?> Kő: <?php echo $quarry[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->quarry_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="quarry()"/></td>
					</tr>
					<tr>
						<td>Laktanya</td>
						<td>Élelem: <?php echo $barrack[0]->food_cost;?> Olaj: <?php echo $barrack[0]->oil_cost;?> Fém: <?php echo $barrack[0]->metal_cost;?> Fa: <?php echo $barrack[0]->wood_cost;?> Kő: <?php echo $barrack[0]->stone_cost;?></td>
						<td><?php echo $update_level[0]->barrack_level;?></td>
						<td><img src="{{ asset('/src/up.png') }}" onclick="barrack()"/></td>
					</tr>
		</table>
</div>
<script>
var alert = document.getElementById("alert");
function useReturnData(data){
		var myvar = data;
		if(myvar == "materials"){
			document.getElementById("alert_msg").innerHTML="Nincs elég nyersanyag!";
			alert.style.display = "block";
			alert.style.backgroundColor = "red";
		}else{
			location.reload();
		}
	}
var agriculture_level = <?php echo $update_level[0]->agriculture_level;?>;
var oil_industry_level = <?php echo $update_level[0]->oil_industry_level;?>;
var metal_industry_level = <?php echo $update_level[0]->metal_industry_level;?>;
var timber_industry_level = <?php echo $update_level[0]->timber_industry_level;?>;
var quarry_level = <?php echo $update_level[0]->quarry_level;?>;
var barrack_level = <?php echo $update_level[0]->barrack_level;?>;
function agriculture(){
	if(agriculture_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ agriculture_level: agriculture_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
function oil_industry(){
	if(oil_industry_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ oil_industry_level: oil_industry_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
function metal_industry(){
	if(metal_industry_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ metal_industry_level: metal_industry_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
function timber_industry(){
	if(timber_industry_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ timber_industry_level: timber_industry_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
function quarry(){
	if(quarry_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ quarry_level: quarry_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
function barrack(){
	if(barrack_level < 3){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type:"post",
		url:"up",
		async:false,
		data:{ barrack_level: barrack_level },
		cache:false,
		success: function(data){
			useReturnData(data);
		}
	});
	}
}
</script>
@include('layout.partials.footer')
</body>
</html>