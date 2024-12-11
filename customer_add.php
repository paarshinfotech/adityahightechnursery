<?php
require_once "config.php";
Aditya::subtitle('नवीन ग्राहक जोडा');
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
             header('Location: customer_list?action=Success&action_msg='.$customer_name.' ग्राहक आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO customer(customer_name, customer_mobno, customer_gender, customer_email,state, city, taluka, village) VALUES ('$customer_name','$customer_mobno','$customer_gender','$customer_email','$state','$city','$taluka','$village')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: customer_list?action=Success&action_msg='.$customer_name.' नवीन ग्राहक जोडले..!');
		exit();
        }else{
        header('Location: customer_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

/*------ update details ------*/
if(isset($_POST['customer_edit'])){ 
	escapeExtract($_POST);
// 	/* profile photo */
// 	$name=$_FILES['profile_photo']['name'];
// 	$temp=$_FILES['profile_photo']['tmp_name'];
// 	if($name){
// 		$upload= "../admin.mansicab.com/assets/uploads/vendor/profile/";
// 		$imgExt=strtolower(pathsuccess($name, PATHsuccess_EXTENSION));
// 		$profile_photo= 'PROFILE-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
// 		if(move_uploaded_file($temp, $upload.$profile_photo)){
// 		    unlink($upload.$ruser['profile_photo']);
// 		}
// 	}else{
// 	    $profile_photo=$getRes['profile_photo'];
// 	}

	$up="update customer set
	customer_name='{$customer_name}', 
	customer_mobno='{$customer_mobno}',
	customer_gender='{$customer_gender}',
	customer_email='{$customer_email}',
	state='{$state}',
	city='{$city}', 
	taluka='{$taluka}', 
	village='{$village}'
	where customer_id='{$_GET['cus_id']}'";

	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: customer_list?action=Success&action_msg= ग्राहकाला अपडेट केले...!');
		exit();
	}else{
		header('Location: customer_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
<!--start page wrapper -->
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <?php
		if(isset($_GET['cus_id'])){
            $getCus=mysqli_query($connect,"select * from customer where customer_id='".$_GET['cus_id']."' ");
            $resCus=mysqli_fetch_assoc($getCus);
            extract($resCus);
		?>
        <div class="row">
            <div class="col-xl-11 mx-auto">

                <div class="card border-top border-0 border-4 border-success">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-success">ग्राहक अपडेट करा</h5>
                        </div>
                        <hr>

                        <form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname"
                                            placeholder="ग्राहकाचे नाव" required value="<?= $customer_name?>">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email"
                                            placeholder="इमेल आयडी" value="<?= $customer_email?>">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                            <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel"
                                            placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control"
                                            required oninput="allowType(event, 'mobile')" value="<?= $customer_mobno?>">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">लिंग</label>
                                        <br>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="male" name="customer_gender"
                                                class="form-check-input" id="male" checked
                                                <?php if($customer_gender=='male'){echo "checked";}?>>
                                            <label class="form-check-label" for="male">पुरुष</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="female" name="customer_gender"
                                                class="form-check-input" id="female"
                                                <?php if($customer_gender=='female'){echo "checked";}?>>
                                            <label class="form-check-label" for="female">महिला</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="other" name="customer_gender"
                                                class="form-check-input" id="other"
                                                <?php if($customer_gender=='other'){echo "checked";}?>>
                                            <label class="form-check-label" for="other">इतर</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य</label>
                                        <select name="state" id="state" class="form-select">
                                            <option selected value="">निवडा...</option>
                                            <?php $getStates = mysqli_query($connect,"select * from states"); ?>
                                            <?php if (mysqli_num_rows($getStates)>0): ?>
                                            <?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
                                                <option value="<?= $stRow['sname']?>"
                                                <?php if($stRow['sname']==$state){echo "selected";}?>>
                                                <?= $stRow['sname']?>
                                            </option>
                                            <?php endwhile ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">जिल्हे</label>
                                        <select class="form-select" id="city" name="city">
                                            <option value="<?php echo $city?>"><?php echo $city?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">तालुका</label>
                                        <select class="form-select" id="tal" name="taluka">
                                            <option value="<?php echo $taluka?>"><?php echo $taluka?></option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">गाव<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="village" name="village"
                                            value="<?= $village?>">
                                    </div>
                                </div>
                            </div>

                            <!--<div class="row">-->
                            <!--   <div class="col-12">-->
                            <!--        <label for="Address" class="form-label">Address</label>-->

                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_success"></textarea>-->

                            <!--    </div>-->
                            <!--</div>-->

                            <button type="submit" name="customer_edit" class="btn btn-success me-2 text-white mt-3">जतन
                                करा</button>
                            <a href="customer_list" class="btn btn-dark mt-3">मागे</a>
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
                            <div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-success">नवीन ग्राहक जोडा</h5>
                        </div>
                        <hr>

                        <form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname"
                                            placeholder="ग्राहकाचे नाव" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email"
                                            placeholder="इमेल आयडी">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                            <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel"
                                            placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control"
                                            required oninput="allowType(event, 'mobile')">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">लिंग</label>
                                        <br>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="male" name="customer_gender"
                                                class="form-check-input" id="male" checked>
                                            <label class="form-check-label" for="male">पुरुष</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="female" name="customer_gender"
                                                class="form-check-input" id="female">
                                            <label class="form-check-label" for="female">महिला</label>
                                        </div>
                                        <div class="form-check form-check-inline custom-control">
                                            <input type="radio" value="other" name="customer_gender"
                                                class="form-check-input" id="other">
                                            <label class="form-check-label" for="other">इतर</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य</label>
                                        <select name="state" id="state" class="form-select">
                                            <option selected value="">निवडा...</option>
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
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">जिल्हे</label>
                                        <select class="form-select" id="city" name="city">
                                            <option value="">निवडा...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">तालुका</label>
                                        <select class="form-select" id="tal" name="taluka">
                                            <option value="">निवडा...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">गाव</label>
                                        <input type="text" class="form-control" id="village" name="village">
                                    </div>
                                </div>
                            </div>

                            <!--<div class="row">
                            <select class="form-select" id="village" name="village">
							                    <option value="">निवडा...</option>
						                </select> 
                            -->
                            <!--   <div class="col-12">-->
                            <!--        <label for="Address" class="form-label">Address</label>-->

                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_success"></textarea>-->

                            <!--    </div>-->
                            <!--</div>-->

                            <button type="submit" name="customer_add" class="btn btn-success me-2 text-white mt-3">जतन
                                करा</button>
                            <a href="customer_list" class="btn btn-dark mt-3">मागे</a>
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
<!--end page wrapper -->

<?php include "footer.php"; ?>
<script>
$(document).ready(function() {
    $("select#state").change(function() {
        var s = $("#state option:selected").val();

        $.ajax({
            type: "POST",
            url: "ajax_master",
            data: {
                state: s
            }
        }).done(function(data) {
            $("#city").html(data);
        });
    });
});
$(document).ready(function() {
    $("select#city").change(function() {
        var s = $("#city option:selected").val();

        $.ajax({
            type: "POST",
            url: "ajax_master",
            data: {
                tal: s
            }
        }).done(function(data) {
            $("#tal").html(data);
        });
    });
});

$(document).ready(function() {
    $("#tal").change(function() {
        var v = $("#tal option:selected").val();
        //alert(v);
        $.ajax({
            type: "POST",
            url: "ajax_master",
            data: {
                village: v
            }
        }).done(function(data) {
            $("#village").html(data);
        });
    });
});
</script>