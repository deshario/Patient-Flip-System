<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PatientInfo */

$this->title = "ee";
$this->params['breadcrumbs'][] = ['label' => 'Patient Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="patient-info-view" style="background:#f8f8f8; padding:20px 20px 20px 20px; border-radius:5px"> -->
<div class="patient-info-view">
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="myname" value="<?php echo "ee"; ?>" readonly="">
            </div>
        </div>
    </form>
</div>
