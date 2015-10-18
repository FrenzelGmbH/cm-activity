<?php

namespace net\frenzel\activity\controllers;

use Yii;
use yii\web\Controller;
use net\frenzel\activity\models\ActivitySearch;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 */
class ActivityController extends Controller
{

    /**
     * Lists all Address models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}
