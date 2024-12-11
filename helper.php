<?php
class Aditya{
	private static $title = 'आदित्य नर्सरी';
	private static $subtitle = 'Admin';
	public static function Title($title) {
		self::$title = $title;
	}
	public static function Subtitle($subtitle) {
		self::$subtitle = $subtitle;
	}
	public static function PrintTitle() {
		echo '<title>'.self::$title.' | '.self::$subtitle.'</title>';
	}
}

function find_user($id) {
	global $connect;
	$getUser = mysqli_query($connect, "SELECT * FROM admin WHERE id = '{$id}'");
	if (mysqli_num_rows($getUser)>0) {
		return (object) mysqli_fetch_assoc($getUser);
	}
	return null;
}

function find_customer($cus_id) {
	global $connect;
	$getCustomer = mysqli_query($connect, "SELECT * FROM customer WHERE cus_id = '{$cus_id}'");
	if (mysqli_num_rows($getCustomer)>0) {
		return (object) mysqli_fetch_assoc($getCustomer);
	}
	return null;
}

function NotFound() {
	global $connect;
	global $url;
	global $redirect;
	global $authUser;
	global $auth_permissions;
	require_once '404.php';
	die();
}

if (!function_exists('week_range')) {
	function week_range($date) {
		$ts = strtotime($date);
		$start = (date('l', $ts) !== 'Monday' ? strtotime('Last Monday', $ts) : $ts);
		$end = (date('l', $ts) !== 'Sunday' ? strtotime('Next Sunday', $start) : $ts);
		return array(
			date('Y-m-d', $start),
			date('Y-m-d', $end)
		);
	}
}
if (!function_exists('week_date_list')) {
	function week_date_list($date) {
		list($start, $end) = week_range($date);
		$_dates = [];
		$i = 0;
		while ($i < 7) {
			$ts = strtotime($start." + {$i} Days");
			$_dates[] = (object) [
				'date' => date('Y-m-d', $ts),
				'is_totay' => (date('d M Y', strtotime($date)) === date('d M Y', $ts) ? true : false),
				'full_date' => date('d M Y', $ts),
				'day' => date('d', $ts),
				'full_day' => date('l', $ts),
				'full_month' => date('F', $ts),
				'month' => date('M', $ts),
				'year' => date('Y', $ts),
			];
			$i++;
		}
		return $_dates;
	}
}
if (!function_exists('week_date_selected')) {
	function week_date_selected($week_date_list) {
		return array_values(array_filter($week_date_list, function($date){
			return $date->is_totay;
		}))[0];
	}
}
if (!function_exists('month_range')) {
	function month_range($date) {
		$ts = strtotime($date);
		return array(
			date('Y-m-01', $ts),
			date('Y-m-t', $ts),
		);
	}
}
if (!function_exists('month_date_list')) {
	function month_date_list($date) {
		list($start, $end) = month_range($date);
		$_dates = [];
		$i = 0;
		$days = date('t', strtotime($start));
		while ($i < $days) {
			$ts = strtotime($start." + {$i} Days");
			$_dates[] = (object) [
				'date' => date('Y-m-d', $ts),
				'is_totay' => (date('d M Y', strtotime($date)) === date('d M Y', $ts) ? true : false),
				'full_date' => date('d M Y', $ts),
				'day' => date('d', $ts),
				'full_day' => date('l', $ts),
				'full_month' => date('F', $ts),
				'month' => date('M', $ts),
				'year' => date('Y', $ts),
			];
			$i++;
		}
		return $_dates;
	}
}

