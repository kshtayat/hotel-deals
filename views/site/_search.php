<?php
/* Partial render for Search Attribute form */

$countries = require('../constant/countries.php');

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model \app\models\SearchForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="search-form  text-center">
    <h1><?=$title?></h1>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id'=>'find-deals',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true
    ]); ?>
    <div class="form-group form-inline">
        <?= $form->field($model, 'destinationCountry',['inputOptions'=>['placeholder'=>'Destination Country'],
            'template'=>"{input}{error}",
            'options'=>['class'=>'form-group inlineBlock']])->widget(\yii\jui\AutoComplete::classname(), [
            'clientOptions' => [
                'source' => $countries,
            ]
        ])->textInput(['placeholder' => 'Destination Country']); ?>
        
        <?= $form->field($model, 'destinationCity',['inputOptions' =>['placeholder' => 'Destination City'],
            'template' => "{input}{error}",'options'=>['class'=>'form-group inlineBlock']])
        ?>
    </div>
    <div class="form-group form-inline">
        <?= $form->field($model, 'minTripStartDate',['inputOptions'=>['placeholder'=>'Check-in'],
            'options'=>['class'=>'form-group inlineBlock']])->widget(DatePicker::classname(), [
                    'clientOptions' => ['defaultDate' => date('Y-m-d'),
                    'minDate' => date('Y-m-d'),
                    'maxDate' => date('Y-m-d', strtotime('+1 year')),
                    ],
                    'dateFormat' => 'yyyy-MM-dd'
        ])->textInput(['placeholder' => 'Y-M-D'])->label('Check-in') ?>
        
        <?= $form->field($model, 'maxTripStartDate',['inputOptions'=>['placeholder'=>'Check-out'],
            'options'=>['class'=>'form-group inlineBlock']])->widget(DatePicker::classname(), [
            'clientOptions' => ['defaultDate' => date('Y-m-d',time()+3*24*60*60),
                    'minDate' => date('Y-m-d'),
                    'maxDate' => date('Y-m-d', strtotime('+1 year')),
                ],
            'dateFormat' => 'yyyy-MM-dd'
        ])->textInput(['placeholder' => 'Y-M-D'])->label('Check-out') ?>
    </div>
    <div class="form-group form-inline">
        <?= $form->field($model, 'minTotalRate',['inputOptions' =>['placeholder' => 'Min Total Rate'],
            'template' => "{input}{error}",'options'=>['class'=>'form-group inlineBlock','min'=>'0']])
        ?>
        <?= $form->field($model, 'maxTotalRate',['inputOptions' =>['placeholder' => 'Max Total Rate'],
            'template' => "{input}{error}",'options'=>['class'=>'form-group inlineBlock','min'=>'0']])
        ?>
    </div>
    <div class="form-group">
        <label>Min/Max Star Rate</label>
        <label id="starrating"></label>

        <?=\yii\jui\Slider::widget([
            'clientOptions' => [
                'min' => 1,
                'max' => 5,
                'values'=>[$model->minStarRating,$model->maxStarRating],
                'tooltip'=>'always',
                'range'=>true,
                'slide'=> new yii\web\JsExpression("function( event, ui ) {
                        $('#searchform-minstarrating' ).val( ui.values[ 0 ]);
                        $('#searchform-maxstarrating' ).val( ui.values[ 1 ]);
                        $('#starrating' ).html('(' + ui.values[ 0 ] +' - '+ui.values[ 1 ]+')');
                    }"),
            ],
        ]);?>
        <?= $form->field($model, 'minStarRating')->hiddenInput()->label(false);?>
        <?= $form->field($model, 'maxStarRating')->hiddenInput()->label(false);?>
    </div>
    <div class="form-group">
        <label>Min/Max Guest Rating</label>
        <label id="guestRating"></label>
        
        <?=\yii\jui\Slider::widget([
            'clientOptions' => [
                'min' => 1,
                'max' => 5,
                'values'=>[$model->minGuestRating,$model->minGuestRating],
                'tooltip'=>'always',
                'range'=>true,
                'slide'=> new yii\web\JsExpression("function( event, ui ) {
                            $('#searchform-minguestrating' ).val( ui.values[ 0 ]);
                            $('#searchform-maxguestrating' ).val( ui.values[ 1 ]);
                            $('#guestRating' ).html('('+  ui.values[ 0 ] +' - '+ui.values[ 1 ]+')');
                        }"),
            ],
        ]);?>
        <?= $form->field($model, 'minGuestRating')->hiddenInput()->label(false);?>
        <?= $form->field($model, 'maxGuestRating')->hiddenInput()->label(false);?>
    </div>
    <div class="form-group align-center">
        <?= Html::submitButton('Search', ['class' => 'btn btn-lg btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>