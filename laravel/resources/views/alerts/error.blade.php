@if(Session::has('message-error'))
    <div class="top-white-space"></div>
    <div class="alert alert-danger alert-dismissible message_margin" role="alert">
        <div class="col-md-11"><span style="float: left">*{{Session::get('message-error')}}</span></div>
         <div class="col-md-1"><button type="button" class="close" data-dismiss="alert" aria-label="close">
                 <span aria-hidden="true"> &times; </span></button><br></div><br>

    </div>
@endif