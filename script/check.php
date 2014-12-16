<pre><?

  
          
include('../inc/header.php');        
       
       
$tmp = file_get_contents("postfix.log");
  
  
  function CheckForProcess($pId) {
    global $active_db;
      
    $tmp2 = file_get_contents("postfix.log");
    $lines2 = explode("\n", $tmp2);
 //   print "trying to find [: ".$pId.":]<br>";
    foreach($lines2 as $no2 => $value2) {
         $pos = strpos($value2,": ".$pId.": to=<");
         if($pos>0) {
           $my_email = substr($value2,$pos+strlen(": ".$pId.": to=<"));
           
           $pos2 = strpos($my_email,">");
           $my_email =substr($my_email,0,$pos2);
            
           print "-- ".$my_email."<br>";
           
           $x = new vmq6($active_db);
           $x->Contacts->UpdateStatus($my_email,VMQ6_CONTACTS_STATUS_ERROR);                             
           
           
           
           
           
           
           
           
         }
     }
  
  }

 $lines = explode("\n", $tmp);

 foreach($lines as $no => $value) {
    $pos = strpos($value,", status=");
   if($pos>0) {
    
     $news=  substr($value,$pos+9);
      $pos2 = strpos($news," ");
       $news =  substr($news,0,$pos2);
       
      if($news!="sent") { 
      
        $pos2 = strpos($value,"]: ");
        $myid=  substr($value,$pos2+3);
        $pos2 = strpos($myid,":");
        $myid =  substr($myid,0,$pos2);
      
        
        print "Line #".$no." - Process: #".$myid." - ".$news." - $value<br>";
        
        CheckForProcess($myid);
        
      }
   }
 
 }
 
 
 // print_r($lines);

?></pre>