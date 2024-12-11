<?php
require_once "config.php";
/* Get Cities of State */
if(isset($_POST["city"]) || isset($_POST['state'])){
	escapePOST($_POST);
    $state = isset($_POST['state']) ? $_POST['state'] : $_POST['city'];
    $getState = mysqli_query($connect, "SELECT * FROM states s, districts d WHERE s.state_id=d.state_id AND s.sname='{$state}'");
    if (mysqli_num_rows($getState)>0){
        // echo "<option value=''>Choose...</option>";
        while($stRow=mysqli_fetch_assoc($getState)){
           echo "<option value='{$stRow['dname']}'>{$stRow['dname']}</option>";
        }
    }else{
        echo "<option value=''>जिल्हे सापडले नाहीत</option>";
    }
}

/* Get taluka */
if(isset($_POST["city"]) || isset($_POST['tal'])){
	escapePOST($_POST);
    $state = isset($_POST['tal']) ? $_POST['tal'] : $_POST['city'];
    $getdname = mysqli_query($connect, "SELECT * FROM districts d, taluka t WHERE d.districts_id=t.districts_id AND d.dname='{$state}'");
    if (mysqli_num_rows($getdname)>0){
       echo "<option selected>निवडा...</option>";
        while($stRow=mysqli_fetch_assoc($getdname)){
           echo "<option value='{$stRow['taluka']}'>{$stRow['taluka']}</option>";
        }
    }else{
        echo "<option value=''>तालुका सापडला नाहीत</option>";
    }
}

/* Get village */
if(isset($_POST["village"])){
  $rTal= $_POST['village'];
  
$resTal="SELECT * FROM taluka t,village v WHERE v.districts_id=t.districts_id AND t.tid=v.tid AND t.taluka='$rTal'";

$getTaluka=mysqli_query($connect,$resTal);
  if (mysqli_num_rows($getTaluka)>0){
      echo "<option selected>निवडा...</option>";
  while($row=mysqli_fetch_assoc($getTaluka)){ 
      
      echo "<option value='{$row['village']}'>{$row['village']}</option>";} 
  }else{
        echo "<option value=''>गाव सापडले नाहीत</option>";
    }
}

/* Get product qty */
if(isset($_POST["qty"])){
  $qty= $_POST['qty'];
  
$resqty="select product_qty from product where product_name='$qty'";

$getqty=mysqli_query($connect,$resqty);
   while($row=mysqli_fetch_assoc($getqty)){ echo $row['product_qty'];}  
} 

if(isset($_POST["pqty"])){
  $qty= $_POST['pqty'];
  
$resqty="select product_qty from product where product_id='$qty'";

$getqty=mysqli_query($connect,$resqty);
   while($row=mysqli_fetch_assoc($getqty)){ echo $row['product_qty'];}  
} 


