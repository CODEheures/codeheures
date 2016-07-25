{!! Form::open(['url' => route('contact.post')]) !!}

    @if(auth()->check())
        {!! Form::hidden('email', auth()->user()->email) !!}
        @else
        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::email('email', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex: jack.sparrow@pearl.bl']) !!}
                <label for="email" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-envelope icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Email</span>
                </label>
            </span>
        </div>
    @endif
        <div class="form-group @if(auth()->check()) full-width @endif">
            <span class="input input--fumi">
                {!! Form::textarea('content', null, ['class' => 'input__field input__field--fumi', 'placeholder' => 'Votre message ici...', 'rows' => '3']) !!}
                <label for="content" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-align-left icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Votre message</span>
                </label>
            </span>
        </div>

        <div class="form-submit">
            <div class="submit">
                <input type="submit" class="btn-yellow2" value="Envoyer le message" />
            </div>
        </div>
{!! Form::close() !!}