<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_details" data-toggle="tab" aria-expanded="true">{!! trans('general.tabs.customers') !!}</a></li>
        <li class=""><a href="#tab_options" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.details') !!}</a></li>
        <li class=""><a href="#tab_roles" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.items') !!}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_details">
            <div class="form-group">
                {!! Form::label('typee', 'Tipe PO') !!}
                {!! Form::select('type', [1 => 'online', 2 => 'offline'], null, ['class' => 'form-control', 'id' => 'type-po', isset($sale) ? 'disabled':'']) !!}
            </div>

            <div class="form-group">
                {!! Form::hidden('customer_id', null, ['id' => 'customer_id']) !!}
                {!! Form::label('name', trans('admin/customers/general.columns.name')) !!}
                @if( isset($sale) )
                    {!! Form::text('name', $sale->customer->name, ['class' => 'form-control', 'disabled']) !!}
                @else
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'customer_name']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('type', 'Customer Type') !!}
                @if( isset($sale) )
                    {!! Form::select('cust_type', config('constant.customer-types'), $sale->customer->type, ['class' => 'form-control type', 'disabled', 'id' => 'type']) !!}
                @else
                    {!! Form::select('cust_type', config('constant.customer-types'), null, ['class' => 'form-control type', 'id' => 'type']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('phone', trans('admin/customers/general.columns.phone')) !!}
                @if( isset($sale) )
                    {!! Form::text('phone', $sale->phone, ['class' => 'form-control phone']) !!}
                @else
                    {!! Form::text('phone', null, ['class' => 'form-control phone']) !!}
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('address', trans('admin/customers/general.columns.address')) !!}
                @if( isset($sale) )
                    {!! Form::textarea('address', $sale->address, ['class' => 'form-control', 'id' => 'base-address', 'rows' => 3]) !!}
                @else
                    {!! Form::text('address', null, ['class' => 'form-control', 'id' => 'base-address']) !!}
                    {!! Form::select('address-2', ['default'=>'choose address'], null, ['class' => 'form-control', 'id' => 'sec-address']) !!}
                @endif
            </div>
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab_options">
            <div class="form-group">
                {!! Form::label('order_date', trans('admin/sales/general.columns.order_date')) !!}
                {!! Form::text('order_date', null, ['class' => 'form-control date']) !!}
            </div>

            <div class="form-group" id="type-po-div">
                {!! Form::label('offline_date', 'Tanggal dan Jam Tunggu') !!}
                {!! Form::text('offline_date', null, ['class' => isset($sale) ? 'form-control' : 'form-control dateNTime', 'id' => 'dateNTime', 'disabled']) !!}
            </div>
            
            <div id="onlineTab">
                <div class="form-group">
                    {!! Form::label('transfer_date', trans('admin/sales/general.columns.transfer_date')) !!}
                    {!! Form::text('transfer_date', null, ['class' => 'form-control date']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('ship_date', trans('admin/sales/general.columns.ship_date')) !!}
                    {!! Form::text('ship_date', null, ['class' => 'form-control date']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('estimation_date', trans('admin/sales/general.columns.estimation_date')) !!}
                    {!! Form::text('estimation_date', null, ['class' => 'form-control date']) !!}
                </div>

                <div class="form-group select2-bootstrap-append">
                    {!! Form::label('transfer_via', trans('admin/sales/general.columns.transfer_via')) !!}
                    {!! Form::select('transfer_via', config('constant.banks'), null, ['class' => 'form-control', 'id' => 'bank', 'style' => "width: 100%"]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('shipping_fee', trans('admin/sales/general.columns.shipping_fee')) !!}
                    {!! Form::text('shipping_fee', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('packing_fee', trans('admin/sales/general.columns.packing_fee')) !!}
                    {!! Form::text('packing_fee', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('resi', trans('admin/sales/general.columns.resi')) !!}
                    {!! Form::text('resi', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('expedition', trans('admin/sales/general.columns.expedition')) !!}
                    {!! Form::text('expedition', null, ['class' => 'form-control', 'id' => 'expedition']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('discount', trans('admin/sales/general.columns.discount')) !!}
                    {!! Form::text('discount', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('description', trans('admin/sales/general.columns.description')) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('note', 'Catatan') !!}
                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => '3']) !!}
            </div>
        </div><!-- /.tab-pane -->

        <div class="tab-pane" id="tab_roles">
            <div class='ketPenjualan col-lg-5"'>
                {{ trans('admin/sales/detail.columns.weight') }} : <span class='weightTotal'>0</span>
            </div><div class='ketPenjualan col-lg-5"'>
                Jerigen : <span class='totalJer'>0</span>
            </div>

            <div class="myForm" id="online">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('admin/sales/detail.columns.name') }}</th>
                            <th>{{ trans('admin/sales/detail.columns.description') }}</th>
                            <th>{{ trans('admin/sales/detail.columns.price') }}</th>
                            <th>{{ trans('admin/sales/detail.columns.quantity') }}</th>
                            <th>{{ trans('admin/sales/detail.columns.total') }}</th>
                            <th>{{ trans('admin/sales/detail.columns.weight') }}</th>
			                <th>Keterangan</th>
                            <th colspan="2" style="text-align: center;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( isset($sale) && $sale->type == 1 )
                            <?php $no = 1; ?>
                            @foreach( $sale->saleDetails as $key => $d )
                                <tr id="row{{ $d->id }}">
                                    <td>{{ $no }}</td>
                                        {!! Form::hidden('item['. $key .'][id]', $d->id) !!}
                                        {!! Form::hidden('item['. $key .'][product_id]', $d->product_id, ['id' => 'productName'. $no .'']) !!}
                                        {!! Form::hidden('baseWeight', $d->product->weight, ['id' => 'baseWeight'.$no.'']) !!}
                                    <td>
                                        {!! Form::text('productName', $d->product->name, ['id' => 'product'. $no .'', 'placeholder' => 'nama', 'class' => 'form-control product']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $key .'][description]', $d->description, ['placeholder' => 'description', 'class' => 'aroma form-control', 'id' => 'aroma'. $key .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $key .'][price]', $d->price, ['id' => 'price'. $no .'']) !!}
                                        @if($d->product->category_id == 10 && $d->product->seed)
                                            {!! Form::select('selectPrice',
                                                [   // if there's 2 same value. the last is the one that will be used, since the value must be unique.
                                                    $d->product->price         => '1 liter',
                                                    $d->product->seed->price_1 => '500 ml',
                                                    $d->product->seed->price_2 => '250 ml',
                                                    $d->product->seed->price_3 => '100 ml'
                                                ], $d->price, ['id' => 'selectPrice'.$no.'', 'class' => 'form-control selectt'])
                                            !!}
                                        @else
                                            {!! Form::text('price', $d->price, ['placeholder' => 'price', 'class' => 'form-control', 'id' => 'displayPrice'. $no .'', 'disabled']) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $key .'][quantity]', $d->quantity, ['placeholder' => 'quantity', 'class' => 'form-control Qty','id' => 'Qty'. $no .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $key .'][total]', $d->total, ['id' => 'total'. $no .'']) !!}
                                        {!! Form::text('total', $d->total, ['placeholder' => 'total', 'class' => 'form-control', 'id' => 'displayTotal'. $no .'', 'disabled']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $key .'][weight]', $d->weight, ['id' => 'weight'. $no .'']) !!}
                                        {!! Form::text('weight', $d->weight, ['placeholder' => 'weight', 'class' => 'form-control sumWeight', 'id' => 'displayWeight'. $no .'', 'disabled']) !!}
                                    </td>
                				    <td>
                					{!! Form::text('item['. $key .'][keterangan]', $d->keterangan, ['class' => 'form-control', 'id' => 'ket'.$no.'']) !!}
                				    </td>
                                    <td id='jer{{$key}}' class='qtyJer' value=''>
                                        0
                                    </td>
                                    <td>
                                        <a class="delete" token="{{ csrf_token() }}" data-id='{{ $d->id }}'><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                            @for($x = $no; $x <=100; $x++)
                                <tr>
                                    <td>
                                        {!! $x !!}
                                        {!! Form::hidden('item['. $x .'][product_id]', '', ['id' => 'productName'. $x .'']) !!}
                                        {!! Form::hidden('baseWeight', '', ['id' => 'baseWeight'.$x.'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('productName', '', ['id' => 'product'. $x .'', 'placeholder' => 'nama', 'class' => 'form-control product']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('item['. $x .'][description]', '', ['placeholder' => 'description', 'class' => 'aroma form-control', 'id' => 'aroma'. $x .'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][price]', '', ['id' => 'price'. $x .'']) !!}
                                        {!! Form::select('selectPrice', [], '', ['id' => 'selectPrice'.$x.'', 'class' => 'form-control selectt', 'style' => 'display:none;']) !!}
                                        {!! Form::text('price', '', ['placeholder' => 'price', 'class' => 'form-control', 'id' => 'displayPrice'. $x .'', 'disabled']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('item['. $x .'][quantity]', '', ['placeholder' => 'quantity', 'class' => 'form-control Qty', 'id' => 'Qty'. $x .'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][total]', '', ['id' => 'total'. $x .'']) !!}
                                        {!! Form::text('total', '', ['placeholder' => 'total', 'class' => 'form-control', 'id' => 'displayTotal'. $x .'', 'disabled']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][weight]', '', ['id' => 'weight'. $x .'']) !!}
                                        {!! Form::text('weight', '', ['placeholder' => 'weight', 'class' => 'form-control sumWeight', 'id' => 'displayWeight'. $x .'', 'disabled']) !!}
                                    </td>

                				    <td>
                					{!! Form::text('item['. $x .'][keterangan]', '', ['placeholder' => 'keterangan', 'class' => 'form-control', 'id' => 'ket'.$x.'']) !!}
                				    </td>

                                    <td id='jer{{$x}}' class='qtyJer' value='' colspan="2" style="text-align: center;">
                                        0
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @for($x = 1; $x <=100; $x++)
                                <tr class="onlineRow">
                                    <td>
                                        {!! $x !!}
                                        {!! Form::hidden('item['. $x .'][product_id]', '', ['id' => 'productName'. $x .'']) !!}
                                        {!! Form::hidden('baseWeight', '', ['id' => 'baseWeight'.$x.'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('productName', '', ['id' => 'product'. $x .'', 'placeholder' => 'nama', 'class' => 'form-control product']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('item['. $x .'][description]', '', ['placeholder' => 'deskripsi', 'class' => 'aroma form-control', 'id' => 'aroma'. $x .'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][price]', '', ['id' => 'price'. $x .'']) !!}
                                        {!! Form::select('selectPrice', [], '', ['id' => 'selectPrice'.$x.'', 'class' => 'form-control selectt', 'style' => 'display:none;']) !!}
                                        {!! Form::select('selectPriceOffline', [], '', ['id' => 'selectPriceOffline'.$x.'', 'class' => 'form-control selectOffline', 'style' => 'display:none;']) !!}
                                        {!! Form::text('price', '', ['placeholder' => 'harga', 'class' => 'form-control', 'id' => 'displayPrice'. $x .'', 'disabled']) !!}
                                    </td>

                                    <td>
                                        {!! Form::text('item['. $x .'][quantity]', '', ['placeholder' => 'jumlah', 'class' => 'form-control Qty', 'id' => 'Qty'. $x .'']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][total]', '', ['id' => 'total'. $x .'']) !!}
                                        {!! Form::text('total', '', ['placeholder' => 'total', 'class' => 'form-control', 'id' => 'displayTotal'. $x .'', 'disabled']) !!}
                                    </td>

                                    <td>
                                        {!! Form::hidden('item['. $x .'][weight]', '', ['id' => 'weight'. $x .'']) !!}
                                        {!! Form::text('weight', '', ['placeholder' => 'berat', 'class' => 'form-control sumWeight', 'id' => 'displayWeight'. $x .'', 'disabled']) !!}
                                    </td>

                				    <td>
                    					{!! Form::text('item['. $x .'][keterangan]', '', ['placeholder' => 'keterangan', 'class' => 'form-control', 'id' => 'ket'.$x.'']) !!}
                				    </td>

                                    <td id='jer{{$x}}' class='qtyJer' value='' colspan="2" style="text-align: center;">
                                        0
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="myForm" id="offline" style="display:none;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Aroma</th>
                            <th>Harga</th>
                            <th>Kemasan</th>
                            <th>QTY</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if( isset($sale) && $sale->type == 2 )
                            <?php $no = 1; ?>
                            @foreach($sale->saleDetails as $key => $value)
                                <tr>
                                    <td>
                                        {!! $no !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('baseWeight', $value->product->weight, ['id' => 'baseWeight'. $no .'']) !!}
                                        {!! Form::hidden('item['. $no .'][product_id]', $value->product_id, ['id' => 'productName'. $no .'']) !!}
                                        {!! Form::text('productName', $value->product->name, ['class' => 'form-control product', 'id' => 'product'. $no .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $no .'][description]', $value->description, ['class' => 'form-control aroma', 'id' => 'aroma'. $no .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $no .'][price]', $value->price, ['id' => 'price'. $no .'']) !!}
                                        {!! Form::hidden('item['. $no .'][total]', $value->total, ['id' => 'total'. $no .'']) !!}
                                        {!! Form::text('price', $value->price, ['class' => 'form-control', 'id' => 'displayPrice'. $no .'', 'disabled']) !!}
                                        {!! Form::select('selectPrice', [], '', ['id' => 'selectPrice'.$no.'', 'class' => 'form-control selectt', 'style' => 'display:none;']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $no .'][keterangan]', $value->keterangan, ['class' => 'form-control', 'id' => 'ket'.$no.'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $no .'][quantity]', $value->quantity, ['class' => 'form-control Qty', 'id' => 'Qty'. $no .'']) !!}
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            @endforeach
                            @for($x = $no; $x < 50; $x++)
                                <tr>
                                    <td>
                                        {!! $x !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('baseWeight', '', ['id' => 'baseWeight'. $x .'']) !!}
                                        {!! Form::hidden('item['. $x .'][product_id]', '', ['id' => 'productName'. $x .'']) !!}
                                        {!! Form::text('productName', '', ['placeholder' => 'nama', 'class' => 'form-control product', 'id' => 'product'. $x .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][description]', '', ['placeholder' => 'aroma', 'class' => 'aroma form-control', 'id' => 'aroma'. $x .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $x .'][price]', '', ['id' => 'price'. $x .'']) !!}
                                        {!! Form::hidden('item['. $x .'][total]', '', ['id' => 'total'. $x .'']) !!}
                                        {!! Form::text('price', '', ['placeholder' => 'price', 'class' => 'form-control', 'id' => 'displayPrice'. $x .'', 'disabled']) !!}
                                        {!! Form::select('selectPrice', [], '', ['id' => 'selectPrice'.$x.'', 'class' => 'form-control selectt', 'style' => 'display:none;']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][keterangan]', '', ['placeholder' => 'kemasan', 'class' => 'form-control', 'id' => 'ket'.$x.'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][quantity]', '', ['placeholder' => 'jumlah', 'class' => 'form-control Qty', 'id' => 'Qty'. $x .'']) !!}
                                    </td>
                                </tr>
                            @endfor
                        @else
                            @for($x = 1; $x <=100; $x++)
                                <tr>
                                    <td>
                                        {!! $x !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('baseWeight', '', ['id' => 'baseWeight'.$x.'']) !!}
                                        {!! Form::hidden('item['. $x .'][product_id]', '', ['id' => 'productName'. $x .'']) !!}
                                        {!! Form::text('productName', '', ['placeholder' => 'nama', 'class' => 'form-control product', 'id' => 'product'. $x .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][description]', '', ['placeholder' => 'aroma', 'class' => 'aroma form-control', 'id' => 'aroma'. $x .'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::hidden('item['. $x .'][price]', '', ['id' => 'price'. $x .'']) !!}
                                        {!! Form::hidden('item['. $x .'][total]', '', ['id' => 'total'. $x .'']) !!}
                                        {!! Form::text('price', '', ['placeholder' => 'price', 'class' => 'form-control', 'id' => 'displayPrice'. $x .'', 'disabled']) !!}
                                        {!! Form::select('selectPrice', [], '', ['id' => 'selectPrice'.$x.'', 'class' => 'form-control selectt', 'style' => 'display:none;']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][keterangan]', '', ['placeholder' => 'kemasan', 'class' => 'form-control', 'id' => 'ket'.$x.'']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('item['. $x .'][quantity]', '', ['placeholder' => 'jumlah', 'class' => 'form-control Qty', 'id' => 'Qty'. $x .'']) !!}
                                    </td>
                                </tr>
                            @endfor
                        @endif
                    </tbody>
                </table>
            </div>
        </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->
</div>
