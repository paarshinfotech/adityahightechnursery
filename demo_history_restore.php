<?php require "config.php" ?>

<?php
Aditya::subtitle('डेमो बिल पुनर्संचयित');

if (isset($_GET['restore']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE sales SET sales_status='1' and demo_status='0' WHERE sale_id='{$dir}'");
    }
        if($delete){
    	header("Location: demo_history?action=Success&action_msg= डेमो बिल पुनर्संचयित कले..!");
		exit();
        }else{
        header('Location: demo_history?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM sales WHERE sale_id='{$dir}' and demo_status='0'");
     }
        if($delete){
    	header("Location: demo_history?action=Success&action_msg=डेमो बिल हटवले..!");
		exit();
        }else{
        header('Location: demo_history?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">डेमो बिल </h6>
            <a class="btn btn-sm btn-success float-end" href="demo_bill" style="margin-top:-25px;">
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
			                            			<a title="डेमो बिल हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('डेमो बिल हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>डेमो बिल हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>ग्राहकाचे नाव</th
                                    >
									<th>तारीख</th>
									<th>गाडी भाडे</th>
									<th>ड्राइवर नाव</th>
									<th>एकूण</th>
									<th>ऍडव्हान्स</th>
									<th>शिल्लक</th>
									<th>पेमेंट मोड</th>
									<th>कृती</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and sales_status='0' and demo_status='0' ORDER BY sale_id DESC") ?>
                            <?php if (mysqli_num_rows($getsalesDetails)>0): ?>
                                <?php while ($sales = mysqli_fetch_assoc($getsalesDetails)): 
                                extract($sales);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <!--<td>-->
                                <!--    <span class="badge bg-gradient-bloody text-white shadow-sm">-->
                                <!--        <?//= $sale_id ?>-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td>
                                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#info<?php echo $salesFetch['sale_id'];?>">
                                        <?= $customer_name; ?>
                                    </a>
                                </td>
                                
                                <td>
																<?= date('d M Y',strtotime($sdate))?>
															</td>
															<td>
																<?= $car_rental_amt?>
															</td>
															<td>
																<?= $driver_name?>
															</td>
															<td>
															    <?php if($car_rental_amt==''){?>
															    <?= $total?>
															    <?php }else {?>
																<?= $car_rental_amt + $total?>
																<?php } ?>
															</td>
															<td>
																<?= $advance?>
															</td>
															<td>
																<?= $balance?>
															</td>
															<td>
																<?= $pay_mode?>
															</td>
                                
                                <td>
									<a href="demo_bill?sale_id=<?= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Edit Sale" data-original-title="Edit Sale"><i class="fa fa-edit text-info"></i></a>
									
									<a href="demo_invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Invoice" data-original-title="Invoice"><i class="fa fa-print text-dark"></i></a>
									<a href="demo_sales_advance_invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Advance Invoice" data-original-title="Advance Invoice"><i class="fa fa-print text-cyan"></i></a>
									<!--<a href="sales_delete?sid=<?php //echo $sale_id?>" class="text-inverse" title="Delete" data-bs-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash text-danger"></i></a>-->
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
<!--priview modal-->
                                <?php 
                                error_reporting(0);
                                foreach ($salesDetails as $salesFetch):?>
                                <?php extract($salesFetch);?>
<div class="modal fade" id="info<?php echo $sale_id;?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoLabel<?php echo $sale_id;?>">चलन तपशील</h5>
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
						        						<span><?= $customer_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल नंबर</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $customer_mobno?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span> <?php $date=date('d M Y',strtotime($sdate))?>
                                            <?= $date?></span>
						        					</td>
						        				</tr>
						        				<?php
						        				$getCusDebAmt=mysqli_query ($connect, "SELECT SUM(total+car_rental_amt) as debAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowDebAmt=mysqli_fetch_assoc($getCusDebAmt);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>डेबिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowDebAmt['debAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				<?php
						        				$getcusCre=mysqli_query ($connect, "SELECT SUM(balance+car_rental_amt) as credAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowcre=mysqli_fetch_assoc($getcusCre);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>क्रेडिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowcre['credAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				
						        				
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">पावती</h6>
						        					</td>
						        				</tr>
						        			</tbody>
						        		</table>
						        		<table class="table table-bordered text-center fs-6">
                                            <thead>
                                                <tr>
                                                    <th>अ.क्र.</th>
                                                    <th>मालाचे विवरण</th>
                                                    <th>रोपांची संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getcuspro = "SELECT * FROM sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN sales d ON s.sale_id=d.sale_id WHERE s.sale_id='$sale_id'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $product_id?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $pqty?></td>
                                                <td><?= $pprice?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">एकूण</th>
                                                  <td class="text-center">₹ <?= $total?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">कारचे भाडे रु</th>
                                                  <td class="text-center">₹ <?= $car_rental_amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">ड्राइवर नाव</th>
                                                  <td class="text-center"><?= $driver_name?></td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">तारीख आणि एकूण</th>
                                                  <td class="text-center">तारीख: <?= date('d M Y',strtotime($advdate))?>, ₹ <?= $amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                      <th colspan="4">ऍडव्हान्स</th>
                                                      <td class="text-center">
                                                          ₹ <?= $advance?>/-
                                                      </td>
                                            </tr>
                                            <tr align="right">      
                                                      <th colspan="4">शिल्लक</th>
                                                      <td class="text-center">
                                                        ₹ <?= $balance?>/-
                                                          
                                                       </td>
                                            </tr>   
                                            </tbody>
                                            
                                    </table>

						        	</div>
                                </div>
                                <!--<div class="modal-footer">-->
                                <!--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>-->
                                <!--    <button type="button" class="btn btn-success" onclick="window.print()">छापणे</button>-->
                                <!--  </div>-->
                                </div>
                              </div>
                            </div>							
                         <?php endforeach?>