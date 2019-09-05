@extends('layouts.app')

@section('content')
<div class="container">
	<table class="table table-striped">
		<tr>
			@if($users->first())
				@foreach($users->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th>Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($users as $user)
			<tr>
			@foreach($user as $k => $v)
				@if(strpos($k, 'avatar') !== false)
					<td><img class="img-rounded" style=" display:block;height:auto;width:3px;" src="/storage/avatars/{{ $user->avatar }}" /></td>
					@continue;
				@endif
				<td> {{ $v }} </td>
			@endforeach
			<td>
			@if(Auth::User()->access_rights()->invoke_rights)
				<a href="{{ route('users.view_rights', ['id' => $user->id]) }}" class="link-tag edit-a">Edit Privileges</a>
			@endif
			@if(Auth::User()->access_rights()->users_delete and Auth::User()->id != $user->id)
				<a href="{{ route('users.delete', ['id' => $user->id]) }}" class="link-tag delete-a"> Delete </a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
</div>
@endsection