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
<h1>File Manager &mdash; Upload Files</h1>

<?
   if($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<form enctype="multipart/form-data" action="/~rbirky1/cs433-php/file_manager/upload-file.php" method="post">
  <p><input type="file" name="files[]"/></p>
  <p><input type="file" name="files[]"/></p>
  <p><input type="file" name="files[]"/></p>
  <p><input type="file" name="files[]"/></p>
  <p><input type="file" name="files[]"/></p>
  <p><input type="submit" value="Upload" name="submit"/></p>
</form>

<?

} else {

$uploaddir = '/home/csee1/rbirky1/www-data/read-write/fm/';
$files = reArrayFiles($_FILES['files']);
$finfo = finfo_open(FILEINFO_MIMETYPE);
$err = false;
$errstr = "";

foreach ($files as $file){
 if ($file['name'] != "") {
  if ( isInvalidType($file) ) {
   $err = true;
   $errstr .= "One or more files are of invalid types <br />";
   break;
  }
  if ( $file['size'] > 50000) {
   $err = true;
   $errstr .= "One or more files exceed 50 KB <br />";
   break;
  }
if ( isInvalidName($file) ) {
   $err = true;
   $errstr .= "One or more files has an invalid name <br />";
   break;
  }
 }
}

if ($err == true){
  print $errstr;
  print "<br /><a href='upload-file.php'>Try Again</a>";
 } else {
   foreach($files as $file){
    if ($file['name'] != "") {
     $newName = str_replace(' ', '_', $file['name']);
     $dest = $uploaddir ."/". $newName;
     if (move_uploaded_file($file['tmp_name'], $dest)) {echo "Successfully uploaded {$file['name']}!<br />";} else {echo "Sorry, an error occurred";}
    }
   }
 }
}

function isInvalidName($f){
  return !preg_match('/^[a-zA-Z0-9-_\s]\.[^\\]+$/', $f);
}

function isInvalidType($f){
  $finfo = finfo_open(FILEINFO_MIMETYPE);
   $ft = $f['type'];
   $fm = finfo_file($finfo, $f['tmp_name']);

   $to = ($ft != 'image/jpeg' && $ft != 'image/png' && $ft != 'image/gif' && $ft != 'text/plain' && $ft != 'text/html');

// TODO WHY RETURN FALSE? Can't get mimetype...? Then don't use it...
if ( $fm !== FALSE ){
   $mo = ($fm != 'image/jpeg' && $fm != 'image/png' && $fm != 'image/gif' && $fm != 'text/plain' && $fm != 'text/html');} else { $mo = false; }

   return ($to || $mo);
}


function reArrayFiles(&$file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

?>

  </body>
</html>
