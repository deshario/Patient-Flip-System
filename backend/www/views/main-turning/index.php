<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MainTurningSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Main Turnings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-turning-index" style="margin-top: -10px">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-file-o"></i>&nbsp; Patient Turning Records</h3>',
            'type' => GridView::TYPE_DEFAULT,
            'before' => 'Hi',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Records', ['create'], ['class' => 'pull-right btn btn-default', 'style'=>'margin-right:5px']),
            'after' => false,
            'footer'=>false
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'main_id',
            'turn_id',
            'patientTurning.latest_turned',
            'staff_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
