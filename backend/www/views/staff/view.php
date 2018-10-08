<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StaffInfo */

$this->title = $model->staff_id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
include 'includes/functions.php';
?>
<div class="staff-info-view">

    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="myname" value="<?= $model->staff_name; ?>" readonly="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mybed" value="<?= getGender($model->staff_gender); ?>" readonly="">
            </div>
        </div>
    </form>

</div>
