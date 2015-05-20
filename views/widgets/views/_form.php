<?php
/**
 * Comment widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \net\frenzel\comment\models\frontend\Comment $model New comment model
 */
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
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

<div class="form-group" data-activity="form-group" id="form-activity-type-section">
    <div class="col-sm-12"><?= \Yii::t('net_frenzel_activity','Now'); ?>:
<?= Html::activeRadioList($model, 'type', $model->TypeArray,[
    'tag' => 'div',
    'item' => function($index, $label, $name, $checked, $value)
    {
        $return = '<label class="btn btn-info">';
        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
        $return .= ' ' . $label;
        $return .= '</label>';
        return $return;
    }
]); ?>
    </div>
</div>

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
    'type' => DateTimePicker::TYPE_INPUT,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy hh:ii'
    ]
]); ?>
    </div>
    <div class="col-sm-8"><?= \Yii::t('net_frenzel_activity','What'); ?>:
<?= Html::activeRadioList($model, 'next_type', $model->NextTypeArray,[
    'tag' => 'div',
    'item' => function($index, $label, $name, $checked, $value)
    {
        $return = '<label class="btn btn-primary">';
        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
        $return .= ' ' . $label;
        $return .= '</label>';
        return $return;
    }
]); ?>
    </div>    
</div>

<div class="form-group" data-activity="form-group">
    <div class="col-sm-12">
        <?= Html::submitButton('<i class="fa fa-check"></i> ' . \Yii::t('net_frenzel_activity', 'submit'), ['class' => 'btn btn-success btn-block']); ?>
    </div>
</div>

<?= Html::activeHiddenInput($model, 'entity') ?>
<?= Html::activeHiddenInput($model, 'entity_id') ?>
<?= Html::endForm(); ?>
<div class="clearfix"></div>