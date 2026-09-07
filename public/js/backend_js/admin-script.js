jQuery(document).ready(function() { 
    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });    
    TableAjax.init();
    $(document).on('click','.toogle_switch',function(){
        if($(this).hasClass('bootstrap-switch-on')){
            $(this).removeClass('bootstrap-switch-on');
            $(this).addClass('bootstrap-switch-off');
            var status=0;
            var id_sent=$(this).attr('id');
        }
        else{
            $(this).removeClass('bootstrap-switch-off');
            $(this).addClass('bootstrap-switch-on');
            var status=1;
            var id_sent=$(this).attr('id');
        }
        var table = $(this).attr('rel');
        var ajax_url='status';
        $.ajax({
            url:ajax_url,
            type:'POST',
            data:{
                'id':id_sent,'status':status, 'table':table
            },
            success:function(msg) {
            }
        })
    });

    $('#change_pass').formValidation({
        framework: 'bootstrap',
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "password":{
                validators:{
                    notEmpty:{
                        message: 'Current password is required'
                    },
                    remote:{
                        message: 'Current password is incorrect',
                        url: '/admin/checkAdminPassword',
                        type: 'POST',
                        delay: 1000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "new_password":{
                validators:{
                    notEmpty:{
                        message: 'New password is required'
                    }
                }
            },
            "re_password":{
                validators:{
                    notEmpty:{
                        message: 'Confirm Password  is required'
                    },
                    identical:{
                        field: "new_password",
                        message: 'Confirm Password is not match with New Password'
                    }
                }
            }
        }
    });

    $('.datePicker')
        .datepicker({
        format: 'yyyy-mm-dd'/*,
        startDate: new Date()*/
    }).on('changeDate', function(e) {
        $('#addCouponForm').formValidation('revalidateField','expiry_date');
        //$('#addCouponForm').formValidation('revalidateField','coupon_date');
        $(this).datepicker('hide');
    });

    //SubAdmin Routes
    $('#addEditSubadmin').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "name":{
                validators:{
                    notEmpty:{
                        message: 'This field is required.'
                    },
                    stringLength:{
                        max: 30,
                        message: 'Name not be more than 30 characters'
                    },
                    regexp: {
                        regexp: '^[a-zA-Z]+( [a-zA-z]+)*$',
                        message: 'Name can only consits of alphabets'
                    }
                }
            },
            "username":{
                validators:{
                    notEmpty:{
                        message: 'This field is required.'
                    },
                    remote:{
                        message: 'This username already exists.',
                        url: '/admin/checkAdminUsername',
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "email":{
                validators:{
                    notEmpty:{
                        message: 'This field is required.'
                    },
                    emailAddress:{
                        message: 'This Email is not a valid email address.'
                    },
                }
            },
            "password":{
                validators:{
                    notEmpty:{
                        message: 'This field is required.'
                    },
                    stringLength:{
                        min: 8,
                        message: 'Minimum 8 characters required.'
                    },
                }
            },
        }
    })
    .on('err.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    })
    .on('success.field.fv', function(e, data) {
        data.fv.disableSubmitButtons(false);
    });


    $('#addEditUser').formValidation({
        framework: 'bootstrap',
        message: 'This value is not valid',
        icon:{
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err:{
            container: 'popover'
        },
        fields:{
            "name":{
                validators:{
                    notEmpty:{
                        message: 'Name is required.'
                    },
                    stringLength:{
                        max: 30,
                        message: 'Name not be more than 30 characters'
                    },
                    regexp: {
                        regexp: '^[a-zA-Z]+( [a-zA-z]+)*$',
                        message: 'Name can only consits of alphabets'
                    }
                }
            },
            "email":{
                validators:{
                    notEmpty:{
                        message: 'Email is required.'
                    },
                    regexp: {  
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',                            
                        message: 'This is not a valid email address'                         
                    },
                    remote:{
                        message: 'This email already exists.',
                        url: '/admin/CheckUserEmail',
                        type: 'POST',
                        delay: 2000     // Send Ajax request every 2 seconds
                    }
                }
            },
            "password":{
                validators:{
                    notEmpty:{
                        message: 'Password  is required'
                    },
                    stringLength:{
                        min: 8,
                        message: 'Minimum 8 alphanumeric characters required'
                    },
                }
            }
        }
    });

    // Coupon Validation Starts
    $('#addCouponForm').formValidation({
        framework: 'bootstrap',
        excluded: [':disabled'],
        message: 'This value is not valid',
        icon: 
        {
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',*/
            validating: 'glyphicon glyphicon-refresh'
        },
        err: 
        {
            container: 'popover'
        },
        fields:
        {
            "expiry_date": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Expiry date is required.'
                    }, 
                    date: {
                        format: 'YYYY-MM-DD',
                        message: 'The date is not a valid'
                    }
                }
            },
            "amount": 
            {
                validators: 
                {
                    notEmpty: 
                    {
                        message: 'Coupon Amount is required.'
                    },
                    regexp: {
                        regexp: /^\d+$/,
                        message: 'Coupon Amount can only consist of digits'
                    }
                }
            },
        }
    });

    $("#Manual").click(function(){
        $("#ManualCode").html('<label class="col-md-3 control-label">Enter Code <span class="red">*</span>:</label><div class="col-md-5"><input maxlength="10" type="text" placeholder="Enter code" name="code" style="color:gray" class="form-control"/></div>');
             $(".loadingDiv").hide();
        $option = "code";
        $('#addCouponForm').formValidation('addField', $option, {
            validators:{   
                notEmpty:{
                    message: 'Code is required'
                },
                remote:{
                    message: 'This coupon code already exists.',
                    url: '/admin/checkCouponCode',
                    type: 'POST',
                    delay: 2000     // Send Ajax request every 2 seconds
                }
            }
        });
        $("#ManualCode").addClass('in');
    });

    $("#Automatic").click(function(){
        $find = $('.form-group');
        if($("#ManualCode").length > 0){
            $('#addCouponForm')
            .formValidation('removeField', $find.find('[name="code"]'));
            $("#ManualCode").remove();
            var $target = $('#AppenderManualCode');
            $target.after('<div class="form-group collapse" id="ManualCode"></div>');
        }
        $(".loadingDiv").hide();
    });
    
    /*Roles Scripts starts*/
    $(document).on('change','.getModuleid',function(){
        var roleType = $(this).attr('data-attr');
        var id = $(this).attr('rel');
        if(roleType === "View"){
            $('#edit-'+id).prop('checked',false);
            $('#delete-'+id).prop('checked',false);
        }else if(roleType==="Edit"){
            $('#view-'+id).prop('checked',true);
            $('#delete-'+id).prop('checked',false);
        }else if(roleType==="Delete"){
            $('#view-'+id).prop('checked',true);
            $('#edit-'+id).prop('checked',true);
        }
    });
    /*Roles Scripts ends*/
});