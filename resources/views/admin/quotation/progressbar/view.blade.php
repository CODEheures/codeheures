@if($quotation->isOrdered)
<div class="quotation-progress published viewed purchased">
@elseif($quotation->isViewed)
<div class="quotation-progress published viewed">
@elseif($quotation->isPublished)
<div class="quotation-progress published">
@else
<div class="quotation-progress">
@endif
<div class="quotation-progress-1">
    <div class="point"><i class="ion-record"></i></div>
    <div class="bar"></div>
</div>
<div class="quotation-progress-2">
    <div class="point"><i class="ion-record"></i></div>
    <div class="bar"></div>
    <div class="point"><i class="ion-record"></i></div>
</div>
<div class="quotation-progress-3">
    <div class="bar"></div>
    <div class="point"><i class="ion-record"></i></div>
</div>
</div>
<div class="quotation-progress-text">
    <div class="quotation-progress-1">
        <p>publié</p>
    </div>
    <div class="quotation-progress-2">
        <p>vu</p>
    </div>
    <div class="quotation-progress-3">
        <p>signé</p>
    </div>
</div>