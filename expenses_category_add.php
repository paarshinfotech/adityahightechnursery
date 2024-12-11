<?php
require_once "config.php";
Aditya::subtitle('नवीन खर्च श्रेणी जोडा');
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
             header('Location: expenses_category_list?action=Success&action_msg='.$ex_cat_name.' खर्च श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO expenses_category(ex_cat_name) VALUES ('$ex_cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: expenses_category_list?action=Success&action_msg='.$ex_cat_name.' नवीन खर्च श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: expenses_category_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

/*------ update details ------*/
if(isset($_POST['ex_cat_edit'])){ 
	escapeExtract($_POST);
	$up="update expenses_category set
	ex_cat_name='{$ex_cat_name}'
	where ex_cat_id='{$_GET['ex_cat_id']}'";

	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: expenses_category_list?action=Success&action_msg= खर्च श्रेणी अपडेट केले...!');
		exit();
	}else{
		header('Location: expenses_category_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['ex_cat_id'])){
            $getCus=mysqli_query($connect,"select * from expenses_category where ex_cat_id='".$_GET['ex_cat_id']."' ");
            $resCus=mysqli_fetch_assoc($getCus);
            extract($resCus);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">खर्च श्रेणी अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">खर्च श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="ex_cat_name" class="form-control" id="cusname" required value="<?= $ex_cat_name?>">
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="ex_cat_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="expenses_category_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन खर्च श्रेणी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">खर्च श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="ex_cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="ex_cat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="expenses_category_list" class="btn btn-dark mt-3">मागे</a>
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