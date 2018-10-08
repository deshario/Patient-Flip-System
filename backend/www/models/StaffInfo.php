<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "staff_info".
 *
 * @property integer $staff_id
 * @property string $staff_name
 * @property integer $staff_gender
 */
class StaffInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_name', 'staff_gender'], 'required'],
            [['staff_gender'], 'integer'],
            [['staff_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'staff_name' => 'Staff Name',
            'staff_gender' => 'Staff Gender',
        ];
    }
}
