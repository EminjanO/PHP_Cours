<?php
// Start the session
session_start();
include "menu.inc.php";
?>
<!DOCTYPE html>
<html>
<body>

<?php
// Set session variables
$_SESSION["startTime"] = date("F j, Y, g:i a");
$_SESSION["lastVisit"]["start"] = date("F j, Y, g:i a");
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>

</body>
</html>