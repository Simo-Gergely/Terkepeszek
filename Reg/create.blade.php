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
            <h2>Regisztráció</h2>
			<div id="alert" class="div_alert">
				<span class="Close_btn" onclick="this.parentElement.style.display='none';">&times;</span> 
				<p id="alert_msg"></p>
			</div>
            <form method="POST" action="register" onsubmit="return mySubmitFunction(event)">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="Username">Felhasználónév:</label>
                    <input type="text" class="form-control" id="Username" name="username">
                </div>

                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="email" class="form-control" id="Email" name="email">
                </div>

                <div class="form-group">
                    <label for="Password">Jelszó:</label>
                    <input type="password" class="form-control" id="Password" name="password">
                </div>

                <div class="form-group">
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Regisztráció</button>
                </div>

            </form>
        </div>
        <!--end of container-->
    </section>
    <!--end of section-->
</div>
<!--end of main container-->
<script>

	function mySubmitFunction(){
		var regex = /^[A-Za-z0-9]+$/;
		var name = document.getElementById("Username").value;
		var email = document.getElementById("Email").value;
		var pw = document.getElementById("Password").value;
		var alert = document.getElementById("alert");
		var checking = true;
		function alert_msg_function(data){
			document.getElementById("alert_msg").innerHTML = data;
			alert.style.display = "block";
		}
		if(((name.length < 5) || (name.length > 14)) || !(regex.test(document.getElementById("Username").value))){
			var data = "A felhasználónév nem megfelelő! (5-14 karakter, A-Za-z0-9)";
			alert_msg_function(data);
			return false;
		}else if((email.length < 8) || (email.length > 38)){
			var data = "Az email cím nem megfelelő! (8-38 karakter)";
			alert_msg_function(data);
			return false;
		}else if((pw.length < 8) || (pw.length > 16)){
			var data = "A jelszó nem megfelelő! (8-16 karakter)";
			alert_msg_function(data);
			return false;
		}
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
			url:"registerpage",
			async:false,
			data:{ name: name, email: email },
			cache:false,
			success: function(data){
				useReturnData(data);
			}
		});
		return checking;
	}
</script>

@include('layout.partials.footer')


