<?php

namespace net\frenzel\activity\controllers;

/**
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\db\Query;

use \net\frenzel\activity\models\Activity;

/**
 * Default Controller
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'create' => ['post'],
                'update' => ['put', 'post'],
                'fetch' =>  ['put', 'post', 'get'],
                'delete' => ['post', 'delete']
            ]
        ];
        return $behaviors;
    }

    /**
     * Create activity.
     */
    public function actionCreate()
    {
        $model = new Activity(['scenario' => 'create']);        
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->tree($model);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return \Yii::t('net_frenzel_activity', 'FRONTEND_FLASH_FAIL_CREATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($model);
            }
        }
    }

    /**
     * Update activity.
     *
     * @param integer $id Activity ID
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) {
                    return $this->renderAjax('@vendor/frenzelgmbh/cm-activity/views/widgets/views/_index_single_item', ['model' => $model]);
                } else {
                    Yii::$app->response->setStatusCode(500);
                    return \Yii::t('net_frenzel_activity', 'FRONTEND_FLASH_FAIL_UPDATE');
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(400);
                return ActiveForm::validate($model);
            }
        }
    }

    /**
     * fetch activity.
     *
     * @param integer $id Activity ID
     * @return mixed
     */
    public function actionFetch($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model->next_at = !is_null($model->next_at)?\Yii::$app->formatter->asDateTime($model->next_at,'yyyy-MM-dd hh:mm'):$model->next_at;
        return $this->renderAjax('@vendor/frenzelgmbh/cm-activity/views/widgets/views/_form_update', ['model' => $model]);
    }

    /**
     * Delete comment page.
     *
     * @param integer $id Comment ID
     * @return string Comment text
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($this->findModel($id)->deleteActivity()) {
            return \Yii::t('net_frenzel_activity', 'FRONTEND_WIDGET_COMMENTS_DELETED_COMMENT_TEXT');
        } else {
            Yii::$app->response->setStatusCode(500);
            return \Yii::t('net_frenzel_activity', 'FRONTEND_FLASH_FAIL_DELETE');
        }
    }

    /**
     * Find model by ID.
     *
     * @param integer|array $id Comment ID
     * @return Comment Model
     * @throws HttpException 404 error if comment not found
     */
    protected function findModel($id)
    {
        /** @var Comment $model */
        $model = Activity::findOne($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404, \Yii::t('net_frenzel_activity', 'FRONTEND_FLASH_RECORD_NOT_FOUND'));
        }
    }

    /**
     * @param Comment $model Comment
     *
     * @return string Comments list
     */
    protected function tree($model)
    {
        $models = Activity::getActivities($model->entity_id, $model->entity);
        return $this->renderPartial('@net/frenzel/activity/views/widgets/views/_index_item', ['models' => $models]);
    }

    public function actionResponsibleList($q = null, $id = null)
    {        
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, username AS text')
                ->from('{{%user}}')
                ->where('username LIKE "%' . $q .'%"')
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $Module = \Yii::$app->getModule('activity');
            $userModel = $Module->userIdentityClass;
            $out['results'] = ['id' => $id, 'text' => $userModel::find($id)->username];
        }
        return $out;
    }

    /**
     * Renders the activities inside a calendar... might be nicer to view
     * @param  [type] $start [description]
     * @param  [type] $end   [description]
     * @param  [type] $_     [description]
     * @return [type]        [description]
     */
    public function actionJsoncalendar($start=NULL,$end=NULL,$entity=NULL,$entity_id=NULL,$_=NULL, $entityTitleField = NULL){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if($start = null)
        {
            $startObj = new DateTime();
            $start = $startObj->format('U');
        }

        $events = Activity::getCalendarActivities($start,$end,$entity,$entity_id, $entityTitleField);
        return $events;
    }
}