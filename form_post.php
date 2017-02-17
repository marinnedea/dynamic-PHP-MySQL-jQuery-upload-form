<?php 
// getting the POST from the form

if (isset($_POST['add_account'])) { 
    if ($_POST['fields']) {
        foreach( $_POST['fields'] as $key=>$fieldArray ) {                          

           if (!empty($_FILES)) {

                $uploaddir = 'upload/';  // Upload directory 

                if (!is_dir($uploaddir)) // Check if upload directory exist
                {
                    mkdir($uploaddir);  // If no upload directory exist, create it
                }

                $newname = time(); // Returns the current time measured in the number of seconds since the Unix Epoch (January 1 1970 00:00:00 GMT),  to use it as part of the name
                $random = rand(100,999); // Getting some random numbers to add in the file names, to avoid files with the same name         

                $name =  $newname.'-'.$random.'-'.$_FILES['fields']['name'][$key]['file_uploaded'][0];  // File Name Construction 

                $tempFile = $_FILES['fields']['tmp_name'][$key]['file_uploaded'][0];  // Getting temporary file location and temporary name ( e.g. /tmp/random_string__here )

                $uploadfile = $uploaddir . $name; // Concatenating upload dir name with the file name               

                if (move_uploaded_file($tempFile, $uploadfile)) {  // If file moved from temp to upload location with the name we constructed above
                    echo 'File uploaded to '.$uploadfile.'.<br />';
                } else {
                    echo 'File not uploaded!<br />';
                }               

            }

            $keys = array_keys($fieldArray);
            $values = array_map("mysql_real_escape_string",$fieldArray);                
            $q = "INSERT INTO accounts (".implode(',',$keys).", file_uploaded) VALUES ('".implode('\',\'',$values)."', ".$uploadfile." )";
            $r = mysql_query($q, $dbc );                                            

        }
    }
    echo "<i><h2><strong>" . count($_POST['fields']) . "</strong> Account(s) Added</h2></i>";       
}
?>
