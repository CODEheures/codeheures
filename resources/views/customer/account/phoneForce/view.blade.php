<div class="form-title">
    <p>Indiquez votre numéro de mobile pour l'envoi du code de confirmation</p>
</div>
{!! Form::model($user, ['url' => route('customer.account.phone.update'), 'class' => 'form-horizontal']) !!}
{!! Form::hidden('routeReturn', json_encode($routeReturn)) !!}

    <div class="form-group">
        <span class="input input--fumi">
            {!! Form::text('phone', ($user->phone != null  ? '0'.$user->phone:null), ['class' => 'input__field input__field--fumi', 'placeholder' => 'Ex.: 0611223344']) !!}
            <label for="phone" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-mobile icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Numéro de mobile</span>
            </label>
        </span>
    </div>
    <div class="form-submit">
        <div class="submit">
            <input type="submit" class="btn btn-yellow2" value="Valider" />
        </div>
    </div>
{!! Form::close() !!}