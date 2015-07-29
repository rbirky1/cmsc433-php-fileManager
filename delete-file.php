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

$uploaddir = "/home/csee1/rbirky1/www-data/read-write/fm/";
if (count($_POST['files']) == 0){
  echo "No files specified for deletion";
} else {

foreach($_POST['files'] as $checkbox){
   $path = $uploaddir . $checkbox;
   if(unlink($path)) { echo "File $checkbox Deleted <br />"; } else { echo "Sorry, there was an error deleting $checkbox <br />";}
}

}
?>
  </body>
</html>
