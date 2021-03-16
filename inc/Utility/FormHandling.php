<?php
/**
 *  @package  eventRsvp
 */

namespace Inc\Utility;

class FormHandling{

    public static $validatedData = [];

    public static function validateInput( $dataArray){
        // Validate Input Data
       foreach($dataArray as $data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            array_push(self::$validatedData, $data);
       }

       return self::$validatedData;
         
    }
    
    //This Method handles File Uploads
     public static function handleFileUpload(){
         //
        global $upload_path;
        $target_file = $upload_path . basename($_FILES["event-poster"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $status = [];

        // Check if image file is a actual image or fake image
       
        $check = getimagesize($_FILES["event-poster"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            return $status = [0, "File is not an image." ];
            $uploadOk = 0;
        }
        

        // // Check if file already exists
        // if (file_exists($target_file)) {
        // return $status = [0, "Sorry, file already exists." ];
        // $uploadOk = 0;
        // }

        // // Check file size
        if ($_FILES["event-poster"]["size"] > 55500000) {
            return $status = [0, "Sorry, your file is too large." ];
            $uploadOk = 0;
        }

        // // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            return $status = [0, "Sorry, only JPG, JPEG, PNG & GIF files are allowed."];
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return $status = [0, "Sorry, your file was not uploaded."];
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["event-poster"]["tmp_name"], $target_file)) {
            return  htmlspecialchars( basename( $_FILES["event-poster"]["name"]));
        } else {
            return $status = [0,"Sorry, there was an error uploading your file."];
        }
        }
     }
        
    public function run(){
        add_action( 'admin_menu', [$this, 'createAdminPage'] );
    }
}