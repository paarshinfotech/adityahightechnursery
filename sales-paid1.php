<?php
require_once "config.php";
Aditya::subtitle('पैसे मिळालेली विक्री');

$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('d-m-Y');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('d-m-Y', strtotime("{$from} + 1 day"));

require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			    <h4 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class='bx bx-left-arrow-circle'></i></a>
					<span>पैसे मिळालेली विक्री</span>
				</h4>
			    <div class="card">
			        <div class="card-body">
			          <div class="d-flex mb-3">
                        <div class="ms-auto p-2 d-flex export-container">
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#reportsDateRangeModal">
                              कालावधी
                            <i class="bx bx-calendar-week"></i></button>
                            <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>
                         <!--Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="customer-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">ग्राहक ने फिल्टर करा</label>
                                                <select class="form-select" id="sales-cus-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">पेमेंट मोड ने फिल्टर करा </label>
                                                <select class="form-select" id="pay-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">पेमेंट स्टेटस ने फिल्टर करा</label>
                                                <select class="form-select" id="paystatus-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                           
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(cusListTbl, '#customer-filters-form')">सर्व फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">बंद करा</button>
                                        <button type="submit" form="customer-filters-form" class="btn btn-dark">फिल्टर लागू करा</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                </div>
                    </div>
        				 <div class="table-responsive">
					<table border="1" id="salesAllTbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <!--<div class="d-inline-flex align-items-center select-all">-->
								    <!--    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">-->
			         <!--                   <div class="dropdown">-->
			         <!--                   	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">-->
			         <!--                   		<i class='bx bx-slider-alt fs-6'></i>-->
			         <!--                   	</button>-->
			         <!--                   	<ul class="dropdown-menu" aria-labelledby="category-action">-->
			         <!--                   		<li>-->
			         <!--                   			<a title="झेंडू बुकिंग हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('झेंडू  बुकिंग हटवा..?');">-->
			         <!--                   				<i class="btn-round bx bx-trash me-2"></i>झेंडू बुकिंग हटवा-->
			         <!--                   			</a>-->
			         <!--                   		</li>-->
			         <!--                   	</ul>-->
			         <!--                   </div>-->
								    <!--</div>-->
									<?php //endif ?>
								 बिल नं.
									<?php //endif ?>
								</th>
    								<th>बिलिंग दिनांक</th>
                                    <th>ग्राहकाचे नाव</th
                                    >
									<th>एकूण</th>
									<th>ऍडव्हान्स</th>
									<th>शिल्लक</th>
									<th>पेमेंट मोड</th>
									<th>पेमेंट स्टेटस </th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and s.sales_status='1' and demo_status='1' AND paystatus='paid' AND s.sdate >= '{$from}' AND s.sdate < '{$to}' order by s.sale_id DESC") ?>
                            <?php if (mysqli_num_rows($getsalesDetails)>0): ?>
                                <?php 
                                $salesDetails = array();
                                while ($salesFetch = mysqli_fetch_assoc($getsalesDetails)): 
                                array_push($salesDetails, $salesFetch);
                                extract($salesFetch);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <!--<input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?//= $sale_id ?>">-->
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <td>
						        						<span> <?php $date=date('d M Y',strtotime($sdate))?>
                                            <?= $date?></span>
						        					</td>
                                <td>
                                    <?= $customer_name; ?>
                                </td>
                                <td class="text-end">
															    <?php if($car_rental_amt==''){?>
															    <?= $total?>
															    <?php }else {?>
																<?= $car_rental_amt + $total?>
																<?php } ?>
															</td>
								<td class="text-end">
									<?= $advance?>
								</td>
								<td class="text-end">
									<?= $balance?>
								</td>
								<td>
									<?= translate($pay_mode)?>
								</td>
								<td>
									<?= translate($paystatus)?>
								</td>
                                
                                </tr>
                                <?php 
                                error_reporting(0);
                                // if($car_rental_amt=='NULL' && $total=='NULL' && $advance=='NULL' && $balance=='NULL'){
                                $totSaleAmt += $car_rental_amt + $total;
                                $totAdv += $advance;
                                $totBal += $balance;
                                ?>
                                
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
                        <?php error_reporting(0);?>
						<tfoot>
				            <tr>
        					    <th colspan="3">एकूण</th>
        					    <th class="rupee-after text-end">
        					        <?= $totSaleAmt; ?>
        					    </th>
            					<th class="rupee-after text-end"> 
            					    <?= $totAdv; ?>
            					</th>
            					<th class="rupee-after text-end"><?= $totBal; ?></th>
				                </tr>
			            </tfoot>
					</table>
				</div>
        				<div class="reports-table-footer"></div>
			        </div>
			    </div>
		    </div>
		</div>
		<div class="modal fade" id="reportsDateRangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reportsDateRangeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-body">
				<form id="date-range-form" class="row g-3 mt-0">
					<div class="col-12">
						<input type="hidden" name="show" value="sales-all">
						<label class="form-label">कालावधी</label>
						<select class="form-select form-select-sm" id="report-date-range" onchange="rangeSelect(this.value)">
							<option value="">कालावधी निवडा</option>
							<option value="today"><?= translate('today') ?></option>
							<option value="yesterday"><?= translate('yesterday') ?></option>
							<option value="last_7_days"><?= sprintf(translate('last_n_days'), 7) ?></option>
							<option value="last_30_days"><?= sprintf(translate('last_n_days'), 30) ?></option>
							<option value="last_90_days"><?= sprintf(translate('last_n_days'), 90) ?></option>
							<option value="last_month"><?= translate('last_month') ?></option>
							<option value="last_year"><?= translate('last_year') ?></option>
							<option value="all">सर्व</option>
						</select>
					</div>
					<div class="col-6">
						<label for="" class="form-label">तारखे पासून</label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="date" name="date-from" class="form-control js-flatpickr" value="<?= date('Y-m-d') ?>" >
							<!--data-hs-flatpickr-options='{"dateFormat": "d-m-Y"}'-->
						</div>
					</div>
					<div class="col-6">
						<label for="" class="form-label">तारखे पर्यंत</label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="date" name="date-to" class="form-control js-flatpickr" value="<?= date('Y-m-d') ?>" >
							<!--data-hs-flatpickr-options='{"dateFormat": "d-m-Y"}'-->
						</div>
					</div>
				</form>
				
			</div>
			<div class="modal-footer border-top-0">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">रद्द करा</button>
				<button type="submit" form="date-range-form" class="btn btn-sm btn-primary">लागू करा</button>
			</div>
		</div>
	</div>
