<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StaffInfo */

$this->title = 'Create Staff Info';
$this->params['breadcrumbs'][] = ['label' => 'Staff Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-info-create" style="background:#f8f8f8; padding:20px 20px 20px 20px; border-radius:5px">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
