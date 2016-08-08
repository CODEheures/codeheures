<div class="quotation">
    @if(count($quotations)>0)
        @foreach($quotations as $quotation)
            <div class="quotations-list">
                <div class="description">
                    <a href="{{ route('admin.quotation.edit', ['id' => $quotation->id]) }}" class="quotation-number">
                        <i class="ion-minus-round"></i>
                        N°{{ $quotation->getPublicNumber() }}
                        <span class="quotation-date"> du {{ $quotation->created_at->formatLocalized('%d-%m-%Y') }}:</span>
                        "{{ $quotation->user->email }}"
                    </a>
                    <ul>
                        @foreach($quotation->lineQuotes as $lineQuote)
                            <li>{{ $lineQuote->product->description }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="progress-icon">
                    @include('admin.quotation.progressicon.view')
                </div>
                <div class="price">
                    <span class="total-price-quotation">{{ \App\Common\FormatManager::price($quotation->totalPrice(true)) }} €</span>
                </div>
            </div>
        @endforeach
    @else
        <p>Aucun devis client...</p>
    @endif
</div>