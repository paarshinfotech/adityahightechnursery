<?php
require_once "config.php";
Aditya::subtitle('नवीन गाडी भाडे  जोडा');
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
             header('Location: car_rental_add?action=Success&action_msg='.$cat_name.' गाडी भाडे श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO car_rental_category(cat_name) VALUES ('$cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: car_rental_add?action=Success&action_msg='.$cat_name.' नवीन गाडी भाडे श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: car_rental_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

if (isset($_POST['car_rental_add'])){
    escapeExtract($_POST);
     $carinsert= "INSERT INTO `car_rental`(name,con,car_cat_id,cdate,village_name,car_rental, pick_up_diesel,deposit_rs) VALUES ('$name','$con','$car_cat_id','$cdate','$village_name','$car_rental_rs','$pick_up_diesel','$deposit_rs')";
    $rescar=mysqli_query($connect,$carinsert);
    if($rescar){
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header('Location: car_rental_list?car_cat_id='.$car_cat_id.'&action=Success&action_msg='.$name.'  नवीन गाडी भाडे जोडले..!');
    }else{
        header('Location: car_rental_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
    }
}

if(isset($_POST['car_rental'])){
        escapeExtract($_POST);
       
        $update1 = mysqli_query($connect,"UPDATE car_rental SET
            `cdate` = '".$cdate."',
            `name` = '".$name."',
            `con` = '".$con."',
            `car_cat_id` = '".$car_cat_id."',
            `village_name` = '".$village_name."',
            `car_rental` = '".$car_rental_rs."',
            `pick_up_diesel` = '".$pick_up_diesel."',
            `deposit_rs` = '".$deposit_rs."'
            where cr_id='".$_GET['cr_id']."'");
            
        // $car_adv = mysqli_query($connect,"UPDATE car_rental_adv SET
        //     `advdate` = '".$advdate."',
        //     `advrs` = '".$advrs."',
        //     `reason` = '".$reason."'
        //     where cr_id='".$_GET['cr_id']."'");
            
    if($update1)
    {
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header('Location: car_rental_list?car_cat_id='.$car_cat_id.'&action=Success&action_msg='.$name.' गाडी भाडे अपडेट  केले..!');
    }else{
        header('Location: car_rental_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
    }
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['cr_id'])){
            $getCus=mysqli_query($connect,"select * from car_rental where cr_id='".$_GET['cr_id']."' ");
            $resCus=mysqli_fetch_assoc($getCus);
            
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">गाडी भाडे अपडेट करा</h5>
						</div>
						<hr>
				
						<form method="post">
						    <div class="row">
						        <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="cdate" class="form-label">तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="cdate" class="form-control" id="cdate" value="<?php echo $resCus['cdate'];?>" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="Email" class="form-label">गावाचे नाव</label>
                                                    <input type="text" class="form-control" name="village_name" id="village_name" value="<?php echo $resCus['village_name'];?>">
                                                </div>
                                            </div>
                                       
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" required value="<?php echo $resCus['name'];?>">
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="con" class="form-label">मोबाईल</label>
                                                    <input type="tel" class="form-control" name="con" id="con" maxlength="10" minlength="10" pattern="[6-9]{1}[0-9]{9}" value="<?php echo $resCus['con'];?>" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>
                                         <div class="col-12 col-md-6 mt-2">

                                            <div class="form-group">
                                                    <label for="category" class="form-label">श्रेणी</label>
                                                   <select name="car_cat_id" id="car_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from car_rental_category") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['car_cat_id'] ?>" <?php if($getcus['car_cat_id']==$resCus['car_cat_id']){echo "selected";}?>><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="car_rental_rs" class="form-label">गाडी भाडे</label>                                        <input id="car_rental" type="text" name="car_rental_rs" class="form-control" value="<?= $resCus['car_rental']; ?>" oninput="allowType(event,'number')">
                                                </div>
                                            </div>

                                    
                                        <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="" class="form-label">उचल डिझेल</label>

                                                    <input id="pick_up_diesel" type="text" name="pick_up_diesel" class="form-control" value="<?php echo $resCus['pick_up_diesel'];?>" oninput="allowType(event,'number')">
                                                </div>
                                            </div>
                                                                                   <div class="col-12 col-md-6 mt-2">
                                                <label for="deposit_rs" class="form-label">शिल्लक रु</label>
                                               <input id="deposit_rs" type="text" name="deposit_rs" class="form-control" value="<?php echo $resCus['deposit_rs'];?>" readonly oninput="allowType(event,'number')">
                                            </div>
						            </div>
                                        

                                       
                                        <button type="submit" name="car_rental" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="car_rental_category" class="btn btn-dark mt-3">मागे</a>
                                    </div>
                                </div>
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
							<h5 class="mb-0 text-success">नवीन गाडी भाडे जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        
                                        <div class="row">
                                           
                                            <div class="col-12 col-md-6 mt-2 mt-2">
                                                <div class="form-group">
                                                <label for="cdate" class="form-label">तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="cdate" class="form-control" id="cdate" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 mt-2">

                                                <div class="form-group">
                                                    <label for="Email" class="form-label">गावाचे नाव</label>
                                                    <input type="text" class="form-control" name="village_name" id="village_name" >
                                                </div>
                                            </div>
                                       
                                            <div class="col-12 col-md-6 mt-2 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" required >
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 mt-2">

                                                <div class="form-group">
                                                    <label for="con" class="form-label">मोबाईल</label>
                                                    <input type="tel" class="form-control" name="con" id="con" maxlength="10" minlength="10" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>
                                         <div class="col-12 col-md-6 mt-2 mt-1">

                                            <div class="form-group">
                                                    <label for="category" class="form-label">श्रेणी 
                                                    <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">
										<i class="bx bxs-plus-circle p-1 ms-1 text-success"></i>
									    </button>
                                                    </label>
                                                   <select name="car_cat_id" id="car_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from car_rental_category order by car_cat_id desc") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['car_cat_id'] ?>" ><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2 mt-3">
                                                <div class="form-group">
                                                    <label for="car_rental_rs" class="form-label">गाडी भाडे</label>                                        <input id="car_rental" type="text" name="car_rental_rs" class="form-control" oninput="allowType(event,'number')">
                                                </div>
                                            </div>

                                    
                                        <div class="col-12 col-md-6 mt-2 mt-2">
                                                <div class="form-group">
                                                    <label for="" class="form-label">उचल डिझेल</label>

                                                    <input id="pick_up_diesel" type="text" name="pick_up_diesel" class="form-control" oninput="allowType(event,'number')">
                                                </div>
                                            </div>
                                                                                   <div class="col-12 col-md-6 mt-2 mt-2">
                                                <label for="deposit_rs" class="form-label">शिल्लक रु</label>
                                               <input id="deposit_rs" type="text" name="deposit_rs" class="form-control" oninput="allowType(event,'number')" readonly>
                                            </div>
                                           
                                            </div>
                                            
                                        <button type="submit" name="car_rental_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="car_rental_category" class="btn btn-dark mt-3">मागे</a>
                                    </div>
                                </div>
                            </form>
					</div>
				</div>
				
			</div>
		</div>
		<?php } ?>
		<!--end row-->
				
			</div>
		</div>
		<!--end page wrapper -->
<!-- Modal -->
<div class="modal fade" id="exCatIdModal" tabindex="-1" aria-labelledby="exCatIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exCatIdModalLabel">नवीन गाडी भाडे श्रेणी जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">गाडी भाडे श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="cat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="car_rental_add" class="btn btn-dark mt-3">मागे</a>
                        </form>
      </div>
    </div>
  </div>
</div>		
<?php include "footer.php"; ?>
<script>
$(document).ready(function() {
    $("#car_rental, #pick_up_diesel").on("input change", sub);
});    
    function sub() {
    let tcar = $('#car_rental').val();
    let pick = $('#pick_up_diesel').val();
    let _bal = Number(tcar) - Number(pick);
    $('#deposit_rs').val(!isNaN(_bal) ? _bal : 0).trigger('change');
}
    </script>