@extends('layouts.app')
<style>
	html, body {
		background-color: #fff;
		color: #636b6f;
		font-family: 'Raleway', sans-serif;
		font-weight: 100;
		height: 100vh;
		margin: 0;
	}

	.full-height {
		height: 100vh-50px;
	}

	.flex-center {
		align-items: center;
		display: flex;
		justify-content: center;
	}

	.position-ref {
		position: relative;
	}

	.content {
		text-align: center;
	}

	.title {
		font-size: 36px;
		padding: 20px;
	}
</style>
@section('content')
<div class = 'flex-center position-ref full-height'>
	<div class ='content'>
		<div class='title'>
		You cannot access this page! This is for ‘{{$role}}’ only
		</div>
	</div>
</div>
@endsection