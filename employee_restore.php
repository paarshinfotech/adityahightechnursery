<?php require "config.php" ?>
<?php
Aditya::subtitle('कर्मचारी यादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['emp_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['emp_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM employees WHERE emp_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE employees SET emp_status='1' WHERE emp_id='{$dir}'");
    }
        if($delete){
    	header("Location: employee_list?action=Success&action_msg=कर्मचारी पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: employee_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['emp_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['emp_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM employees WHERE emp_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE employees SET emp_status='1' WHERE emp_id='{$dir}'");
    // }
        if($delete){
    	header("Location: employee_list?action=Success&action_msg=कर्मचारी हटवले..!");
		exit();
        }else{
        header('Location: employee_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">कर्मचारी</h6>
            <a class="btn btn-sm btn-success float-end" href="employee_add" style="margin-top:-25px;">
			<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
		
		<!--<div class="dropdown-center">-->
  <!--             <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">-->
  <!--             <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>-->
  <!--                <ul class="dropdown-menu">-->
  <!--                  <li><a class="dropdown-item"  href="employee_add">नवीन तयार करा</a></li>-->
  <!--                  <li><a class="dropdown-item"  href="employee_list">सर्व बघा</a></li>-->
  <!--                  <li><a class="dropdown-item"  href="attendance">हजेरी</a></li>-->
  <!--                   <li><a class="dropdown-item" href="sallery">पगार</a></li>-->
  <!--                  <li><a class="dropdown-item"  href="pickup">उचल / ऍडव्हान / उसने</a></li>-->
                   

  <!--                </ul>-->
  <!--          </div>-->
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
			                            			<a title="कर्मचारी हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('कर्मचारी हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>कर्मचारी हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>आयडी</th>
                                    <th>कर्मचाऱ्याचे नाव</th
                                    >
                                    <th>मोबाईल नंबर</th>
                                    <th>इमेल आयडी</th>
                                    <th>लिंग</th>
                                    <th>प्रतिदिन पगार</th>
                                    <th>रुजू होण्याची तारीख</th
						   </tr>
						</thead>
						<tbody>
                            <?php $getEmp = mysqli_query($connect, "SELECT * FROM employees WHERE emp_status='0' ORDER BY emp_id DESC") ?>
                            <?php if (mysqli_num_rows($getEmp)>0): ?>
                                <?php while ($emp = mysqli_fetch_assoc($getEmp)): 
                                extract($emp);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="emp_id[]" value="<?= $emp_id ?>">
                                </td>
                                <td>
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $emp_id ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="employee_add?emp_id=<?= $emp_id;?>">
                                        <?= $emp_name; ?>
                                    </a>
                                </td>
                                
                                <td>
                                    <?= $emp_mobile; ?>
                                </td>
                                <td>
                                    <?= $emp_email; ?>
                                </td>
                                <td>
                                    <?= translate($emp_gender) ?>
                                </td>
                                <td>
                                    <?= $emp_salary ?>
                                </td>
                                <td>
                                    <?= date('d M Y',strtotime($emp_joined)) ?>
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