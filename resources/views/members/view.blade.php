@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Members</h1>
</div>
<div class="container">
	<td><img style=" display:block;height:150px;width:150px;" src="/storage/avatars/{{ $member['avatar'] }}" /></td>
	<table class="table table-striped">
		@foreach($member as $k => $v)
			@if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false or strpos($k, 'avatar') !== false)
				@continue;
			@endif
			<tr>
				@if($k == 'id')
					<th>Member ID</th>
				@else
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endif
				@if(strpos($k, 'no_of_subscribed_shares') !== false)
					<td><div class="no-print"><a href="{{ route('shares.view', ['id' => $member['id']]) }}" class="link-tag view-a">View Shares</a></td></div>
					@continue;
				@endif
				<td>{{ $v }}</td>
			</tr>
		@endforeach
	</table>
	<hr>
	<div class="no-print">
		@if(Auth::User()->access_rights()->member_edit)
			<a href="{{ route('members.edit', ['id' => $member['id']]) }}" class="link-tag edit-a"> Edit</a>
		@endif
		@if(Auth::User()->access_rights()->member_delete)
			<a href="{{ route('members.delete', ['id' => $member['id']]) }}" class="link-tag delete-a"> Delete</a>
		@endif
		@if(Auth::User()->access_rights()->member_view)
			<a href="{{ route('members.index') }}" class="link-tag view-a"> View All Members </a>
		@endif
	</div>
	<br>
</div>
@endsection