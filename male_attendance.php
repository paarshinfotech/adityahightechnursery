<?php require "config.php" ?>
<?php
Aditya::subtitle('पुरुष हजेरी');

if (isset($_GET['date'])) {
	escape($_GET);
	$today = date('Y-m-d', strtotime($_GET['date']));
	if (strtotime($today) > strtotime(date('Y-m-d'))) {
		$today = date('Y-m-d');
	}
} else {
	$today = date('Y-m-d');
}
if (isset($_POST['save_attendance'])) {
	if (save_attendance($_POST)) {
		header("Location: male_attendance?date={$today}");
		exit();
	}
}
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
	    <h6 class="mb-0 text-uppercase">पुरुष हजेरी</h6>
		<div class="dropdown-center">
               <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item"  href="employee_add">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item"  href="male_list">सर्व बघा</a></li>
                    
                     <li><a class="dropdown-item" href="male_salery">पगार</a></li>
                    <li><a class="dropdown-item"  href="pickup">उचल / ऍडव्हान / उसने</a></li>
                   

                  </ul>
            </div>
		<hr/>
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
				
				 <form method="POST">
			<input type="hidden" name="at_date" value="<?= $today ?>">
			<?php $list = week_date_list($today) ?>
			<div class="fs-3 bg-light border px-2 py-3 text-center mb-2 rounded-1 shadow-sm">
				<?= translate(week_date_selected($list)->full_month) ?> - <?= translate_number(week_date_selected($list)->year) ?>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered table-nowrap table-align-middle table-col-1-fixed-start shadow-end table-col-2-fixed-start-offset-1">
					<thead class="thead-light" align="center">
						<tr>
							<th rowspan="2" class="fs-5"><?= translate('sr_no') ?></th>
							<th rowspan="2" class="text-start fs-5">
								<?= translate('employee_name') ?>
							</th>
							<?php foreach ($list as $i => $day): ?>
							<th colspan="2" class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>">
								<div class="fs-5">
									<?= translate($day->full_day) ?>
								</div>
								<div>
									<?= translate_date($day->full_date) ?>
								</div>
							</th>
							<?php endforeach ?>
						</tr>
						<tr>
							<?php foreach ($list as $i => $day): ?>
							<th class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>"><?= translate('absent') ?></th>
							<th class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>"><?= translate('present') ?></th>
							<!--<th class="<?//= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>"><?//= translate('paid_leave') ?></th>-->
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody align="center">
						<?php $employees = get_employees() ?>
						<?php foreach ($employees as $i => $employee): ?>
						<tr>
							<td class="bg-light"><?= translate_number($employee->emp_id) ?></td>
							<td class="bg-light text-start">
								<input type="hidden" name="at_emp_id[<?= $employee->emp_id ?>]" value="<?= $employee->emp_id ?>">
								<?= $employee->emp_name ?>
							</td>
							<?php foreach ($list as $i => $day): ?>
							<?php $attn = get_emp_attendance($employee->emp_id, $day->date) ?>
							<td class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>">
								<input class="form-check-input" type="radio"
								<?php if ($day->is_totay): ?>
									name="at_status[<?= $employee->emp_id ?>]" value="A"
								<?php else: ?>
									disabled
								<?php endif ?>
								<?php if ($attn->at_status && $attn->at_status === 'A'): ?>
									checked
								<?php endif ?>
								>
							</td>
							<td class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>">
								<input class="form-check-input" type="radio"
								<?php if ($day->is_totay): ?>
									name="at_status[<?= $employee->emp_id ?>]" value="P"
								<?php else: ?>
									disabled
								<?php endif ?>
								<?php if ($attn->at_status && $attn->at_status === 'P'): ?>
									checked
								<?php endif ?>
								>
							</td>
							<!--<td class="<?//= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>">-->
							<!--	<input class="form-check-input" type="radio"-->
							<!--	<?php if ($day->is_totay): ?>-->
							<!--		name="at_status[<?= $employee->emp_id ?>]" value="PL"-->
							<!--	<?php else: ?>-->
							<!--		disabled-->
							<!--	<?php endif ?>-->
							<!--	<?php if ($attn->at_status && $attn->at_status === 'PL'): ?>-->
							<!--		checked-->
							<!--	<?php endif ?>-->
							<!--	>-->
							<!--</td>-->
							<?php endforeach ?>
						</tr>
						<?php endforeach ?>
					</tbody>
					<tfoot class="thead-light">
						<tr>
							<th class="border-end-0"></th>
							<th class="border-start-0"></th>
							<?php foreach ($list as $i => $day): ?>
							<th colspan="2" class="<?= $day->is_totay ? 'bg-primary bg-opacity-25' : '' ?>">
								<?php if (count($employees) && $day->is_totay): ?>
								<button type="submit" class="btn btn-primary btn-sm w-100" name="save_attendance">
									<?= translate('save') ?>
								</button>
								<?php endif ?>
							</th>
							<?php endforeach ?>
						</tr>
					</tfoot>
				</table>
			</div>
		</form>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>
<script>
    window.addEventListener('load', () => {
		let inputs = document.querySelector('.date-picker');
		if (inputs) {
			flatpickr(inputs, {
				dateFormat: 'Y-m-d',
				maxDate: new Date()
			});
		}
	});
</script>