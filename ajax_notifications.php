<?php
require_once 'header.php';
require_once 'Response.php';

if ($_SERVER['REQUEST_METHOD']!=='POST' || empty($_POST)) {
	Response::NotAllowed();
	Response::PrintJSON(true);
	exit();
} else {
	escapePOST($_POST);
}
/***********************************/
/*-------- { Social Post } --------*/
/***********************************/
if (isset($_POST['get_notifications'])) {
	Response::Data(Notification::Get([
		'n_user_id' => $vid,
		'n_for' => 'vendor',
		'n_seen' => '0'
	]));
	Response::Success();
	Response::PrintJSON(true);
}
if (isset($_POST['mark_as_seen'])) {
	Notification::MarkAsSeen($_POST['mark_as_seen']);
	Response::Success();
	Response::PrintJSON(true);
}
if (isset($_POST['mark_all_seen'])) {
	Notification::MarkAllAsSeen('vendor', $vid);
	Response::Success();
	Response::PrintJSON(true);
}