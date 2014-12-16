<?

include('inc/header.php');

?><h1>Virtual Mail Queue System (vmq6)</h1>
<h2>Status</h2>
<?

$x = new vmq6($active_db);


?>
<p><? print $x->Status(); ?></p>
