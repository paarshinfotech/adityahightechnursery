<?php //session_start(); 
require_once "config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if (isset($_POST['save'])){
    escapeExtract($_POST);
    $insert= "INSERT INTO letter_pad(letters,far_name,idate,village,mob_no) VALUES ('$letters','$far_name','$idate','$village','$mob_no')";
    $add=mysqli_query($connect,$insert);
    if($add){
    // header('Location: customer_list?action=Success&action_msg=Customer Added');
    header('Location: letter_list?action=Success&action_msg= '.$far_name.' नवीन लेटर पॅड जोडले..!');
		exit();
        }else{
        header('Location: letter_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

if (isset($_POST['edit'])){
    escapeExtract($_POST);
    $editletters=mysqli_query($connect,"UPDATE letter_pad SET 
    letters='$letters',
    far_name='$far_name',
    idate='$idate',
    village='$village',
    mob_no='$mob_no'
    WHERE lid='{$_GET['lid']}'");
    if($editletters){
    header('Location: letter_list?action=Success&action_msg= '.$far_name.' लेटर पॅड अपडेट केले..!');
		exit();
        }else{
        header('Location: letter_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="shortcut icon" href="logo/logo-512x512.png">
 <link rel="apple-touch-icon" sizes="180x180" href="logo/logo-512x512.png">
 <link rel="icon" type="image/png" sizes="32x32" href="logo/logo-512x512.png">
 <link rel="icon" type="image/png" sizes="16x16" href="logo/logo-512x512.png">
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<!--<link rel="stylesheet" href="assets/css/semi-dark.css" />-->
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<title>आदित्य नर्सरी | लेटर पॅड</title>
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
						<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>लेटर पॅड</a>
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
						<div class="menu-title">इन्व्हेंटोरी</div>
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
          						<div class="menu-title">इन्व्हेंटोरी</div>
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
 							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
 							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
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
						
							<li class="nav-item dropdown dropdown-large">
								<div class="dropdown-menu dropdown-menu-end">
									<div class="header-notifications-list">
									</div>
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
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<!--<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">-->
				<!--	<div class="breadcrumb-title pe-3">Forms</div>-->
				<!--	<div class="ps-3">-->
				<!--		<nav aria-label="breadcrumb">-->
				<!--			<ol class="breadcrumb mb-0 p-0">-->
				<!--				<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>-->
				<!--				</li>-->
				<!--				<li class="breadcrumb-item active" aria-current="page">Text Editor</li>-->
				<!--			</ol>-->
				<!--		</nav>-->
				<!--	</div>-->
				<!--	<div class="ms-auto">-->
				<!--		<div class="btn-group">-->
				<!--			<button type="button" class="btn btn-primary">Settings</button>-->
				<!--			<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>-->
				<!--			</button>-->
				<!--			<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>-->
				<!--				<a class="dropdown-item" href="javascript:;">Another action</a>-->
				<!--				<a class="dropdown-item" href="javascript:;">Something else here</a>-->
				<!--				<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	</div>-->
				<!--</div>-->
				<!--end breadcrumb-->
				<div class="card">
					<div class="card-body">
					    <?php
                                if(isset($_GET['lid'])){
                                $getletter=mysqli_query($connect,"SELECT * FROM letter_pad WHERE lid='{$_GET['lid']}'");
                                $resletter=mysqli_fetch_assoc($getletter);
                                extract($resletter);
                                ?>
					    <div class="d-flex bd-highlight">
                          <div class="text-uppercase flex-grow-1 bd-highlight fs-4">आदित्य हायटेक नर्सरी</div>
                          <div class="bd-highlight"><a href="letter_list" class="btn btn-dark float-end mt-2 me-2">मागे</a></div>
                          <div class="bd-highlight">
                              <button class="btn btn-dark float-end mt-2 me-2" form="letter_pad" type="submit" name="edit">जतन करा</button></h6>
                          </div>
                        </div>
                        <hr>
						<!--<h6 class="">आदित्य हायटेक नर्सरी-->
						
						<!--<hr/>-->
						<!--<h4 class="mb-4">TinyMCE Quick Start Guide</h4>-->
						
						<form method="post" id="letter_pad">
							<textarea id="mytextarea" name="letters" placeholder="येथे मजकूर प्रविष्ट करा...!"><?= $letters?></textarea>
						    
						    <!--<div class="row mt-3">-->
          <!--                              <div class="col-12 col-lg-6">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="far_name" class="form-control" placeholder="नाव प्रविष्ट करा" value=<?= $far_name?>>-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="village" value="<?= $village?>" class="form-control" placeholder="गाव प्रविष्ट करा">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6 mt-3">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="mob_no" value="<?= $mob_no?>" class="form-control" maxlength="10" oninput="allowType(event,'mobile')" minlength="10" placeholder="मोबाईल प्रविष्ट कर">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6 mt-3">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="date" name="idate" class="form-control" value="<?= date('Y-m-d')?>">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                          </div>-->
						</form>
						<?php } else {?>
						<div class="d-flex bd-highlight">
                          <div class="text-uppercase flex-grow-1 bd-highlight fs-4">आदित्य हायटेक नर्सरी</div>
                          <div class="bd-highlight"><a href="letter_list" class="btn btn-dark float-end mt-2 me-2">मागे</a></div>
                          <div class="bd-highlight">
                              <button class="btn btn-dark float-end mt-2 me-2" form="letter_pad" type="submit" name="save">जतन करा</button></h6>
                          </div>
                        </div>
                        <hr>
						<form method="post" id="letter_pad">
							<textarea id="mytextarea" name="letters" placeholder="येथे मजकूर प्रविष्ट करा...!"></textarea>
						    
						    <!--<div class="row mt-3">-->
          <!--                              <div class="col-12 col-lg-6">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="far_name" class="form-control" placeholder="नाव प्रविष्ट करा">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="village" class="form-control" placeholder="गाव प्रविष्ट करा">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6 mt-3">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="text" name="mob_no" class="form-control" maxlength="10" oninput="allowType(event,'mobile')" minlength="10" placeholder="मोबाईल प्रविष्ट कर">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                              <div class="col-12 col-lg-6 mt-3">-->
          <!--                                  <div class="form-group">-->
          <!--                                      <input type="date" name="idate" class="form-control" value="<?= date('Y-m-d')?>">-->
          <!--                                  </div>-->
          <!--                              </div>-->
          <!--                          </div>-->
						</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © <?= date('Y')?> आदित्य नर्सरी द्वारे  <a href="/" target="_blank" class="text-muted fw-bold">पार्ष इन्फोटेक प्रा. ली</a>.</p>
		</footer>
	</div>
	<div class="switcher-wrapper my-auto">
		<div class="switcher-btn"> <i class='bx bx-sun bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Change Themes</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr/>
			<div class="d-flex align-items-center justify-content-around">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode">
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<!--<div class="form-check">-->
				<!--	<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark" checked>-->
				<!--	<label class="form-check-label" for="semidark">Semi Dark</label>-->
				<!--</div>-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin">
	</script>
	<script>
		tinymce.init({
		  selector: '#mytextarea'
		});
	</script>
	<script>
	    function allowType(e, o = 'number', l = false, c=false) {
	let val = e.target.value;
	const devn = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
	switch (o) {
		case 'alfanum':
			if (l) {
				val = val.substr(0, l).replaceAll(/[^0-9a-zA-Z]/gmi, '');
			} else {
				val = val.replaceAll(/[^0-9a-zA-Z]/gmi, '');
			}
			break;
		case 'number':
			devn.forEach(dn => {
				val = val.replaceAll(dn, devn.indexOf(dn));
			});
			if (l) {
				val = val.substr(0, l).replaceAll(/[^0-9]/gmi, '');
			} else {
				val = val.replaceAll(/[^0-9]/gmi, '');
			}
			break;
		case 'mobile':
			devn.forEach(dn => {
				val = val.replaceAll(dn, devn.indexOf(dn));
			});
			val = val.replaceAll(/[^0-9]/gmi, '');
			val = val.substr(0, 10);
			if (!val.charAt(0).match(/[6-9]/)) {
				val = val.substr(1);
			}
			break;
		case 'decimal':
			devn.forEach(dn => {
				val = val.replaceAll(dn, devn.indexOf(dn));
			});
			let i = val.search(/\./gmi);
			if (val.length === 1) {
				val = val.replaceAll(/[^0-9]/gmi, '');
			}
			if (i >= 0) {
				if (l) {
					val = val.substr(0, i + 1) + val.substr(i).substr(0, l + 1).replaceAll(/\./gmi, '');
				} else {
					val = val.substr(0, i + 1) + val.substr(i).replaceAll(/\./gmi, '');
				}
			}
			val = val.replaceAll(/[^0-9.]/gmi, '');
			break;
	}
	if (c=='upper') {
		val = val.toUpperCase();
	} else if (c=='lower') {
		val = val.toLowerCase();
	} else if (c=='title') {
		val = val.toTitleCase();
	}
	e.target.value = val;
}		
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>

</html>