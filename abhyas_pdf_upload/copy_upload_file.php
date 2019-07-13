<?php
$path = 'http://infiniti.paathshala.world/abhyas_pdf_upload/'; # Write full path here
if(isset($_FILES["file"]))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "0";
    }
    else
    {
        if(is_uploaded_file($_FILES["file"]["tmp_name"]) && move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]))
        {
            echo "1";
        }
        else {
            echo "0";
        }
    }
}
else
{
    echo "0";
}
?>