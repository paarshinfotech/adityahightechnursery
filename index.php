<><>

<?php
require_once "config.php";
Aditya::subtitle(translate('डॅशबोड'));
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
} elseif (isset($_GET['show_purchase'])) {
	$nav_tabs['purchase'] = true;
} elseif (isset($_GET['show_supplier'])) {
	$nav_tabs['supplier'] = true;
} elseif (isset($_GET['show_history'])) {
	$nav_tabs['sale_history'] = true;
} else {
	$nav_tabs['sales'] = true;
}
//yearly revenue
$getyear=mysqli_query($connect,"SELECT  COUNT(*) total,SUM(total+car_rental_amt) as totyear FROM `sales` WHERE YEAR(sdate) = YEAR(NOW()) AND sales_status='1' AND demo_status='1'");
$tyear=mysqli_fetch_assoc($getyear);

//monthly revenue
$getmonth=mysqli_query($connect,"SELECT  COUNT(*) total,SUM(total+car_rental_amt) as totmonth FROM `sales` WHERE YEAR(sdate) = YEAR(NOW()) AND MONTH(sdate) = MONTH(NOW()) AND sales_status='1' AND demo_status='1'");
$tmon=mysqli_fetch_assoc($getmonth);

//today's revenue
$getrev=mysqli_query($connect,"SELECT COUNT(*) total,SUM(total+car_rental_amt) earning FROM `sales` WHERE DATE(sdate) = DATE(NOW()) AND sales_status='1' AND demo_status='1'");
$trev=mysqli_fetch_assoc($getrev);

//yearly purchase
$getPuryear=mysqli_query($connect,"SELECT SUM(purchase_price) as purTotYear FROM `purchase` WHERE YEAR(purchase_created) = YEAR(NOW()) AND purchase_status='1'");
$totpuryear=mysqli_fetch_assoc($getPuryear);

//monthly purchase
$getmonthPur=mysqli_query($connect,"SELECT SUM(purchase_price) as totmonth FROM `purchase` WHERE YEAR(purchase_created) = YEAR(NOW()) AND MONTH(purchase_created) = MONTH(NOW()) AND purchase_status='1'");
$totPurmonth=mysqli_fetch_assoc($getmonthPur);

//daily purchase
$getTodayspur=mysqli_query($connect,"SELECT SUM(purchase_price) earning FROM `purchase` WHERE DATE(purchase_created) = DATE(NOW()) AND purchase_status='1'");
$totTodaypur=mysqli_fetch_assoc($getTodayspur);

//getyearlyEx
$getYearEx=mysqli_query($connect,"SELECT SUM(ex_amt) as totYearEx FROM `expenses` WHERE YEAR(ex_date) = YEAR(NOW()) AND ex_status='1'");
$totYearEx=mysqli_fetch_assoc($getYearEx);

//getmonthEx
$getMonth=mysqli_query($connect,"SELECT SUM(ex_amt) as totmonth FROM `expenses` WHERE YEAR(ex_date) = YEAR(NOW()) AND MONTH(ex_date) = MONTH(NOW()) AND ex_status='1' ");
$totMonEx=mysqli_fetch_assoc($getMonth);

//gettodaysEx
$getTodayEx=mysqli_query($connect,"SELECT SUM(ex_amt) totTodayEx FROM `expenses` WHERE DATE(ex_date) = DATE(NOW()) AND ex_status='1'");
$totTodayEx=mysqli_fetch_assoc($getTodayEx);

//zendubookingYearly
$getzin=mysqli_query($connect,"SELECT SUM(total_amount) as totzenduYear FROM `zendu_booking` where YEAR(booking_date) = YEAR(NOW()) AND zb_status='1'");
$tzin=mysqli_fetch_assoc($getzin);

//zendubookingMonthly
$getZenduMon=mysqli_query($connect,"SELECT SUM(total_amount) as totmonth FROM `zendu_booking` where YEAR(booking_date) = YEAR(NOW()) AND MONTH(booking_date) = MONTH(NOW()) AND zb_status='1'");
$totmonthly=mysqli_fetch_assoc($getZenduMon);

//zenduBookingToday
$getZenToday=mysqli_query($connect,"SELECT SUM(total_amount) totTodayzendu FROM `zendu_booking` WHERE DATE(booking_date) = DATE(NOW()) and zb_status='1'");
$totzenduToday=mysqli_fetch_assoc($getZenToday);

//bhajipalaYearly
$getBhajipala=mysqli_query($connect,"SELECT SUM(total) as totYearBhaji FROM `bhajipala_sales` where YEAR(sdate) = YEAR(NOW()) AND is_not_delete='1'");
$totBhajiYear=mysqli_fetch_assoc($getBhajipala);

//bhajipalaMonthly
$getBhajiMonth=mysqli_query($connect,"SELECT SUM(total) as totmonth FROM `bhajipala_sales` where YEAR(sdate) = YEAR(NOW()) AND MONTH(sdate) = MONTH(NOW()) AND is_not_delete='1'");
$totBhajimonth=mysqli_fetch_assoc($getBhajiMonth);

