<?php
require_once "config.php";
Aditya::subtitle('नवीन मोबाइल डायरी जोडा');
/*------ Add details ------*/
if (isset($_POST['add'])){
    escapeExtract($_POST);
    $sql="SELECT * FROM mobile_diary WHERE mobile='$mobile'";
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: mobile_diary_list?action=Success&action_msg='.$name.' मोबाइल डायरी आधिपासुन आहे..!');
		    exit();
         }else{
     {
    escapeExtract($_POST);

     $insert= "INSERT INTO mobile_diary(name,village,mobile,whatsno,pep_info) VALUES ('$name','$village','$mobile','$whatsno','$pep_info')";

    $add=mysqli_query($connect,$insert);


    if($add){
        // header('Location: customer_list?action=Success&action_msg=Customer Added');
        header('Location: mobile_diary_list?action=Success&action_msg='.$name.'  नवीन मोबाइल डायरी जोडले..!');
      	    exit();
    }
    else{
       header('Location: mobile_diary_list?action=Success&action_msg=काहीतरी चूक झाली..!');
      	exit();
    }
}
    }
}

if(isset($_POST['edit'])){
        extract($_POST);
        
        $update = mysqli_query($connect,"update mobile_diary set
            name = '".mysqli_real_escape_string($connect,$name)."',
            village = '".mysqli_real_escape_string($connect,$village)."',
            mobile = '".mysqli_real_escape_string($connect,$mobile)."',
            whatsno = '".mysqli_real_escape_string($connect,$whatsno)."',
            pep_info = '".mysqli_real_escape_string($connect,$pep_info)."'
                  where mob_id = '".$_GET['mob_id']."'");
        
        if($update){
            header('Location: mobile_diary_list?action=Success&action_msg='.$name.' मोबाइल डायरी अपडेट केले..!');
      	    exit();
        }
        else{
       header('Location: mobile_diary_list?action=Success&action_msg=काहीतरी चूक झाली..!');
      	exit();
    }
    }
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if (isset($_GET['mob_id'])){
		$query1=mysqli_query($connect, "select * from mobile_diary where mob_id='" .$_GET['mob_id'] ."'") or die(mysqli_error($connect));

		$row= mysqli_fetch_array($query1);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">मोबाइल डायरी अपडेट करा</h5>
						</div>
						<hr>
					
						 <form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name" value="<?php echo $row['name']; ?>" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">गाव<span class="text-danger">*</span></label>
                                                <input type="text" name="village" class="form-control" id="cusname" placeholder="village" value="<?php echo $row['village']; ?>" required>
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="qty" class="form-label">मोबाईल नंबर</label>
                                                    <input type="tel" class="form-control" name="mobile" id="qty" placeholder="Enter Mobile No" minlength="10" maxlength="10" value="<?php echo $row['mobile']; ?>" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="whatsno" class="form-label">व्हॉट्सअप नंबर</label>
                                                    <input type="tel" class="form-control" name="whatsno" minlength="10" maxlength="10" id="whatsno" placeholder="Enter Whatsapp No" value="<?php echo $row['whatsno']; ?>" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="pep_info" class="form-label">व्यक्ती माहिती</label>
                                                    <textarea type="text" class="form-control" name="pep_info" id="pep_info" placeholder="Enter Person Information" ><?php echo $row['pep_info']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="submit" name="edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="mobile_diary_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन मोबाइल डायरी जोडा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" required>
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
                                                    <label for="mobile" class="form-label">मोबाईल नंबर</label>

                                                    <input id="mobile" type="tel" minlength="10" maxlength="10" name="mobile" class="form-control" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="whatsno" class="form-label">व्हॉट्सअप नंबर</label>

                                                    <input id="whatsno" type="tel" minlength="10" maxlength="10" name="whatsno" class="form-control" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 mt-2">
                                                 
                                                    <div class="form-group">
                                                        <label for="pep_info" class="form-label">व्यक्ती माहिती<span class="text-danger">*</span></label>
                                                        <textarea id="pep_info" class="form-control" name="pep_info"></textarea>
                                                    </div>
                                               
                                            </div>
                                            
                                        
                                        
                                        </div>
                                        
                                        <button type="submit" name="add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="mobile_diary_list" class="btn btn-dark mt-3">मागे</a>
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