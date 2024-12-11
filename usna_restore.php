<?php require "config.php" ?>
<?php
Aditya::subtitle('उसना व्यवहार यादी');
$nav_tabs = array(
	'Inward' => false,
	'expense' => false,
	'bank' => false,
	'cash' => false,
	'income' => false,
	'usana' => false,
);
if (isset($_GET['show_inward'])) {
	$nav_tabs['Inward'] = true;
} elseif (isset($_GET['show_expense'])) {
	$nav_tabs['expense'] = true;
} elseif (isset($_GET['show_bank'])) {
	$nav_tabs['bank'] = true;
} elseif (isset($_GET['show_cash'])) {
	$nav_tabs['cash'] = true;
} elseif (isset($_GET['show_income'])) {
	$nav_tabs['income'] = true;
} elseif (isset($_GET['show_usana'])) {
	$nav_tabs['usana'] = true;
} else {
	$nav_tabs['Inward'] = true;
}
//restore 
if (isset($_GET['restore']) && isset($_GET['bo_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['bo_id'] as $dir){
     $delete = mysqli_query($connect, "UPDATE borrowing SET bo_status='1' WHERE inward_id='{$dir}'");
    }
        if($delete){
    	header("Location: oneday_add?show_usana=true&action=Success&action_msg=उसना व्यवहार  पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: oneday_add?show_usana=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['bo_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['bo_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM borrowing WHERE inward_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE customer SET bo_status='1' WHERE inward_id='{$dir}'");
    // }
        if($delete){
    	header("Location: oneday_add?show_usana=true&action=Success&action_msg=उसना व्यवहार  हटवले..!");
		exit();
        }else{
        header('Location: oneday_add?show_usana=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">उसना व्यवहार </h6>
            <a class="btn btn-sm btn-success float-end" href="oneday_add" style="margin-top:-25px;">
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
                        <!--<div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">-->
                        <!--    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
                        <!--        <div class="modal-content">-->
                        <!--            <div class="modal-header">-->
                        <!--                <h5 class="modal-title" id="filterModalLabel">Filters</h5>-->
                        <!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                        <!--            </div>-->
                        <!--            <div class="modal-body">-->
                        <!--                <form id="vendor-filters-form" class="row g-3">-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">Filter by city</label>-->
                        <!--                        <select class="form-select" id="vendor-filter-city">-->
                        <!--                            <option value="">All</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">Filter by pin</label>-->
                        <!--                        <select class="form-select" id="vendor-filter-pin">-->
                        <!--                            <option value="">All</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">Filter by category</label>-->
                        <!--                        <select class="form-select" id="vendor-filter-cat">-->
                        <!--                            <option value="">All</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">Filter by subscription</label>-->
                        <!--                        <select class="form-select" id="vendor-filter-sub">-->
                        <!--                            <option value="">All</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                    <div class="col-12">-->
                        <!--                        <label class="form-label">Filter by status</label>-->
                        <!--                        <select class="form-select" id="vendor-filter-status">-->
                        <!--                            <option value="">All</option>-->
                        <!--                        </select>-->
                        <!--                    </div>-->
                        <!--                </form>-->
                        <!--            </div>-->
                        <!--            <div class="modal-footer border-top-0">-->
                        <!--                <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>-->
                        <!--                <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>-->
                        <!--                <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
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
			                            	<ul class="dropdown-menu" aria-labelledby="category-action" style="margin: 0px; position: absolute; inset: 0px auto auto 0px; transform: translate(0px, 35px);">
			                            		<li>
			                            			<a title="पुनर्संचयित करा" class="multi-action-btn dropdown-item text-success" data-multi-action="restore" data-multi-action-page="" href="?restore=true" ONCLICK="RETURN CONFIRM('पुनर्संचयित करा..?');">
			                            				<i class="btn-round bx bx-recycle me-2"></i>पुनर्संचयित करा 
			                            			</a>
			                            			</li>
			                            			<li>
			                            			<a title="उसना व्यवहार  हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('उसना व्यवहार  हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>उसना व्यवहार  हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    						    <th>तारीख</th>
                                <th>नाव</th>
                                <th>मोबाईल</th>
                                <th>रुपये</th>
                                <th>प्राप्त तारीख</th>
                                <th>प्राप्त रुपये</t>
						   </tr>
						</thead>
							<tbody>
                                <?php $getBrand = mysqli_query($connect, "select * from borrowing WHERE bo_status='0' ORDER BY inward_id DESC") ?>
                                <?php if (mysqli_num_rows($getBrand)>0): ?>
                                    <?php while ($brand = mysqli_fetch_assoc($getBrand)): 
                                    extract($brand);
                                    ?>
                                    <tr>
                                    <td class="form-group">
                                        <input type="checkbox" class="multi-check-item" name="bo_id[]" value="<?= $inward_id ?>">
                                        <span class="badge bg-gradient-bloody text-white shadow-sm">
                                            <?= $inward_id ?>
                                        </span>
                                    </td>
                                  
                                    <td>
                                        <a class="text-decoration-none" href="?show_usana=true&bo_id=<?= $inward_id;?>">
                                            
                                            <?= date('d M Y',strtotime($idate)); ?>
                                        </a>
                                    </td>
                                    <td><a class="text-decoration-none" href="?show_usana=true&bo_id=<?= $inward_id;?>"><?= $inward?></a></td>
                                     <td><?= $contact?></td>
                                                <td>₹ <?= $inward_rs?>/-</td>
                                                <td><?= date('d M Y',strtotime($receive_date))?></td>
                                                <td>₹ <?= $receive_rs?>/-</td>
                                                       
                                </tr>
                                    <?php endwhile ?>
                                <?php endif ?>
    						</tbody>
    						 <?php $getbo=mysqli_query($connect,"SELECT SUM(inward_rs) as totb FROM borrowing WHERE bo_status='0' ");
                                        $totalbo=mysqli_fetch_assoc($getbo);
                                       
                                       $getSrec=mysqli_query($connect,"SELECT SUM(receive_rs) as totrecrs FROM borrowing WHERE bo_status='0'");
                                        $totBres=mysqli_fetch_assoc($getSrec)
                                        ?>
                                            <tr>
                                                <th colspan="4" class="text-center fs-6">एकूण</th>
                                               
                                                <th class="text-nowrap">₹ <?= $totalbo['totb'] ?>/-</th>
                                               <td></td>
                                                <th class="text-nowrap">₹ <?= $totBres['totrecrs'] ?>/-</th>
                                                
                                            </tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>