<?php

session_start();

if(isset ($_GET["user"])){

	session_destroy();

}

header("Location: ../Acceso/");
die();

