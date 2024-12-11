<?php require_once 'config.php' ?>
<?php //is_login(null, 'login') ?>
<?php// Nursery::Title(translate('all_sales')) ?>
<?php
//$subcription_status = get_subscription();
//if (!$subcription_status) {
//	subscription_expired();
//}
//if (!is_allowed('view', 'Report')) {
//	notAllowed();
//}
$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('Y-m-d');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('Y-m-d', strtotime("{$from} + 1 day"));
?>
<?php require_once 'header.php' ?>
<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a>
					<span><?= translate('all_sales') ?></span>
				</h1>
			</div>
		</div>
	</div>
	<div class="reports-table-filters">
		<div class="row g-3">
			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
					  <i class="bi-search"></i>
					</div>
					<input type="search" class="form-control reports-table-search" placeholder="<?= translate('search_here') ?>">
				</div>
			</div>
			<div class="col-12 col-md-6 offset-md-3">
				<div class="d-flex align-items-center gap-2">
					<button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal" data-bs-target="#reportsDateRangeModal">
						<?= translate('duration') ?> <i class="bi-calendar-week"></i>
					</button>
					<button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
						<?= translate('filter') ?> <i class="bi-funnel-fill"></i>
					</button>
					<div class="export-buttons"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table id="reports-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light" align="left">
				<tr>
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
									<th>पेमेंट स्टेटस </th
				</tr>
			</thead>
			<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and s.sales_status='1' and demo_status='1' AND s.sdate >= '{$from}' AND s.sdate < '{$to}' order by s.sale_id DESC") ?>
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
                                
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
			
		</table>
	</div>
	<div class="reports-table-footer"></div>
</div>
<div class="modal fade" id="reportsDateRangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reportsDateRangeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-body">
				<form id="date-range-form" class="row g-3 mt-0">
					<div class="col-12">
						<input type="hidden" name="show" value="sales-all">
						<label class="form-label"><?= translate('duration') ?></label>
						<select class="form-select form-select-sm" id="report-date-range" onchange="rangeSelect(this.value)">
							<option value=""><?= translate('select_duration') ?></option>
							<option value="today"><?= translate('today') ?></option>
							<option value="yesterday"><?= translate('yesterday') ?></option>
							<option value="last_7_days"><?= sprintf(translate('last_n_days'), 7) ?></option>
							<option value="last_30_days"><?= sprintf(translate('last_n_days'), 30) ?></option>
							<option value="last_90_days"><?= sprintf(translate('last_n_days'), 90) ?></option>
							<option value="last_month"><?= translate('last_month') ?></option>
							<option value="last_year"><?= translate('last_year') ?></option>
							<option value="all"><?= translate('all') ?></option>
						</select>
					</div>
					<div class="col-6">
						<label for="" class="form-label"><?= translate('from_date') ?></label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="text" name="date-from" class="form-control js-flatpickr" value="<?= $from ?>" data-hs-flatpickr-options='{"dateFormat": "Y-m-d"}'>
						</div>
					</div>
					<div class="col-6">
						<label for="" class="form-label"><?= translate('to_date') ?></label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="text" name="date-to" class="form-control js-flatpickr" value="<?= $to ?>" data-hs-flatpickr-options='{"dateFormat": "Y-m-d"}'>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer border-top-0">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= translate('cancel') ?></button>
				<button type="submit" form="date-range-form" class="btn btn-sm btn-primary"><?= translate('apply') ?></button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-header">
				<h5 class="modal-title" id="filterModalLabel"><?= translate('filter') ?></h5>
			</div>
			<div class="modal-body py-3">
				<form class="row g-3" id="filter-form">
					<div class="col-12 col-md-6">
						<label class="form-label">
							<?= sprintf(translate('filter_by'), translate('customers')) ?>
						</label>
						<select class="form-select form-select-sm" id="filter-customer" name="cus_name">
							<option value="" selected><?= translate('all') ?></option>>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">
							<?= sprintf(translate('filter_by'), translate('paymode')) ?>
						</label>
						<select class="form-select form-select-sm" name="paymode">
							<option value="" selected><?= translate('all') ?></option>
							<option value="<?= translate('cash') ?>"><?= translate('cash') ?></option>
							<option value="<?= translate('upi') ?>"><?= translate('upi') ?></option>
							<option value="<?= translate('neft') ?>"><?= translate('neft') ?></option>
							<option value="<?= translate('rtgs') ?>"><?= translate('rtgs') ?></option>
							<option value="<?= translate('other') ?>"><?= translate('other') ?></option>
							<option value="<?= translate('unpaid') ?>"><?= translate('unpaid') ?></option>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label">
							<?= sprintf(translate('filter_by'), translate('payment_status')) ?>
						</label>
						<select class="form-select form-select-sm" name="status">
							<option value="" selected><?= translate('all') ?></option>
							<option value="<?= translate('paid') ?>"><?= translate('paid') ?></option>
							<option value="<?= translate('unpaid') ?>"><?= translate('unpaid') ?></option>
							<option value="<?= translate('quotation') ?>"><?= translate('quotation') ?></option>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer border-top-0">
				<button type="button" onclick="clearAllFilters()" class="btn btn-sm btn-outline-danger me-auto" data-bs-dismiss="modal"><?= translate('clear_filters') ?></button>
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= translate('close') ?></button>
				<button type="submit" form="filter-form" class="btn btn-sm btn-primary"><?= translate('apply_filter') ?></button>
			</div>
		</div>
	</div>
