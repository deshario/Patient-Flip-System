<?php
include 'functions.php';
include 'connection.php';
if($_POST['id']){
    $id = $_POST['id'];
//    $query=mysqli_query($con,"SELECT * FROM patient_turning
//INNER JOIN patient_info ON patient_turning.P_id = patient_info.patient_id
//INNER JOIN staff_info ON patient_turning.turned_by = staff_info.staff_id
// WHERE patient_info.patient_id = $id ORDER BY patient_turning.latest_turned DESC ");

    $query=mysqli_query($con,"SELECT latest_turned,position,patient_name,patient_bed,
IF(staff_name IS NULL or staff_name = '', '<i> Empty </i>', staff_name) as staff_name FROM patient_turning 
INNER JOIN patient_info ON patient_turning.P_id = patient_info.patient_id
LEFT JOIN staff_info ON patient_turning.turned_by = staff_info.staff_id
WHERE patient_info.patient_id = $id ORDER BY patient_turning.latest_turned DESC");
    //  $query=mysqli_query($con,"SELECT * FROM patient_info WHERE patient_id=$id");
    $array = array();
    $subArray=array();
    $no = 1;
    while($row = mysqli_fetch_array($query)) {
        $subArray['no'] = $no;  //location_id is key and $row['location'] is value which come fron database.
        $subArray['latest_turned'] = DateThai($row['latest_turned'],true);
        $subArray['position'] = $row['position'];
        $subArray['turned_by'] = $row['staff_name'];
        $array[] =  $subArray ;
        $no = $no+1;
    }
    echo json_encode($array);
}
?>
