<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PolizzenserviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="bgwhite">

<?php 

$redirect = Url::toRoute([$targetUrl,'entityTitleField' => $entityTitleField,'id'=>''],true);

$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
    var url = '{$redirect}' + calEvent.id;
    $(location).attr('href',url);
}
EOF;
	
	?>

	<?= yii2fullcalendar\yii2fullcalendar::widget([
          'options' => [
            'lang' => substr(\Yii::$app->language,0,2),
            'class' => 'fullcalendar'
          ],
          'header' => [
            'left' => 'prev',
            'center' => 'title',
            'right' => 'next'
          ],  
          'clientOptions' => [
                'defaultView' => 'agendaDay',
                'height' => 400,
                'selectable' => true,
                'selectHelper' => true,
                'defaultDate' => date('Y-m-d'),
                'eventClick' => new JsExpression($JSEventClick),
                'eventLimit' => true
          ],
          'ajaxEvents' => Url::toRoute(['/activity/default/jsoncalendar','entity' => $entity, 'entityTitleField' => $entityTitleField])
        ]);
    ?>

</div>