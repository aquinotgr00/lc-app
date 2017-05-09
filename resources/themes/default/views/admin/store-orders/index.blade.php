@extends('layouts.master')

@section('head_extra')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')

	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                	<h3 class="box-title">List Pesanan</h3>
                </div>
                <div class="box-body">
                	<div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover">
                        	<thead>
                        		<tr>
                        			<th>Nama</th>
                        			<th>Total</th>
                        			<th>Status</th>
                        			<th>Dibuat</th>
                        			<th>Aksi</th>
                        		</tr>
                        	</thead>
                        	<tfoot>
                        		<tr>
                        			<th>Nama</th>
                        			<th>Total</th>
                        			<th>Status</th>
                        			<th>Dibuat</th>
                        			<th>Aksi</th>
                        		</tr>
                        	</tfoot>
                        	<tbody id="content">
                        		@foreach($orders as $value)
                        		<tr>
                        			<td>{!! link_to_route('admin.store-orders.show', $value->storeCustomer->name(), $value->id) !!}</td>
                        			<td>{{ Helpers::reggo($value->total) }}</td>
                        			<td>{{ $value->getStatusDisplayName() }}</td>
                        			<td>{{ date('l, d F Y', strtotime($value->created_at)) }}</td>
                        			<td>
                                        <a href="{!! route('admin.store-orders.confirm-delete', $value->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable text-red"></i></a>
                                    </td>
                        		</tr>
                        		@endforeach
                        	</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('body_bottom')
    <!-- Datatable -->
    @include('partials.body_bottom_js.datatable_js')

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example2').DataTable({
                "ordering": false
            });
        });
    </script>
@endsection