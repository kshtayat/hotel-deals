
<div class="hotel row">
    <div class="thumb col-lg-3 col-md-3 col-sm-3 col-xs-4">
        <div class="thumb">
        <img src="<?=str_replace('t.jpg','b.jpg',$model->hotelInfo->hotelImageUrl)?>" alt="<?=$model->hotelInfo->hotelName?>">
        </div>
    </div>
    <div class="content col-lg-9 col-md-9 col-sm-9 col-xs-8">
        <div class="content">
            <a href="<?=urldecode($model->hotelUrls->hotelInfositeUrl)?>" class="name" target="_blank">
                <?=$model->hotelInfo->hotelName?>
            </a>
            <div class="rating">
                <?= \kartik\rating\StarRating::widget([
                    'name' => 'rating',
                    'value' => $model->hotelInfo->hotelStarRating,
                    'pluginOptions' => [
                        'size'=>'',
                        'readonly' => true,
                        'showClear' => false,
                        'showCaption' => false,
                    ],
                ]);
                ?>
            </div>
            <div class="address"><?=$model->hotelInfo->hotelStreetAddress?>, <?=$model->hotelInfo->hotelLongDestination?></div>
            <div class="description"><?=$model->hotelInfo->hotelDestination?> </div>
            <div class="price">
                <span class="now">$<?=$model->hotelPricingInfo->averagePriceValue?></span>
                <span class="price-label">avg/night</span>
            </div>
            <div class="travel-dates"><?=implode('-',$model->offerDateRange->travelStartDate)?> - <?=implode('-',$model->offerDateRange->travelEndDate)?></div>
        </div>
    </div>
</div>