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
    <?php foreach ($models as $model) : ?>
        <?= $this->render('_index_single_item', ['model' => $model]) ?>
    <?php endforeach; ?>
<?php endif; ?>