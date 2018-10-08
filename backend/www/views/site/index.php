<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="container">
  <div class="col-md-12">
             <div class="row">
                <div style="margin-top: -10px">
                   <div class="bg panel panel-default">
                      <div class="panel-heading">
                         <h4 class='panel-title'><i class="fa fa-user-o"></i>&nbsp; Patient Information</h4>
                      </div>
                      <div class="panel-body" style="margin-bottom: -10px;">
                         <div class="row">
                            <?php
                            $con=mysqli_connect("localhost","root","");
                              mysqli_select_db($con,"hospital"); 
                               $query=mysqli_query($con,"SELECT * FROM patient_info");
                               while ($row = mysqli_fetch_array($query)) { ?>
                            <div class="col-sm-3" style="margin-bottom:-10px">
                               <div class="panel panel-default">
                                  <div class="panel-body" style="margin-bottom: -14px;">
                                     <img src="assets/img/man.png" class="img-responsive user_logo" alt="">
                                     <div class="titler"><?php echo $row['patient_name'] ?></div>
                                  </div>
                                  <div class='panel-footer' align="center">
                                     <!-- <a type="button" class="btn btn-default btn-sm open-AddBookDialog"><span class="fa fa-user-o"></span> Details</a> -->
                                     <a type="button" class="btn btn-default btn-sm btn_profile" data-toggle="modal" data-target="#myModalProfile" id="<?php echo $row['patient_id'];?>"><span class="fa fa-user-o"></span> Details</a>
                                     <a type="button" class="btn btn-default btn-sm btn_turning" data-toggle="modal" data-target="#myModalTurning" id="<?php echo $row['patient_id'];?>" pname="<?php echo $row['patient_name'];?>"><span class="fa fa-file-o"></span> Turning Records</a>
                                  </div>
                               </div>
                            </div>
                            <?php } ?>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
</div>
