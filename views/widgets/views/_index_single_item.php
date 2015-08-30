<?php
/**
 * Comment item view.
 *
 * @var \yii\web\View $this View
 * @var \net\frenzel\comment\models\frontend\Comment[] $models Comment models
 * && $model->next_type == \net\frenzel\activity\models\Activity::TYPE_APPOINTMENT
 */
use yii\helpers\Url;
?>
<?php if ($model !== null) : ?>
    <div class="media" data-activity="parent" data-activity-id="<?= $model->id ?>">
        <div class="media-left">
            <img src="http://gravatar.com/avatar/<?= $model->author->profile->gravatar_id ?>?s=35" alt="" class="img-rounded" />

            <i class="fa fa-<?= $model->TypeAsIcon; ?> fa-3x"></i>
        </div>
        <div class="media-body" data-activity="append">
            <div class="media-heading">
                <div>
                    <small><?= \Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                    by <?= $model->author->username ?>&nbsp;</small>
                </div> 
            </div>
            <?php if (!is_null($model->deleted_at)) { ?>
                <?= \Yii::t('net_frenzel_activity', 'deleted') ?>
            <?php } else { ?>
                <div class="content" data-activity="content"><?= $model->text ?></div>                        
            <?php } ?> 

            <div class="pull-right">
            <?php
                $nextResponsible = is_object($model->responsible)?$model->responsible->username:'EVERYONE';
                echo '<i class="fa fa-hand-o-right fa-2x"></i> ' . $nextResponsible . ' has a ' . $model->NextTypeAsString . ' at ' . \Yii::$app->formatter->asDateTime($model->next_at); ?>
            </div>           

            <?php if (is_null($model->deleted_at)) { ?>
                <div data-activity="tools">
                    <?php if (Yii::$app->user->identity->isAdmin) { ?>
                        <a href="#" data-activity="update" data-activity-id="<?= $model->id ?>" data-activity-url="<?= Url::to([
                            '/activity/default/update',
                            'id' => $model->id
                        ]) ?>" data-activity-fetch-url="<?= Url::to([
                            '/activity/default/fetch',
                            'id' => $model->id
                        ]) ?>">
                            <i class="fa fa-pencil"></i> <?= \Yii::t('app', 'update') ?>
                        </a>
                    <?php } ?>
                    <?php if (Yii::$app->user->identity->isAdmin) { ?>
                        <a href="#" data-activity="delete" data-activity-id="<?= $model->id ?>" data-activity-url="<?= Url::to([
                            '/activity/default/delete',
                            'id' => $model->id
                        ]) ?>" data-confirm="<?= \Yii::t('net_frenzel_activity', 'FRONTEND_WIDGET_ACTIVITY_DELETE_CONFIRMATION') ?>">
                            <i class="fa fa-remove"></i> <?= \Yii::t('app', 'delete') ?>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div class="media-right">
            <i class="fa fa-<?= $model->NextTypeAsIcon; ?> fa-3x text-primary"></i>            
        </div>
        
        <hr>
    </div>
<?php endif; ?>