//bhajipalaTodays
$getbhajipala=mysqli_query($connect,"SELECT SUM(total) totBhajiToday FROM `bhajipala_sales` WHERE DATE(sdate) = DATE(NOW()) and is_not_delete='1'");
$totBhajiToday=mysqli_fetch_assoc($getbhajipala);

//seedsYeraly
$getSeedsyear=mysqli_query($connect,"SELECT SUM(total) as totYearseeds FROM `seeds_sales` where  YEAR(sdate) = YEAR(NOW()) AND seeds_status='1'");
$totSeedsYear=mysqli_fetch_assoc($getSeedsyear);

//seedsMonthly
$getseedsMonthly=mysqli_query($connect,"SELECT SUM(total) as totmonth FROM `seeds_sales` where  YEAR(sdate) = YEAR(NOW()) AND MONTH(sdate) = MONTH(NOW()) AND seeds_status='1'");
$totseedsmon=mysqli_fetch_assoc($getseedsMonthly);

//seedsTodays
$getseedstoday=mysqli_query($connect,"SELECT SUM(total) as totseedsToday FROM `seeds_sales` WHERE DATE(sdate) = DATE(NOW()) and seeds_status='1'");
$totseedsToday=mysqli_fetch_assoc($getseedstoday);

//carrentalYearly
$getCarRentalYear=mysqli_query($connect,"SELECT SUM(car_rental) as totCarYear FROM `car_rental` where YEAR(cdate) = YEAR(NOW()) AND car_status='1'");
$totCarRentalYear=mysqli_fetch_assoc($getCarRentalYear);

//carRetalMontly
$getCarRentalm=mysqli_query($connect,"SELECT SUM(car_rental) as totmonthcar FROM `car_rental` where YEAR(cdate) = YEAR(NOW()) AND MONTH(cdate) = MONTH(NOW()) AND car_status='1'");
$totCarRentalm=mysqli_fetch_assoc($getCarRentalm);

//carRetaltoday
$getCarToday=mysqli_query($connect,"SELECT SUM(car_rental) totCarToday FROM `car_rental` WHERE DATE(cdate) = DATE(NOW()) and car_status='1'");
$totCarToday=mysqli_fetch_assoc($getCarToday);


//getCustomers
$getcus=mysqli_query($connect,"SELECT COUNT('customer_id') AS totcus FROM customer where customer_status='1'");
$tcus=mysqli_fetch_assoc($getcus);

//getProduct
$getpro=mysqli_query($connect,"SELECT COUNT('product_id') AS totpro FROM product where product_status='1'");
$tpro=mysqli_fetch_assoc($getpro);

//getBills
$getpro=mysqli_query($connect,"SELECT COUNT('sale_id') AS totorders FROM sales WHERE sales_status='1' AND demo_status='1'");
$torder=mysqli_fetch_assoc($getpro);

//get employees
$getemp=mysqli_query($connect,"SELECT COUNT(emp_id) totemp FROM `employees` where emp_status='1'");
$temp=mysqli_fetch_assoc($getemp);

//get Supplier
$getsupplier=mysqli_query($connect,"SELECT COUNT(supplier_id) totsupp FROM `supplier` WHERE sup_status='1'");
$tsup=mysqli_fetch_assoc($getsupplier);

//getOutStanding Report
$getOutstanding=mysqli_query($connect,"SELECT COUNT(sale_id) as outReport FROM `sales` WHERE balance!='0' AND sales_status='1' AND demo_status='1'");
$totOutReport=mysqli_fetch_assoc($getOutstanding);

