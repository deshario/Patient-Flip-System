<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "patient_turning".
 *
 * @property integer $turning_id
 * @property integer $patient_id
 * @property string $latest_turned
 * @property string $position
 * @property string $turned_by
 */
class PatientTurning extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_turning';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['P_id', 'position'], 'required'],
            [['latest_turned','date'], 'safe'],
            [['P_name','P_bed','S_taff'], 'safe'],
            [['position','turned_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'turning_id' => 'Turning ID',
            'P_id' => 'Patient ID',
            'P_name' => 'Patient Name',
            'P_bed' => 'Patient Bed',
            'S_taff' => 'Turned By',
            'latest_turned' => 'Turned DateTime',
            'position' => 'Position',
            'turned_by' => 'Turned By',
        ];
    }

    public function getPatient(){
      return $this->hasOne(PatientInfo::className(),['patient_id' => 'P_id']);
    }

    public function getStaff(){
        return $this->hasOne(StaffInfo::className(),['staff_id' => 'turned_by']);
    }

    public function getPatientName(){
        $list = PatientInfo::find()->orderBy('patient_id')->all();
        return ArrayHelper::map($list,'patient_id','patient_name');
    }

    public function getStaffName(){
        $list = StaffInfo::find()->orderBy('staff_id')->all();
        return ArrayHelper::map($list,'staff_id','staff_name');
    }

}
