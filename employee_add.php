<?php
require_once "config.php";
Aditya::subtitle('नवीन कर्मचारी जोडा');
/*------ Add details ------*/
if (isset($_POST['emp_add'])){
    escapeExtract($_POST);
    
    if (!empty($emp_email)) {
        $sql="SELECT * FROM employees WHERE emp_mobile='$emp_mobile'";
    } else {
        $sql="SELECT * FROM employees WHERE emp_mobile='$emp_mobile'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: employee_list?action=Success&action_msg='.$emp_name.' कर्मचारी आधिपासुन आहे..!');
		    exit();
         }else{
        
        if($emp_gender=='male'){
            $emp_salary_type='monthly';
        }else{
            $emp_salary_type='daily';
        }
        $insert=mysqli_query($connect,"INSERT INTO employees(emp_name, emp_mobile, emp_email, emp_address, emp_gender, emp_salary, emp_salary_type, emp_joined) VALUES ('$emp_name','$emp_mobile','$emp_email','$emp_address', '$emp_gender','$emp_salary','$emp_salary_type','$emp_joined')");

        if($insert){
        header('Location: employee_list?action=Success&action_msg='.$emp_name.' नवीन कर्मचारी जोडले..!');
		exit();
        }else{
        header('Location: employee_list?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

/*------ update details ------*/
if(isset($_POST['emp_edit'])){ 
	escapeExtract($_POST);
    
    if($emp_gender=='male'){
            $emp_salary_type='monthly';
        }else{
            $emp_salary_type='daily';
        }
	$up="update employees set
	emp_name='{$emp_name}', 
	emp_mobile='{$emp_mobile}',
	emp_email='{$emp_email}',
	emp_address='{$emp_address}',
	emp_gender='{$emp_gender}',
	emp_salary='{$emp_salary}', 
	emp_salary_type='{$emp_salary_type}', 
	emp_joined='{$emp_joined}'
	where emp_id='{$_GET['emp_id']}'";

	$result=mysqli_query($connect,$up);
	if($result){
		header('Location: employee_list?action=Success&action_msg= कर्मचारी ला अपडेट केले...!');
		exit();
	}else{
		header('Location: employee_list?action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
	<?php
		if(isset($_GET['emp_id'])){
            $getEmps=mysqli_query($connect,"select * from employees where emp_id='".$_GET['emp_id']."' ");
            $resEmp=mysqli_fetch_assoc($getEmps);
            extract($resEmp);
		?>
				<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-success">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-success">कर्मचारी अपडेट करा</h5>
						</div>
						<hr>
					
						<form method="post" class="row g-3" id="employee-form">
					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<input type="hidden" id="employee-form-action" name="add_employee" value="">
								<label for="" class="form-label">कर्मचाऱ्याचे नाव <span class="text-danger">*</span></label>
								<input type="text" name="emp_name" class="form-control form-control-sm" required value="<?= $emp_name?>">
							</div>
							<div class="col-12">
								<label for="" class="form-label">मोबाईल नंबर     <span class="text-danger">*</span></label>
								<input type="tel" name="emp_mobile" class="form-control form-control-sm" oninput="allowType(event, 'mobile')" required value="<?= $emp_mobile?>">
							</div>
							<div class="col-12">
								<label for="" class="form-label">इमेल आयडी</label>
								<input type="email" name="emp_email" class="form-control form-control-sm" value="<?= $emp_email?>">
							</div>
							<div class="col-12">
								<label for="" class="form-label">प्रतिदिन पगार   <span class="text-danger">*</span></label>
								<input type="text" name="emp_salary" class="form-control form-control-sm" oninput="allowType(event, 'number')" required value="<?= $emp_salary?>">
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<label for="" class="form-label required">रुजू होण्याची तारीख <span class="text-danger">*</span></label>
								<input type="date" name="emp_joined" class="form-control form-control-sm" required value="<?= $emp_joined?>">
							</div>
							<div class="col-12">
								<label for="" class="form-label">लिंग</label>
								<select name="emp_gender" class="form-control form-control-sm">
									<option value="male" <?php if($emp_gender=='male'){echo "selected";}?>>पुरुष</option>
									<option value="female"  <?php if($emp_gender=='female'){echo "selected";}?>>महिला</option>
								</select>
							</div>
							<div class="col-12">
								<label for="" class="form-label">पत्ता</label>
								<textarea name="emp_address" class="form-control form-control-sm" rows="5"><?= $emp_address?></textarea>
							</div>
						</div>
					</div>
					
					<div class="col-12 col-md-6">
					    <button type="submit" name="emp_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                    <a href="employee_list" class="btn btn-dark mt-3">मागे</a>
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
							<div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-success">नवीन कर्मचारी जोडा</h5>
						</div>
						<hr>
					
						<form method="post" class="row g-3" id="employee-form">
					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<input type="hidden" id="employee-form-action" name="add_employee" value="">
								<label for="" class="form-label">कर्मचाऱ्याचे नाव <span class="text-danger">*</span></label>
								<input type="text" name="emp_name" class="form-control form-control-sm" required="">
							</div>
							<div class="col-12">
								<label for="" class="form-label">मोबाईल नंबर     <span class="text-danger">*</span></label>
								<input type="tel" name="emp_mobile" class="form-control form-control-sm" oninput="allowType(event, 'mobile')" required>
							</div>
							<div class="col-12">
								<label for="" class="form-label">इमेल आयडी</label>
								<input type="email" name="emp_email" class="form-control form-control-sm">
							</div>
							<div class="col-12">
								<label for="" class="form-label">प्रतिदिन पगार   <span class="text-danger">*</span></label>
								<input type="text" name="emp_salary" class="form-control form-control-sm" oninput="allowType(event, 'number')" required>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<label for="" class="form-label required">रुजू होण्याची तारीख <span class="text-danger">*</span></label>
								<input type="date" name="emp_joined" class="form-control form-control-sm" required value="<?= date('Y-m-d')?>">
							</div>
							<div class="col-12">
								<label for="" class="form-label">लिंग</label>
								<select name="emp_gender" class="form-control form-control-sm">
									<!--<option value="noshare">माहित नाही</option>-->
									<option value="male">पुरुष</option>
									<option value="female">महिला</option>
									<!--<option value="other">इतर</option>-->
								</select>
							</div>
							<div class="col-12">
								<label for="" class="form-label">पत्ता</label>
								<textarea name="emp_address" class="form-control form-control-sm" rows="5"></textarea>
							</div>
						</div>
					</div>
					
					<div class="col-12 col-md-6">
					    <button type="submit" name="emp_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                    <a href="employee_list" class="btn btn-dark mt-3">मागे</a>
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