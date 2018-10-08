<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MainTurning */

$this->title = 'Update Main Turning: ' . $model->main_id;
$this->params['breadcrumbs'][] = ['label' => 'Main Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->main_id, 'url' => ['view', 'id' => $model->main_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="main-turning-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
