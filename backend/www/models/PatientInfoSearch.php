<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PatientInfo;

/**
 * PatientInfoSearch represents the model behind the search form about `app\models\PatientInfo`.
 */
class PatientInfoSearch extends PatientInfo
{
    /**
     * @inheritdoc
     */
    public $Pturned;
    public function rules()
    {
        return [
            [['patient_id'], 'integer'],
            [['patient_name', 'patient_bed', 'Pturned', 'patient_created'], 'safe'],
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
        $query = PatientInfo::find()->groupBy('patient_name');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'Pturned' => [
                    'asc' => ['patient_turning.latest_turned' => SORT_ASC],
                    'desc' => ['patient_turning.latest_turned' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('patientTurning'); // Mame of RElation

        // grid filtering conditions
        $query->andFilterWhere([
            'patient_id' => $this->patient_id,
            'patient_created' => $this->patient_created,
        ]);

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'patient_bed', $this->patient_bed]);

        return $dataProvider;
    }
}
