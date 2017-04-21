<table id="example2" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>{{ trans('admin/sales/general.columns.name') }}</th>
            <th>{{ trans('admin/sales/general.columns.order_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.transfer_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.estimation_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.nominal') }}</th>
            <th>{{ trans('admin/sales/general.columns.total') }}</th>
            <th>{{ trans('admin/sales/general.columns.status') }}</th>
            <th>{{ trans('admin/sales/general.columns.actions') }}</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>{{ trans('admin/sales/general.columns.name') }}</th>
            <th>{{ trans('admin/sales/general.columns.order_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.transfer_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.estimation_date') }}</th>
            <th>{{ trans('admin/sales/general.columns.nominal') }}</th>
            <th>{{ trans('admin/sales/general.columns.total') }}</th>
            <th>{{ trans('admin/sales/general.columns.status') }}</th>
            <th>{{ trans('admin/sales/general.columns.actions') }}</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach($sales as $key => $sale)
        <tr>
            <td>{!! link_to_route('admin.sales.show', $sale->customer->name, $sale->id) !!}</td>
            <td>{{ Helpers::date($sale->order_date) }}</td>
            <td>{{ Helpers::date($sale->transfer_date) }}</td>
            <td>{{ Helpers::date($sale->estimation_date) }}</td>
            <td>{{ Helpers::reggo($sale->nominal) }}</td>
            <td>{{ Helpers::reggo(($sale->nominal-$sale->discount)+$sale->shipping_fee+$sale->packing_fee) }}</td>
            <td>
                @if($sale->type == 1)
                {!! Form::select('status', config('constant.sale-status'), $sale->status, ['class' => 'form-control status',  'data-id' => $sale->id, 'data-token' => csrf_token()]) !!}
                @else
                {!! Form::select('status', config('constant.sale-status-offline'), $sale->status, ['class' => 'form-control status',  'data-id' => $sale->id, 'data-token' => csrf_token()]) !!}
                @endif
            </td>
            <td>
                <a href="{!! route('admin.sales.edit', $sale->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-pencil-square-o"></i></a>
                <a href="{!! route('admin.sales.print', $sale->id) !!}" target="_blank" title="{{ trans('general.button.print') }}"><i class="fa fa-print"></i></a>
                <a href="{!! route('admin.sales.confirm-delete', $sale->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash-o deletable"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>