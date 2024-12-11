<?php
require_once "config.php";
http_response_code(200);
$response = [
	'code' => 200,
	'status' => 'success',
	'data' => []
];

function isNotified($notify_type, $notify_id)
{
	global $connect;
	$stmt = $connect->prepare("SELECT * FROM notifications WHERE notify_type = ? AND notify_id = ? AND DATE(notify_time) = DATE(NOW())");
	$stmt->bind_param('si', $notify_type, $notify_id);
	$stmt->execute();
	$results = $stmt->get_result();
	return $results->num_rows > 0;
}

function addToNotification($notify_type, $notify_id, $notify_title, $notify_desc)
{
	global $connect;
	$stmt = $connect->prepare("INSERT INTO notifications(notify_type, notify_id, notify_title, notify_desc) VALUES (?, ?, ?, ?)");
	$stmt->bind_param('siss', $notify_type, $notify_id, $notify_title, $notify_desc);

	if (!$stmt->execute()) {
		return false;
	} else {
		return $connect->insert_id;
	}
}

if (isset($_GET['ping_notification'])) {
	$zendu_red = [];
	$zendu_yellow = [];
	$bhajipala = [];

	$redStmt = $connect->prepare("SELECT * FROM zendu_booking WHERE zb_status = 1 AND date_given = '0000-00-00' AND red_giving_date > NOW() AND red_giving_date <= (NOW() + INTERVAL 2 DAY)");

	$redStmt->execute();
	$redResults = $redStmt->get_result();
	while ($rRow = $redResults->fetch_object()) {
		$zendu_red[] = $rRow;
	}

	$yellowStmt = $connect->prepare("SELECT * FROM zendu_booking WHERE zb_status = 1 AND date_given = '0000-00-00' AND yellow_giving_date > NOW() AND yellow_giving_date <= (NOW() + INTERVAL 2 DAY)");

	$yellowStmt->execute();
	$yellowResults = $yellowStmt->get_result();
	while ($yRow = $yellowResults->fetch_object()) {
		$zendu_yellow[] = $yRow;
	}

	$bhajipalaStmt = $connect->prepare("SELECT * FROM bhajipala_sales WHERE given_date = '' AND is_not_delete = 1 AND deli_date > NOW() AND deli_date <= (NOW() + INTERVAL 2 DAY)");

	$bhajipalaStmt->execute();
	$bhajipalaResults = $bhajipalaStmt->get_result();
	while ($bRow = $bhajipalaResults->fetch_object()) {
		$bhajipala[] = $bRow;
	}

	foreach ($zendu_red as $booking) {
		$notify_type = 'zendu_booking_red';
		$notify_id = $booking->zendu_id;
		$notify_title = 'आगामी लाल झेंडू बुकिंग डिलिव्हरी';
		$booking->booking_date = date('d M Y', strtotime($booking->booking_date));
		$booking->red_giving_date = date('d M Y', strtotime($booking->red_giving_date));
		$notify_desc = <<< HTML
		<div>
			<div>
				<strong>झेंडू बुकिंग नं. : </strong>
				<span>{$booking->zendu_id}</span>
			</div>
			<div>
				<strong>झेंडू बुकिंग तारीख : </strong>
				<span>{$booking->booking_date}</span>
			</div>
			<div>
				<strong>शेतकऱ्याचे नाव : </strong>
				<span>{$booking->name}</span>
			</div>
			<div>
				<strong>देण्याची तारीख : </strong>
				<span>{$booking->red_giving_date}</span>
			</div>
			<div>
				<a href="/zendu_booking_add?zid={$booking->zendu_id}" class="badge bg-opacity-25 bg-primary border border-primary lh-sm stretched-link text-primary">बुकिंग द्या</a>
			</div>
		</div>
		HTML;
		if (!isNotified($notify_type, $notify_id)) {
			addToNotification($notify_type, $notify_id, $notify_title, $notify_desc);
		}
	}
	foreach ($zendu_yellow as $booking) {
		$notify_type = 'zendu_booking_yellow';
		$notify_id = $booking->zendu_id;
		$notify_title = 'आगामी पिवळा झेंडू बुकिंग डिलिव्हरी';
		$booking->booking_date = date('d M Y', strtotime($booking->booking_date));
		$booking->yellow_giving_date = date('d M Y', strtotime($booking->yellow_giving_date));
		$notify_desc = <<< HTML
		<div>
			<div>
				<strong>झेंडू बुकिंग नं. : </strong>
				<span>{$booking->zendu_id}</span>
			</div>
			<div>
				<strong>झेंडू बुकिंग तारीख : </strong>
				<span>{$booking->booking_date}</span>
			</div>
			<div>
				<strong>शेतकऱ्याचे नाव : </strong>
				<span>{$booking->name}</span>
			</div>
			<div>
				<strong>देण्याची तारीख : </strong>
				<span>{$booking->yellow_giving_date}</span>
			</div>
			<div>
				<a href="/zendu_booking_add?zid={$booking->zendu_id}" class="badge bg-opacity-25 bg-primary border border-primary lh-sm stretched-link text-primary">बुकिंग द्या</a>
			</div>
		</div>
		HTML;
		if (!isNotified($notify_type, $notify_id)) {
			addToNotification($notify_type, $notify_id, $notify_title, $notify_desc);
		}
	}
	foreach ($bhajipala as $booking) {
		$notify_type = 'bhajipala_booking';
		$notify_id = $booking->sale_id;
		$notify_title = 'आगामी भाजीपाला बुकिंग डिलिव्हरी';
		$booking->sdate = date('d M Y', strtotime($booking->sdate));
		$booking->deli_date = date('d M Y', strtotime($booking->deli_date));
		$notify_desc = <<< HTML
		<div>
			<div>
				<strong>भाजीपाला बुकिंग नं. : </strong>
				<span>{$booking->sale_id}</span>
			</div>
			<div>
				<strong>भाजीपाला बुकिंग तारीख : </strong>
				<span>{$booking->sdate}</span>
			</div>
			<div>
				<strong>शेतकऱ्याचे नाव : </strong>
				<span>{$booking->far_name}</span>
			</div>
			<div>
				<strong>देण्याची तारीख : </strong>
				<span>{$booking->deli_date}</span>
			</div>
			<div>
				<a href="./bhajipala_sales.php?sale_id={$booking->sale_id}" class="badge bg-opacity-25 bg-primary border border-primary lh-sm stretched-link text-primary">बुकिंग द्या</a>
			</div>
		</div>
		HTML;
		if (!isNotified($notify_type, $notify_id)) {
			addToNotification($notify_type, $notify_id, $notify_title, $notify_desc);
		}
	}
}

