<?php

class CheckMIMEType{

    //public $acStandartsMimeTypes = array();

    public $acStandartsMimeTypes = array(
        "image/jpeg",//jpg or jpeg
        "image/png",//png
        "application/pdf",//pdf
        "application/msword",//doc (not docx)
        "application/vnd.ms-excel",//xls (not xlsx)
        "text/csv",//csv
        //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
        //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
        //"application/vnd.ms-powerpoint",//ppt
        //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
    );

    public function isTheFileValid($testMimeType){
        if (in_array($testMimeType, $this->acStandartsMimeTypes)) {
            return true;
        }
        return false;
    }
    /*
    public function setValidMimeType(array $arrayMimeTypes = CheckMIMEType::$acStandartsMimeTypes){
        $this->acTypesFileForUploading = $arrayMimeTypes;
    }
    */
}