</div>
<?php require_once 'footer.php' ?>
<script>
	function clearAllFilters() {
		$('#filter-form').trigger('reset');
		reportsTable.columns().search('').draw();
	}
	$('#filter-form').on('submit', function(e){
		e.preventDefault();
		const form = this.elements;
		reportsTable.column(2).search(form.cus_name.value).draw()
		reportsTable.column(8).search(form.paymode.value).draw();
		// Exact Match with RegExp => ^start with ends with$
		if (form.status.value) {
			reportsTable.column(9).search('^'+form.status.value+'$', true, false).draw();
		} else {
			reportsTable.column(9).search(form.status.value).draw();
		}
		$('#filterModal').modal('hide');
	});
	let reportsTable = $('#reports-table').DataTable({
		lengthChange: true,
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
			$(api.table().footer()).find('th:eq(2)').html(
				api.column(4, {page:'current'}).data().sum().toFixed(2)
			);
			$(api.table().footer()).find('th:eq(3)').html(
				api.column(5, {page:'current'}).data().sum().toFixed(2)
			);
			$(api.table().footer()).find('th:eq(4)').html(
				api.column(6, {page:'current'}).data().sum().toFixed(2)
			);
			$(api.table().footer()).find('th:eq(5)').html(
				api.column(7, {page:'current'}).data().sum().toFixed(2)
			);
		},
		buttons: [{
			extend: 'collection',
			text: '<i class="bi bi-cloud-download-fill"></i>',
			className: 'btn-sm btn-outline-primary',
			buttons: [
				{extend: 'copy', text: '<i class="bi-clipboard2-check dropdown-item-icon"></i> <?= translate('copy') ?>'},
				{extend: 'excel', text: '<i class="bi-filetype-xlsx dropdown-item-icon"></i> <?= translate('excel') ?>'},
				{extend: 'csv', text: '<i class="bi-filetype-csv dropdown-item-icon"></i> <?= translate('csv') ?>'},
				{extend: 'pdf', text: '<i class="bi-filetype-pdf dropdown-item-icon"></i> <?= translate('pdf') ?>'},
				{extend: 'print', text: '<i class="bi-printer dropdown-item-icon"></i> <?= translate('print') ?>'}
			]
		}]
	});
	reportsTable.buttons().container().find('.btn-secondary').removeClass('btn-secondary');
	reportsTable.buttons().container().appendTo($('.export-buttons'));
	const customer = reportsTable.column(2).data().unique();
	const list = [];
	for (let i = 0; i < customer.length; i++) {
		const cus = $(customer[i]).text().trim();
		if (list.indexOf(cus)<0) {
			list.push(cus);
		}
	}
	list.forEach(c => {
		$('#filter-customer').append(`<option value="${c}">${c}</option>`);
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