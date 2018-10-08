<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PatientTurning */

$this->title = 'Create Patient Turning';
$this->params['breadcrumbs'][] = ['label' => 'Patient Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-turning-create" style="background:#f8f8f8; padding:20px 20px 20px 20px; border-radius:5px">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
