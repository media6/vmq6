<?

include("inc/header.php");
?>
<h1>vmq6</h1>
<h2>Create an email</h2>
<?

if(isset($_POST['title']) && isset($_POST['from']) && isset($_POST['to']) && isset($_POST['message'])) {

    $x = new vmq6($active_db);
    if($x->Emails->Create($_POST['title'],$_POST['message'],$_POST['from'],$_POST['to'],$_POST['cc'],$_POST['bcc'],"/home/sources/www/vmq.media6.ca/")) {
      print "email is now in queue...";
    } else {
      print "An error occured...";
    }
    
    print "<br><br><a href=\"".$_SERVER['PHP_SELF']."\">Click here to start over</a>.";



} else {

?>
<form method="post">
<table>
  <tr>
    <td>From : </td>
    <td><input type="text" name="from" value="your@mail.com"></td>
  </tr>
  <tr>
    <td>To : </td>
    <td><input type="text" name="to" value="your@mail.com"></td>
  </tr>
  <tr>
    <td>CC : </td>
    <td><input type="text" name="cc" value=""></td>
  </tr>
  <tr>
    <td>BCC : </td>
    <td><input type="text" name="bcc" value=""></td>
  </tr>
  
  <tr>
    <td>Titre : </td>
    <td><input type="text" name="title" value="Title"></td>
  </tr>  
  <tr>
    <td>Message : </td>
    <td><textarea name="message"></textarea></td>
  </tr>
  
  <tr>
    <td></td>
    <td><input type ="submit"></td>
  </tr>  
  


</form>
<?
 
}

?>