
{!! Form::model($newQuotation, ['class' => 'form-horizontal', 'url' => route('admin.quotation.store')]) !!}
    <div class="quotation">
        <div class="form-group">
            {!! Form::label('user_id', 'Client') !!}
            {!! Form::select('user_id', $userList, null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('validity', 'Date de validité') !!}
            {!! Form::input('date', 'validity', Carbon\Carbon::now()->formatLocalized('%Y-%m-%d'), ['class' => 'form-control', 'placeholder' => '10-11-2015']) !!}
        </div>

        <div class="form-group">
            <div class="submit">
                <input type="submit" class="btn-yellow2" value="Ajouter" />
            </div>
        </div>
    </div>
{!! Form::close() !!}


<div class="clear"></div>