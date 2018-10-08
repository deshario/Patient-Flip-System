<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\mpdf\Pdf;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StaffInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff Information';
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
     $('#modal_pt').modal('show')
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
    $('.view_btn').click(function (){
        $.get($(this).attr('href'), function(data) {
          $('#modal').modal('show')
          .find('#modalContent')
          .html(data)
       });
       return false;
    }); 
});
");
?>

<?php
$title = "Patient Turning Records";
Modal::begin([
    "header" => "<h4 class='modal-title'>".$title."</h4>",
    "id" => "modal_pt",
    "size" => "modal-md",
]);
echo "<div id='modalContent' style='margin-top:-20px; margin-left: -10px; margin-right: -5px; margin-bottom: -10px'></div>";
Modal::end();
?>

<?php
Modal::begin([
    'header' => "<h4 class='modal-title' id='Mtitle'>Staff Information</h4>",
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php Pjax::begin(); ?>

<div class="row">
    <div class="container-fluid">
            <div style="margin-top: -10px">
                <div class="bg panel panel-default">
                    <div class="panel-heading">
                        <h4 class='panel-title'><i class="fa fa-user-o"></i>&nbsp; Staff Information</h4>
                    </div>

                    <div class="panel-body" style="margin-bottom: -10px;">
                        <div class="row">
                            <?php foreach ($dataProvider->models as $model) { ?>
                                <div class="col-sm-3" style="margin-bottom:-10px">
                                    <div class="panel panel-default">
                                        <div class="panel-body" style="margin-bottom: -14px;">
                                            <img src="<?= Yii::$app->request->baseUrl ?>/img/man.png" class="img-responsive user_logo" alt="">
                                            <div class="titler"><?php echo $model->staff_name; ?></div>
                                        </div>
                                        <div class='panel-footer' align="center">
                                            <a type="button" class="btn btn-default btn-sm btn_profile view_btn" href="<?=Url::to(['view', 'id'=>$model->staff_id]); ?>"><span class="fa fa-user-o"></span> Details</a>
                                          </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-default" style="font-family: Arial" href="create"><i class="fa fa-user-plus"> Create New Staff</i></a>
                    </div>
                </div>
            </div>
        </div>

<!--        'staff_id',-->
<!--        //            'staff_name',-->
<!--        //            'staff_gender',-->

<?php Pjax::end(); ?></div>
