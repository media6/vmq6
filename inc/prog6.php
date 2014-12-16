<?


$_SESSION['BASE_DIR'] = realpath(dirname(__FILE__))."/../";
$_SESSION['IPT_VARS_DIR'] = "/home/sources/www/vmq.media6.ca/prog6/php/";



include_once($_SESSION['IPT_VARS_DIR']."widget.php");    

include_once($_SESSION['IPT_VARS_DIR']."_debug.php");   
 
 include_once($_SESSION['IPT_VARS_DIR']."dbobject.php");
 
       
include_once($_SESSION['IPT_VARS_DIR']."db.php");
include_once($_SESSION['IPT_VARS_DIR']."dbquery.php");
include_once($_SESSION['IPT_VARS_DIR']."dbupdate.php");
              
include_once($_SESSION['IPT_VARS_DIR']."email.php");
include_once($_SESSION['IPT_VARS_DIR']."crypt.php");
include_once($_SESSION['IPT_VARS_DIR']."url.php");
include_once($_SESSION['IPT_VARS_DIR']."magicscreen.php");


include_once($_SESSION['IPT_VARS_DIR']."pdf.php");
//include_once($_SESSION['VARS_DIR']."ezpdf.php");
include_once($_SESSION['IPT_VARS_DIR']."pdf_form.php");

include($_SESSION['IPT_VARS_DIR']."screen.php");
//include_once($_SESSION['VARS_DIR']."pagenumber.php");
include_once($_SESSION['IPT_VARS_DIR']."imap.php");



?>