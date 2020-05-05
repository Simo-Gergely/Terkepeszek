<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.partials.head')
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('layout.partials.header')
<div class="bg-light main-container pb-3 pt-3">
    <section>
        <div class="container">

            <h2>Bejelentkezés</h2>
			<div id="alert" class="div_alert">
				<span class="Close_btn" onclick="this.parentElement.style.display='none';">&times;</span> 
				<p id="alert_msg"></p>
			</div>
            <form method="POST" action="login" onsubmit="return mySubmitFunction(event)">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="username">Felhasználónév:</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>

                <div class="form-group">
                    <label for="password">Jelszó:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
				
				<div class="select_div">
					<select id="select_server">
						<option hidden selected>-- Válaszd ki a szervert! --</option>
					</select>
				</div>
				
                <div class="form-group">
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Bejelentkezés</button>
                </div>
				<?php
					$servers = DB::table('servers')->where([
						['server_status', '=', 'Okay'],
					])->get();
					$servers_array = array();
					$size=sizeof($servers);
					for($y = 0; $y < $size; $y++){
						$servers_array[$y] = $servers[$y]->server_name;
					}
				?>
				<script type="text/javascript">
					var ServerSelect = document.getElementById('select_server');
					var size = <?php echo json_encode($size); ?>;
					for(i = 0; i < size; i++){
						var ServerName = <?php echo json_encode($servers_array);?>;
						var ServerOption = document.createElement('option');
						ServerOption.value = ServerName[i];
						ServerOption.text = ServerName[i];
						ServerSelect.appendChild(ServerOption);
					}
				function mySubmitFunction(){
				var s_select = document.getElementById("select_server");
				var s_option = s_select.options[s_select.selectedIndex].value;
				var alert = document.getElementById("alert");
				var bool = true;
				for(i = 0; i < size; i++){
					if(s_option==ServerName[i]){
						bool = false;
					}
				}
				if(bool){
					var exp = "Válaszd ki a szervert!";
					document.getElementById("alert_msg").innerHTML = exp;
					alert.style.display = "block";
					return false;
				}

				var name = document.getElementById("username").value;
				var pw = document.getElementById("password").value;
				var checking = true;
				function useReturnData(data){
					myvar = data;
					if(myvar){
						document.getElementById("alert_msg").innerHTML=myvar;
						alert.style.display = "block";
						checking = false;
					}else{
						checking = true;
					}
				}
				$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
				});
				$.ajax({
					type:"post",
					url:"loginpage",
					async:false,
					data:{ name: name, pw: pw },
					cache:false,
					success: function(data){
						useReturnData(data);
					}
				});
				return checking;
				}
				</script>
            </form>
        </div>
        <!--end of container-->
    </section>
    <!--end of section-->
</div>
<!--end of main container-->
@include('layout.partials.footer')
</body>