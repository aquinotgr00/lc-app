<html>
  <tr>
    <!-- Colspan -->
    <th colspan="11" align="center">
      Perincian Orderan Orchid Chemical Laundry Yogyakarta
    </th>
  </tr>
  <tr><td colspan="11"></td></tr>
  <tr>
    <td></td>
    <th>Customer</th>
    <td colspan="5"> {{ $customer->name }}</td>
    <td align="center" style="border:solid medium #000;">{{ $customer->getCustomerTypeDisplayName() }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Alamat</b></td>
    <td colspan="5"> {{ $sale->address }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Telepon</b></td>
    <td colspan="5"> {{ $sale->phone }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Tanggal Order</b></td>
    <td colspan="5"> {{ Helpers::date($sale->order_date) }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Tanggal Transfer</b></td>
    <td colspan="5"> {{ ($sale->transfer_date == '0000-00-00' || $sale->transfer_date == null) ? '' : Helpers::date($sale->transfer_date) }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Transfer Via</b></td>
    <td colspan="5"> {{ $sale->transfer_via }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Tanggal Kirim</b></td>
    <td colspan="5"> {{ ($sale->ship_date == '0000-00-00' || $sale->ship_date == null) ? '' : Helpers::date($sale->ship_date) }}</td>
  </tr>
  <tr>
    <td></td>
    <td><b>Tanggal Estimasi</b></td>
    <td colspan="5">
      {{ ($sale->estimation_date == '0000-00-00' || $sale->estimation_date == null) ? '' : Helpers::date($sale->estimation_date) }}
    </td>
  </tr>
  <tr>
    <td></td>
    <td><b>Nomer Resi</b></td>
    <td colspan="5"> {{ $sale->resi }}</td>
  </tr>
  <tr><td colspan="11"></td></tr>
  <table style="border:2px solid #000000">
    <tr>
      <th align="center" style="border:1px solid #000000;">No</th>
      <th align="center" style="border:1px solid #000000;">Nama Produk</th>
      <th align="center" style="border:1px solid #000000;">Aroma</th>
      <th align="center" style="border:1px solid #000000;">Harga</th>
      <th align="center" style="border:1px solid #000000;">Keterangan</th>
      <th align="center" style="border:1px solid #000000;">Qty Order</th>
      <th align="center" style="border:1px solid #000000;">Jumlah</th>
      <th align="center" style="border:1px solid #000000;">Berat</th>
      <th align="center" style="border:1px solid #000000;">QC</th>
      <th align="center" style="border:1px solid #000000;">Packing</th>
    </tr>
    <?php
      $no   = 1;
      $nom  = 0;
      $kg   = 0;
      $totj = 0;
      foreach($details as $key => $row){
        $nom = $nom + $row['total'];
        $kg  = $kg + $row['weight'];
    ?>
    <tr>
      <th align="center" style="border:1px solid #000000;">{{ $no }}</th>
      <td style="border:1px solid #000000;">{{ $row->product->name }}</td>
      <td style="border:1px solid #000000;">{{ $row->description }}</td>
      <td style="border:1px solid #000000;">{{ Helpers::reggo($row->price) }}</td>
      <td style="border:1px solid #000000;">{{ $row->keterangan }} Kg</td>
      <td style="border:1px solid #000000;">{{ $row->quantity }}</td>
      <td style="border:1px solid #000000;">{{ Helpers::reggo($row->total) }}</td>
      <td style="border:1px solid #000000;">{{ $row->weight }} Kg</td>
      <td style="border:1px solid #000000;"></td>
      <td style="border:1px solid #000000;"></td>
      <td>{{ $jer = $row->quantity/5 }}</td>
    </tr>
    <?php $totj = $totj + $jer; $no++; }?>
    <tr>
      <td colspan="7" style="border:1px solid #000000;">Berat Kemasan</td>
      <th style="border:1px solid #000000;">{{ $kg }} Kg</th>
    </tr>
    <tr>
      <td colspan="7" style="border:1px solid #000000;">Berat Packing</td>
      <th style="border:1px solid #000000;">{{ $kg/40 }} Kg</th>
    </tr>
    <tr>
      <td align="center" colspan="6" style="border:1px solid #000000;">Jumlah</td>
      <td style="border:1px solid #000000;">{{ Helpers::reggo($nom) }}</td>
      <td style="border:1px solid #000000;">{{ $kg+($kg/40) }} Kg</td>
      <td></td>
      <td></td>
      <td>{{ $totj }}</td>
    </tr>
  </table>
  <table style="font:10pt;">
    <tr>
      <td></td>
      <td>Ongkir</td>
      <td colspan="5">{{ Helpers::reggo($sale->shipping_fee) }}</td>
      <td align="center" style="border:solid medium #000000;">{{ $sale->expedition }}</td>
    </tr>
    <tr>
      <td></td>
      <td>Packing Kayu</td>
      <td colspan="5">{{ $sale->packing_fee }}</td>
    </tr>
    <tr>
      <td></td>
      <td>Diskon</td>
      <td colspan="5">{{ $sale->discount }} %</td>
    </tr>
    <tr>
      <td></td>
      <td>TOTAL</td>
	    <?php $potongan = round($sale->discount/100*$nom); ?>
      <td colspan="5">{{ Helpers::reggo(($nom-$potongan) + $sale->shipping_fee + $sale->packing_fee) }}</td>
    </tr>
    <tr>
      <td></td>
      <td>Keterangan :</td>
      <td colspan="6">{{ $sale->description }}</td>
    </tr>
  </table>
</html>
