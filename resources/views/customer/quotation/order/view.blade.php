<div class="quotation-title">
    <h2><i class="ion-ios-information-outline"></i>Devis N°{{ $quotation->getPublicNumber() }}:</h2>
    <div class="price-quotation">
        <div class="btn-fake total-price-quotation-info">
            Coût total: {{ \App\Common\FormatManager::price($quotation->totalPrice(true)) }}€
        </div>
    </div>
</div>
@if(!isset($isPdf) || !$isPdf)
<nav class="quotation-get-pdf">
    <p><a href="{{ route('customer.quotation.showPdf', ['id' => $quotation->id]) }}"><i class="ion-archive"></i>Télécharger ce devis</a></p>
</nav>
@endif
<div class="quotation">
    <p class="order-validity">
        <span class="quotation-date"> valable jusqu'au {{ \Carbon\Carbon::parse($quotation->validity)->formatLocalized('%A %e %B %Y') }}:</span>@if(!isset($isPdf) || !$isPdf)<span class="signature">CODE SMS A CONFIRMER en bas de page</span>@endif
    </p>
    @include('customer.quotation.table.view')
    @if($quotation->downPercentPayment)
    <p class="downPercentPayment">L'acceptation de ce devis donnera lieu à un acompte de {{ $quotation->downPercentPayment }}%</p>
    @endif
    @include('legal.quotation.mentions')
</div>

@if(!isset($isPdf) || !$isPdf)
<div class="quotation-title">
    <h2><i class="ion-ios-locked-outline"></i>Signature éléctronique</h2>
</div>

<div class="quotation">

    {!! Form::open(['class' => 'form-horizontal', 'url' => route('customer.quotation.order.post', ['id' => $quotation->id])]) !!}

            {!! Form::hidden('email', auth()->user()->email, ['class' => 'form-control form-disable']) !!}
            {!! Form::hidden('phone', '0'.auth()->user()->phone, ['class' => 'form-control form-disable']) !!}

        <div class="form-group" @if(auth()->user()->isDemo) data-intro="rentrez ici le code SMS
            et le compte client est mis à jour. Ainsi CODEheures peut commencer à travailler sur votre projet de suite
            en attendant le retour courrier signé"
             data-step="2" data-position="bottom" @endif>
            <span class="input input--fumi">
                {!! Form::text('smsCode', '', ['class' => 'input__field input__field--fumi', 'placeholder' => '123456']) !!}
                <label for="smsCode" class="input__label input__label--fumi">
                    <i class="fa fa-fw fa-user-secret icon icon--fumi"></i>
                    <span class="input__label-content input__label-content--fumi">Code de confirmation</span>
                </label>
            </span>
        </div>

        <div class="form-submit">
            <div class="submit">
                <input type="submit" class="btn-yellow2" value="Signer" />
            </div>
        </div>

    {!! Form::close() !!}
</div>
@endif