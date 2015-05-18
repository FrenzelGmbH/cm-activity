<?php
/**
 * Comment item view.
 *
 * @var \yii\web\View $this View
 * @var \net\frenzel\comment\models\frontend\Comment[] $models Comment models
 */
use yii\helpers\Url;
?>
<?php if ($models !== null) : ?>
    <?php foreach ($models as $activity) : ?>
        <div class="media" data-activity="parent" data-activity-id="<?= $activity->id ?>">
            <div class="media-left">
                <i class="fa fa-<?= $activity->TypeAsIcon; ?> fa-3x"></i>
            </div>
            <div class="media-body">
                <div data-activity="append">
                    <?php if (!is_null($activity->deleted_at)) { ?>
                        <?= \Yii::t('net_frenzel_activity', 'deleted') ?>
                    <?php } else { ?>
                        <div class="content" data-activity="content"><?= $activity->text ?></div>
                    <?php } ?>
                    <div class="media-heading">
                        <div>
                            <small><?= \Yii::$app->formatter->asRelativeTime($activity->created_at) ?>
                            by <?= $activity->author->username ?>&nbsp;</small>
                        </div> 
                    </div>                    
                <?php if (is_null($activity->deleted_at)) { ?>
                    <div class="pull-left" data-activity="tools">
                        <?php if (Yii::$app->user->identity->isAdmin) { ?>
                            &nbsp;
                            <a href="#" data-activity="update" data-activity-id="<?= $activity->id ?>" data-activity-url="<?= Url::to([
                                '/activity/default/update',
                                'id' => $activity->id
                            ]) ?>">
                                <i class="fa fa-pencil"></i> <?= \Yii::t('net_frenzel_activity', 'edit') ?>
                            </a>
                        <?php } ?>
                        <?php if (Yii::$app->user->identity->isAdmin) { ?>
                            &nbsp;
                            <a href="#" data-activity="delete" data-activity-id="<?= $activity->id ?>" data-activity-url="<?= Url::to([
                                '/activity/default/delete',
                                'id' => $activity->id
                            ]) ?>" data-activity-confirm="<?= \Yii::t('net_frenzel_activity', 'FRONTEND_WIDGET_ACTIVITY_DELETE_CONFIRMATION') ?>">
                                <i class="fa fa-remove"></i> <?= \Yii::t('net_frenzel_activity', 'delete') ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                </div>
            </div>
            <div class="media-right">
                <img src="http://gravatar.com/avatar/<?= $activity->author->profile->gravatar_id ?>?s=50" alt="" class="img-rounded" />                
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>