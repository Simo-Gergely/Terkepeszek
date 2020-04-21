<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
</head>
<body>
@include('layout.partials.header')
@include('layout.partials.nav')
<!--src="{{ asset('/src/europe.png') }}"-->

<div class="bg-light main-container pb-3 pt-3" style="text-align: center;">
<table align="center">
					<th style="min-width: 570px">
						<div class="container_map" style="min-width: 570px">
							<img src="{{ asset('/src/europe.png') }}" width="570" height="510" onclick="mindet_rejt()">
							<button id="map1" class="svedorszag" onclick="svedorszag()"></button>
							
								<button id="map1a" class="svedorszag_p1" onclick="opentable('Svédország')">P</button>
								<button id="map1b" class="svedorszag_close" onclick="so_close()">X</button>
								
							<button id="map2" class="norvegia" onclick="norvegia()"></button>
							
								<button id="map2a" class="norvegia_p1" onclick="opentable('Norvégia')">P</button>
								<button id="map2b" class="norvegia_close" onclick="no_close()">X</button>
								
							<button id="map3" class="US" onclick="US()"></button>
							
								<button id="map3a" class="US_p1" onclick="opentable('Nagy-Britannia')">P</button>
								<button id="map3b" class="US_close" onclick="us_close()">X</button>
								
							<button id="map4" class="russia" onclick="russia()"></button>
							
								<button id="map4a" class="russia_p1" onclick="opentable('Oroszország')">P</button>
								<button id="map4b" class="russia_close" onclick="ru_close()">X</button>
								
							<button id="map5" class="magyar" onclick="magyar()"></button>
							
								<button id="map5a" class="magyar_p1" onclick="opentable('Magyarország')">P</button>
								<button id="map5b" class="magyar_close" onclick="hu_close()">X</button>
								
							<button id="map6" class="german" onclick="german()"></button>
							
								<button id="map6a" class="german_p1" onclick="opentable('Németország')">P</button>
								<button id="map6b" class="german_close" onclick="de_close()">X</button>
								
							<button id="map7" class="spain" onclick="spain()"></button>
							
								<button id="map7a" class="spain_p1" onclick="opentable('Spanyolország')">P</button>
								<button id="map7b" class="spain_close" onclick="sp_close()">X</button>
								
							<button id="map8" class="italy" onclick="italy()"></button>
							
								<button id="map8a" class="italy_p1" onclick="opentable('Olaszország')">P</button>
								<button id="map8b" class="italy_close" onclick="it_close()">X</button>
								
							<button id="map9" class="poland" onclick="poland()"></button>
							
								<button id="map9a" class="poland_p1" onclick="opentable('Lengyelország')">P</button>
								<button id="map9b" class="poland_close" onclick="po_close()">X</button>
								
							<button id="map10" class="france" onclick="france()"></button>
							
								<button id="map10a" class="france_p1" onclick="opentable('Franciaország')">P</button>
								<button id="map10b" class="france_close" onclick="fro_close()">X</button>
								
							<button id="map11" class="finn" onclick="finn()"></button>
							
								<button id="map11a" class="finn_p1" onclick="opentable('Finnország')">P</button>
								<button id="map11b" class="finn_close" onclick="fi_close()">X</button>
								
							<button id="map12" class="jugo" onclick="jugo()"></button>
							
								<button id="map12a" class="jugo_p1" onclick="opentable('Jugoszlávia')">P</button>
								<button id="map12b" class="jugo_close" onclick="ju_close()">X</button>
								
							<button id="map13" class="cz_slo" onclick="cz_slo()"></button>
							
								<button id="map13a" class="cz_slo_p1" onclick="opentable('Csehszlovákia')">P</button>
								<button id="map13b" class="cz_slo_close" onclick="cz_slo_close()">X</button>
								
							<button id="map14" class="romania" onclick="romania()"></button>
							
								<button id="map14a" class="romania_p1" onclick="opentable('Románia')">P</button>
								<button id="map14b" class="romania_close" onclick="ro_close()">X</button>
								
							<button id="map15" class="bulgaria" onclick="bulgaria()"></button>
							
								<button id="map15a" class="bulgaria_p1" onclick="opentable('Bulgária')">P</button>
								<button id="map15b" class="bulgaria_close" onclick="bu_close()">X</button>
								
							<button id="map16" class="turkey" onclick="turkey()"></button>
							
								<button id="map16a" class="turkey_p1" onclick="opentable('Törökország')">P</button>
								<button id="map16b" class="turkey_close" onclick="tro_close()">X</button>
								
							<button id="map17" class="greece" onclick="greece()"></button>
							
								<button id="map17a" class="greece_p1" onclick="opentable('Görögország')">P</button>
								<button id="map17b" class="greece_close" onclick="gre_close()">X</button>
								
							<button id="map18" class="austria" onclick="austria()"></button>
							
								<button id="map18a" class="austria_p1" onclick="opentable('Ausztria')">P</button>
								<button id="map18b" class="austria_close" onclick="au_close()">X</button>
								
							<button id="map19" class="swajc" onclick="swajc()"></button>
							
								<button id="map19a" class="swajc_p1" onclick="opentable('Svájc')">P</button>
								<button id="map19b" class="swajc_close" onclick="sw_close()">X</button>
								
							<button id="map20" class="portugal" onclick="portugal()"></button>
							
								<button id="map20a" class="portugal_p1" onclick="opentable('Portugália')">P</button>
								<button id="map20b" class="portugal_close" onclick="port_close()">X</button>
								
							<button id="map21" class="ireland" onclick="ireland()"></button>
							
								<button id="map21a" class="ireland_p1" onclick="opentable('Írország')">P</button>
								<button id="map21b" class="ireland_close" onclick="ire_close()">X</button>
								
							<button id="map22" class="dania" onclick="dania()"></button>
							
								<button id="map22a" class="dania_p1" onclick="opentable('Dánia')">P</button>
								<button id="map22b" class="dania_close" onclick="dan_close()">X</button>
						</div>
					</th>
			</table>
</div>

@include('layout.partials.footer')
</body>
</html>