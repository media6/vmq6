<?
 

 $mydir = realpath(dirname(__FILE__))."/";
 
 if ($handle = opendir($mydir)) {
      while (false !== ($entry = readdir($handle))) {
      
      
          if ($entry != "." && $entry != ".." && $entry != "index.php" && $entry != "classes.php" && substr($entry,strlen($entry)-4,4)==".php") {
         //     echo "<br>$mydir$entry<br>";
              include_once($mydir.$entry);
              
          }
      }
      closedir($handle);
  }


?>