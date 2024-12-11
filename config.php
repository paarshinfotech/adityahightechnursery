<?php
if (!defined('APP_VERSION')) {
	define('APP_VERSION', '1.0.0');
}
if (!defined('APP_DEBUG')) {
	define('APP_DEBUG', false);
}

if (isset($_REQUEST['show_error']) || APP_DEBUG) {
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
} else {
	ini_set('display_startup_errors', false);
	ini_set('display_errors', 0);
	error_reporting(false);
}
if (!isset($_SESSION)) {
	session_start();
}

function fast_output() {
	/* Immediate output flush to browser */
	ob_end_flush();
	flush();
	ob_start();
}

date_default_timezone_set("Asia/Kolkata");
$connect = mysqli_connect("localhost","root","","adityahightechnursery") or die("Error In Database Conection");;


if($connect){
	mysqli_set_charset($connect, 'utf8mb4');
	mysqli_query($connect, "SET time_zone = '+05:30'");
}
$qsArray = array_filter(explode('&', $_SERVER['QUERY_STRING']), function($el){
	return substr($el, 0, 6)!== 'logout';
});
$qs = implode('&', $qsArray);
$path = str_replace('index', '', str_replace('.php', '', $_SERVER['PHP_SELF']));
$url = $path.(!empty($qs) ? '?'.trim($qs) : ''); // active page url
$redirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : $url;
if(isset($_GET['logout'])){
	session_destroy();
	setcookie('id', '', time() - (86400 * 30), './');
	header("Location: ./login?redirect={$redirect}");
	exit();
}
// mysqli_real_escape_string
if (!function_exists('_escape')){
	function _escape($value, $htmlEscape=true){
		global $connect;
		$json = false;
		$stdClass = false;
		if ($value instanceof stdClass) {
			$stdClass = true;
			$value = (array) $value;
		} elseif (!is_array($value) && json_decode($value)){
		    $json = true;
		    $value = json_decode($value, true);
		}
		$esArray = array();
		if (is_array($value)){
		    foreach($value as $key => $val){
		    	if (is_array($val) || $val instanceof stdClass) {
		    		$esArray[$key] = _escape($val, $htmlEscape);
		    	} else {
		    		$esArray[$key] = ($val!==true && !empty($val)) ? ($htmlEscape ? mysqli_real_escape_string($connect, htmlentities($val)) : mysqli_real_escape_string($connect, $val)) : $val;
		    	}
		    }
		    if ($stdClass) {
		    	return (object) $esArray;
		    } elseif ($json) {
		    	return json_encode($esArray);
		    } else {
		    	return $esArray;
		    }
		}else{
		    return ($value!==true && !empty($value)) ? ($htmlEscape ? mysqli_real_escape_string($connect, htmlentities($value)) : mysqli_real_escape_string($connect, $value)) : $value;
		}
	}
}
// escape array (GET, POST, any) and returns new array
if (!function_exists('escape')){
	function escape($array){
		return array_map('_escape', $array);
	}
}
// escape array (GET, POST, any) and replaces original array
if (!function_exists('escapePOST')){
	function escapePOST(&$array){
		$array = array_map('_escape', $array);
	}
}
// escape array (GET, POST, any) and extract array
if (!function_exists('escapeExtract')){
	function escapeExtract($array){
		$escaped = escape($array);
		extract($escaped);
		foreach (array_keys($escaped) as $value) {
			$GLOBALS[$value] = $escaped[$value];
		}
	}
}
if (!function_exists('slugify')) {
    function slugify($string, $wordLimit=0, $separator="-") {
        $quoteSeparator = preg_quote($separator, '#');
        $replace = array(
            "[\&]"                      => "and",
            // "(\+{2})"                    => "pp",
            "&.+?;"                     => "",
            "[^\w\d _-]"                => "",
            "\s+"                       => $separator,
            "(".$quoteSeparator.")+"    => $separator,
        );
        $slug = strip_tags($string);
        foreach ($replace as $key => $value) {
            $slug = preg_replace('#'.$key.'#i', $value, $slug);
        }
        $slug = trim(trim(strtolower($slug), $separator));
        if ($wordLimit!=0) {
            $slug = implode($separator, array_slice(explode($separator, $slug), 0, $wordLimit));
        }
        return $slug; 
    }
}
function authUser() {
	global $connect;
	if (isset($_SESSION['id']) || isset($_COOKIE['id'])) {
		$id = isset($_SESSION['id']) ? $_SESSION['id'] : $_SESSION['id'] = $_COOKIE['id'];
		$getUser = mysqli_query($connect, "SELECT * FROM admin WHERE id = '{$id}'");
		if (mysqli_num_rows($getUser) > 0) {
			return (object) mysqli_fetch_assoc($getUser);
		}
	}
	return null;
}
$authUser = authUser();
if (!$authUser && pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) !== 'login') {
	header("Location: ./?logout=true&redirect={$redirect}");
	exit();
}
function pass_hash($password) {
	return hash('sha512', $password);
}
require_once 'helper.php';