if (!function_exists('get_emp_attendance')) {
	function get_emp_attendance($emp_id, $date) {
		global $connect;
// 		$user = get_session_user();
		$query = mysqli_query($connect, "SELECT * FROM attendance WHERE at_date = '{$date}' AND at_emp_id = '{$emp_id}'");
		if (mysqli_num_rows($query) > 0) {
			$row = (object) mysqli_fetch_assoc($query);
			$result = (object) [
				'at_emp_id' => (int) $row->at_emp_id,
				'at_date' => date('Y-m-d', strtotime($row->at_date)),
				'at_status' => $row->at_status,
			];
		} else {
			$result = (object) [
				'at_emp_id' => (int) $emp_id,
				'at_date' => date('Y-m-d', strtotime($date)),
				'at_status' => false,
			];
		}
		return $result;
	}
}

if (!function_exists('get_employees')) {
	function get_employees($emp_id=false) {
		global $connect;
		//$user = get_session_user();
		//$where = ($emp_id!==false) ? " AND emp_id = '{$emp_id}'" : '';
		$sql = mysqli_query($connect, "SELECT * FROM employees where emp_status='1' and emp_gender='male'");
		$data = array();
		if (mysqli_num_rows($sql) > 0) {
			if ($emp_id!==false) {
				$row = mysqli_fetch_assoc($sql);
				$row['emp_gender_lang'] = $row['emp_gender'];
				$data = (object) $row;
			} else {
				while ($row = mysqli_fetch_assoc($sql)) {
					$row['emp_gender_lang'] = $row['emp_gender'];
					$data[] = (object) $row;
				}
			}
		}
		return $data;
	}
}
if (!function_exists('get_employees_female')) {
	function get_employees_female($emp_id=false) {
		global $connect;
		//$user = get_session_user();
		//$where = ($emp_id!==false) ? " AND emp_id = '{$emp_id}'" : '';
		$sql = mysqli_query($connect, "SELECT * FROM employees where emp_status='1' and emp_gender='female'");
		$data = array();
		if (mysqli_num_rows($sql) > 0) {
			if ($emp_id!==false) {
				$row = mysqli_fetch_assoc($sql);
				$row['emp_gender_lang'] = $row['emp_gender'];
				$data = (object) $row;
			} else {
				while ($row = mysqli_fetch_assoc($sql)) {
					$row['emp_gender_lang'] = $row['emp_gender'];
					$data[] = (object) $row;
				}
			}
		}
		return $data;
	}
}

if (!function_exists('get_employees_sallery_male')) {
	function get_employees_sallery_male($emp_id=false) {
		global $connect;
		//$user = get_session_user();
		//$where = ($emp_id!==false) ? " AND emp_id = '{$emp_id}'" : '';
		$sql = mysqli_query($connect, "SELECT * FROM employees where emp_gender='male'");
		$data = array();
		if (mysqli_num_rows($sql) > 0) {
			if ($emp_id!==false) {
				$row = mysqli_fetch_assoc($sql);
				$row['emp_gender_lang'] = $row['emp_gender'];
				$data = (object) $row;
			} else {
				while ($row = mysqli_fetch_assoc($sql)) {
					$row['emp_gender_lang'] = $row['emp_gender'];
					$data[] = (object) $row;
				}
			}
		}
		return $data;
	}
}

if (!function_exists('get_employees_sallery_female')) {
	function get_employees_sallery_female($emp_id=false) {
		global $connect;
		//$user = get_session_user();
		//$where = ($emp_id!==false) ? " AND emp_id = '{$emp_id}'" : '';
		$sql = mysqli_query($connect, "SELECT * FROM employees where emp_gender='female'");
		$data = array();
		if (mysqli_num_rows($sql) > 0) {
			if ($emp_id!==false) {
				$row = mysqli_fetch_assoc($sql);
				$row['emp_gender_lang'] = $row['emp_gender'];
				$data = (object) $row;
			} else {
				while ($row = mysqli_fetch_assoc($sql)) {
					$row['emp_gender_lang'] = $row['emp_gender'];
					$data[] = (object) $row;
				}
			}
		}
		return $data;
	}
}


