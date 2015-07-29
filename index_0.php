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
<h1>File Manager &mdash; View Files</h1>
<form action="delete-file.php" method="post">
<table>
  <thead>
    <tr>
      <th></th>
      <th>
        Name
        <a href="./index.php?sort=name&amp;order=ascending">&darr;</a><a href="./index.php?sort=name&amp;order=des\
cending">&uarr;</a>
      </th>
      <th>
        Size
        <a href="./index.php?sort=size&amp;order=ascending">&darr;</a><a href="./index.php?sort=size&amp;order=des\
cending">&uarr;</a>
      </th>
      <th>
        Type
        <a href="./index.php?sort=type&amp;order=ascending">&darr;</a><a href="./index.php?sort=type&amp;order=des\
cending">&uarr;</a>
      </th>
      <th>
        Modified
        <a href="./index.php?sort=modified&amp;order=ascending">&darr;</a><a href="./index.php?sort=modified&amp;o\
rder=descending">&uarr;</a>
      </th>
    </tr>
  </thead>
  <tbody>
<?
$dirname = 'uploads/';
$dir = 'uploads/*';
$file = array();
$finfo = finfo_open(FILEINFO_MIME_TYPE);
foreach (glob($dir) as $file){
	$t = date("M j, Y g:i a", filemtime($file));
	$m = finfo_file($finfo, $file);
	$m = getMime($m);
	$s = filesize($file);
	if ($s > 1000)	{$s = round( $s / 1000) . " KB";} else { $s .= "  B";}
	$n = basename($file);

	echo "<tr>
		<td><input type='checkbox' name='files[]' value=$n /></td>
	     	<td><a href=$dirname$n>$n</a></td>
	     	<td class='number'>$s</td>
	     	<td>$m</td>
	     	<td>$t</td>
	     </tr>";
}


function getMime($type){

	 switch($type){
		case "image/jpeg":
		     return "JPEG image";
		     break;
		case "image/gif":
		     return "GIF image";
		     break;
		case "image/png":
		     return "PNG image";
		     break;
		case "text/plain":
		     return "Plain Text Document";
		     break;
		case "text/html":
		     return "HTML Document";
		     break;
		default:
			return $type;
	 }

}
?>
  </tbody>
</table>
<br />
<input type="submit" value="Delete Selected Files" />
</form>

  </body>
</html>