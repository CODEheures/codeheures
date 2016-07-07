@if($quotation->isPurchased)
    <p>Publié? <i class="ion-ios-checkmark-outline"></i></p>
    <p>Vu? <i class="ion-ios-checkmark-outline"></i></p>
    <p>Signé? <i class="ion-ios-checkmark-outline"></i></p>
@elseif($quotation->isViewed)
    <p>Publié? <i class="ion-ios-checkmark-outline"></i></p>
    <p>Vu? <i class="ion-ios-checkmark-outline"></i></p>
    <p>Signé? <i class="ion-ios-minus-outline"></i></p>
@elseif($quotation->isPublished)
    <p>Publié? <i class="ion-ios-checkmark-outline"></i></p>
    <p>Vu? <i class="ion-ios-minus-outline"></i></p>
    <p>Signé? <i class="ion-ios-minus-outline"></i></p>
@else
    <p>Publié? <i class="ion-ios-minus-outline"></i></p>
    <p>Vu? <i class="ion-ios-minus-outline"></i></p>
    <p>Signé? <i class="ion-ios-minus-outline"></i></p>
@endif