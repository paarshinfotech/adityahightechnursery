<?php
require_once "config.php";
/*------ Add driver details ------*/
if(isset($_POST['driver_add'])){ 
	escapeExtract($_POST);
	
	if (!empty($demail)) {
        $sql="SELECT * FROM driver WHERE dcontact='$dcontact' OR demail='$demail'";
    } else {
        $sql="SELECT * FROM driver WHERE dcontact='$dcontact'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: driver_list?action=Success&action_msg=Driver Allready Exists..!');
		     exit();
         }
         else{
                //   $password = hash('sha512', $dpassword);
    	 
        	/* profile photo */
        	$name=$_FILES['dprofilephoto']['name'];
        	$temp=$_FILES['dprofilephoto']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/profile/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$dprofilephoto= 'DIR-PROFILE-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$dprofilephoto)){
        		    unlink($upload.$ruser['dprofilephoto']);
        		}
        	}	
        	
        	/* Aadhar Card */
        	$name=$_FILES['aadhar_card']['name'];
        	$temp=$_FILES['aadhar_card']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$aadhar_card= 'DIR-AADHAR-CARD-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$aadhar_card)){
        		    unlink($upload.$ruser['aadhar_card']);
        		}
        	}
        	
        	/* Pan Card */
        	$name=$_FILES['pan_card']['name'];
        	$temp=$_FILES['pan_card']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$pan_card= 'DIR-PAN-CARD-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$pan_card)){
        		    unlink($upload.$ruser['pan_card']);
        		}
        	}
        	
        	/* Driving Licence */
        	$name=$_FILES['driving_licence']['name'];
        	$temp=$_FILES['driving_licence']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$driving_licence= 'DIR-DRI-LIC-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$driving_licence)){
        		    unlink($upload.$ruser['driving_licence']);
        		}
        	}
        	
        	/* Police Verification */
        	$name=$_FILES['police_verification']['name'];
        	$temp=$_FILES['police_verification']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$police_verification= 'DIR-POLICE-VERIFICATION-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$police_verification)){
        		    unlink($upload.$ruser['police_verification']);
        		}
        	}	
    	
        	$Driveradd="INSERT INTO driver(vid, dname, demail,dcontact, dstate, dcity, dgender, dprofilephoto, description,aadhar_card,pan_card,driving_licence,police_verification) values('$vid','$dname','$demail','$dcontact','$dstate','$dcity','$dgender','$dprofilephoto','$description','$aadhar_card','$pan_card','$driving_licence','$police_verification')";
        	$result=mysqli_query($connect,$Driveradd);
        	
        	$did=mysqli_insert_id($connect);
	
    	/* Driver documents && $add2*/
        // 	if(isset($_FILES['bussiness_doc'])){
    //     foreach($_FILES['bussiness_doc']['tmp_name'] as $key => $tmp_name ){
    //         $file_name = $key.$_FILES['bussiness_doc']['name'][$key];
    //         $file_size =$_FILES['bussiness_doc']['size'][$key];
    //         $file_tmp =$_FILES['bussiness_doc']['tmp_name'][$key];
    //         $file_type=$_FILES['bussiness_doc']['type'][$key];  
            
    //         $ext=explode('.',$file_name);
    //         $a='DIR-DOC-'.$vid.'-'.date('YmdHis').rand(1000, 9999).".".end($ext);
            
    //         $extension = strtolower(pathinfo($a,PATHINFO_EXTENSION));  
    //         $url="../admin.mansicab.com/assets/uploads/driver/documents/".$a;
            
    //         $query="INSERT into  driver_documents(doc_vid,doc_did,bussiness_doc) VALUES('$vid','$did','$a')";
            
    //         move_uploaded_file($file_tmp,$url);
        
    //         $add2=mysqli_query($connect,$query);
    //     }
    // }
    
    
	if($result){
		header('Location: driver_list?action=Success&action_msg='.$dname.' Added successfully..!');
		exit();
	}else{
		header('Location: driver_list?action=error&action_msg=something wents wrong..!');
		exit();
	}
 }
}

//select img 
// $getimg=mysqli_query($connect,"select * from driver where did='".$_GET['edit']."' ");
// $imgpro=mysqli_fetch_assoc($getimg);



