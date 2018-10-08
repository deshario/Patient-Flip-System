<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PatientTurning */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-turning-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'P_id')->dropDownList($model->getPatientName()) ?>

    <!-- <?= $form->field($model, 'P_id')->textInput() ?> -->

    <!-- <?= $form->field($model, 'latest_turned')->textInput() ?> -->

    <?= $form->field($model, 'latest_turned')->widget(DateControl::classname(),
      [
          'type'=>DateControl::FORMAT_DATETIME,
          'options' => ['placeholder' => 'Select Turning Date'],
          'ajaxConversion'=>true,
          'language' => 'th',
      ]);
   ?>

    <?= $form->field($model, 'turned_by')->dropDownList($model->getStaffName(),['prompt'=>'Select Staff..'] ) ?>


    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
