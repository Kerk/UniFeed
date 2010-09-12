<?php

  if ($_POST['filename']) {
    $filename = $_POST['filename'];
    $link = $_POST['link'];
    $global = $_POST['global'];
    $items = $_POST['items'];
    $itemtemplate = $_POST['itemtemplate'];

    $f = fopen("./templates/".$_POST['filename'],"w");
    fwrite($f, urlencode($link)."\r\n");
    fwrite($f, urlencode($global)."\r\n");
    fwrite($f, urlencode($items)."\r\n");
    fwrite($f, urlencode($itemtemplate)."\r\n");
    fclose($f);    
  }

  if ($_GET['name']) {
    $filename = $_GET['name'];

    $f = fopen("./templates/".$filename,"r");

    $link = urldecode(trim(fgets($f,1024)));
    $global = urldecode(trim(fgets($f,1024)));
    $items = urldecode(trim(fgets($f,1024)));
    $itemtemplate = urldecode(trim(fgets($f,1024)));
    
    fclose($f);    
  }

/////////////////////////////////////////////////////////////////////////////////

?>

<html>
<body>
<h1>UniFeed setup</h1>
<table border=0><tr valign=top><td style="padding:50px;">
<form method="get" action="index.php">
<input name="name" value="<?php echo $filename;?>"><br>
<input value="Load" type="submit">
</form>
</td><td>
<form method="post" action="index.php">
Feed Name:<br><input name="filename" value="<?php echo $filename;?>"><br>
URL:<br><input size="30" name="link" value="<?php echo $link;?>"><br>
Global pattern:<br>
<textarea name="global" cols=40 rows=5><?php echo stripslashes($global);?></textarea><br>
Item search:<br>
<textarea name="items" cols=40 rows=5><?php echo stripslashes($items);?></textarea><br>
Item Template:<br><textarea name="itemtemplate" cols=40 rows=5><?php echo stripslashes($itemtemplate);?></textarea><br>
<input type="submit" value="Save">
</form>
<?php 
  if ($_POST['filename']) {
    echo "Saved!<br>";
  }
?>
</td>
<td style="padding:50px;">
<?php
  echo "<i>Feed List</i>:<br>";
  $d = dir("./templates");
  while (false !== ($entry = $d->read()))
  {
    if (($entry != ".") && ($entry != ".."))
    {
      echo "$entry: <a href=\"?name=$entry\">".Load."</a>&nbsp;<a href=\"getpage.php?name=$entry&preview=1\">".Preview."</a>&nbsp;<a href=\"getpage.php?name=$entry\">".XML."</a><br>\n";
    }
  }
  $d->close();
?>
</td>
</tr></table>
</body>
</html>
