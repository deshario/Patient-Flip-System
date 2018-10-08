<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient_info".
 *
 * @property integer $patient_id
 * @property string $patient_name
 * @property string $patient_bed
 * @property string $patient_created
 */
class PatientInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['patient_name', 'patient_bed', 'patient_created'], 'required'],
            [['patient_created'], 'safe'],
            [['patient_name'], 'string', 'max' => 100],
            [['patient_bed'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'patient_id' => 'Patient ID',
            'patient_name' => 'Patient Name',
            'patient_bed' => 'Patient Bed',
            'patient_created' => 'Patient Created',
        ];
    }

    public function getPatientTurning(){
        return $this->hasOne(PatientTurning::className(),['turning_id' => 'patient_id']);
    }

}
