<?php
require_once "config.php";
Aditya::subtitle('नवीन जेसीबी जोडा');

if (isset($_POST['cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($cat_name)) {
        $sql="SELECT * FROM jcb_category WHERE cat_name='$cat_name'";
    } else {
        $sql="SELECT * FROM jcb_category WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: jcb_add?action=Success&action_msg='.$cat_name.' जेसीबी श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO jcb_category(cat_name) VALUES ('$cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: jcb_add?action=Success&action_msg='.$cat_name.' नवीन जेसीबी श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: jcb_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}
if (isset($_POST['jcb_add'])){
    escapeExtract($_POST);

     $jcbAdd= "INSERT INTO jcb(jdate,jcb_cat_id, name, mobile, village_name, nwork,jcb, tactor,hrs, trip, rate, total_amt) VALUES ('$jdate','$jcb_cat_id','$name','$mobile', '$village_name','$nwork','$jcb','$tactor','$hrs','$trip','$rate','$total_amt')";
    $jcbList=mysqli_query($connect,$jcbAdd);
    
    if($jcbList){
        header('Location: jcb_list?jcb_cat_id='.$jcb_cat_id.'&action=Success&action_msg='.$name.' नवीन जेसीबी जोडले..!');
		exit();
	}else{
		header('Location: jcb_add?action=Success&action_msg=काहीतरी चूक झाली');
		exit();
	}
}

if (isset($_POST['jcb_edit'])){
    escapeExtract($_POST);

    $upJcb = mysqli_query($connect,"UPDATE jcb SET
    jdate='{$jdate}',
    jcb_cat_id='{$jcb_cat_id}',
    name='{$name}',
    mobile='{$mobile}',
    village_name='{$village_name}',
    nwork='{$nwork}',
    jcb='{$jcb}',
    tactor='{$tactor}',
    hrs='{$hrs}',
    trip='{$trip}',
    rate='{$rate}',
    total_amt='{$total_amt}' WHERE jcb_id='{$_GET['jcb_id']}'");
   
    if($upJcb){
       header('Location: jcb_list?jcb_cat_id='.$jcb_cat_id.'&action=Success&action_msg='.$name.' जेसीबी अपडेट केले..!');
		exit();
	}else{
		header('Location: jcb_add?action=Success&action_msg=काहीतरी चूक झाली');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		 <?php if(isset($_GET['jcb_id'])){
        $geJcb = mysqli_query($connect, "SELECT * FROM jcb WHERE jcb_id='{$_GET['jcb_id']}'");
        $rowJcb = mysqli_fetch_assoc($geJcb);
        extract($rowJcb);
        ?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">जेसीबी अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        
                                        <div class="row">
                                             <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="jdate" class="form-label">तारीख<span class="text-danger">*</span></label>
                                                <input type="text" name="jdate" class="form-control" id="jdate" required value="<?= date('d-m-Y',strtotime($jdate))?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                            <div class="form-group">
                                                    <label for="category" class="form-label">जेसीबी श्रेणी</label>
                                                   <select name="jcb_cat_id" id="jcb_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from jcb_category") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['jcb_cat_id'] ?>" <?php if($getcus['jcb_cat_id']==$jcb_cat_id){echo "selected";}?>><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                             <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" required value="<?= $name?>">
                                                </div>
                                            </div>
                                             <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="mobile" class="form-label">मोबाईल नंबर</label>
                                                    <input type="tel" class="form-control" name="mobile" id="con" maxlength="10" minlength="10" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event, 'mobile')" value="<?= $mobile?>">
                                                </div> 
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="Email" class="form-label">गावाचे नाव</label>
                                                    <input type="text" class="form-control" name="village_name" id="village_name" value="<?= $village_name?>">
                                                </div>  
                                            </div>
                                           
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="nwork" class="form-label">कामाचे स्वरूप</label>
                                                    <input type="text" class="form-control" name="nwork" id="nwork" value="<?= $nwork?>">
                                                </div>  
                                            </div>
                                             <div class="col-12 col-md-1 mt-3">
                                               <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="jcb" id="jcb" value="jcb" <?php if($jcb=='jcb'){echo "checked";}?>>
                                                  <label class="form-check-label" for="jcb">
                                                    जेसीबी
                                                  </label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="jcb" id="tactor" value="tactor" <?php if($jcb=='tactor'){echo "checked";}?>>
                                                  <label class="form-check-label" for="tactor">
                                                    टॅक्टर
                                                  </label>
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-5 mt-3">
                                               <div class="form-group">
                                                    <!--<label for="tactor" class="form-label">JCB/Tactor</label>-->
                                                    <input type="text" class="form-control" name="tactor" id="tactor" value="<?= $tactor?>">
                                                </div>  
                                            </div>
                                            <div class="col-12 col-md-1 mt-3">
                                               <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="hrs" id="hrs" value="hrs" <?php if($hrs='hrs'){echo "checked";}?>>
                                                  <label class="form-check-label" for="hrs">
                                                    तास
                                                  </label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="hrs" id="trip" value="trip" <?php if($hrs='trip'){echo "checked";}?>>
                                                  <label class="form-check-label" for="trip">
                                                    ट्रिप
                                                  </label>
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-5 mt-3">
                                               <div class="form-group">
                                                    <!--<label for="trip" class="form-label">Hours/Trip</label>-->
                                                    <input type="text" class="form-control trip" name="trip" id="hours" value="<?= $trip?>"  oninput="allowType(event,'decimal')">
                                                </div>  
                                            </div>
                                           
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="rate" class="form-label">दर</label>
                                                    <input type="text" class="form-control rate" name="rate" id="rate"value="<?= $rate?>" oninput="allowType(event,'number')">
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="total_amt" class="form-label">एकूण रक्कम</label>
                                                    <input type="text" class="form-control total_amt" name="total_amt" id="total_amt" readonly value="<?= $total_amt?>" oninput="allowType(event,'number')">
                                                </div>  
                                            </div>
                                           
                                        </div>
                                        
                                        <button type="submit" name="jcb_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                         <a href="jcb_category" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन जेसीबी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        
                                        <div class="row">
                                             <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="jdate" class="form-label">तारीख<span class="text-danger">*</span></label>
                                                <input type="text" name="jdate" class="form-control" id="jdate" required value="<?= date('d-m-Y')?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                 <div class="form-group">
                                                    <label for="category" class="form-label">जेसीबी श्रेणी                               <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#exCatIdModal">
										<i class="bx bxs-plus-circle p-1 ms-1 text-success"></i>
									    </button>
                                         </label>
                                                   <select name="jcb_cat_id" id="jcb_cat_id" class="mb-3 form-select"><option value="">श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from jcb_category") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['jcb_cat_id'] ?>"><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                            </div>
                                           
                                             <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" required>
                                                </div>
                                            </div>
                                             <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="mobile" class="form-label">मोबाईल नंबर</label>
                                                    <input type="tel" class="form-control" name="mobile" id="con" maxlength="10" minlength="10" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event, 'mobile')">
                                                </div> 
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="Email" class="form-label">गावाचे नाव</label>
                                                    <input type="text" class="form-control" name="village_name" id="village_name">
                                                </div>  
                                            </div>
                                           
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="nwork" class="form-label">कामाचे स्वरूप</label>
                                                    <input type="text" class="form-control" name="nwork" id="nwork">
                                                </div>  
                                            </div>
                                             <div class="col-12 col-md-1 mt-3">
                                               <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="jcb" id="jcb" value="jcb">
                                                  <label class="form-check-label" for="jcb">
                                                    जेसीबी
                                                  </label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="jcb" id="tactor" value="tactor">
                                                  <label class="form-check-label" for="tactor">
                                                    टॅक्टर
                                                  </label>
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-5 mt-3">
                                               <div class="form-group">
                                                    <!--<label for="tactor" class="form-label">JCB/Tactor</label>-->
                                                    <input type="text" class="form-control" name="tactor" id="tactor">
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-1 mt-3">
                                               <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="hrs" id="hrs" value="hrs">
                                                  <label class="form-check-label" for="hrs">
                                                    तास
                                                  </label>
                                                </div>
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="hrs" id="trip" value="trip">
                                                  <label class="form-check-label" for="trip">
                                                    ट्रिप
                                                  </label>
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-5 mt-3">
                                               <div class="form-group">
                                                    <!--<label for="trip" class="form-label">Hours/Trip</label>-->
                                                    <input type="text" class="form-control trip" name="trip" id="hours" oninput="allowType(event,'decimal')">
                                                </div>  
                                            </div>
                                           
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="rate" class="form-label">दर</label>
                                                    <input type="text" class="form-control rate" name="rate" id="rate" oninput="allowType(event,'number')">
                                                </div>  
                                            </div>
                                           <div class="col-12 col-md-6 mt-2">
                                               <div class="form-group">
                                                    <label for="total_amt" class="form-label">एकूण रक्कम</label>
                                                    <input type="text" class="form-control total_amt" name="total_amt" id="total_amt" readonly oninput="allowType(event,'number')">
                                                </div>  
                                            </div>
                                           
                                        </div>
                                        
                                        <button type="submit" name="jcb_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                       <a href="jcb_category" class="btn btn-dark mt-3">मागे</a>
                                    </div>
                                </div>
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
<div class="modal fade" id="exCatIdModal" tabindex="-1" aria-labelledby="exCatIdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exCatIdModalLabel">नवीन श्रेणी जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label"> श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="cat_add" class="btn btn-sm btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="jcb_add" class="btn btn-sm btn-dark mt-3">मागे</a>
                        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    let hrs = $('.trip').val();
    $(".trip, .rate").on("input", mul);
    });    
    function mul() {
    let hrs = $('.trip').val();
    let rate = $('.rate').val();
        let _bal = Number(hrs) * Number(rate);
        $('#total_amt').val(!isNaN(_bal) ? _bal : 0).trigger('change');
    }
    </script>