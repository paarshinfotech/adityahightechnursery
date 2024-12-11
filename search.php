<?php
require_once "config.php";
$nav_tabs = array(
	'sales' => false,
	'products' => false,
	'purchase' => false,
	'supplier' => false,
	'sale_history' => false,
	'cus_details' => false,
);
if (isset($_GET['show_sales'])) {
	$nav_tabs['sales'] = true;
} elseif (isset($_GET['show_products'])) {
	$nav_tabs['products'] = true;
// } elseif (isset($_GET['show_purchase'])) {
// 	$nav_tabs['purchase'] = true;
// } elseif (isset($_GET['show_supplier'])) {
// 	$nav_tabs['supplier'] = true;
// } elseif (isset($_GET['show_history'])) {
// 	$nav_tabs['sale_history'] = true;
// } else {
// 	$nav_tabs['sales'] = true;
// }
}
if(isset($_POST["query"])){
    $search = mysqli_real_escape_string($connect, $_POST["query"]);
    $querycus=mysqli_query($connect,"select * from customer where 
    (customer_mobno LIKE '%".$search."%' OR customer_name LIKE '%".$search."%')"); }
if($querycus){
    echo "<script>";
    echo "window.location.href='customer_list';";
    echo "</script>";
} 

if(isset($_POST["pro"])){
    $search = mysqli_real_escape_string($connect, $_POST["pro"]);
    $queryPro=mysqli_query($connect,"select * from product where 
    (product_id LIKE '%".$search."%' OR product_name LIKE '%".$search."%') order by product_id desc"); }
if($queryPro){
    echo "<script>";
    echo "window.location.href='sales?show_products=true';";
    echo "</script>";
} 