<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PatientInfo */

$this->title = 'Create Patient Info';
$this->params['breadcrumbs'][] = ['label' => 'Patient Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-info-create" style="background:#f8f8f8; padding:20px 20px 20px 20px; border-radius:5px">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
