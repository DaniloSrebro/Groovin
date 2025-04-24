<?php

session_start();

session_destroy();

header("Location: ../djadmin/mikula.php");
exit;