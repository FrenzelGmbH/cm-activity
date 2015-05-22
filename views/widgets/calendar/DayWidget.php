<?php
namespace net\frenzel\activity\views\widgets\calendar;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 */

use net\frenzel\activity\models\Activity;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;

/**
 * Activity Class
 */
class DayWidget extends Widget
{   
    /**
     * [$entity description]
     * @var null
     */
    public $entity = NULL;

    /**
     * [$entity_id description]
     * @var null
     */
    public $entity_id = NULL;

    public $targetUrl = '/site/index';
   
    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('_day_view', [
            'targetUrl' => $this->targetUrl,
            'entity' => $this->entity,
            'entity_id' => $this->entity_id,
        ]);
    }
}