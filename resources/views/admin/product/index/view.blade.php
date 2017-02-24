<div class="product">
    @if(count($products)>0)
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Utilisé</th>
                    <th>Obsolète</th>
                    <th>Réserve à</th>
                    <th style="min-width: 11rem;">Prix</th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td class="admin">
                        <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                            {{ $product->description }}
                        </a>
                    </td>
                    <td>
                        @include('admin.product.isUsedIcon.view')
                    </td>
                    <td>
                        @include('admin.product.isObsoleteIcon.view')
                    </td>
                    <td>
                        @if($product->reservedForUserId && $product->reservedForUserId > 0)
                            {{ $product->getReservedUser()->name }}
                        @endif
                    </td>
                    <td>
                        <span class="product-price">{{ \App\Common\FormatManager::price($product->price) }} €</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun produit en vente...</p>
    @endif
</div>