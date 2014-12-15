<?


if(!isset($_POST['login']) ||
!isset($_POST['pass'])) {

  header('Location: error.php');


} else {
        
  $login = $_POST['login'];
  $pass = $_POST['pass'];
  
  
  
  
}

?>