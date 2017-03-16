@extends('layouts.master')

@section('head_extra')
    <!-- autocomplete ui css -->
    @include('partials.head_css.autocomplete_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Item di PO</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        @foreach($data as $product => $saleDetail)
                        <div class="panel box box-{{ isset($saleDetail['materials']) ? 'primary' : 'danger' }}">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $x }}">
                                    {{ $product }}
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
                                                if ( isset($total[$val['material_id']]) ) {
                                                    $total[$val['material_id']] += $val['quantity'] * $saleDetail['quantity'];
                                                } else {
                                                    $total[$val['material_id']] = 0 + $val['quantity'] * $saleDetail['quantity'];
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
                                            if ( isset( $totalSeed[$saleDetail['description']] ) ) {
                                                    $totalSeed[$saleDetail['description']] += $saleDetail['seed'] * $saleDetail['quantity'];
                                                } else {
                                                    $totalSeed[$saleDetail['description']] = 0 + $saleDetail['seed'] * $saleDetail['quantity'];
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
                        @endforeach <?php $x = 0; ?>
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
            {!! Form::open( ['route' => 'admin.purchase-orders.store'] ) !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Collapsible Accordion</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center">
                                    <a class="btn" href="#" onclick="toggleCheckbox(); return false;" title="{{ trans('general.button.toggle-select') }}">
                                        <i class="fa fa-check-square-o"></i>
                                    </a>
                                </th>
                                <th>{{ trans('admin/formulas/general.columns.materials') }}</th>
                                <th>{{ trans('admin/formulas/general.columns.total') }}</th>
                                <th>{{ trans('admin/formulas/general.columns.stock') }}</th>
                                <th>Harga</th>
                                <th>Vendor</th>
                                <th>{{ trans('admin/formulas/general.columns.quantity') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($total as $material => $value)
                            <tr>
                                <td align="center">
                                    {!! Form::checkbox('material['. $x .'][material_id]', Helpers::getMaterialById($material)->id, false, ['class' => 'material', 'id' => 'material'. $x .'']) !!}
                                </td>
                                <td>{{ Helpers::getMaterialById($material)->name }}</td>
                                <td>{{ $value }}</td>
                                <td>{{ Helpers::getMaterialById($material)->stock }}</td>
                                <td id="harga{{$x}}">{{ Helpers::reggo(Helpers::getMaterialById($material)->price) }}</td>
                                <td>
                                    {!! Form::hidden('material['. $x .'][supplier_id]', '', ['id' => 'supplier_id'.$x.'', 'disabled']) !!}
                                    {!! Form::text('supplier_name', '', ['class' => 'form-control supplier', 'id' => 'supplier'.$x.'', 'disabled']) !!}
                                </td>
                                <td>
                                    {!! Form::text('material['. $x .'][quantity]', null, ['class' => 'form-control quantity', 'id' => 'quantity'. $x .'', 'disabled']); !!}
                                    {!! Form::hidden('material['. $x .'][need]', $value, ['id' => 'need'. $x .'', 'disabled']) !!}
                                    {!! Form::hidden('price', Helpers::getMaterialById($material)->price, ['id' => 'price'. $x .'']) !!}
                                    {!! Form::hidden('material['. $x .'][total]', null, ['id' => 'total'. $x .'', 'disabled', 'class' => 'totall']) !!}
                                </td>
                            </tr>
                            <?php $x++ ?>
                            @endforeach
                            @foreach($totalSeed as $name => $value)
                            <tr>
                                <td align="center">
                                    {!! Form::checkbox('seed['. $x .'][material_id]', Helpers::getMaterialByName($name)->id, false, ['class' => 'material', 'id' => 'material'. $x .'']) !!}
                                </td>
                                <td>{{ $name }}</td>
                                <td>{{ $value }}</td>
                                <td>{{ Helpers::getMaterialByName($name)->seedMaterial->stock }}</td>
                                <td id="harga{{$x}}">{{ Helpers::reggo(Helpers::getMaterialByName($name)->price) }}</td>
                                <td>
                                    {!! Form::hidden('seed['. $x .'][supplier_id]', '', ['id' => 'supplier_id'.$x.'', 'disabled']) !!}
                                    {!! Form::text('supplier_name', '', ['class' => 'form-control supplier', 'id' => 'supplier'.$x.'', 'disabled']) !!}
                                </td>
                                <td>
                                    {!! Form::text('seed['. $x .'][quantity]', null, ['class' => 'form-control quantity', 'id' => 'quantity'. $x .'', 'disabled']); !!}
                                    {!! Form::hidden('seed['. $x .'][need]', $value, ['id' => 'need'. $x .'', 'disabled']) !!}
                                    {!! Form::hidden('price', Helpers::getMaterialByName($name)->price, ['id' => 'price'. $x .'']) !!}
                                    {!! Form::hidden('seed['. $x .'][total]', null, ['id' => 'total'. $x .'', 'disabled', 'class' => 'totall']) !!}
                                </td>
                            </tr>
                            <?php $x++ ?>
                            @endforeach
                            <tr>
                                <th colspan="4">Total</th>
                                <td id="allTotal"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('admin/purchase-orders/general.page.create.section-title') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('description', trans('admin/purchase-orders/general.columns.description')) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit( trans('general.button.create'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('body_bottom')
    <!-- Vue JS -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.22/vue.min.js" type="text/javascript"></script>

    <!-- autocomplete UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script language="JavaScript">
        function toggleCheckbox() {
            checkboxes = document.getElementsByName('material[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        }

        $('.supplier').autocomplete({
            source   : '/admin/suppliers/search',
            minLength: 2,
            autoFocus: true,
             select       : function(e, ui) {
                currentId = $(this).attr('id').replace('supplier', '');
                $('#supplier_id'+currentId).val(ui.item.id);
                for (prop in ui.item.detail) {
                    if ($('#material'+currentId).val() == ui.item.detail[prop]['material_id']) {
                        $('#harga'+currentId).html(ui.item.detail[prop]['price']);
                        $('#price'+currentId).val(ui.item.detail[prop]['price']);
                    }
                }
            }
        });

        $('.material').change(function(){
            var currentId = $(this).attr('id').replace('material', '');
            $('#need' + currentId).prop('disabled', function(i, v) { return !v; });
            $('#total' + currentId).prop('disabled', function(i, v) { return !v; });
            $('#quantity' + currentId).prop('disabled', function(i, v) { return !v; });
            $('#supplier' + currentId).prop('disabled', function(i, v) { return !v; });
            $('#supplier_id' + currentId).prop('disabled', function(i, v) { return !v; });
        });

        $('.quantity').focusout(function () {
            var currentId = $(this).attr('id').replace('quantity', '');
            var total = $('#price' + currentId).val() * $('#quantity' + currentId).val();
            $('#total' + currentId).val(total);

            var arr = document.getElementsByClassName('totall');
            var tot = 0;
            for(var i=0;i<arr.length;i++){
                if(parseInt(arr[i].value)) {
                    tot += parseInt(arr[i].value);
                }
            }
            $('#allTotal').html(tot);
        });
    </script>
@endsection