<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?= $name ?></h3>

            <p>
                <?= nl2br(Html::encode($message)) ?>
            </p>

            <p>
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
                Meanwhile, you may <a href='<?= Yii::$app->homeUrl ?>'>return to dashboard</a> or try using the search
                form.
            </p>

            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>






<?php
//
//
//        // Controller
//        public function actionView($id){
//            return $this->renderAjax('view', [
//                'model' => $this->findModel($id),
//            ]);
//        }
//
//        // View
//        $this->registerJs("
//            $(function(){
//                $('.modalButton').click(function (){
//                    $.get($(this).attr('href'), function(data) {
//                      $('#modal').modal('show')
//                      .find('#modalContent')
//                      .html(data)
//                   });
//                   return false;
//                });
//        ");
//
//        Modal::begin([
//                'header' => 'Patient Name',  //'header' => 'Patient Name'.$model->patient_name,
//            'header' => 'Patient Name'.$model->patient_name,
//                'id' => 'modal',
//                'size' => 'modal-md',
//            ]);
//            echo "<div id='modalContent'></div>";
//        Modal::end();
//
// ?>
<!---->
<!--        <a type="button" class="btn btn-default btn-sm btn_turning modalButton"-->
<!--           href="--><?//=Url::to(['viewturn', 'id'=>$model->patient_id]); ?><!--"><span class="fa fa-file-o"></span> Details</a>-->
<!---->