if(isset($_POST["cat_product"])){
  $cat_id= $_POST['cat_product'];
  
$resqty="select product_id,product_name from product where cat_id='$cat_id'";

$getcatpro=mysqli_query($connect,$resqty);
  if (mysqli_num_rows($getcatpro)>0){
      echo "<option selected>निवडा...</option>";
  while($row=mysqli_fetch_assoc($getcatpro)){ 
      
      echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";} 
  }else{
        echo "<option value=''>प्रॉडक्ट सापडले नाहीत</option>";
    }
} 

// get product price
if(isset($_POST["get_product_qty_price"])){
    $data=['price'=>false,'qty'=>false,'varity'=>false];
    
    $pid= $_POST['get_product_qty_price'];
    $getpro="SELECT product_amount, product_qty, product_varity FROM product WHERE product_id='". $pid."' ";
    $getpid=mysqli_query($connect,$getpro);
    if(mysqli_num_rows($getpid)>0){
        $getprice=mysqli_fetch_assoc($getpid);
        $data=[
            'price'=>$getprice['product_amount'],
            'qty'=>$getprice['product_qty'],
            'varity'=>$getprice['product_varity']
        ];
    }
    echo json_encode($data);
 }

// // pending amt customer
// if(isset($_POST["balamt"])){
//   $balamt= $_POST['balamt'];
  
// $getsub="select SUM(balance) as totval from sales where customer_id='$balamt' and status='pending'";
// $sub=mysqli_query($connect,$getsub);
//   while($srow=mysqli_fetch_array($sub)){ echo $srow['totval'];}  
// } 
 
// pending amt customer
if(isset($_POST["balamt"])){
  $balamt= $_POST['balamt'];
  
$getsub="SELECT total FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sale_id ='$balamt'";
$sub=mysqli_query($connect,$getsub);
  while($srow=mysqli_fetch_array($sub)){ echo $srow['total'];}  
} 
  
//sal car register start

//salcar_workers_attendance total sal amount
if(isset($_POST["salrs"])){
  $_tsal= $_POST['salrs'];
  
$rsal="SELECT sallery FROM `salcar` WHERE sal_id=$_tsal";

$gsal=mysqli_query($connect,$rsal);
  while($rowsal=mysqli_fetch_assoc($gsal)){ echo $rowsal['sallery'];}  
}

//no of present days
if(isset($_POST["workers_days"])){
  $salcarworker= $_POST['workers_days'];
  
$getemp="SELECT COUNT(is_present) as days FROM `salcar_atten` WHERE sal_id=$salcarworker AND is_present='present'";
$emp=mysqli_query($connect,$getemp);
 $days=mysqli_fetch_assoc($emp);
 echo $days['days']; 
    $day=$days['days'];
}

//salcar total sal amount
if(isset($_POST["workerstotsal"])){
  $_tsal= $_POST['workerstotsal'];
  
$rsal="SELECT total_amt FROM `salcar_sallery` WHERE ma_id=$_tsal";

$gsal=mysqli_query($connect,$rsal);
  while($rowsal=mysqli_fetch_assoc($gsal)){ echo $rowsal['total_amt'];}  
}

//end sal car


// pending amt users all loan details for deposit
if(isset($_POST["pamt"])){
  $pamt_id= $_POST['pamt'];
  
$getsub="select pending_amt from all_loan_details where ald_id='$pamt_id'"
;

$sub=mysqli_query($connect,$getsub);
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['pending_amt'];}  
}


// bhajipala customers 
if(isset($_POST["mob"])){
$mob= $_POST['mob'];
$getCus="select customer_mobno from customer where customer_name='$mob'";
$rowCus=mysqli_query($connect,$getCus);
   while($resCus=mysqli_fetch_assoc($rowCus)){ echo $resCus['customer_mobno'];} 
}

// bhajipala customers 
if(isset($_POST["gav"])){
$gav= $_POST['gav'];
$getCus="select village from customer where customer_name='$gav'";
$rowCus=mysqli_query($connect,$getCus);
   while($resCus=mysqli_fetch_assoc($rowCus)){ echo $resCus['village'];}
}

// pending amt farmers for bhajipala
if(isset($_POST["balAmt"])){
  $balamt= $_POST['balAmt'];
$getsub="select balance from bhajipala_sales where sale_id='".$balamt."'";
$sub=mysqli_query($connect,$getsub);
   while($srow=mysqli_fetch_array($sub)){ echo $srow['balance'];}  
}

// pending amt farmers for bhajipala sale_id for deposit
if(isset($_POST["sid"])){
  $sales_id= $_POST['sid'];
$getsub="select sale_id from bhajipala_sales where sale_id='".$sales_id."'";
$sub=mysqli_query($connect,$getsub);
   while($srow=mysqli_fetch_array($sub)){ echo $srow['sale_id'];}  
}

// pending amt farmers for seeds
if(isset($_POST["balamtSeeds"])){
  $seedsBalAmt= $_POST['balamtSeeds'];
  
$getsub="select balance from seeds_sales where sale_id='".$seedsBalAmt."'"
;

$sub=mysqli_query($connect,$getsub);
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['balance'];}  
}
// pending amt farmers for seeds sale_id for deposit
if(isset($_POST["sales_id"])){
  $sales_id= $_POST['sales_id'];
  
$getsub="select sale_id from seeds_sales where sale_id='".$sales_id."'"
;

$sub=mysqli_query($connect,$getsub) or die(mysqli_error($connect));
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['sale_id'];}  
}


