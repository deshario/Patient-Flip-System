<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MainTurning */

$this->title = 'Create Main Turning';
$this->params['breadcrumbs'][] = ['label' => 'Main Turnings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-turning-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
