jQuery(document).ready(function() {

    var add_employed=$('.employed_button'),close=$('.close_button'), alerts=$('#add_alerts'),i= 0, add_name,add_first_name, add_last_name, add_email, add_role, add_token,add_password, add_password_confirmation;

    add_employed.on("click",function(){
        $('.alert').alert('close');
        add_name=document.getElementById('name-create').value;
        add_first_name=document.getElementById('first-create').value;
        add_last_name=document.getElementById('last-create').value;
        add_password=document.getElementById('password-create').value;
        add_password_confirmation=document.getElementById('password-create-confirmation').value;
        add_email=document.getElementById('email-create').value;
        add_role=document.getElementById('role-create').value;
        add_token=document.getElementById('token-create').value;
        $.ajax({
            type: "POST",
            url: "/empleado/crear",
            data: {name_create:add_name ,first_create:add_first_name, last_create:add_last_name, password_create:add_password, password_create_confirmation:add_password_confirmation, email_create:add_email, role_create:add_role , _token: add_token},
            success: function(data) {
                console.log(data.message);
                if(data.success == false) {
                    $.each(data.message, function (index, obj) {
                        //document.getElementById('add_alerts').append('<div class="alert alert-danger up_margin"> <div class="col-md-11"> <span style="float: left;">*' +obj+' </span><br> </div> <div class="col-md-1"> <button type="button" class="close" data-dismiss="alert" aria-label="close"> <span aria-hidden="true"> &times; </span></button><br> </div>') ;
                        $('<div class="alert alert-danger"> <div class="col-md-11"> <span class="message-margin" style="float: left;">*' +obj+' </span><br> </div> <div class="col-md-1 message-margin"> <button type="button" class="close " data-dismiss="alert" aria-label="close"> <span aria-hidden="true"> &times; </span></button><br> </div>').appendTo(alerts);
                    });
                }
                else{
                    $('<div class="alert alert-success"> <div class="col-md-11"> <span class="message-margin" style="float: left;">*' +data.message+' </span><br> </div> <div class="col-md-1 message-margin"> <button type="button" class="close" data-dismiss="alert" aria-label="close"> <span aria-hidden="true"> &times; </span></button><br> </div>').appendTo(alerts);
                    $('#stack1').modal('hide');
                    $('#employed_table').DataTable().ajax.reload();
                    $('#name-create').val("");
                    $('#first-create').val("");
                    $('#last-create').val("");
                    $('#password-create').val("");
                    $('#password-create-confirmation').val("");
                    $('#email-create').val("");
                    $('.alert').alert('close');
                }

            }
        })
    });

    close.on("click",function(){
       $('#stack1').modal('hide');
        $('#name-create').val("");
        $('#first-create').val("");
        $('#last-create').val("");
        $('#password-create').val("");
        $('#password-create-confirmation').val("");
        $('#email-create').val("");
        $('.alert').alert('close');
    });


});
