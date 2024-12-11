<?php require "config.php" ?>
<?php
Aditya::subtitle('खर्च यादी');
if (isset($_GET['restore']) && isset($_GET['ex_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['ex_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE expenses SET ex_status='1' WHERE ex_id='{$dir}'");
    }
        if($delete){
    	header("Location: expenses_category?action=Success&action_msg=खर्च पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: expenses_category?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['ex_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['ex_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM expenses WHERE ex_id='{$dir}'");
     }
        if($delete){
    	header("Location: expenses_category?action=Success&action_msg=खर्च हटवले..!");
		exit();
        }else{
        header('Location: expenses_category?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">खर्च </h6>
            <a class="btn btn-sm btn-success float-end" href="expenses_add" style="margin-top:-25px;">
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
			                            			<a title="खर्च हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('खर्च हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>खर्च हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>श्रेणीचे नाव</th>
                                    <th>नाव</th>
                                    <th>खर्चाचे कारण</th>
                                    <th>खर्चाचा प्रकार</th>
                                    <th>रक्कम</th>
                                    <th>पेमेंट मोड</th>
                                    <th>तारीख</th>
                                    <th>खर्च बीजक</th>
						   </tr>
						</thead>
						<tbody>
						    <?php
						  //  if(isset($_GET['ex_cat_id'])){
                            $getexpenses="select * from expenses e,expenses_category c WHERE c.ex_cat_id=e.ex_cat_id and ex_status='0' order by e.ex_date DESC";
                            $view=mysqli_query($connect,$getexpenses);
						    ?>
                            <?php if (mysqli_num_rows($view)>0): ?>
                                <?php while ($rowExpenses = mysqli_fetch_assoc($view)): 
                                extract($rowExpenses);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="ex_id[]" value="<?= $ex_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $ex_id ?>
                                    </span>
                                </td>
                                <td><?= $ex_cat_name;?></td>
                                <td>
                                    <a class="text-decoration-none" href="expenses_add?ex_id=<?= $ex_id;?>">
                                        <?= $ex_name; ?>
                                    </a>
                                </td>
                                               
                                                <td><?= $ex_for;?></td>
                                                <td><?= $ex_type;?></td>
                                                <td><?= $ex_amt?></td>
                                                <td><?= $payment_mode?></td>
                                                <td><?= date('d M Y',strtotime($ex_date))?></td>
                                                <td>
												<?php if ($ex_invoice && !empty($ex_invoice)): ?>
												<a title="Invoice" class="btn bg-light btn-sm text-dark" href="image/expense/<?= $ex_invoice ?>" target="_blank">View</a>
												<?php endif ?>
											</td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
                            <?php //} ?>
						</tbody>
						<!--ex_cat_id='{$ex_cat_id}' and-->
						<?php $gettotal=mysqli_query($connect,"SELECT SUM(ex_amt) as totexpense FROM expenses where ex_status='0'");
                                        $totaltotexpense=mysqli_fetch_assoc($gettotal);
                                        ?>
                                            <tr>
                                                <th colspan="4" class="text-center fs-6">Total</th>
                                                <th></th> 
                                                <th class="text-nowrap">₹ <?= $totaltotexpense['totexpense'] ?>/-</th>
                                               
                                               <th></th> 
                                               <th></th> 
                                               <th></th> 
                                            </tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>