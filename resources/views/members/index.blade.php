@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Members</h1>
</div>
<div class="container">
	@include('partials.filter_bar')
	<table class="table table-striped" id="main-table">
		<tr>
			@if($members->first())
				@foreach($members->first() as $k => $v)
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endforeach
				<th class="no-print">Actions</th>
			@else
				<th> Empty </th>
			@endif
		</tr>
		@foreach($members as $member)
			<tr>
			@foreach($member as $k => $v)
				<td> {{ $v }} </td>
			@endforeach
			<td no-search class= "no-print">
			@if(Auth::User()->access_rights()->member_view)
				<a href="{{ route('members.view', ['id' => $member->id]) }}" class="link-tag view-a">View</a>
			@endif
			@if(Auth::User()->access_rights()->member_edit)
				<a href="{{ route('members.edit', ['id' => $member->id]) }}" class="link-tag edit-a"> Edit</a>
			@endif
			@if(Auth::User()->access_rights()->member_delete)
				<a href="{{ route('members.delete', ['id' => $member->id]) }}" class="link-tag delete-a"> Delete</a>
			@endif
			</td>
			</tr>
		@endforeach
	</table>
	<div class= "no-print">
		@if(Auth::User()->access_rights()->member_create)
			<a href="{{ route('members.create') }}" class="link-tag add-a"> Add Member </a>
		@endif
	</div>
</div>
@endsection