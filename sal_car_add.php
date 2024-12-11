<?php
require_once "config.php";
Aditya::subtitle('नवीन साल कार जोडा');
if (isset($_POST['sal_add'])){
    escapeExtract($_POST);
     $insert= "INSERT INTO `salcar`(`worker_name`,`contact`,`sdate`, `sallery`) VALUES('$worker_name','$contact','$sdate','$sallery')";
    $add=mysqli_query($connect,$insert) or die(mysqli_error($connect));
    if($add){
        header('Location: sal_car_list?action=Success&action_msg='.$worker_name.' नवीन साल कार जोडले..!');
    }
    else{
        header('Location: sal_car_list?action=Success&action_msg=काहीतरी चूक झाली..!');
      	exit();
    }
}

//edit
if (isset($_POST['edit_sal_car'])){
    escapeExtract($_POST);
     $updatesal=mysqli_query($connect,"UPDATE salcar SET
     worker_name='$worker_name',
     contact='$contact',
     sdate='$sdate',
     sallery='$sallery' WHERE sal_id='{$_GET['sal_id']}'");
    if($updatesal){
        header('Location: sal_car_list?action=Success&action_msg=साल कार अपडेट केले..!');
    }else{
        header('Location: sal_car_list?action=Success&action_msg=काहीतरी चूक झाली..!');
      	exit();
    }
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['sal_id'])){
        $getsalCar=mysqli_query($connect,"SELECT * FROM salcar WHERE sal_id='{$_GET['sal_id']}'");
        $rowsalCar=mysqli_fetch_assoc($getsalCar);
        extract($rowsalCar);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">साल कार अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">                           
                                        <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="worker_name" class="form-label">कामगाराचे नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="worker_name" class="form-control" id="worker_name" required value="<?= $worker_name?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="contact" class="form-label">मोबाईल नंबर</label>

                                                    <input id="contact" type="tel" minlength="10" maxlength="10" name="contact" class="form-control" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event, 'mobile')" value="<?= $contact?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="sdate" class="form-label">रुजू होण्याची तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="sdate" class="form-control" id="sdate" value="<?= $sdate?>" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="sal" class="form-label">पगाराची रक्कम<span class="text-danger">*</span></label>

                                                    <input id="sal" type="text" name="sallery" oninput="allowType(event, 'number')" class="form-control" required value="<?= $sallery?>">
                                                </div>
                                            </div>

                                        </div>

                                       
                                        <button type="submit" name="edit_sal_car" class="btn btn-success me-2 text-white mt-3">Submit</button>
                                        <a href="sal_car_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन साल कार जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">                           
                                        <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                <label for="worker_name" class="form-label">कामगाराचे नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="worker_name" class="form-control" id="worker_name" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="contact" class="form-label">मोबाईल नंबर</label>

                                                    <input id="contact" type="tel" minlength="10" maxlength="10" name="contact" oninput="allowType(event, 'mobile')" class="form-control" pattern="[6-9]{1}[0-9]{9}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="sdate" class="form-label">रुजू होण्याची तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="sdate" class="form-control" id="sdate" value="<?= date('Y-m-d')?>" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="sal" class="form-label">पगाराची रक्कम<span class="text-danger">*</span></label>

                                                    <input oninput="allowType(event, 'number')" id="sal" type="text" name="sallery" class="form-control" required>
                                                </div>
                                            </div>

                                        </div>

                                       
                                        <button type="submit" name="sal_add" class="btn btn-success me-2 text-white mt-3">Submit</button>
                                        <a href="sal_car_list" class="btn btn-dark mt-3">मागे</a>
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
<script>
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