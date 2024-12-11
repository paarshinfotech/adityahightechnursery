<?php //session_start(); 
require_once "config.php";

$qsArray = array_filter(explode('&', $_SERVER['QUERY_STRING']), function($el){
	return substr($el, 0, 6)!== 'logout';
});
$qs = implode('&', $qsArray);
$path = str_replace('index.php', '', str_replace('.php', '', $_SERVER['PHP_SELF']));
$url = $path.(!empty($qs) ? '?'.trim($qs) : ''); // active page url
$redirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : $url;

if(!isset($_SESSION['username']) && !isset($_SESSION['id']) && !isset($_SESSION['password'])){
 if (isset($_COOKIE['username']) && isset($_COOKIE['id']) && isset($_COOKIE['password'])){
  $_SESSION['username'] = $_COOKIE['username'];
  $_SESSION['id'] = $_COOKIE['id'];
  $_SESSION['password'] = $_COOKIE['password'];
 }else{
  header("Location: ./login?redirect={$redirect}");
  exit();
 }
}

/* logout */
if(isset($_GET['logout'])){
	session_destroy();
	setcookie('username', '', time() - (86400 * 30), './');
	setcookie('id', '', time() - (86400 * 30), './');
	setcookie('password', '', time() - (86400 * 30), './');
	header("Location: ./login?redirect={$redirect}");
	exit();
}
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Favicons -->
 <link rel="shortcut icon" href="logo/logo-512x512.png">
 <link rel="apple-touch-icon" sizes="180x180" href="logo/logo-512x512.png">
 <link rel="icon" type="image/png" sizes="32x32" href="logo/logo-512x512.png">
 <link rel="icon" type="image/png" sizes="16x16" href="logo/logo-512x512.png">
	<!--plugins-->
	
	<link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.13.1/af-2.5.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/date-1.2.0/fc-4.2.1/fh-3.3.1/kt-2.8.0/r-2.4.0/rg-1.3.0/rr-1.3.1/sc-2.0.7/sb-1.4.0/sp-2.1.0/sl-1.5.0/sr-1.2.0/datatables.min.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<link href="assets/css/flatpickr.min.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	
	<link rel="stylesheet" href="assets/css/photo.css" />
	<?php Aditya::PrintTitle() ?>
	<script>
		(function() {
			const theme = localStorage.getItem('theme') ?? 'light';
			$("html").attr('class', `${theme}-theme`);
			$(window).on('load', function() {
				$(`#${theme}mode`).attr('checked', true);
			});
		})();
	</script>