//male total sal amount
// if(isset($_POST["emp_Sal"])){
//   $_emp_id= $_POST['emp_Sal'];
// $totDays=mysqli_query($connect,"SELECT COUNT(at_emp_id) as emp_days FROM `attendance` WHERE at_status='P' AND at_emp_id='$_emp_id'");
//   $_totEmpDays=mysqli_fetch_assoc($totDays); 
//   echo $_totEmpDays['emp_days'];
// }  

// SELECT SUM(emp_salary) FROM `employees` AS e, `attendance` AS a WHERE e.emp_id='2' and e.emp_id=a.at_emp_id

if(isset($_POST["emp_Sal"])){
  $_EMPSAL= $_POST['emp_Sal'];
  
$rsal="SELECT SUM(emp_salary) as empSal FROM `employees` AS e, `attendance` AS a WHERE e.emp_id='$_EMPSAL' and e.emp_id=a.at_emp_id and e.emp_status='1'";

$gsal=mysqli_query($connect,$rsal);
  while($rowsal=mysqli_fetch_assoc($gsal)){ echo $rowsal['empSal'];}  
}


//zendu_booking
if(isset($_POST["rqty"])){
  $cat_id= $_POST['rqty'];
  
$getcat="select cat_qty from marigold_category where cat_name='".$cat_id."'";

$getmcat=mysqli_query($connect,$getcat) or die(mysqli_error($connect));
   while($row=mysqli_fetch_array($getmcat)){ echo $row['cat_qty'];}  
}

// red subcat
if(isset($_POST["subcat"])){
  $cat_id= $_POST['subcat'];
$getsub="select subcat_name from marigold_subcategory where subcat_name='".$cat_id."' AND pt_id='1'";
$sub=mysqli_query($connect,$getsub) or die(mysqli_error($connect));
  while($srow=mysqli_fetch_array($sub)){ echo $srow['subcat_name'];}  
}

//yellow category qunatity
 
if(isset($_POST["yellowqty"])){
  $yeqty= $_POST['yellowqty'];
  
$getyqty="select cat_qty from marigold_category where cat_name='".$yeqty."' AND pt_id=2 ";

$yqty=mysqli_query($connect,$getyqty) or die(mysqli_error($connect));
     
   while($yrow=mysqli_fetch_array($yqty)){ echo $yrow['cat_qty'];}  
}

if(isset($_POST["subcat"])){
  $cat_id= $_POST['subcat'];
  
$getsub="select subcat_name from marigold_subcategory where subcat_name='".$cat_id."' AND pt_id='2'";

$sub=mysqli_query($connect,$getsub) or die(mysqli_error($connect));
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['subcat_name'];}  
}

 // red sub count
if(isset($_POST["subcatqty"])){
  $srqty= $_POST['subcatqty'];
$srq="select subcat_qty from marigold_subcategory where subcat_name='".$srqty."'";
$subrqty=mysqli_query($connect,$srq) or die(mysqli_error($connect));
  while($srowqty=mysqli_fetch_array($subrqty)){ echo $srowqty['subcat_qty'];}  
}


// pending amt user zendu booking for deposit
if(isset($_POST["pendingamt"])){
  $pamt_id= $_POST['pendingamt'];
  
$getsub="select pending_amt from zendu_booking where zendu_id='".$pamt_id."'"
;

$sub=mysqli_query($connect,$getsub) or die(mysqli_error($connect));
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['pending_amt'];}  
}

// zendu id
if(isset($_POST["zenduid"])){
  $zendu_id= $_POST['zenduid'];
  
$getsub="select zendu_id from zendu_booking where zendu_id='".$zendu_id."'";

$sub=mysqli_query($connect,$getsub) or die(mysqli_error($connect));
     
   while($srow=mysqli_fetch_array($sub)){ echo $srow['zendu_id'];}  
}

//id
if(isset($_POST["_cqty"])){
  $ccatid= $_POST['_cqty'];
  
$getcat="select cat_qty from marigold_category where cat_id='".$ccatid."'";

$getmcat=mysqli_query($connect,$getcat) or die(mysqli_error($connect));
   while($row=mysqli_fetch_array($getmcat)){ echo $row['cat_qty'];}  
}