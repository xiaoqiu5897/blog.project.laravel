<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Document</title>
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<style type="text/css">
		.error {
			color: red
		}
	</style>
</head>
<body>
	<form action="/testvalid" method="POST" role="form">
		@csrf
		<div class="form-group">
			<label for="">Tiêu đề</label>
			<input type="text" name="title" class="form-control" id="" >
			<span class="error">
				@if($errors->has('title'))
				{{$errors->first('title')}}
				@endif
			</span>
		</div>
		<div class="form-group">
			<label for="">Mô tả</label>
			<input type="text" name="description" class="form-control" id="" >
			<span class="error">
				@if($errors->has('description'))
				{{$errors->first('description')}}
				@endif
			</span>
		</div>
		<div class="form-group">
			<label for="">Slug</label>
			<input type="text" name="slug" class="form-control" id="" >
			<span class="error"></span>
		</div>
		<div class="form-group">
			<label for="">Nội dung</label>
			<input type="text" name="content" class="form-control" id="" >
			<span class="error"></span>
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
	{{-- <p>{{dd($errors)}}</p> --}}
</body>
</html>