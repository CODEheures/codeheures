<div class="product">
    @if(count($products)>0)
        <table>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="admin">
                        <i class="ion-minus-round"></i>
                        <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                            {{ $product->description }}
                        </a>
                        @include('admin.product.isUsedIcon.view')
                        <span class="product-price">{{ $product->price }} €</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun produit en vente...</p>
    @endif
</div>