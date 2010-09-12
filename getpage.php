<?php

$preview = $_GET['preview'];

function prepare($str)
{
  $str = stripslashes($str);
  $str = str_replace("/", "\\/", $str);
  $str = str_replace("\.", "\\\.", $str);
  $str = str_replace("\?", "\\\?", $str);
  return trim($str);
}

$f = fopen("./templates/".$_GET['name'], "r");
$link = urldecode(trim(fgets($f, 1024)));
$gl = urldecode(fgets($f, 16386));
$it = urldecode(fgets($f, 16386));
$itemtemplate = urldecode(trim(fgets($f, 16386)));
fclose($f);

$gl = str_replace("{%}", "(.+)", prepare($gl));
$it = str_replace("{%}", "(.*?)", prepare($it));

/////////////////////////////////////////////////////////////////////////////////

$page = file_get_contents($link);

preg_match("/".$gl."/si", $page, $result);
$page = $result[1];

preg_match_all("/".$it."/si", $page, $result, PREG_SET_ORDER);

if (!$preview)
  echo "<unifeed>\n"; 

for ($i = 0; $i <= count($result)-1; $i++)
{
  $current_item = $itemtemplate;
    
  for ($j = 1; $j < count($result[$i]); $j++)
  {
    if ($preview)
      echo "{%$j} = ".$result[$i][$j]."<br>";
    else
      $current_item = str_replace("{%$j}", $result[$i][$j], $current_item);
  }
    
  if ($preview)
    echo "<br>";
  else
  {
    echo "<item>\n";
    echo $current_item."\n";
    echo "</item>\n";
  }
}

if (!$preview)
  echo "</unifeed>\n";

?>
