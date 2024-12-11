<?php require "config.php" ?>
<?php
Aditya::subtitle('झेंडू बुकिंग यादी');
if (isset($_GET['restore']) && isset($_GET['zendu_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['zendu_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE zendu_booking SET zb_status='1' WHERE zendu_id='{$dir}'");
    }
        if($delete){
    	header("Location: zendu_booking_list?action=Success&action_msg=झेंडू  बुकिंग पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: zendu_booking_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['zendu_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['zendu_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM zendu_booking WHERE zendu_id='{$dir}'");
     }
        if($delete){
    	header("Location: zendu_booking_list?action=Success&action_msg=झेंडू  बुकिंग् हटवले..!");
		exit();
        }else{
        header('Location: zendu_booking_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

if(isset($_POST['deposit'])){
    escapeExtract($_POST);
    
    $editdeposit = mysqli_query($connect,"UPDATE zendu_booking SET 
           depositdate = '$depositdate',
           pending_amt='$finally_left',
           deposit_again ='$deposit_again',
           finally_left = '$finally_left'
           WHERE zendu_id ='$zendu_id'");
    if($editdeposit)
    {
          header('Location: zendu_booking_list?action=Success&action_msg=शेतकऱ्यांचे ₹ '.$deposit_again.' /- जमा झाले..!');
      	    exit();
        //   header("Location: zendu_booking_deposit_invoice?zid={$zendu_id}");
      	 //   exit();
        //   header("Location: zendu_booking_list");
      	 //   exit();
    }
    else{
        header('Location: zendu_booking_list');
      	exit();
    }
}

//add stock
if(isset($_POST['add_stock'])){
    escapeExtract($_POST);
        $_cQty = $ocat_qty + $cat_nqty;
        $update = mysqli_query($connect,"update marigold_category set
            zendu_id='$zendu_id',
            cat_qty = '$_cQty',
            cat_date='".date('Y-m-d')."'
            where zendu_id = '$zendu_id'");
        
        if($update){
            header('Location: zendu_booking_list?action=Success&action_msg='.$cat_name.' नवीन स्टॉक जोडला..!');
      	    exit();
        }
        else{
        header('Location: zendu_booking_list?action=Success&action_msg=somthing went wrong');
      	exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<div class="dropdown-center">
               <a href="sal_car_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="zendu_booking_add">नवीन तयार करा</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deposit" data-bs-whatever="@mdo">ठेव</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addStockModal" data-bs-whatever="@mdo">स्टॉक जोडा</a></li>
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
			                            			<a title="झेंडू  बुकिंग हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('झेंडू  बुकिंग हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>झेंडू  बुकिंग हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>बुकिंग तारीख</th>
                                    <th>शेतकऱ्याचे नाव</th>
                                    <th>गाव</th>
                                    <th>मोबाईल</th>
                                    <th>लाल वनस्पती व संख्या</th>
                                    <!--<th>एकूण संख्या</th>-->
                                    <th>पिवळी वनस्पती व संख्या</th>
                                    <!--<th>एकूण संख्या</th>-->
                                    
                                    <th>लाल उपवर्ग वर्णन</th>
                                    <!--<th></th>-->
                                    <th>पिवळ्या उपवर्ग वर्णन</th>
                                    <!--<th></th>-->
                                    
                                    <th>एकूण रक्कम</th>
                                    <th>ठेव</th>
                                    <th>प्रलंबित</th>
                                    <th>पुन्हा ठेव</th>
                                    <th>अखेर बाकी</th>
                                               
                                    <!--<th>Red Giving Date</th>-->
                                    <!--<th>Yellow Giving Date</th>-->
                                    <th>वितरण तारीख</th>
                                   
                                    <th>क्रिया</th>
						   </tr>
						</thead>
							<tbody>
                            <?php $getZbooking = mysqli_query($connect, "select * from zendu_booking where zb_status='0' order by booking_date ASC") ?>
                            <?php if (mysqli_num_rows($getZbooking)>0): ?>
                                <?php 
                                $zenduList = array();
                                while ($zenduBook = mysqli_fetch_assoc($getZbooking)): 
                                array_push($zenduList, $zenduBook);
                                extract($zenduBook);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="zendu_id[]" value="<?= $zendu_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $zendu_id ?>
                                    </span>
                                </td>
                               
                                <!--<td>-->
                                <!--    <a class="text-decoration-none" href="zendu_booking_add?zendu_id=<?//= $zendu_id;?>">-->
                                <!--        <?//= $cat_name; ?>-->
                                <!--    </a>-->
                                <!--</td>-->
                                <td class="text-danger fw-bold"><?= date('d M Y',strtotime($booking_date))?></td>
                                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $zenduBook['zendu_id'];?>"class="text-success"><?= $name?></td>
                                                <td><?= $village?></td>
                                                <td><?= $mobile?></td>
                                                 <td><?= $red_plants?>,(<?= $red_plants_count?>)</td> 
                                                <!--<td></td>-->
                                                 <td><?= $yellow_plants?>,(<?= $yellow_plants_count?>)</td>
                                               
                                                <!--<td></td> -->
                                                <td><?= $subcat_id?>(<?= $sub_cat_qty?>),<?= $subcat_id1?>,(<?= $sub_cat_qty1?>), <b class="text-danger fw-bold"><?= date('d M Y',strtotime($red_giving_date))?></b></td> 
                                                <!--<td></td> -->
                                                <td><?= $ysubcat_id?>(<?= $yellowcount?>) <?= $subcat_idy1?>(<?= $sub_cat_qtyy1?>), <b class="text-warning fw-bold"><?= date('d M Y',strtotime($yellow_giving_date))?></b></td> 
                                                <!--<td></b></td> -->
                                                
                                                
                                                <td>₹ <?= $total_amount?>/-</td> 
                                                <td>₹ <?= $adv_amt?>/-</td> 
                                                <td>₹ <?= $pending_amt?>/-</td> 
                                                
                                                <td>₹ <?= $deposit_again?>/-</td> 
                                                <td>₹ <?= $finally_left?>/-</td> 
                                                <!--<td><?//= date('d M Y',strtotime($red_giving_date))?></td> -->
                                                <!--<td><?//= date('d M Y',strtotime($yellow_giving_date))?></td> -->
                                                <td><?php if($date_given=='0000-00-00'){ } else {?>
                                               <?= date('d M Y',strtotime($date_given))?>
                                                </td> 
                                               <?php } ?>
                                                <td>
                                                    
                                                    <a href="zendu_booking_invoice?zid=<?php echo $zendu_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="इनव्हॉइस बुकिंग" data-original-title="इनव्हॉइस बुकिंग"><i class="fa fa-print"></i></a> 
                                                    <a href="zendu_booking_add?zid=<?php echo $zendu_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="बुकिंग अपडेट" data-original-title="बुकिंग अपडेट"><i class="fa fa-edit"></i></a> 
                                                    <a href="zendu_booking_deposit_invoice?zid=<?php echo $zendu_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="ठेव इनव्हॉइस" data-original-title="ठेव इनव्हॉइस"><i class="fa fa-print"></i></a> 
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
 <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStockModalLabel">स्टॉक जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div class="row">
            <div class="col-12">
                <form method="post">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            
                            <select class="form-select item_name text-start" name="cat_id" id="cid" required>
                                    <option value="">श्रेणी निवडा</option>
                                    <?php $query = mysqli_query($connect,"select * from marigold_category where cat_status='1'") ?>
                                    <?php if ($query && mysqli_num_rows($query)): ?>
                                      <?php while ($row1=mysqli_fetch_assoc($query)): ?>
                                        <option value="<?= $row1['cat_id'] ?>"><?= $row1['cat_name'] ?></option>
                                      <?php endwhile ?>
                                    <?php endif ?>
                                  </select>
                            </div>
                            <div class="col-12 my-3">
                            <div class="form-group">
                               
                                <input id="aviqty" type="text" name="ocat_qty" class="form-control" oninput="allowType(event,'number')" readonly>
                            </div>
                        </div>
                            <div class="col-12">
                            <div class="form-group">
                                
                                <input id="pnqty" type="text" name="cat_nqty" class="form-control" oninput="allowType(event,'number')" required>
                            </div>
                        </div>

                        </div>
                        
                    </div>

                   
                    <button type="submit" name="add_stock" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                </form>
            </div>
        </div>    
      </div>
    </div>
    </div>
    </div> 

<div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="depositLabel" aria-hidden="true">
                                        <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="depositLabel">ठेव</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="zendu_id" class="col-form-label">नाव</label>
            	<select name="zendu_id" id="zid" class="form-control mb-3 zid" required><option value="">शेतकरी निवडा</option>	
										<?php $getzendu = mysqli_query($connect,"SELECT name,zendu_id from zendu_booking where zb_status='1'") ?>
																	<?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
																		<?php while ($getrow=mysqli_fetch_assoc($getzendu)):?>
																		<option value="<?= $getrow['zendu_id'] ?>"><?= $getrow['name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
										
														</select>
          </div>
          
          <div class="mb-3">
            <label for="depositdate" class="col-form-label">तारीख</label>
            <input type="date" class="form-control" id="depositdate" name="depositdate" value="<?php echo date('Y-m-d')?>">
          </div>
                                        <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span class="text-danger">*</span></label><br>
                                                <input type="text" name="pending_amt" id='pending_amt' class="form-control" readonly>
                                                <input type="hidden" name="zendu_id" id='zendu_id' class="form-control" readonly oninput="allowType(event,'number')">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="deposit_again" class="form-label">पुन्हा ठेव<span class="text-danger">*</span></label><br>
                                                <input type=text name="deposit_again" id='deposit_again' class="form-control" oninput="allowType(event,'number')">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="finally_left" class="form-label">अखेर बाकी<span class="text-danger">*</span></label><br>
                                                <input type=text name="finally_left" id='finally_left' class="form-control" readonly oninput="allowType(event,'number')">
                                                </div>
                                                    </div>
                                                    
       
                                    </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                                        <button type="submit" name="deposit" class="btn btn-primary">जतन करा</button>
                                       
                                         </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>

<?php 
error_reporting(0);
foreach ($zenduList as $zenduBook): ?>
                    <?php extract($zenduBook);
                    ?>
         <div class="modal fade" id="info<?php echo $zendu_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $zendu_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $zendu_id;?>">शेतकऱ्यांची माहिती</h5>
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
						        						<span><?= $mobile?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span class="text-danger fw-bold"><?= date('d M Y',strtotime($booking_date));?></span>
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
						        						<strong>लाल वनस्पती</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($red_plants==0 && $subcat_id==0 && $sub_cat_qty==0 && $rate==0 && $subcat_id1==0 && $sub_cat_qty1==0 && $rate1==0){?>
						        					    <span>NULL</span>
						        					    <?php } else{?>
						        						<span><?= $red_plants?>: <?= $subcat_id?> (<?= $sub_cat_qty?>)x(<?= $rate?>),<?= $subcat_id1?> (<?= $sub_cat_qty1?>)x(<?= $rate1?>) </span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>लाल रोपे एकूण</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($total_rs==0 || $total_rs1==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span><?= $total_rs + $total_rs1?></span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी वनस्पती</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($yellow_plants==0 && $ysubcat_id==0 && $yellowcount==0 && $ratey==0 && $subcat_idy1==0 && $sub_cat_qtyy1==0 && $ratey1==0){?>
						        						<span>NULL</span>
						        						<?php } else{?>
						        						<span><?= $yellow_plants?>: <?= $ysubcat_id?> (<?= $yellowcount?>)x(<?= $ratey?>),<?= $subcat_idy1?> (<?= $sub_cat_qtyy1?>)x(<?= $ratey1?>) </span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी रोपे एकूण रु</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php
						        					 //   if(isset($total_rsy) || (isset($yellow_total))){
						        					    if(isset($total_rsy))?>
						        				<?= $total_rsy ?>
						        				<?php if(isset($yellow_total)) 
						        					$yellow_total;
						        					error_reporting(0);
						        		 			//$TOTYellow = $total_rsy+$yellow_total;
						        				
						        					?>
						        				
						        				<span><?= $TOTYellow?></span>
						        				
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
						        						<span><?= $total_amount?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>ऍडव्हान्स रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $adv_amt?></span>
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
						        				<tr>
						        					<td>
						        						<strong>जमा करण्याची तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<?php if($depositdate==''){
						        					    ?>
						        					    <td>
						        						<span>DD/MM/YY</span>
						        					</td>
						        					    <?php
						        					}else{?>
						        					<td>
						        						<span><?= date('d M Y',strtotime($depositdate))?></span>
						        					</td>
						        					<?php } ?>
						        				</tr>
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
						        						<strong>अखेर बाकी</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($finally_left==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span><?= $finally_left?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>लाल देणारी तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($red_giving_date==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-danger fw-bold"><?= date('d M Y',strtotime($red_giving_date))?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी देणारी तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($yellow_giving_date==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-warning fw-bold"><?= date('d M Y',strtotime($yellow_giving_date))?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>वितरण तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($date_given==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-success fw-bold"><?= date('d M Y',strtotime($date_given))?></span><?php } ?>
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
    $("select.zid").change(function(){
          var x = $(".zid option:selected").val();
          //alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { pendingamt : x  } 
          }).done(function(data){
              $("#pending_amt").val(data);
          });
      });
  });
    $(document).ready(function(){
    $("select#zid").change(function(){
          var x = $("#zid option:selected").val();
        //   alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { zenduid : x  } 
          }).done(function(data){
              $("#zendu_id").val(data);
          });
      });
  });
  
   $(document).ready(function() {
    
     //this calculates values automatically finally left
    pending_sub();
    $("#pending_amt, #deposit_again").on("input", function() {
        pending_sub();
    });
});
   function pending_sub() {
             let totpending = document.getElementById('pending_amt').value;
            let depagain = document.getElementById('deposit_again').value;
			let finalleft = parseInt(totpending) - parseInt(depagain);
            if (!isNaN(finalleft)) {
				document.getElementById('finally_left').value = finalleft;
            }
        }

    $(document).ready(function(){
    $("select#cid").change(function(){
          var q = $("#cid option:selected").val();
          //alert(q);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { _cqty : q } 
          }).done(function(data){
              $("#aviqty").val(data);
          });
      });
  });
</script>         