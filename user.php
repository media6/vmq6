<?

include('inc/header.php');


  if(isset($_GET['id'])) {
$x = new vmq6($active_db);

 //      print_r($x->Queue());

          $z = new iptWidget("html/detail_user.html",$x->Contacts->Infos($_GET['id'])); 
          $z->ParseData("row_msg",$x->Contacts->ListEmails($_GET['id']));
      
          print $z->GetHTML();
          
  } else {
  
  header('Location:index.php');
  }

 ?>
