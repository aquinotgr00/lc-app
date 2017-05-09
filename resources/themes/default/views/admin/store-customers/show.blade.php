@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset("/bower_components/admin-lte/dist/img/generic_user_160x160.jpg") }}" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $customer->user->first_name .' '. $customer->user->last_name }}</h3>
                    <p class="text-muted text-center">{{ $customer->user->username }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"> {{ $customer->user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Telpon</b> <a class="pull-right">{{ $customer->phone }}</a>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><b> Delete </b></a>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Affiliator</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-link margin-r-5"></i>  Alamat</strong>
                    <p class="text-muted">
                        {{ $customer->address }}
                    </p>
                    <hr>
                    <strong><i class="fa fa-money margin-r-5"></i> Alamat Lain</strong>
                    <p class="text-muted">{{ $customer->ship_address }}</p>
                    <hr>
                    <strong><i class="fa fa-money margin-r-5"></i>Terdaftar</strong>
                    <p class="text-muted">{{ $customer->created_at }}</p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#firsttab" data-toggle="tab">Order History</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th>{{ trans('admin/customers/followup.columns.created') }}</th>
                                  <th>Total</th>
                                  <th>Status</th>
                                  <th>{{ trans('admin/customers/followup.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $key => $value)
                                <tr>
                                    <td>{!! link_to_route('admin.store-orders.show', date('d F, Y', strtotime($value->created_at)), $value->id) !!}</td>
                                    <td>{{ Helpers::reggo($value->total) }}</td>
                                    <td>{{ $value->getStatusDisplayName() }}</td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable text-red"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.tab-pane -->
                </div>
            </div>
        </div>
    </div>

@endsection