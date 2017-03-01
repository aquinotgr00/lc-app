@extends('layouts.master')

@section('head_extra')
    <!-- autocomplete ui css -->
    @include('partials.head_css.autocomplete_css')
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8" style="float:none;margin:0 auto;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/products/general.page.edit.section-title') }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    {!! Form::model($product, ['route' => ['admin.seeds.update', $product->id], 'method' => 'PATCH']) !!}

                    <div class="form-group">
                        {!! Form::label('name', trans('admin/products/general.columns.name')) !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('stock', trans('admin/products/general.columns.stock')) !!}
                        {!! Form::text('stock', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('weight', trans('admin/products/general.columns.weight')) !!}
                        {!! Form::text('weight', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', trans('admin/products/general.columns.description')) !!}
                        {!! Form::textarea('description', null, ['rows' => '3', 'class' => 'form-control']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('price', 'Harga 1 Liter', ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            {!! Form::text('price', null, ['placeholder' => 'Harga 1 Liter', 'class' => 'form-control']) !!}
                            <span class="input-group-addon">.000</span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('price_1', 'Harga 500 ml', ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            {!! Form::text('seed[price_1]', null, ['placeholder' => 'Harga 500 ml', 'class' => 'form-control']) !!}
                            <span class="input-group-addon">.000</span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('price_2', 'Harga 250 ml', ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            {!! Form::text('seed[price_2]', null, ['placeholder' => 'Harga 250 ml', 'class' => 'form-control']) !!}
                            <span class="input-group-addon">.000</span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::label('price_3', 'Harga 100 ml', ['class' => 'control-label']) !!}
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            {!! Form::text('seed[price_3]', null, ['placeholder' => 'Harga 100 ml', 'class' => 'form-control']) !!}
                            <span class="input-group-addon">.000</span>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        {!! Form::submit( trans('general.button.edit'), ['class' => 'btn btn-primary'] ) !!}
                        <a href="{!! route('admin.seeds.index') !!}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>
                            {{ trans('general.button.cancel') }}
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

@endsection

@section('body_bottom')
    @include('partials.body_bottom_js.create_product')
@endsection