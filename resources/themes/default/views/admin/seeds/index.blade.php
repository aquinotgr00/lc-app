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
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/products/general.page.index.categories') }}</h3>
                    <div class="box-tools">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active">
                            <a href="#">
                                Bibit Parfum
                            </a>
                        </li>
                        <li>
                            <a href="/admin/products/other-material">
                                Lain - lain
                            </a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div><!-- /.col -->

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-hover table-striped">
                        <thead>
                            <th>Nama</th>
                            <th>Harga 1 liter</th>
                            <th>Harga 600 ml</th>
                            <th>Harga 100 ml</th>
                            <th>Aksi</th>
                        </thead>
                        <tfoot>
                            <th>Nama</th>
                            <th>Harga 1 liter</th>
                            <th>Harga 600 ml</th>
                            <th>Harga 100 ml</th>
                            <th>Aksi</th>
                        </tfoot>
                        <tbody>
                            @foreach($seeds as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ Helpers::reggo($p->seed->price_1) }}</td>
                                    <td>{{ Helpers::reggo($p->seed->price_2) }}</td>
                                    <td>{{ Helpers::reggo($p->seed->price_3) }}</td>
                                    <td>
                                        <a href="{{ route('admin.seeds.edit', $p->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
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
@endsection