<?php

namespace net\frenzel\activity\controllers;

/**
 * @author Philipp Frenzel <philipp@frenzel.net>
 */

use Yii;
use yii\web\Controller;

class ActivityController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
