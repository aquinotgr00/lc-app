<!-- autocomplete UI -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="{{ asset("/bower_components/moment/min/moment.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>

<script type="text/javascript">
    // hide 'sec-address' because we want to give 'address' input for a new customers
    // also hide date and time because it's only used for offline PO
    $('#sec-address').attr('style', 'display:none');
    $('#type-po-div').attr('style', 'display:none');

    function myWeight() {
        var sum    = 0;
        var jerSum = 0;

        $('.sumWeight').each(function(){
            sum += parseFloat( $(this).val() || 0 );  //Or this.innerHTML, this.innerText
        });

        $('.qtyJer').each(function(){
            if ( $(this).text() != 0 ) {
                jerSum += parseFloat( $(this).attr('value') );  //Or this.innerHTML, this.innerText
            }
        });

        $('.weightTotal').empty().append(sum).fadeIn();
        $('.totalJer').empty().append(jerSum).fadeIn();
    }

    function sumJerigen() {
        var currentId = 0;
        var qty = 0;

        $('.Qty').each(function() {
            currentId = $(this).attr('id').replace('Qty','');
            qty = $(this).val();
            $('#jer'+currentId).text(Math.round(qty/5));
            $('#jer'+currentId).attr('value', Math.round(qty/5));
        });
    }

    $(document).ready(function() {
        //  customer data tab
        $('#customer_name').autocomplete({
            source   : '/admin/customers/search',
            minLength: 3,
            autoFocus: true,
            select:function(e,ui){
	            var stations = $("#sec-address");
	            // remove the assigning name in 'base-address' and assigning to 'sec-address'
	            $('#base-address').attr('name','');
	            stations.attr('name','address');

	            // change the address input
	            $('#base-address').hide(500);
	            stations.show(500);

	            // append the data to select box
	            stations.empty();
	            stations.append('<option value="default">Choose Address</option>');
	            stations.append('<option value="' + ui.item.address +'">Rumah: ' + ui.item.address + '</option>');
	            stations.append('<option value="' + ui.item.laundry_address +'">Laundry: ' + ui.item.laundry_address + '</option>');
		        stations.append('<option value="' + ui.item.ship_address +'">Kirim: ' + ui.item.ship_address + '</option>');

	            // asigning input column from the data that we got above
	            $('#customer_id').val(ui.item.id);
	            $('#type').val(ui.item.type);
	            $('.phone').val(ui.item.phone);
          	}
        });
        //  details sale tab
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: false,
            autoclose: true
        });

        $('.dateNTime').datetimepicker();

        $('#bank').select2({});

        $('#expedition').autocomplete({
            source   : '/admin/expeditions/search',
            minLength: 3,
            autoFocus: true
        });
        // sale items tab
        sumJerigen();
        myWeight();

        $('.product').autocomplete({
            source       : '/admin/products/search',
            minLength    : 3,
            matchContains: true,
            selectFirst  : false,
            autoFocus    : true,
            select       : function(e, ui) {
                currentId = $(this).attr('id').replace('product', '');
                type      = $('#type').val();
                if (ui.item.seed == 1 && ui.item.category == 10) {
                    $('#displayPrice'+currentId).fadeOut();
                    var optDef       = document.createElement('option');
                    optDef.innerHTML = 'Pilih';
                    var optPrc       = document.createElement('option');
                    optPrc.value     = ui.item.price;
                    optPrc.innerHTML = '1 liter';
                    var opt          = document.createElement('option');
                    opt.value        = ui.item.price_1;
                    opt.innerHTML    = '500 ml';
                    var opt2         = document.createElement('option');
                    opt2.value       = ui.item.price_2;
                    opt2.innerHTML   = '250 ml';
                    var opt3         = document.createElement('option');
                    opt3.value       = ui.item.price_3;
                    opt3.innerHTML   = '100 ml';
                    document.getElementById('selectPrice'+currentId).add(optDef);
                    document.getElementById('selectPrice'+currentId).add(optPrc);
                    document.getElementById('selectPrice'+currentId).add(opt);
                    document.getElementById('selectPrice'+currentId).add(opt2);
                    document.getElementById('selectPrice'+currentId).add(opt3);
                    $('#selectPrice'+currentId).fadeIn();
                } else {
                    if (type == 1 || type == 3 || type == 6 || type == 8) {
                        $('#displayPrice'+currentId).val(ui.item.agenlepas_price);
                        $('#price'+currentId).val(ui.item.agenlepas_price);
                    } else if (type == 2 || type == 7) {
                        $('#displayPrice'+currentId).val(ui.item.agenresmi_price);
                        $('#price'+currentId).val(ui.item.agenresmi_price);
                    } else {
                        $('#displayPrice'+currentId).val(ui.item.price);
                        $('#price'+currentId).val(ui.item.price);
                    }
                }

                $('#baseWeight'+currentId).val(ui.item.weight);
                // $('#beratAwal'+currentId).val(ui.item.weight);
                $('#productName'+currentId).val(ui.item.id);
                $('#product'+currentId).removeAttr('style');
            }
        });

        $('.selectt').change(function () {
            currentId = $(this).attr('id').replace('selectPrice', '');
            $('#price'+currentId).val($('#selectPrice'+currentId).val());
            $('#ket'+currentId).val($('#selectPrice'+currentId+'  option:selected').text());
        });

        if ( $('#type-po').val() == 2 ) {
            $('#type-po-div').removeAttr('style');
            $('#dateNTime').removeAttr('disabled');
            $('#online').fadeOut();
            $('#offline').removeAttr('style');
            $('#onlineTab').attr('style', 'display:none');
            $('.onlineRow').remove();
        }

        $('#type-po').change(function () {
            if ($('#type-po').val() == 2) {
                $('#type-po-div').removeAttr('style');
                $('#dateNTime').removeAttr('disabled');
                $('#online').attr('style', 'display:none');
                $('#offline').removeAttr('style');
                $('#onlineTab').attr('style', 'display:none');
            } else {
                $('#dateNTime').attr('disabled', true);
                $('#type-po-div').attr('style', 'display:none');
                $('#offline').attr('style', 'display:none');
                $('#online').removeAttr('style');
                $('#onlineTab').removeAttr('style');
            }
        });

        function productValidation(currentId) {
            var currentId = currentId;

            if ( $('#product'+currentId).val() != '' ) {
                if ( $('#productName'+currentId).val() == '' ) {
                    $('#product'+currentId).attr('style','border-color:#B31154');
                }
            }
        }

        $('.aroma').autocomplete({
            source   : '/admin/products/aromaSearch',
            minLength: 2,
            autoFocus: true,
            select:function(e,ui){
                currentId = $(this).attr('id').replace('product','');
            }
        });

        $('.Qty').focusout(function() {
            var qty         = $(this).val();
            var currentId   = $(this).attr('id').replace('Qty','');

            var price       = $('#price'+currentId).val();
            var baseWeight  = $('#baseWeight'+currentId).val();
            console.log(price);
            // var weight      = $('#weight'+currentId).val();
            var weightTotal = qty*baseWeight;

            $('#total'+currentId).val(qty*price);
            $('#displayTotal'+currentId).val(qty*price);

            $('#jer'+currentId).attr('value', Math.round(qty/5));
            $('#jer'+currentId).text(Math.round(qty/5));

            if(!isNaN(weightTotal)){
                $('#weight'+currentId).val(Math.round(weightTotal));
                $('#displayWeight'+currentId).val(Math.round(weightTotal));
            }
            myWeight();
        });
    });
</script>
