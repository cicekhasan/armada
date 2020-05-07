<?php
	require_once 'core/init.php';

	if (Session::varsa('basari')) {
		echo Session::flash('basari');
	}

	//echo Session::getir(Config::getir('session/session_ismi'));
?>