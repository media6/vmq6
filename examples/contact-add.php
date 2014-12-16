<?

include("../inc/header.php");
?>
<h1>vmq6 examples</h1>
<h2>Add an email to your list</h2>
<?

if(isset($_POST['address'])) {
    $my_email =$_POST['address'];
    
    $x = new vmq6($active_db);
    if($x->Contacts->Check($my_email)) {
      print $my_email." seems to be a legit email.";
    } else {
      print "An error occured...";
    }
      print "<br><br><a href=\"".$_SERVER['PHP_SELF']."\">Click here to start over</a>.";

} else {

?>
<form method="post">
<input type="text" name="address" value="your@mail.com">
<input type ="submit">

</form>
<?
 
}

?>