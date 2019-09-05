@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Access Rights</div>

                <div class="panel-body">
					{{Form::open(['url' => route('users.update_rights', ['id' => $access_rights['user_id']]) ] )}}
					{{ csrf_field() }}
					<table class='table table-striped'>
						@foreach($columns as $column)
							<tr>
								<div class="form-group">
									@if(strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false)
										@continue;
									@endif
									<td>{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}</td>
									<td>
										<div class="col-md-6">
											@if(strpos($column->COLUMN_NAME, 'id') == true)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'readonly' => '')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'readonly' => '')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'date') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::date($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control')) }}
													@else
														{{ Form::date($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => '')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'int') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'bit') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::checkbox($column->COLUMN_NAME, 1,$access_rights[$column->COLUMN_NAME], array('class' => 'form-control')) }}
													@else
														{{ Form::checkbox($column->COLUMN_NAME, 1, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'money') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => '0.01', 'required' => '')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'real') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'float') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
													@endif
												@elseif(strpos($column->TYPE_NAME, 'binary') !== false)
													@if($column->NULLABLE == 1)
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any')) }}
													@else
														{{ Form::number($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'step' => 'any', 'required' => '')) }}
													@endif
												@else
													@if($column->NULLABLE == 1)
														{{ Form::text($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control' )) }}
													@else
														{{ Form::text($column->COLUMN_NAME, $access_rights[$column->COLUMN_NAME], array('class' => 'form-control', 'required' => '')) }}
													@endif
												@endif
										</div>
									</td>
								</div>
							</tr>
						@endforeach
						<tr>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<td colspan="2">
								{{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
								<a class="btn btn-default btn-close" href="{{ route('home') }}">Cancel</a>
								</td>
							</div>
						</div>
						</tr>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection