
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
    integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type='text/javascript' id="custom-js">
    $(document).ready(function() {

        //package form Repeater

        $('#package_info').repeater({
            initEmpty: false,

            // defaultValues: {
            //     'description': '1.0',
            //     'weight': '1.0',
            //     'qty': '1'
            // },

            show: function() {
                $(this).slideDown();
                Calculate_Total_Weight();
                Calculate_Total_Qty();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },

            isFirstItemUndeletable: true
        }); 

        //Check  collection type
        var collection_type = $("input[id='collection_type']:checked").val();
        if (collection_type == 2) {
            $('#sender_branch').hide();
        }
        $("input[name='collection_type']").change(function() {
            var collection_type = $("input[name='collection_type']:checked").val();
            if (collection_type == 1) {
                $('#sender_branch').show();
            }
            if (collection_type == 2) {
                $('#sender_branch').hide();
            }
        });

        //Check  delivery type
        var delivery_type = $("input[id='delivery_type']:checked").val();
        if (delivery_type == 2) {
            $('#receiver_branch').hide();
        }
        $("input[name='delivery_type']").change(function() {
            var delivery_type = $("input[name='delivery_type']:checked").val();
            if (delivery_type == 1) {
                $('#receiver_branch').show();
            }
            if (delivery_type == 2) {
                $('#receiver_branch').hide();
            }
        });




        //Initialize select 2 foem
        $('#sel_sender_address').select2();
        $('#sel_receiver_address').select2();
        $('#sel_branch_1').select2();
        $('#sel_branch_2').select2();
        $('#from_branch').select2();
        $('#to_branch').select2();
        // SENDER ADDRESS
        $('#sel_sender_address').change(function() {
            var id = $(this).val();

            // AJAX request 
            $.ajax({
                url: '<?php echo e(url('dashboard/address/getbranch')); ?>/' + id + '?type=2',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#sel_branch_1').find('option').not(':first').remove();
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var name = response['data'][i].name;

                            var option = "<option value='" + id + "'>" + name +
                                "</option>";

                            $("#sel_branch_1").append(option);
                        }

                    }

                }
            });
        });
        // SENDER ADDRESS
        $('#sel_receiver_address').change(function() {

            var id = $(this).val();

            // Empty the dropdown

            // AJAX request 
            $.ajax({
                url: '<?php echo e(url('dashboard/address/getbranch')); ?>/' + id + '?type=2',
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#sel_branch_2').find('option').not(':first').remove();
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }

                    if (len > 0) {
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var name = response['data'][i].name;

                            var option = "<option value='" + id + "'>" + name +
                                "</option>";

                            $("#sel_branch_2").append(option);
                        }
                    }
                }
            });
        });
    });

    function Calculate_Total_Weight() {
        //get element class
        var element_class = $('.weights');
        //set weight to 0
        var sum_weight = 0;
        //map elements
        element_class.map(function() {
            //sum all the .weight values
            sum_weight += parseFloat($(this).val());
        }).get();

        //update total weight value
        $('.total_weight').val(sum_weight);
    }

    function Calculate_Total_Qty() {
        //get element class
        var element_class = $('.qty');
        //set weight to 0
        var sum_qty = 0;
        //map elements
        element_class.map(function() {
            //sum all the .weight values
            sum_qty += parseFloat($(this).val());
        }).get();

        //update total weight value
        $('.total_qty').val(sum_qty);
    }
</script>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/scripts.blade.php ENDPATH**/ ?>