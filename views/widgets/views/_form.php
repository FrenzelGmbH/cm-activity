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

<?php $form = ActiveForm::begin([
        'action' => ['/activity/default/create'], 
        'method' => 'POST', 
        'options' => [
            'class' => 'form-horizontal', 
            'data-activity' => 'form', 
            'data-activity-action' => 'create'
        ]
    ]
) ?>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12"><?= \Yii::t('net_frenzel_activity','Now'); ?>:
        <?= $form->field($model, 'type')->radioButtonGroup($model->TypeArray,[
                //'class' => 'btn-group-sm',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-warning']]
            ])->label(false);?>
    </div>
</div>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12"><?= \Yii::t('net_frenzel_activity','Notes'); ?>:
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
                'pluginOptions' => [
                    'autoclose'=>true,
                ]
            ]); ?>
    </div>
    <div class="col-sm-8"><?= \Yii::t('net_frenzel_activity','Next'); ?>:
        <?= $form->field($model, 'next_type')->radioButtonGroup($model->NextTypeArray,[
                //'class' => 'btn-group-sm',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
            ])->label(false);?>
    </div>    
</div>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12">
        <?= Html::submitButton('<i class="fa fa-check"></i> ' . \Yii::t('net_frenzel_activity', 'submit'), ['class' => 'btn btn-default btn-block']); ?>
    </div>
</div>

<?= Html::activeHiddenInput($model, 'entity') ?>
<?= Html::activeHiddenInput($model, 'entity_id') ?>
<?= Html::endForm(); ?>
<div class="clearfix"></div>