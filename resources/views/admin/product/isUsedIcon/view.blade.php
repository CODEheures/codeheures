@if($product->lineQuotes->count() > 0 || $product->purchases->count() > 0)
    <i class="fa fa-check"></i>
@else
@endif