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
                    <h3 class="box-title">{{ trans('admin/expeditions/general.page.index.table-title') }}</h3>
                    &nbsp;
                    <a class="btn btn-default btn-sm" href="{!! route('admin.expeditions.create') !!}" title="{{ trans('admin/expeditions/general.button.create') }}">
                        <i class="fa fa-plus-square"></i>
                    </a>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <!-- <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th> -->
                                    <th>{{ trans('admin/expeditions/general.columns.name') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.contact') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.description') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <!-- <th style="text-align: center">
                                        <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                            <i class="fa fa-check-square-o"></i>
                                        </a>
                                    </th> -->
                                    <th>{{ trans('admin/expeditions/general.columns.name') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.contact') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.description') }}</th>
                                    <th>{{ trans('admin/expeditions/general.columns.actions') }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($expeditions as $e)
                                <tr>
                                    <!-- <td align="center">
                                        {!! Form::checkbox('chkUser[]', $e->id); !!}
                                    </td> -->
                                    <td>{!! link_to_route('admin.expeditions.edit', $e->name, [$e->id], []) !!}</td>
                                    <td>{{ $e->contact }}</td>
                                    <td>{{ $e->description }}</td>
                                    <td>
                                        <a href="{!! route('admin.expeditions.confirm-delete', $e->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
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
    <!-- DataTables -->
    <script src="{{ asset('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script language="JavaScript">
        $('#example2').DataTable({
            "order"   : [[ 0, 'desc' ]],
            "ordering": false
        });
    </script>
@endsection
