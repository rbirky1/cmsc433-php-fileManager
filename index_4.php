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
            <a href="./index.php?sort=name&amp;order=ascending">&darr;</a><a href="./index.php?sort=name&amp;order=descending">&uarr;</a>
          </th>
          <th>
            Size
            <a href="./index.php?sort=size&amp;order=ascending">&darr;</a><a href="./index.php?sort=size&amp;order=descending">&uarr;</a>
          </th>
          <th>
            Type
            <a href="./index.php?sort=type&amp;order=ascending">&darr;</a><a href="./index.php?sort=type&amp;order=descending">&uarr;</a>
          </th>
          <th>
            Modified
            <a href="./index.php?sort=modified&amp;order=ascending">&darr;</a><a href="./index.php?sort=modified&amp;order=descending">&uarr;</a>
          </th>
        </tr>
      </thead>
      <tbody>
<?

$filesArray = getFiles();

if ($_GET['sort'] == 'size') { 
	   usort($filesArray, function($a,$b){ if($a->size == $b->size) return 0; return ($a->size < $b->size) ? -1 : 1; });
	   if ($_GET['order'] == 'ascending') { $filesArray = array_reverse($filesArray); }
	}

//TODO
if ($_GET['sort'] == 'name') { 
	   usort($filesArray, function($a,$b){ return strcmp(strtolower($a->name), strtolower($b->name)); });
	   if ($_GET['order'] == 'ascending') { $filesArray = array_reverse($filesArray); }
	}

if ($_GET['sort'] == 'type') { 
	   usort($filesArray, function($a,$b){ return strcmp($a->type, $b->type); });
	   if ($_GET['order'] == 'ascending') { $filesArray = array_reverse($filesArray); }
	}

if ($_GET['sort'] == 'modified') { 
	   usort($filesArray, function($a,$b){ return strcmp($a->time, $b->time); });
	   if ($_GET['order'] == 'ascending') { $filesArray = array_reverse($filesArray); }
	}

printTable($filesArray);

function getFiles(){
         $dirname = 'uploads/';
         $dir = 'uploads/*';
         $files = array();
         $finfo = finfo_open(FILEINFO_MIME_TYPE);
         foreach (glob($dir) as $file){
           $n = basename($file);
 // chmod( $dirname . $n, 0777);
           $t = date("M j, Y g:i a", filemtime($file));
           $m = finfo_file($finfo, $file);
           $m = getMime($m);
           $s = filesize($file);

           $href = "$dirname$n";
           $thisFile = new FileU($n, $s, $m, $t, $href);
	   $files[] = clone $thisFile;
	  }
         return $files;
       }

function printTable($arr){
//var_dump($arr[0]->name);
//echo "{$arr[0]->name}";
  foreach (array_values($arr) as $afile){
	$s = $afile->size;
        if ( $s > 1000)	{$s = round( $s / 1000) . " KB";} else { $s .= "  B";}
         echo "<tr>
         <td><input type='checkbox' name='files[]' value={$afile->name} /></td>
         <td><a href={$afile->href}>{$afile->name}</a></td>
         <td class='number'>$s</td>
         <td>{$afile->mime}</td>
         <td>{$afile->time}</td>
         </tr>";
       }
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

class FileU{

	public $name;
	public $size;
	public $mime;
	public $time;
	public $href;

	function FileU($name, $size, $mime, $time, $href){
	  $this->name = $name;
	  $this->size = $size;
	  $this->mime = $mime;
	  $this->time = $time;
	  $this->href = $href;
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
