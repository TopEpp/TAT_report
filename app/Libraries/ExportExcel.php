<?php 
namespace App\Libraries;
use App\Libraries\ExportExcel\html2excel;

include "ExportExcel/html2excel.php";
class ExportExcel {
    public $fileAction="D";
    public $file="";
    public $path="uploads/export/";
      public function exportFhtml($data,$fileName=''){
          $html2excel=new html2excel();
          $html2excel->UTF8='UTF-8';
          if($fileName!=''){
              $this->file = $fileName;
          }
            foreach($data as $index=>$val){
                $html2excel->html=$val['html'];
                $html=$html2excel->loadhtml();
                $html2excel->addData($html,$val['border'],$val['auto']);
            }
          $html2excel->Output($this->file,$this->path,$this->fileAction);
      }

} 
?>