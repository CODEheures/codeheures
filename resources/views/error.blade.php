@if($errors->any())
    <div class="alert alert-danger">
        <div class="title">
            <p><strong>Attention</strong>, merci de corriger les erreurs suivantes</p>
            <div class="close_btn"><i class="ion-ios-close"></i></div>
        </div>
        <ol>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@endif