</div>

		<!--end page wrapper -->
<?php include "footer.php"; ?>
<script>
    cusListTbl = $('#salesAllTbl').DataTable({
         lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, 'सर्व'],
        ],
        initComplete: function(settings, json) {
            const filterCus = this.api().table().column(2).data().unique();
            $('#sales-cus-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterCus.length; i++) {
                if (filterCus[i]) {
                    $('#sales-cus-filter').append(`<option value="${filterCus[i]}">${filterCus[i].toTitleCase()}</option>`);
                }
            }
            const filterPay = this.api().table().column(6).data().unique();
            $('#pay-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterPay.length; i++) {
                if (filterPay[i]) {
                    $('#pay-filter').append(`<option value="${filterPay[i]}">${filterPay[i].toTitleCase()}</option>`);
                }
            }
            const filterPayStatus = this.api().table().column(7).data().unique();
            $('#paystatus-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterPayStatus.length; i++) {
                if (filterPayStatus[i]) {
                    $('#paystatus-filter').append(`<option value="${filterPayStatus[i]}">${filterPayStatus[i].toTitleCase()}</option>`);
                }
            }
        },
        buttons: [{
            extend: 'collection',
            text: 'Export',
            className: 'btn-sm btn-outline-dark me-2',
            buttons: [
                'copy',
                'excel',
                'csv',
                //'pdf',
                'print'
            ]
        }]
    });
    cusListTbl.buttons().container().prependTo('.export-container');
    $('#customer-filters-form').on('submit', function(e){
        e.preventDefault();
        const form = this.elements;
        cusListTbl.column(2).search(form['sales-cus-filter'].value).draw();
        cusListTbl.column(6).search(form['pay-filter'].value).draw();
        cusListTbl.column(7).search(form['paystatus-filter'].value).draw();
       
        $('#filterModal').modal('hide');
    });
	function rangeSelect(range) {
		let from = document.querySelector('[name="date-from"]');
		let to = document.querySelector('[name="date-to"]');
		let date = new Date();
		switch(range) {
			case 'today':
				from.value = date.getToday('-');
				date.setDate(date.getDate() + 1);
				to.value = date.getToday('-');
				break;
			case 'yesterday':
				to.value = date.getToday('-');
				date.setDate(date.getDate() - 1);
				from.value = date.getToday('-');
				break;
			case 'last_7_days':
				date.setDate(date.getDate() + 1);
				to.value = date.getToday('-');
				date.setDate(date.getDate() - 7);
				from.value = date.getToday('-');
				break;
			case 'last_30_days':
				date.setDate(date.getDate() + 1);
				to.value = date.getToday('-');
				date.setDate(date.getDate() - 30);
				from.value = date.getToday('-');
				break;
			case 'last_90_days':
				date.setDate(date.getDate() + 1);
				to.value = date.getToday('-');
				date.setDate(date.getDate() - 90);
				from.value = date.getToday('-');
				break;
			case 'last_month':
				date.setMonth(date.getMonth(), 0)
				from.value = date.getToday('-');
				date.setDate(1);
				to.value = date.getToday('-');
				break;
			case 'last_year':
				date.setYear(date.getFullYear() - 1);
				from.value = `${date.getFullYear()}-01-01`;
				to.value = `${date.getFullYear()}-12-31`;
				break;
			case 'all':
				from.value = '1970-01-01';
				date.setDate(date.getDate() + 1);
				to.value = date.getToday('-');
				break;
		}
	}

</script>
<script src="assets/js/vfs_fonts.js"></script>
<script>
	$.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt.buttons.pdfHtml5.customize = function(doc) { doc.defaultStyle.font = 'NotoSans';};
</script>