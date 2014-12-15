<?

include('inc/header.php');

?><h1>Virtual Mail Queue System (vmq6)</h1>
<h2>Queue</h2>
<?

$x = new vmq6();


?>
<p><? print $x->Queue(); ?></p>
