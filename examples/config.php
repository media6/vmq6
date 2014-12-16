<?

include("../inc/header.php");
?>
<h1>vmq6 examples</h1>
<h2>Configuration</h2>
<?
  
    $x = new vmq6($active_db);
    $x->Config->SetValue("max_per_min",1);
    $x->Config->SetValue("max_per_hour",60);
    $x->Config->SetValue("max_per_day",1000);
    
    
  
?>

