<?php

include("db_connect.php");

if ($conn) {
    echo "<h2 style='color:green;'>✅ Database Connected Successfully!</h2>";
} else {
    echo "<h2 style='color:red;'>❌ Connection Failed!</h2>";
}

?>