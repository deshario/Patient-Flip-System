<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PatientTurning;

/**
 * PatientTurningSearch represents the model behind the search form about `app\models\PatientTurning`.
 */
class PatientTurningSearch extends PatientTurning
{
    /**
     * @inheritdoc
     */
    public $P_bed;
    public $P_name;
    public $S_taff;

    public function rules()
    {
        return [
            [['P_id','turning_id'], 'integer'],
            [['latest_turned','P_name','S_taff','P_bed','position','turned_by'], 'safe'],
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
        $query = PatientTurning::find();
//        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
          'attributes' => [
              'P_name' => [
                  'asc' => ['patient_info.patient_name' => SORT_ASC],
                  'desc' => ['patient_info.patient_name' => SORT_DESC],
                  // 'label' => 'P_id',
                  'default' => SORT_ASC
              ],
              'P_bed' => [
                  'asc' => ['patient_info.patient_bed' => SORT_ASC],
                  'desc' => ['patient_info.patient_bed' => SORT_DESC],
                  // 'label' => 'P_id',
                  'default' => SORT_ASC
              ],
              'S_taff' => [
                  'asc' => ['staff_info.staff_name' => SORT_ASC],
                  'desc' => ['staff_info.staff_name' => SORT_DESC],
                  'default' => SORT_ASC
              ],
              'latest_turned',
              'position',
              'turned_by',
          ]
      ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('patient'); // Mame of RElation

        // grid filtering conditions
        $query->andFilterWhere([
            'turning_id' => $this->turning_id,
            // 'P_id' => $this->P_id,
            'latest_turned' => $this->latest_turned,
        ]);

        $query->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'turned_by', $this->turned_by])
            ->andFilterWhere(['like', 'patient_info.patient_name', $this->P_name])
            ->andFilterWhere(['like', 'patient_info.patient_bed', $this->P_bed])
            ->andFilterWhere(['like', 'staff_info.staff_name', '']);

        return $dataProvider;
    }
}
