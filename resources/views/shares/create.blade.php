@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Shares</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Share</div>
				{!! Form::open(['url' => route('shares.store')]); !!}
                <div class="panel-body">
				<table class='table table-striped'>
                        {{ csrf_field() }}
						@foreach($columns as $column)
						<tr>
							@if($column->COLUMN_NAME == 'id' or strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false)
								@continue;
							@elseif(strpos($column->COLUMN_NAME, 'member') !== false and strpos($column->COLUMN_NAME, 'id') !== false)
								<td>
									{{ Form::label($column->COLUMN_NAME, 'Member', array('class' => 'col-md-4 control-label')) }}
									<div class="col-md-6">
										{{ Form::select($column->COLUMN_NAME, $members, null, array('class' => 'form-control', 'required' => '')) }}
									</div>
								</td>
								@continue;
							@elseif(strpos($column->COLUMN_NAME, 'loan') !== false and strpos($column->COLUMN_NAME, 'type') !== false)
								<td>
									{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
									<div class="col-md-6">
										{{ Form::select($column->COLUMN_NAME, $loan_types, null, array('class' => 'form-control', 'required' => '', 'onchange' => 'loanTypeChanged()')) }}
									</div>
								</td>
								@continue;
							@endif
							<!--<div class="form-group">-->
								<td colspan="2">
								{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
								
								<div class="col-md-6">
									@if($column->COLUMN_NAME === 'amount')
										{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'readonly' => '', 'required' => '')) }}
									@elseif($column->COLUMN_NAME === 'total')
										{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'oninput' => 'calculateAmount()', 'required' => '')) }}
									@elseif($column->COLUMN_NAME === 'price')
										{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'oninput' => 'calculateAmount()', 'required' => '')) }}
									@elseif($column->COLUMN_NAME === 'amount' or $column->COLUMN_NAME === 'interest_per_annum' or $column->COLUMN_NAME === 'term')
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'oninput' => 'calculate_everything()')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'required' => '', 'oninput' => 'calculate_everything()')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'date') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control')) }}
										@else
											{{ Form::date($column->COLUMN_NAME, \Carbon\Carbon::now(), array('class' => 'form-control', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'int') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'money') !== false or strpos($column->TYPE_NAME, 'decimal') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => '0.01', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'real') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'float') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@elseif(strpos($column->TYPE_NAME, 'binary') !== false)
										@if($column->NULLABLE == 1)
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any')) }}
										@else
											{{ Form::number($column->COLUMN_NAME, null, array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
										@endif
									@else
										@if($column->NULLABLE == 1)
											{{ Form::text($column->COLUMN_NAME, '', array('class' => 'form-control' )) }}
										@else
											{{ Form::text($column->COLUMN_NAME, '', array('class' => 'form-control', 'required' => '')) }}
										@endif
									@endif
								</div>
								</td>
							<!--</div>-->
						</tr>
						@endforeach
						
						
						<tr>
						<!--<div class="form-group">-->
							<td colspan="2">
                            <div class="col-md-8 col-md-offset-4">
                                {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}
								<a class="btn btn-default btn-close" href="{{ url()->previous() }}">Cancel</a>
                            </div>
							</td>
                        <!--</div>-->
						</tr>
				</table>
                </div>
				{{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script>
	function calculateAmount(){
		var total= Number(document.getElementById('total').value);
		var price= Number(document.getElementById('price').value);
		var amount= total*price;
		var amount_field= document.getElementById('amount')
		amount_field.setAttribute('value', roundtopennies(amount));
	}
	function roundtopennies(n)
	{
		pennies = n * 100;
		
		pennies = Math.round(pennies);
		strPennies = "" + pennies;
		len = strPennies.length;
		
		return (pennies/100);
	}
</script>
@endsection