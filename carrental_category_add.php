<?php
require_once "config.php";
Aditya::subtitle('नवीन गाडी भाडे श्रेणी जोडा');
/*------ Add details ------*/
if (isset($_POST['cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($cat_name)) {
        $sql="SELECT * FROM car_rental_category WHERE cat_name='$cat_name'";
    } else {
        $sql="SELECT * FROM car_rental_category WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: carrental_category_list?action=Success&action_msg='.$cat_name.' गाडी भाडे श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO car_rental_category(cat_name) VALUES ('$cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: carrental_category_list?action=Success&action_msg='.$cat_name.' नवीन गाडी भाडे श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: carrental_category_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

/*------ update details ------*/
if(isset($_POST['cat_edit'])){ 
	escapeExtract($_POST);
	$up="update car_rental_category set
	cat_name='{$cat_name}'
	where car_cat_id='{$_GET['car_cat_id']}'";

	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: carrental_category_list?action=Success&action_msg= गाडी भाडे श्रेणी अपडेट केले...!');
		exit();
	}else{
		header('Location: carrental_category_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['car_cat_id'])){
            $getCus=mysqli_query($connect,"select * from car_rental_category where car_cat_id='".$_GET['car_cat_id']."' ");
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
							<h5 class="mb-0 text-success">गाडी भाडे श्रेणी अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">गाडी भाडे श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required value="<?= $cat_name?>">
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="cat_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="carrental_category_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन गाडी भाडे श्रेणी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">गाडी भाडे श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="cat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="carrental_category_list" class="btn btn-dark mt-3">मागे</a>
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