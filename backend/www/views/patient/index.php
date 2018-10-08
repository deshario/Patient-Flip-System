<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\mpdf\Pdf;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PatientInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Patient Information';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(
    'https://js.pusher.com/4.1/pusher.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerCss("
.user_logo {
       float: none;
       margin: 0 auto;
       width: 50%;
       height: 50%;
       -webkit-border-radius: 50% !important;
       -moz-border-radius: 50% !important;
       border-radius: 50% !important;
       }
       .titler {
       text-align: center;
       margin-top: 10px;
       color: #5a7391;
       font-size: 16px;
       font-weight: 600;
       margin-bottom: 7px;
       }
       .bg{
       background: rgba(248, 248, 248, 0.8);
       border-radius: 5px
       }
");
$root = Yii::getAlias('@web');
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
     $('#modalContent').load('$root/turning/update?id='+myid)
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
    $('.modalButton').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show')
          .find('#modalContent')
          .html(data)
       });
       return false;
    });
    
    $('.modalTurning').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show')
          .find('#modalContent')
          .html(data) 
       });
       return false;
    }); 
});
");
$this->registerJs("
 $('.btn_turning').click(function(){
             var id = $(this).attr('id');
             var p_name = $(this).attr('pname');
             var Capital_pname = p_name.substr(0,1).toUpperCase()+p_name.substr(1);
             $.ajax({
               type : 'post',
                url : '../includes/turning_db.php',
                data : 'id='+ id,
                dataType: 'json',
                success: function (response){ 
                if(response.length == 0) { 
                   $('#myModalTurning').modal('hide')
                   alert(Capital_pname+' does not have any turning records yet !');
                }else{
                $('#myModalTurning').modal('show') 
                    var trHTML = '';
                     $.each(response, function (key,value) {
                        trHTML +=
                           '<tr><td>' + value.no +
                           '</td><td>' + value.latest_turned +
                           '</td><td>' + value.position +
                           '</td><td>' + value.turned_by +
                           '</td></tr>';
                       });
                   $('#myTable>tbody').html(trHTML);
                   $('#Mtitle').html(\"<span class='fa fa-file-o'></span>&nbsp; Turning Records of \"+p_name.substr(0,1).toUpperCase()+p_name.substr(1));
                }
                }  
             });
           });
  ");
?>

<?php
$title = "Patient Turning Records";
Modal::begin([
    "header" => "<h4 class='modal-title'>".$title."</h4>",
    "id" => "modal",
    "size" => "modal-md",
]);
echo "<div id='modalContent' style='margin-top:-20px; margin-left: -10px; margin-right: -5px; margin-bottom: -10px'></div>";
Modal::end();
?>

<div class="modal fade" id="myModalTurning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:25px"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Mtitle">Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="tablePanelBody" class="panel-body" style="margin-left:-5px; margin-right:-5px; margin-top:-20px; margin-bottom:-40px">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Turned Datetime</th>
                                    <th>Position</th>
                                    <th>Turned By</th>
                                </tr>
                                </thead>
                                <tbody id="t_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => "<h4 class='modal-title' id='Mtitle'>Patient Information</h4>",
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<div class="row">
    <div class="container-fluid">
        <div style="margin-top: -10px">
            <div class="bg panel panel-default">
                <div class="panel-heading">
                    <h4 class='panel-title'><i class="fa fa-user-o"></i>&nbsp; Patient Information</h4>
                </div>
                <div class="panel-body" style="margin-bottom: -10px;">
                    <div class="row">
                        <?php foreach ($dataProvider->models as $model) { ?>
                            <div class="col-md-3 col-sm-6 col-xs-12" style="margin-bottom:-10px">
                                <div class="panel panel-default">
                                    <div class="panel-body" style="margin-bottom: -14px;">
                                        <img src="<?= Yii::$app->request->baseUrl ?>/img/man.png" class="img-responsive user_logo" alt="">
                                        <div class="titler"><?php echo $model->patient_name; ?></div>
                                    </div>
                                    <div class='panel-footer' align="center">
                                        <!-- <a type="button" class="btn btn-default btn-sm open-AddBookDialog"><span class="fa fa-user-o"></span> Details</a> -->
                                        <!-- <?= Html::a('<i class="fa fa-user-o"></i> Details', ['view?id='.$model->patient_id], ['id' => 'modalButtson', 'class' => 'btn btn-default btn-sm', 'style'=>'margin-right:5px']) ?> -->
                                        <a type="button" class="btn btn-default btn-sm btn_profile modalButton" href="<?=Url::to(['view', 'id'=>$model->patient_id]); ?>"><span class="fa fa-user-o"></span> Details</a>
                                        <a type="button" class="btn btn-default btn-sm btn_turning" id="<?php echo $model->patient_id; ?>" pname="<?php  echo $model->patient_name; ?>"><span class="fa fa-file-o"></span> Turning Records</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="panel-footer">
                    <a class="btn btn-default" style="font-family: Arial" href="create"><i class="fa fa-user-plus">Create New Patient</i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => 'Patient Name',
    'id' => 'modal_turning',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>


<!-- <div class="patient-info-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>
<?php
date_default_timezone_set("Asia/Bangkok");
$date = date('D, d-M-Y H:i a');
$pdfHeader = [
    'L' => ['content' => 'Nan Hospital',],
    'C' => ['content' => 'Patient Turning Records',
        // 'font-size' => 10,'font-style' => 'B',  'font-family' => 'arial','color' => '#333333'
    ],
    'R' => ['content' => 'Generated : '.$date],
    'line' => false,
];

$pdfFooter = [
    'L' => ['content' => '© Deshario',
        // 'font-size' => 10,'color' => '#333333','font-family' => 'arial',
    ],
    'C' => ['content' => ''],
    'R' => ['content' => '{PAGENO}','font-style' => 'N'],
    'line' => true,
];

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> Patients</h3>',
        'type'=>'success',
        //  'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        //  'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        'before' => '',
        'after' => false,
        'footer'=>false
    ],
    'layout' => "{items}\n{pager}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //
        //'patient_id',
        'patient_name',
        'patient_bed',
        'patient_created',
        ['class' => 'yii\grid\ActionColumn'],
    ],
    'pjax'=>true,
    'resizableColumns'=>true,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
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
        // GridView::CSV => [],
        //     GridView::PDF => [
        //      'label' => 'PDF',
        //      'filename' => 'Hello',
        //      'title' => 'Title',
        //      'options' => ['title' => 'Title List','author' => 'des'],
        //  ],
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
<?php Pjax::end(); ?></div> -->
