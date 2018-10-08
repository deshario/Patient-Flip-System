<?php

function DateThai($strDate,$full){
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));
  $strHour= date("H",strtotime($strDate));
  $strMinute= date("i",strtotime($strDate));
  $strSeconds= date("s",strtotime($strDate));
  if($full == true){
    $strMonthCut = Array(
      "",
      "มกราคม",
      "กุมภาพันธ์",
      "มีนาคม",
      "เมษายน",
      "พฤษภาคม",
      "มิถุนายน",
      "กรกฎาคม",
      "สิงหาคม",
      "กันยายน",
      "ตุลาคม",
      "พฤศจิกายน",
      "ธันวาคม"
  );
  }else{
      $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  }
  $dd = add_zero_or_not($strDay);
  $strMonthThai=$strMonthCut[$strMonth];
  return "วันที่ $dd $strMonthThai $strYear, เวลา $strHour:$strMinute:$strSeconds";
}

function add_zero_or_not($number){
        if(($number) < 10){
            $number = "0".$number;
            return $number;
        }else{
            $number = "".$number;
            return $number;
        }
}

function getGender($gen_id){
    if($gen_id == 1){
        return "Male";
    }else{
        return "Fe-male";
    }
}

?>
