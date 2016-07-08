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
@if($quotation->isRefused)
<div class="quotation-progress refuse published viewed  refused">
@else
<div class="quotation-progress refuse">
@endif
    <div class="quotation-progress-2b">
        <div class="bifurcation"><i class="ion-minus-round"></i></div>
    </div>
    <div class="quotation-progress-3">
        <div class="bar"></div>
        <div class="point"><i class="ion-record"></i></div>
    </div>
</div>
<div class="quotation-progress-text refuse">
    <div class="quotation-progress-3">
        <p>refusé</p>
    </div>
</div>