<?php
require_once "config.php";
Aditya::subtitle('नवीन उधारी तपशील जोडा');
if (isset($_POST['all_loan'])){
    escapeExtract($_POST);
//      $names = $_FILES['sign']['name'];
// 	$temp = $_FILES['sign']['tmp_name'];
// 	$sign = NULL;
// 	if($names){
// 		$upload1 = "image/";
// 		$imgExt = strtolower(pathinfo($names, PATHINFO_EXTENSION));
// 		$sign = 'SIGN-'.date('YmdHis').rand(1000,9999).".".$imgExt;
// 		move_uploaded_file($temp,$upload1.$sign);
// 	}
    
     $insert= "INSERT INTO `all_loan_details`(ald_date,far_name,village,mob_no, des_plant,total_amt,deposit_amt,pending_amt,given_date,deli_date,nill) VALUES ('$ald_date','$far_name','$village','$mob_no','$des_plant','$total_amt','$deposit_amt','$pending_amt','$given_date','$deli_date','$nill')";
    $add=mysqli_query($connect,$insert);
    if($add){
        header('Location: all_loan_details_list?action=Success&action_msg='.$far_name.' नवीन उधारी तपशील जोडले.');
      	    exit();
    }else{
        header('Location: all_loan_details_list?action=Success&action_msg=काहीतरी चूक झाली..!');
      	exit();
    }
}

