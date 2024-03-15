
    var next_click = document.querySelectorAll(".next_button");
    var main_form = document.querySelectorAll(".main");
    var step_list = document.querySelectorAll(".progress-bar-section li");
    var num = document.querySelector(".step-number");
    let formnumber = 0;

    next_click.forEach(function(next_click_form) {
        next_click_form.addEventListener('click', function() {
            if (!validateform()) {
                return false
            }
            var currentStep = $(this).data('current');
            if (currentStep == 3) {

                //check database connections
                var db_host = $('input[name="db_host"]').val();
                var db_name = $('input[name="db_name"]').val();
                var db_user = $('input[name="db_user"]').val();
                var db_pass = $('input[name="db_pass"]').val();
                var db_data = {
                    db_host: db_host,
                    db_name: db_name,
                    db_user: db_user,
                    db_pass: db_pass
                };
                $('#database_error').hide();
                //show some response on the button
                $btn = $(this);
                $btn.prop('type', 'submit');
                $btn.prop('orig_label', $btn.text());
                $btn.prop('disabled', true);
                $btn.html(
                    '<span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                );
                $.ajax({
                    type: "POST",
                    url: 'check.php?check=db',
                    data: db_data,
                    dataType: 'json',
                    success: function(response) {
                        //reverse the response on the button
                        //$btn = $(this);
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                        if (response.result == 'success') {
                            $('#database_error').hide();
                            formnumber++;
                            updateform();
                            progress_forward();
                            contentchange();

                        } else {
                            $('#database_error').show().html(response.message);
                        }
                    },
                    error: function() {
                        //reverse the response on the button
                        //$btn = $(this);
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                        return false
                    }
                });
            } else {
                formnumber++;
                updateform();
                progress_forward();
                contentchange();
            }

        });
    });

    var back_click = document.querySelectorAll(".back_button");
    back_click.forEach(function(back_click_form) {
        back_click_form.addEventListener('click', function() {
            formnumber--;
            updateform();
            progress_backward();
            contentchange();
        });
    });

  
    var submit_click = document.querySelectorAll(".submit_button");
    submit_click.forEach(function(submit_click_form) {
        submit_click_form.addEventListener('click', function() {

            // database connections
            var db_host = $('input[name="db_host"]').val();
            var db_name = $('input[name="db_name"]').val();
            var db_user = $('input[name="db_user"]').val();
            var db_pass = $('input[name="db_pass"]').val();
            // system options
            var locale = $('select[name="locale"]').val();
            var states = $("input[name='states']:checked").length > 0;
            var cities = $("input[name='cities']:checked").length > 0;
            if (states) {
                states = 'add';
            }
            if (cities) {
                cities = 'add';
            }
            // admin credentials
            var firstname = $('input[name="firstname"]').val();
            var lastname = $('input[name="lastname"]').val();
            var email = $('input[name="email"]').val();

            //prepare data
            var install_data = {
                db_host: db_host,
                db_name: db_name,
                db_user: db_user,
                db_pass: db_pass,
                locale: locale,
                states: states,
                cities: cities,
                firstname: firstname,
                lastname: lastname,
                email: email

            };
            $('#install_error').hide();
            //show some response on the button
            $btn = $(this);
            $btn.prop('type', 'submit');
            $btn.prop('orig_label', $btn.text());
            $btn.prop('disabled', true);
            $btn.html(
                '<span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
            );

            //progress bar
            $('#installing').show();
            // var bar = $('#bar_add');
            // var percent = $('#percent_add');
            $.ajax({
                type: "POST",
                url: 'check.php?check=install',
                data: install_data,
                dataType: 'json',
                // beforeSend: function() {
                //     document.getElementById("progress_div_add").style.display = "block";
                //     var percentVal = '50%';
                //     bar.width(percentVal)
                //     percent.html(percentVal);
                // },

                success: function(response) {

                    // var percentVal = '100%';
                    // bar.width(percentVal)
                    // percent.html(percentVal);

                    // $('#installing').hide();

                    if (response.result == 'success') {
                        // $('#progress_div_add').hide();
                        //reverse the response on the button
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                        $('#install_error').hide();
                        $('#install_success').show().html(response.message);
                        formnumber++;
                        updateform();
                        progress_forward();
                        contentchange();

                    } else {
                        //reverse the response on the button
                        label = $btn.prop('orig_label');
                        if (label) {
                            $btn.prop('type', 'submit');
                            $btn.text(label);
                            $btn.prop('orig_label', '');
                            $btn.prop('disabled', false);
                        }
                        $('#install_error').show().html('Error: An error occured');
                    }
                },
                error: function() {
                    $('#install_error').show().html('Error: An error occured');
                    //reverse the response on the button
                    //$btn = $(this);
                    label = $btn.prop('orig_label');
                    if (label) {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                        $btn.prop('disabled', false);
                    }
                    return false
                }
            });

        });
    });

    


    function updateform() {
        main_form.forEach(function(mainform_number) {
            mainform_number.classList.remove('active');
        })
        main_form[formnumber].classList.add('active');
    }

    function progress_forward() {
        // step_list.forEach(list => {

        //     list.classList.remove('active');

        // }); 


        num.innerHTML = formnumber + 1;
        step_list[formnumber].classList.add('active');
    }

    function progress_backward() {
        var form_num = formnumber + 1;
        step_list[form_num].classList.remove('active');
        num.innerHTML = form_num;
    }

    var step_num_content = document.querySelectorAll(".step-number-content");

    function contentchange() {
        step_num_content.forEach(function(content) {
            content.classList.remove('active');
            content.classList.add('d-none');
        });
        step_num_content[formnumber].classList.add('active');
    }


    function validateform() {
        validate = true;
        var validate_inputs = document.querySelectorAll(".main.active input");
        validate_inputs.forEach(function(vaildate_input) {
            vaildate_input.classList.remove('warning');
            if (vaildate_input.hasAttribute('require')) {
                if (vaildate_input.value.length == 0) {
                    validate = false;
                    vaildate_input.classList.add('warning');
                }
            }
        });
        return validate;

    }
