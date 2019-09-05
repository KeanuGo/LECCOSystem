@extends('layouts.app')

@section('content')
<div align="center">
<h1 style='width:90%;text-align:left;' >Members</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Member</div>
				{!! Form::open(['url' => route('members.store'), 'enctype'=> 'multipart/form-data']); !!}
                <div class="panel-body">
				<table class='table table-striped'>
                        {{ csrf_field() }}
						@foreach($columns as $column)
						<tr>
							@if($column->COLUMN_NAME == 'id' or strpos($column->COLUMN_NAME, 'created_at') !== false or strpos($column->COLUMN_NAME, 'updated_at') !== false)
								@continue;
							@endif
							<!--<div class="form-group">-->
								<td colspan="2">
								{{ Form::label($column->COLUMN_NAME, ucwords(str_replace('_', ' ', $column->COLUMN_NAME)), array('class' => 'col-md-4 control-label')) }}
								
								<div class="col-md-6">
									@if(strpos($column->COLUMN_NAME, 'avatar') !== false)
										<input type="file" class="form-control-file" name="avatar" id="avatarFile" aria-describedby="fileHelp">
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
@endsection