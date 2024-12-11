<?php require "config.php" ?>
<?php
Aditya::subtitle('झेंडू उपवर्ग श्रेणी यादी');
if (isset($_GET['restore']) && isset($_GET['subcat_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['subcat_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE marigold_subcategory SET sub_cat_status='1' WHERE subcat_id='{$dir}'");
    }
        if($delete){
    	header("Location: zendu_subcat_list?action=Success&action_msg=झेंडू उपवर्ग  श्रेणी पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: zendu_subcat_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['subcat_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['subcat_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM marigold_subcategory WHERE subcat_id='{$dir}'");
     }
        if($delete){
    	header("Location: zendu_subcat_list?action=Success&action_msg=झेंडू उपवर्ग  श्रेणी् हटवले..!");
		exit();
        }else{
        header('Location: zendu_subcat_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">झेंडू उपवर्ग  श्रेणी </h6>
            <a class="btn btn-sm btn-success float-end" href="zendu_subcat_add" style="margin-top:-25px;">
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
			                            			<a title="झेंडू उपवर्ग  श्रेणी हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('झेंडू उपवर्ग  श्रेणी हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>झेंडू उपवर्ग  श्रेणी हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>वनस्पती प्रकार</th>    				
    							    <th>श्रेणीचे नाव</th>
                                    <th>झेंडू उपवर्ग श्रेणीचे नाव</th
                                    >
                                    <th>संख्या</th>
                                    <th>तारीख</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getBrand = mysqli_query($connect, "select * from marigold_category c,marigold_subcategory s, plant_type p where c.cat_id=s.cat_id and sub_cat_status='0' and p.pt_id=s.pt_id ORDER BY s.subcat_id DESC") ?>
                            <?php if (mysqli_num_rows($getBrand)>0): ?>
                                <?php while ($brand = mysqli_fetch_assoc($getBrand)): 
                                extract($brand);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="subcat_id[]" value="<?= $subcat_id ?>">
                                     <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $subcat_id ?>
                                    </span>
                                </td>
                                <td>
                                   <?= $pt_name;?>
                                </td>
                                <td><?= $cat_name;?></td>
                                <td>
                                    <a class="text-decoration-none" href="zendu_subcat_add?subcat_id=<?= $subcat_id;?>">
                                        <?= $subcat_name; ?>
                                    </a>
                                </td>
                                <td><?= $subcat_qty?></td>
                                <td><?= date('d M Y',strtotime($subcat_date))?></td> 
                
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