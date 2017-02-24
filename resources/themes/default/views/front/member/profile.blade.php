@extends('layouts.store')

@section('top_styles')
<!-- autocomplete ui -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css">
<!-- autocomplete loading gif -->
<style>
    input.ui-autocomplete-loading { background:url('http://preloaders.net/preloaders/712/Floating%20rays-16.gif') no-repeat right center }
</style>
@endsection

@section('content')	
	<section id="cart-view">
		<div class="container">
			<div class="row" style="margin-top:20px;">
				<div class="col-md-3" style="padding:10px;">
					<div class="panel panel-default">
						<div class="panel-body">
							<img width="100%" src="/img/default-avatar.png" alt="profile" class="img-rounded center-block">
						</div>
					</div>
					@if(Auth::user()->id == $id)
						@if($user->hasRole('partners'))
						<div class="panel panel-default">
							<div class="panel-body">
								<h4 class="header-title">Toko</h4>
								<hr>
								<a href="#" class="btn btn-block btn-primary tabs" id="stok">Stok Barang</a>
							</div>
						</div>
						@endif
						<div class="panel panel-default">
							<div class="panel-body">
								<ul class="nav nav-pills nav-stacked">
									<h4 class="header-title">Heading</h4><hr>
									<li><a href="#" class="tabs" id="edit" data-id="{{ $id }}">Edit</a></li>
									@if($user->affiliate)
					    				<li><a href="#" class="tabs" id="aff">Affiliate</a></li>
					    			@endif
									<li><a href="#">Something else</a></li>
								</ul>
							</div>
						</div>
					@endif
				</div>
                <img id="loading" src="http://blog.teamtreehouse.com/wp-content/uploads/2015/05/InternetSlowdown_Day.gif" width="10%" style="display:none;">
				<div class="col-md-9" id="isi" style="padding:10px;">
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>{{ $user->first_name .' '. $user->last_name }}</h4>
							@if($user->hasRole('members'))
			    				<tr>
			    					<td>Phone</td>
			    					<td>{{ $user->storeCustomer->phone or '-' }}</td>
			    				</tr>
			    				<tr>
			    					<td>Address</td>
			    					<td>{{ $user->storeCustomer->address }}</td>
			    				</tr>
		    				@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- addProduct Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Modal title</h4>
          </div>
          <div class="modal-body">
            {!! Form::text('name', '', ['id' => 'productName', 'class' => 'form-control']) !!}
            <div class="row" id="productList"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('bottom_scripts')
<!-- autocomplete UI -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script>
	$("#prov").change(function() {
        $.getJSON("api/get-kokab/" + $("#prov").val(), function(data) {
            var $stations = $("#kokab");
            $stations.empty();
            $.each(data, function(index, value) {
                $stations.append('<option value="' + index +'">' + value + '</option>');
            });
            $("#kota").trigger("change"); /* trigger next drop down list not in the example */
        });
    });

    $(".tabs").on('click', function (event) {
    	event.preventDefault();
    	$("#edit").parent('li').removeClass('active');
    	$("#aff").parent('li').removeClass('active');
    	var id  = $("#edit").data('id');
    	var tab = $(this).attr('id');
        $("#loading").fadeIn();
        $( "#isi" ).empty();
        $.ajax({
            url      : "/member/"+ id +"/"+ tab +"",
            type     : 'GET',
            dataType : 'html',
            success: function(data){
                $("#loading").fadeOut();
                $("#"+tab+"").parent('li').addClass('active');
                $( "#isi" ).append( data );
            }
        });
    });

    $(document).ready(function () {
        var products = [];
        $('#productName').autocomplete({
            source       : '/store/products/search',
            minLength    : 3,
            matchContains: true,
            selectFirst  : false,
            autoFocus    : true,
            appendTo     : '#addProduct',
            select       : function(e, ui) {
                var para = document.createElement('div');
                var node = document.createTextNode(ui.item.value);
                para.setAttribute('class', 'col-md-3');
                para.appendChild(node);
                document.getElementById('productList').appendChild(ui.item.data);
                $(this).val('');
                return false;
            }
        });
    });


    function addProduct() {
        event.preventDefault();
        alert("clicked");
    };
</script>
@endsection