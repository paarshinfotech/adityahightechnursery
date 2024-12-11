<?php
require_once "config.php";
Aditya::subtitle('सर्व खर्च');

$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('d-m-Y');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('d-m-Y', strtotime("{$from} + 1 day"));

require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			    <h4 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class='bx bx-left-arrow-circle'></i></a>
					<span>सर्व खर्च</span>
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
                        <!--<div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">-->
                        <!--    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
                        <!--        <div class="modal-content">-->
                        <!--            <div class="modal-header">-->
                        <!--                <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>-->
                        <!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                        <!--            </div>-->
                        <!--            <div class="modal-body">-->
                        <!--                <form id="customer-filters-form" class="row g-3">-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">श्रेणी ने फिल्टर करा</label>-->
                        <!--                        <select class="form-select" id="category-filter">-->
                        <!--                            <option value="">सर्व</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">कोणाला दिले ने फिल्टर करा</label>-->
                        <!--                        <select class="form-select" id="typefor-filter">-->
                        <!--                            <option value="">सर्व</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">कशासाठी खर्च केला ने फिल्टर करा</label>-->
                        <!--                        <select class="form-select" id="reson-filter">-->
                        <!--                            <option value="">सर्व</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">खर्चासाठी पेमेंट मोड ने फिल्टर करा</label>-->
                        <!--                        <select class="form-select" id="expense-pay-filter">-->
                        <!--                            <option value="">सर्व</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                                           
                        <!--                </form>-->
                        <!--            </div>-->
                        <!--            <div class="modal-footer border-top-0">-->
                        <!--                <button class="btn btn-outline-light border text-danger me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(cusListTbl, '#customer-filters-form')">सर्व फिल्टर हटवा</button>-->
                        <!--                <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">बंद करा</button>-->
                        <!--                <button type="submit" form="customer-filters-form" class="btn btn-dark">फिल्टर लागू करा</button>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-header">
				<h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
			</div>
			<div class="modal-body py-3">
				<form class="row g-3" id="filter-form">
					<div class="col-12 col-md-6">
						 <label class="form-label">श्रेणी ने फिल्टर करा</label>
						<select class="form-select form-select-sm" id="filter-ex_cat" name="ex_cat">
							<option value="">सर्व</option>
						</select>
					</div>
					<div class="col-12 col-md-6">
						 <label class="form-label">कोणाला दिले ने फिल्टर करा</label>
						<select class="form-select form-select-sm" id="filter-expense_to" name="expense_to">
							<option value="">सर्व</option>
						</select>
					</div>
					<div class="col-12 col-md-6">
					<label class="form-label">कशासाठी खर्च केला ने फिल्टर करा</label>
						<select class="form-select form-select-sm" id="filter-expense_for" name="expense_for">
							<option value="">सर्व</option>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">खर्चासाठी पेमेंट मोड ने फिल्टर करा</label>
						<select class="form-select form-select-sm" id="filter-expense_paymode" name="expense_paymode">
							<option value="">सर्व</option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer border-top-0">
				<button type="button" onclick="clearAllFilters()" class="btn btn-sm btn-outline-danger me-auto" data-bs-dismiss="modal">सर्व फिल्टर हटवा</button>
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">बंद करा</button>
				<button type="submit" form="filter-form" class="btn btn-sm btn-primary">फिल्टर लागू करा</button>
			</div>
		</div>
	</div>
