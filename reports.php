<?php
require_once "config.php";
Aditya::subtitle(translate('reports'));
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		        <div class="row align-items-center">
            <div class="col">
                <h5 class="page-header-title mb-2"><?= translate('reports') ?></h5>
                <hr>
            </div>
        </div>
        <div class="row g-3">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4"><?//= translate('sales') ?>विक्री</span>
                        <span>
                            <i class="rupee fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="sales-all"><div><?//= translate('all_sales') ?>सर्व विक्री</div></a>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="sales-paid"><div><?//= translate('paid_sales') ?>पैसे मिळालेली विक्री</div></a>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="sales-unpaid"><div><?//= translate('unpaid_sales') ?>उधारी विक्री</div></a>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="sales-products"><div>उत्पादनानुसार विक्री</div></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
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
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="purchase-all"><div>सर्व खरेदी</div></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
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
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="expenses-all"><div>सर्व खर्च</div></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-4">बुकिंग्स</span>
                        <span>
                            <i class="bx bx-purchase-tag fs-4"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="zendu-bookings-all"><div>झेंडू बुकिंग</div></a>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="bhajipala-booking-all"><div>भाजी पाला बुकिंग</div></a>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <a class="text-green" href="seeds-booking-all"><div>बियाणे सिड्स बुकिंग</div></a>
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