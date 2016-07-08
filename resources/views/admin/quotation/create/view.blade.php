
{!! Form::model($newQuotation, ['class' => 'form-horizontal', 'url' => route('admin.quotation.store')]) !!}
    <div class="quotation">
        <div class="form-group">
            <span class="input input--fumi">
                    {!! Form::select('user_id', $userList, null, ['class' => 'input__field input__field--fumi']) !!}
                    <label for="user_id" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-user icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Client</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('date', 'validity', Carbon\Carbon::now()->formatLocalized('%Y-%m-%d'), ['class' => 'input__field input__field--fumi', 'placeholder' => '10-11-2015']) !!}
                <label for="validity" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-calendar icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Date de validité</span>
                </label>
            </span>
        </div>

        <div class="form-submit">
            <div class="submit">
                <input type="submit" class="btn-yellow2" value="Ajouter" />
            </div>
        </div>
    </div>
{!! Form::close() !!}


<div class="clear"></div>