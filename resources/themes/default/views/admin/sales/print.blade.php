@extends('layouts.print')

@section('content')

<div id="wrap">
	<table id="allset">
		<tbody>
			<tr>
				<td align="center">
					<p>
						<img width="219" vspace="0" hspace="0" height="90" border="0" src="{{ asset('img/logo-new.png') }}"><br>
					</p>
				</td>
				<td align="center">
					<p>
						<font size="5">OrchiD BranD</font><br>
						<font size="4"><b>Laundry CleaniQue</b></font><br>
						<font size="2">Kantor: Jl. Palagan Tentara Pelajar KM. 9, Sleman - Yogyakarta</font><br>
						<font size="2">Telp.(0274) 283-0339</font><br>
						<font size="3">www.BisnisLaundryKiloan.com - www.PeluangUsahaLaundry.com&nbsp;</font>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<hr width="100%" align="left" />
	<div class="orchid" id="keterangan">

		<table id="allset" >
			<tr>
				<th>No</th>
				<td>:</td>
				<td>PO-{{ $sale->customer->id.'-'.$sale->id.'-'. date("d-m-Y", strtotime($sale->order_date)) }}</td>
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
				<th>Telepon</th>
				<td>:</td>
				<td>{{ $sale->phone }}</td>
			</tr>
			<tr>
				<th>Tanggal Order</th>
				<td>:</td>
				<td>{{ date('l, d F Y', strtotime($sale->order_date)) }}</td>
			</tr>
			<tr>
				<th>Tanggal Transfer</th>
				<td>:</td>
				<td>
					@if($sale->transfer_date == '0000-00-00' || $sale->transfer_date == null)
						{{''}}
					@else
						{{ date('l, d F Y', strtotime($sale->transfer_date))}}
					@endif
				</td>
			</tr>
			<tr>
				<th>Tanggal Estimasi</th>
				<td>:</td>
				<td>
					@if($sale->estimation_date == '0000-00-00')
						{{''}}
					@else
						{{$sale->estimation_date}}
					@endif
				</td>
			</tr>
			<tr>
				<th>Transfer Via</th>
				<td>:</td>
				<td>{{ $sale->transfer_via }}</td>
			</tr>
			<tr>
				<th>Tanggal Kirim</th>
				<td>:</td>
				<td>
					@if($sale->ship_date == '0000-00-00')
						{{''}}
					@else
						{{$sale->ship_date}}
					@endif
				</td>
			</tr>
			<tr>
				<th>Nomer Resi</th>
				<td>:</td>
				<td>{{ $sale->resi }}</td>
			</tr>
		</table>
	</div>

	<div class='orchid' id='mitra'>
		<b>{{ $sale->customer->getCustomerTypeDisplayName() }}</b>
	</div>

	<table id="allset" >
		<tr class="trhead">
			<th class="bodered">No</th>
			<th class="bodered">Nama Produk</th>
			<th class="bodered">Aroma</th>
			<th class="bodered">Harga</th>
			<th class="bodered">QTY</th>
			<th class="bodered">Total</th>
			<th class="bodered">Berat</th>
			<th class="bodered">Ket</th>
			<th class="bodered">QC</th>
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
			<td class="bodered">{{ Helpers::reggo($d->price) }}</td>
			<td class="bodered">{{ $d->quantity }}</td>
			<td class="bodered">{{ Helpers::reggo($d->total) }}</td>
			<td class="bodered">{{ $d->weight }} Kg</td>
			<td class="bodered">{{ $d->keterangan }}</td>
			<td class="bodered" width="3%"></td>
			<td >{{ $jer = $d->quantity / 5 }}</td>
		</tr>
		<?php $totj = $totj + $jer;  $no++; ?>
		@endforeach
		<tr class="trisi">
			<td class="bodered" colspan="2">Berat Kemasan</td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<th class="bodered">{{ $kg }} Kg</th>
		</tr>
		<tr class="trisi">
			<td class="bodered" colspan="2">Berat Packing</td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<td class="bodered"></td>
			<th class="bodered">{{$kg/40}} Kg</th>
		</tr>
		<tr>
			<th colspan=5 class="bodered">Jumlah</th>
			<th class="bodered">{{ Helpers::reggo($nom) }}</th>
			<th class="bodered">{{$kg+($kg/40)}} Kg</th>
			<td></td>
			<td></td>
			<th class="bodered">{{ $totj }}</th>
		</tr>
	</table>
	<div id='ket'>
		<div class='kiri'>
			Ongkir
		</div><div class='tengah'>
			{{ Helpers::reggo($sale->shipping_fee) }}
		</div>
		<div class='kanan' id='ekspedisi'>
			<b>{{ $sale->expedition }}</b>
		</div>
		<div class='clearboth'></div>
		<div class='kiri'>
			Packing Kayu
		</div>
		<div class='tengah'>
			{{ Helpers::reggo($sale->packing_fee) }}
		</div>
		<div class='clearboth'></div>
		<div class='kiri'>
			Diskon
		</div>
		<div class='tengah'>
			{{ $sale->discount }}%
		</div>
		<div class='clearboth'></div>
		<div class='kiri'>
			Total
		</div>
		<div class='tengah'>
		<?php $potongan = round($sale->discount/100*$nom); ?>
			<b>{{ Helpers::reggo($nom-$potongan + $sale->shipping_fee + $sale->packing_fee) }}</b>
		</div>
		<div class='clearboth'></div>
		<div class='kiri'>
			Catatan
		</div>
		<div class='tengah'>
			<b><pre>{!! nl2br($sale->note) !!}</pre></b>
		</div>
		<div class='clearboth'></div>
		<div class='kiri'>
			Keterangan
		</div>
		<div class='tengah' id="ketnya">
			<b>{!! nl2br($sale->description) !!}</b>
		</div>
		<div class='clearboth'></div>
	</div>
</div>

@endsection
