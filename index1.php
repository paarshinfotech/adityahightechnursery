<?php require_once "config.php"; ?>
<?php Aditya::Subtitle('डॅशबोड') ?>
<?php
// $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
// $expenses = 0;
// $getExp = mysqli_query($connect, "SELECT ROUND(SUM(ex_amount), 2) AS expenses FROM admin_expenses WHERE YEAR(ex_date) = '{$year}'");
// $_exp = mysqli_fetch_assoc($getExp);
// if (!empty($_exp['expenses'])) {
// 	$expenses += $_exp['expenses'];
// }

// $getSubc = mysqli_query($connect, "SELECT COUNT(*) AS customers, SUM(sp_paid) AS amount FROM subcription_purchase WHERE YEAR(sp_purchased) = '{$year}'");
// $_subc = mysqli_fetch_assoc($getSubc);

// $all_custs = (int) $_subc['customers'];
// $sub_revenue = (float) $_subc['amount'];

// $getSMS = mysqli_query($connect, "SELECT SUM(spp_sms_count) AS sold, SUM(spp_paid) AS amount FROM sms_pack_purchase WHERE YEAR(spp_purchase) = '{$year}'");
// $_sms = mysqli_fetch_assoc($getSMS);
// $sms_revenue = (float) $_sms['amount'];
// $sms_sold = (int) $_sms['sold'];
// $total_revenue = (float) ($sub_revenue + $sms_revenue);
// $total_profit = (float) ($total_revenue - $expenses);
// $gross_margin = $total_revenue ? (float) (100 * $total_profit / $total_revenue) : 0.00;

// $active_subsc = (int) mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS active FROM subcription_purchase WHERE sp_id IN (SELECT MAX(sp_id) AS sp_id FROM subcription_purchase GROUP BY sp_vid) AND sp_status = 'active'"))['active'];
// $expired_subsc = (int) mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS expired FROM subcription_purchase WHERE sp_id IN (SELECT MAX(sp_id) AS sp_id FROM subcription_purchase GROUP BY sp_vid) AND sp_status = 'expired'"))['expired'];

// $start_custs = (int) mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS customers FROM subcription_purchase WHERE YEAR(sp_purchased) = '{$year}' AND MONTH(sp_purchased) = '01'"))['customers'];

// $end_custs = (int) mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(*) AS customers FROM subcription_purchase WHERE YEAR(sp_purchased) = '{$year}' AND MONTH(sp_purchased) <= '12'"))['customers'];
// $churn_rate = $start_custs ? (float) ($start_custs - $end_custs / $start_custs) : (float) ($start_custs - $end_custs);
// $lifetime = $churn_rate ? (float) (1 / $churn_rate) : 0.00;
// $lifetime_revenue = (float) ($lifetime * $total_revenue);
// $lifetime_value = (float) ($lifetime_revenue * $gross_margin);
?>
<?php require_once "header.php"; ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<div class="row g-3" data-masonry='{"percentPosition": true }'>
			<div class="col-12">
				<div class="border rounded-3 shadow-sm bg-white d-flex justify-content-between">
					<div class="fs-5 p-3">Dashboard</div>
					<div class="fs-5 p-3"><?//= $year ?></div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Total Revenue</div>
					<div class="p-3">
						<div class="d-flex justify-content-between">
							<span>Subscription</span>
							<span class="rupee-after">
								<?//= sprintf('%0.2f', $sub_revenue) ?>
							</span>
						</div>
						<div class="d-flex justify-content-between border-bottom">
							<span>SMS</span>
							<span class="rupee-after">
								<?//= sprintf('%0.2f', $sms_revenue) ?>
							</span>
						</div>
						<div class="d-flex justify-content-between">
							<span>Total</span>
							<span class="rupee-after">
								<?//= sprintf('%0.2f', $total_revenue) ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Total Profit</div>
					<div class="p-3">
						<div class="d-flex justify-content-between">
							<span>Total Revenue</span>
							<span class="rupee-after">
								<?//= sprintf('%0.2f', $total_revenue) ?>
							</span>
						</div>
						<div class="d-flex justify-content-between border-bottom">
							<span>Total Expenses</span>
							<span class="rupee-after">
								- <?//= sprintf('%0.2f', $expenses) ?>
							</span>
						</div>
						<div class="d-flex justify-content-between">
							<span>Total Profit</span>
							<span class="rupee-after">
								<?//= sprintf('%0.2f', $total_profit) ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Gross Margin</div>
					<div class="p-3">
						<div>&nbsp;</div>
						<div><?//= sprintf('%0.2f', $gross_margin) ?>%</div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Subscribers</div>
					<div class="p-3">
						<div class="d-flex justify-content-between">
							<span>Active</span>
							<span>
								<?//= $active_subsc ?>
							</span>
						</div>
						<div class="d-flex justify-content-between border-bottom">
							<span>Inactive</span>
							<span>
								<?//= $expired_subsc ?>
							</span>
						</div>
						<div class="d-flex justify-content-between">
							<span>Total</span>
							<span>
								<?//= $active_subsc + $expired_subsc ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">SMS</div>
					<div class="p-3">
						<div class="d-flex justify-content-between">
							<span>Remaining</span>
							<span>
								<?//= rand(90000, 100000) ?>
							</span>
						</div>
						<div class="d-flex justify-content-between">
							<span>Sold</span>
							<span>
								<?//= $sms_sold ?>
							</span>
						</div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Customer Churn rate</div>
					<div class="p-3">
						<div>&nbsp;</div>
						<div><?//= sprintf('%+0.2f', $churn_rate) ?></div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Lifetime of customer</div>
					<div class="p-3">
						<div>&nbsp;</div>
						<div><?//= sprintf('%+0.2f', $lifetime) ?></div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Lifetime revenue</div>
					<div class="p-3">
						<div>&nbsp;</div>
						<div><?//= sprintf('%+0.2f', $lifetime_revenue) ?></div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4">
				<div class="border rounded-3 shadow-sm bg-white">
					<div class="fs-5 border-bottom p-3">Lifetime Value</div>
					<div class="p-3">
						<div>&nbsp;</div>
						<div><?//= sprintf('%+0.2f', $lifetime_value) ?></div>
						<div>&nbsp;</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php require_once "footer.php"; ?>