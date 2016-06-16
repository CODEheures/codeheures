@if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Attention</strong>, merci de corriger les erreurs suivantes</p>
        <div class="close_btn"><i class="ion-ios-close"></i></div>
        <ol>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@endif