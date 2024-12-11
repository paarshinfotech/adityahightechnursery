<?php require "config.php" ?>
<?php
Aditya::subtitle('बुकिंग तपशील यादी');
//restore 
if (isset($_GET['restore']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE sale_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE bhajipala_sales SET is_not_delete='1' WHERE sale_id='{$dir}'");
    }
        if($delete){
    	header("Location: bhajipala_sales_list?action=Success&action_msg=बुकिंग तपशील पुनर्संचयित  केले..!");
		exit();
        }else{
        header('Location: bhajipala_sales_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//delete
if (isset($_GET['delete']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    $delete = mysqli_query($connect, "DELETE FROM bhajipala_sales WHERE sale_id='{$dir}'");
     }
    //  $delete = mysqli_query($connect, "UPDATE customer SET is_not_delete='1' WHERE sale_id='{$dir}'");
    // }
        if($delete){
    	header("Location: bhajipala_sales_list?action=Success&action_msg=बुकिंग तपशील हटवले..!");
		exit();
        }else{
        header('Location: bhajipala_sales_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

if(isset($_POST['deposit'])){
    escapeExtract($_POST);
    
    $editdeposit = mysqli_query($connect,"UPDATE bhajipala_sales SET 
           depositdate = '$depositdate',
           balance='$finally_left',
           deposit ='$deposit_again',
           finally_left = '$finally_left'
           WHERE sale_id ='$sale_id'");
    if($editdeposit)
    {
        //   header("Location: seeds_sales_list");
      	 //   exit();
          header("Location: bhajipala_sales_deposit_invoice?sid={$sale_id}");
      	    exit();
    }
    else{
        header('Location: seeds_sales_list');
      	exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">बुकिंग तपशील</h6>
            <div class="dropdown-center">
               <a href="bhajipala_sales" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="bhajipala_sales">नवीन तयार करा</a></li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deposit">ठेव</a></li>

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
			                            			<a title="बुकिंग तपशील हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('बुकिंग तपशील हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>बुकिंग तपशील हटवा 
			                            			</a>
			                            		</li>
			                            	</ul>
			                            	
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>शेतकऱ्यांचे नाव</th>
                                    <th>गाव</th>
                                    <th>मोबाईल</th>
                                    <th>बुकिंग तारीख</th>
                                    <!--<th>दिलेली तारीख</th>-->
                                    <th>देण्याची तारीख</th>
                                    <th>एकूण</th>
                                    <th>कृती</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getBooking = mysqli_query($connect, "SELECT * FROM bhajipala_sales where is_not_delete='0' order by given_date DESC") ?>
                            <?php if (mysqli_num_rows($getBooking)>0): ?>
                                <?php
                                $bookList = array();
                                while ($resBook = mysqli_fetch_assoc($getBooking)): 
                                array_push($bookList, $resBook);
                                extract($resBook);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $sale_id;?>"class="text-primary"><a class="text-decoration-none"><?= $far_name?></a></td>
                                
                                <td><?= $village?></td>
                                <td>
                                    <a class="text-decoration-none" href="bhajipala_sales?sale_id=<?= $sale_id;?>">
                                        <?= $mob_no; ?>
                                    </a>
                                </td>
                                               
                                                <td><?= date('d M Y',strtotime($sdate))?></td>
                                                <!--<td><?//= date('d M Y',strtotime($given_date))?></td>-->
                                               <td class="text-danger fw-bold"><?= date('d M Y',strtotime($deli_date))?></td>
                                            
                                                <td><?= $total?></td>
                                                <td>
                                                    <a href="bhajipala_invoice?sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Booking Invoice"><i class="fa fa-print"></i></a>
                                                    <a href="bhajipala_sales?sale_id=<?php echo $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-edit text-primary"></i></a> 
                                                    <a href="bhajipala_sales_deposit_invoice?sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Deposit Invoice"><i class="fa fa-print"></i></a>
                                                    
                                                    
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
<div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="depositLabel" aria-hidden="true">
                                        <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="depositLabel">ठेव रक्कम</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="sale_id" class="col-form-label">नाव</label>
            	<select name="sale_id" id="cid" class="form-control cid" required><option>शेतकरी निवडा</option>	
										<?php $getzendu = mysqli_query($connect,"SELECT far_name,sale_id from bhajipala_sales") ?>
																	<?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
																		<?php while ($getrow=mysqli_fetch_assoc($getzendu)):?>
																		<option value="<?= $getrow['sale_id'] ?>"><?= $getrow['far_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
										
														</select>
          </div>
          
          <div class="mb-3">
            <label for="depositdate" class="col-form-label">तारीख</label>
            <input type="date" class="form-control" id="depositdate" name="depositdate" value="<?php echo date('Y-m-d')?>">
          </div>
             <div class="col-12 col-md-12 mt-2">
                                                <div class="form-group">
                                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span class="text-danger">*</span></label><br>
                                                
                                                <input type="text" name="pending_amt" id='pending_amt' class="form-control" readonly>
                                          
                                                <input type="hidden" name="sale_id" id='sale_id' class="form-control" readonly>
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12 mt-2">
                                                <div class="form-group">
                                                <label for="deposit_again" class="form-label">ठेव<span class="text-danger">*</span></label><br>
                                                <input type=text name="deposit_again" id='deposit_again' class="form-control" oninput="allowType(event, 'number')">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12 mt-2">
                                                <div class="form-group">
                                                <label for="finally_left" class="form-label">शेवटी लेफ्ट<span class="text-danger">*</span></label><br>
                                                <input type=text name="finally_left" id='finally_left' class="form-control" readonly>
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
foreach ($bookList as $resBook): ?>
                    <?php extract($resBook);
                    ?>
         <div class="modal fade" id="info<?php echo $sale_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="infoLabel<?php echo $sale_id;?>">शेतकऱ्याची बुकिंग तपशील</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-primary mb-0">मूलभूत माहिती</h6>
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
						        						<strong>बुकिंग तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($sdate));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>दिलेली तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($given_date));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>देण्याची तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $deli_date;?></span>
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
						        						<h6 class="text-primary mb-0">उत्पादनांचे वर्णन</h6>
						        					</td>
						        				</tr>
						        		
						        			</tbody>
						        		</table>
						        		<table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>अ.क्र.</th>
                                                    <th>मालाचे विवरण</th>
                                                    <th>संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                if(isset($resBook['sale_id'])):
                                                $getcuspro = "SELECT * FROM bhajipala_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN bhajipala_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$resBook['sale_id']}'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $pid?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $product_qty?></td>
                                                <td><?= $product_amount?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">एकूण</th>
                                                  <td class="text-center">₹ <?= $total?>/-</td>
                                        </tr>
                                            
                                        <tr align="right">
                                                  <th colspan="4">ऍडव्हान्स</th>
                                                  <td class="text-center">
                                                      ₹ <?= $advance?>/-
                                                  </td>
                                        </tr>
                                        <tr align="right">
                                                  <th colspan="4">प्रलंबित रक्कम</th>
                                                  <td class="text-center"><?= $balance?></td>
                                        </tr>
                                        <tr align="right">
                                                  <th colspan="4">ठेव रक्कम</th>
                                                  <td class="text-center">
                                                      <?= $deposit?>
                                                  </td>
                                        </tr>
                                        <tr align="right">      
                                                  <th colspan="4">शिल्लक</th>
                                                  <td class="text-center">
                                                     <?= $finally_left?>
                                                      
                                                   </td>
                                        </tr>   
                                            </tbody>
                                            
                                            <?php endif ?>
                                    </table>
						        	</div>
                                </div>
                            </div>
                        </div>
                        </div>
       <?php endforeach?>                        
<script>
     $(document).ready(function(){
     $("#cid").change(function(){
          var s = $("#cid option:selected").val();
           
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { balAmt : s } 
          }).done(function(data){
              $("#pending_amt").val(data);
          });
      });
  });
  
  $(document).ready(function(){
    $("#cid").change(function(){
          var x = $("#cid option:selected").val();
        //   alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { sid : x  } 
          }).done(function(data){
              $("#sale_id").val(data);
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
</script>