if (isset($_GET['get_notification'])) {
	$stmt = $connect->prepare("SELECT * FROM notifications WHERE id = ?");
	$stmt->bind_param('i', $_GET['get_notification']);
	$stmt->execute();
	$results = $stmt->get_result();
	$response['data'] = $results->fetch_object();
	if (!$response['data']) {
		http_response_code(400);
		$response['code'] = 400;
		$response['status'] = 'not-found';
	}
}

if (isset($_GET['get_notifications'])) {
	$page = $_GET['page'] ?? 1;
	$limit = $_GET['limit'] ?? 10;
	$offset = ($page - 1) * $limit;

	$countStmt = $connect->prepare("SELECT * FROM notifications WHERE notify_status = 'new'");
	$countStmt->execute();
	$countResults = $countStmt->get_result();
	$response['count'] = $countResults->num_rows;

	$stmt = $connect->prepare("SELECT * FROM notifications WHERE notify_status = 'new' ORDER BY notify_time DESC LIMIT ?, ?");
	$stmt->bind_param('ii', $offset, $limit);
	$stmt->execute();
	$results = $stmt->get_result();
	while ($row = $results->fetch_object()) {
		$response['data'][] = $row;
	}
}

if (isset($_GET['read_notification'])) {
	$stmt = $connect->prepare("UPDATE notifications SET notify_status = 'read' WHERE id = ?");
	$stmt->bind_param('i', $_GET['read_notification']);
	if (!$stmt->execute()) {
		http_response_code(500);
		$response['code'] = 500;
		$response['status'] = 'error';
	}
}

if (isset($_GET['delete_notification'])) {
	$stmt = $connect->prepare("UPDATE notifications SET notify_status = 'deleted' WHERE id = ?");
	$stmt->bind_param('i', $_GET['delete_notification']);
	if (!$stmt->execute()) {
		http_response_code(500);
		$response['code'] = 500;
		$response['status'] = 'error';
	}
}
header('Content-type: application/json');
echo json_encode($response);