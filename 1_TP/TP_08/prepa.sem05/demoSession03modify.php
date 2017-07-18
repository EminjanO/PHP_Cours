<?php
session_start();
include "menu.inc.php";
?>
<!DOCTYPE html>
<html>
<body>

<?php
// to change a session variable, just overwrite it

$_SESSION["lastVisit"]["modify"] = date("F j, Y, g:i a");
$_SESSION["favcolor"] = "yellow";
$_SESSION["startTime"] = date("F j, Y, g:i a");
echo "<pre>".print_r($_SESSION,true)."</pre>";

?>

</body>
</html>
Run example »
