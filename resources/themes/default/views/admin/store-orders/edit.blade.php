@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="float:none;margin:0 auto;">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/sales/general.page.edit.section-title') }}</h3>
                </div>
                <div class="box-body">

                    {!! Form::model($order, ['route' => ['admin.store-orders.update', $order->id], 'method' => 'PATCH']) !!}

                        <div class="form-group"></div>

                        <div class="form-group">
                            {!! Form::submit( 'Update', ['class' => 'btn btn-primary'] ) !!}
                            <a href="{!! route('admin.store-orders.index') !!}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection