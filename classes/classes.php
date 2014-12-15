<?
 
 if(!isset($_SESSION['BASE_DIR'])) {
       $_SESSION['BASE_DIR'] = getcwd()."/";
 }  
 $mydir = $_SESSION['BASE_DIR']."classes/";
  
 if ($handle = opendir($mydir)) {
      while (false !== ($entry = readdir($handle))) {
      
      
          if ($entry != "." && $entry != ".." && $entry != "index.php" && $entry != "classes.php" && substr($entry,strlen($entry)-4,4)==".php") {
              //echo "<br>A$entry<br>";
              include_once($mydir.$entry);
              
          }
      }
      closedir($handle);
  }


?>