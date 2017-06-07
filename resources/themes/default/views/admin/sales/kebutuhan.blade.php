@extends('layouts.master')

@section('head_extra')
    <script>
        window.print();
    </script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group" id="accordion">
                        @foreach($data as $datee)
                            @foreach($datee as $product => $saleDetail)
                            <div class="panel box box-{{ isset($saleDetail['materials']) ? 'primary' : 'danger' }}">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $x }}">
                                        {{ $product }} - {{ $saleDetail['estimation'] }}
                                        </a>
                                    </h4>
                                    <div class="pull-right">
                                        <span class="badge">{{ $saleDetail['quantity'] }}</span>
                                    </div>
                                </div>
                                <?php if( isset($saleDetail['materials']) ) : ?>
                                <div id="collapse{{ $x }}" class="panel-collapse collapse">
                                    <div class="box-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('admin/formulas/general.columns.materials') }}</th>
                                                    <th>{{ trans('admin/formulas/general.columns.quantity') }}</th>
                                                    <th>{{ trans('admin/formulas/general.columns.total') }}</th>
                                                </tr>
                                            </thead>
                                            @foreach($saleDetail['materials'] as $type => $val)
                                                <?php
                                                    if ( isset($perDate[$saleDetail['estimation']][$val['material_id']]) ) {
                                                        $perDate[$saleDetail['estimation']][$val['material_id']] += $val['quantity'] * $saleDetail['quantity'];
                                                    } else {
                                                        $perDate[$saleDetail['estimation']][$val['material_id']] = 0 + $val['quantity'] * $saleDetail['quantity'];
                                                    }
                                                ?>
                                                <tr>
                                                    <td>{{ Helpers::getMaterialById($val['material_id'])->name }}</td>
                                                    <td>{{ $val['quantity'] }}</td>
                                                    <td>{{ $val['quantity'] * $saleDetail['quantity'] }}</td>
                                                </tr>
                                            @endforeach
                                            @if( isset($saleDetail['seed']) )
                                            <?php
                                                if ( isset( $totalSeed[$saleDetail['estimation']][$saleDetail['description']] ) ) {
                                                        $totalSeed[$saleDetail['estimation']][$saleDetail['description']] += $saleDetail['seed'] * $saleDetail['quantity'];
                                                    } else {
                                                        $totalSeed[$saleDetail['estimation']][$saleDetail['description']] = 0 + $saleDetail['seed'] * $saleDetail['quantity'];
                                                    }
                                            ?>
                                            <tr>
                                                <td>{{ $saleDetail['description'] }}</td>
                                                <td>{{ $saleDetail['seed'] }}</td>
                                                <td>{{ $saleDetail['seed'] * $saleDetail['quantity'] }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                <?php endif; $x++; ?>
                            </div>
                            @endforeach
                        @endforeach<?php $x = 0; ?>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="create-purchase-order">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Bahan Baku</h3>
                </div>
                <div class="box-body table-responsive">
                    @foreach($perDate as $p => $value)
                    <div class="col-md-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ $p }}</th>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>{{ trans('admin/formulas/general.columns.total') }}</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($value as $t => $v)
                                    <tr>
                                        <td>{{ Helpers::getMaterialById($t)->name }}</td>
                                        <td>{{ $v }}</td>
                                        <td>{{ Helpers::reggo(Helpers::getMaterialById($t)->price * $v) }}</td>
                                    </tr>
                                    <?php
                                        if ( isset($total[Helpers::getMaterialById($t)->name]) ) {
                                            $total[Helpers::getMaterialById($t)->name] += $v;
                                        } else {
                                            $total[Helpers::getMaterialById($t)->name] = 0 + $v;
                                        }
                                    ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                    <div class="col-md-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>{{ trans('admin/formulas/general.columns.total') }}</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($total as $material => $value)
                                    <tr>
                                        <td>{{ $material }}</td>
                                        <td>{{ $value }}</td>
                                        <td>{{ Helpers::getMaterialById($t)->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" id="create-purchase-order">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Bibit</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>{{ trans('admin/formulas/general.columns.total') }}</th>
                                <th>Stok</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalSeed as $u => $dateSeed)
                                <tr>
                                    <th colspan="4" style="text-align:center;">{{ $u }}</th>
                                </tr>
                                @foreach($dateSeed as $name => $value)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>{{ $value }}</td>
                                    <td>{{ Helpers::getMaterialByName($name)->seedMaterial->stock }}</td>
                                    <td id="harga{{$x}}">{{ Helpers::reggo(Helpers::getMaterialByName($name)->price) }}</td>
                                </tr>
                                <?php $x++ ?>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection