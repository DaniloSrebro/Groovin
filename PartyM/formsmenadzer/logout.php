<?php

session_start();

session_destroy();

header("Location: ../tocionica/pregled/pregledtocionica.php");
exit;