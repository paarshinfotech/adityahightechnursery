<?php require "config.php" ?>

<?php
Aditya::subtitle('विक्री पुनर्संचयित');

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
if (isset($_GET['restore']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE sales SET sales_status='1' and demo_status='1' WHERE sale_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?show_history=true&action=Success&action_msg= विक्री पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM sales WHERE sale_id='{$dir}' and demo_status='1'");
     }
        if($delete){
    	header("Location: sales?show_history=true&action=Success&action_msg=विक्री हटवले..!");
		exit();
        }else{
        header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">विक्री </h6>
            <a class="btn btn-sm btn-success float-end" href="sales" style="margin-top:-25px;">
			<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
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
				
				 <div class="table-responsive">
					<table border="1" id="example2" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			             
			                            		<li>
			                            			<a title="पुनर्संचयित करा" class="multi-action-btn dropdown-item text-success" data-multi-action="restore" data-multi-action-page="" href="?restore=true" ONCLICK="RETURN CONFIRM('पुनर्संचयित करा..?');">
			                            				<i class="btn-round bx bx-recycle me-2"></i>पुनर्संचयित करा 
			                            			</a>
			                            			</li>
			                            			<li>
			                            			<a title="विक्री हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('विक्री हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>विक्री हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>ग्राहकाचे नाव</th
                                    >
									<th>तारीख</th>
									<th>गाडी भाडे</th>
									<th>ड्राइवर नाव</th>
									<th>एकूण</th>
									<th>ऍडव्हान्स</th>
									<th>शिल्लक</th>
									<th>पेमेंट मोड</th>
									<th>कृती</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and sales_status='0' and demo_status='1' ORDER BY sale_id DESC") ?>
                            <?php if (mysqli_num_rows($getsalesDetails)>0): ?>
                                <?php while ($sales = mysqli_fetch_assoc($getsalesDetails)): 
                                extract($sales);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <!--<td>-->
                                <!--    <span class="badge bg-gradient-bloody text-white shadow-sm">-->
                                <!--        <?//= $sale_id ?>-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td>
                                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#info<?php echo $salesFetch['sale_id'];?>">
                                        <?= $customer_name; ?>
                                    </a>
                                </td>
                                
                                <td>
																<?= date('d M Y',strtotime($sdate))?>
															</td>
															<td>
																<?= $car_rental_amt?>
															</td>
															<td>
																<?= $driver_name?>
															</td>
															<td>
															    <?php if($car_rental_amt==''){?>
															    <?= $total?>
															    <?php }else {?>
																<?= $car_rental_amt + $total?>
																<?php } ?>
															</td>
															<td>
																<?= $advance?>
															</td>
															<td>
																<?= $balance?>
															</td>
															<td>
																<?= $pay_mode?>
															</td>
                                
                                <td>
									<a href="sales?sale_id=<?= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Edit Sale" data-original-title="Edit Sale"><i class="fa fa-edit text-info"></i></a>
									
									<a href="invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Invoice" data-original-title="Invoice"><i class="fa fa-print text-dark"></i></a>
									<a href="sales_advance_invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Advance Invoice" data-original-title="Advance Invoice"><i class="fa fa-print text-cyan"></i></a>
									<!--<a href="sales_delete?sid=<?php //echo $sale_id?>" class="text-inverse" title="Delete" data-bs-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash text-danger"></i></a>-->
									</td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>