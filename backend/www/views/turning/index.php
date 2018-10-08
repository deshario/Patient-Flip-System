<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\mpdf\Pdf;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Patient Turnings';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    'https://js.pusher.com/4.1/pusher.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
//$this->registerJsFile(Yii::$app->request->baseUrl.'/js/deshario_noti.js',['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJs("
//    $('#modal').modal('show');
//    $('#modalContent').load('update?id=1');
//");
$this->registerJs("
    //Pusher.logToConsole = true;
    var pusher = new Pusher('6d49c0fafb127faf5241', {
      cluster: 'ap1',
      encrypted: true
    });
    
    var channel = pusher.subscribe('my-channel'); 
    
    channel.bind('my-event', function(data) {
     var myid = parseInt(data.message);
     $('#modal').modal('show')
     $('#modalContent').load('update?id='+myid)
    });
    
     channel.bind('line-event', function(data) {
     var msg = data.message;
     $.ajax({
            type: 'POST',
	        url: '../includes/line_manager.php',
	        data: {access: 'granted', message:msg},
	        success:function(html) {
	          console.log('Done'); 
	        } 
	      });
    }); 
");

$this->registerJs("    
$(function(){   
    $('.view_btn').click(function (){ 
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show')
          .find('#modalContent').html(data)
       });
       return false;
    }); 
    $('.update_btn').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show').find('#modalContent').html(data) 
       });
       return false;
    });
});
");
?>

<?php
$title = "Patient Turning Records";
//$title = "<script>document.getElementByID('yourid').value</script>";
Modal::begin([
    "header" => "<h4 class='modal-title'>".$title."</h4>",
    "id" => "modal",
    "size" => "modal-md",
]);
echo "<div id='modalContent' style='margin-top:-20px; margin-left: -10px; margin-right: -5px; margin-bottom: -10px'></div>";
Modal::end();
?>

<div class="patient-turning-index" style="margin-top: -10px">
    <?php Pjax::begin(); ?>
    <?php
    date_default_timezone_set("Asia/Bangkok");
    $date = date('D, d-M-Y H:i a');
    $pdfHeader = [
        'L' => ['content' => 'Nan Hospital',],
        'C' => ['content' => 'Patient Turning Records',],
        'R' => ['content' => 'Generated : '.$date],
        'line' => false,
    ];

    $pdfFooter = [
        'L' => ['content' => '© Deshario',],
        'C' => ['content' => ''],
        'R' => ['content' => '{PAGENO}','font-style' => 'N'],
        'line' => true,
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="fa fa-file-o"></i>&nbsp; Patient Turning Records</h3>',
            'type' => GridView::TYPE_DEFAULT,
            'before' => 'Hi',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Records', ['create'], ['class' => 'pull-right btn btn-default', 'style'=>'margin-right:5px']),
            'after' => false,
            'footer'=>false
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'<a>#</a>','headerOptions' => ['class' => 'text-center'],'contentOptions' => ['class' => 'text-center']],
            //'turn_id',
            // 'P_id',
            // 'patient.patient_name',
            ['attribute' => 'P_name','value' => 'patient.patient_name',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
//                'filter' => ArrayHelper::map(\app\models\PatientInfo::find()->all(), 'patient_id', 'patient_name'),
                'filter' => $searchModel->getPatientName(),
                ],

            ['attribute' => 'P_bed','value' => 'patient.patient_bed','headerOptions' => ['class' => 'text-center'],'contentOptions' => ['class' => 'text-center']], //'contentOptions' => ['class' => 'text-center'],
            // 'latest_turned',
            [
                'attribute'=>'latest_turned',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
                'format'=>'html',
                'value'=>function($model, $key, $inex, $column){
                    // return $model->latest_turned;
                    return Yii::$app->formatter->asDateTime($model->latest_turned,'medium'); //short,medium,long,full
                    //return Yii::$app->formatter->asDate($model->created_at,'medium');
                },
                'filter' => DateControl::widget([
                    'model' => $searchModel,
                    'attribute' => 'latest_turned',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]),
            ],
            ['attribute'=>'position','headerOptions' => ['class' => 'text-center'],'contentOptions' => ['class' => 'text-center']],
//            'turned_by',
            ['attribute' => 'S_taff','value' => 'staff.staff_name',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                'filter' => $searchModel->getStaffName(),
            ],
//            ['class' => 'kartik\grid\ActionColumn','header'=>'<a>Actions</a>'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['view?id='.$model->turning_id],['id' => 'my_view', 'class' => 'view_btn', 'style'=>'margin-right:2px']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update?id='.$model->turning_id],['id' => 'my_update', 'class' => 'update_btn', 'style'=>'margin-right:2px']);
                    },
//                    'delete' => function ($url, $model) {
//                        $url = Url::to(['turning/delete', 'id' => $model->turning_id]);
//                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
//                            'title'        => 'delete',
//                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                            'data-method'  => 'post',
//                        ]);
//                    },
                ]
            ],
        ],
        'responsiveWrap' => false,
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                // 'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
                'iconOptions' => ['class' => 'text-success'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => "Patient Turnings",
                'alertMsg' => 'The EXCEL export file will be generated for download.',
                'options' => ['title' => 'Microsoft Excel 95+'],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => 'ExportWorksheet',
                    'cssFile' => ''
                ]
            ],
            GridView::TEXT => [
                'label' => 'Text',
                'filename' => 'Patient Turnings'
            ],
            GridView::PDF => [
                'label' => 'PDF',
                //  'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
                'iconOptions' => ['class' => 'text-danger'],
                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => 'Patient Turnings',
                'alertMsg' => 'The Patient Turning Records will be generated for download.',
                'options' => ['title' => 'Patient Turnings','author' => 'deshario'],
                'mime' => 'application/pdf',
                //  'cssFile' => '@app/web/css/bootstrap.css',
                'config' => [
                    'methods' => [
                        'SetHeader' => [ ['odd' => $pdfHeader, 'even' => $pdfHeader] ],
                        'SetFooter' => [ ['odd' => $pdfFooter, 'even' => $pdfFooter] ],
                    ],
                    'mode' => Pdf::MODE_CORE,
                    'format' => Pdf::FORMAT_A4,
                    'orientation' => Pdf::ORIENT_PORTRAIT,
                    'destination' => Pdf::DEST_BROWSER,
                ],
            ],
        ],

    ]); ?>
    <?php Pjax::end(); ?></div>
