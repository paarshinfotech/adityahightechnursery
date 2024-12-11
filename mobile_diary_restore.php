<?php require "config.php" ?>
<?php
Aditya::subtitle('मोबाइल डायरी यादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['mob_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['mob_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM mobile_diary WHERE mob_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE mobile_diary SET status='1' WHERE mob_id='{$dir}'");
    }
        if($delete){
    	header("Location: mobile_diary_list?action=Success&action_msg=मोबाइल डायरी पुनर्संचयित केले..!");
		exit();
        }else{
        header('Location: mobile_diary_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['mob_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['mob_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM mobile_diary WHERE mob_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE mobile_diary SET status='1' WHERE mob_id='{$dir}'");
    // }
        if($delete){
    	header("Location: mobile_diary_list?action=Success&action_msg=मोबाइल डायरी  हटवले..!");
		exit();
        }else{
        header('Location: mobile_diary_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">मोबाइल डायरी </h6>
            <a class="btn btn-sm btn-success float-end" href="mobile_diary_add" style="margin-top:-25px;">
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
			                            			<a title="मोबाइल डायरी  हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('मोबाइल डायरी  हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>मोबाइल डायरी  हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>नाव</th>
                                    <th>गाव</th>
                                    <th>मोबाईल</th>
                                    <th>व्हॉट्सअप नंबर</th>
                                    <th>व्यक्ती माहिती</
						   </tr>
						</thead>
						<tbody>
                            <?php $getMobDiary = mysqli_query($connect, "SELECT * FROM mobile_diary WHERE status='0' ORDER BY mob_id DESC") ?>
                            <?php if (mysqli_num_rows($getMobDiary)>0): ?>
                                <?php while ($mobDiary = mysqli_fetch_assoc($getMobDiary)): 
                                extract($mobDiary);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="mob_id[]" value="<?= $mob_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $mob_id ?>
                                    </span>
                                </td>
                               
                                <td>
                                    <a class="text-decoration-none" href="mobile_diary_add?mob_id=<?= $mob_id;?>">
                                        <?= $name; ?>
                                    </a>
                                </td>
                               
                                <td><?= $village;?></td>
                                <td><?= $mobile?></td>
                                <td><?= $whatsno?></td>
                                <td><?= $pep_info?></td>
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