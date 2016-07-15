@if(session()->has('success'))
    <div class="alert alert-success">
        <div class="title">
            <p>
                {{ session('success') }}
                @if(session()->has('info_url'))
                <a href="{{ session('info_url') }}">{{ session('info_url_txt') }}</a>
                @endif
            </p>
            <div class="close_btn"><i class="ion-ios-close"></i></div>
        </div>
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-info">
        <div class="title">
            <p>{{ session('info') }}</p>
            <div class="close_btn"><i class="ion-ios-close"></i></div>
        </div>
    </div>
@endif

@if(session()->has('status'))
    <div class="alert alert-info">
        <div class="title">
            <p>{{ session('status') }}</p>
            <div class="close_btn"><i class="ion-ios-close"></i></div>
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger">
        <div class="title">
            <p>{{ session('error') }}</p>
            <div class="close_btn"><i class="ion-ios-close"></i></div>
        </div>
    </div>
@endif