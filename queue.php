<?

include('inc/header.php');


$x = new vmq6($active_db);




 //      print_r($x->Queue());

          $z = new iptWidget("html/list_emails.html",$x->Queue());    
          print $z->GetHTML();
          


 ?>