require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		        <div class="row align-items-center">
            <div class="col">
                <h5 class="page-header-title mb-2"><?= translate('डॅशबोड') ?></h5>
                <hr>
            </div>
        </div>
        <div class="row g-3">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">महसूल</span>
                        <span>
                            <i class="rupee fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण महसूल</span>-->
                        <!--        <span class="rupee-after text-green fw-bold">-->
                        <!--            <?php // error_reporting(0) ?>-->
                        <!--            <?//= $tyear['totyear'] + $tmon['totmonth'] + $trev['earning'] ?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक महसूल</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $tyear['totyear']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक महसूल</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $tmon['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक महसूल</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $trev['earning']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
             <a href="sales" class="stretched-link">
                <div class="card">
                    <div class="card-header bg-light text-primary py-2">
                   <div class="card-title d-flex justify-content-between align-items-center">
                         <span class="fs-4">विक्री</span>
                        <span>
                            <i class='rupee fs-4'></i>
                        </span>
                        
                    </div>
                
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण विक्री</span>-->
                        <!--        <?php //error_reporting(0)?>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $tyear['totyear'] + $tmon['totmonth'] + $trev['earning'] ?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक विक्री</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $tyear['totyear']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक विक्री</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $tmon['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक विक्री</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $trev['earning']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
             </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
            <a href="sales?show_purchase=true" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">खरेदी</span>
                        <span>
                            <i class='bx bxs-cart-add fs-4'></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण खरेदी</span>-->
                       <?php 
                                //error_reporting(0);
                        //    $TotalPurchase = $totpuryear['purTotYear'] + $totPurmonth['totmonth'] + $totTodaypur['earning'];?>
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $TotalPurchase ?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक खरेदी</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totpuryear['purTotYear']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक खरेदी</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totPurmonth['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक खरेदी</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totTodaypur['earning']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
             </a>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4 position-relative">
            <a href="expenses_category" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">खर्च</span>
                        <span>
                            <i class='rupee fs-4'></i>                        
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण खर्च</span>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $totYearEx['totYearEx'] + $totMonEx['totmonth'] + $totTodayEx['totTodayEx']?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक खर्च</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totYearEx['totYearEx']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक खर्च</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totMonEx['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक खर्च</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totTodayEx['totTodayEx']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
            <a href="zendu_booking_list" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">झेंडू बुकिंग</span>
                        <span>
                            <i class="bx bx-purchase-tag fs-4"></i>                        
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण झेंडू बुकिंग</span>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $tzin['totzenduYear'] + $totmonthly['totmonth'] + $totzenduToday['totTodayzendu']?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक झेंडू बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $tzin['totzenduYear']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक झेंडू बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totmonthly['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक झेंडू बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totzenduToday['totTodayzendu']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
             <a href="bhajipala_sales_list" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">भाजी पाला बुकिंग</span>
                        <span>
                            <i class="bx bx-purchase-tag fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण भाजी पाला बुकिंग</span>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $totBhajiYear['totYearBhaji'] + $totBhajimonth['totmonth'] + $totBhajiToday['totBhajiToday']?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक भाजी पाला बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totBhajiYear['totYearBhaji']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक भाजी पाला बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totBhajimonth['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक भाजी पाला बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totBhajiToday['totBhajiToday']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
             </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
            <a href="seeds_category" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">बियाणे सिड्स बुकिंग</span>
                        <span>
                            <i class="bx bx-purchase-tag fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण बियाणे सिड्स बुकिंग</span>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $totSeedsYear['totYearseeds'] + $totseedsmon['totmonth'] + $totseedsToday['totseedsToday']?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक बियाणे सिड्स बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totSeedsYear['totYearseeds']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक बियाणे सिड्स बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totseedsmon['totmonth']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक बियाणे सिड्स बुकिंग</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totseedsToday['totseedsToday']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4 position-relative">
            <a href="car_rental_category" class="stretched-link">
                <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">गाडी भाडे </span>
                        <span>
                            <i class="bx bx-purchase-tag fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <!--<li class="list-group-item px-0 py-2 text-green">-->
                        <!--    <div class="d-flex justify-content-between">-->
                        <!--        <span>एकूण गाडी भाडे</span>-->
                        <!--        <span class="rupee-after text-green fw-bold"><?//= $totCarRentalYear['totCarYear'] + $totCarRentalm['totmonthcar'] + $totCarToday['totCarToday']?></span>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>वार्षिक गाडी भाडे</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totCarRentalYear['totCarYear']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>मासिक गाडी भाडे</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totCarRentalm['totmonthcar']) ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <div class="d-flex justify-content-between">
                                <span>दैनिक गाडी भाडे</span>
                                <span class="rupee-after text-green fw-bold"><?= sprintf('%0.2f', $totCarToday['totCarToday']) ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            </a>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">इतर तपशील</span>
                        <span>
                            <i class="bx bxs-report fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="customer_list">
                                <div class="d-flex justify-content-between">
                                    <span>एकूण ग्राहक</span>
                                    <span class="text-green fw-bold"><?= $tcus['totcus']?></span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="sales?show_products=true">
                                <div class="d-flex justify-content-between">
                                    <span>एकूण प्रॉडक्ट</span>
                                    <span class="text-green fw-bold"><?= $tpro['totpro']?></span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="sales?show_history=true">
                                <div class="d-flex justify-content-between">
                                <span>एकूण बिल</span>
                                <span class="text-green fw-bold"><?= $torder['totorders']?></span>
                            </div>
                            </a>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="employee_list">
                                <div class="d-flex justify-content-between">
                                    <span>एकूण कर्मचारी </span>
                                    <span class="text-green fw-bold"><?= $temp['totemp']?></span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="sales?show_supplier=true">
                                <div class="d-flex justify-content-between">
                                    <span>एकूण पुरवठादार</span>
                                    <span class="text-green fw-bold"><?= $tsup['totsupp']?></span>
                                </div>
                            </a>
                        </li>
                        <li class="list-group-item px-0 py-2 text-green">
                            <a class="text-green" href="outstanding_report">
                                <div class="d-flex justify-content-between">
                                    <span>एकूण आउट स्टँडिंग रिपोर्ट्स</span>
                                    <span class="text-green fw-bold"><?= $totOutReport['outReport']?></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
			</div>
			
		</div>
		<!--end page wrapper -->
		
<?php include "footer.php"; ?>