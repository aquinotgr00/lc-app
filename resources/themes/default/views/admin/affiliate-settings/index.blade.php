@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Affiliate Setting</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['route' => 'admin.affiliate-settings.save', 'method' => 'POST']) !!}

                        @foreach($affSettings as $value)
                            <div class="form-group">
                                {!! Form::label($value->name, $value->display_name) !!}
                                @if($value->type == 1)
                                    {!! Form::text($value->name, $value->value, ['class' => 'form-control']) !!}
                                @else
                                    {!! Form::number($value->name, $value->value_int, ['class' => 'form-control']) !!}
                                @endif
                            </div>
                        @endforeach

                        <div class="form-group">
                            {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection