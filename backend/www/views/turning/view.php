<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PatientTurning */

$this->title = $model->patient->patient_name;
$this->params['breadcrumbs'][] = ['label' => 'Patient Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-turning-view" style="padding:20px 20px 5px 20px; border-radius:5px">

    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="myname" value="<?= $model->patient->patient_name; ?>" readonly="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Bed No</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mybed" value="<?= $model->patient->patient_bed; ?>" readonly="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Turned</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mycreated" value="<?= $model->latest_turned; ?>" readonly="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Position</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mycreated" value="<?= $model->position; ?>" readonly="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Turned By</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mycreated" value="<?= $model->turned_by; ?>" readonly="">
            </div>
        </div>
    </form>

    <?php /* = DetailView::widget([
        'model' => $model,
        'attributes' => [
            'turning_id',
            'P_id',
            'patient.patient_name',
            'patient.patient_bed',
            'latest_turned:datetime',
            'position',
            'turned_by',
        ],
    ]) */ ?>

</div>
