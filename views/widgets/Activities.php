<?php
namespace net\frenzel\activity\views\widgets;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 */

use net\frenzel\activity\CoreAsset AS Asset;
use net\frenzel\activity\models\Activity;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Json;

/**
 * Activity Class
 */
class Activities extends Widget
{
    /**
     * @var \yii\db\ActiveRecord|null Widget model
     */
    public $model;
    
    /**
     * @var array comment Javascript plugin options
     */
    public $jsOptions = [];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->model === null) {
            throw new InvalidConfigException('The "model" property must be set.');
        }
        $this->registerClientScript();
    }
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $class = $this->model;
        $class = $class::className();
        $models = Activity::getActivities($this->model->id, $class);
        $model = new Activity(['scenario' => 'create']);
        $model->entity = $class;
        $model->entity_id = $this->model->id;
        return $this->render('index', [
            'models' => $models,
            'model' => $model
        ]);
    }
    /**
     * Register widget client scripts.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();
        $options = Json::encode($this->jsOptions);
        Asset::register($view);
        $view->registerJs('jQuery.activity(' . $options . ');');
    }
}