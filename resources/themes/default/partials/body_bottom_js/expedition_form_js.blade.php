<!-- Vue JS -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.22/vue.min.js" type="text/javascript"></script>

<!-- autocomplete UI -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
        $('#kokab_name').autocomplete({
            source   : '/admin/expeditions/search-kokab',
            minLength: 2,
            autoFocus: true,
            select:function(e,ui){
                // asigning input column from the data that we got above
                vm.newDetail.id = ui.item.id;
            }
        });

        $('.removee').click(function (e) {
            e.preventDefault();
            var currentId = $(this).data('id');
            $('#tr'+currentId).remove();
        });
    });

    var vm = new Vue({
        el: '#form',

        data : {
            newDetail: { id: '', name: '', price: '' },
            details: []
        },

        methods: {
            addDetail: function () {
                if (this.newDetail.id) {
                    this.details.push(this.newDetail);
                    this.newDetail = { id: '', name: '', price: '' };
                }
            },
            removeDetail: function (item) {
                this.details.$remove(item);
            }
        },
    });
</script>