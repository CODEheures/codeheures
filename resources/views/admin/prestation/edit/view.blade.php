<div class="prestation-title">
    <h2><i class="ion-ios-information-outline"></i>Informations prestation standard</h2>
    <div class="btn-fake prestation-duration">
        Durée facturée: {{ $prestation->duration }} heure(s)
    </div>
</div>
<div class="prestation">
    <?php if($prestation->id != null) {
        $method = 'put';
        $route = route('admin.prestation.update', ['id' => $prestation->id]);
        $submitText = 'modifier';
    } else {
        $method = 'post';
        $route = route('admin.prestation.store');
        $submitText = 'créer';
    }
     ?>
    {!! Form::model($prestation, ['method'=>$method, 'class' => 'form-horizontal', 'url' => $route]) !!}
        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('text','name', null, ['class' => 'input__field input__field--fumi'. ($prestation->canEdit() == false ? ' form-disable':'')]) !!}
                <label for="name" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-quote-left icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Nom de la prestation</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('number','duration', null, ['class' => 'input__field input__field--fumi'. ($prestation->canEdit() == false ? ' form-disable':''), 'min' => 0, 'step' => '0.01']) !!}
                <label for="duration" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-plus icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Durée Facturée (heures)</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::textarea('description', null, ['class' => 'input__field input__field--fumi'. ($prestation->canEdit() == false ? ' form-disable':''), 'placeholder' => '10h de webmastering...']) !!}
                <label for="description" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-comment-o icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Description</span>
                </label>
            </span>
        </div>

        <div class="form-group">
            <span class="input input--fumi">
                {!! Form::input('url', 'url', null, ['class' => 'input__field input__field--fumi'. ($prestation->canEdit() == false ? ' form-disable':''), 'placeholder' => 'http://...']) !!}
                <label for="url" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-link icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Lien Web</span>
                </label>
            </span>
        </div>

        <div class="form-submit">
            <div class="submit">
                @if($prestation->canEdit())
                    <input type="submit" class="btn-yellow2" value="{{ $submitText }}" />
                @else
                    <input type="submit" class="btn-disable" value="{{ $submitText }}" />
                @endif
            </div>
        </div>
    {!! Form::close() !!}
</div>


<div class="product-title">
    <h2><i class="ion-ios-people-outline"></i>Publication</h2>
</div>
<div class="product">
    <div class="form-submit">
        @if($prestation->id != null && $prestation->canEdit())
            <a href="{{ route('admin.prestation.publish', ['id' => $prestation->id]) }}" class="btn-yellow2">Publier</a>
            <a href="{{ route('admin.prestation.delete', ['id' => $prestation->id]) }}" class="btn-yellow2">Supprimer</a>
        @else
            <a href="#" class="btn-disable">Publier</a>
            <a href="#" class="btn-disable">Supprimer</a>
        @endif
        @if($prestation->id != null && $prestation->isPublished)
            @if(!$prestation->isObsolete)
                <a href="{{ route('admin.prestation.toObsolete', ['id' => $prestation->id]) }}" class="btn-yellow2">Rendre obsolete</a>
            @else
                <a href="{{ route('admin.prestation.toNotObsolete', ['id' => $prestation->id]) }}" class="btn-yellow2">Rendre non-obsolete</a>
            @endif
        @endif
    </div>
</div>