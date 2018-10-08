<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StaffInfo;

/**
 * StaffInfoSearch represents the model behind the search form about `app\models\StaffInfo`.
 */
class StaffInfoSearch extends StaffInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'staff_gender'], 'integer'],
            [['staff_name'], 'safe'],
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
        $query = StaffInfo::find();

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
            'staff_id' => $this->staff_id,
            'staff_gender' => $this->staff_gender,
        ]);

        $query->andFilterWhere(['like', 'staff_name', $this->staff_name]);

        return $dataProvider;
    }
}