</head>
<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="logo/logo-512x512.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
				    <h6 class="logo-text text-green ms-2 fs-5">आदित्य नर्सरी</h6>
					<!--<h4 class="logo-text text-dark">आदित्य नर्सरी</h4>-->
				</div>
				<div class="toggle-icon ms-auto text-dark">
					<i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<!--<li>-->
				<!--	<a href="javascript:;" class="has-arrow">-->
				<!--		<div class="parent-icon"><i class='bx bx-home-circle'></i>-->
				<!--		</div>-->
				<!--		<div class="menu-title">Dashboard</div>-->
				<!--	</a>-->
				<!--	<ul>-->
				<!--		<li> <a href="index.html"><i class="bx bx-right-arrow-alt"></i>Default</a>-->
				<!--		</li>-->
				<!--		<li> <a href="index2.html"><i class="bx bx-right-arrow-alt"></i>Alternate</a>-->
				<!--		</li>-->
				<!--	</ul>-->
				<!--</li>-->
				
				<li>
					<a href="./">
						<div class="parent-icon"><i class="bx bx-home"></i>
						</div>
						<div class="menu-title">डॅशबोर्ड</div>
					</a>
				</li>
				<li>
					<a href="customer_list">
						<div class="parent-icon"><i class="bx bx-user-circle"></i>
						</div>
						<div class="menu-title">ग्राहक</div>
					</a>
				</li>
				<li>
					<a href="sales">
						<div class="parent-icon"> <i class="bx bx-trending-up"></i>
						</div>
						<div class="menu-title">विक्री</div>
					</a>
				</li>
				<li>
					<a href="outstanding_report">
						<div class="parent-icon"> <i class="bx bx-video-recording"></i>
						</div>
						<div class="menu-title">आउट स्टँडिंग रिपोर्ट्स</div>
					</a>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-bar-chart"></i>
						</div>
						<div class="menu-title">खातेवही व्यवस्थापन</div>
					</a>
					<ul>
						<li> <a href="product_category_list"  ><i class="bx bx-right-arrow-alt"></i>प्रॉडक्ट श्रेणी</a>
						</li>
						<li> <a href="zendu_cat_list"><i class="bx bx-right-arrow-alt"></i>झेंडू श्रेणी</a>
						</li>
						<li> <a href="zendu_subcat_list"><i class="bx bx-right-arrow-alt"></i>झेंडू उपवर्ग</a>
						</li>
						<li> <a href="letter_list"><i class="bx bx-right-arrow-alt"></i>लेटर पॅड</a>
						</li>
						<li> <a href="demo_bill"><i class="bx bx-right-arrow-alt"></i>डेमो बिल</a>
						</li>
						<li> <a href="demo_history"><i class="bx bx-right-arrow-alt"></i> डेमो इतिहास</a>
						</li>
						<li> <a href="expenses_category_list"><i class="bx bx-right-arrow-alt"></i>खर्च श्रेणी</a>
						</li>
						<li> <a href="carrental_category_list"><i class="bx bx-right-arrow-alt"></i>गाडी भाडे श्रेणी</a>
						</li>
						<li> <a href="seeds_category_list"><i class="bx bx-right-arrow-alt"></i>बियाणे आवक व जावक श्रेणी</a>
						</li>
						<li> <a href="jcb_category_list"><i class="bx bx-right-arrow-alt"></i>जेसीबी श्रेणी</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="expenses_category" >
						<div class="parent-icon"> <i class="bx bx-line-chart-down"></i>
						</div>
						<div class="menu-title">खर्च</div>
					</a>
				</li>
				
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="fa fa-users fs-5"></i>
						</div>
						<div class="menu-title">कर्मचारी</div>
					</a>
					<ul>
						<li> <a href="employee_list"><i class="bx bx-right-arrow-alt"></i>कर्मचारी</a>
						</li>
						<li> <a href="male_list"><i class="bx bx-right-arrow-alt"></i>पुरुष मजुरी महिना हजेरी</a>
						</li>
						<li> <a href="female_list"><i class="bx bx-right-arrow-alt"></i>महिला मजुरी हजेरी</a>
						</li>
						<li> <a href="pickup"><i class="bx bx-right-arrow-alt"></i>अडवान्स / उसने</a>
						</li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bxs-cart-alt"></i>
						</div>
						<div class="menu-title">इन्व्हेंटरी</div>
					</a>
					<ul>
						<li> <a href="oneday_list?date=<?= date('Y-m-d')?>"><i class="bx bx-right-arrow-alt"></i>एक दिवसीय आवक जावक</a>
						</li>
						<li> <a href="car_rental_category"><i class="bx bx-right-arrow-alt"></i>गाडी भाडे तपशील</a>
						</li>
						<li> <a href="zendu_booking_list"><i class="bx bx-right-arrow-alt"></i>झेंडू बुकिंग</a>
						</li>
						<!--<li> <a href="employee_list"><i class="bx bx-right-arrow-alt"></i>पुरुष मजुरी महिना हजेरी</a>-->
						<!--</li>-->
						<li> <a href="seeds_category"><i class="bx bx-right-arrow-alt"></i>बियाणे आवक व जावक रुपश्री सिड्स जालना</a>
						</li>
						<li> <a href="bhajipala_sales_list"><i class="bx bx-right-arrow-alt"></i>भाजी पाला बुकिंग</a>
						</li>
						<!--<li> <a href="employees_list"><i class="bx bx-right-arrow-alt"></i>महिला मजुरी हजेरी</a>-->
						<!--</li>-->
						<li> <a href="mobile_diary_list"><i class="bx bx-right-arrow-alt"></i>मोबाईल डायरी</a>
						</li>
						<li> <a href="all_loan_details_list"><i class="bx bx-right-arrow-alt"></i>सर्व उधारी तपशील</a>
						</li>
						<li> <a href="sal_car_list"><i class="bx bx-right-arrow-alt"></i>साल गाडी राजीटर</a>
						</li>
						<li> <a href="jcb_category"><i class="bx bx-right-arrow-alt"></i>जे.सी.बी. यादी</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="reports">
						<div class="parent-icon"> <i class="bx bxs-report"></i>
						</div>
						<div class="menu-title">रिपोर्ट्स</div>
					</a>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class="bx bx-recycle"></i>
						</div>
						<div class="menu-title">पुनर्संचयित करा</div>
					</a>
					<ul>
						<li> <a href="customer_restore"  ><i class="bx bx-user-circle"></i>ग्राहक पुनर्संचयित करा</a>
						</li>
        					 <li>
          					<a class="has-arrow" href="javascript:;">
          						<div class="parent-icon"><i class="bx bx-right-arrow-alt"></i>
          						</div>
          						<div class="menu-title">विक्री</div>
          					</a>
        				 	 <ul>
        						<li> <a href="product_category_restore"  ><i class="bx bx-right-arrow-alt"></i>प्रॉडक्ट श्रेणी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="product_restore"  ><i class="bx bx-right-arrow-alt"></i>प्रॉडक्टी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="supplier_restore"  ><i class="bx bx-right-arrow-alt"></i>सप्लायर पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="purchase_restore"  ><i class="bx bx-right-arrow-alt"></i>खरेदी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="sales_restore"  ><i class="bx bx-right-arrow-alt"></i>विक्री पुनर्संचयित करा</a>
        						</li>
        					</ul>
        				  </li>
        					 <li>
          					<a class="has-arrow" href="javascript:;">
          						<div class="parent-icon"><i class="bx bx-right-arrow-alt"></i>
          						</div>
          						<div class="menu-title">खातेवही व्यवस्थापन</div>
          					</a>
        				 	 <ul>
        				 	     <li> <a href="zendu_cat_restore"><i class="bx bx-right-arrow-alt"></i>झेंडू श्रेणी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="zendu_subcat_restore"><i class="bx bx-right-arrow-alt"></i>झेंडू उपवर्ग पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="letter_restore"><i class="bx bx-right-arrow-alt"></i>लेटर पॅड पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="demo_history_restore"><i class="bx bx-right-arrow-alt"></i>डेमो बिल पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="expenses_category_restore"  ><i class="bx bx-right-arrow-alt"></i>खर्च श्रेणी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="carrental_category_restore"  ><i class="bx bx-right-arrow-alt"></i>गाडी भाडे श्रेणी पुनर्संचयित करा</a>
        						</li>
        						<li> <a href="seeds_category_restore"><i class="bx bx-right-arrow-alt"></i>बियाणे आवक व जावक श्रेणी</a>
						        </li>
        						<li> <a href="jcb_category_restore"  ><i class="bx bx-right-arrow-alt"></i>जेसीबी श्रेणी पुनर्संचयित करा</a>
        						</li>
        						
        					</ul>
        				  </li>
        				  
				        <li> <a href="expenses_restore"  ><i class="bx bx-line-chart-down"></i>खर्च पुनर्संचयित करा</a>
						</li>
						<li> <a href="employee_restore"  ><i class="bx bx-user-circle"></i>कर्मचारी पुनर्संचयित करा</a>
						</li>
						<li>
          					<a class="has-arrow" href="javascript:;">
          						<div class="parent-icon"><i class="bx bxs-cart-alt"></i>
          						</div>
          						<div class="menu-title">इन्व्हेंटरी</div>
          					</a>
        				 	 <ul>
        				 	     <li>
  					<a class="has-arrow" href="javascript:;">
  						<div class="parent-icon"><i class="bx bx-right-arrow-alt"></i>
  						</div>
  						<div class="menu-title">एक दिवसीय आवक जावक</div>
  					</a>
				 	 <ul>
				 	     <li> <a href="inward_restore"><i class="bx bx-right-arrow-alt"></i>आवक पुनर्संचयित करा</a>
						 </li>
						 <li> <a href="expense_restore"><i class="bx bx-right-arrow-alt"></i>आवक मधून सर्व खर्च पुनर्संचयित करा</a>
						 </li>
				 	     <li> <a href="bank_restore"><i class="bx bx-right-arrow-alt"></i>बँक व्यवहार खर्च एमजीबीिंग पुनर्संचयित करा</a>
						</li>
						
					
						<li> <a href="cash_restore"><i class="bx bx-right-arrow-alt"></i>दादा व दशरथ हस्ते नगदी खर्च पुनर्संचयित करा</a>
						</li>
						<li> <a href="income_restore"><i class="bx bx-right-arrow-alt"></i>बँक आवक पुनर्संचयित करा</a>
						</li>
						<li> <a href="usna_restore"><i class="bx bx-right-arrow-alt"></i>उसना व्यवहार पुनर्संचयित करा</a>
						</li>
						
					</ul>
				  </li>
            			 	     <li> <a href="car_rental_restore"><i class="bx bx-right-arrow-alt"></i>गाडी भाडे तपशील पुनर्संचयित करा</a>
            					 </li>
            			 	     <li> <a href="zendu_booking_restore"><i class="bx bx-right-arrow-alt"></i>झेंडू बुकिंग पुनर्संचयित करा</a>
            					</li>
            					<li> <a href="seeds_restore"><i class="bx bx-right-arrow-alt"></i>बियाणे आवक व जावक श्रेणी पुनर्संचयित करा</a>
            					        </li>
            					<li> <a href="bhajipala_sales_restore"><i class="bx bx-right-arrow-alt"></i>भाजी पाला बुकिंग पुनर्संचयित करा</a>
            					</li>
            					<li> <a href="mobile_diary_restore"><i class="bx bx-right-arrow-alt"></i>मोबाइल डायरी पुनर्संचयित करा</a>
            					</li>
            					<li> <a href="all_loan_details_restore"><i class="bx bx-right-arrow-alt"></i>सर्व उधारी तपशील पुनर्संचयित करा</a>
            					</li>
            					<li> <a href="sal_car_restore"><i class="bx bx-right-arrow-alt"></i>साल गाडी राजीटर पुनर्संचयित करा</a>
            					</li>
            					<li> <a href="jcb_restore"><i class="bx bx-right-arrow-alt"></i>जे.सी.बी. पुनर्संचयित करा</a>
            					</li>
    					</ul>
				        </li>
				        
					</ul>
				</li>	
				
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					 <div class="search-bar flex-grow-1">
 						<div class="position-relative search-bar-box">
 						    <!--<form method="post">-->
 							   <!-- <input type="text" class="form-control search-control" name="search_text" id="search_text" placeholder="Type to search..."> -->
 							   <!-- <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>-->
 							   <!-- <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>-->
 						    <!--</form>-->
 						    <div class="result"></div>
 						</div>
					 </div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#" >
									<i class='bx bx-search'></i>
								</a>
							</li>
							<?php //if ($authUser->role==='admin'): ?>
							<!--<li class="nav-item">-->
							<!--	<a class="nav-link" href="user_action_log">-->
							<!--		<i class='bx bx-book-reader' data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="User Action Log" data-bs-original-title="User Action Log"></i>-->
							<!--	</a>-->
							<!--</li>-->
							<?php //endif ?>
							<li class="nav-item">
							</li>
							<li class="nav-item dropdown dropdown-large">
								<button class="nav-link btn btn-sm position-relative" data-bs-toggle="dropdown">
									<span class="notify-counter alert-count">0</span>
									<i class="bx bx-bell" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="नोटीफिकेशन"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="border-bottom px-3 py-2 fw-bold text-center">नोटीफिकेशन</div>
									<div class="notifications-list" style="max-height: 400px;overflow-y: auto;"></div>
									<div class="header-notifications-list d-none"></div>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link link-dark dropdown-toggle dropdown-toggle-nocaret" href="login" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						 <img src="image/<?= !empty($authUser->profile_photo) ? $authUser->profile_photo : 'no_img.jpg' ?>" class="user-img shadow-sm" loading="lazy">
							<div class="user-info ps-3">
								<div><h6 class="fs-6"><?= $authUser->full_name ?></<h6></div>
								<h6 class="small text-muted page-header-title"><?= $authUser->username ?></h6>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li>
							 	<a class="dropdown-item" href="profile">
							 		<i class="bx bx-user"></i>
							 		<span>प्रोफाईल</span>
							 	</a>
							</li>
							<li>
								<a class="dropdown-item text-danger" href="?logout=true&redirect=<?= $url ?>">
									<i class="bx bx-log-out-circle"></i>
									<span>बाहेर पडा</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
<script>
// $(document).ready(function(){
//     load_data();
//     function load_data(query)
//     {
//         // var query =$(this).val();
//         $.ajax({
//             url:"search.php",
//             method:"post",
//             data:{query:query},
//             success:function(data)
//             {
//                 $('.result').html(data);
//             }
//         });
//     }
    
//     $('#search_text').keyup(function(){
//         var search = $(this).val();
//         if(search != '')
//         {
//             load_data(search);
//         }
//         else
//         {
//             load_data();            
//         }
//     });
// });

// $(document).ready(function(){
//     load_data();
//     function load_data(query)
//     {
//         // var query =$(this).val();
//         $.ajax({
//             url:"search.php",
//             method:"post",
//             data:{pro:pro},
//             success:function(data)
//             {
//                 $('.result').html(data);
//             }
//         });
//     }
    
//     $('#search_text').keyup(function(){
//         var search = $(this).val();
//         if(search != '')
//         {
//             load_data(search);
//         }
//         else
//         {
//             load_data();            
//         }
//     });
// });
</script>