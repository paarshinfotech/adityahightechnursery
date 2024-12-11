<?php require "config.php" ?>
<?php
Aditya::subtitle('गाडी भाडे तपशील यादी');
if (isset($_GET['restore']) && isset($_GET['cr_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['cr_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE car_rental SET car_status='1' WHERE cr_id='{$dir}'");
    }
        if($delete){
    	header("Location: car_rental_category?action=Success&action_msg=गाडी भाडे तपशील पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: car_rental_category?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['cr_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['cr_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM car_rental WHERE cr_id='{$dir}'");
     }
        if($delete){
    	header("Location: car_rental_category?action=Success&action_msg=गाडी भाडे तपशील हटवले..!");
		exit();
        }else{
        header('Location: car_rental_category?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
if (isset($_POST['adv'])){
    escapeExtract($_POST);

     $carinsert= "INSERT INTO `car_rental_adv`(adv_cr_id,advdate,advrs,reason) VALUES ('$cr_id','$advdate','$advrs','$reason')";

    $rescar=mysqli_query($connect,$carinsert);
    $adv_id=mysqli_insert_id($connect);
    
    mysqli_query($connect, "UPDATE car_rental SET deposit_rs = deposit_rs - {$advrs} WHERE cr_id = '{$cr_id}'");

    if($rescar){
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header('Location: car_rental_restore?action=Success&action_msg=ग्राहकाचे ₹ '.$advrs.' /- जमा झाले');
        exit();
    }
    else{
        header('Location: car_rental_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">गाडी भाडे तपशील </h6>
            <div class="dropdown-center">
               <a href="car_rental_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="car_rental_add">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv">ऍडव्हान्स</a></li>
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
			                            			<a title="गाडी भाडे तपशील हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('गाडी भाडे तपशील हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>गाडी भाडे तपशील हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>तारीख</th>
                                    <th>गावाचे नाव</th>
                                    <th>श्रेणी</th>
                                    <th>भाड्याने गाडी</th>
                                    <th>उचल डिझेल</th>
                                    <th>शिल्लक रुपये</th>
                                    <th>नाव</th>
                                    <th>ऍडव्हान्स रु</th>
                                   
                                    <th>ऍडव्हान्स तारीख</th>
                                   
                                    <!--<th>Reason</th>-->
                                    
                                    <th>क्रिया</th>						
                                    </tr>
						</thead>
						<tbody>
						    <?php
						   // if(isset($_GET['car_cat_id'])){
                            $getcar_rental="select * from car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.adv_cr_id INNER JOIN car_rental_category r ON c.car_cat_id=r.car_cat_id and c.car_status='0' group by c.cr_id DESC";
                            $view=mysqli_query($connect,$getcar_rental);
						    ?>
                            <?php if (mysqli_num_rows($view)>0): ?>
                                <?php 
                                $carList = array();
                                while ($rowcar_rental = mysqli_fetch_assoc($view)): 
                                array_push($carList, $rowcar_rental);
                                extract($rowcar_rental);
                                
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="cr_id[]" value="<?= $cr_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $cr_id ?>
                                    </span>
                                </td>
                                               
                                                <td><?= date('d M Y',strtotime($cdate));?></td>
                                                <td><?= $village_name?></td>
                                                 <td>
                                                    <a class="text-decoration-none" href="car_rental_add?cr_id=<?= $cr_id;?>">
                                                        <?= $cat_name;?>
                                                    </a>
                                                </td>
                                                <td><?= $car_rental?></td>
                                                <td><?= $pick_up_diesel?></td>
                                                <td><?= $deposit_rs?></td>
                                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $rowcar_rental['cr_id'];?>" class="text-success"><?= $name?></td>
                                                <td><?= $advrs?></td>
                                               
                                                <td><?= $advdate?></td>
                                                <!--<td><?//= $reason?></td>-->
                                               
                                                <td>
                                                    <a href="car_rental_invoice?cr_id=<?php echo $cr_id?>&adv_id=<?= $adv_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i class="fa fa-print"></i></a> 
                                                    <a href="car_rental_add?cr_id=<?php echo $cr_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a> 
                                                </td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
                            <?php //} ?>
						</tbody>
						<?php
                                            $adv=mysqli_query($connect,"SELECT advrs FROM car_rental_adv");
                                            
                                             $getadvrs=mysqli_fetch_assoc($adv);
                                             
                                              $getadv=mysqli_query($connect,"SELECT SUM(advrs) as totadv FROM car_rental_adv a,car_rental c WHERE a.adv_cr_id=c.cr_id and c.car_status='0'");
                                        $advtotal=mysqli_fetch_assoc($getadv);
                                           
                                             $gettotal=mysqli_query($connect,"SELECT SUM(car_rental) as totcar_rental FROM car_rental WHERE  car_status='0'");
                                        $total=mysqli_fetch_assoc($gettotal);
                                       
                                       $getpick=mysqli_query($connect,"SELECT SUM(pick_up_diesel) as totpick_up_diesel FROM car_rental WHERE car_status='0'");
                                        $totpick=mysqli_fetch_assoc($getpick);
                                        
                                         $getdep=mysqli_query($connect,"SELECT SUM(deposit_rs) as totdeposit_rs FROM car_rental WHERE car_status='0'");
                                        $totdep=mysqli_fetch_assoc($getdep);
                                        ?>
                                            <tr>
                                               
                                                <th colspan="4" class="text-center fs-6">Total</th>
                                                <th>₹ <?= $total['totcar_rental'] ?>/-</th>
                                                <th>₹ <?= $totpick['totpick_up_diesel'] ?>/-</th>
                                                <th>₹ <?= $totdep['totdeposit_rs'] ?>/-</th>
                                              
                                                <th></th>
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
<!--Details Info Modal-->
        <?php 
        error_reporting(0);
        foreach ($carList as $rowcar_rental): ?>
                    <?php extract($rowcar_rental);
                     $totBal1 = $deposit_rs-$advrs;
                    ?>
         <div class="modal fade" id="info<?php echo $cr_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $cr_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $cr_id;?>">
कर्मचारी माहिती</h5>
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
						        						<span><?= $name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $con?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($cdate));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गावाचे नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>श्रेणीचे नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $cat_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गाडी भाडे</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span>₹ <?= $car_rental?>/-</span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>उचल डिझेल</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span>₹ <?= $pick_up_diesel?>/-</span>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">इतर माहिती</h6>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        				    <th>ऍडव्हान्स तारीख</th>
						        				    <th>ऍडव्हान्स रु</th>
						        				    <th>कारण</th>
						        				</tr>
						        				<tr>
						        				    <?php 
						        				    error_reporting(0);
						        				    $advcar=mysqli_query($connect,"select * from car_rental_adv WHERE adv_cr_id='$cr_id' order by adv_id DESC");
						        				    while($_resadv=mysqli_fetch_assoc($advcar)):
						        				 //extract($_resadv);   
						        				   ?>
						        				    <td><?= date('d M Y',strtotime($_resadv['advdate']))?></td>
						        				    <td><?= $_resadv['advrs']?></td>
						        				    <td><?= $_resadv['reason']?></td>
						        				</tr>
						        			<?php $sumAdv=mysqli_query($connect,"SELECT SUM(advrs) as sumADV FROM `car_rental_adv` WHERE adv_cr_id='$cr_id'");
						        				$rSumAdv=mysqli_fetch_assoc($sumAdv);
						        				?>
						        				<?php endwhile?>
						        				
						        				<tr>
                                                  <th colspan="1">एकूण ऍडव्हान्स</th>
                                                  <td>₹ <?= $rSumAdv['sumADV'];?>/-              </td>
                                                  <td></td>
                                                </tr>
						        				<tr>
                                                  <th colspan="1">एकूण शिल्लक</th>
                                                  <td>₹ <?= $deposit_rs?>/-              </td>
                                                  <td></td>
                                                </tr>
						        				
						        			</tbody>
						        		</table>
						        	</div>
                                </div>
                            </div>
                        </div>
                        </div>
       <?php endforeach?>
       
       <!--Advance modal-->
         <div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="advLabel">ऍडव्हान्स
</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form method="post">
                          <div class="mb-3">
                            <label for="adate" class="col-form-label">नाव</label>
                            	<select name="cr_id" class="form-control mb-3" required><option>कर्मचारी निवडा</option>	
                										<?php $getcustomert = mysqli_query($connect,"SELECT * from car_rental") ?>
                																	<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
                																		<?php while ($getcus=mysqli_fetch_assoc($getcustomert)):?>
                																		<option value="<?= $getcus['cr_id'] ?>"><?= $getcus['name'] ?></option>
                																		<?php endwhile ?>
                																	<?php endif ?>
                					</select>
                                </div>
                                  <div class="mb-3">
                                    <label for="adate" class="col-form-label">तारीख</label>
                                    <input type="date" class="form-control" id="adate" name="advdate" value="<?php echo date('Y-m-d')?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="rs" class="col-form-label">रुपये</label>
                                    <input type="text" class="form-control" id="rs" name="advrs" oninput="allowType(event,'number')">
                                  </div>
                                  <div class="mb-3">
                                    <label for="pick_up_extra" class="col-form-label">कारण</label>
                                    <input type="text" class="form-control" id="pick_up_extra" name="reason">
                                  </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                        <button type="submit" name="adv" class="btn btn-primary">जतन करा</button>
                         
                      </div>
                    </div>
                  </div>
                </div>
                                                        
                                                        
                </form>
                    </div>
                </div>
            </div>
        </div>
<?php include "footer.php"; ?>