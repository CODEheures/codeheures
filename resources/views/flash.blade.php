@if(session()->has('success'))
    <div class="alert alert-success">
        <p>{{ session('success') }}</p>
        <div class="close_btn"><i class="ion-ios-close"></i></div>
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-info">
        <p>{{ session('info') }}</p>
        <div class="close_btn"><i class="ion-ios-close"></i></div>
    </div>
@endif

@if(session()->has('status'))
    <div class="alert alert-info">
        <p>{{ session('status') }}</p>
        <div class="close_btn"><i class="ion-ios-close"></i></div>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger">
        <p>{{ session('error') }}</p>
        <div class="close_btn"><i class="ion-ios-close"></i></div>
    </div>
@endif