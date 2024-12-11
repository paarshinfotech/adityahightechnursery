<?php
require_once "config.php";
Aditya::subtitle('नवीन झेंडू उपवर्ग श्रेणी जोडा');
/*------ Add details ------*/
if (isset($_POST['subcat_add'])){
    escapeExtract($_POST);
    
     $insert= "INSERT INTO marigold_subcategory(pt_id,cat_id,subcat_name,subcat_qty,subcat_date) VALUES ('$pt_id','$cat_id','$subcat_name','$subcat_qty','".date('Y-m-d')."')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: zendu_subcat_list?action=Success&action_msg='.$cat_name.' नवीन झेंडू उपवर्ग श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: zendu_subcat_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

/*------ update details ------*/
if(isset($_POST['subcat_edit'])){ 
	escapeExtract($_POST);
	$up="UPDATE marigold_subcategory SET
            pt_id='".$pt_id."',
            cat_id = '".$cat_id."',
            subcat_name = '".$subcat_name."',
            subcat_qty = '".$subcat_qty."'
            where subcat_id = '".$_GET['subcat_id']."'";
	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: zendu_subcat_list?action=Success&action_msg= झेंडू उपवर्ग श्रेणी अपडेट केले...!');
		exit();
	}else{
		header('Location: zendu_subcat_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['subcat_id'])){
            $getCat=mysqli_query($connect,"select * from marigold_subcategory where subcat_id='" .$_GET['subcat_id'] ."'");
            $resCat=mysqli_fetch_assoc($getCat);
            extract($resCat);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">झेंडू उपवर्ग श्रेणी अपडेट करा</h5>
						</div>
						<hr>
				
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">वनस्पती प्रकार<span class="text-danger">*</span></label>
                                                <select name="pt_id" class="form-control mb-3" required><option>प्रकार निवडा..</option>	
										<?php $type = mysqli_query($connect,"SELECT * from plant_type") ?>
									
										<?php while ($plant=mysqli_fetch_assoc($type)):?>
										<option value="<?= $plant['pt_id'] ?>"<?php if($plant['pt_id']==$pt_id){echo "selected";}?>><?= $plant['pt_name'] ?></option>
										<?php endwhile ?>
								
														</select>
                                                            </div>
                                            </div>
                                             <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">श्रेणीचे नाव<span class="text-danger">*</span></label>
                                                <select name="cat_id" class="form-control mb-3" required><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['cat_id'] ?>" <?php if($getcus['cat_id']==$cat_id){echo "selected";}?>><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">श्रेणीचे नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="subcat_name" class="form-control" id="cusname" required value="<?= $subcat_name?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">

                                                <div class="form-group">
                                                    <label for="qty" class="form-label">उपश्रेणी प्रमाण</label>
                                                    <input type="text" class="form-control" name="subcat_qty" id="qty" value="<?= $subcat_qty?>" oninput="allowType(event,'number')">                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="submit" name="subcat_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="zendu_subcat_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन झेंडू उपवर्ग श्रेणी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="pt_id" class="form-label">वनस्पती प्रकार<span class="text-danger">*</span></label>
                                                <select name="pt_id" class="form-control mb-3" required><option value="">निवडा..</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from plant_type") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['pt_id'] ?>"><?= $getcus['pt_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">श्रेणीचे नाव<span class="text-danger">*</span></label>
                                                <select name="cat_id" class="form-control mb-3" required><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['cat_id'] ?>"><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">श्रेणीचे नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="subcat_name" class="form-control" id="cusname" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">

                                                <div class="form-group">
                                                    <label for="qty" class="form-label">उपश्रेणी प्रमाण</label>
                                                    <input type="text" class="form-control" name="subcat_qty" id="qty" oninput="allowType(event,'number')">                                                </div>
                                            </div>
                                            <!--  <div class="col-12 col-md-3">-->

                                            <!--    <div class="form-group">-->
                                            <!--        <label for="rate" class="form-label">Rate</label>-->
                                            <!--        <input type="number" class="form-control" name="rate" id="rate" >-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            <!--  <div class="col-12 col-md-3">-->

                                            <!--    <div class="form-group">-->
                                            <!--        <label for="total_rs" class="form-label">Total Rs</label>-->
                                            <!--        <input type="text" class="form-control" name="total_rs" id="total_rs"  readonly>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>

                                        
                                        <button type="submit" name="subcat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="zendu_subcat_list" class="btn btn-dark mt-3">मागे</a>
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