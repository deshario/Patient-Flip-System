<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MainTurning;

/**
 * MainTurningSearch represents the model behind the search form about `app\models\MainTurning`.
 */
class MainTurningSearch extends MainTurning
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['main_id', 'turn_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
//        $query = MainTurning::find();
        $query = MainTurning::find();
//            ->select("latest_turned")
//            ->join('LEFT OUTER JOIN','auth_assignment','auth_assignment.user_id = user.id')
//            ->join('INNER JOIN','patient_turning',' patient_turning.turn_id = main_turning.turn_id');
//        $query = MainTurning::find()
//            ->innerJoinWith('patientTurning', 'main_turning.id = patient_turning.turn_id')
//            ->all();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'main_id' => $this->main_id,
            'turn_id' => $this->turn_id,
            'staff_id' => $this->staff_id,
        ]);

        return $dataProvider;
    }
}