/*------ update details ------*/
if(isset($_POST['all_loan_edit'])){
        escapeExtract($_POST);
      
        $update = mysqli_query($connect,"UPDATE all_loan_details SET 
            ald_date = '".$ald_date."',
            far_name = '".$far_name."',
            village = '".$village."',
            mob_no = '".$mob_no."',
            des_plant = '".$des_plant."',
            total_amt = '".$total_amt."',
            deposit_amt = '".$deposit_amt."',
            pending_amt = '".$pending_amt."',
            
            given_date = '".$given_date."',
            deli_date = '".$deli_date."',
            nill = '".$nill."'
            where ald_id = '".$_GET['ald_id']."'");
        if($update){
            header('Location: all_loan_details_list?action=Success&action_msg='.$far_name.' उधारी तपशील अपडेट केले.!.');
      	    exit();
        }else{
            header('Location: all_loan_details_list?action=Success&action_msg=काहीतरी चूक झाली..!');
          	exit();
        }
    }
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
			if (isset($_GET['ald_id'])){
		$getsalcar=mysqli_query($connect, "select * from all_loan_details where ald_id='" .$_GET['ald_id'] ."'");
		$row= mysqli_fetch_array($getsalcar);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-success"></i>
							</div>
							<h5 class="mb-0 text-success">उधारी तपशील अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="ald_date" class="form-label">तारीख</label>

                                                    <input id="ald_date" type="date"  name="ald_date" class="form-control" value="<?php echo $row['ald_date']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="Email" class="form-label">शेतकऱ्यांचे नाव</label>
                                                    <input type="text" class="form-control" name="far_name" id="Email"  value="<?php echo $row['far_name']; ?>">
                                                </div>
                                            </div>
                                                           
                                           <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">गाव</label>

                                                    <input id="customer mobile" type="text" name="village" class="form-control" value="<?php echo $row['village']; ?>">
                                                </div>
                                            </div>
                                            
                                           <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">मोबाईल</label>

                                                    <input id="customer mobile" type="text" minlength="10" oninput="allowType(event, 'mobile')" maxlength="13" name="mob_no" class="form-control" value="<?php echo $row['mob_no']; ?>">
                                                </div>
                                            </div>
                                             <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">वर्णन वनस्पती</label>

                                                    <input id="customer mobile" type="text" name="des_plant" class="form-control" value="<?php echo $row['des_plant']; ?>">
                                                </div>
                                            </div>
                                              <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">एकूण रक्कम</label>

                                                    <input oninput="allowType(event, 'number')" id="total_amount" type="text" name="total_amt" class="form-control" value="<?php echo $row['total_amt']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">ठेव रक्कम</label>

                                                    <input type="text" name="deposit_amt" oninput="allowType(event, 'number')" id="adv_amt" class="form-control" value="<?php echo $row['deposit_amt']; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">प्रलंबित रक्कम</label>

                                                    <input id="pending_amt" type="text" oninput="allowType(event, 'number')" name="pending_amt" class="form-control"readonly value="<?php echo $row['pending_amt']; ?>">
                                                </div>
                                            </div>
                                            
                                            <!--<div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="customer mobile" class="form-label">Deposit Again</label>-->

                                            <!--        <input id="deposit_again" type="text" name="deposit_again" class="form-control" value="<?php echo $row['deposit_again']; ?>">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="customer mobile" class="form-label">Again Pending</label>-->

                                            <!--        <input id="finally_left" type="text" name="again_pending" class="form-control" readonly value="<?php echo $row['again_pending']; ?>">-->
                                            <!--    </div >-->
                                            <!--</div>-->
                                            
                                             <div class="col-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="given_date" class="form-label">Given Date</label>
                                                <input type="date" name="given_date" class="form-control" id="given_date" value="<?php echo $row['given_date']; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="due_date" class="form-label">Delivery Date<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="deli_date" id="due_date" required value="<?php echo $row['deli_date']; ?>">
                                                </div>
                                            </div>

                                          
                                           <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="sign" class="form-label">शून्य<span class="text-danger">*</span></label><br>
                                                <input type="text" name="nill" id='sign' class="form-control" value="<?php echo $row['nill']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <button type="submit" name="all_loan_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="all_loan_details_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन उधारी तपशील जोडा</h5>
						</div>
						<hr>
					
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="cusname" class="form-label">तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="ald_date" class="form-control" id="cusname" required value="<?= date('Y-m-d')?>">
                                                            </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">

                                                <div class="form-group">
                                                    <label for="Email" class="form-label">शेतकऱ्यांचे नाव</label>
                                                    <input type="text" class="form-control" name="far_name" id="Email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">गाव</label>

                                                    <input id="customer mobile" type="text" name="village" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">मोबाईल</label>

                                                    <input id="customer mobile" type="text" minlength="10" maxlength="13" name="mob_no" oninput="allowType(event, 'mobile')" class="form-control number_only">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">वर्णन वनस्पती</label>

                                                    <input id="customer mobile" type="text" name="des_plant" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">एकूण रक्कम</label>

                                                    <input id="total_amount" type="text" oninput="allowType(event, 'number')" name="total_amt" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">ठेव रक्कम</label>

                                                    <input type="text" name="deposit_amt" oninput="allowType(event, 'number')" id="adv_amt" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">प्रलंबित रक्कम</label>

                                                    <input id="pending_amt" type="text" oninput="allowType(event, 'number')" name="pending_amt" class="form-control"readonly>
                                                </div>
                                            </div>
                                            
                                            <!--<div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="customer mobile" class="form-label">Deposit Again</label>-->

                                            <!--        <input id="deposit_again" type="text" name="deposit_again" class="form-control">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="customer mobile" class="form-label">Again Pending</label>-->

                                            <!--        <input id="finally_left" type="text" name="again_pending" class="form-control" readonly>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!-- <div class="col-12 col-md-6 mt-2">-->
                                            <!--<div class="form-group">-->
                                            <!--    <label for="given_date" class="form-label">Given Date</label>-->
                                            <!--    <input type="date" name="given_date" class="form-control" id="given_date">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            
                                            <!--<div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--        <label for="due_date" class="form-label">Delivery Date</label>-->
                                            <!--        <input type="date" class="form-control" name="deli_date" id="due_date" >-->
                                            <!--    </div>-->
                                            <!--</div>-->

                                          
                                           <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                <label for="nill" class="form-label">शून्य<span class="text-danger">*</span></label><br>
                                                <input type="text" name="nill" id='nill' class="form-control">
                                                </div>
                                            </div>
                                            
                                            <!--  <div class="col-12 col-md-6 mt-2">-->
                                            <!--    <div class="form-group">-->
                                            <!--    <label for="sign" class="form-label">Upload Signature<span class="text-danger">*</span></label><br>-->
                                            <!--    <input type="file" name="sign" id='sign' class="form-control">-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                        
                                        <button type="submit" name="all_loan" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="all_loan_details_list" class="btn btn-dark mt-3">मागे</a>
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
<script>
     $(document).ready(function() {
    //this calculates values automatically total sub
    sub();
    $("#total_amount, #adv_amt").on("keydown keyup", function() {
        sub();
    });
    
     //this calculates values automatically finally left
    // pending_sub();
    // $("#pending_amt, #deposit_again,.bal_amt").on("input", function() {
    //     pending_sub();
    // });
});
function sub() {
            let tamt = document.getElementById('total_amount').value;
            let aamt = document.getElementById('adv_amt').value;
			let result1 = parseInt(tamt) - parseInt(aamt);
            if (!isNaN(result1)) {
				document.getElementById('pending_amt').value = result1;
            }
        }
        
// function pending_sub() {
//              let totpending = document.getElementById('pending_amt').value;
//             let depagain = document.getElementById('deposit_again').value;
// 			let finalleft = parseInt(totpending) - parseInt(depagain);
//             if (!isNaN(finalleft)) {
// 				$('.bal_amt').value = finalleft;
//             }
//         }
</script>    		
<?php include "footer.php"; ?>