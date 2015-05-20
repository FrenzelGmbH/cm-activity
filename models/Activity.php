<?php

namespace net\frenzel\activity\models;

use yii\base\Event;

use \DateTime;
/**
 * @author Philipp Frenzel <philipp@frenzel.net> 
 */

/**
 * Class Activity
 * @package net\frenzel\activity\models
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entity_id
 * @property integer $type
 * @property string $text
 * @property integer $deleted
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \yii\db\ActiveRecord $author
 * @property \yii\db\ActiveRecord $lastUpdateAuthor
 *
 * @method scope\CommentQuery hasMany(string $class, array $link) see BaseActiveRecord::hasMany() for more info
 * @method scope\CommentQuery hasOne(string $class, array $link) see BaseActiveRecord::hasOne() for more info
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * here the user can set "his" personal next steps, pls. use the constants to define, as it makes it easier to read.
     * @var array
     */
    public $allowed_next_type = [self::TYPE_CALL, self::TYPE_APPOINTMENT];

    const EVENT_ACTIVITY_UPDATE = 'net_frenzel_activity_update';

    const TYPE_CALL = 1;
    const TYPE_MAIL = 2;
    const TYPE_SMS = 3;
    const TYPE_POST = 4;
    const TYPE_FAX = 5;
    const TYPE_SOCIAL = 6;
    const TYPE_IM = 7;
    const TYPE_APPOINTMENT = 8;
    
    public static $activityTypes = [
        self::TYPE_CALL => 'Call',
        self::TYPE_MAIL => 'Mail',
        self::TYPE_SMS => 'SMS',
        self::TYPE_POST => 'Post',
        self::TYPE_FAX => 'Fax',
        self::TYPE_SOCIAL => 'Social Network',
        self::TYPE_IM => 'Instant Messanger',
        self::TYPE_APPOINTMENT => 'Appointment'
    ];

    public static $activityTypesIcons = [
        self::TYPE_CALL => 'phone-square',
        self::TYPE_MAIL => 'send',
        self::TYPE_SMS => 'mobile',
        self::TYPE_POST => 'truck',
        self::TYPE_FAX => 'fax',
        self::TYPE_SOCIAL => 'twitter',
        self::TYPE_IM => 'skype',
        self::TYPE_APPOINTMENT => 'calendar'
    ];
    
    public function getTypeAsString()
    {
        if(isset(self::$activityTypes[$this->type]))
            return self::$activityTypes[$this->type];
        return 'ERROR, pls. contact support!';
    }

    public function getTypeAsIcon()
    {
        if(isset(self::$activityTypesIcons[$this->type]))
            return self::$activityTypesIcons[$this->type];
        return 'asterisk';
    }

    public function getNextTypeAsIcon()
    {
        if(isset(self::$activityTypesIcons[$this->next_type]))
            return self::$activityTypesIcons[$this->next_type];
        return 'asterisk';
    }

    public static function getTypeArray()
    {
        return self::$activityTypes;
    }

    public function getNextTypeArray()
    {
        $return = [];
        foreach($this->allowed_next_type AS $key)
        {
            $return[$key] = self::$activityTypes[$key];
        }
        return $return;
    }

    public function getNextTypeAsString()
    {
        if(isset(self::$activityTypes[$this->next_type]))
            return self::$activityTypes[$this->next_type];
        return 'ERROR, pls. contact support!';
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%net_frenzel_activity}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::className(),
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['type', 'entity', 'entity_id', 'text', 'type','next_type','next_at','next_by'],
            'update' => ['type' ,'text','next_type','next_at','next_by'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text','entity'], 'string'],
            [['next_at'], 'string'],
            [['created_by', 'updated_by', 'created_at', 'updated_at','deleted_at','next_by','entity_id','type','next_type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => \Yii::t('app', 'ID'),
            'text'       => \Yii::t('app', 'Text'),
            'entity'     => \Yii::t('app', 'Entity'),
            'type'       => \Yii::t('app', 'Current Type'),
            'next_type'  => \Yii::t('app', 'Next Type'),
            'next_at'    => \Yii::t('app', 'Next Action'),
            'next_by'    => \Yii::t('app', 'Next By'),
            'created_by' => \Yii::t('app', 'Created by'),
            'updated_by' => \Yii::t('app', 'Updated by'),
            'created_at' => \Yii::t('app', 'Created at'),
            'updated_at' => \Yii::t('app', 'Updated at'),
            'deleted_at' => \Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        $Module = \Yii::$app->getModule('activity');
        return $this->hasOne($Module->userIdentityClass, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsible()
    {
        $Module = \Yii::$app->getModule('activity');
        return $this->hasOne($Module->userIdentityClass, ['id' => 'next_by']);
    }
    
    /**
     * Delete comment.
     *
     * @return boolean Whether comment was deleted or not
     */
    public function deleteActivity()
    {
        $this->touch('deleted_at');
        $this->text = '';
        return $this->save(false, ['deleted_at', 'text']);
    }

    /**
     * [getActivities description]
     * @param  [type] $model [description]
     * @param  [type] $class [description]
     * @return [type]        [description]
     */
    public static function getActivities($model, $class)
    {
        $models = self::find()->where([
            'entity_id' => $model,
            'entity' => $class
        ])->orderBy('{{%net_frenzel_activity}}.created_at DESC')->with(['author'])->all();

        return $models;
    }

    /**
     * Model ID validation.
     *
     * @param string $attribute Attribute name
     * @param array $params Attribute params
     *
     * @return mixed
     */
    public function validateModelId($attribute, $params)
    {
        /** @var ActiveRecord $class */
        $class = Model::findIdentity($this->model_class);
        if ($class === null) {
            $this->addError($attribute, \Yii::t('net_frenzel_activity', 'ERROR_MSG_INVALID_MODEL_ID'));
        } else {
            $model = $class->name;
            if ($model::find()->where(['id' => $this->model_id]) === false) {
                $this->addError($attribute, \Yii::t('net_frenzel_activity', 'ERROR_MSG_INVALID_MODEL_ID'));
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(Model::className(), ['id' => 'entity']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        /** @var ActiveRecord $class */
        $class = Model::find()->where(['id' => $this->entity])->asArray()->one();
        $model = $class->name;
        return $this->hasOne($model::className(), ['id' => 'entity_id']);
    }

    /**
     * changed beforeSave as I want to trigger an individual event for this
     * @param  [type] $insert [description]
     * @return boolean         [description]
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            Event::trigger(self::className(),self::EVENT_ACTIVITY_UPDATE, new Event(['sender' => $this]));
            \Yii::trace('The Event '.self::EVENT_ACTIVITY_UPDATE.' should be fired, pls. check!');

            $nextDate = new DateTime($this->next_at);
            $this->next_at = $nextDate->format('U');

            if(is_null($this->next_by))
            {
                $this->next_by = $this->created_by;
            }

            return true;
        }
        return false;
    }
}
