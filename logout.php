<?php
	include_once 'header.php';

	Authent::endSession();
	header("location:index.php");
?>