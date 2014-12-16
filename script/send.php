<?




          
include('../inc/header.php');        
       

$x = new vmq6($active_db);

$max_min = $x->Config->GetValue("max_per_min");


if($max_min<1) { $max_min=0; }
if($max_min>50) { $max_min=50; }

if($max_min>0) {
        for($i=0;$i<$max_min;$i++) {
          print "Sending ".($i+1)." of ".$max_min."<br>";
          $nb = $x->Send(0,"/home/sources/www/vmq.media6.ca/");
        }

}




?>