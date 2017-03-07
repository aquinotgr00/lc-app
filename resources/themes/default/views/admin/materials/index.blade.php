@extends('layouts.master')

@section('head_extra')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            {!! link_to('admin/materials/create', 'Tambah Bahan', ['class' => 'btn btn-primary btn-block margin-bottom']); !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/products/general.page.index.categories') }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="{{ isset($seed) ? '':'active' }}">
                            <a href="{{ route('admin.materials.index') }}">
                                Bahan
                            </a>
                        </li>
                        <li class="{{ isset($seed) ? 'active':'' }}">
                            <a href="{{ route('admin.materials.index-seed') }}">
                                Bibit
                            </a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div>
        <div class="col-md-9">
            {!! Form::open( array('route' => 'admin.materials.order-selected', 'id' => 'frmMaterialList') ) !!}
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('admin/materials/general.page.index.title') }}</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('admin/materials/general.columns.name') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.price') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.stock') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.min_stock') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th>
                                    <th>{{ trans('admin/materials/general.columns.name') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.price') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.stock') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.min_stock') }}</th>
                                    <th>{{ trans('admin/materials/general.columns.actions') }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($materials as $material)
                                <tr>
                                    <td align="center">
                                        {!! Form::checkbox('chkMaterial[]', $material->id); !!}
                                    </td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ Helpers::reggo($material->price) }}</td>
                                    <td>{{ $material->stock }}</td>
                                    <td>{{ $material->min_stock }}</td>
                                    <td>
                                        <a href="{!! route('admin.materials.edit', $material->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="{!! route('admin.materials.confirm-delete', $material->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('body_bottom')
    @include('partials.body_bottom_js.datatable_js')

    <script type="text/javascript">
        function toggleCheckbox() {
            checkboxes = document.getElementsByName('chkMaterial[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }
        $(document).ready(function() {
            $('#example2').DataTable({
                'order': [[1, 'asc']]
            });
        });
    </script>
@endsection