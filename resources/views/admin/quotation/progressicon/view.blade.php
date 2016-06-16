@if($quotation->isPurchased)
<p>P<i class="ion-ios-checkmark-outline"></i> V<i class="ion-ios-checkmark-outline"></i> S<i class="ion-ios-checkmark-outline"></i></p>
@elseif($quotation->isViewed)
    <p>P<i class="ion-ios-checkmark-outline"></i> V<i class="ion-ios-checkmark-outline"></i> S<i class="ion-ios-minus-outline"></i></p>
@elseif($quotation->isPublished)
    <p>P<i class="ion-ios-checkmark-outline"></i> V<i class="ion-ios-minus-outline"></i> S<i class="ion-ios-minus-outline"></i></p>
@else
    <p>P<i class="ion-ios-minus-outline"></i> V<i class="ion-ios-minus-outline"></i> S<i class="ion-ios-minus-outline"></i></p>
@endif