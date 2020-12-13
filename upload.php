<?php

if(!empty($_FILES['files']['name'][0])) {
    $files = $_FILES['files'];

    $uploaded = array();
    $failed = array();

    $allowed = array('png' , 'jpg', 'gif');

    foreach ($files['name'] as $position => $file_name){

        $file_tmp = $files['tmp_name'][$position];
        $files_size = $files['size'][$position];
        $file_error = $files['error'][$position];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        if(in_array($file_ext, $allowed)){

            if($file_error === 0) {

                if ($file_size <= 1000000){

                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if(move_uploaded_file($file_tmp, $file_destination)){
                        $uploaded[$position]  = $file_destination;
                    } else {
                        $failed[$position] = "[{$file_name}] erreur de téléchargement.";
                    }

                }else {
                    $failed[$position] = "[{$file_name}] trop volumineux.";
                }

            } else {
                $failed[$position] = "[{$file_name}] erreur avec le code {$file_error}.";
            }

        } else {
            $failed[$position] = "[{$file_name}] l'extension du fichier '{$file_ext}' n'est pas bon.";
        }
    }
    if (!empty($uploaded)){
        print_r($uploaded);
    }
    if (!empty($failed)){
        print_r($failed);
    }

}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title> Télécharge ton fichier</title>
</head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="imageUpload">Télécharge ton fichier</label>
            <input type="file" name="files[]" multiple="multiple" id="imageUpload" />
            <input type="submit" value="upload">
        </form>

<?php
        $it = new FilesystemIterator(dirname('uploads/..'));
        foreach ($it as $fileinfo)
        {
        echo "<figure><img src =" .$fileinfo."/></figure>" ;
        echo "<h3>" .$fileinfo->getFilename() . "\n"."</h3>" ;
        }
?>
        <figure>
    </body>
</html>