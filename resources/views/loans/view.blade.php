@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Loans</h1>
</div>
<div class="container">
	<table class="table table-striped">
		@foreach($loan as $k => $v)
			@if(strpos($k, 'created_at') !== false or strpos($k, 'updated_at') !== false or strpos($k, 'avatar') !== false or strpos($k, 'avatar') !== false)
				@continue;
			@endif
			<tr>
				@if($k == 'id')
					<th>Loan ID</th>
				@else
					<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
				@endif
				@if($k == 'remarks')
					<td>
					@if(Auth::User()->access_rights()->loans_edit)
						<form action="{{ route('loans.update', ['id' => $loan->id]) }}" method="POST">
							{{ Form::hidden('_token', csrf_token()) }}
							{{ Form::text($k, $v, ['name' => $k, 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)']) }}
							{{ Form::submit('Update', ['class' => 'btn btn-primary no-print']) }}
						</form>
					@else
						<td>{{ $v }}</td>
					@endif
					</td>
					@continue
				@endif
				<td>{{ $v }}</td>
			</tr>
		@endforeach
	</table>
	
</div>
	<h3 align="center">Payment Schedule</h3>
	<hr>
	<table class="table table-striped">
		@if(reset($payroll_deductions))
			@foreach($payroll_deductions as $payroll => $_payroll_deductions)
				@if(count($_payroll_deductions) > 0)
					<tr><th colspan={{ count($_payroll_deductions) }}><h4 style='text-align:center;'>Salary Deduction: {{ ucwords(str_replace('_', ' ', $payroll)) }}</h4></th></tr>
					<tr>
					@foreach($_payroll_deductions[0] as $k => $v)
						@if($k == 'loan_id' or $k == 'created_at')
							@continue;
						@endif
						<th>{{ ucwords(str_replace('_', ' ', $k)) }}</th>
					@endforeach
					<th class="no-print"> Action </th>
					</tr>
					@foreach($_payroll_deductions as $payroll_deduction)
						@if(Auth::User()->access_rights()->loans_edit)
							@if(!$payroll_deduction['month_year_applied'])
								<form action="{{ route('payment_schedule.update') }}" method="POST" id="{{ $payroll .'_'. $payroll_deduction['payment_no'] }}" onsubmit="return approve()">
							@else
								<form action="{{ route('payment_schedule.undo') }}" method="POST" id="{{ $payroll .'_'. $payroll_deduction['payment_no'] }}" onsubmit="return approve()">
							@endif
						@endif
							<tr>
								@if(Auth::User()->access_rights()->loans_edit)
									{{ Form::hidden('_token', csrf_token(), ['form' => $payroll .'_'. $payroll_deduction['payment_no']]) }}
									{{ Form::hidden('loan_id', $payroll_deduction['loan_id'], ['form' => $payroll .'_'. $payroll_deduction['payment_no']]) }}
									{{ Form::hidden('payroll', $payroll, ['form' => $payroll .'_'. $payroll_deduction['payment_no']]) }}
								@endif
								@foreach($payroll_deduction as $k1 => $v1)
									@if($k1 == 'loan_id' or $k1 == 'created_at')
										@continue;
									@elseif(strpos($k1, 'month') !== false and strpos($k1, 'year') !== false and strpos($k1, 'applied') !== false)
										@if(!$payroll_deduction['month_year_applied'])
											<td>{{ Form::date($v1, ((\Carbon\Carbon::parse($payroll_deduction['expected_date_of_payment']) > \Carbon\Carbon::now('Asia/Manila')) ? $payroll_deduction['expected_date_of_payment'] : \Carbon\Carbon::now('Asia/Manila')), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'class' => 'format-print']) }}</td>
										@else
											<td>{{ Form::date($v1, ((\Carbon\Carbon::parse($payroll_deduction['expected_date_of_payment']) > \Carbon\Carbon::now('Asia/Manila')) ? $payroll_deduction['expected_date_of_payment'] : \Carbon\Carbon::now('Asia/Manila')), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => '']) }}</td>
										@endif
										@continue
									@elseif(strpos($k1, 'penalty') !== false and strpos($k1, 'interest') !== false)
										@if(!$payroll_deduction['month_year_applied'])
											@if(\Carbon\Carbon::now('Asia/Manila') > $payroll_deduction['expected_date_of_payment'])
												<td>{{ Form::number($v1, round((((floor(\Carbon\Carbon::now('Asia/Manila')->diffInDays($payroll_deduction['expected_date_of_payment'])/30.0)*.05))*$payroll_deduction['periodic_payment']), 2), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'step' => '0.01', 'class' => 'format-print']) }}</td>
											@else
												<td>{{ Form::number($v1, 0.00, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'step' => '0.01', 'class' => 'format-print']) }}</td>
											@endif
										@else
											<td>{{ Form::number($v1, ($v1==0?'0.00':$v1), ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => '']) }}</td>
										@endif
										@continue
									@elseif(strpos($k1, 'remarks') !== false and strpos($k1, 'remarks') !== false)
										@if(!$payroll_deduction['month_year_applied'])
											<td>{{ Form::text($v1, '', ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;background-color:rgba(0,0,0,0)', 'required' => '', 'step' => '0.01', 'class' => 'format-print']) }}</td>
										@else
											<td>{{ Form::text($v1, $v1, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => '']) }}</td>
										@endif
										@continue
									@endif
									<td>{{ Form::text($v1, $v1, ['name' => $k1, 'form' => ($payroll .'_'. $payroll_deduction['payment_no']), 'style' => 'text-align:center;border:0px;background-color:rgba(0,0,0,0)', 'readonly' => '', 'required' => '']) }}</td>
								@endforeach
								<td class="no-print">
									@if(Auth::User()->access_rights()->loans_edit)
										@if(!$payroll_deduction['month_year_applied'])
											{{ Form::submit('Update', ['form' => $payroll .'_'. $payroll_deduction['payment_no'], 'class' => 'btn btn-primary']) }}
										@elseif($payroll_deduction['updated_at'] == $latest)
											{{ Form::submit('Undo', ['form' => $payroll .'_'. $payroll_deduction['payment_no'], 'class' => 'btn delete-a', 'style' => 'color:white;']) }}
										@endif
									@endif
								</td>
							</tr>
						{{ Form::close() }}
					@endforeach
				@endif
			@endforeach
		@else
			<tr><th> Empty </th></tr>
		@endif
	</table>
<script>
	function approve(){
		if(confirm('Updating are you sure?')){
			return true;
		}else{
			return false;
		}
	}
</script>
@endsection