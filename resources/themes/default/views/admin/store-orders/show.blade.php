@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Informasi User/Customer</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $order->storeCustomer->user->getFullNameAttribute() }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $order->storeCustomer->user->email }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Informasi Pesanan</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Status</td>
                                <td>{{ $order->getStatusDisplayName() }}</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td>{{ Helpers::reggo($order->total) }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Order</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Pesanan</h3>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->storeOrderDetails as $key => $value)
                            <tr>
                                <td>{{ $value->product->name }}</td>
                                <td>{{ Helpers::reggo($value->price) }}</td>
                                <td>{{ $value->quantity }}</td>
                                <td>{{ Helpers::reggo($value->total) }}</td>
                                <td>{{ $value->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    @if($order->status == 1)
                        <a href="{{ route('admin.store-orders.proccess-order', $order->id) }}" class="btn btn-info">Proses Pesanan</a>
                    @endif
                    <div class="pull-right">
                        <a href="{{ route('admin.store-orders.edit', $order->id) }}" class="btn btn-default"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection