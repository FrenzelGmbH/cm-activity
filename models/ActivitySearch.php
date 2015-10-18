<?php

namespace net\frenzel\activity\models;

/**
 * Created by PhpStorm.
 * User: philippfrenzel
 * Date: 10/18/15
 * Time: 10:28 PM
 */
class ActivitySearch extends \net\frenzel\activity\models\Activity
{
    /**
     * [search description]
     * @param  array $params [description]
     * @param  string $module [description]
     * @param  integer $id     [description]
     * @return [type]         [description]
     */
    public function search($params,$entity=NULL,$entity_id=NULL)
    {
        $query = Activity::find()->active()->related($entity, $entity_id);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', 'cityName', $this->cityName])
            ->andFilterWhere(['like', 'zipCode', $this->zipCode])
            ->andFilterWhere(['like', 'postBox', $this->postBox])
            ->andFilterWhere(['like', 'addresslineOne', $this->addresslineOne])
            ->andFilterWhere(['like', 'addresslineTwo', $this->addresslineTwo])
            ->andFilterWhere(['like', 'regionName', $this->regionName]);

        return $dataProvider;
    }
}