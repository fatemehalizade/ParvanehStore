<?php
    if(!function_exists("convertDateToFarsi")){
        function convertDateToFarsi($date){
            $convertedDate=\Morilog\Jalali\Jalalian::forge($date)->format("Y-m-d H:i:s");
            return $convertedDate;
        }
    }
?>
