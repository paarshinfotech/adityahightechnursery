<?php
require_once "config.php";
Aditya::subtitle('नवीन झेंडू श्रेणी जोडा');
/*------ Add details ------*/
if (isset($_POST['cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($cat_name)) {
        $sql="SELECT * FROM marigold_category WHERE cat_name='$cat_name'";
    } else {
        $sql="SELECT * FROM marigold_category WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: zendu_cat_list?action=Success&action_msg='.$cat_name.' झेंडू श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO marigold_category(pt_id,cat_name,cat_qty,cat_date) VALUES ('$pt_id','$cat_name','$cat_qty','".date('Y-m-d')."')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: zendu_cat_list?action=Success&action_msg='.$cat_name.' नवीन झेंडू श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: zendu_cat_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

/*------ update details ------*/
if(isset($_POST['cat_edit'])){ 
	escapeExtract($_POST);
	$up="update marigold_category set
	        pt_id='$pt_id',
            cat_name = '$cat_name',
            cat_qty = '$cat_qty'
            where cat_id = '".$_GET['cat_id']."'";
	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: zendu_cat_list?action=Success&action_msg= झेंडू श्रेणी अपडेट केले...!');
		exit();
	}else{
		header('Location: zendu_cat_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['cat_id'])){
            $getCat=mysqli_query($connect,"select * from marigold_category where cat_id='".$_GET['cat_id']."' ");
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
							<h5 class="mb-0 text-success">झेंडू श्रेणी अपडेट करा</h5>
						</div>
						<hr>
				
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">वनस्पती प्रकार<span class="text-danger">*</span></label>
                                                <select name="pt_id" class="form-control mb-3" required><option value="">प्रकार निवडा</option>	
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
                                                <input type="text" name="cat_name" class="form-control" id="cusname" required value="<?= $cat_name?>">
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6">

                                                <div class="form-group">
                                                    <label for="qty" class="form-label">श्रेणी संख्या <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="cat_qty" required id="qty" value="<?= $cat_qty?>" oninput="allowType(event,'number')">
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="submit" name="cat_edit" class="btn btn-success me-2 text-white mt-3">Submit</button>
                                        <a href="zendu_cat_list" class="btn btn-dark mt-3">Back</a>
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
							<h5 class="mb-0 text-success">नवीन झेंडू श्रेणी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">वनस्पती प्रकार<span class="text-danger">*</span></label>
                                                <select name="pt_id" class="form-control mb-3" required><option>प्रकार निवडा</option>	
										<?php $type = mysqli_query($connect,"SELECT * from plant_type") ?>
									
										<?php while ($plant=mysqli_fetch_assoc($type)):?>
										<option value="<?= $plant['pt_id'] ?>"><?= $plant['pt_name'] ?></option>
										<?php endwhile ?>
								
														</select>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">श्रेणीचे नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6">

                                                <div class="form-group">
                                                    <label for="qty" class="form-label">श्रेणी संख्या <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="cat_qty" required id="qty" oninput="allowType(event,'number')">
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="submit" name="cat_add" class="btn btn-success me-2 text-white mt-3">Submit</button>
                                        <a href="zendu_cat_list" class="btn btn-dark mt-3">Back</a>
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