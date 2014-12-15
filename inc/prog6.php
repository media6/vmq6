<?


$_SESSION['BASE_DIR'] = realpath(dirname(__FILE__))."/../";
$_SESSION['VARS_DIR'] = $_SESSION['BASE_DIR']."prog6/php/";

include_once($_SESSION['VARS_DIR']."widget.php");
include_once($_SESSION['VARS_DIR']."userauthentification.php");
include_once($_SESSION['VARS_DIR']."_debug.php");
include_once($_SESSION['VARS_DIR']."db.php");
include_once($_SESSION['VARS_DIR']."dbquery.php");
include_once($_SESSION['VARS_DIR']."dbupdate.php");
include_once($_SESSION['VARS_DIR']."email.php");
include_once($_SESSION['VARS_DIR']."crypt.php");
include_once($_SESSION['VARS_DIR']."url.php");
include_once($_SESSION['VARS_DIR']."magicscreen.php");


include_once($_SESSION['VARS_DIR']."pdf.php");
//include_once($_SESSION['VARS_DIR']."ezpdf.php");
include_once($_SESSION['VARS_DIR']."pdf_form.php");

include($_SESSION['VARS_DIR']."dbobject.php");
include($_SESSION['VARS_DIR']."screen.php");
//include_once($_SESSION['VARS_DIR']."pagenumber.php");
include_once($_SESSION['VARS_DIR']."imap.php");



?>