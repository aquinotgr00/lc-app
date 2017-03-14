@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" style="float:none;margin:0 auto;">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/suppliers/general.page.create.section-title') }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body" id="form">

                    {!! Form::open(['route' => 'admin.suppliers.store']) !!}

                        @include('partials.forms.supplier_form')

                        <div class="form-group">
                            {!! Form::submit( trans('general.button.create'), ['class' => 'btn btn-primary'] ) !!}
                            <a href="{!! route('admin.suppliers.index') !!}" title="{{ trans('general.button.cancel') }}" class='btn btn-default'>{{ trans('general.button.cancel') }}</a>
                        </div>
                      
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('body_bottom')
    @include('partials.body_bottom_js.supplier_form_js')
@endsection
