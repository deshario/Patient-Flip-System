<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MainTurning */

$this->title = $model->main_id;
$this->params['breadcrumbs'][] = ['label' => 'Main Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-turning-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->main_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->main_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'main_id',
            'turn_id',
            'staff_id',
        ],
    ]) ?>

</div>
