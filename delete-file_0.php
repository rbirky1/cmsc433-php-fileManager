<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>File Manager</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div id="nav">
      <a href="index.php">View</a> | <a href="upload-file.php">Upload</a>
    </div>
<h1>File Manager: Delete Files</h1>
<?

$uploaddir = "uploads/";
if (count($_POST['files']) == 0){
  echo "No files specified for deletion";
} else {

foreach($_POST['files'] as $checkbox){
   $path = $uploaddir . $checkbox;
//   chdir($uploaddir);
   if(unlink($path)) { echo "File $checkbox Deleted"; } else { echo "Sorry, there was an error";}
}

}
?>
  </body>
</html>
