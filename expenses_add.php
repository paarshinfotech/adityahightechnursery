<?php
require_once "config.php";
Aditya::subtitle('नवीन खर्च जोडा');
/*------ Add details ------*/
if (isset($_POST['ex_cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($ex_cat_name)) {
        $sql="SELECT * FROM expenses_category WHERE ex_cat_name='$ex_cat_name'";
    } else {
        $sql="SELECT * FROM expenses_category WHERE ex_cat_name='$ex_cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: expenses_add?action=Success&action_msg='.$ex_cat_name.' खर्च श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO expenses_category(ex_cat_name) VALUES ('$ex_cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: expenses_add?action=Success&action_msg='.$ex_cat_name.' नवीन खर्च श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: expenses_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

if (isset($_POST['expense_add'])){
	escapeExtract($_POST);
	/* invoice */
	$today = date('Y-m-d');
	$name = $_FILES['ex_invoice']['name'];
	$temp = $_FILES['ex_invoice']['tmp_name'];
	$ex_invoice = NULL;
	if($name){
		$upload1 = "image/expense/";
		$imgExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		$ex_invoice = 'INVOICE-'.date('YmdHis').rand(1000,9999).".".$imgExt;
		move_uploaded_file($temp,$upload1.$ex_invoice);
	}
	
	$ex = "INSERT INTO expenses(ex_cat_id,ex_name,ex_for,ex_invoice, ex_type, ex_create_date, ex_date, ex_amt, ex_note, payment_mode) VALUES('{$ex_cat_id}','{$ex_name}','{$ex_for}','{$ex_invoice}','{$ex_type}','{$today}','{$ex_date}','{$ex_amt}','{$ex_note}','{$payment_mode}')";
	
	$exv = mysqli_query($connect,$ex);
	 
	if($exv){
		header('Location: expenses?ex_cat_id='.$ex_cat_id.'&action=Success&action_msg='.$ex_name.' नवीन खर्च जोडले..!');
		exit();
	}else{
		header('Location: expenses_add?action=Success&action_msg=काहीतरी चूक झाली');
		exit();
	}
}

//select invoice
error_reporting(0);
$getexI="select ex_invoice from expenses where ex_id='{$_GET['ex_id']}'";
$expesesIn=mysqli_query($connect,$getexI);
$resInvoice=mysqli_fetch_assoc($expesesIn);
            	
if(isset($_POST['expense_edit'])){
	escapeExtract($_POST);
	/* invoice */
	
	$name = $_FILES['ex_invoice']['name'];
	$temp = $_FILES['ex_invoice']['tmp_name'];
    $ex_invoice = 'NULL';
	if($name){
		$upload1 = "image/expense/";
		$imgExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		$ex_invoice = 'INVOICE-'.date('YmdHis').rand(1000,9999).".".$imgExt;
		if(move_uploaded_file($temp,$upload1.$ex_invoice)) {
			unlink($upload1.$old_invoice);
		}
	}
	else{
		$ex_invoice = $resInvoice['ex_invoice'];
	}
		$upe="UPDATE expenses SET 
		ex_cat_id='$ex_cat_id',
		ex_name='$ex_name',
		ex_for='$ex_for',
		ex_invoice='$ex_invoice',
		ex_type='$ex_type',
		ex_date='$ex_date',
		ex_amt='$ex_amt',
		ex_note='$ex_note',
		payment_mode='$payment_mode'
		WHERE ex_id='{$_GET['ex_id']}'";
		
		$upev = mysqli_query($connect,$upe);
		if($upev){
			header('Location: expenses?ex_cat_id='.$ex_cat_id.'&action=Success&action_msg='.$ex_name.'खर्च अपडेट केले..!');
		exit();
    	}else{
    		header('Location: expenses_add?action=Success&action_msg=काहीतरी चूक झाली');
    		exit();
    	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
	         <?php
        	    if(isset($_GET['ex_id'])){
            	$ex="select * from expenses where ex_id='{$_GET['ex_id']}'";
            	$expeses=mysqli_query($connect,$ex);
            	$res=mysqli_fetch_assoc($expeses);
            	extract($res);
            ?>
				<div class="row">
		    	<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">खर्च अपडेट करा</h5>
						</div>
						<hr>
					   
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                <label for="ex_name" class="form-label">खर्च श्रेणी<span class="text-danger">*</span>
          <!--                                      <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">-->
										<!--<i class="bx bxs-plus-circle p-1 ms-1 text-success"></i>-->
									 <!--   </button>-->
                                                </label>
                                                <select name="ex_cat_id" id="ex_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from expenses_category order by ex_cat_id desc") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['ex_cat_id'] ?>"<?php if($getcus['ex_cat_id']==$ex_cat_id){echo "selected";}?>><?= $getcus['ex_cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                <div class="form-group">
                                                <label for="ex_name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="ex_name" class="form-control" id="ex_name" required value="<?= $ex_name?>">
                                                            </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-4 mt-2">

                                                <div class="form-group">
                                                    <label for="ex_for" class="form-label">खर्चाचे कारण<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="ex_for" id="ex_for" required value="<?= $ex_for?>">
                                                </div>
                                            </div>
                                             <div class="col-md-6 mt-2">
														<label for="inputFirstName" class="form-label">खर्चाचा प्रकार</label>
														<input type="text" name="ex_type" class="form-control" id="inputFirstName" value="<?php echo $ex_type;?>">
													</div>
													<div class="col-md-6 mt-2">
														<label for="inputPassword" class="form-label">तारीख</label>
														<input type="date" name="ex_date" max="<?php echo date('Y-m-d'); ?>" class="form-control datepicker" id="inputPassword" value="<?php echo $ex_date; ?>">
													</div>
                                       
                                            	<div class="col-md-6 mt-2">
														<label for="inputLastName" class="form-label">रक्कम <span class="text-danger">*</span></label>
														<input type="text" name="ex_amt" oninput="allowType(event, 'number')" class="form-control" id="inputLastName" value="<?php echo $ex_amt;?>" required>
													</div>
													<div class="col-md-6 mt-2">
														<label for="inputLastName" class="form-label">पेमेंट मोड</label>
														<input type="text" name="payment_mode" class="form-control" id="inputLastName" value="<?php echo $payment_mode;?>">
													</div>
                                        	<div class="col-md-4">
														<label for="inputPassword" class="form-label">खर्च बीजक</label>
														<input type="hidden" name="old_invoice" value="<?= $ex_invoice ?>">
														<input type="file" name="ex_invoice" class="form-control" accept=".jpg, .png, .pdf">
													</div>
													<div class="col-md-2">
														<div class="form-label">&nbsp;</div>
														<div class="text-muted small">
															<?= $ex_invoice ?>
														</div>
													</div>
													<div class="col-md-6 mt-2">
														<label for="inputAddress" class="form-label">नोंद</label>
														<textarea class="form-control" id="inputAddress" name="ex_note" placeholder="" rows="3"><?php echo $ex_note; ?></textarea>
													</div>
										</div>
                                        <button type="submit" name="expense_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="expenses_category" class="btn btn-dark mt-3">मागे</a>
                                    </form>
					</div>
				</div>
				
			</div>
		</div>
	<?php }else{ ?>			
		<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">नवीन खर्च जोडा</h5>
						</div>
						<hr>
					
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                <label for="ex_name" class="form-label">खर्च श्रेणी<span class="text-danger">*</span> 
                                                <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">
										<i class="bx bxs-plus-circle p-1 ms-1 text-success"></i>
									    </button>
									</label>
                                                <select name="ex_cat_id" id="ex_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from expenses_category order by ex_cat_id desc") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['ex_cat_id'] ?>"><?= $getcus['ex_cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">
                                                <div class="form-group">
                                                <label for="ex_name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="ex_name" class="form-control" id="ex_name" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-4 mt-2">

                                                <div class="form-group">
                                                    <label for="ex_for" class="form-label">खर्चाचे कारण<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="ex_for" id="ex_for" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="ex_type" class="form-label">खर्चाचा प्रकार<span class="text-danger">*</span></label>
                                                <input type="text" name="ex_type" class="form-control" id="ex_type" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="ex_date" class="form-label">तारीख</label>
                                                    <input type="date" class="form-control" name="ex_date" id="ex_date" value="<?= date('Y-m-d');?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="ex_amt" class="form-label">रक्कम <span class="text-danger">*</span></label>

                                                    <input oninput="allowType(event, 'number')" id="ex_amt" type="text"  name="ex_amt" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="payment_mode" class="form-label">पेमेंट मोड</label>
                                                        <input id="payment_mode" type="tel" name="payment_mode" class="form-control">
                                                </div>
                                            </div>

                                          
                                        </div>
                                        
                                        <div class="row">
                                           <div class="col-12 col-lg-6">
                                                <label for="Address" class="form-label">खर्च बीजक</label>
                                               
                                               <input type="file" name="ex_invoice" class="form-control" accept=".jpg, .png, .pdf">
                                               
                                            </div>
                                       
                                           <div class="col-12 col-lg-6">
                                                <label for="ex_note" class="form-label">नोंद</label>
                                               
                                                <textarea id="ex_note" class="form-control" placeholder="" name="ex_note"></textarea>
                                               
                                            </div>
                                        </div>
                                       
                                        
                                        <button type="submit" name="expense_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="expenses_category" class="btn btn-dark mt-3">मागे</a>
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
		
<?php include "footer.php"; ?>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exCatIdModal" tabindex="-1" aria-labelledby="exCatIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exCatIdModalLabel">नवीन खर्च श्रेणी जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">खर्च श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="ex_cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="ex_cat_add" class="btn btn-sm btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="expenses_add" class="btn btn-sm btn-dark mt-3">मागे</a>
                        </form>
      </div>
    </div>
  </div>
</div>