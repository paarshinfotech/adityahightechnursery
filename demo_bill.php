<?php
require_once "config.php";
Aditya::subtitle('नवीन डेमो बिल जोडा');
/*------ Add details ------*/
if (isset($_POST['customer_add'])){
    escapeExtract($_POST);
    
    if (!empty($customer_email)) {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    } else {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: customer_list?action=Success&action_msg='.$customer_name.' डेमो बिल आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO customer(customer_name, customer_mobno, customer_gender, customer_email,state, city, taluka, village) VALUES ('$customer_name','$customer_mobno','$customer_gender','$customer_email','$state','$city','$taluka','$village')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: customer_list?action=Success&action_msg='.$customer_name.' नवीन डेमो बिल जोडले..!');
		exit();
        }else{
        header('Location: customer_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

if(isset($_POST['demo_sales_add'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$payment = $_POST['payment'];
	$total= $_POST['total'];
	$car_rental_amt= $_POST['car_rental_amt'];
	$driver_name= $_POST['driver_name'];
	$advdate= $_POST['advdate'];
	$amt= $_POST['amt'];
	$sub_total = $_POST['sub_total'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	
	$demo_date = $_POST['demo_date'];
	$status = ($balance > 0) ? 'pending' : 'completed';
	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
	if (mysqli_query($connect, "INSERT INTO `sales`(customer_id, sdate, total,car_rental_amt,driver_name,advdate,amt,advance, balance, pay_mode, paystatus, status,demo_status,demo_date) VALUES('$cid', '$sdate', '$total','$car_rental_amt','$driver_name','$advdate','$amt','$advance', '$balance', '$payment', '$paystatus', '$status','0','$demo_date')")) {
		$sales_id = mysqli_insert_id($connect);
		$_salesAdded = true;
		foreach ($pid as $key => $_pid) {
		    
			$saleDetail = mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES('{$sales_id}','{$_pid}','{$quantity[$key]}','{$pprice[$key]}','{$sub_total[$key]}','{$cat_id[$key]}','{$varity[$key]}')");
			if (!$saleDetail) {
				$_salesAdded = false;
			} 
// 			else {
// 				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
// 			}
		}
		if($_salesAdded) {
			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
			// exit();
			header("Location: demo_history?action=Success&action_msg=नवीन डेमो बिल जोडले..!");
    		exit();
            }else{
            header('Location: demo_history?action=Success&action_msg=काहीतरी चूक झाली');
          	exit();
            }
	}
}

// if(isset($_POST['demo_sales_edit'])){
// 	escapePOST($_POST);
// 	$cid = $_POST['customer_id'];
// 	$sdate = $_POST['sdate'];
// 	$pid = $_POST['pid'];
// 	$quantity = $_POST['pqty'];
// 	$pprice = $_POST['pprice'];
// 	$payment = $_POST['payment'];
// 	$total= $_POST['total'];
// 	$car_rental_amt= $_POST['car_rental_amt'];
// 	$driver_name= $_POST['driver_name'];
// 	$advdate= $_POST['advdate'];
// 	$amt= $_POST['amt'];
// 	$sub_total = $_POST['sub_total'];
// 	$advance = $_POST['advance'];
// 	$balance = $_POST['balance'];
// 	$cat_id = $_POST['cat_id'];
// 	$varity = $_POST['varity'];
// 	$demo_date = $_POST['demo_date'];
	
// 	$status = ($balance > 0) ? 'pending' : 'completed';
// 	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
// 	if (mysqli_query($connect, "UPDATE sales SET customer_id = '{$cid}',sdate = '{$sdate}',total = '{$total}',car_rental_amt = '{$car_rental_amt}',driver_name = '{$driver_name}',advdate='{$advdate}',amt='{$amt}',  advance = '{$advance}',balance = '{$balance}',pay_mode = '{$payment}', paystatus = '{$paystatus}' , status = '{$status}', demo_date = '{$demo_date}' WHERE sale_id = '{$_GET['sale_id']}'")) {
// 		$sales_id = mysqli_insert_id($connect);
// 		$_salesAdded = true;
// 		foreach ($pid as $key => $_pid) {
		    
// 			$saleDetail = mysqli_query($connect, "UPDATE sales_details SET pid = '{$pid[$key]}', pqty = '{$quantity[$$key]}', pprice = '{$pprice[$key]}', sub_total = '{$sub_total[$key]}',cat_id = '{$cat_id[$key]}', varity = '{$varity[$key]}' WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$key]}'");
// 			if (!$saleDetail) {
// 				$_salesAdded = false;
// 			} 
// // 			else {
// // 				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
// // 			}
// 		}
// 		if($_salesAdded) {
// 			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
// 			// exit();
// 			header("Location: demo_history?action=Success&action_msg= डेमो बिल अपडेट केले..!");
//     		exit();
//             }else{
//             header('Location: demo_history?action=Success&action_msg=काहीतरी चूक झाली');
//           	exit();
//             }
// 	}
// }

if(isset($_POST['demo_sales_edit'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	
	$sid = $_POST['sid'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$sub_total = $_POST['sub_total'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	
	$demo_date = $_POST['demo_date'];
	
	$total = $_POST['total'];
	$car_rental_amt = $_POST['car_rental_amt'];
	$driver_name = $_POST['driver_name'];
	$advdate = $_POST['advdate'];
	$amt = $_POST['amt'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$payment = $_POST['payment'];
	$paystatus = ($balance>0) ? 'unpaid' : 'paid' ;
	$status = ($paystatus!='unpaid') ? 'completed' : 'pending';
	if (mysqli_query($connect, "UPDATE sales SET customer_id = '{$cid}',sdate = '{$sdate}',total = '{$total}',car_rental_amt = '{$car_rental_amt}',driver_name = '{$driver_name}',advdate='{$advdate}',amt='{$amt}',  advance = '{$advance}',balance = '{$balance}',pay_mode = '{$payment}', paystatus = '{$paystatus}' , status = '{$status}', demo_date = '{$demo_date}' WHERE sale_id = '{$_GET['sale_id']}'")) {
	    $sid_in = '('.implode(', ', $sid).')';
	    $getDeleteSale = mysqli_query($connect, "SELECT pid, pqty FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
	   // if (mysqli_num_rows($getDeleteSale) > 0) {
	   //     while($delRow = mysqli_fetch_assoc($getDeleteSale)) {
	   //         mysqli_query($connect, "UPDATE product SET product_qty = (product_qty + {$delRow['pqty']}) WHERE product_id = '{$delRow['pid']}'");
	   //     }
	   // }
	    mysqli_query($connect, "DELETE FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
	    $insert = true;
	    foreach ($sid as $_i => $_sid) {
	        if ($_sid=='new') {
	            // add if new
	            if (!mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES ('{$_GET['sale_id']}', '{$pid[$_i]}', '{$quantity[$_i]}', '{$pprice[$_i]}', '{$sub_total[$_i]}','{$cat_id[$_i]}','{$varity[$_i]}')")) {
	                $insert = false;
	            } 
	           // else {
	           //     mysqli_query($connect, "UPDATE product SET product_qty = (product_qty - {$quantity[$_i]}) WHERE product_id = '{$pid[$_i]}'");
	           // }
	        } else {
	            // update
	            $get_old_product = mysqli_query($connect, "SELECT pqty FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'");
	            $old_pqty = 0;
	            if (mysqli_num_rows($get_old_product)>0) {
	                $old_pqty = (int) mysqli_fetch_assoc($get_old_product)['pqty'];
	            }
	            if(!mysqli_query($connect, "UPDATE sales_details SET pid = '{$pid[$_i]}', pqty = '{$quantity[$_i]}', pprice = '{$pprice[$_i]}', sub_total = '{$sub_total[$_i]}',cat_id = '{$cat_id[$_i]}', varity = '{$varity[$_i]}' WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'")) {
	                $insert = false;
	            } 
	           // else {
	           //     if ($quantity[$_i] > $old_pqty) {
	           //         // substract
	           //         $_qty = $quantity[$_i] - $old_pqty;
	           //         mysqli_query($connect, "UPDATE product SET product_qty = (product_qty - {$_qty}) WHERE product_id = '{$pid[$_i]}'");
	           //     } elseif ($quantity[$_i] < $old_pqty) {
	           //         // addition
	           //         $_qty = $old_pqty - $quantity[$_i];
	           //         mysqli_query($connect, "UPDATE product SET product_qty = (product_qty + {$_qty}) WHERE product_id = '{$pid[$_i]}'");
	           //     }
	           // }
	        }
	    }
	    if ($insert) {
	        header("Location: demo_history?action=Success&action_msg=डेमो बिल अपडेट केले..!");
    		exit();
	    } else {
	        header("Location: demo_history?sale_id='{$_GET['sale_id']}'");
	        exit();
	    }
	} else {
	    header("Location: demo_history?sale_id='{$_GET['sale_id']}'");
	    exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
	            <?php
						if(isset($_GET['sale_id'])){
						      $rsa = false;
							  $gets=mysqli_query($connect,"SELECT * FROM sales WHERE sale_id='{$_GET['sale_id']}'");
							  if (mysqli_num_rows($gets) > 0) {
							      $rsa = mysqli_fetch_assoc($gets);
							      $getSaleDetail = mysqli_query($connect, "SELECT * FROM sales_details WHERE sale_id = '{$rsa['sale_id']}'");
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
			<div class="col-xl-12 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-success">डेमो बिल अपडेट करा</h5>
						</div>
						<hr>
					    
							<form method="post">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td align="center">
													<h4>डेमो अद्यतनित करा</h4>
												</td>
											</tr>
											<tr>
												<td>
													<div class="row justify-content-between">
														



														<div class="col-12 col-md-4" id="serch_input_customer">
                                                            <label class="form-label fw-bold">ग्राहक</label>
                                                            <div class="input-group search-box" id="Search_input_fild">
                                                                <?php
                                                                        $getcustomert = mysqli_query($connect, "SELECT * FROM customer WHERE customer_status=1 AND customer_id = " . $rsa['customer_id'] . " LIMIT 1");

                                                                        if ($getcustomert && mysqli_num_rows($getcustomert) > 0) {
                                                                            $getcus = mysqli_fetch_assoc($getcustomert);
                                                                            ?>
                                                                <input type="text" name="customer_Search"
                                                                    value="<?php echo $getcus['customer_name'] ?>"
                                                                    id="customer_search" class="form-control mb-3"
                                                                    oninput="searchCustomers(this.value)"
                                                                    placeholder="ग्राहक शोधा..." required>

                                                                <?php
                                                                        }
                                                                        ?>


                                                                <input type="hidden" name="customer_id" id="customer_id"
                                                                    value="<?php echo $rsa['customer_id'] ?>" required>
                                                            </div>
                                                            <div class="search-results position-relative"
                                                                id="customer_search_results_Div">
                                                            </div>
                                                        </div>





														<div class="col-12 col-md-3 mt-4">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#customer" data-bs-whatever="@mdo">+</button>
														</div><br>
														<div class="col-12 col-md-3">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="sdate" id="order_date" class="form-control mb-3" value="<?= date('Y-m-d', strtotime($rsa['sdate']))?>">
														</div>
														<div class="col-12 col-md-3">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="demo_date" id="demo_date" class="form-control mb-3" value="<?= $rsa['demo_date']?>">
														</div>
													</div>
													<table id="invoice-item-table" class="table table-bordered mb-0">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<!--<th>कृती</th>-->
																<th width="15%" class="text-start">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
																<th width="10%">प्रमाण</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
																
															</tr>
														</thead>
														<tbody class="align-middle">
														    <?php if ($rsa['sale_details'] && count($rsa['sale_details'])>0): ?>
														    <?php foreach ($rsa['sale_details'] as $k => $sdtls): ?>
														    <tr align="center">
																<td><?= $k + 1 ?></td>
																<!--<td>-->
																<!--	<button type="button" class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>-->
																<!--</td>-->
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>" <?= ($sdtls['cat_id'] == $row1['cat_id']) ? 'selected' : '' ?>>
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
																    <input type="text" name="varity[]" class="form-control text-center varity" value="<?= $sdtls['varity'] ?>" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" value="<?= $sdtls['pqty'] ?>" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" value="<?= $sdtls['pprice'] ?>" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" value="<?= $sdtls['sub_total'] ?>" readonly class="form-control text-center final_amount">
																</td>
																<!--<td>-->
																<!--	<button type="button" class="btn btn-sm btn-outline-<?//= $k==0 ? 'success add_row' : 'danger remove_row' ?> fw-bold text-center"><?//= $k==0 ? '+' : 'x' ?></button>-->
																<!--</td>-->
															</tr>
														    <?php endforeach ?>
														    <?php else: ?>
														    <tr align="center">
																<td>1</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
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
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																
															</tr>
														    <?php endif ?>
															<tr class="total-footer">
																<td colspan="5" rowspan="7"></td>
															    <th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center final_total_amt" id="final_total_amt" name="total" value="<?= $rsa['total'] ?>" readonly>
																</td>
																
															</tr>
														    <tr>
																<th>
																	गाडी भाडे

																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="car_rental" placeholder="कार भाड्याची रक्कम" name="car_rental_amt" value="<?= $rsa['car_rental_amt'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																	<input class="form-control text-center my-3" id="car_name" name="driver_name" placeholder="ड्राइवर नाव" value="<?= $rsa['driver_name'] ?>">
																</td>
																<td rowspan="7"></td>
															</tr>
															<tr>
															    <th>
																	एकूण
																</th>
																<td align="center">
																    <?php //$gt = $rsa['amt'] + $rsa['car_rental_amt'] ?>
																	<input type="text" class="form-control text-center amt"  readonly value="<?= $rsa['amt']?>">
																</td>
																
															</tr>
															<tr>
																<th>
																	तारीख
																</th>
																<td align="center">
																	<input type="date" class="form-control text-center mb-2" id="advdate" name="advdate" value="<?= $rsa['advdate']?>">
																	<input class="form-control text-center subadvance" name="amt" oninput="allowType(event, 'number'),calcTotal()" value="<?= $rsa['amt']?>">
																</td>
															</tr>
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" value="<?= $rsa['advance'] ?>" oninput="allowType(event, 'number'),calcTotal()">
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
															<tr>
																<th>पेमेंट निवडा</th>
																<td colspan="1">
																	<select name="payment" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option <?= ($rsa['pay_mode']=='cash') ? 'selected' : '' ?> value="cash">रोख</option>
																		<option <?= ($rsa['pay_mode']=='sbi') ? 'selected' : '' ?> value="sbi">आदित्य नर्सरी SBI</option>
																		<option <?= ($rsa['pay_mode']=='mgb') ? 'selected' : '' ?> value="mgb">आदित्य नर्सरी MGB</option>
																		<option <?= ($rsa['pay_mode']=='ds_bank') ? 'selected' : '' ?> value="ds_bank">डीएस बँक</option>
																		<option <?= ($rsa['pay_mode']=='other_bank') ? 'selected' : '' ?> value="other_bank">इतर बँक</option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th class="text-center">
													<input type="submit" name="demo_sales_edit" id="create_invoice" class="btn btn-success" value="बिल अपडेट करा">
                                            <a href="demo_history" class="btn btn-dark ">मागे</a>
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							<?php else: ?>
							<h5 class="text-muted text-center">सेल्स इन्व्हॉईस मिळाले नाही</h5>
							<?php endif ?>
							
					</div>
				</div>
				
			</div>
		</div>
			<?php } else {?>
		<div class="row">
			<div class="col-xl-12 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-success">नवीन डेमो बिल जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td align="center">
													<h4>नवीन डेमो तयार करा</h4>
												</td>
											</tr>
											<tr>
												<td>
													<div class="row justify-content-between">
													<div class="col-12 col-md-3" id="serch_input_customer">
                                                            <label class="form-label fw-bold">ग्राहक</label>
                                                            <div class="input-group search-box" id="Search_input_fild">
                                                                <input type="text" name="customer_Search"
                                                                    id="customer_search" class="form-control mb-3"
                                                                    oninput="searchCustomers(this.value)"
                                                                    placeholder="ग्राहक शोधा..." required>
                                                                <input type="hidden" name="customer_id" id="customer_id"
                                                                    required>
                                                            </div>
                                                            <div class="search-results position-relative"
                                                                id="customer_search_results_Div">
                                                            </div>
                                                        </div>
														<div class="col-12 col-md-3 mt-4">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#customer" data-bs-whatever="@mdo">+</button>
														</div><br>
														<div class="col-12 col-md-3">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="sdate" id="order_date" class="form-control mb-3" value="<?= date('Y-m-d')?>">
														</div>
														<div class="col-12 col-md-3">
															<lable class="form-lable fw-bold">डेमो तारीख</lable>
															<input type="date" name="demo_date" id="demo_date" class="form-control mb-3">
														</div>
													</div>
													<table id="invoice-item-table" class="table table-bordered mb-0">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th>कृती</th>
																<th width="15%" class="text-nowrap">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
																<th width="10%">प्रमाण</th>
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
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
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
																    <input type="text" name="varity[]" class="form-control text-center varity" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																
															</tr>
															<tr class="total-footer">
															    <td colspan="6" rowspan="7"></td>
																<th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center tot_amt" id="final_total_amt" name="total" readonly>
																</td>
															</tr>
															<tr>
																<th>
																गाडी भाडे 
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="car_rental" placeholder="कार भाड्याची रक्कम" name="car_rental_amt" oninput="allowType(event, 'number'),calcTotal()">
																	<input class="form-control text-center my-3" id="car_name" name="driver_name" placeholder="ड्राइवर नाव">
																</td>	
																</td>
																<td rowspan="6"></td>
															</tr>
															
															<tr>
																<th>
																 एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center amt" readonly>
																</td>
															</tr>
															<tr>
															    <th>
																	तारीख
																</th>
																<td align="center">
																	<input type="date" class="form-control text-center mb-2" id="advdate" name="advdate" value="<?= date('Y-m-d')?>">
																	<input class="form-control text-center subadvance" name="amt" oninput="allowType(event, 'number'),calcTotal()">
																</td>
															</tr>
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" oninput="allowType(event, 'number'),calcTotal()">
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
															<tr>
																<th>Select Payment</th>
																<td colspan="1">
																	<select name="payment" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option value="cash">रोख</option>
																		<option value="sbi">आदित्य नर्सरी SBI</option>
																		<option value="mgb">आदित्य नर्सरी MGB</option>
																		<option value="ds_bank">डीएस बँक</option>
																		<option value="other_bank">इतर बँक</option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th class="text-center">
													<input type="submit" name="demo_sales_add" id="create_invoice" class="btn btn-success" value="डेमो बिल करा">
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							<?php } ?>
					</div>
				</div>
				
			</div>
		</div>
		<!--end row-->
	
			</div>
		</div>
		<!--end page wrapper -->
	
<?php include "footer.php"; ?>
<div class="modal fade" id="customer" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="advLabel">नवीन ग्राहक जोडा</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
							<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname" placeholder="ग्राहकाचे नाव" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email" placeholder="इमेल आयडी">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                        <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel" placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control" required oninput="allowType(event, 'mobile')">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">लिंग</label>
                                        <br>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="male" name="customer_gender" class="form-check-input" id="male" checked>
                                            <label class="form-check-label" for="male">पुरुष</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="female" name="customer_gender" class="form-check-input" id="female">
                                            <label class="form-check-label" for="female">महिला</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="other" name="customer_gender" class="form-check-input" id="other">
                                            <label class="form-check-label" for="other">इतर</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य</label>
                                            <select name="state" id="state" class="form-select">
												<option selected>निवडा...</option>
							<?php $getStates = mysqli_query($connect,"select * from states"); ?>
							<?php if (mysqli_num_rows($getStates)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
							<option value="<?= $stRow['sname']?>">
								<?= $stRow['sname']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
									</div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">जिल्हे </label>
                                        <select class="form-select" id="city" name="city">
							                <option>निवडा...</option>
						                </select>                                    
						            </div>
                                </div>
                                
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">तालुका</label>
                                            <select class="form-select" id="tal" name="taluka">
							                    <option>निवडा...</option>
						                    </select>  
									</div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">गाव</label>
                      <!--                  <select class="form-select" id="village" name="village">-->
							               <!--     <option>निवडा...</option>-->
						                <!--</select>                                   -->
						                 <input type="text" class="form-control" id="village" name="village">
						            </div>
                                </div>
                            </div>     
                            
                            <!--<div class="row">-->
                            <!--   <div class="col-12">-->
                            <!--        <label for="Address" class="form-label">Address</label>-->
                                   
                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_info"></textarea>-->
                                   
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <button type="submit" name="customer_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="customer_list" class="btn btn-dark mt-3">मागे</a>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
	$("#bal_amt, #adv_amt").on("input change", advsub);
	calcTotal();
	
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
    const amt = $('.amt').val();
	let final = 0;
	for (let i = 0; i < qty.length; i++) {
		const _t = $(qty[i]).val() * $(price[i]).val();
		final += _t;
		$(total[i]).val(_t.toFixed(2));
	}
	$('#final_total_amt').val(final.toFixed(2));
	let car = Number($('#car_rental').val());
	let gr_total = final + car;
	$('.amt').val(gr_total.toFixed(2));
    $('#bal').val((gr_total - Number($('.subadvance').val()) - Number(adv)).toFixed(2));
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

function advsub() {
    let amt = $('#bal_amt').val();
    let adv = $('#adv_amt').val();
    let _resbal = Number(amt) - Number(adv);
    
    $('#totbal').val(!isNaN(_resbal) ? _resbal : 0).trigger('change');
}

$(document).ready(function() {
	$("select#pur_id").change(function() {
		var q = $("#pur_id option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { qty: q }
		}).done(function(data) {
			$("#pur_qty").val(data);
		});
	});
});
$(document).ready(function() {
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
});

//customer state,city,village
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
  });
   $(document).ready(function(){
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
  });
  
  $(document).ready(function(){
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
  });
</script>		

<script src="https://code.jquery.com/jquery-3.6.4.min.js">
</script>
<script>
function searchCustomers(value) {
    //console.log(value)
    $.ajax({
        type: "GET",
        url: "ajax_load_customer_data",
        data: {
            searchInput: value
        },
        success: function(data) {
            $('#customer_search_results_Div').html(
                data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function updateCustomerSearch(ID, Name) {
    // Assuming you have the input field with id 'customer_search'
    // $('#customer_search').val(value);
    //console.log(ID, Name)
    $('#customer_search').val(Name);
    $('#customer_id').val(ID);
    $('#customer_search_results_Div').html('');

}
</script>