<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src="{{  asset ("/bower_components/admin-lte/select2/js/select2.min.js") }}"></script>
<script type="text/javascript">
    $("#prov").change(function() {
        $.getJSON("/api/get-kokab/" + $("#prov").val(), function(data) {
            var $stations = $("#kokab");
            $stations.empty();
            $.each(data, function(index, value) {
                $stations.append('<option value="' + index +'">' + value + '</option>');
            });
            $("#kota").trigger("change"); /* trigger next drop down list not in the example */
        });
    });
    $('.type').select2({
        theme: "bootstrap",
        placeholder: '...',
        tags: true
    });
    $('.date').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: false,
        autoclose: true
    });
</script>
