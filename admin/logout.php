<?php
	include("inc/config.php");
	unset($_SESSION['username']);
	unset($_SESSION['senha']);
	header('Location: index.php');
?>