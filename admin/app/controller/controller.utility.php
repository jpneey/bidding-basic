<?php

class Utility {

    public static function getBase($http = true){
        if(!$http) {
            return '/admin/';
        }

        return 'http://localhost/admin/app/';
    }

    public static function getRoleString($role) {
        switch ($role) {
            case "5":
                return "Administrator";
            case "3":
                return "Digital Marketer";
            case "2":
                return "Human Resource";
        }
    }

    public static function compressImage($source_url, $destination_url, $quality) {

        //$quality :: 0 - 100
    
        if( $destination_url == NULL || $destination_url == "" ) $destination_url = $source_url;
    
        $info = getimagesize($source_url);
    
        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg')
        {
            $image = imagecreatefromjpeg($source_url);
            //save file
            //ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            imagejpeg($image, $destination_url, $quality);
    
            //Free up memory
            imagedestroy($image);
        }
        elseif ($info['mime'] == 'image/png')
        {
            $image = imagecreatefrompng($source_url);
    
            imageAlphaBlending($image, true);
            imageSaveAlpha($image, true);
    
            /* chang to png quality */
            $png_quality = 9 - round(($quality / 100 ) * 9 );
            imagePng($image, $destination_url, $png_quality);//Compression level: from 0 (no compression) to 9(full compression).
            //Free up memory
            imagedestroy($image);
        }else
            return FALSE;
    
        return $destination_url;
    
    }

}