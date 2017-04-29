@extends('layouts.print')

@section('content')

<div id="wrap">
    <table id="allset">
        <tbody>
            <tr>
                <td>
                    <img width="114" vspace="0" hspace="0" height="45" border="0" src="{{ asset('img/logo-new.png') }}"><br>
                </td>
                <td align="center" width="500px">
                    <h1 style="font-size:35px;margin:25px 0;">SPK Offline</h1>
                </td>
            </tr>
        </tbody>
    </table>

    <div class='orchid' id='keterangan' style="margin-bottom:20px">
        <table id="allset">
            <tr>
                <th>No</th>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>:</td>
                <td>{{ $sale->customer->name }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>:</td>
                <td>{{ $sale->customer->laundry_name or '' }} {{ $sale->address }}</td>
            </tr>
            <tr>
                <th>Tanggal Antar / Ambil / Tunggu</th>
                <td>:</td>
                <td>
                    {{ substr($sale->offline_date,0, 10) }}
                </td>
            </tr>
            <tr>
                <th>Jam Antar / Ambil / Tunggu</th>
                <td>:</td>
                <td>
                    {{ substr($sale->offline_date,10, 16) }}
                </td>
            </tr>
        </table>
    </div>

    <div class='orchid' id='mitra'>
        <b>Customer Offline</b>
    </div>

    <table id="allset" >
        <tr class="trhead">
            <th class="bodered" rowspan="2">No</th>
            <th class="bodered" rowspan="2">Nama Produk</th>
            <th class="bodered" rowspan="2">Aroma</th>
            <th class="bodered" rowspan="2">Qty</th>
            @if(Request::is('admin/sales/*/print-off-price'))
            <th class="bodered" rowspan="2">Harga</th>
            <th class="bodered" rowspan="2">Total</th>
            @endif
            <th class="bodered">Kemasan</th>
            <th class="bodered" rowspan="2">QC</th>
            <th class="bodered" rowspan="2">Packing</th>
        </tr>
        <tr>
            <th class="bodered">Ltr/Kg</th>
        </tr>
        <?php
            $no = 1;
            $nom = 0;
            $kg = 0;
            $totj = 0;
        ?>
        @foreach($sale->saleDetails->sortBy('product_id') as $d)
            <?php
                $nom = $nom + $d->total;
                $kg = $kg + $d->weight;
            ?>
            <tr class="trisi">
                <th class="bodered">{{ $no }}</th>
                <td class="bodered">{{ $d->product->name }}</td>
                <td class="bodered">{{ $d->description }}</td>
                <td class="bodered">{{ $d->quantity }}</td>
                @if(Request::is('admin/sales/*/print-off-price'))
                    <td class="bodered">{{ Helpers::reggo($d->price) }}</td>
                    <td class="bodered">{{ Helpers::reggo($d->total) }}</td>
                @endif
                <td class="bodered">{{ $d->keterangan }}</td>
                <td class="bodered"></td>
                <td class="bodered"></td>
                <td >{{ $jer = $d->quantity / 5 }}</td>
            </tr>
            <?php $totj = $totj + $jer;  $no++; ?>
        @endforeach
        @if(Request::is('admin/sales/*/print-off-price'))
        <tr>
            <th class="bodered" colspan="5">Jumlah</th>
            <th class="bodered">{{ Helpers::reggo($sale->nominal) }}</th>
        </tr>
        @endif
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @if(Request::is('admin/sales/*/print-off-price'))
                <td></td>
                <td></td>
            @endif
            <td class="bodered">{{ $totj }}</td>
        </tr>
    </table>
</div>

@endsection
