@if($product->lineQuotes->count() > 0 || $product->purchases->count() > 0)
@else
    <span>(Non Utilisé)</span>
@endif