//delete pro imgs
if(isset($_GET['delete_image'])){
	$sel=mysqli_query($connect,"select * from driver_documents where doc_did='{$_GET['edit']}' AND doc_id='{$_GET['delete_image']}'");
        while ($fetch1=mysqli_fetch_assoc($sel)){
          $img1=$fetch1["bussiness_doc"];
          $isrc1=$img1;
          unlink($isrc1);
        }
    if(mysqli_query($connect, "DELETE FROM driver_documents WHERE doc_id='".$_GET['delete_image']."'")){;
    
    header('Location: driver_add?edit='.$_GET['edit'].'&action=Success&action_msg=Delete successfully..!');
		exit();
    }
}
// add more imgs
// if (isset($_POST['add_extra_img'])){
//     if(isset($_FILES['bussiness_doc'])){
//     foreach($_FILES['bussiness_doc']['tmp_name'] as $key => $tmp_name ){
//         $file_name = $key.$_FILES['bussiness_doc']['name'][$key];
//         $file_size =$_FILES['bussiness_doc']['size'][$key];
//         $file_tmp =$_FILES['bussiness_doc']['tmp_name'][$key];
//         $file_type=$_FILES['bussiness_doc']['type'][$key];  
        
//         $ext=explode('.',$file_name);
//         $a='DIR-DOC-'.$vid.'-'.date('YmdHis').rand(1000, 9999).'.'.end($ext);
        
//         $extension = strtolower(pathinfo($a,PATHINFO_EXTENSION));  
//         $url="../admin.mansicab.com/assets/uploads/driver/documents/".$a;
        
//          $query="INSERT into  driver_documents(doc_vid,doc_did,bussiness_doc) VALUES('$vid','{$_GET['edit']}','$a')";
        
//         move_uploaded_file($file_tmp,$url);
    
//         $add2=mysqli_query($connect,$query);
//     }
// }
// }

/*------ update driver details ------*/
if(isset($_POST['driver_edit'])){ 
	escapeExtract($_POST);
	/* profile photo */
    $name=$_FILES['dprofilephoto']['name'];
	$temp=$_FILES['dprofilephoto']['tmp_name'];
	if($name){
		$upload= "../admin.mansicab.com/assets/uploads/driver/profile/";
		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
		$dprofilephoto= 'PROFILE-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
		if(move_uploaded_file($temp, $upload.$dprofilephoto)){
		    unlink($upload.$ruser['dprofilephoto']);
		}
	}else{
	    $dprofilephoto=$imgpro['dprofilephoto'];
	}
	
	/* Aadhar Card */
        	$name=$_FILES['aadhar_card']['name'];
        	$temp=$_FILES['aadhar_card']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$aadhar_card= 'DIR-AADHAR-CARD-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$aadhar_card)){
        		    unlink($upload.$ruser['aadhar_card']);
        		}
        	}else{
	            $aadhar_card=$imgpro['aadhar_card'];
	        }
        	
        	/* Pan Card */
        	$name=$_FILES['pan_card']['name'];
        	$temp=$_FILES['pan_card']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$pan_card= 'DIR-PAN-CARD-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$pan_card)){
        		    unlink($upload.$ruser['pan_card']);
        		}
        	}else{
	            $pan_card=$imgpro['pan_card'];
	        }
        	
        	/* Driving Licence */
        	$name=$_FILES['driving_licence']['name'];
        	$temp=$_FILES['driving_licence']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$driving_licence= 'DIR-DRI-LIC-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$driving_licence)){
        		    unlink($upload.$ruser['driving_licence']);
        		}
        	}else{
	            $driving_licence=$imgpro['driving_licence'];
	        }
        	
        	/* Police Verification */
        	$name=$_FILES['police_verification']['name'];
        	$temp=$_FILES['police_verification']['tmp_name'];
        	if($name){
        		$upload= "../admin.mansicab.com/assets/uploads/driver/documents/";
        		$imgExt=strtolower(pathinfo($name, PATHINFO_EXTENSION));
        		$police_verification= 'DIR-POLICE-VERIFICATION-'.$vid.'-'.date('YmdHis').rand(1000,9999).".".$imgExt;
        		if(move_uploaded_file($temp, $upload.$police_verification)){
        		    unlink($upload.$ruser['police_verification']);
        		}
        	}else{
	            $police_verification=$imgpro['police_verification'];
        	}

	$up="update driver set
	vid='{$vid}',
	dname='{$dname}',
	demail='{$demail}',
	dcontact='{$dcontact}',
    dstate='{$dstate}',
	dcity='{$dcity}',
	dgender='{$dgender}',
	dprofilephoto='{$dprofilephoto}',
	description='{$description}',
	aadhar_card='{$aadhar_card}',
	pan_card='{$pan_card}',
	driving_licence='{$driving_licence}',
	police_verification='{$police_verification}'
	
	where did='{$_GET['edit']}'";

	$upRes=mysqli_query($connect,$up);
	if($upRes){
		header('Location: driver_list?action=Success&action_msg=Update successfully..!');
		exit();
	}else{
		header('Location: driver_list?action=error&action_msg=something wents wrong..!');
		exit();
	}
}

