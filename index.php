<?php
	require_once 'core/init.php';

	if (Session::varsa('basari')) {
		echo Session::flash('basari');
	}
?>