if (!function_exists('save_attendance')) {
	function save_attendance($options) {
		global $connect;
		if (!isset($options['at_date'])) {
			throw new \Exception("at_date required");
			exit();
		}
		if (!isset($options['at_emp_id']) || (!is_array($options['at_emp_id']) && !is_object($options['at_emp_id']))) {
			throw new \Exception("at_emp_id required");
			exit();
		}
		if (!isset($options['at_status']) || (!is_array($options['at_status']) && !is_object($options['at_status']))) {
			$options['at_status'] = [];
			foreach ($options['at_emp_id'] as $eid) {
				$options['at_status'][$eid] = 'A';
			}
		}
		$at_date = date('Y-m-d', strtotime($options['at_date']));
		$at_emp_id = $options['at_emp_id'];
		$at_status = $options['at_status'];
		//$user = get_session_user();
		$updated = true;
		foreach ($at_emp_id as $emp_id) {
			$attn = get_emp_attendance($emp_id, $at_date);
			if ($attn->at_status) {
				$save = mysqli_query($connect, "UPDATE attendance SET
				at_status = '{$at_status[$emp_id]}'
				WHERE at_date = '{$at_date}' AND at_emp_id = '{$emp_id}'");
			} else {
				if (!isset($at_status[$emp_id])) {
					$at_status[$emp_id] = 'A';
				}
				$save = mysqli_query($connect, "INSERT INTO attendance( at_emp_id, at_date, at_status) VALUES ('{$emp_id}', '{$at_date}', '{$at_status[$emp_id]}')");
			}
			if (!$save) {
				$updated = false;
			} 
		}
		return $updated;
	}
}

if (!function_exists('save_female_attendance')) {
	function save_female_attendance($options) {
		global $connect;
		if (!isset($options['at_date'])) {
			throw new \Exception("at_date required");
			exit();
		}
		if (!isset($options['at_emp_id']) || (!is_array($options['at_emp_id']) && !is_object($options['at_emp_id']))) {
			throw new \Exception("at_emp_id required");
			exit();
		}
		if (!isset($options['at_status']) || (!is_array($options['at_status']) && !is_object($options['at_status']))) {
			$options['at_status'] = [];
			foreach ($options['at_emp_id'] as $eid) {
				$options['at_status'][$eid] = 'A';
			}
		}
		$at_date = date('Y-m-d', strtotime($options['at_date']));
		$at_emp_id = $options['at_emp_id'];
		$at_status = $options['at_status'];
		//$user = get_session_user();
		$updated = true;
		foreach ($at_emp_id as $emp_id) {
			$attn = get_emp_attendance($emp_id, $at_date);
			if ($attn->at_status) {
				$save = mysqli_query($connect, "UPDATE attendance SET
				at_status = '{$at_status[$emp_id]}'
				WHERE at_date = '{$at_date}' AND at_emp_id = '{$emp_id}'");
			} else {
				if (!isset($at_status[$emp_id])) {
					$at_status[$emp_id] = 'A';
				}
				$save = mysqli_query($connect, "INSERT INTO attendance( at_emp_id, at_date, at_status) VALUES ('{$emp_id}', '{$at_date}', '{$at_status[$emp_id]}')");
			}
			if (!$save) {
				$updated = false;
			} 
		}
		return $updated;
	}
}

// if (!function_exists('save_female_attendance')) {
// 	function save_female_attendance($options) {
// 		global $connect;
// 		if (!isset($options['at_date'])) {
// 			throw new \Exception("at_date required");
// 			exit();
// 		}
// 		if (!isset($options['per_day'])) {
// 			throw new \Exception("per_day required");
// 			exit();
// 		}
// 		if (!isset($options['at_emp_id']) || (!is_array($options['at_emp_id']) && !is_object($options['at_emp_id']))) {
// 			throw new \Exception("at_emp_id required");
// 			exit();
// 		}
// 		if (!isset($options['at_status']) || (!is_array($options['at_status']) && !is_object($options['at_status']))) {
// 			$options['at_status'] = [];
// 			foreach ($options['at_emp_id'] as $eid) {
// 				$options['at_status'][$eid] = 'A';
// 			}
// 		}
// 		$at_date = date('Y-m-d', strtotime($options['at_date']));
// 		$at_emp_id = $options['at_emp_id'];
// 		$at_status = $options['at_status'];
// 		$per_day = $options['per_day'];
// 		//$user = get_session_user();
// 		$updated = true;
// 		foreach ($at_emp_id as $emp_id) {
// 			$attn = get_emp_attendance($emp_id, $at_date);
// 			if ($attn->at_status) {
// 				$save = mysqli_query($connect, "UPDATE attendance SET
// 				at_status = '{$at_status[$emp_id]}',
// 				per_day = '{$per_day[$per_day]}'
// 				WHERE at_date = '{$at_date}' AND at_emp_id = '{$emp_id}'");
// 			} else {
// 				if (!isset($at_status[$emp_id])) {
// 					$at_status[$emp_id] = 'A';
// 				}
// 				$save = mysqli_query($connect, "INSERT INTO attendance( at_emp_id, at_date, at_status,per_day) VALUES ('{$emp_id}', '{$at_date}', '{$at_status[$emp_id]}','{$per_day}')");
// 			}
// 			if (!$save) {
// 				$updated = false;
// 			} 
// 		}
// 		return $updated;
// 	}
// }

/**
 * Multi Language translate
 * 
 **/
if (!isset($_SESSION['lang'])) {
	if (isset($_COOKIE['lang'])) {
		$_SESSION['lang'] = $_COOKIE['lang'];
		$lang = $_COOKIE['lang'];
	} else {
		$lang = 'mr';
	}
} else {
	$lang = $_SESSION['lang'];
}
if (isset($_REQUEST['language'])) {
	$_SESSION['lang'] = $_REQUEST['language'];
	$lang = $_REQUEST['language'];
	setcookie('lang', $lang, time() + (86400 * 30), '/');
	header("Location: {$_SERVER['REQUEST_URI']}");
}
require_once 'lang.php';
if (!function_exists('translate')) {
	function translate($word) {
		global $lang;
		global $_dictionary;
		$match = @$_dictionary[$word];
		if (is_array($match)) {
			return $match[$lang];
		}
		return $word;
	}
}
if (!function_exists('translate_date')) {
	function translate_date($date) {
		preg_match('/(\d{2}) (\w{3}) (\d{4})/', $date, $matched, PREG_OFFSET_CAPTURE);
		if ($matched[0][0] == $date && count($matched) > 3) {
			$d = translate_number($matched[1][0]);
		    $M = translate($matched[2][0]);
		    $Y = translate_number($matched[3][0]);
		    return "{$d} {$M} {$Y}";
		}
		return $date;
	}
}

if (!function_exists('translate_number')) {
	function translate_number($number) {
		$trans = '';
		$number = strval($number);
		for($i=0; $i < strlen($number); $i++) {
			$trans .= translate($number[$i]);
		}
		return $trans;
	}
}

if (!function_exists('load_salary_format')) {
	function load_salary_format() {
		//$format = Settings::Find('salary_format');
		if (@$format) {
			return $format;
		} else {
			return 'monthly';
		}
	}
}

if (!function_exists('sum_advance')) {
	function sum_advance($emp_id, $month) {
		global $connect;
		
		$sql = mysqli_query($connect, "SELECT ROUND(SUM(ead_amount), 2) AS total_advance FROM employee_advance WHERE ead_emp_id = '{$emp_id}' and MONTH(ead_date)='{$month}' ");
		$advance = 0.00;
		if (mysqli_num_rows($sql) > 0) {
			$row = mysqli_fetch_assoc($sql);
			$advance = (float) sprintf('%0.2f', $row['total_advance']);
		}
		return $advance;
	}
}