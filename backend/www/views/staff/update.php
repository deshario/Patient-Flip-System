<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StaffInfo */

$this->title = 'Update Staff Info: ' . $model->staff_id;
$this->params['breadcrumbs'][] = ['label' => 'Staff Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->staff_id, 'url' => ['view', 'id' => $model->staff_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
