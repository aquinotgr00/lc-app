@extends('layouts.master')

@section('head_extra')
    <!-- autocomplete ui -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- autocomplete loading gif -->
    <style>
        input.ui-autocomplete-loading { background:url('http://preloaders.net/preloaders/712/Floating%20rays-16.gif') no-repeat right center }
    </style>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')

	<div class="row">
		@if(!is_null($parent))
        <div class="col-md-3">
            {!! link_to('admin/products/create', trans('admin/products/general.button.create'), ['class' => 'btn btn-primary btn-block margin-bottom']); !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/products/general.page.index.categories') }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                    	@foreach($parent->getDescendants() as $descendant)
							<li class="{{ $slug == $descendant->slug ? 'active':'' }}">
								<a href="{{ route('admin.products.index-category', $descendant->slug) }}">
									{{ $descendant->name }}
								</a>
							</li>
						@endforeach
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/products/general.page.index.price-list') }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{url('admin/priceList/1')}}"><i class="fa fa-circle-o text-red"></i> Price List Agen Resmi</a></li>
                        <li><a href="{{url('admin/priceList/2')}}"><i class="fa fa-circle-o text-yellow"></i> Price List Agen Lepas</a></li>
                        <li><a href="{{url('admin/priceList/3')}}"><i class="fa fa-circle-o text-light-blue"></i> Price List Customer</a></li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        @endif

        <div class="{{ isset($parent) ? 'col-md-9':'col-md-12' }}">
            <div class="box box-primary">

                <div class="box-body table-responsive">
                        <table id="example2" class="table table-hover table-striped">
                            <thead>
                                <th>{{ trans('admin/products/general.columns.name') }}</th>
                                <th>{{ trans('admin/products/general.columns.hpp') }}</th>
                                <th>{{ trans('admin/products/general.columns.agenresmi_price') }}</th>
                                <th>{{ trans('admin/products/general.columns.agenlepas_price') }}</th>
                                <th>{{ trans('admin/products/general.columns.price') }}</th>
                                <th>{{ trans('admin/products/general.columns.stock') }}</th>
                                <th>{{ trans('admin/products/general.columns.actions') }}</th>
                            </thead>
                            <tfoot>
                                <th>{{ trans('admin/products/general.columns.name') }}</th>
                                <th>{{ trans('admin/products/general.columns.hpp') }}</th>
                                <th>{{ trans('admin/products/general.columns.agenresmi_price') }}</th>
                                <th>{{ trans('admin/products/general.columns.agenlepas_price') }}</th>
                                <th>{{ trans('admin/products/general.columns.price') }}</th>
                                <th>{{ trans('admin/products/general.columns.stock') }}</th>
                                <th>{{ trans('admin/products/general.columns.actions') }}</th>
                            </tfoot>
                            <tbody>
                                @foreach($products as $p)
                                <tr>
                                    <td>{!! link_to_route('admin.products.edit', $p->name, $p->id) !!}</a></td>
                                    <td>{{ Helpers::reggo($p->hpp) }}</td>
                                    <td>{{ Helpers::reggo($p->agenresmi_price) }}</td>
                                    <td>{{ Helpers::reggo($p->agenlepas_price) }}</td>
                                    <td>{{ Helpers::reggo($p->price) }}</td>
                                    <td>
                                        {{-- {{ Form::select('stok', $stok, $p->stok, ['class'=>'form-control input-sm stok', 'id'=>$p->id, 'data-token'=>csrf_token()]) }} --}}
                                        {{ $p->stock }}
                                    </td>
                                    <td>
                                        <a href="{!! route('admin.products.confirm-delete', $p->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- /.table -->
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div><!-- /.col -->
    </div>

@endsection

@section('body_bottom')
    <!-- autocomplete UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <!-- DataTables -->
    <script src="{{ asset('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(document).ready(function(){
            $('#search').autocomplete({
                source: '/admin/products/getInfo',
                minLength: 3,
                autoFocus: true,
                select:function(e,ui){
                    window.location = '/admin/products/'+ui.item.id+'/edit'
                }
            });

            $('#example2').DataTable({
                "order"   : [[ 0, 'asc' ]],
		        "lengthMenu": [
		            [10, 25, 50, -1],
		            [10, 25, 50, "All"]
		        ],
		        responsive: true,
		        language: {
		            search: "_INPUT_",
		            searchPlaceholder: "Search",
		        }
            });
        });
    </script>
@stop