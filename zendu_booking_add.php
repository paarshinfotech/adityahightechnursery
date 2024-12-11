<?php
require_once "config.php";
Aditya::subtitle('नवीन झेंडू बुकिंग जोडा');
/*------ Add details ------*/
if (isset($_POST['customer_add'])){
    escapeExtract($_POST);
    
    if (!empty($customer_email)) {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    } else {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: zendu_booking_add?action=Success&action_msg='.$customer_name.' ग्राहक आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO customer(customer_name, customer_mobno, customer_gender, customer_email,state, city, taluka, village) VALUES ('$customer_name','$customer_mobno','$customer_gender','$customer_email','$state','$city','$taluka','$village')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: zendu_booking_add?action=Success&action_msg='.$customer_name.' नवीन ग्राहक जोडले..!');
		exit();
        }else{
        header('Location: zendu_booking_add?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}
/*------ Add details ------*/
if (isset($_POST['zendu_book_add'])){
    escapeExtract($_POST);
    
     $insert= "INSERT INTO `zendu_booking`(`booking_date`, `name`, `village`, `mobile`, `red_plants`, `red_plants_count`, `subcat_id`, `sub_cat_qty`, `rate`, `total_rs`, `subcat_id1`, `sub_cat_qty1`, `rate1`, `total_rs1`, `yellow_plants`, `yellow_plants_count`, `ysubcat_id`, `yellowcount`, `ratey`, `total_rsy`, `subcat_idy1`, `sub_cat_qtyy1`, `ratey1`, `yellow_total`, `total_amount`, `adv_amt`,`pay_mode`, `pending_amt`, `red_giving_date`, `yellow_giving_date`, `date_given`) VALUES ('$booking_date','$name','$village','$mobile','$red_plants','$red_plants_count','$subcat_id','$sub_cat_qty','$rate', '$total_rs', '$subcat_id1', '$sub_cat_qty1', '$rate1', '$total_rs1','$yellow_plants','$yellow_plants_count','$ysubcat_id','$yellowcount','$ratey', '$total_rsy', '$subcat_idy1', '$sub_cat_qtyy1', '$ratey1', '$yellow_total','$total_amount','$adv_amt','$pay_mode','$pending_amt','$red_giving_date','$yellow_giving_date','$date_given')";
        $add=mysqli_query($connect,$insert);
     
        $zid=mysqli_insert_id($connect);
        
        mysqli_query($connect, "UPDATE marigold_category SET cat_qty = cat_qty - ($sub_cat_qty+$sub_cat_qty1) WHERE cat_name= '$red_plants'");
        
        mysqli_query($connect, "UPDATE marigold_category SET cat_qty = cat_qty - ($yellowcount+$sub_cat_qtyy1) WHERE cat_name = '$yellow_plants'");
        
        if($add){
        header('Location: zendu_booking_list?action=Success&action_msg='.$cat_name.' नवीन झेंडू बुकिंग जोडली.!');
		exit();
        }else{
        header('Location: zendu_booking_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
    }
}

/*------ update details ------*/
if(isset($_POST['zendu_book_edit'])){ 
	escapeExtract($_POST);
	$up="UPDATE zendu_booking SET
        booking_date='$booking_date',
        name='$name',
        village='$village',
        mobile='$mobile',
        red_plants='$red_plants',
        red_plants_count='$red_plants_count',
        subcat_id='$subcat_id',
        sub_cat_qty='$sub_cat_qty',
        rate='$rate',
        total_rs='$total_rs',
        subcat_id1='$subcat_id1',
        sub_cat_qty1='$sub_cat_qty1',
        rate1='$rate1',
        total_rs1='$total_rs1',
        yellow_plants='$yellow_plants',
        yellow_plants_count='$yellow_plants_count',
        ysubcat_id='$ysubcat_id',
        yellowcount='$yellowcount',
        ratey='$ratey',
        total_rsy='$total_rsy',
        subcat_idy1='$subcat_idy1',
        sub_cat_qtyy1='$sub_cat_qtyy1',
        ratey1='$ratey1',
        yellow_total='$yellow_total',
        total_amount='$total_amount',
        adv_amt='$adv_amt',
        pay_mode='$pay_mode',
        pending_amt='$pending_amt',
        
        red_giving_date='$red_giving_date',
        yellow_giving_date='$yellow_giving_date',
        date_given='$date_given'
        
        WHERE zendu_id='{$_GET['zid']}'";
    	$result=mysqli_query($connect,$up);
    	if($result){
	    
	   // deposit_again='$deposit_again',
        // finally_left='$finally_left',
	    //sms
              
//               $n = 8329684365;
//                 $na=$name."  Your  Booking ";
                
//                  $msg="Hello $na /- Successfully Done For Aditya Nursery...!";

//                   $DLT_TE_ID= '1207162244244182505';
   
//   			   $curl = curl_init();

// 			curl_setopt_array($curl, array(
				
// 		CURLOPT_URL=> "http://sms.brightead.in:8080/api/mt/SendSMS?user=demo&password=demo123&senderid=WEBSMS&channel=Promo&DCS=0&flashsms=0&number=91989xxxxxxx&text=test message&route=##&Peid=##&DLTTemplateId=##",
		
		
// 			  CURLOPT_RETURNTRANSFER => true,
// 			  CURLOPT_ENCODING => "",
// 			  CURLOPT_MAXREDIRS => 10,
// 			  CURLOPT_TIMEOUT => 30,
// 			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 			  CURLOPT_CUSTOMREQUEST => "GET",
// 			  CURLOPT_POSTFIELDS => "",
// 			  CURLOPT_HTTPHEADER => array(
// 			    "content-type: application/x-www-form-urlencoded"
// 			  ),
// 			));

// 			$response = curl_exec($curl);
// 			$err = curl_error($curl); 
    //number sms
		header('Location: zendu_booking_list?action=Success&action_msg= झेंडू बुकिंग अपडेट केले...!');
		exit();
	}else{
		header('Location: zendu_booking_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['zid'])){
            $getCat=mysqli_query($connect,"select * from zendu_booking where zendu_id='" .$_GET['zid'] ."'");
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
							<h5 class="mb-0 text-success">झेंडू बुकिंग अपडेट करा</h5>
						</div>
						<hr>
				
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            

                                            <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="booking_date" class="form-label">बुकिंग तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="booking_date" class="form-control" id="booking_date" required value="<?= $booking_date?>">
                                                </div>
                                                    </div>
                                                    
                                            <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span></label>
                                                <!--<input type="text" name="name" class="form-control" id="name" required value="<?//= $name?>">-->
                                                <select class="form-select cus_id text-start" id="cus_id" name="name" required>
																		<option value="">ग्राहक निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from customer") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['customer_name'] ?>" <?php if($row1['customer_name']== $name) {echo "selected";}?>><?= $row1['customer_id'] ?> | <?= $row1['customer_name'] ?> (<?= $row1['customer_mobno'] ?>)</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
                                                </div>
                                                    </div>
                                                    
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="village" class="form-label">गाव<span class="text-danger">*</span></label>
                                                <input type="text" name="village" id="gav" class="form-control" value="<?= $village?>">
                                                </div>
                                                    </div>
                                                    
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="mobile" class="form-label">मोबाईल<span class="text-danger">*</span></label><br>
                                                <input type=text name="mobile" id='mob' class="form-control" minlebgth="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')" value="<?= $mobile?>">
                                                </div>
                                                    </div>
                                                
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="red_plants" class="form-label">लाल वनस्पती<span class="text-danger">*</span></label><br>
                                              
                                                <select name="red_plants" id="redplant" class="form-select mb-3" required><option>श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category where pt_id='1'") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcatz=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcatz['cat_name']?>"<?php if ($getcatz['cat_name']==$red_plants) {echo "selected";}?>><?= $getcatz['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                                    </div>
                                                    
                                                
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="red_plants_count" class="form-label">एकूण लाल वनस्पती<span class="text-danger">*</span></label><br>
                                                <input type="text" name="red_plants_count" oninput="allowType(event,'number')" id='red_plants_count' class="form-control red_plants_count" value="<?= $red_plants_count?>">
                                                </div>
                                                    </div>
                                                    
                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="red_plants_count" class="form-label">उपवर्ग
                                                </label><br>
                                                
                                                <select name="subcat_id" id="subcat_id" class="mb-3 form-select"><option value="ट्रे">ट्रे</option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="redcount" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                    
                                                <input type="text" name="sub_cat_qty" oninput="allowType(event,'number')" id='sub_cat_qty' class="form-control sub_cat_qty" value="<?= $sub_cat_qty?>">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="rate" class="form-label">दर<span class="text-danger"></span></label><br>
                                     
                                                <input type="text" name="rate" oninput="allowType(event,'decimal')" id='rate' class="form-control rate" value="<?= $rate?>">
                                                </div>
                                                    </div>
                                        <div class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="total_rs" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="total_rs" oninput="allowType(event,'number')" id='total_rs' class="form-control total_rs " value="<?= $total_rs?>" readonly>
                                                </div>
                                        </div>
                                        
                                        <!--<div class="col-md-1 mt-4" id="show-btn">-->
                                        <!--    <h6 class="btn btn-sm btn-outline-success">+</h6>-->
                                        <!--</div>-->
                                         
                                                <div id="show-box">
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="subcat_id1" class="form-label">उपवर्ग
                                                </label><br>
                                               
                                                <select name="subcat_id1" id="subcat_id1" class="mb-3 form-select"><option value="वाफा">वाफा </option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="sub_cat_qty1" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                     
                                                <input type="text" name="sub_cat_qty1" oninput="allowType(event,'number')" id='sub_cat_qty1' class="form-control sub_cat_qty1" value="<?= $sub_cat_qty1?>">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="rate1" class="form-label">दर<span class="text-danger"></span></label><br>
                                    
                                                <input type="text" name="rate1" oninput="allowType(event,'decimal')" id='rate1' class="form-control rate1" value="<?= $rate1?>">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="total_rs1" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="total_rs1" oninput="allowType(event,'number')" id='total_rs1' class="form-control total_rs1" readonly value="<?= $total_rs1?>">
                                                </div>
                                                    </div>
                                              </div>
                                          </div>
                                                                                          
                                           
                                            <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="yellow_plants" class="form-label">पिवळी वनस्पती<span class="text-danger">*</span></label><br>
                                                
                                                <select name="yellow_plants" id="yellowplant" class="form-control mb-3" required><option>श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category where pt_id='2'") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['cat_name']?>"<?php if ($getcus['cat_name']==$yellow_plants) {echo "selected";}?>><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                                    </div>
                                                    
                                                
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="yellow_plants_count" class="form-label">एकूण पिवळी वनस्पती<span class="text-danger">*</span></label><br>
                                                <input type="text" name="yellow_plants_count" oninput="allowType(event,'number')" id='yellow_plants_count' class="form-control" value="<?= $yellow_plants_count?>">
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ysubcat_id" class="form-label">उपवर्ग<span class="text-danger">*</span></label><br>
                                               
                                                  <select name="ysubcat_id" id="ysubcat_id" class="mb-3 form-select"><option value="ट्रे">ट्रे</option>
														</select>
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="yellowcount" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                                <input type="text" name="yellowcount" oninput="allowType(event,'number')" id='yellowcount' class="form-control yellowcount" value="<?= $yellowcount?>">
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ratey" class="form-label">दर<span class="text-danger"></span></label><br>
                                                <input type="text" name="ratey" oninput="allowType(event,'decimal')" id='ratey' class="form-control ratey" value="<?= $ratey?>">
                                                </div>
                                                    </div>
                                                      <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="total_rsy" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                <input type="text" name="total_rsy" oninput="allowType(event,'number')" id='total_rsy' class="form-control total_rsy" readonly value="<?= $total_rsy?>">
                                                </div>
                                                    </div>
                                        <!--            <div class="col-md-1 mt-4" id="show-btn1">-->
                                        <!--    <h6 class="btn btn-sm btn-outline-success">+</h6>-->
                                        <!--</div>-->
                                         
                                                <div id="show-box1">
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="subcat_idy1" class="form-label">उपवर्ग
                                                </label><br>
                                               
                                                <select name="subcat_idy1" id="subcat_idy1" class="mb-3 form-select"><option value="वाफा">वाफा</option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="sub_cat_qtyy1" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                     
                                                <input type="text" name="sub_cat_qtyy1" oninput="allowType(event,'number')" id='sub_cat_qtyy1' class="form-control sub_cat_qtyy1" value="<?= $sub_cat_qtyy1?>"> 
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ratey1" class="form-label">दर<span class="text-danger"></span></label><br>
                                    
                                                <input type="text" name="ratey1" oninput="allowType(event,'decimal')" id='ratey1' class="form-control ratey1" value="<?= $ratey1?>">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="yellow_total" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="yellow_total" oninput="allowType(event,'number')" id='yellow_total' class="form-control yellow_total" readonly value="<?= $yellow_total?>">
                                                </div>
                                                    </div>
                                                  </div>
                                              </div>
                                                 

                                                    
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="total_amount" class="form-label">एकूण रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="total_amount" oninput="allowType(event,'number')" id='total_amount' class="form-control total_amount" readonly value="<?= $total_amount?>">
                                                </div>
                                                    </div>
                                                     
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="adv_amt" class="form-label">ऍडव्हान्स रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="adv_amt" oninput="allowType(event,'number')" id='adv_amt' class="form-control" value="<?= $adv_amt?>">
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="adv_amt" class="form-label">पेमेंट निवडा<span class="text-danger">*</span></label><br>
                                                
																	<select name="pay_mode" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option <?= ($resCat['pay_mode']=='cash') ? 'selected' : '' ?> value="cash">रोख</option>
																		<option <?= ($resCat['pay_mode']=='sbi') ? 'selected' : '' ?> value="sbi">आदित्य नर्सरी SBI</option>
																		<option <?= ($resCat['pay_mode']=='mgb') ? 'selected' : '' ?> value="mgb">आदित्य नर्सरी MGB</option>
																		<option <?= ($resCat['pay_mode']=='ds_bank') ? 'selected' : '' ?> value="ds_bank">डीएस बँक</option>
																		<option <?= ($resCat['pay_mode']=='other_bank') ? 'selected' : '' ?> value="other_bank">इतर बँक</option>
																	</select>
															
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="pending_amt" oninput="allowType(event,'number')" id='pending_amt' class="form-control" readonly value="<?= $pending_amt?>">
                                                </div>
                                                    </div>
                                                <!--<div class="col-12 col-md-6 my-2">-->
                                                <!--<div class="form-group">-->
                                                <!--<label for="deposit_again" class="form-label">पुन्हा जमा <span class="text-danger">*</span></label><br>-->
                                                <!--<input type=text name="deposit_again" id='deposit_again' class="form-control" value="<?= $deposit_again?>">-->
                                                <!--</div>-->
                                                <!--    </div>-->
                                                <!--<div class="col-12 col-md-6 my-2">-->
                                                <!--<div class="form-group">-->
                                                <!--<label for="finally_left" class="form-label">अखेर बाकी <span class="text-danger">*</span></label><br>-->
                                                <!--<input type=text name="finally_left" id='finally_left' class="form-control" readonly value="<?= $finally_left?>">-->
                                                <!--</div>-->
                                                <!--    </div>-->
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="red_giving_date" class="form-label">लाल देणारी तारीख<span class="text-danger">*</span></label><br>
                                                <input type=date name="red_giving_date" id='red_giving_date' class="form-control" value="<?= $red_giving_date?>">
                                                </div>
                                                    </div>
                                            
                                            <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="yellow_giving_date" class="form-label">पिवळी देणारी तारीख<span class="text-danger">*</span></label><br>
                                                <input type="date" name="yellow_giving_date" id='yellow_giving_date' class="form-control" value="<?= $yellow_giving_date?>">
                                                </div>
                                                    </div>
                                                  
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="date_given" class="form-label">वितरण तारीख</label>
                                                <input type="date" name="date_given" class="form-control" id="date_given" placeholder="" value="<?= $date_given?>">
                                                </div>
                                                    </div>
                                            </div>
                                                
                                          
                                       
                                        <button type="submit" name="zendu_book_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="zendu_booking_list" class="btn btn-dark mt-3">मागे</a>
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
							<h5 class="mb-0 text-success">नवीन झेंडू बुकिंग जोडा</h5>
						</div>
						<hr>
					
						<form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            

                                            <div class="col-12 col-md-6 my-2 mt-3">
                                                <div class="form-group">
                                                <label for="booking_date" class="form-label">बुकिंग तारीख<span class="text-danger">*</span></label>
                                                <input type="date" name="booking_date" class="form-control" id="booking_date" required value="<?= date('Y-m-d')?>">
                                                </div>
                                                    </div>
                                                    
                                            <div class="col-12 col-md-6 my-2 mt-1">
                                                <div class="form-group">
                                                <label for="name" class="form-label">नाव<span class="text-danger">*</span>
                                                 <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#cusModal">
										<i class="bx bxs-plus-circle p-1 ms-1 text-success"></i>
									    </button>
                                                </label>
                                                <!--<input type="text" name="name" class="form-control" id="name" required>-->
                                                
                                                <div class="input-group search-box" id="Search_input_fild">
    <input type="text" name="customer_Search" id="customer_search" 
        class="form-control mb-3" 
        oninput="searchCustomers(this.value)" 
        placeholder="ग्राहक शोधा..." required>
    
    <div id="search-results" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto;">
        <?php
        $query = mysqli_query($connect, "SELECT * FROM customer ORDER BY customer_id DESC");
        if ($query && mysqli_num_rows($query) > 0):
            while ($row = mysqli_fetch_assoc($query)): ?>
                <div class="dropdown-item" onclick="selectCustomer('<?= $row['customer_id'] ?>', '<?= $row['customer_name'] ?>', '<?= $row['customer_mobno'] ?>')">
                    <?= $row['customer_id'] ?> | <?= $row['customer_name'] ?> (<?= $row['customer_mobno'] ?>)
                </div>
        <?php endwhile; endif; ?>
    </div>
    
    <input type="hidden" name="customer_id" id="customer_id" value="" required>
</div>



                                                </div>
                                                    </div>
                                                    
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="village" class="form-label">गाव<span class="text-danger">*</span></label>
                                                <input type="text" id="gav" name="village" class="form-control">
                                                </div>
                                                    </div>
                                                    
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="mobile" class="form-label">मोबाईल<span class="text-danger">*</span></label><br>
                                                <input type=text name="mobile" id="mob" class="form-control" minlebgth="10" maxlength="10" pattern="[6-9]{1}[0-9]{9}" oninput="allowType(event,'mobile')">
                                                </div>
                                                    </div>
                                                
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="red_plants" class="form-label">लाल वनस्पती<span class="text-danger">*</span></label><br>
                                                <!--<input type=text name="red_plants" id='red_plants' class="form-control">-->
                                                <select name="red_plants" id="redplant" class="form-select mb-3" required><option>श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category where pt_id='1'") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['cat_name'] ?>"><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                                    </div>
                                                    
                                                
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="red_plants_count" class="form-label">एकूण लाल वनस्पती<span class="text-danger">*</span></label><br>
                                                <input type="text" name="red_plants_count" oninput="allowType(event,'number')" id='red_plants_count' class="form-control red_plants_count" readonly >
                                                </div>
                                                    </div>
                                                    
                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="red_plants_count" class="form-label">उपवर्ग
   
                                                </label><br>
                                                <!--<input type="text" name="subcat_id[]" id='subcat_id' class="form-control">-->
                                                 
                                                <select name="subcat_id" id="subcat_id" class="mb-3 form-select"><option value="ट्रे">ट्रे</option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="redcount" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                     <!--           <select class="select2 m-b-10 select2-multiple" name="sub_cat_qty[]" id="sub_cat_qty" style="width: 100%" multiple="multiple" data-placeholder="Choose">-->
                                                    
                                     <!--</select>-->
                                                <input type="text" name="sub_cat_qty" oninput="allowType(event,'number')" id='sub_cat_qty' class="form-control sub_cat_qty">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="rate" class="form-label">दर<span class="text-danger"></span></label><br>
                                     <!--            <select class="select2 m-b-10 select2-multiple" name="rate[]" id="rate" style="width: 100%" multiple="multiple" data-placeholder="Choose">-->
                                                    
                                     <!--</select>-->
                                                <input type="text" name="rate" oninput="allowType(event,'decimal')" id='rate' class="form-control rate">
                                                </div>
                                                    </div>
                                        <div class="col-12 col-md-2">
                                            <div class="form-group">
                                                <label for="total_rs" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="total_rs" oninput="allowType(event,'number')" id='total_rs' class="form-control total_rs " readonly>
                                                </div>
                                        </div>
                                        
                                        <div class="col-md-1 mt-4" id="show-btn">
                                            <h6 class="btn btn-sm btn-outline-success">+</h6>
                                        </div>
                                         
                                                <div id="show-box">
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="subcat_id1" class="form-label">उपवर्ग
   
                                                </label><br>
                                               
                                                <select name="subcat_id1" id="subcat_id1" class="mb-3 form-select"><option value="वाफा">वाफा </option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="sub_cat_qty1" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                     
                                                <input type="text" name="sub_cat_qty1" oninput="allowType(event,'number')" id='sub_cat_qty1' class="form-control sub_cat_qty1">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="rate1" class="form-label">दर<span class="text-danger"></span></label><br>
                                    
                                                <input type="text" name="rate1" oninput="allowType(event,'decimal')" id='rate1' class="form-control rate1">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="total_rs1" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="total_rs1" oninput="allowType(event,'number')" id='total_rs1' class="form-control total_rs1" readonly>
                                                </div>
                                                    </div>
      </div>
  </div>
                                        <script>
      /**
| Use this function in your code 
*/

function show_box(){
  // the second box will be hide by default
  $('#show-btn').next('div#show-box').css('display', 'none');
  
  // Show the second box when click on the frist box
  $('#show-btn').click(function(){
    $(this).next('#show-box').slideToggle(400);
  });
}

show_box();
  </script>            
                                                    
                                                    
                                                    
                                                    
                                            <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="yellow_plants" class="form-label">पिवळी वनस्पती<span class="text-danger">*</span></label><br>
                                                <!--<input type=text name="red_plants" id='red_plants' class="form-control">-->
                                                <select name="yellow_plants" id="yellowplant" class="form-control mb-3" required><option>श्रेणी निवडा</option>	
										<?php $getcat = mysqli_query($connect,"SELECT * from marigold_category where pt_id='2'") ?>
																	<?php if ($getcat && mysqli_num_rows($getcat)): ?>
																		<?php while ($getcus=mysqli_fetch_assoc($getcat)):?>
																		<option value="<?= $getcus['cat_name'] ?>"><?= $getcus['cat_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
														</select>
                                                </div>
                                                    </div>
                                                    
                                                
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="yellow_plants_count" class="form-label">एकूण पिवळी वनस्पती<span class="text-danger">*</span></label><br>
                                                <input type="text" name="yellow_plants_count" oninput="allowType(event,'number')" id='yellow_plants_count' class="form-control" readonly>
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ysubcat_id" class="form-label">उपवर्ग<span class="text-danger">*</span></label><br>
                                               
                                                  <select name="ysubcat_id" id="ysubcat_id" class="mb-3 form-select"><option value="ट्रे">ट्रे</option>
														</select>
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="yellowcount" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                                <input type="text" name="yellowcount" oninput="allowType(event,'number')" id='yellowcount' class="form-control yellowcount">
                                                </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ratey" class="form-label">दर<span class="text-danger"></span></label><br>
                                                <input type="text" name="ratey" oninput="allowType(event,'decimal')" id='ratey' class="form-control ratey">
                                                </div>
                                                    </div>
                                                      <div class="col-12 col-md-2">
                                                <div class="form-group">
                                                <label for="total_rsy" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                <input type="text" name="total_rsy" oninput="allowType(event,'number')" id='total_rsy' class="form-control total_rsy" readonly>
                                                </div>
                                                    </div>
                                                    <div class="col-md-1 mt-4" id="show-btn1">
                                            <h6 class="btn btn-sm btn-outline-success">+</h6>
                                        </div>
                                         
                                                <div id="show-box1">
                                                    <div class="row">
                                                        <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="subcat_idy1" class="form-label">उपवर्ग
                                                </label><br>
                                               
                                                <select name="subcat_idy1" id="subcat_idy1" class="mb-3 form-select"><option value="वाफा">वाफा</option>
														</select>
                                                </div>
                                                    </div>
                                               <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="sub_cat_qtyy1" class="form-label">उपश्रेणी प्रमाण<span class="text-danger"></span></label><br>
                                     
                                                <input type="text" name="sub_cat_qtyy1" oninput="allowType(event,'number')" id='sub_cat_qtyy1' class="form-control sub_cat_qtyy1"> 
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="ratey1" class="form-label">दर<span class="text-danger"></span></label><br>
                                    
                                                <input type="text" name="ratey1" oninput="allowType(event,'decimal')" id='ratey1' class="form-control ratey1">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-3">
                                                <div class="form-group">
                                                <label for="yellow_total" class="form-label">एकूण रु<span class="text-danger"></span></label><br>
                                                
                                                <input type="text" name="yellow_total" oninput="allowType(event,'number')" id='yellow_total' class="form-control yellow_total" readonly>
                                                </div>
                                                    </div>
      </div>
  </div>
 <script>
      /**
| Use this function in your code 
*/

function show_box1(){
  // the second box will be hide by default
  $('#show-btn1').next('div#show-box1').css('display', 'none');
  
  // Show the second box when click on the frist box
  $('#show-btn1').click(function(){
    $(this).next('#show-box1').slideToggle(400);
  });
}

show_box1();
  </script>       
                                            
          <!--                                  <div class="col-12 col-md-6 my-2 mt-2">-->
          <!--                                      <div class="form-group">-->
          <!--                                      <label for="yellow_plants" id="yellowplant" class="form-label">पिवळी वनस्पती<span class="text-danger">*</span></label><br>-->
                                                <!--<input type=text name="yellow_plants" class="form-control" id='yellow_plants'>-->
          <!--                                       <select name="yellowplant" id="yellowplant" class="form-control mb-3" required><option>श्रेणी निवडा</option>	-->
										<!--<?php $getycat = mysqli_query($connect,"SELECT * from marigold_category where pt_id='2'") ?>-->
										<!--							<?php if ($getycat && mysqli_num_rows($getycat)): ?>-->
										<!--								<?php while ($getyrow=mysqli_fetch_assoc($getycat)):?>-->
										<!--								<option value="<?= $getyrow['cat_id'] ?>"><?= $getyrow['cat_name'] ?></option>-->
										<!--								<?php endwhile ?>-->
										<!--							<?php endif ?>-->
										<!--				</select>-->
          <!--                                      </div>-->
          <!--                                          </div>-->
                                                    
          <!--                                      <div class="col-12 col-md-6 my-2 mt-2">-->
          <!--                                      <div class="form-group">-->
          <!--                                      <label for="yellow_plants_count" class="form-label">Total पिवळी वनस्पती<span class="text-danger">*</span></label><br>-->
          <!--                                      <input type=text name="yellow_plants_count" oninput="allowType(event,'number')" id='yellow_plants_count' class="form-control">-->
          <!--                                      </div>-->
          <!--                                          </div>-->
                                                    
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="total_amount" class="form-label">एकूण रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="total_amount" oninput="allowType(event,'number')" id='total_amount' class="form-control total_amount" readonly>
                                                </div>
                                                    </div>
                                                     
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="adv_amt" class="form-label">ऍडव्हान्स रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="adv_amt" oninput="allowType(event,'number')" id='adv_amt' class="form-control">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="adv_amt" class="form-label">पेमेंट निवडा<span class="text-danger">*</span></label><br>
                                                
																	<select name="pay_mode" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option value="cash">रोख</option>
																		<option value="sbi">आदित्य नर्सरी SBI</option>
																		<option value="mgb">आदित्य नर्सरी MGB</option>
																		<option value="ds_bank">डीएस बँक</option>
																		<option value="other_bank">इतर बँक</option>
																	</select>
															
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-6 my-2">
                                                <div class="form-group">
                                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span class="text-danger">*</span></label><br>
                                                <input type=text name="pending_amt" oninput="allowType(event,'number')" id='pending_amt' class="form-control" readonly>
                                                </div>
                                                    </div>
                                                <!--<div class="col-12 col-md-6 my-2 mt-2">-->
                                                <!--<div class="form-group">-->
                                                <!--<label for="deposit_again" class="form-label">Deposit Again<span class="text-danger">*</span></label><br>-->
                                                <!--<input type=text name="deposit_again" id='deposit_again' class="form-control">-->
                                                <!--</div>-->
                                                <!--    </div>-->
                                                <!--<div class="col-12 col-md-6 my-2 mt-2">-->
                                                <!--<div class="form-group">-->
                                                <!--<label for="finally_left" class="form-label">Finally Left<span class="text-danger">*</span></label><br>-->
                                                <!--<input type=text name="finally_left" id='finally_left' class="form-control" readonly>-->
                                                <!--</div>-->
                                                <!--    </div>-->
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="red_giving_date" class="form-label">लाल देणारी तारीख<span class="text-danger">*</span></label><br>
                                                <input type=date name="red_giving_date" id='red_giving_date' class="form-control">
                                                </div>
                                                    </div>
                                            
                                            <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="yellow_giving_date" class="form-label">पिवळी देणारी तारीख<span class="text-danger">*</span></label><br>
                                                <input type="date" name="yellow_giving_date" id='yellow_giving_date' class="form-control">
                                                </div>
                                                    </div>
                                                  
                                                <div class="col-12 col-md-6 my-2 mt-2">
                                                <div class="form-group">
                                                <label for="date_given" class="form-label">वितरण तारीख</label>
                                                <input type="date" name="date_given" class="form-control" id="date_given" placeholder="" >
                                                </div>
                                                    </div>
                                                    
                                                <!--     <div class="col-12 col-md-6 my-2 mt-2">-->
                                                <!--<div class="form-group">-->
                                                <!--<label for="sign" class="form-label">Upload Signature<span class="text-danger">*</span></label><br>-->
                                                <!--<input type=file name="sign" id='sign' class="form-control">-->
                                                <!--</div>-->
                                                <!--    </div>-->
                                            </div>
                                                
                                           
                                       
                                        <button type="submit" name="zendu_book_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="zendu_booking_list" class="btn btn-dark mt-3">मागे</a>
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
<div class="modal fade" id="cusModal" tabindex="-1" aria-labelledby="cusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cusModalLabel">नवीन ग्राहक जोडा</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname" placeholder="ग्राहकाचे नाव" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email" placeholder="इमेल आयडी">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                        <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel" placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control" required oninput="allowType(event, 'mobile')">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">लिंग</label>
                                        <br>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="male" name="customer_gender" class="form-check-input" id="male" checked>
                                            <label class="form-check-label" for="male">पुरुष</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="female" name="customer_gender" class="form-check-input" id="female">
                                            <label class="form-check-label" for="female">महिला</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="other" name="customer_gender" class="form-check-input" id="other">
                                            <label class="form-check-label" for="other">इतर</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य</label>
                                            <select name="state" id="state" class="form-select">
												<option selected>निवडा...</option>
							<?php $getStates = mysqli_query($connect,"select * from states"); ?>
							<?php if (mysqli_num_rows($getStates)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
							<option value="<?= $stRow['sname']?>">
								<?= $stRow['sname']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
									</div>
                                </div>
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">जिल्हे </label>
                                        <select class="form-select" id="city" name="city">
							                <option>निवडा...</option>
						                </select>                                    
						            </div>
                                </div>
                                
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">तालुका</label>
                                            <select class="form-select" id="tal" name="taluka">
							                    <option>निवडा...</option>
						                    </select>  
									</div>
                                </div>
                                <div class="col-12 col-md-6 my-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">गाव</label>
                      <!--                  <select class="form-select" id="village" name="village">-->
							               <!--     <option>निवडा...</option>-->
						                <!--</select>                                   -->
						                <input type="text" class="form-control" id="village" name="village">
						            </div>
                                </div>
                            </div>     
                            
                            <!--<div class="row">-->
                            <!--   <div class="col-12">-->
                            <!--        <label for="Address" class="form-label">Address</label>-->
                                   
                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_success"></textarea>-->
                                   
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <button type="submit" name="customer_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="customer_list" class="btn btn-dark mt-3">मागे</a>
                        </form>
      </div>
    </div>
  </div>
</div>		
<?php include "footer.php"; ?>
<script type="text/javascript">
  $(document).ready(function(){
    $("select#redplant").change(function(){
          var g = $("#redplant option:selected").val();
          //alert(g);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { rqty : g  } 
          }).done(function(data){
              $("#red_plants_count").val(data);
          });
      });
  });
  
  
  $(document).ready(function(){
    $("select#redplant").change(function(){
          var s = $("#redplant option:selected").val();
          // alert(s);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { subcat : s } 
          }).done(function(data){
              $("#subcat_id").val(data);
          });
      });
  });
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
//           alert(s);
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { subcatqty : s } 
//           }).done(function(data){
//               $("#sub_cat_qty").val(data);
//           });
//       });
//   });
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
           
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { rate : s } 
//           }).done(function(data){
//               $("#rate").val(data);
//           });
//       });
//   });
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
           
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { totalrs : s } 
//           }).done(function(data){
//               $("#total_rs").val(data);
//           });
//       });
//   });
  
  
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
//           alert(s);
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { subcatqty : s } 
//           }).done(function(data){
//               $("#sub_cat_qty1").val(data);
//           });
//       });
//   });
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
           
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { rate : s } 
//           }).done(function(data){
//               $("#rate1").val(data);
//           });
//       });
//   });
//   $(document).ready(function(){
//     $("select#subcat_id").change(function(){
//           var s = $("#subcat_id option:selected").val();
           
//           $.ajax({
//               type: "POST",
//               url: "ajax_product", 
//               data: { totalrs : s } 
//           }).done(function(data){
//               $("#total_rs1").val(data);
//           });
//       });
//   });
  
 $(document).ready(function(){
    $("select#yellowplant").change(function(){
          var x = $("#yellowplant option:selected").val();
          //alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { yellowqty : x  } 
          }).done(function(data){
              $("#yellow_plants_count").val(data);
          });
      });
  });
  
  
  $(document).ready(function(){
    $("select#yellowplant").change(function(){
          var s = $("#yellowplant option:selected").val();
           
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { subcat : s } 
          }).done(function(data){
              $("#ysubcat_id").val(data);
          });
      });
  });
  
  
  $(document).ready(function(){
    $("select#yellowplant").change(function(){
          var s = $("#yellowplant option:selected").val();
           
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { subcatqty : s } 
          }).done(function(data){
              $("#yellowcount").val(data);
          });
      });
  });
  
  
  $(document).ready(function() {
    //this calculates values automatically total sub
    sub();
    $("#total_amount, #adv_amt").on("input", function() {
        sub();
    });
    
     //this calculates values automatically finally left
    // pending_sub();
    // $("#pending_amt, #deposit_again").on("keydown keyup", function() {
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
        
//         function pending_sub() {
//              let totpending = document.getElementById('pending_amt').value;
//             let depagain = document.getElementById('deposit_again').value;
// 			let finalleft = parseInt(totpending) - parseInt(depagain);
//             if (!isNaN(finalleft)) {
// 				document.getElementById('finally_left').value = finalleft;
//             }
//         }
//mul red sub qty*rate
$(document).ready(function() {
   $(".sub_cat_qty, .rate").on("input", mul);
});
function mul() {
            let tamt = $('.sub_cat_qty').val();
            let aamt = $('.rate').val();
			let result1 = Number(tamt) * Number(aamt);
			$('.total_rs').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }
        
$(document).ready(function() {
  $(".sub_cat_qty1, .rate1").on("input", subcat);
});
function subcat() {
            let tamt = $('.sub_cat_qty1').val();
            let aamt = $('.rate1').val();
			let result1 = Number(tamt) * Number(aamt);
			$('.total_rs1').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }
        
        
  //mul yellow sub qty*rate
$(document).ready(function() {
   $(".yellowcount, .ratey").on("input", yellowmul);
});
function yellowmul() {
            let tamt = $('.yellowcount').val();
            let aamt = $('.ratey').val();
			let result1 = Number(tamt) * Number(aamt);
			$('.total_rsy').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }   
 $(document).ready(function() {
   $(".sub_cat_qtyy1, .ratey1").on("input", yellowmul1);
});
function yellowmul1() {
            let tamt = $('.sub_cat_qtyy1').val();
            let aamt = $('.ratey1').val();
			let result1 = Number(tamt) * Number(aamt);
			$('.yellow_total').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }   
$(document).ready(function() {
  $(".total_rs, .total_rs1,.total_rsy,.yellow_total,.sub_cat_qty,.rate,.sub_cat_qty1,.rate1,.yellowcount,.ratey,.sub_cat_qtyy1,.ratey1").on("keyup", totalamt);
});
function totalamt() {
            let tamt = $('.total_rs').val();
            let aamt = $('.total_rs1').val();
            let tamt1 = $('.total_rsy').val();
            let aamt1 = $('.yellow_total').val();
			let result1 = Number(tamt) + Number(aamt) + Number(tamt1) + Number(aamt1);
			$('.total_amount').val(!isNaN(result1) ? result1 : 0).trigger('change');
        }
        
</script>
<script>
    //customers state,city,village,taluka
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
      
    
    $(".cus_id").change(function() {
		var b = $(".cus_id option:selected").val();
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { gav: b }
		}).done(function(data) {
			$("#gav").val(data);
		});
	});
	
    
    $(".cus_id").change(function() {
		var cus = $(".cus_id option:selected").val();
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { mob: cus }
		}).done(function(data) {
			$("#mob").val(data);
		});
	});
      
  });
</script>
<script>
    function searchCustomers(query) {
        const results = document.getElementById('search-results');
        const items = results.querySelectorAll('.dropdown-item');
        const value = query.toLowerCase();
        let found = false;                                          

        // Show matching results
        items.forEach(item => {
            if (item.textContent.toLowerCase().includes(value)) {
                item.style.display = 'block';
                found = true;
            } else {
                item.style.display = 'none';
            }
        });

        results.style.display = found ? 'block' : 'none';
    }

    function selectCustomer(id, name, mobno) {
        document.getElementById('customer_search').value = `${name} | ${mobno}`;
        document.getElementById('customer_id').value = id;
        document.getElementById('search-results').style.display = 'none';
    }
</script>