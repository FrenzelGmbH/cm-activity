<?php
/**
 * Comment widget form view.
 * @var \yii\web\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \net\frenzel\comment\models\frontend\Comment $model New comment model
 */
use yii\helpers\Html;
use yii\web\JsExpression;
use kartik\datetime\DateTimePicker;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;

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

<div class="row" data-activity="form-group">
    <div class="col-sm-12">
    <div class="col-sm-12"><?= \Yii::t('net_frenzel_activity','Now'); ?>:
        <?= $form->field($model, 'type')->radioButtonGroup($model->TypeArray,[
                //'class' => 'btn-group-sm',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-warning']]
            ])->label(false);?>
         <?= Html::error($model, 'type', ['data-activity' => 'form-summary', 'class' => 'help-block hidden']) ?>
    </div>
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
        <?= Html::error($model, 'next_at', ['data-activity' => 'form-summary', 'class' => 'help-block hidden']) ?>
    </div>
    <div class="col-sm-8"><?= \Yii::t('net_frenzel_activity','Next'); ?>:
        <?= $form->field($model, 'next_type')->radioButtonGroup($model->NextTypeArray,[
                //'class' => 'btn-group-sm',
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']]
            ])->label(false);?>
        <?= Html::error($model, 'next_type', ['data-activity' => 'form-summary', 'class' => 'help-block hidden']) ?>
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-9">
            <?php
            $userDesc = empty($model->next_by) ? '' : $model->responsible->username;
            $url = \yii\helpers\Url::to(['/activity/default/responsible-list']);

            echo $form->field($model, 'next_by')->widget(Select2::classname(), [
                'initValueText' => $userDesc,
                'options' => ['placeholder' => 'responsible ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(user) { return user.text; }'),
                    'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                ],
            ])->label(false);
            ?>
        </div>
        <div class="col-md-3">
            <?= Html::submitButton('<i class="fa fa-check"></i> ' . \Yii::t('net_frenzel_activity', 'submit'), ['class' => 'btn btn-success btn-block']); ?>
        </div>
    </div>
</div>

<?= Html::activeHiddenInput($model, 'entity') ?>
<?= Html::activeHiddenInput($model, 'entity_id') ?>
<?= Html::endForm(); ?>
<div class="clearfix"></div>