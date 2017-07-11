<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = $title;
?>
<div class="site-index">
    <div class="text-center">
        <?=Html::img('images/logo_header.png',['title'=>'expedia','alt'=>'www.expedia.com'])?>
    </div>
    <?=$this->render('_search',['title'=>$title,'model'=>$searchModel])?>

    <?= \yii\widgets\ListView::widget(
        [
            'dataProvider' => $dataProvider,
            'itemView'     =>  '_item_view',
        ])?>
</div>
