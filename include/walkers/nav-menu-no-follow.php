<?php

if(!class_exists('Walker_Nav_Menu_No_Follow')) {

	/*
		Nav walker class that adds rel="nofollow" attributes to all links.
	*/
	class Walker_Nav_Menu_No_Follow extends Walker_Nav_Menu {

		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			$item->xfn = 'nofollow';
			parent::start_el($output, $item, $depth, $args, $id);
		}

	}
}