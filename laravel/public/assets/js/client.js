var client_data=(function() {

    var name,email,gender,rfc,phone,status,client_data=$(".client-data"),name_field=$('.client-name'),email_field=$('.client-email'),gender_field=$('.client-gender'),
        rfc_field=$('.client-rfc'),phone_field=$('.client-phone'),status_field=$('.client-status');

    $(".client-data").on("click", function () {
        name= $(this).data("name");
        console.log(name);
        name_field.html(name);

        email= $(this).data("email");
        email_field.html(email);

        gender= $(this).data("gender");
            gender_field.html(gender);


        phone= $(this).data("phone");
        phone_field.html(phone);

        status= $(this).data("status");
            status_field.html(status);

    });

});