<?php
require_once "config.php";
Aditya::subtitle('नवीन बियाणे आवक व जावक जोडा');
/*------ Add details ------*/
if (isset($_POST['cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($cat_name)) {
        $sql="SELECT * FROM seeds_category WHERE cat_name='$cat_name'";
    } else {
        $sql="SELECT * FROM seeds_category WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: seeds_add?action=Success&action_msg='.$cat_name.' बियाणे आवक व जावक श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO seeds_category(cat_name) VALUES ('$cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: seeds_add?action=Success&action_msg='.$cat_name.' नवीन बियाणे आवक व जावक श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: seeds_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

if(isset($_POST['seeds_booking_add'])){
	escapePOST($_POST);
	$cid = $_POST['far_name'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	
	$cat_id=$_POST['cat_id'];
	$pro_cat_id = $_POST['pro_cat_id'];
	$pro_varity = $_POST['pro_varity'];
	$variety = $_POST['variety'];
	$dag = $_POST['dag'];
	$bill_no = $_POST['bill_no'];
    
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$village= $_POST['village'];
	$mob_no= $_POST['mob_no'];
	$sub_total=$_POST['sub_total'];
	$total= $_POST['total'];
	$advance = $_POST['advance'];
	$pay_mode = $_POST['pay_mode'];
	$balance = $_POST['balance'];
	$given_date = $_POST['given_date'];
	$deli_date = $_POST['deli_date'];
// 	$status = ($balance > 0) ? 'pending' : 'completed';
// 	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';

	if (mysqli_query($connect, "INSERT INTO seeds_sales(far_name, sdate, village, mob_no, total, advance, pay_mode,balance, given_date, deli_date,cat_id,bill_no,dag) VALUES('$cid', '$sdate', '$village','$mob_no','$total','$advance','$pay_mode','$balance','$given_date', '$deli_date','$cat_id','$bill_no','$dag')")) {
		$sales_id = mysqli_insert_id($connect);
		$_salesAdded = true;
		foreach ($pid as $key => $_pid) {
			$saleDetail = mysqli_query($connect, "INSERT INTO seeds_sales_details(sale_id, pid, pqty, pprice, sub_total,pro_cat_id,pro_varity,variety) VALUES('{$sales_id}','{$_pid}','{$quantity[$key]}','{$pprice[$key]}','{$sub_total[$key]}','{$pro_cat_id[$key]}','{$pro_varity[$key]}','{$variety[$key]}')");
			if (!$saleDetail) {
				$_salesAdded = false;
			} 
// 			else {
// 				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
// 			}
		}
		if($_salesAdded) {
		header('Location: seeds_list?cat_id='.$cat_id.'&action=Success&action_msg='.$cid.' नवीन बियाणे आवक व जावक बुकिंग जोडली..!');
    		exit();
            }else{
            header('Location: seeds_list?action=Success&action_msg=काहीतरी चूक झाली');
          	exit();
            }
	}
}

if(isset($_POST['seeds_booking_edit'])){
	escapePOST($_POST);
	$cid = $_POST['far_name'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	$cat_id = $_POST['cat_id'];


	$cat_id=$_POST['cat_id'];
	$dag = $_POST['dag'];
	$bill_no = $_POST['bill_no'];
	
	$pro_cat_id = $_POST['pro_cat_id'];
	$pro_varity = $_POST['pro_varity'];
	$variety = $_POST['variety'];
	
	
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$village= $_POST['village'];
	$mob_no= $_POST['mob_no'];
	$sub_total=$_POST['sub_total'];
	$total= $_POST['total'];
	$advance = $_POST['advance'];
	$pay_mode = $_POST['pay_mode'];
	$balance = $_POST['balance'];
	$given_date = $_POST['given_date'];
	$deli_date = $_POST['deli_date'];
	
	if (mysqli_query($connect, "UPDATE seeds_sales SET far_name = '{$cid}',sdate = '{$sdate}',village='{$village}',mob_no='{$mob_no}',total = '{$total}', advance = '{$advance}',pay_mode = '{$pay_mode}',balance = '{$balance}',given_date='{$given_date}',deli_date='{$deli_date}',cat_id ='{$cat_id}', dag = '{$dag}',bill_no= '{$bill_no}' WHERE sale_id = '{$_GET['sale_id']}'")) {
	    $sid_in = '('.implode(', ', $sid).')';
	    $getDeleteSale = mysqli_query($connect, "SELECT pid, pqty FROM seeds_sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
	   
	    foreach ($sid as $_i => $_sid) {
	            if(!mysqli_query($connect, "UPDATE seeds_sales_details SET pid = '{$pid[$_i]}', pqty = '{$quantity[$_i]}', pprice = '{$pprice[$_i]}', sub_total = '{$sub_total[$_i]}', cat_id = '{$cat_id[$_i]}' , pro_varity = '{$pro_varity[$_i]}', pro_cat_id = '{$pro_cat_id[$_i]}', variety = '{$variety[$_i]}'  WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'")) {
	                $insert = false;
	            } 
	        }
	    }
	    if ($insert) {
	        header('Location: seeds_list?cat_id='.$cat_id.'&action=Success&action_msg='.$cid. 'चे बियाणे आवक व जावक अपडेट केली..!');
    		exit();
             }
        else{
           header('Location: seeds_list?cat_id='.$cat_id.'&action=Success&action_msg='.$cid. 'चे बियाणे आवक व जावक अपडेट केली..!');
    		exit();
            }
	} 

require_once "header.php";?>
		
 		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['sale_id'])){
						      $rsa = false;
							  $gets=mysqli_query($connect,"SELECT * FROM  seeds_sales WHERE sale_id='{$_GET['sale_id']}'");
							  if (mysqli_num_rows($gets) > 0) {
							      $rsa = mysqli_fetch_assoc($gets);
							      $getSaleDetail = mysqli_query($connect, "SELECT * FROM seeds_sales_details WHERE sale_id = '{$rsa['sale_id']}'");
							      $rsa['sale_details'] = array();
							      if (mysqli_num_rows($getSaleDetail) > 0) {
							          while($sdRow = mysqli_fetch_assoc($getSaleDetail)) {
							              $rsa['sale_details'][] = $sdRow;
							          }
							      }
							  }
							?>
							<?php if ($rsa): ?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">बियाणे आवक व जावक अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-4 mt-2">
                                                        <div class="form-group">
                                                            <label for="bdate" class="form-label">बुकिंग तारीख<span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" name="sdate" id="bdate" required value="<?= $rsa['sdate']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mt-2">
                                                        <div class="form-group">
                                                        <label for="name" class="form-label">श्रेणी<span class="text-danger">*</span>
          <!--                                              <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">-->
										<!--<i class="bx bxs-plus-circle text-success"></i>-->
									 <!--   </button>-->
                                                        </label>
                                                        <select class="form-select text-start" name="cat_id" required>
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from seeds_category") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>" <?php if($row1['cat_id']==$rsa['cat_id']){echo "selected";}?>>
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
                                                      
                                                         </div>
                                                    </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                        <div class="form-group">
                                                        <label for="name" class="form-label">शेतकऱ्याचे नाव<span class="text-danger">*</span></label>
                                                        <input type="text" name="far_name" class="form-control" id="name" required value="<?= $rsa['far_name']?>">
                                                      
                                                         </div>
                                                    </div>
                                                    
                                                     <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                        <label for="village" class="form-label">गाव<span class="text-danger">*</span></label>
                                                        <input type="text" name="village" class="form-control" id="village" required value="<?= $rsa['village']?>">
                                                      
                                                         </div>
                                                    </div>
        
                                                     <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="customer mobile" class="form-label">मोबाईल नंबर</label><span class="text-danger">*</span>
        
                                                            <input id="customer mobile" type="tel" minlength="10" maxlength="10" name="mob_no" class="form-control" required pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')" value="<?= $rsa['mob_no']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="add" class="form-label">डाग<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="dag" id="add" required oninput="allowType(event, 'number')" value="<?= $rsa['dag']?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="customer mobile" class="form-label">बिल क्रमांक</label><span class="text-danger">*</span>
        
                                                            <input id="customer mobile" type="text" min="0" name="bill_no" class="form-control" required="" oninput="allowType(event,'number')" value="<?= $rsa['bill_no']?>">
                                                        </div>
                                                    </div>
                                            </div>
                                            
                                            <table id="invoice-item-table" class="table table-bordered mb-0 mt-3">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th width="15%" class="text-start">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start text-nowrap">प्रॉडक्ट विविधता</th>
																<th>प्रमाण</th>
																<th>विविधता</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
															
															</tr>
														</thead>
														<tbody class="align-middle">
														    <?php if ($rsa['sale_details'] && count($rsa['sale_details'])>0): ?>
														    <?php foreach ($rsa['sale_details'] as $k => $sdtls): ?>
														    <tr align="center">
																<td><?= $k + 1 ?></td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="pro_cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>" <?= ($sdtls['pro_cat_id'] == $row1['cat_id']) ? 'selected' : '' ?>>
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="<?= $sdtls['sid'] ?>">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['product_id'] ?>" <?= ($sdtls['pid'] == $row1['product_id']) ? 'selected' : '' ?>>
																			<?= $row1['product_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="text" name="varity[]" class="form-control text-center varity" value="<?= $sdtls['pro_varity'] ?>" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" value="<?= $sdtls['pqty'] ?>" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																	<td>
                                                                    <input type="text" name="variety[]" id="variety" class="form-control text-center variety" value="<?= $sdtls['variety'] ?>">
                                                                </td>
																<td>
																	<input type="text" name="pprice[]" value="<?= $sdtls['pprice'] ?>" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>

																<td>
																	<input type="text" name="sub_total[]" value="<?= $sdtls['sub_total'] ?>" readonly class="form-control text-center final_amount">
																</td>
																
															</tr>
														    <?php endforeach ?>
														    <?php else: ?>
														    <tr align="center">
																<td>1</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="pro_cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="new">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php //$query = mysqli_query($connect,"select * from product") ?>
																		<?php //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
																		<!--<option value="<?//= $row1['product_id'] ?>">-->
																			<?//= $row1['product_name'] ?>
																		</option>
																		<?php //endwhile ?>
																		<?php //endif ?>
																	</select>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																	<td>
                                                                    <input type="text" name="variety[]" id="variety" class="form-control text-center variety" value="<?= $sdtls['variety'] ?>">
                                                                </td>
															
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																
															</tr>
														    <?php endif ?>
															<tr class="total-footer">
																<td colspan="6" rowspan="3"></td>
															    <th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center final_total_amt" id="final_total_amt" name="total" value="<?= $rsa['total'] ?>" readonly>
																</td>
																
															</tr>
														 	<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" value="<?= $rsa['advance'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																	<select name="pay_mode" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option <?= ($rsa['pay_mode']=='cash') ? 'selected' : '' ?> value="cash">रोख</option>
																		<option <?= ($rsa['pay_mode']=='rtgs') ? 'selected' : '' ?> value="rtgs">RTGS</option>
																		<option <?= ($rsa['pay_mode']=='neet') ? 'selected' : '' ?> value="neet">NEET</option>
																		<option <?= ($rsa['pay_mode']=='phonepay') ? 'selected' : '' ?> value="phonepay"> फोनपे</option>
										
																	</select>	
																	
																</td>
															</tr>
															<tr>
																<th>
																	शिल्लक
																</th>
																<td align="center">
																	<input class="form-control text-center" id="bal" name="balance" value="<?= $rsa['balance'] ?>" readonly>
																</td>
															</tr>
															
														</tbody>
													</table>
									
                                        <button type="submit" name="seeds_booking_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="seeds_category" class="btn btn-dark mt-3">मागे</a>
                                    </form>
					</div>
				</div>
				
			</div>
		</div>
	            <?php else: ?>
							<h5 class="text-muted text-center">बियाणे आवक व जावक  उत्पादने इन्व्हॉईस मिळाले नाही</h5>
							<?php endif ?>
							<?php } else {?>			
		<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">नवीन बियाणे आवक व जावक जोडा</h5>
						</div>
						<hr>
					
				        <form method="post" enctype="multipart/form-data">
                        
                                            <div class="row">
                                            <div class="col-12 col-md-4 mt-2">
                                                        <div class="form-group">
                                                            <label for="bdate" class="form-label">बुकिंग तारीख<span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" name="sdate" id="bdate" required value="<?= date('Y-m-d')?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4 mt-1 ">
                                                        <div class="form-group">
                                                        <label for="name" class="form-label">श्रेणी<span class="text-danger">*</span>
                                                        <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">
										<i class="bx bxs-plus-circle text-success"></i>
									    </button>
                                                        </label>
                                                        <select class="form-select text-start" name="cat_id" required>
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from seeds_category") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
                                                      
                                                         </div>
                                                    </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                        <div class="form-group">
                                                        <label for="name" class="form-label">शेतकऱ्याचे नाव<span class="text-danger">*</span></label>
                                                        <input type="text" name="far_name" class="form-control" id="name" required>
                                                      
                                                         </div>
                                                    </div>
                                                    
                                                     <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                        <label for="village" class="form-label">गाव<span class="text-danger">*</span></label>
                                                        <input type="text" name="village" class="form-control" id="village" required>
                                                      
                                                         </div>
                                                    </div>
        
                                                     <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="customer mobile" class="form-label">मोबाईल नंबर</label><span class="text-danger">*</span>
        
                                                            <input id="customer mobile" type="tel" minlength="10" maxlength="10" name="mob_no" class="form-control" required pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="add" class="form-label">डाग<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="dag" id="add" required oninput="allowType(event, 'number')">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mt-2">
                                                        <div class="form-group">
                                                            <label for="customer mobile" class="form-label">बिल क्रमांक</label><span class="text-danger">*</span>
        
                                                            <input id="customer mobile" type="text" min="0" name="bill_no" class="form-control" required="" oninput="allowType(event,'number')">
                                                        </div>
                                                    </div>
                                            </div>
                                            <table id="invoice-item-table" class="table table-bordered mb-0 mt-3">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th>कृती</th>
																<th width="15%" class="text-nowrap">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start text-nowrap">प्रॉडक्ट विविधता</th>
																<th>प्रमाण</th>
																<th>विविधता</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
																
															</tr>
														</thead>
														<tbody class="align-middle">
															<tr align="center">
																<td>1</td>
																<td>
																	<button type="button" class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>
																</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="pro_cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php //$query = mysqli_query($connect,"select * from product")  //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
																		<!--<option value="<?//= $row1['product_id'] ?>">-->
																			<?//= $row1['product_name'] ?>
																		</option>
																		<?php //endwhile ?>
																		<?php //endif ?>
																	</select>
																</td>
																<td>
																    <input type="text" name="pro_varity[]" class="form-control text-center varity" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
                                                                    <input type="text" name="variety[]" id="variety" class="form-control text-center variety">
                                                                </td>
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																
															</tr>
															<tr class="total-footer">
															    <td colspan="7" rowspan="3"></td>
																<th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center tot_amt" id="final_total_amt" name="total" readonly>
																</td>
															</tr>
															
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" oninput="allowType(event, 'number'),calcTotal()">
																	<select name="pay_mode" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option value="cash">रोख</option>
																		<option value="rtgs">RTGS</option>
																		<option value="neet">NEET</option>
																		<option value="phomepay">फोनपे</option>
																	</select>
																</td>
															</tr>
															
															<tr>
																<th>
																	शिल्लक
																</th>
																<td align="center">
																	<input class="form-control text-center" id="bal" name="balance" readonly>
																</td>
															</tr>
															
														</tbody>
													</table>
                                       
                                        <button type="submit" name="seeds_booking_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="seeds_category" class="btn btn-dark mt-3">मागे</a>
                                    </form>
					</div>
				</div>
				
			</div>
		</div>
		<!--end row-->
	<?php } ?>
				
			</div>
		</div>
		<!--end page wrapper -->
<!-- Modal -->
<div class="modal fade" id="exCatIdModal" tabindex="-1" aria-labelledby="exCatIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exCatIdModalLabel">बियाणे आवक व जावक श्रेणी जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">बियाणे आवक व जावक श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="cat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="seeds_add" class="btn btn-dark mt-3">मागे</a>
                        </form>
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
<script>
$(document).ready(function() {
	$('.number_only').on('input', function() {
		this.value = this.value.replace(/[^0-9]/g, '');
	});
	$('.remove_row').on('click', function() {
	    $(this).closest('tr').remove();
		manageCount();
		calcTotal();
	});

	$("select#pid").change(function() {
		var q = $("#pid option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { pqty: q }
		}).done(function(data) {
			$("#aviqty").val(data);
		});
	});
	
	$("#cus_id").change(function() {
		var b = $("#cus_id option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { balamt: b }
		}).done(function(data) {
			$("#bal_amt").val(data);
		});
	});
});
$('.add_row').on('click', function() {
	const table = $('#invoice-item-table');
	const cloned = $(this).closest('tr').clone();
	cloned.find('.add_row')
		.removeClass('add_row')
		.removeClass('btn-outline-success')
		.addClass('btn-outline-danger')
		.addClass('remove_row').on('click', function() {
			$(this).closest('tr').remove();
			manageCount();
			calcTotal();
		})
		.text('x');
	cloned.find('select, input').val('');
	cloned.find('[name="sid[]"]').val('new');
	cloned.insertBefore('.total-footer', table);
	manageCount();
 	calcTotal();
});

function manageCount() {
	const sr = $('#invoice-item-table tbody tr td:nth-child(1):not([colspan])');
	for (i = 0; i < sr.length; i++) {
		$(sr[i]).text(i + 1);
	}
}

function calcTotal() {
	const table = $('#invoice-item-table');
	const item = $('select', table);
	const qty = $('.item_quantity', table);
	const price = $('.item_price', table);
	const total = $('.final_amount', table);
    const adv = $('#adv').val();
    const amt = $('.tot_amt').val();
	let final = 0;
	for (let i = 0; i < qty.length; i++) {
		const _t = $(qty[i]).val() * $(price[i]).val();
		final += _t;
		$(total[i]).val(_t.toFixed(2));
	}
	$('#final_total_amt').val(final.toFixed(2));
	$('#bal').val((final - Number(adv)).toFixed(2));
}

function changePrice(el) {
	const pid = el.value;
	const row = $(el).closest('tr');
	$.ajax({
		url: "ajax_master",
		method: "POST",
		dataType: 'json',
		data: { get_product_qty_price: pid },
		success: res => {
			$('.item_price', row).val(res.price);
			$('.item_quantity', row).val(res.qty);
			$('.varity', row).val(res.varity);
			calcTotal();
		}
	});
}
function catProduct(el) {
	const cat_id = el.value;
	const row = $(el).closest('tr');
	$.ajax({
		url: "ajax_master",
		method: "POST",
	    data: { cat_product: cat_id }
		}).done(function(data) {
			$(".proid", row).html(data);
		});
	}

//customers state,city,village,taluka
$(document).ready(function(){
    
    $("select#state").change(function(){
          var s = $("#state option:selected").val();
          
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { state : s } 
          }).done(function(data){
              $("#city").html(data);
          });
      });
      
    $("select#city").change(function(){
          var s = $("#city option:selected").val();
          
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { tal : s } 
          }).done(function(data){
              $("#tal").html(data);
          });
      });
      
    $("#tal").change(function(){
          var v = $("#tal option:selected").val();
          //alert(v);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { village : v } 
          }).done(function(data){
              $("#village").html(data);
          });
      });
      
    
    $(".cus_id").change(function() {
		var b = $(".cus_id option:selected").val();
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { gav: b }
		}).done(function(data) {
			$("#gav").val(data);
		});
	});
	
    
    $(".cus_id").change(function() {
		var cus = $(".cus_id option:selected").val();
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { mob: cus }
		}).done(function(data) {
			$("#mob").val(data);
		});
	});
      
  });
</script>  