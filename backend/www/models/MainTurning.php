<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_turning".
 *
 * @property integer $main_id
 * @property integer $turn_id
 * @property integer $staff_id
 */
class MainTurning extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_turning';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turn_id', 'staff_id'], 'required'],
            [['turn_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'main_id' => 'Main ID',
            'turn_id' => 'Turn ID',
            'staff_id' => 'Staff ID',
        ];
    }

    public function getPatientTurning(){
        return $this->hasOne(PatientTurning::className(),['turning_id' => 'turn_id']);
    }

    public function getStaff(){
        return $this->hasMany(StaffInfo::className(),['staff_id' => 'staff_id']);
    }
}
