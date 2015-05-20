<?php
/**
 * Comment widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \net\frenzel\comment\models\frontend\Comment $model New comment model
 */
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
use kartik\form\ActiveForm;
?>

<div class="panel panel-default">
    <div class="panel-body">
<?php $form = ActiveForm::begin([
        'action' => ['/activity/default/update','id' => $model->id], 
        'method' => 'POST', 
        'options' => [
            'class' => 'form-horizontal', 
            'data-activity' => 'form', 
            'data-activity-action' => 'update',
            'data-activity-id' => $model->id,
        ]
    ]
) ?>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12">
        <?= net\frenzel\textareaautosize\yii2textareaautosize::widget([
		      'model'=> $model,
		      'attribute' => 'text'
		  ]);
    	?>
        <?= Html::error($model, 'text', ['data-activity' => 'form-summary', 'class' => 'help-block hidden']) ?>
    </div>
</div>

<div class="form-group" data-activity="form-group">
        <div class="col-sm-4">
    <?= \Yii::t('net_frenzel_activity','When'); ?>:
<?= DateTimePicker::widget([
    'model' => $model,
    'attribute' => 'next_at',
    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
    'options' => [
        'id' => 'activity-next_at-' . $model->id,    
    ],
    'pluginOptions' => [
        'autoclose'=>true,
    ]
]); ?>
    </div>
    <div class="col-sm-8"><?= \Yii::t('net_frenzel_activity','What'); ?>:
        <?= $form->field($model, 'next_type')->radioButtonGroup($model->NextTypeArray,[
                //'class' => 'btn-group-sm',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
            ])->label(false);?>
    </div>   
</div>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12">
        <?= Html::submitButton('<i class="fa fa-check"></i> ' . \Yii::t('net_frenzel_activity', 'submit'), ['class' => 'btn btn-success btn-block']); ?>
    </div>
</div>

<?= Html::activeHiddenInput($model, 'entity') ?>
<?= Html::activeHiddenInput($model, 'entity_id') ?>
<?= Html::activeHiddenInput($model, 'type') ?>
<?php ActiveForm::end(); ?>

    </div>
</div>

<div class="clearfix"></div>