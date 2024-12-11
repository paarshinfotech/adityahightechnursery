<?php require "config.php" ?>
<?php
Aditya::subtitle('महिला पगार');

$salary_format = load_salary_format();
if (isset($_GET['year'])) {
	escape($_GET);
	$year = (int) $_GET['year'];
	if ($year > ((int) date('Y'))) {
		$year = (int) date('Y');
	}
} else {
	$year = (int) date('Y');
}

if (isset($_GET['month'])) {
	escape($_GET);
	$month = $_GET['month'];
	if (strtotime("{$year}-{$month}") > strtotime(date('Y-m'))) {
		$month = date('m');
	}
} else {
	$month = date('m');
}
$day = '01';
// if (isset($_GET['week'])) {
// 	escape($_GET);
// 	$week = $_GET['week'];
// 	if (strtotime("{$year}-{$month}") > strtotime(date('Y-m'))) {
// 		$week = date('m');
// 	}
// } else {
// 	$week = date('m');
// }
$date = "{$year}-{$month}-{$day}";
?>
<?php require "header.php" ?>
<style>
td:nth-child(1), td:nth-child(2){
   position:sticky;
   left:0px;
}
</style>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
	    <div class="row align-items-center">
			<div class="col">
				<h6 class="page-header-title">
					महिला <?= translate('salary') ?>
				</h6>
			</div>
			<div class="col-auto mb-3">
				<button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#selectSalaryMonth"><?= translate('change_month') ?></button>
			</div>
			<div class="col-auto mt-2">
				<div class="dropdown-center">
               <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    
                    <li><a class="dropdown-item"  href="employee_add">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item"  href="female_list">सर्व बघा</a></li>
                    <li><a class="dropdown-item"  href="female_attendance">हजेरी</a></li>
                     <!--<li><a class="dropdown-item" href="sallery">पगार</a></li>-->
                    <li><a class="dropdown-item"  href="pickup">उचल / ऍडव्हान / उसने</a></li>
                   

                  </ul>
            </div>
			</div>
			
		</div>
        
		<!--<hr/>-->
		<div class="card">
			<div class="card-body">
			     <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				 <div>
		<?php if ($salary_format==='monthly'): ?>
		<?php $list = month_date_list($date) ?>
		<?php elseif ($salary_format==='weekly'): ?>
		<?php $list = week_date_list($date) ?>
		<?php endif ?>
		<div class="fs-3 bg-light border px-2 py-3 text-center mb-2 rounded-1 shadow-sm">
			<div><?= translate(week_date_selected($list)->full_month) ?> - <?= translate_number(week_date_selected($list)->year) ?></div>
			<div class="small">
				<small>[<?= translate_date($list[0]->full_date) ?> - <?= translate_date($list[count($list) - 1]->full_date) ?>]</small>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-nowrap table-align-middle table-col-1-fixed-start shadow-end table-col-2-fixed-start-offset-1">
				<thead class="bg-light" align="center">
					<tr>
						<th class="text-start"><?= translate('sr_no') ?> 
						
						</th>
						<th class="text-start"><?= translate('employee_name') ?></th>
						<?php foreach ($list as $i => $day): ?>
						<?php if ($salary_format==='monthly'): ?>
						<th><?= translate_number($day->day) ?></th>
						<?php elseif ($salary_format==='weekly'): ?>
						<th>
							<div class="fs-5">
								<?= translate($day->full_day) ?>
							</div>
							<div>
								<?= translate_date($day->full_date) ?>
							</div></th>
						<?php endif ?>
						<?php endforeach ?>
						<th class="text-white bg-danger"><?= translate('absent') ?></th>
						<th class="text-white bg-success"><?= translate('present') ?></th>
						<!--<th class="text-white bg-primary"><?//= translate('paid_leave') ?></th>-->
						<th class="text-white bg-secondary"><?= translate('per_day_salary') ?></th>
						<th class="text-white bg-dark">
							<div><?= translate('total_salary') ?></div>
							<div class="small fw-normal">
								<small>(<?= translate('present') ?> + <?= translate('paid_leave') ?>) x <?= translate('per_day_salary') ?></small>
							</div>
						</th>
						<th class="text-white bg-warning"><?= translate('advance') ?> / <?= translate('borrowing') ?></th>
						<th class="text-white bg-success">
							<div><?= translate('total_payable') ?></div>
							<div class="small fw-normal">
								<small>(<?= translate('total_salary') ?> - <?= translate('advance') ?>)</small>
							</div>
						</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php $employees = get_employees_sallery_female() ?>
					<?php foreach ($employees as $i => $employee): ?>
					<tr>
						<td class="bg-light text-start"><?= translate_number($employee->emp_id) ?> </td>
						<td class="bg-light text-start"><?= $employee->emp_name ?></td>
						<?php
						$present = 0;
						$paid_leave = 0;
						$absent = 0;
						$total_present = 0;
				        //$advance = 0;
				        $advance = sum_advance($employee->emp_id);
						?>
						<?php foreach ($list as $i => $day): ?>
						<?php $attn = get_emp_attendance($employee->emp_id, $day->date) ?>
						<td class="<?= $attn->at_status=='P' ? 'text-white bg-success' : ($attn->at_status=='A' ? 'text-white bg-danger' : ($attn->at_status=='PL' ? 'text-white bg-primary' : 'bg-light')) ?>"><?= $attn->at_status ?></td>
						<?php if ($attn->at_status=='P'): ?>
						<?php $present++; $total_present++; ?>
						<?php elseif ($attn->at_status=='A'): ?>
						<?php $absent++; ?>
						<?php //elseif ($attn->at_status=='PL'): ?>
						<?php //$paid_leave++; $total_present++; ?>
						<?php endif ?>
						<?php endforeach ?>
						<td class="text-white bg-danger"><?= translate_number($absent) ?></td>
						<td class="text-white bg-success"><?= translate_number($present) ?></td>
						<!--<td class="text-white bg-primary"><?//= translate_number($paid_leave) ?></td>-->
						<td class="text-white bg-secondary"><?= translate_number(sprintf('%0.2f', $employee->emp_salary)) ?></td>
						<td class="text-white bg-dark"><?= translate_number(sprintf('%0.2f', $total_present * $employee->emp_salary)) ?></td>
						<td class="text-white bg-warning"><?= translate_number(sprintf('%0.2f', $advance)) ?></td>
						<td class="text-white bg-success"><?= translate_number(sprintf('%0.2f', (($total_present * $employee->emp_salary) - $advance))) ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center gap-3 my-2">
			<span class="px-3 rounded-1 text-white bg-success">P - <?= translate('present') ?></span>
			<span class="px-3 rounded-1 text-white bg-danger">A - <?= translate('absent') ?></span>
			<!--<span class="px-3 rounded-1 text-white bg-primary">PL - <?//= translate('paid_leave') ?></span>-->
		</div>
	</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<div class="modal fade" id="selectSalaryMonth" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="selectSalaryMonthLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content border shadow">
			<div class="modal-header">
				<h5 class="modal-title" id="selectSalaryMonthLabel"><?= translate('change_month') ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" class="row g-3" id="salary-month-change-form">
					<div class="col-12 col-md-6">
						<label class="form-label"><?= translate('select_month') ?></label>
						<select class="form-select form-select-sm" name="month" required>
							<option value=""><?= translate('select') ?></option>
							<?php for ($mn = 1; $mn <= 12; $mn++): ?>
							<option value="<?= sprintf("%'02d", $mn) ?>" <?= ($month == $mn) ? 'selected' : '' ?>><?= translate(date('F', strtotime("{$year}-".sprintf("%'02d", $mn)))) ?></option>
							<?php endfor ?>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label"><?= translate('select_year') ?></label>
						<select class="form-select form-select-sm" name="year" required>
							<option value=""><?= translate('select') ?></option>
							<?php for ($yr=(date('Y')-2); $yr <= date('Y'); $yr++): ?> 
							<option value="<?= $yr ?>" <?= $yr === $year ? 'selected' : '' ?>><?= $yr ?></option>
							<?php endfor ?>
						</select>
					</div>
				</form>
			</div>
			<div class="modal-footer pt-0 border-top-0">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= translate('close') ?></button>
				<button type="submit" form="salary-month-change-form" class="btn btn-sm btn-primary"><?= translate('change') ?></button>
			</div>
		</div>
	</div>
</div>
<?php require_once 'footer.php' ?>
<script>
	$(document).ready(() => {
		flatpickr($('.date-picker'), {
			dateFormat: 'Y-m-d',
			maxDate: new Date()
		});
	});
</script>