require_once "sidebar.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
		<?php
		if(isset($_GET['edit'])){
            $view=mysqli_query($connect,"select * from driver where did='".$_GET['edit']."' ");
            $fetch2=mysqli_fetch_assoc($view);
            extract($fetch2);
            $query_img=mysqli_query($connect,"select * from  driver_documents where doc_did = '" .$_GET['edit'] ."'");
		?>
				<div class="row">
				    <div class="col-12 col-lg-8">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Driver Edit</h5>
                          <!-- Vertical Form -->
                          
                          <form class="row g-3" method="POST" enctype="multipart/form-data"> 
            									<div class="col-12 col-md-6">
            										<label for="dname" class="form-label">Name<span class="text-danger">*</span></label>
            										<input type="text" class="form-control" id="dname" name="dname" required value=<?= $dname?>>
            									</div>
            									<div class="col-12 col-md-6">
            										<label for="dcontact" class="form-label">contact<span class="text-danger">*</span></label>
            										<input type="text" minlenght="10" maxlenght="10" pattern="[6789]{1}[0-9]{9}" class="form-control" id="dcontact" name="dcontact" required maxlength="10" minlength="10" value=<?= $dcontact?>>
            									</div>
            									<div class="col-12 col-md-6"><label for="area" class="form-label">Gender<span class="text-danger">*</span></label>
                    											<div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="male" name="dgender" class="custom-control-input" value="male" <?php if($dgender=='male'){ echo "checked";} ?>>
                      <label class="custom-control-label" for="male">Male</label>
                    </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" id="Female" name="dgender" class="custom-control-input" value="female" <?php if($dgender=='female'){ echo "checked";} ?>>
                      <label class="custom-control-label" for="Female">Female</label>
                    </div>
                                                    </div>
            								
            									<div class="col-12 col-md-6">
            										<label for="demail" class="form-label">Email<span class="text-danger">*</span></label>
            										<input type="text" class="form-control" id="demail" name="demail" required value=<?= $demail?>>
            									</div>
            									<!--<div class="col-12 col-md-6">-->
            									<!--	<label for="dpassword" class="form-label">Password</label>-->
            	        <!--                       		<input type="password" class="form-control" name="dpassword" oninput="checkPassword(this)" required>-->
            
            									<!--</div>-->
            									<!--<div class="col-12 col-md-6">-->
            									<!--	<label for="dpassword" class="form-label">Confirm Password</label>-->
            	        <!--                       		<input type="password" class="form-control" name="dpassword" oninput="checkPassword(this)" required>-->
            
            									<!--</div>-->
            									
            									<div class="col-12 col-md-6">
            										<label for="state" class="form-label">State<span class="text-danger">*</span></label>
            										
            										<select class="form-select" id="state" name="dstate" required="">
                                                    <?php $getStates = mysqli_query($connect,"select * from states"); ?>
            							<?php if (mysqli_num_rows($getStates)>0): ?>
            							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
            							<option value="<?= $stRow['state_id']?>" <?php if($stRow['state_id']==$dstate){echo "selected";}?>>
            								<?= $stRow['sname']?>
            							</option>
            							<?php endwhile ?>
            							<?php endif ?>
                                                    </select>
                                                    
            									</div>
            									
            									<div class="col-12 col-md-6">
            										<label for="city" class="form-label">City<span class="text-danger">*</span></label>
            										
            										<select  class="form-control" name="dcity" id="city">
            			                                <option value="">Select City</option>
            			                            <?php $getStates = mysqli_query($connect,"select * from districts"); ?>
            							<?php if (mysqli_num_rows($getStates)>0): ?>
            							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
            							<option value="<?= $stRow['dname']?>" <?php if($stRow['dname']==$city){echo "selected";}?>>
            								<?= $stRow['dname']?>
            							</option>
            							<?php endwhile ?>
            							<?php endif ?>
                                  			        </select>
            										
            									</div>
            								    
            								        	<div class="row g-3 align-items-center">
                                                                    <div class="col-12 col-lg-4">
                                                                        <input id="image" type="file" name="dprofilephoto" class="form-control" value="<?php echo $dprofilephoto ?>" />
                                                                    </div>
                                                                    <div class="col-12 col-lg-2 text-center text-md-end">
                                                                        <img id="preview_img" style="object-fit: cover;" class="rounded-circle p-1 border border-primary" src="//admin.mansicab.com/assets/uploads/driver/profile/<?= !empty($dprofilephoto) ? $dprofilephoto : 'no_img.jpg' ?>" height="70" width="70" loading="lazy">
                                                                    </div>
                                                                    <div class="col-12 col-lg-6">
            												<label for="description" class="form-label">Description</label>
            												<div class="input-group" id="description">
            													<textarea name="description" class="form-control"><?= $description?></textarea>
            												</div>
            											</div>
                                                                </div>
            								            <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Aadhar Card<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="aadhar_card" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Pan Card<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="pan_card" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Driving Licence<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="driving_licence" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Police Verification</label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="police_verification" class="form-control">
                                            </div>
                                        </div>
                                    </div>
            								            <!--<div class="col-12 col-lg-6">-->
            								            <!--    	<label for="description" class="form-label">Upload Documents</label>-->
                        								<!--        <div class="input-group mb-3">-->
                                <!--                                        <input type="file" id="bussiness_doc" multiple name="bussiness_doc[]" class="form-control" accept=".jpg, .png, .pdf">-->
                                                                        <!--<select class="input-group-text text-start" name="doc_type">-->
                                                                        <!--    <option value="Udyog Aadhar">Udyog Aadhar</option>-->
                                                                        <!--    <option value="DL">DL</option>-->
                                                                        <!--    <option value="Police Verification">Police Verification</option>-->
                                                                        <!--    <option value="Other">Other</option>-->
                                                                        <!--</select>-->
                                <!--                                </div>-->
                                <!--                            </div>-->
            								            
            								    
            									<div class="col-12">
            										<button type="submit" name="driver_edit" class="btn btn-primary">Submit</button>
            										<a href="driver_list" class="btn btn-dark" >Back</a>
            									</div>
            								</form>
                         
                    </div>
                </div>
            </div>
        
        <div class="col-lg-4">
          <div class="row g-3 m-0 bg-white rounded-3 shadow-sm">
              <div class="col-12">
                   
                  <h5 class="card-title">Click Document to delete</h5>
              </div>
               
              <?php 
                if(isset($_GET['edit'])){
                
                $geti="select * from driver_documents where doc_did='{$_GET['edit']}'";
                $viewimgs=mysqli_query($connect,$geti);
                
                while($rowi=mysqli_fetch_array($viewimgs)){
                extract($rowi);
                ?>
            <div class="col-6">
              <a href="<?= $_SERVER['REQUEST_URI'] ?>&delete_image=<?= $doc_id ?>" onclick="return confirm('Are you sure you want to delete this image?');" class="d-block rounded-3 shadow-sm p-1">
                <img loading="lazy"class="img-fluid rounded-2 shadow-sm" src="//admin.mansicab.com/assets/uploads/driver/documents/<?= !empty($bussiness_doc) ? $bussiness_doc : 'no_img.jpg' ?>" style="aspect-ratio: 6/2;object-fit:cover">
              </a>
            </div>
            
            <?php }} ?>
            <div class="col-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="img-upload" class="form-label">
                        <h5 class="card-title">Add More Documents <span class="text-danger">*</span></h5>
                    </label>
                    <input type="file" name="bussiness_doc[]" class="form-control form-control-sm" placeholder="Add more images"  id="fileupload" required multiple accept=" .jpg , .jpeg , .png ">
                    <div id="dvPreview"></div>
                    <button type="submit" class="btn btn-primary mt-3 mb-2 float-end" name="add_extra_img">Upload</button>
                </form>
            </div>
          </div>
          
        </div>
	</div>
	<?php }else{ ?>			
		<div class="row">
			<div class="col-xl-11 mx-auto">
				
				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-5">
						<div class="card-title d-flex align-items-center">
							<div><i class="bx bxs-plus me-1 font-22 text-primary"></i>
							</div>
							<h5 class="mb-0 text-primary">Add Driver</h5>
						</div>
						<hr>
					
						<form class="row g-3" method="POST" enctype="multipart/form-data"> 
							<div class="col-12 col-md-6">
								<label for="dname" class="form-label">Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="dname" name="dname" required>
							</div>
							<div class="col-12 col-md-6">
								<label for="dcontact" class="form-label">contact<span class="text-danger">*</span></label>
								<input type="text" minlenght="10" maxlenght="10" pattern="[6789]{1}[0-9]{9}" class="form-control" id="dcontact" name="dcontact" required maxlength="10" minlength="10">
							</div>
							<div class="col-12 col-md-6"><label for="area" class="form-label">Gender<span class="text-danger">*</span></label>
									<div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" id="male" name="dgender" class="custom-control-input" value="male" checked>
                                      <label class="custom-control-label" for="male">Male</label>
                                    </div>
                                                                            <div class="custom-control custom-radio custom-control-inline">
                                      <input type="radio" id="Female" name="dgender" class="custom-control-input" value="female">
                                      <label class="custom-control-label" for="Female">Female</label>
                                    </div>
                                </div>
						
							<div class="col-12 col-md-6">
								<label for="demail" class="form-label">Email<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="demail" name="demail" required>
							</div>
							<!--<div class="col-12 col-md-6">-->
							<!--	<label for="dpassword" class="form-label">Password<span class="text-danger">*</span></label>-->
       <!--                    		<input type="password" class="form-control" name="dpassword" oninput="checkPassword(this)" required>-->

							<!--</div>-->
							<!--<div class="col-12 col-md-6">-->
							<!--	<label for="dpassword" class="form-label">Confirm Password<span class="text-danger">*</span></label>-->
       <!--                    		<input type="password" class="form-control" name="dpassword" oninput="checkPassword(this)" required>-->

							<!--</div>-->
							
							<div class="col-12 col-md-6">
								<label for="state" class="form-label">State<span class="text-danger">*</span></label>
								
								<select class="form-select" id="state" name="dstate" required>
                                <option>Select State</option>
                                  <?php

                                $query = mysqli_query($connect, "select * from states order by state_id DESC");

                                while ($row = mysqli_fetch_assoc($query)) {
                                    extract($row);
                                    

                                ?>
                                <option value="<?php echo $state_id; ?>"><?php echo $sname; ?> </option>

                                <?php } ?>
                                </select>
                                
							</div>
							
							<div class="col-12 col-md-6">
								<label for="city" class="form-label">City<span class="text-danger">*</span></label>
								
								<select  class="form-control" name="dcity" id="city">
	                                <option value="">Select City</option>
	                      
              			        </select>
								
							</div>
						    
						        	<div class="col-12 col-lg-6">
                                            <label for="dprofilephoto">Profile Photo<span class="text-danger">*</span></label>
                                            <div class="row g-3 align-items-center">
                                                <div class="col-12 col-lg-9">
                                                    <input id="image"  type="file" name="dprofilephoto" class="form-control"  accept=".jpg, .jpeg, .png">
                                                </div>
                                                <div class="col-12 col-lg-3 text-center text-md-end">
                                                    <img id="preview_img" style="object-fit: cover;" class="rounded-circle p-1 border border-primary" src="icons/logo/noimg.jpg" height="70" width="70" loading="lazy">
                                                </div>
                                            </div>
                                        </div>
						            
						            <!--<div class="col-12 col-lg-6">-->
						            <!--    	<label for="description" class="form-label">Upload Documents<span class="text-danger">*</span></label>-->
    								      <!--  <div class="input-group mb-3">-->
                  <!--                                  <input type="file" id="bussiness_doc" multiple name="bussiness_doc[]" class="form-control" accept=".jpg, .png, .pdf" required>-->
                                                    <!--<select class="input-group-text text-start" name="doc_type">-->
                                                    <!--    <option value="Udyog Aadhar">Udyog Aadhar</option>-->
                                                    <!--    <option value="DL">DL</option>-->
                                                    <!--    <option value="Police Verification">Police Verification</option>-->
                                                    <!--    <option value="Other">Other</option>-->
                                                    <!--</select>-->
                  <!--                          </div>-->
                  <!--                      </div>-->
                                    <div class="col-12 col-lg-6">
										<label for="description" class="form-label">Description</label>
										<div class="input-group" id="description">
											<textarea name="description" class="form-control"></textarea>
										</div>
									</div>
						    
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Aadhar Card<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="aadhar_card" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Pan Card<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="pan_card" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Driving Licence<span class="text-danger">*</span></label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="driving_licence" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="dprofilephoto">Police Verification</label>
                                        <div class="row g-3 align-items-center">
                                            <div class="col-12">
                                                <input type="file" name="police_verification" class="form-control">
                                            </div>
                                        </div>
                                    </div>
						            
							<div class="col-12">
								<button type="submit" name="driver_add" class="btn btn-primary">Submit</button>
								<a href="driver_list" class="btn btn-dark" >Back</a>
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
<script>
  $(document).ready(function(){
    $("#state").change(function(){
          var s = $("#state option:selected").val();
          //alert(s);
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
       
// function validatePassword(password) {
// 	if (!(/^(.{8,20}$)/.test(password))) {
// 	    return 'Password must be between 8 to 20 chars';
// 	}
// 	else if (!(/^(?=.*[A-Z])/.test(password))) {
// 	    return 'Password must contain at least one uppercase';
// 	}
// 	else if (!(/^(?=.*[a-z])/.test(password))) {
// 	    return 'Password must contain at least one lowercase';
// 	}
// 	else if (!(/^(?=.*[0-9])/.test(password))) {
// 	    return 'Password must contain at least one digit';
// 	}
// 	else if (!(/^(?=.*[\$_@!])/.test(password))) {
// 	    return "Password must contain symbol from $_@!";
// 	}
// 	return true;
// }
// function checkPassword(el) {
// 	let error_msg = $(el).next('.error-msg');
// 	if (!error_msg.length) {
// 		$(el).after('<div class="small error-msg mt-2"></div>');
// 		error_msg = $(el).next('.error-msg');
// 	}
// 	const validation = validatePassword(el.value);
// 	if (validation===true) {
// 		error_msg.removeClass('text-danger').addClass('text-success').text('Strong password');
// 		el.setCustomValidity('');
// 	} else {
// 		error_msg.removeClass('text-success').addClass('text-danger').text(validation);
// 		el.setCustomValidity(validation);
// 	}
// }
// function matchPassword(el) {
// 	let error_msg = $(el).next('.error-msg');
// 	if (!error_msg.length) {
// 		$(el).after('<div class="small error-msg mt-2"></div>');
// 		error_msg = $(el).next('.error-msg');
// 	}
// 	if ($('[name="password"]').val() === $('[name="cpassword"]').val()) {
// 		error_msg.removeClass('text-danger').addClass('text-success').text('Password matched');
// 		el.setCustomValidity('');
// 	} else {
// 		error_msg.removeClass('text-success').addClass('text-danger').text('Password and confirm password not matched');
// 		el.setCustomValidity('Password and confirm password not matched');
// 	}
// }
// function togglePasswordChange() {
// 	const form = $('#password-change-form');
// 	if (form.css('display')=='none') {
// 		form.slideDown();
// 	} else {
// 		form.slideUp();
// 	}
// }
</script>       