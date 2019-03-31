
@if(session()->has('message'))
    <div class="notification is-success">
        <p><span class="icon"><i class="fas fa-check"></i></span>&nbsp;{{ session()->get('message') }}</p>
    </div>
@endif

@if(session()->has('error'))
    <div class="notification is-danger">
        <p><span class="icon"><i class="fas fa-exclamation-triangle"></i></span>&nbsp;{{ session()->get('error') }}</p>
    </div>
@endif