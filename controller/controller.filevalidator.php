<?php 

class FileValidator {

    public static function isUploaded($file) {

        switch($_FILES[$file]["error"]) {
            case UPLOAD_ERR_OK:
                return true;
                break;
            case UPLOAD_ERR_NO_FILE:
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
            default:
                return false;
                break;
        }

    }

    public static function allowedSize($file, $size) {
        
        if($_FILES[$file]['size'] > $size) {
            return false;
        }
        return true;

    }

    public static function allowedType($file, $extensionArray) {

        $fileUpload = basename($_FILES[$file]["name"]);
        $imageFileType = strtolower(pathinfo($fileUpload,PATHINFO_EXTENSION));

        if(in_array($imageFileType,$extensionArray)){ 
            return true;
        }
        return false;
        
    }

    public static function rename($prefix, $file) {
        
        $rename = $prefix.'-'.rand(pow(10, 5-1), pow(10, 5)-1).'-'.str_replace(" ", "-", basename($_FILES[$file]["name"]));
        $renamed = str_replace(" ", '', $rename);
        return $renamed;

    }

    public static function upload($directory, $file, $fileName) {
        if (move_uploaded_file($_FILES[$file]['tmp_name'],$directory.$fileName)) {
            return true;
        }
        return false;
    }

}