<?php
/**
 * Activity list view.
 *
 * @var \yii\web\View $this View
 * @var \net\frenzel\activity\models\Activity[] $models Activity models
 * @var \net\frenzel\activity\models\Activity $model New Activity model
 *
 * style="max-height:280px; overflow-y:scroll;"
 */

?>

<div id="activity">

<div class="panel panel-info">
	<div class="panel-heading">
		<h4 class="panel-title">
			<i class="fa fa-comments-o"></i> 
			<?= \Yii::t('net_frenzel_activity', 'Activity') ?>
		</h4>
	</div>
	<div class="panel-body">
		<?php if (!\Yii::$app->user->isGuest) : ?>	        
	        <?= $this->render('_form', ['model' => $model]); ?>
    	<?php endif; ?>		
		<!--/ #activity-list -->
		<div id="activity-list" data-activity="list">
	        <?= $this->render('_index_item', ['models' => $models]) ?>
	    </div>
    	<!--/ #activity-list -->		
	</div>	
</div>
    
</div>