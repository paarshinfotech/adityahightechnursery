<?php require "config.php" ?>
<?php
Aditya::subtitle('उधारी तपशीलयादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['ald_id'])){
    escapePOST($_GET);
    foreach ($_GET['ald_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE ald_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE all_loan_details SET loan_status='1' WHERE ald_id='{$dir}'");
    }
        if($delete){
    	header("Location: all_loan_details_list?action=Success&action_msg=उधारी तपशील पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: all_loan_details_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['ald_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['ald_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM all_loan_details WHERE ald_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE customer SET loan_status='1' WHERE ald_id='{$dir}'");
    // }
        if($delete){
    	header("Location: all_loan_details_list?action=Success&action_msg=उधारी तपशील हटवले..!");
		exit();
        }else{
        header('Location: all_loan_details_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

if (isset($_POST['deposit'])){
    escapeExtract($_POST);
    
    $editdeposit = mysqli_query($connect,"UPDATE all_loan_details SET 
           ddate = '".date('Y-m-d')."',
           pending_amt='$deposit_again',
           deposit_again ='$deposit_again',
           again_pending = '$bal_amt'
           WHERE ald_id ='$ald_id'");

    if($editdeposit)
    {
        header('Location: all_loan_details_list?action=Success&action_msg=ग्राहकाची ₹ '.$deposit_again.' /- जमा झाले');
        exit();
    }
    else{
        header('Location: all_loan_details_list?action=Success&action_msg=somthing went wrong');
      	exit();
    }
}
?>
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">उधारी तपशील</h6>
   <!--         <a class="btn btn-sm btn-success float-end" href="sal_car_add" style="margin-top:-25px;">-->
			<!--<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>-->
			<div class="dropdown-center">
               <a href="all_loan_details_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="all_loan_details_add">नवीन तयार करा</a></li>
                     <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv">ठेव</a></li>
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
			                            			<a title="उधारी तपशील हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('उधारी तपशील हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>उधारी तपशील हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>नाव</th>
                                                <th>एकूण रक्कम</th>
                                                <th>ठेव रक्कम</th>
                                                <th>प्रलंबित रक्कम</th>
                                                <th>पुन्हा ठेव</th>
                                                <th>पुन्हा प्रलंबित रक्कम</th>
                                                <th>तारीख</th>
                                                <th>गाव</th>
                                                <th>मोबाईल</th>
                                                <th>वर्णन वनस्पती</th>
                                                <th>तारीख दिली</th>
                                                <th>वितरण तारीख</th>
                                                <th>शून्य</th>
                                                
                                                <th>कृती</th>
						   </tr>
						</thead>
					<tbody>
                            <?php $getDetails="select * from all_loan_details where loan_status='0' order by ald_date DESC";
                                    $resDetails=mysqli_query($connect,$getDetails);
                                    if (mysqli_num_rows($resDetails)>0): 
                                        
                                    $infoList = array();
                                    while($fetch=mysqli_fetch_assoc($resDetails)):
                                    array_push($infoList, $fetch);
                                    extract($fetch);
                                ?>
                               
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="ald_id[]" value="<?= $ald_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $ald_id ?>
                                    </span>
                                </td>
                                               
                                                
                                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $fetch['ald_id'];?>"class="text-success"><?= $far_name?></td>
                                               
                                                <td><?= $total_amt?></td>
                                                <td><?= $deposit_amt?></td> 
                                                <td><?= $pending_amt?></td>
                                                <td><?= $deposit_again?></td>
                                                <td><?= $again_pending?></td>
                                                <td><?= date('d M Y',strtotime($ald_date));?></td>
                                                <td><?= $village?></td>
                                                 <td>
                                                    <a class="text-decoration-none" href="all_loan_details_add?ald_id=<?= $ald_id;?>">
                                                    <?= $mob_no;?></a></td>
                                                
                                                <td><?= $des_plant?></td>
                                                <?php if($given_date=='0000-00-00'){?>
                                                <td>NULL</td>
                                                <?php } else{?>
                                                <td><?= date('d M Y',strtotime($given_date))?></td>
                                                <?php } ?>
                                                
                                                <?php if($deli_date=='0000-00-00'){?>
                                                <td>NULL</td>
                                                <?php } else{?>
                                                <td><?= date('d M Y',strtotime($deli_date))?></td>
                                                <?php } ?>
                                                <td><?= $nill?></td>
                                                
                                                <td>
                                                    <a href="all_loan_invoice.php?ald_id=<?php echo $ald_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i class="fa fa-print"></i></a> 
                                                    <a href="all_loan_details_add?ald_id=<?php echo $ald_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a> 
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

<!--deposit_modal-->
<div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="advLabel">ग्राहक ठेव</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <form method="post" id="depositeLoan">
          <div class="mb-3">
            <label for="adate" class="col-form-label">नाव</label>
            	<select name="ald_id" class="form-control mb-3 ald_id" required><option>Select Users</option>	
										<?php $getcustomert = mysqli_query($connect,"SELECT * from all_loan_details") ?>
																	<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcustomert)):?>
																		<option value="<?= $getcus['ald_id'] ?>"><?= $getcus['far_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
          </div>
          <div class="mb-3">
            <label for="adate" class="col-form-label">तारीख</label>
            <input type="date" class="form-control" id="ddate" name="advdate" value="<?php echo date('Y-m-d')?>">
          </div>
          <div class="mb-3">
            <label for="rs" class="col-form-label">प्रलंबित रक्कम</label>
            <input type="text" class="form-control pending_amt" id="pending_amt" name="pending_amt" readonly>
          </div>
          <div class="mb-3">
            <label for="rs" class="col-form-label">ठेव</label>
            <input type="text" class="form-control deposit_again" id="deposit_again" name="deposit_again" oninput="allowType(event, 'number')">
          </div>
          <div class="mb-3">
            <label for="rs" class="col-form-label">शिल्लक</label>
            <input type="text" class="form-control finally_left" id="finally_left" name="bal_amt" readonly>
          </div>
       
      </div>
      
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="deposit" form="depositeLoan" class="btn btn-success">जतन करा</button>
            </div>
    </div>
</div>
</div>       


<?php foreach ($infoList as $fetch): ?>
                    <?php extract($fetch);
                    ?>
         <div class="modal fade" id="info<?php echo $ald_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $ald_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $ald_id;?>">शेतकऱ्याची माहिती</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $far_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $mob_no?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($ald_date));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गावाचे नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">वनस्पतींचे वर्णन</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>वनस्पती</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					   
						        				<span><?= $des_plant?></span>
						        					</td>
						        				</tr>
						        				
						        					<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">खात्याची माहिती</h6>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>एकूण रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $total_amt?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>आगाऊ रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $deposit_amt?></span>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>प्रलंबित रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($pending_amt==0){?>
						        						<span>0</span><?php }else{?>
						        						<span><?= $pending_amt?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Deposit Date</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span>-->
						        				<!--		    <?= date('d M Y',strtotime($ddate))?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        				<tr>
						        					<td>
						        						<strong>पुन्हा ठेव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($deposit_again==0){?>
						        						<span>0</span><?php } else{?>
						        						<span><?= $deposit_again?></span><?php } ?>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>बाकी रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($again_pending==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span><?= $again_pending?></span><?php } ?>
						        					</td>
						        				</tr>
						        			
						        			
						        			</tbody>
						        		</table>
						        	</div>
                                </div>
                            </div>
                        </div>
                        </div>
<?php endforeach?>
<script>
 $(document).ready(function(){
    $("select.ald_id").change(function(){
          var x = $(".ald_id option:selected").val();
          //alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { pamt : x  } 
          }).done(function(data){
              $("#pending_amt").val(data);
          });
      });
  });
$(document).ready(function() {
    $(".pending_amt, .deposit_again").on("input", sub_deposit);
});  
function sub_deposit() {
    let tamt = $('.pending_amt').val();
    let aamt = $('.deposit_again').val();
    let result1 = Number(tamt) - Number(aamt);
    $('.finally_left').val(!isNaN(result1) ? result1 : 0).trigger('change');
}
</script>
<?php include "footer.php"; ?>