</div>
                                    
                                </div>
                    </div>
        				<div class="table-responsive">
        					<table border="1" id="reports-table" class="table table-striped table-bordered table-hover multicheck-container">
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
        			         <!--                   			<a title="Delete" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('विक्री हटवा..?');">-->
        			         <!--                   				<i class="btn-round bx bx-trash me-2"></i>विक्री हटवा-->
        			         <!--                   			</a>-->
        			         <!--                   		</li>-->
        			         <!--                   	</ul>-->
        			         <!--                   </div>-->
        								    <!--</div>-->
        								   अ.क्रं.	
        									<?php //endif ?>
        								</th>
        								    <th>श्रेणी</th>
            								<th>खर्चाची तारीख</th>
                                            <th>खर्चाची रक्कम</th
                                            >
        									<th>कोणाला दिले</th>
        									<th>कशासाठी खर्च केला</th>
        									<th>खर्चाचे वर्णन</th>
        									<th>खर्चासाठी पेमेंट मोड</th>
        						   </tr>
        						</thead>
        						<tbody>
                                    <?php $getExpenses = mysqli_query($connect, "SELECT * FROM expenses e, expenses_category c WHERE e.ex_cat_id=c.ex_cat_id AND e.ex_status='1' AND e.ex_date >= '{$from}' AND e.ex_date < '{$to}' order by e.ex_id DESC") ?>
                                    <?php if (mysqli_num_rows($getExpenses)>0): ?>
                                        <?php 
                                        $exOrder = array();
                                        while ($fetchExpense = mysqli_fetch_assoc($getExpenses)): 
                                        array_push($exOrder, $fetchExpense);
                                        extract($fetchExpense);
                                        ?>
                                        <tr>
                                        <td class="form-group">
                                            <!--<input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?//= $sale_id ?>">-->
                                            <span class="badge bg-gradient-bloody text-white shadow-sm">
                                                <?= $ex_id ?>
                                            </span>
                                        </td>
                                        <td><?= $ex_cat_name?></td>
                                        <td class="text-dark fw-bold">
        						        						<span> <?php $date=date('d M Y',strtotime($ex_date))?>
                                                    <?= $date?></span>
        						        					</td>
                                        <td>
                                            <?= $ex_amt; ?>
                                        </td>
                                        <td>
                                            <?= $ex_name; ?>
                                        </td>
                                        
        								<td>
        									<?= $ex_for?>
        								</td>
        								<td>
        									<?= $ex_note?>
        								</td>
        								<td>
        									<?= $payment_mode?>
        								</td>
        								
                                        </tr>
                                        <?php 
                                        error_reporting(0);
                                        $totExpense += $ex_amt;
                                        ?>
                                        
                                        <?php endwhile ?>
                                    <?php endif ?>
        						</tbody>
                                <?php error_reporting(0);?>
        						<tfoot>
        				            <tr>
                					    <th colspan="3">एकूण</th>
                    					<th class="rupee-after"> 
                    					    <?= $totExpense; ?>
                    					</th>
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
	function clearAllFilters() {
		$('#filter-form').trigger('reset');
		reportsTable.columns().search('').draw();
	}
	$('#filter-form').on('submit', function(e){
		e.preventDefault();
		const form = this.elements;
		reportsTable.column(1).search(form.ex_cat.value).draw()
		reportsTable.column(4).search(form.expense_to.value).draw()
		reportsTable.column(5).search(form.expense_for.value).draw();
		reportsTable.column(7).search(form.expense_paymode.value).draw();
		$('#filterModal').modal('hide');
	});
	let reportsTable = $('#reports-table').DataTable({
		lengthChange: true,
		lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, 'सर्व'],
        ],
		columnDefs: [{
			// targets: [0,],
			// orderable: false,
		}],
		order: [
			[1, 'desc'],
			[0, 'desc']
		],
		initComplete: function(settings, json) {
			$('.dataTables_filter').hide();
			$('.reports-table-footer').append($('#reports-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
			$('.dataTables_info').before($('.dataTables_length').find('label').attr('class','d-inline-flex text-nowrap align-items-center gap-2'));
			$('.reports-table-search').on('input', function() {
				reportsTable.search(this.value).draw();
			});
		},
		drawCallback: function () {
			let api = this.api();
			$(api.table().footer()).find('th:eq(1)').html(
				api.column(3, {page:'current'}).data().sum().toFixed(2)
			);
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
	reportsTable.buttons().container().prependTo('.export-container');
	reportsTable.buttons().container().find('.btn-secondary').removeClass('btn-secondary');
	reportsTable.buttons().container().appendTo($('.export-buttons'));
	const ex_cat = reportsTable.column(1).data().unique();
	for (let i = 0; i < ex_cat.length; i++) {
		$('#filter-ex_cat').append(`<option value="${ex_cat[i]}">${ex_cat[i]}</option>`);
	}
	const expense_to = reportsTable.column(4).data().unique();
	for (let i = 0; i < expense_to.length; i++) {
		$('#filter-expense_to').append(`<option value="${expense_to[i]}">${expense_to[i]}</option>`);
	}
	const expense_for = reportsTable.column(5).data().unique();
	for (let i = 0; i < expense_for.length; i++) {
		$('#filter-expense_for').append(`<option value="${expense_for[i]}">${expense_for[i]}</option>`);
	}
	const expense_paymode = reportsTable.column(7).data().unique();
	for (let i = 0; i < expense_paymode.length; i++) {
		$('#filter-expense_paymode').append(`<option value="${expense_paymode[i]}">${expense_paymode[i]}</option>`);
	}
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