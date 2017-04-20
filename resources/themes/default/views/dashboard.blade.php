@extends('layouts.master')

@section('head_extra')
    <!-- jVectorMap 1.2.2 -->
    <link href="{{ asset("/bower_components/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}" rel="stylesheet" type="text/css" />
    <!-- autocomplete ui css -->
    @include('partials.head_css.autocomplete_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Customer Baru Bulan Ini</span>
                    <span class="info-box-number">{{ $newCustomersCount }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Penjualan Bulan Ini</span>
                    <span class="info-box-number">{{ $salesThisMonthCount }}</span>
                </div>
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pemasukan Online Bulan Ini</span>
                    <span class="info-box-number">{{ Helpers::reggo($incomeThisMountTotal) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-smile-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">BO Goal</span>
                    <span class="info-box-number">2</span>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-4">
            <div class="box box-success collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Followup</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['route' => 'admin.customer-followups.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('customer_id', null, ['id' => 'customer-id']) !!}
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Customer:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="customer-name" placeholder="nama customer">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Isi:</label>
                            <div class="col-sm-10">
                                <textarea name="content" class="form-control"></textarea>
                            </div>
                        </div>

                        {!! Form::submit('Tambah', ['class' => 'btn btn-info']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Followup Terakhir</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Isi</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestFollowups as $key => $value)
                            <tr>
                                <td><a href="{{ route('admin.customers.show', $value->customer_id) }}">{{ $value->id }}</a></td>
                                <td>{{ $value->content }}</td>
                                <td>{{ $value->customer->name }}</td>
                                <td>{{ $value->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">PO Terakhir</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestSales as $key => $value)
                            <tr>
                                <td><a href="{{ route('admin.sales.show', $value->id) }}">{{ $value->id }}</a></td>
                                <td>{{ $value->customer->name }}</td>
                                <td>{{ $value->getStatusDisplayName() }}</td>
                                <td>{{ $value->order_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Best Aroma</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($final as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
        <div class='col-md-4'>
            <!-- BROWSER USAGE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Pemasukan</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="pieChart" height="150"></canvas>
                            </div><!-- ./chart-responsive -->
                        </div><!-- /.col -->
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                @foreach($saleDetails as $detail => $item)
                                    <li><i class="fa fa-circle-o text-{{ $item['color'] }}"></i> {{ $detail }}</li>
                                @endforeach
                            </ul>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
                <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach($saleDetailsLastMonth as $detail => $item)
                        <li>
                            <a href="#">{{ $item['label'] }}
                                <span class="pull-right text-{{ $item['valueThisMonth'] > $item['value'] ? 'green' : 'red' }}">
                                    <i class="fa fa-angle-{{ $item['valueThisMonth'] > $item['value'] ? 'up' : 'down' }}"></i>
                                    {{ Helpers::reggo($item['valueThisMonth']-$item['value']) }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div><!-- /.footer -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('body_bottom')
    <!-- ChartJS -->
    <script src="{{ asset ("/bower_components/admin-lte/plugins/chartjs/Chart.min.js") }}" type="text/javascript"></script>

    <!-- autocomplete UI -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#customer-name').autocomplete({
                source   : '/admin/customers/search',
                minLength: 2,
                autoFocus: true,
                select:function(e,ui){
                    // asigning input column from the data that we got above
                    $('#customer-id').val(ui.item.id);
                }
            });
        });
    </script>

    <script type="text/javascript">
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            @foreach($saleDetails as $detail => $item)
            {
                value    :  {{ $item['value'] }},
                color    : '{{ $item['color'] }}',
                highlight: '{{ $item['highlight'] }}',
                label    : '{{ $item['label'] }}'
            },
            @endforeach
        ];
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 1,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
            //String - A tooltip template
            tooltipTemplate: "<%=value%> income <%=label%>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
        //-----------------
        //- END PIE CHART -
        //-----------------
    </script>
@endsection
