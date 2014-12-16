<?

include('inc/header.php');
if(!isset($_GET['id'])) {
  $_GET['id']=0;
}

$x = new vmq6($active_db);
$nb = $x->Send($_GET['id']);

print $nb." items sent";


          
 ?>
