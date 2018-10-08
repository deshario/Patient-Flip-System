<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PatientTurning */
$this->title = $model->patient->patient_name; 
$this->params['breadcrumbs'][] = ['label' => 'Patient Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->patient->patient_name, 'url' => ['view', 'id' => $model->turning_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="patient-turning-update" style="padding:20px 20px 5px 20px; border-radius:5px">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
