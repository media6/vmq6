<?

include("../inc/header.php");
$my_email = "mt@media6.ca";

$x = new vmq6($active_db);
if($x->Contacts->Check($my_email)) {
  print $my_email." seems to be a legit email.";
} else {
  print "An error occured...";
}


?>