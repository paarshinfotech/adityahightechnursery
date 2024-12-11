<?php require "config.php" ?>
<?php
Aditya::subtitle('जेसीबी यादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['jcb_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['jcb_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE jcb_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE jcb SET jcb_status='1' WHERE jcb_id='{$dir}'");
    }
        if($delete){
    	header("Location: jcb_category?action=Success&action_msg=जेसीबी  पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: jcb_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['jcb_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['jcb_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM jcb WHERE jcb_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE customer SET jcb_status='0' WHERE jcb_id='{$dir}'");
    // }
        if($delete){
    	header("Location: jcb_category?action=Success&action_msg=जेसीबी  हटवले..!");
		exit();
        }else{
        header('Location: jcb_restore?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">जेसीबी </h6>
   <div class="dropdown-center">
               <a href="jcb_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="jcb_add">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv" data-bs-whatever="@mdo">ऍडव्हान्स</a></li>

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
			                            			<a title="जेसीबी  हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('जेसीबी  हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>जेसीबी  हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>श्रेणी</th> 
                                                <th>नाव</th> 
                                                <th>तास/सहल</th>
                                                <th>दर</th>
                                                <th>एकूण रक्कम</th>
                                                <th>एकूण आगाऊ</th>
                                                <th>एकूण शिल्लक</th>
                                                <th>तारीख</th>
                                                <th>मोबाईल</th> 
                                                <th>गावाचे नाव</th>
                                                <th>कामाचे स्वरूप</th>
                                                <th>जेसीबी</th>
                                               
                                                <th>टॅक्टर</th>
                                                 <th>तास</th>
                                                 <th>देणारा</th>
                                                 <th>घेणारा</th>
                                                 <th>कृती</th>
						   </tr>
						</thead>
					<tbody>
						    <?php
						  // if(isset($_GET['jcb_cat_id'])){
                            // $getjcb="select * from jcb e,jcb_category c WHERE c.jcb_cat_id=e.jcb_cat_id and jcb_status!='1' order by e.jcb_id DESC";
                            $getjcb="select * from jcb c LEFT JOIN jcb_adv a ON c.jcb_id=a.cr_id INNER JOIN jcb_category r ON c.jcb_cat_id=r.jcb_cat_id and c.jcb_status='1' group by c.jcb_id DESC";
                            $view=mysqli_query($connect,$getjcb);
                           
						    ?>
                            <?php if (mysqli_num_rows($view)>0): ?>
                                <?php 
                                 $infoDetails = array();
                                while ($rowjcb = mysqli_fetch_assoc($view)):
                                    array_push($infoDetails, $rowjcb);
                                extract($rowjcb);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="jcb_id[]" value="<?= $jcb_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $jcb_id ?>
                                    </span>
                                </td>
                                <td><?= $cat_name;?></td>
                                 
                                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $rowjcb['jcb_id'];?>" class="text-success"><?= $name?></td>
                                               
                                               
                                               
                                                <td><?= $trip?></td>
                                                <td><?= $rate?></td>
                                                <td><?= $total_amt?></td>
                                                <?php 
                                                if(isset($cr_id)){
                                                $cusadv=mysqli_query($connect,"select SUM(advrs) as advrscus from jcb_adv where cr_id='{$cr_id}'");
                                                $rowAdvtot=mysqli_fetch_assoc($cusadv);?>
                                                <td><?= $rowAdvtot['advrscus']?></td>
                                                <?php } else {?>
                                                <td>₹ 0/-</td>
                                                <?php } ?>
                                                <?php if(isset($totBal)){?>
                                                <td><?= $totBal?></td>
                                                <?php } else {?>
                                                <td>₹ 0/-</td>
                                                <?php } ?>
                                                <td><?= date('d M Y',strtotime($jdate));?></td>
                                                 <td>
                                                      <a class="text-decoration-none" href="jcb_add?jcb_id=<?= $jcb_id;?>"><?= $mobile?>
                                                      </a>
                                                      </td>
                                                <td><?= $village_name?></td>
                                                <td><?= $nwork?></td>
                                                <td><?= $jcb?></td>
                                                
                                                <td><?= $tactor?></td>
                                                <td><?= $hrs?></td>
                                                <?php if(isset($giver)){?>
                                                <td><?= $giver?></td>
                                                <?php }else {?>
                                                <td>...</td>
                                                <?php } ?>
                                                <?php if(isset($takar)){?>
                                                <td><?= $takar?></td>
                                                <?php }else {?>
                                                <td>...</td>
                                                <?php } ?>
                                                <td>
                                                    <?php if(isset($adv_id)){?>
                                                    <a href="jcb_invoice?jcb_id=<?php echo $jcb_id?>&adv_id=<?= $adv_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i class="fa fa-print"></i></a> <?php } ?>
                                                    <a href="jcb_add?jcb_id=<?php echo $jcb_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a> 
                                               </td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
                            <?php
                                            error_reporting(0);
                                            $totBalance += $totBal;?>
                                            <?php //} ?>
                                            
                            
						</tbody>
						<?php $getadv=mysqli_query($connect,"SELECT COUNT(jcb_id) as cus FROM jcb where jcb_status='0'");
                                        $tcus=mysqli_fetch_assoc($getadv);
                                        
                                              $getadv=mysqli_query($connect,"SELECT SUM(advrs) as totadv FROM jcb_adv a,jcb j WHERE j.jcb_id=a.cr_id and jcb_status='0'");
                                        $tadv=mysqli_fetch_assoc($getadv);
                                           
                                             $gettotal=mysqli_query($connect,"SELECT SUM(trip) as tottrip FROM jcb where jcb_status='0'");
                                        $ttrip=mysqli_fetch_assoc($gettotal);
                                       
                                      
                                         $getdep=mysqli_query($connect,"SELECT SUM(rate) as rate FROM jcb where jcb_status='0'");
                                        $trate=mysqli_fetch_assoc($getdep);
                                        
                                         $getdep=mysqli_query($connect,"SELECT SUM(total_amt) as totamt FROM jcb where jcb_status='0'");
                                        $totamt=mysqli_fetch_assoc($getdep);
                                        ?>
                                            <tr>
                                                <th class="text-center fs-6">Total</th>
                                                <th colspan="2" class="text-center fs-6"><?= $tcus['cus']?></th>
                                                
                                                <th><?= $ttrip['tottrip'] ?></th>
                                                <th><?= $trate['rate'] ?></th>
                                                <th>₹ <?= $totamt['totamt'] ?>/-</th>
                                                <th>₹ <?= $tadv['totadv'] ?>/-</th>
                                                <th>₹ <?= $totBalance ?>/-</th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
                                               <th></th>
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
        <?php foreach ($infoDetails as $rowjcb): ?>
                    <?php extract($rowjcb);
                     $totBal1 = $total_amt-$advrs;
                    ?>
         <div class="modal fade" id="info<?php echo $jcb_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $jcb_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $jcb_id;?>">ग्राहकाची माहिती</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="5" class="bg-light">
						        						<h6 class="text-success mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>श्रेणी</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $cat_name?></span>
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
						        						<span><?= date('d M Y',strtotime($jdate));?></span>
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
						        					<td colspan="5" class="bg-light">
						        						<h6 class="text-success mb-0">इतर माहिती</h6>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        				    <th>ऍडव्हान्स तारीख</th>
						        				    <th>ऍडव्हान्स  रु</th>
						        				    <th>कारण</th>
						        				    <th>देणारा</th>
						        				    <th>घेणारा</th>
						        				</tr>
						        				<tr>
						        				    <?php 
						        				    error_reporting(0);
						        				    $advcar=mysqli_query($connect,"select * from jcb_adv WHERE cr_id='$jcb_id' order by adv_id DESC");
						        				    while($_resadv=mysqli_fetch_assoc($advcar)):
						        				 //extract($_resadv);   
						        				   ?>
						        				    <td><?= date('d M Y',strtotime($_resadv['advdate']))?></td>
						        				    <td><?= $_resadv['advrs']?></td>
						        				    <td><?= $_resadv['reason']?></td>
						        				    <td><?= $_resadv['giver']?></td>
						        				    <td><?= $_resadv['taker']?></td>
						        				</tr>
						        			<?php $sumAdv=mysqli_query($connect,"SELECT SUM(advrs) as sumADV FROM `jcb_adv` WHERE cr_id='$jcb_id'");
						        				$rSumAdv=mysqli_fetch_assoc($sumAdv);
						        				?>
						        				<?php endwhile?>
						        				
						        				<tr>
                                                  <th colspan="1">Total Advance </th>
                                                  <td><?= $rSumAdv['sumADV'];?>              </td>
                                                  <td></td>
                                                </tr>
						        				<tr>
                                                  <th colspan="1">Total Balance</th>
                                                  <td><?= $totBal1?>              </td>
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
        <h5 class="modal-title" id="advLabel">ऍडव्हान्स</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="adate" class="col-form-label">नाव</label>
            	<select name="cr_id" class="form-control mb-3" required><option>निवडा..</option>	
										<?php $getcustomert = mysqli_query($connect,"SELECT * from jcb where jcb_cat_id='$jcb_cat_id' and jcb_status!=0") ?>
																	<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcustomert)):?>
																		<option value="<?= $getcus['jcb_id'] ?>"><?= $getcus['name'] ?>, (<?= $getcus['jdate'] ?>)</option>
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
          <div class="mb-3">
            <label for="giver" class="col-form-label">देणारा</label>
            <input type="text" class="form-control"  name="giver">
          </div>
          <div class="mb-3">
            <label for="taker" class="col-form-label">घेणारा</label>
            <input type="text" class="form-control"  name="taker">
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
        <button type="submit" name="adv" class="btn btn-success">जतन करा</button>
         </form>
      </div>
    </div>
  </div>
</div>
  
<?php include "footer.php"; ?>