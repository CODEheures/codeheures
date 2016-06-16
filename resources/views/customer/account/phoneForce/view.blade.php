<div class="form-title">
    <p>Indiquez votre numéro de mobile pour l'envoi du code de confirmation</p>
</div>
{!! Form::model($user, ['url' => route('customer.account.phone.update'), 'class' => 'form-horizontal']) !!}
{!! Form::hidden('routeReturn', json_encode($routeReturn)) !!}

    <div class="form-group">
        {!! Form::label('phone', 'Numero de mobile') !!}
        {!! Form::text('phone', ($user->phone != null  ? '0'.$user->phone:null), ['class' => 'form-control', 'placeholder' => 'Ex.: 0611223344']) !!}
    </div>
    <div class="form-group">
        <div class="submit">
            <input type="submit" class="btn btn-yellow2" value="Valider" />
        </div>
    </div>
{!! Form::close() !!}