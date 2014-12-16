<?

include('inc/header.php');

?><h1>Virtual Mail Queue System (vmq6)</h1>
<h2>Queue</h2>
<?
  if(isset($_GET['id'])) {
$x = new vmq6($active_db);




 //      print_r($x->Queue());

          $z = new iptWidget("html/detail_email.html",$x->Emails->Infos($_GET['id'])); 
       //  print_r($x->Emails->Destinataires($_GET['id'],VMQ6_ROUTING_TYPE_TO)->RowCount()); 
          $z->ParseData("row_to",$x->Emails->Destinataires($_GET['id'],VMQ6_ROUTING_TYPE_TO));
          $z->ParseData("row_cc",$x->Emails->Destinataires($_GET['id'],VMQ6_ROUTING_TYPE_CC));
          $z->ParseData("row_bcc",$x->Emails->Destinataires($_GET['id'],VMQ6_ROUTING_TYPE_BCC));
             
          print $z->GetHTML();
          
  } else {
  
  print "Error!";
  }

 ?>
