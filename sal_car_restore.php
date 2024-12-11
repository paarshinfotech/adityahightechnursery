<?php require "config.php" ?>
<?php
Aditya::subtitle('साल कार यादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['sal_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sal_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE sal_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE salcar SET salcar_status='1' WHERE sal_id='{$dir}'");
    }
        if($delete){
    	header("Location: sal_car_list?action=Success&action_msg=साल कार  पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: sal_car_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['sal_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sal_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM salcar WHERE sal_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE customer SET salcar_status='1' WHERE sal_id='{$dir}'");
    // }
        if($delete){
    	header("Location: sal_car_list?action=Success&action_msg=साल कार  हटवले..!");
		exit();
        }else{
        header('Location: sal_car_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}


//add attendance
if (isset($_POST['sal_car_atten'])){
    escapeExtract($_POST);
     $atten= "INSERT INTO salcar_atten(sal_id, jdate, is_present,leave_reason) VALUES ('$sal_id','$jdate','$is_present','$lreason')";
    $resempa=mysqli_query($connect,$atten);
    if($resempa){
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header('Location: sal_car_list');
    }else{
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
      	exit();
    }
}

//sallery
if (isset($_POST['sallery'])){
    escapeExtract($_POST);

     $atten= "INSERT INTO `salcar_sallery`(ma_id,sdate,total_days,daily_rs, total_amt) VALUES ('$ma_id','$sdate','$total_days','$daily_rs','$total_amt')";

    $resempa=mysqli_query($connect,$atten);


    if($resempa){
        header('Location: sal_car_list');
    }else{
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
      	exit();
    }
}

//pick up rs
if (isset($_POST['pickup'])){
    escapeExtract($_POST);

     $atten= "INSERT INTO salcar_pickup_rs(ma_id, total_amt, pickup_rs, pdate, balance_rs, reason) VALUES ('$ma_id','$total_amt','$pickup_rs','$pdate','$balance_rs','$reason')";
    $respick=mysqli_query($connect,$atten);
    mysqli_query($connect,"UPDATE salcar_sallery SET total_amt=total_amt-$pickup_rs");
    if($respick){
        header('Location: sal_car_list');
    }else{
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
      	exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">साल कार </h6>
   <!--         <a class="btn btn-sm btn-success float-end" href="sal_car_add" style="margin-top:-25px;">-->
			<!--<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>-->
			<div class="dropdown-center">
               <a href="sal_car_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="sal_car_add">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#male_attendance" data-bs-whatever="@mdo">उपस्थिती</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sal" data-bs-whatever="@mdo">सॅलरी</a></li>
                    
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pickup" data-bs-whatever="@mdo">उचल रु</a></li>
                    
                    <!--<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#gave" data-bs-whatever="@mdo">Gave</a></li>-->
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
			                            			<a title="साल कार  हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('साल कार  हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>साल कार  हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								</th>
    								<th>कामगाराचे नाव</th>
                                    <th>मोबाईल नंबर</th>
                                    <th>तारीख</th>
                                    <th>पगार रु</th>
                                    <!--<th>Reason</th>-->
                                    <!--<th>Leave</th>-->
                                    <!--<th>Leave Date</th>-->
                                    <!--<th>Leave Reason</th>-->
						   </tr>
						</thead>
					<tbody>
                            <?php $getsalcar="select * from salcar where salcar_status='0' order by sal_id DESC";
                                    $resSalcar=mysqli_query($connect,$getsalcar);
                                    if (mysqli_num_rows($resSalcar)>0): 
                                        
                                    $carList = array();
                                    while($fetch=mysqli_fetch_assoc($resSalcar)):
                                    array_push($carList, $fetch);
                                    extract($fetch);
                                ?>
                               
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sal_id[]" value="<?= $sal_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sal_id ?>
                                    </span>
                                </td>
                                
                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $fetch['sal_id'];?>" class="text-success"><?= $worker_name;?></td>
                                                <td>
                                                    <a class="text-decoration-none" href="sal_car_add?sal_id=<?= $sal_id;?>">
                                                    <?= $contact;?></a></td>
                                                <td><?= date('d M Y',strtotime($sdate));?></td>
                                                <td><?= $sallery;?></td>
                                                <!--<td><?//= $pick_up_rs?></td>-->
                                                <!--<td><?//= $reason?></td>-->
                                                <!--<td><?//= $leave?></td>-->
                                                <!--<td><?//= $date_leave?></td>-->
                                                <!-- <td><?//= $reason_leave?></td>-->
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

<!--attendance_modal-->
<div class="modal fade" id="male_attendance" tabindex="-1" aria-labelledby="male_attendanceLabel" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="male_attendanceLabel">कामगारांची उपस्थिती</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <form method="post" id="salcaratten">
                <div class="mb-3">
            <label for="sal_id" class="col-form-label">नाव</label>
            	<select name="sal_id" id="sal_id" class="form-control mb-3" required><option>कामगार निवडा</option>	
										<?php $getemp = mysqli_query($connect,"SELECT * from salcar ORDER BY sal_id DESC") ?>
																	<?php if ($getemp && mysqli_num_rows($getemp)): ?>
																		<?php while ($gete=mysqli_fetch_assoc($getemp)):?>
																		<option value="<?= $gete['sal_id'] ?>"><?= $gete['worker_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                </div>
                <div class="mb-3">
            <label for="jdate" class="col-form-label">तारीख</label>
            <input type="date" class="form-control" id="jdate" name="jdate" value="<?php echo date('Y-m-d')?>" required>
          </div>
                <div class="mb-3">
            <div class="form-check-inline">
                <div class="form-group">
                 <input required="" type="radio" onclick="javascript:yesnoCheck();" name="is_present" id="noCheck" value="present" checked> 
                   <label for="noCheck"> उपस्थित</label>
                   
                    <input type="radio" onclick="javascript:yesnoCheck();" name="is_present" id="yesCheck" value="absent"><label for="yesCheck" class="ms-1"> अनुपस्थित</label>
                </div>    
            </div>        
            <div id="ifYes" style="visibility:hidden">
            <input type="text" name='lreason' placeholder="अनुपस्थित कारण" class='form-control mt-2'>
            </div> 
          </div>
            </form>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="sal_car_atten" form="salcaratten" class="btn btn-success">जतन करा</button>
            </div>
    </div>
</div>
</div>       

<!--Sallery modal-->
<div class="modal fade" id="sal" tabindex="-1" aria-labelledby="salLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="salLabel">कामगार उपस्थिती सॅलरी</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="male_sal">
          <div class="row">
              <div class="col-12 col-lg-6">
                  <div class="mb-3">
                    <label for="adate" class="col-form-label">नाव</label>
            	    <select name="ma_id" id="ma_id" class="form-control mb-3 sal_id" required onchange="mul(this)"><option>कामगार निवडा</option>	
										<?php $getemp = mysqli_query($connect,"SELECT * from salcar d,salcar_atten e WHERE e.sal_id=d.sal_id GROUP BY d.sal_id DESC") ?>
																	<?php if ($getemp && mysqli_num_rows($getemp)): ?>
																		<?php while ($gete=mysqli_fetch_assoc($getemp)):?>
																		<option value="<?= $gete['sal_id'] ?>"><?= $gete['worker_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                  <div class="mb-3">
                <label for="adate" class="col-form-label">तारीख</label>
                <input type="date" class="form-control" id="adate" name="sdate" value="<?php echo date('Y-m-d')?>">
              </div>
              </div>
            </div>
            <div class="row">
                 <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="amt" class="form-label">एकूण कामकाजाचे दिवस<span class="text-danger">*</span></label>
                <input type="text" name="total_days" class="form-control wdays" id="total_days" placeholder="एकूण दिवस" required oninput="allowType(event, 'number')">
                            </div>
                                            </div>   
                                            <div class="col-12 col-md-6">

                                                <div class="form-group">
                                                    <label for="daily_rs" class="form-label">पगार रु<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control salrs" name="daily_rs" id="daily_rs" required oninput="allowType(event, 'number')">
                                                </div>
                                            </div>
                                            </div>
                            
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                        <label for="total_amt" class="form-label">एकूण सॅलरी रक्कम<span class="text-danger">*</span></label>
                        <input type="text" name="total_amt" class="form-control" id="total_amt" placeholder="एकूण सॅलरी रक्कम" required readonly>
                        </div>
                    </div>
          </form>
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
        <button type="submit" name="sallery" form="male_sal" class="btn btn-success">जतन करा</button>
             </div>
        </div>
    </div>
</div>

<!--pickuprs-->
<div class="modal fade" id="pickup" tabindex="-1" aria-labelledby="pickupLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pickupLabel">उचल रु</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" id="pickuprs">
          <div class="row">
              <div class="col-12 col-lg-6">
                  <div class="mb-3">
                    <label for="adate" class="col-form-label">नाव</label>
            	    <select name="ma_id" id="ma_id" class="form-control mb-3 ma_id wrsal" required><option>कामगार निवडा</option>	
										<?php $getemp = mysqli_query($connect,"SELECT * from salcar_sallery d,salcar e WHERE e.sal_id=d.ma_id GROUP BY d.ma_id DESC") ?>
																	<?php if ($getemp && mysqli_num_rows($getemp)): ?>
																		<?php while ($gete=mysqli_fetch_assoc($getemp)):?>
																		<option value="<?= $gete['sal_id'] ?>"><?= $gete['worker_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
					</select>
                </div>
              </div>
              <div class="col-12 col-lg-6">
                  <div class="mb-3">
                <label for="adate" class="col-form-label">उचल तारीख</label>
                <input type="date" class="form-control" id="adate" name="pdate" value="<?php echo date('Y-m-d')?>">
              </div>
              </div>
              
              <div class="col-12 col-md-6 mt-2">
                    <div class="form-group">
                    <label for="total_amt" class="form-label">एकूण रक्कम<span class="text-danger">*</span></label>
                    <input type="text" name="total_amt" class="form-control totamt total_amt" id="total_amt" oninput="allowType(event, 'number')" placeholder="एकूण रक्कम" required readonly>
                    </div>
                </div>
                
                <div class="col-12 col-md-6">
                    <label for="pickup_rs" class="col-form-label">उचल रु</label>
                    <input type="text" class="form-control pickup_rs" id="pickup_rs" oninput="allowType(event, 'number')" name="pickup_rs">
                </div>
                <div class="col-12 col-md-6">
                            <label for="balance_rs" class="col-form-label">शिल्लक रु</label>
                            <input type="text" class="form-control balance_rs" id="balance_rs" oninput="allowType(event, 'number')" name="balance_rs" readonly>
                </div>
                <div class="col-12 col-md-6">
                            <label for="reason" class="col-form-label">उचल कारण</label>
                            <input type="text" class="form-control" id="reason" name="reason">
                </div>
                
            </div>
             
          </form>
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
        <button type="submit" name="pickup" form="pickuprs" class="btn btn-success">जतन करा</button>
             </div>
        </div>
    </div>
</div>


<?php foreach ($carList as $fetch): ?>
<?php extract($fetch);?>
         <div class="modal fade" id="info<?php echo $sal_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $sal_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $sal_id;?>">कामगार तपशील</h5>
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
						        						<span><?= $worker_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल नंबर</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $contact?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>रुजू होण्याची तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($sdate));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पगार रु</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span>₹ <?= $sallery?> /-</span>
						        					</td>
						        				</tr>
						        				<?php
						        				error_reporting(0);
						        				$getDays=mysqli_query($connect,"SELECT * FROM `salcar_sallery` WHERE ma_id=$sal_id");
						        		$rowDays=mysqli_fetch_assoc($getDays);
						        		
						        				$getAb=mysqli_query($connect,"SELECT COUNT(is_present) as totab FROM `salcar_atten` WHERE sal_id=$sal_id AND is_present='absent'");
						        		$rowAb=mysqli_fetch_assoc($getAb);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>एकूण कामकाजाचे दिवस</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($rowDays['total_days']==0){?>
						        						<span>0</span>
						        						<?php }else{ ?>
						        						<span><?= $rowDays['total_days']?></span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>एकूण रजा</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($rowAb['totab']==0){ ?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span><?= $rowAb['totab']?></span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>एकूण पगार </strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($rowDays['total_amt']==0){?>
						        						<span>0</span>
						        						<?php } else {?>
						        						<span>₹ <?= $rowDays['total_amt']?>/-</span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">उचल रु</h6>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        				    <th>उचल रु तारीख</th>
						        				    <th>उचल रु</th>
						        				    <th>कारण</th>
						        				</tr>
						        				<tr>
						        				    <?php 
						        				    error_reporting(0);
						        				    $_getPickUp=mysqli_query($connect,"select * from salcar_pickup_rs WHERE ma_id='$sal_id' order by male_pickup_id DESC");
						        				    while($_rowPickUp=mysqli_fetch_assoc($_getPickUp)):
						        				 //extract($_rowPickUp);   
						        				   ?>
						        				    <td><?= date('d M Y',strtotime($_rowPickUp['pdate']))?></td>
						        				    <td>₹ <?= $_rowPickUp['pickup_rs']?> /-</td>
						        				    <td><?= $_rowPickUp['reason']?></td>
						        				</tr>
						        			<?php $sumAdv=mysqli_query($connect,"SELECT SUM(pickup_rs) as sumpickrs FROM `salcar_pickup_rs` WHERE ma_id='$sal_id'");
						        				$rSumAdv=mysqli_fetch_assoc($sumAdv);
						        				?>
						        				<?php endwhile?>
						        				
						        				<tr>
                                                  <th colspan="1">एकूण उचल </th>
                                                  <td>₹ <?= $rSumAdv['sumpickrs']?>/-              </td>
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
<script>
$(document).ready(function(){
    $("select.sal_id").change(function(){
          var d = $(".sal_id option:selected").val();
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { salrs : d } 
          }).done(function(data){
              $(".salrs").val(data);
          });
      });
  });
    $(document).ready(function(){
    $("select.sal_id").change(function(){
          var r = $(".sal_id option:selected").val();
          $.ajax({
              method: "POST",
              url: "ajax_master", 
              data: { workers_days : r } 
          }).done(function(data){
              $(".wdays").val(data);
          });
      });
  });
  
  $(document).ready(function(){
    $("select.wrsal").change(function(){
          var t = $(".wrsal option:selected").val();
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { workerstotsal : t } 
          }).done(function(data){
              $(".totamt").val(data);
          });
      });
  });
   $(document).ready(function() {
     $("#total_days, #daily_rs").on("input", mul);
     $(".total_amt, .pickup_rs").on("input", sub);
  });
    function mul() {
            let tamt = $('#total_days').val();
            let aamt = $('#daily_rs').val();
			let result1 = Number(tamt) * Number(aamt);
			$('#total_amt').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }
    function sub() {
    let tamtsal = $('.total_amt').val();
    let pickrs = $('.pickup_rs').val();
    let _bal = Number(tamtsal) - Number(pickrs);
    $('.balance_rs').val(!isNaN(_bal) ? _bal : 0).trigger('change');
}

function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    else document.getElementById('ifYes').style.visibility = 'hidden';

}
 </script>
<?php include "footer.php"; ?>