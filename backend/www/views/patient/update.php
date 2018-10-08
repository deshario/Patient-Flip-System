<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\PatientInfo */

$this->title = 'Update Patient Info: ' . $model->patient_id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->patient_name, 'url' => ['view', 'id' => $model->patient_id], 'class' => 'modalButton'];
$this->params['breadcrumbs'][] = 'Update';
$this->registerJs("
$(function(){
    $('.modalButton').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show').find('#modalContent').html(data)
       });
       return false;
    });
});
");
?>
<!--<div class="patient-info-update" style="background:#f8f8f8; padding:20px 20px 20px 20px; border-radius:5px">-->
<div class="patient-info-update" style="background:#f8f8f8">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php
        Modal::begin([
            'header' => 'Patient Name',
            'id' => 'modal',
            'size' => 'modal-md',
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
        ?>

</div>
