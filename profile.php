<?php require_once "config.php";
Aditya::Subtitle('प्रोफाईल');
$getAdminPic=mysqli_query($connect,"SELECT profile_photo FROM admin");
$getRes=mysqli_fetch_assoc($getAdminPic);
/*------ Edit Admin details ------*/
if(isset($_POST['edit'])){ 
	escapeExtract($_POST);
	/* profile photo */
	$name=$_FILES['profile_photo']['name'];
	$temp=$_FILES['profile_photo']['tmp_name'];
	if($name){
		$upload= "image/";
		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
		$profile_photo= 'PROFILE-ADMIN'.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
		if(move_uploaded_file($temp, $upload.$profile_photo)){
		    unlink($upload.$ruser['profile_photo']);
		}
	}else{
	    $profile_photo=$getRes['profile_photo'];
	}
	$up="update admin set
	full_name='{$full_name}',
	mobile='{$mobile}',
    address='{$address}',
    profile_photo='{$profile_photo}'
	where id='{$_SESSION['id']}'";

	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: profile?action=Success&action_msg=बदल झाले..!');
		exit();
	}else{
		header('Location: profile?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
if (isset($_POST['check_old_password'])) {
	if (pass_hash($_POST['check_old_password']) === $authUser->password) {
		echo "matched";
	} else {
		echo 'not_matched';
	}
	exit();
}
if (isset($_POST['change_password'])) {
	if (!empty($_POST['password'])) {
		$password = pass_hash($_POST['password']);
		if (mysqli_query($connect, "UPDATE admin SET password = '{$password}' WHERE id = '{$authUser->id}'")) {
			header("Location: ./?logout=true&redirect={$redirect}");
			exit();
		}
	}
}


?>
<?php require_once 'header.php'; ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body px-3 py-4">
                                <div class="d-flex flex-column align-items-center text-center">
                                    
                                    <img src="image/<?= !empty($authUser->profile_photo) ? $authUser->profile_photo : 'no_img.jpg'?>" style="object-fit: cover;" alt="propic" class="rounded-circle p-1 border border-success" height="100" width="100">
                                    <div class="mt-3">
                                        <h4>
                                            <?= $authUser->full_name ?>
                                        </h4>
                                        
                                        <p class="text-muted font-size-sm">
                                            <?= $authUser->address ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                         <ul class="flex-nowrap my-3 mt-md-0 nav nav-pills ox-auto scrollbar-hidden text-nowrap" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dark rounded-10 active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">प्रोफाइल माहिती</button>
                            </li>
                            
                            <li class="nav-item" role="presentation">
                                <button class="nav-link dark rounded-10" id="pills-Change-pass-tab" data-bs-toggle="pill" data-bs-target="#pills-Change-pass" type="button" role="tab" aria-controls="pills-bank" aria-selected="false" tabindex="-1">पासवर्ड बदला</button>
                            </li>
                            
                           
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card">
                                    <div class="card-body px-3 py-4">
                                        
                                        <form class="row g-3" method="POST" enctype="multipart/form-data">
										<div class="col-sm-3">
                                        <h6 class="mb-0">पूर्ण नाव</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="full_name" class="form-control" value="<?= $authUser->full_name ?>">
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">ईमेल</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="username" class="form-control" value="<?= $authUser->username ?>" readonly>
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">मोबईल</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="mobile" class="form-control" value="<?= $authUser->mobile ?>" oninput="allowType(event, 'mobile')">
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">पत्ता</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <textarea class="form-control" name="address"><?= $authUser->address ?></textarea>
                                    </div>
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">प्रोफाईल फोटो</h6>
                                    </div>
                                    <div class="col-12 col-lg-7">
                                                            <input id="image" type="file" name="profile_photo" class="form-control"/>
                                                        </div>
                                                        <div class="col-12 col-lg-2 text-center text-md-end">
                                                            <img src="image/<?= !empty($authUser->profile_photo) ? $authUser->profile_photo : 'no_img.jpg'?>" style="object-fit: cover;" alt="propic" class="rounded-circle p-1 border border-success" height="70" width="70">
                                                        </div>
                                        
											<div class="col-12 col-lg-3">
												<div class="d-grid">
													<button type="submit" name="edit" class="btn btn-dark me-2">जतन करा  <i class="bx bx-edit"></i> </button>
												</div>
												
											</div>
										</form>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div class="tab-pane fade" id="pills-Change-pass" role="tabpanel" aria-labelledby="pills-Change-pass-tab">
                                <div class="card">
                                    <div class="card-body px-3 py-4">
                                        <form method="POST" class="row g-3 mt-0" id="password-change-form">
                                	<div class="col-sm-4">
                                		<h6>जुना पासवर्ड</h6>
                                	</div>
                                	<div class="col-sm-7">
                                		<input type="password" class="form-control" name="old_password" oninput="chechOldPassword(this)" required>
                                	</div>
                                	<div class="col-sm-4">
                                		<h6>नवीन पासवर्ड</h6>
                                	</div>
                                	<div class="col-sm-7">
                                		<input type="password" class="form-control" name="password" oninput="checkPassword(this)" required>
                                	</div>
                                	<div class="col-sm-4">
                                		<h6>नवीन पासवर्ड कन्फर्म करा</h6>
                                	</div>
                                	<div class="col-sm-7">
                                		<input type="password" class="form-control" name="cpassword" oninput="matchPassword(this)" required>
                                	</div>
                                	<div class="col-sm-3">
                                		<button type="submit" name="change_password" class="btn btn-dark">पासवर्ड बदला</button>
                                	</div>
                                </form>
                                                                         
                                       
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php require_once "footer.php"; ?>
<script>
$(document).ready(function(){
    //Image file input change event
    $("#image").change(function(){
        readImageData(this);//Call image read and render function
    });
});
 
function readImageData(imgData){
    if (imgData.files && imgData.files[0]) {
        var readerObj = new FileReader();
        
        readerObj.onload = function (element) {
            $('#preview_img').attr('src', element.target.result);
        }
        
        readerObj.readAsDataURL(imgData.files[0]);
    }
}

function chechOldPassword(el){
	const input = $(el);
	let error_msg = input.next('.error-msg');
	if (!error_msg.length) {
		input.after('<div class="small error-msg mt-2"></div>');
		error_msg = input.next('.error-msg');
	}
	$.ajax({
		url: '/profile',
		method: 'POST',
		data: {check_old_password: (input.val())},
		success: res => {
			if (res==='matched') {
				error_msg.removeClass('text-danger').addClass('text-success').text('Old password matched');
				input[0].setCustomValidity('');
			} else {
				error_msg.removeClass('text-success').addClass('text-danger').text('Old password not matched');
				input[0].setCustomValidity('Old password not matched');
			}
		}
	});
}
function validatePassword(password) {
	if (!(/^(.{8,20}$)/.test(password))) {
	    return 'Password must be between 8 to 20 chars';
	}
	else if (!(/^(?=.*[A-Z])/.test(password))) {
	    return 'Password must contain at least one uppercase';
	}
	else if (!(/^(?=.*[a-z])/.test(password))) {
	    return 'Password must contain at least one lowercase';
	}
	else if (!(/^(?=.*[0-9])/.test(password))) {
	    return 'Password must contain at least one digit';
	}
	else if (!(/^(?=.*[\$_@!])/.test(password))) {
	    return "Password must contain symbol from $_@!";
	}
	return true;
}
function checkPassword(el) {
	let error_msg = $(el).next('.error-msg');
	if (!error_msg.length) {
		$(el).after('<div class="small error-msg mt-2"></div>');
		error_msg = $(el).next('.error-msg');
	}
	const validation = validatePassword(el.value);
	if (validation===true) {
		error_msg.removeClass('text-danger').addClass('text-success').text('Strong password');
		el.setCustomValidity('');
	} else {
		error_msg.removeClass('text-success').addClass('text-danger').text(validation);
		el.setCustomValidity(validation);
	}
}
function matchPassword(el) {
	let error_msg = $(el).next('.error-msg');
	if (!error_msg.length) {
		$(el).after('<div class="small error-msg mt-2"></div>');
		error_msg = $(el).next('.error-msg');
	}
	if ($('[name="password"]').val() === $('[name="cpassword"]').val()) {
		error_msg.removeClass('text-danger').addClass('text-success').text('Password matched');
		el.setCustomValidity('');
	} else {
		error_msg.removeClass('text-success').addClass('text-danger').text('Password and confirm password not matched');
		el.setCustomValidity('Password and confirm password not matched');
	}
}
function togglePasswordChange() {
	const form = $('#password-change-form');
	if (form.css('display')=='none') {
		form.slideDown();
	} else {
		form.slideUp();
	}
}
</script>