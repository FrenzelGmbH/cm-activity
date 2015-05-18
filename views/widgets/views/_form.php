<?php
/**
 * Comment widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \net\frenzel\comment\models\frontend\Comment $model New comment model
 */
use yii\helpers\Html;
?>

<?= Html::beginForm(
    ['/activity/default/create'], 
    'POST', 
    [
        'class' => 'form-horizontal', 
        'data-activity' => 'form', 
        'data-activity-action' => 'create'
    ]
) ?>
<?= Html::activeRadioList($model, 'type', $model->TypeArray); ?>
    <div class="form-group" data-activity="form-group">
        <div class="col-sm-9">
            <?= net\frenzel\textareaautosize\yii2textareaautosize::widget([
			      'model'=> $model,
			      'attribute' => 'text'
			  ]);
        	?>
            <?= Html::error($model, 'text', ['data-activity' => 'form-summary', 'class' => 'help-block hidden']) ?>
        </div>
        <div class="col-sm-3">
        	<?= Html::submitButton('<i class="fa fa-check"></i> ' . \Yii::t('net_frenzel_activity', 'send '), ['class' => 'btn btn-default btn-block']); ?>
        </div>
    </div>
<?= Html::activeHiddenInput($model, 'entity') ?>
<?= Html::activeHiddenInput($model, 'entity_id') ?>
<?= Html::endForm(); ?>
<div class="clearfix"></div>