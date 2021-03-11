@if(Session::has('message'))
	<div class="top-white-space"></div>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true"> &times; </span></button>
        {{Session::get('message')}}
    </div>
    
@endif