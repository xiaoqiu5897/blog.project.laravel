<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Document</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<style type="text/css">
		body{ 
			margin:0; 
			font:normal 75% Arial, Helvetica, sans-serif; 
		} 

		canvas { 
			display: block; 
			vertical-align: bottom; 
		}

		#particles-js{ 
			position:absolute; 
			width: 100%; 
			height: 100%; 
			/*background-color: #232741; 
			background-image: url("http://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NASA_logo.svg/1237px-NASA_logo.svg.png"); */
			background: url('https://wallpaperplay.com/walls/full/e/5/3/181223.jpg');
			background-repeat: no-repeat; 
			background-size: 100%; 
			background-position: 50% 50%; 
		}

		.count-particles{ 
			background: #000022; 
			position: absolute; 
			top: 48px; 
			left: 0; 
			width: 80px; 
			color: #13E8E9; 
			font-size: .8em; 
			text-align: left; 
			text-indent: 4px; 
			line-height: 14px; 
			padding-bottom: 2px; 
			font-family: Helvetica, Arial, sans-serif; 
			font-weight: bold; 
		} 

		.js-count-particles{ 
			font-size: 1.1em; 
		} 

		#stats, 
		.count-particles { 
			-webkit-user-select: none; 
			margin-top: 5px; 
			margin-left: 5px; 
		} 

		#stats { 
			border-radius: 3px 3px 0 0; 
			overflow: hidden; 
		} 

		.count-particles { 
			border-radius: 0 0 3px 3px; 
		}
		input {
			font-size: 20px!important;
			opacity: 1 !important;
			height: 50px !important;
		}
		.login-div {
			border-radius: 8px;
			width: 35%; 
			margin: auto; 
			background-color: #232741; 
			opacity: 0.6;
			padding-left: 50px;
			padding-right: 50px;
			padding-top: 30px;
			padding-bottom: 50px;
		}
		button {
			font-size: 20px !important;
		}
		h1 {
			color: white;
			margin: auto;
			margin-bottom: 30px;
			width: 200px;
		}
		a {
			font-size: 17px;
		}
	</style>
</head>
<body>
	<div id="particles-js"></div>
	<div style="width: 100%; height: 100%; padding-top: 220px">
		<div class="login-div">
			<form method="POST" action="{{ route('login') }}">
				<h1>Đăng nhập</h1>
				@csrf

				<div class="form-group row">
					<div class="col-md-12">
						<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Nhập Email">

						@if ($errors->has('email'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<br><br><br>
				<div class="form-group row">
					<div class="col-md-12">
						<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Nhập mật khẩu">

						@if ($errors->has('password'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						@endif
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-6 offset-md-4">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

							<label class="form-check-label" for="remember">
								{{ __('Remember Me') }}
							</label>
						</div>
					</div>
				</div>
				<br><br><br>
				<div class="form-group row mb-0">
					<div class="col-md-8 offset-md-4">
						<button type="submit" class="btn btn-primary">
							{{ __('Đăng nhập') }}
						</button>

						<a class="btn btn-link" href="{{ route('password.request') }}">
							{{ __('Forgot Your Password?') }}
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<script src="{{ asset('js/app.js') }}" defer></script>
	<script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> 
	<script src="http://threejs.org/examples/js/libs/stats.min.js"></script>\
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	<script type="text/javascript">
		particlesJS("particles-js", {"particles":{"number":{"value":260,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":1,"random":true,"anim":{"enable":true,"speed":1,"opacity_min":0,"sync":false}},"size":{"value":3,"random":true,"anim":{"enable":false,"speed":4,"size_min":0.3,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":1,"direction":"none","random":true,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":600}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"bubble"},"onclick":{"enable":true,"mode":"repulse"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":250,"size":0,"duration":2,"opacity":0,"speed":3},"repulse":{"distance":400,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true})
	</script>
</body>
</html>