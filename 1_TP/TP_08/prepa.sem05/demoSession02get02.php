<?php
session_start();
include "menu.inc.php";
?>
<!DOCTYPE html>
<html>
<body>

<?php

$_SESSION["lastVisit"]["print_r"] = date("F j, Y, g:i a");
echo "<pre>".print_r($_SESSION,true)."</pre>";
?>

</body>
</html>
Run example »
