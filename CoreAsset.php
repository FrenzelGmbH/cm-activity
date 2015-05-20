<?php
namespace net\frenzel\activity;

/**
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class CoreAsset extends AssetBundle
{
    
    /**
     * @inheritdoc
     */
    public $sourcePath = '@net/frenzel/activity/assets';
    
    /**
     * @inheritdoc
     */
    public $js = [
        'js/frenzel_activity.js'
    ];

    public $css = [
        'css/frenzel_activity.css'
    ];
    
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset'
    ];
}