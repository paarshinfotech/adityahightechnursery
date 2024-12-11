<?php
require_once "config.php";
Aditya::subtitle('विक्री');
$nav_tabs = array(
	'sales' => false,
	'products' => false,
	'purchase' => false,
	'supplier' => false,
	'sale_history' => false,
	'cus_details' => false,
// 	'quotation' => false,
// 	'quotation_sales' => false,
);
if (isset($_GET['show_sales'])) {
	$nav_tabs['sales'] = true;
} elseif (isset($_GET['show_products'])) {
	$nav_tabs['products'] = true;
} elseif (isset($_GET['show_purchase'])) {
	$nav_tabs['purchase'] = true;
} elseif (isset($_GET['show_supplier'])) {
	$nav_tabs['supplier'] = true;
} elseif (isset($_GET['show_history'])) {
	$nav_tabs['sale_history'] = true;
// } elseif (isset($_GET['show_quotation'])) {
// 	$nav_tabs['quotation'] = true;
// } elseif (isset($_GET['show_quotation_sales'])) {
// 	$nav_tabs['quotation_sales'] = true;
} else {
	$nav_tabs['sales'] = true;
}

// product category
if (isset($_POST['pro_cat_add'])){
    escapeExtract($_POST);
    
    if (!empty($cat_name)) {
        $sql="SELECT * FROM category_product WHERE cat_name='$cat_name'";
    } else {
        $sql="SELECT * FROM category_product WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: sales?show_products=true&action=Success&action_msg='.$cat_name.' प्रॉडक्ट श्रेणी आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO category_product(cat_name) VALUES ('$cat_name')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: sales?show_products=true&action=Success&action_msg='.$cat_name.' नवीन प्रॉडक्ट श्रेणी जोडली.!');
		exit();
        }else{
        header('Location: sales?show_products=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}
// add products
if(isset($_POST['product_add'])){
  escapeExtract($_POST);
  if (!empty($product_name)) {
        $sql="SELECT * FROM product WHERE product_name='$product_name'";
    } else {
        $sql="SELECT * FROM product WHERE product_name='$product_name'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: sales?show_products=true&action=Success&action_msg='.$product_name.' प्रॉडक आधिपासुन आहे..!');
		    exit();
         }else{
  $proadd="INSERT INTO product(`product_name`,`product_qty`,`product_amount`, `product_info`,cat_id,product_varity) VALUES ('$product_name','$product_qty','$product_amount','$product_info','$cat_id','$product_varity')"; 
  $result=mysqli_query($connect,$proadd);
  if($result) {
	 header('Location: sales?show_products=true&action=Success&action_msg='.$product_name.' नावाचे प्रॉडक्ट जोडले..!');
		exit();
        }else{
        header('Location: sales?show_products=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
}
//update product
if(isset($_POST['product_edit'])){
	escapeExtract($_POST);

	$update = mysqli_query($connect,"update product set
		product_name = '$product_name',
		product_qty = '$product_qty',
		product_amount = '$product_amount',
		product_info = '$product_info',
		cat_id='$cat_id',
		product_varity='$product_varity'
		where product_id = '".$_GET['pid']."'");
	
	if($update) {
		header('Location: sales?show_products=true&action=Success&action_msg= प्रॉडक्ट अपडेट केले...!');
		exit();
	}else{
		header('Location: sales?show_products=true&action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}

//soft delete product
if (isset($_GET['delete']) && isset($_GET['product_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['product_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE product SET product_status='0' WHERE product_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?show_products=true&action=Success&action_msg=प्रॉडक्ट  हटवले..!");
		exit();
        }else{
        header('Location: sales?show_products=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}


//supplier add
if (isset($_POST['supplier_add'])){
	extract($_POST);
	$sql="SELECT * FROM supplier WHERE supplier_mobno='$smobile' OR supplier_email='$semail'";
	$sql_res = mysqli_query($connect,$sql);
	   if (mysqli_num_rows($sql_res) != 0)
		 {
			header('Location: sales?show_supplier=true&action=Success&action_msg='.$sname.' सप्लायर आधिपासुन आहे..!');
		    exit();
		 }
	  else
		  {
			  
	 $insert= "INSERT INTO supplier(`supplier_name`, `supplier_mobno`,  `supplier_email`,`supplier_info`,`supplier_address`,`store_name`) VALUES ('".mysqli_real_escape_string($connect,$sname)."','".mysqli_real_escape_string($connect,$smobile)."',
		'".mysqli_real_escape_string($connect,$semail)."','".mysqli_real_escape_string($connect,$spl_info)."','".mysqli_real_escape_string($connect,$spl_add)."','".mysqli_real_escape_string($connect,$store_name)."')";

	$add=mysqli_query($connect,$insert);
	if($add){
		header('Location: sales?show_supplier=true&action=Success&action_msg='.$sname. 'नवीन सप्लायर जोडले..!');
		exit();
        }else{
        header('Location: sales?show_supplier=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
}
//edit supplier
 if(isset($_POST['supplier_edit'])){
		extract($_POST);
		
		$update = mysqli_query($connect,"update supplier set
			supplier_name = '".mysqli_real_escape_string($connect,$sname)."',
			supplier_email = '".mysqli_real_escape_string($connect,$semail)."',
			supplier_mobno = '".mysqli_real_escape_string($connect,$smobile)."',
			supplier_info = '".mysqli_real_escape_string($connect,$spl_info)."',
			supplier_address = '".mysqli_real_escape_string($connect,$spl_add)."',
			store_name = '".mysqli_real_escape_string($connect,$store_name)."'      where supplier_id = '".$_GET['supid']."'");
		
		if($update){
			header('Location: sales?show_supplier=true&action=Success&action_msg='.$sname. 'सप्लायर अपडेट झाले..!');
		exit();
        }else{
        header('Location: sales?show_supplier=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}
//soft delete supplier
if (isset($_GET['delete']) && isset($_GET['supplier_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['supplier_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE supplier SET sup_status='0' WHERE supplier_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?show_supplier=true&action=Success&action_msg=सप्लायर हटवले..!");
		exit();
        }else{
        header('Location: sales?show_supplier=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

// add purchase
if (isset($_POST['purchase_add'])){
	escapeExtract($_POST);

	 $insert= "INSERT INTO purchase(`purchase_name`,`pold_qty`,`purchase_qty`,`purchase_price`,`purchase_created`,`purchase_expected`,`supplier_name`) VALUES ('$purchase_name','$pold_qty','$pqty','$pprice','$pcreated','$pexpected','$supplier_name')";
	$add=mysqli_query($connect,$insert);
    $pnQTY = $pold_qty + $pqty;
	$update = mysqli_query($connect,"update product set
		product_qty = '$pnQTY'
		where product_name = '$purchase_name'");
	if($add){
	 header('Location: sales?show_purchase=true&action=Success&action_msg=नवीन  जोडले..!');
		exit();
	}else{
		header('Location: sales?show_purchase=true&action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
}

//edit purchase
if(isset($_POST['purchase_edit'])){
		extract($_POST);
		
		$update = mysqli_query($connect,"update purchase set
			purchase_name = '".mysqli_real_escape_string($connect,$purchase_name)."',
			purchase_qty = '".mysqli_real_escape_string($connect,$pqty)."',
			purchase_price = '".mysqli_real_escape_string($connect,$pprice)."',
			purchase_created = '".mysqli_real_escape_string($connect,$pcreated)."',
			purchase_expected = '".mysqli_real_escape_string($connect,$pexpected)."',
			supplier_name = '".mysqli_real_escape_string($connect,$supplier_name)."'      where purchase_id = '".$_GET['pur_id']."'");
			
		$pnQTY = $pold_qty + $pqty;
     	$update = mysqli_query($connect,"update product set
		product_qty = '$pnQTY'
		where product_name = '$purchase_name'");
		
		if($update){
			 header('Location: sales?show_purchase=true&action=Success&action_msg= अपडेट केले...!');
		exit();
	}else{
		header('Location: sales?show_purchase=true&action=error&action_msg=काहीतरी चूक झाली..!');
		exit();
	}
	}

//soft delete purchase
if (isset($_GET['delete']) && isset($_GET['purchase_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['purchase_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE purchase SET purchase_status='0' WHERE purchase_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?show_purchase=true&action=Success&action_msg=खरेदी हटवले..!");
		exit();
        }else{
        header('Location: sales?show_purchase=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//स्टॉक जोडा
if(isset($_POST['add_stock'])){
	escapeExtract($_POST);
	$pnQTY = $poqty + $pnqty;
	$update = mysqli_query($connect,"update product set
		product_id='$pid',
		product_qty = '$pnQTY'
		where product_id = '$pid'");
	
	if($update){
		header('Location: sales?show_products=true');
		exit();
	}
		else{
		header('Location: sales?action=Success&action_msg=somthing went wrong');
		exit();
	}
}
if(isset($_POST['qbill'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$payment = $_POST['payment'];
	$total= $_POST['total'];
	$car_rental_amt= $_POST['car_rental_amt'];
	$driver_name= $_POST['driver_name'];
	$advdate= $_POST['advdate'];
	$amt= $_POST['amt'];
	$sub_total = $_POST['sub_total'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	$status = ($balance > 0) ? 'pending' : 'completed';
	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
	if (mysqli_query($connect, "UPDATE sales SET customer_id = '{$cid}',sdate = '{$sdate}',total = '{$total}',car_rental_amt = '{$car_rental_amt}',driver_name = '{$driver_name}',advdate='{$advdate}',amt='{$amt}',  advance = '{$advance}',balance = '{$balance}',pay_mode = '{$payment}', paystatus = '{$paystatus}' , status = '{$status}' WHERE sale_id = '{$_GET['sale_id']}'")) {
		$sales_id = mysqli_insert_id($connect);
		$_salesAdded = true;
		foreach ($pid as $key => $_pid) {
		    
			$saleDetail = mysqli_query($connect, "UPDATE sales_details SET pid = '{$pid[$key]}', pqty = '{$quantity[$$key]}', pprice = '{$pprice[$key]}', sub_total = '{$sub_total[$key]}',cat_id = '{$cat_id[$key]}', varity = '{$varity[$key]}' WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$key]}'");
			if (!$saleDetail) {
				$_salesAdded = false;
			} else {
				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
			}
		}
		if($_salesAdded) {
			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
			// exit();
			header("Location: sales?show_history=true&action=Success&action_msg= विक्री केले..!");
    		exit();
            }else{
            header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
          	exit();
            }
	}
}
//add sales
if(isset($_POST['quotation'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$payment = $_POST['payment'];
	$total= $_POST['total'];
	$car_rental_amt= $_POST['car_rental_amt'];
	$driver_name= $_POST['driver_name'];
	$advdate= $_POST['advdate'];
	$amt= $_POST['amt'];
	$sub_total = $_POST['sub_total'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	$status = ($balance > 0) ? 'pending' : 'completed';
	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
	if (mysqli_query($connect, "INSERT INTO `sales`(customer_id, sdate, total,car_rental_amt,driver_name,advdate,amt,advance, balance, pay_mode, paystatus, status) VALUES('$cid', '$sdate', '$total','$car_rental_amt','$driver_name','$advdate','$amt','$advance', '$balance', '$payment', '$paystatus', '$status')")) {
		$sales_id = mysqli_insert_id($connect);
		$_salesAdded = true;
		foreach ($pid as $key => $_pid) {
		    
			$saleDetail = mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES('{$sales_id}','{$_pid}','{$quantity[$key]}','{$pprice[$key]}','{$sub_total[$key]}','{$cat_id[$key]}','{$varity[$key]}')");
			if (!$saleDetail) {
				$_salesAdded = false;
			} 
// 			else {
// 				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
// 			}
		}
		if($_salesAdded) {
			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
			// exit();
			header("Location: sales?show_history=true&action=Success&action_msg= कोटेशन दिले..!");
    		exit();
            }else{
            header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
          	exit();
            }
	}
}
elseif(isset($_POST['sales'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$payment = $_POST['payment'];
	$total= $_POST['total'];
	$car_rental_amt= $_POST['car_rental_amt'];
	$driver_name= $_POST['driver_name'];
	$advdate= $_POST['advdate'];
	$amt= $_POST['amt'];
	$sub_total = $_POST['sub_total'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	$status = ($balance > 0) ? 'pending' : 'completed';
	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
	if (mysqli_query($connect, "INSERT INTO `sales`(customer_id, sdate, total,car_rental_amt,driver_name,advdate,amt,advance, balance, pay_mode, paystatus, status) VALUES('$cid', '$sdate', '$total','$car_rental_amt','$driver_name','$advdate','$amt','$advance', '$balance', '$payment', '$paystatus', '$status')")) {
		$sales_id = mysqli_insert_id($connect);
		$_salesAdded = true;
		foreach ($pid as $key => $_pid) {
		    
			$saleDetail = mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES('{$sales_id}','{$_pid}','{$quantity[$key]}','{$pprice[$key]}','{$sub_total[$key]}','{$cat_id[$key]}','{$varity[$key]}')");
			if (!$saleDetail) {
				$_salesAdded = false;
			} else {
				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
			}
		}
		if($_salesAdded) {
			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
			// exit();
			header("Location: sales?show_history=true&action=Success&action_msg=नवीन विक्री जोडले..!");
    		exit();
            }else{
            header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
          	exit();
            }
	}
}
//edit sales
else if(isset($_POST['sales_edit'])){
	escapePOST($_POST);
	$cid = $_POST['customer_id'];
	$sdate = $_POST['sdate'];
	
	$sid = $_POST['sid'];
	$pid = $_POST['pid'];
	$quantity = $_POST['pqty'];
	$pprice = $_POST['pprice'];
	$sub_total = $_POST['sub_total'];
	$cat_id = $_POST['cat_id'];
	$varity = $_POST['varity'];
	
	$total = $_POST['total'];
	$car_rental_amt = $_POST['car_rental_amt'];
	$driver_name = $_POST['driver_name'];
	$advdate = $_POST['advdate'];
	$amt = $_POST['amt'];
	$advance = $_POST['advance'];
	$balance = $_POST['balance'];
	$payment = $_POST['payment'];
	$paystatus = ($balance>0) ? 'unpaid' : 'paid' ;
	$status = ($paystatus!='unpaid') ? 'completed' : 'pending';
	if (mysqli_query($connect, "UPDATE sales SET customer_id = '{$cid}',sdate = '{$sdate}',total = '{$total}',car_rental_amt = '{$car_rental_amt}',driver_name = '{$driver_name}',advdate='{$advdate}',amt='{$amt}',  advance = '{$advance}',balance = '{$balance}',pay_mode = '{$payment}', paystatus = '{$paystatus}' , status = '{$status}' WHERE sale_id = '{$_GET['sale_id']}'")) {
	    $sid_in = '('.implode(', ', $sid).')';
	    $getDeleteSale = mysqli_query($connect, "SELECT pid, pqty FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
	    if (mysqli_num_rows($getDeleteSale) > 0) {
	        while($delRow = mysqli_fetch_assoc($getDeleteSale)) {
	            mysqli_query($connect, "UPDATE product SET product_qty = (product_qty + {$delRow['pqty']}) WHERE product_id = '{$delRow['pid']}'");
	        }
	    }
	    mysqli_query($connect, "DELETE FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
	    $insert = true;
	    foreach ($sid as $_i => $_sid) {
	        if ($_sid=='new') {
	            // add if new
	            if (!mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES ('{$_GET['sale_id']}', '{$pid[$_i]}', '{$quantity[$_i]}', '{$pprice[$_i]}', '{$sub_total[$_i]}','{$cat_id[$_i]}','{$varity[$_i]}')")) {
	                $insert = false;
	            } else {
	                mysqli_query($connect, "UPDATE product SET product_qty = (product_qty - {$quantity[$_i]}) WHERE product_id = '{$pid[$_i]}'");
	            }
	        } else {
	            // update
	            $get_old_product = mysqli_query($connect, "SELECT pqty FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'");
	            $old_pqty = 0;
	            if (mysqli_num_rows($get_old_product)>0) {
	                $old_pqty = (int) mysqli_fetch_assoc($get_old_product)['pqty'];
	            }
	            if(!mysqli_query($connect, "UPDATE sales_details SET pid = '{$pid[$_i]}', pqty = '{$quantity[$_i]}', pprice = '{$pprice[$_i]}', sub_total = '{$sub_total[$_i]}',cat_id = '{$cat_id[$_i]}', varity = '{$varity[$_i]}' WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'")) {
	                $insert = false;
	            } else {
	                if ($quantity[$_i] > $old_pqty) {
	                    // substract
	                    $_qty = $quantity[$_i] - $old_pqty;
	                    mysqli_query($connect, "UPDATE product SET product_qty = (product_qty - {$_qty}) WHERE product_id = '{$pid[$_i]}'");
	                } elseif ($quantity[$_i] < $old_pqty) {
	                    // addition
	                    $_qty = $old_pqty - $quantity[$_i];
	                    mysqli_query($connect, "UPDATE product SET product_qty = (product_qty + {$_qty}) WHERE product_id = '{$pid[$_i]}'");
	                }
	            }
	        }
	    }
	    if ($insert) {
	        header("Location: sales?show_history=true&action=Success&action_msg=विक्री अपडेट केले..!");
    		exit();
	    } else {
	        header("Location: sales?sale_id='{$_GET['sale_id']}'");
	        exit();
	    }
	} else {
	    header("Location: sales?sale_id='{$_GET['sale_id']}'");
	    exit();
	}
}


//soft delete sales
if (isset($_GET['delete']) && isset($_GET['sale_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE sales SET sales_status='0' WHERE sale_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?show_history=true&action=Success&action_msg=विक्री हटवले..!");
		exit();
        }else{
        header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}

//adv_sales
if(isset($_POST['adv_sales'])){
    escapePOST($_POST);
    $advance=$_POST['bal_amt'];
	$again_adv_amt = $_POST['again_adv_amt'];
	$balance = $_POST['totbal'];
	$paystatus = ($balance>0) ? 'unpaid' : 'paid' ;
	$status = ($paystatus!='unpaid') ? 'completed' : 'pending';
	
    $advSaleRes=mysqli_query($connect,"UPDATE sales SET
    again_adv_amt='{$advance}',
    advance='{$again_adv_amt}',
    balance='{$balance}',
    paystatus = '{$paystatus}',
    status = '{$status}' WHERE customer_id='{$_POST['cus_id']}'");
    
    if ($advSaleRes) {
	       // header("Location: sales?show_history=true");
	       // exit();
	        header('Location: outstanding_report?action=Success&action_msg=ग्राहकाची ₹ '.$again_adv_amt.' /- जमा झाले..!');
		    exit();
	    } else {
	        header("Location: sales?sale_id='{$_GET['sale_id']}'");
	        exit();
	}
}

/*------ Add Customer details ------*/
if (isset($_POST['customer_add'])){
    escapeExtract($_POST);
    
    if (!empty($customer_email)) {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    } else {
        $sql="SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    }
    $sql_res = mysqli_query($connect,$sql);
       if (mysqli_num_rows($sql_res) != 0){
             header('Location: sales?show_sales=true&action=Success&action_msg='.$customer_name.' ग्राहक आधिपासुन आहे..!');
		    exit();
         }else{
     $insert= "INSERT INTO customer(customer_name, customer_mobno, customer_gender, customer_email,state, city, taluka, village) VALUES ('$customer_name','$customer_mobno','$customer_gender','$customer_email','$state','$city','$taluka','$village')";
     $add=mysqli_query($connect,$insert);

        if($add){
        header('Location: sales?action=Success&action_msg='.$customer_name.' नवीन ग्राहक जोडले..!');
		exit();
        }else{
        header('Location: sales?show_sales=true&action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
    }
}

//customer soft delete
if (isset($_GET['delete']) && isset($_GET['customer_id'])){
    escapePOST($_GET);
   
    //del profile and driver 
    foreach ($_GET['customer_id'] as $dir){
    //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
    // }
     $delete = mysqli_query($connect, "UPDATE customer SET customer_status='0' WHERE customer_id='{$dir}'");
    }
        if($delete){
    	header("Location: sales?action=Success&action_msg=ग्राहक हटवले..!");
		exit();
        }else{
        header('Location: sales?action=Success&action_msg=काहीतरी चूक झाली');
      	exit();
        }
}


//quotation_add
// if(isset($_POST['quotation'])){
// 	escapePOST($_POST);
// 	$cid = $_POST['customer_id'];
// 	$sdate = $_POST['sdate'];
// 	$pid = $_POST['pid'];
// 	$quantity = $_POST['pqty'];
// 	$pprice = $_POST['pprice'];
// 	$payment = $_POST['payment'];
// 	$total= $_POST['total'];
// 	$car_rental_amt= $_POST['car_rental_amt'];
// 	$driver_name= $_POST['driver_name'];
// 	$advdate= $_POST['advdate'];
// 	$amt= $_POST['amt'];
// 	$sub_total = $_POST['sub_total'];
// 	$advance = $_POST['advance'];
// 	$balance = $_POST['balance'];
// 	$cat_id = $_POST['cat_id'];
// 	$varity = $_POST['varity'];
// 	$status = ($balance > 0) ? 'pending' : 'completed';
// 	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	
// 	if (mysqli_query($connect, "INSERT INTO `sales`(customer_id, sdate, total,car_rental_amt,driver_name,advdate,amt,advance, balance, pay_mode, paystatus, status) VALUES('$cid', '$sdate', '$total','$car_rental_amt','$driver_name','$advdate','$amt','$advance', '$balance', '$payment', '$paystatus', '$status')")) {
// 		$sales_id = mysqli_insert_id($connect);
// 		$_salesAdded = true;
// 		foreach ($pid as $key => $_pid) {
		    
// 			$saleDetail = mysqli_query($connect, "INSERT INTO sales_details(sale_id, pid, pqty, pprice, sub_total,cat_id,varity) VALUES('{$sales_id}','{$_pid}','{$quantity[$key]}','{$pprice[$key]}','{$sub_total[$key]}','{$cat_id[$key]}','{$varity[$key]}')");
// 			if (!$saleDetail) {
// 				$_salesAdded = false;
// 			} 
// // 			else {
// // 				mysqli_query($connect, "UPDATE product SET product_qty = product_qty - {$quantity[$key]} WHERE product_id = '{$_pid}'");
// // 			}
// 		}
// 		if($_salesAdded) {
// 			// header("Location: invoice?cid={$cid}&sid={$sales_id}");
// 			// exit();
// 			header("Location: sales?show_history=true&action=Success&action_msg=कोटेशन दिले..!");
//     		exit();
//             }else{
//             header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
//           	exit();
//             }
// 	}
// }

?>
<?php require_once "header.php"; ?>
<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row mt-5">
			<div class="col-12">
				<div class="card card-body">
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['sales'] ? 'active' : '' ?>" id="pills-sales-tab" data-bs-toggle="pill" data-bs-target="#pills-sales" type="button" role="tab">विक्री</button>
						</li>
						<!--<li class="nav-item" role="presentation">-->
						<!--	<button class="nav-link dark <?//= $nav_tabs['quotation'] ? 'active' : '' ?>" id="pills-quotation-tab" data-bs-toggle="pill" data-bs-target="#pills-quotation" type="button" role="tab" aria-controls="pills-quotation" aria-selected="false">कोटेशन इतिहास</button>-->
						<!--</li>-->
						<!--<li class="nav-item" role="presentation">-->
						<!--	<button class="nav-link dark <?//= $nav_tabs['quotation_sales'] ? 'active' : '' ?>" id="pills-quotation_sales-tab" data-bs-toggle="pill" data-bs-target="#pills-quotation_sales" type="button" role="tab" aria-controls="pills-quotation_sales" aria-selected="false">कोटेशन</button>-->
						<!--</li>-->
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['sale_history'] ? 'active' : '' ?>" id="pills-salesh-tab" data-bs-toggle="pill" data-bs-target="#pills-salesh" type="button" role="tab" aria-controls="pills-salesh" aria-selected="false">विक्री इतिहास</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['products'] ? 'active' : '' ?>" id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product" aria-selected="false">उत्पादने</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['purchase'] ? 'active' : '' ?>" id="pills-purchase-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase" type="button" role="tab" aria-controls="pills-purchase" aria-selected="false">खरेदी ऑर्डर</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['supplier'] ? 'active' : '' ?>" id="pills-supplier-tab" data-bs-toggle="pill" data-bs-target="#pills-supplier" type="button" role="tab" aria-controls="pills-supplier" aria-selected="false">पुरवठादार</button>
						</li>
						
						<li class="nav-item" role="presentation">
							<button class="nav-link dark <?= $nav_tabs['cus_details'] ? 'active' : '' ?>" id="pills-cusdet-tab" data-bs-toggle="pill" data-bs-target="#pills-cusdet" type="button" role="tab" aria-controls="pills-cusdet" aria-selected="false">ग्राहक तपशील</button>
						</li>
						<li class="nav-item" role="presentation">
							<!--<button class="nav-link dark <?//= $nav_tabs['cus_details'] ? 'active' : '' ?>" id="pills-cusdet-tab" data-bs-toggle="pill" data-bs-target="#pills-cusdet" type="button" role="tab" aria-controls="pills-cusdet" aria-selected="false">Customer Details</button>-->
							<button class="btn text-success" data-bs-toggle="modal" data-bs-target="#addStockModal">स्टॉक जोडा</button>
						</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<!--sales start-->
						<div class="tab-pane fade <?= $nav_tabs['sales'] ? 'show active' : '' ?>" id="pills-sales" role="tabpanel" aria-labelledby="pills-sales-tab">
							<?php
							if(isset($_GET['sale_id'])){
						      $rsa = false;
							  $gets=mysqli_query($connect,"SELECT * FROM sales WHERE sale_id='{$_GET['sale_id']}'");
							  if (mysqli_num_rows($gets) > 0) {
							      $rsa = mysqli_fetch_assoc($gets);
							      $getSaleDetail = mysqli_query($connect, "SELECT * FROM sales_details WHERE sale_id = '{$rsa['sale_id']}'");
							      $rsa['sale_details'] = array();
							      if (mysqli_num_rows($getSaleDetail) > 0) {
							          while($sdRow = mysqli_fetch_assoc($getSaleDetail)) {
							              $rsa['sale_details'][] = $sdRow;
							          }
							      }
							  }
							?>
							<?php if ($rsa): ?>
							<form method="post">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td align="center">
													<h4>विक्री अद्यतनित करा</h4>
												</td>
											</tr>
											<tr>
												<td>
													<div class="row justify-content-between">
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">ग्राहक</lable>
															<select name="customer_id" id="customer_id" class="form-select mb-3" required>
																<option value="">ग्राहक निवडा</option>
																<?php $getcustomert = mysqli_query($connect,"SELECT * from customer where customer_status=1 order by customer_id desc") ?>
																<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
																<?php while ($getcus=mysqli_fetch_assoc($getcustomert)): ?>
																<option value="<?= $getcus['customer_id'] ?>" <?= ($rsa['customer_id']==$getcus['customer_id']) ? 'selected' : '' ?>>
																	<?= $getcus['customer_id'] ?> | <?= $getcus['customer_name'] ?>(<?= $getcus['customer_mobno'] ?>)
																</option>
																<?php endwhile ?>
																<?php endif ?>
															</select>
														</div>
														<div class="col-12 col-md-4 mt-4">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#customer" data-bs-whatever="@mdo">+</button>
														</div><br>
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="sdate" id="order_date" class="form-control mb-3" value="<?= date('Y-m-d', strtotime($rsa['sdate']))?>">
														</div>
													</div>
													<table id="invoice-item-table" class="table table-bordered mb-0">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th width="15%" class="text-start">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
																<th>प्रमाण</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
																<!--<th>कृती</th>-->
															</tr>
														</thead>
														<tbody class="align-middle">
														    <?php if ($rsa['sale_details'] && count($rsa['sale_details'])>0): ?>
														    <?php foreach ($rsa['sale_details'] as $k => $sdtls): ?>
														    <tr align="center">
																<td><?= $k + 1 ?></td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>" <?= ($sdtls['cat_id'] == $row1['cat_id']) ? 'selected' : '' ?>>
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="<?= $sdtls['sid'] ?>">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['product_id'] ?>" <?= ($sdtls['pid'] == $row1['product_id']) ? 'selected' : '' ?>>
																			<?= $row1['product_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="text" name="varity[]" class="form-control text-center varity" value="<?= $sdtls['varity'] ?>" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" value="<?= $sdtls['pqty'] ?>" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" value="<?= $sdtls['pprice'] ?>" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" value="<?= $sdtls['sub_total'] ?>" readonly class="form-control text-center final_amount">
																</td>
																<!--<td>-->
																<!--	<button type="button" class="btn btn-sm btn-outline-<?//= $k==0 ? 'success add_row' : 'danger remove_row' ?> fw-bold text-center"><?//= $k==0 ? '+' : 'x' ?></button>-->
																<!--</td>-->
															</tr>
														    <?php endforeach ?>
														    <?php else: ?>
														    <tr align="center">
																<td>1</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="new">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php //$query = mysqli_query($connect,"select * from product") ?>
																		<?php //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
																		<!--<option value="<?//= $row1['product_id'] ?>">-->
																			<?//= $row1['product_name'] ?>
																		</option>
																		<?php //endwhile ?>
																		<?php //endif ?>
																	</select>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																<!--<td>-->
																<!--	<button type="button" class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>-->
																<!--</td>-->
															</tr>
														    <?php endif ?>
															<tr class="total-footer">
																<td colspan="5" rowspan="7"></td>
															    <th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center final_total_amt" id="final_total_amt" name="total" value="<?= $rsa['total'] ?>" readonly>
																</td>
																
															</tr>
														    <tr>
																<th>
																	गाडी भाडे

																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="car_rental" placeholder="कार भाड्याची रक्कम" name="car_rental_amt" value="<?= $rsa['car_rental_amt'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																	<input class="form-control text-center my-3" id="car_name" name="driver_name" placeholder="ड्राइवर नाव" value="<?= $rsa['driver_name'] ?>">
																</td>
																<td rowspan="7"></td>
															</tr>
															<tr>
															    <th>
																	एकूण
																</th>
																<td align="center">
																    <?php //$gt = $rsa['amt'] + $rsa['car_rental_amt'] ?>
																	<input type="text" class="form-control text-center amt"  readonly value="<?= $rsa['amt']?>">
																</td>
																
															</tr>
															<tr>
																<th>
																	तारीख
																</th>
																<td align="center">
																	<input type="date" class="form-control text-center mb-2" id="advdate" name="advdate" value="<?= $rsa['advdate']?>">
																	<input class="form-control text-center subadvance" name="amt" oninput="allowType(event, 'number'),calcTotal()" value="<?= $rsa['amt']?>">
																</td>
															</tr>
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" value="<?= $rsa['advance'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																</td>
															</tr>
															<tr>
																<th>
																	शिल्लक
																</th>
																<td align="center">
																	<input class="form-control text-center" id="bal" name="balance" value="<?= $rsa['balance'] ?>" readonly>
																</td>
															</tr>
															<tr>
																<th>पेमेंट निवडा</th>
																<td colspan="1">
																	<select name="payment" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option <?= ($rsa['pay_mode']=='cash') ? 'selected' : '' ?> value="cash">रोख</option>
																		<option <?= ($rsa['pay_mode']=='sbi') ? 'selected' : '' ?> value="sbi">आदित्य नर्सरी SBI</option>
																		<option <?= ($rsa['pay_mode']=='mgb') ? 'selected' : '' ?> value="mgb">आदित्य नर्सरी MGB</option>
																		<option <?= ($rsa['pay_mode']=='ds_bank') ? 'selected' : '' ?> value="ds_bank">डीएस बँक</option>
																		<option <?= ($rsa['pay_mode']=='other_bank') ? 'selected' : '' ?> value="other_bank">इतर बँक</option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th class="text-center">
													<!--<input type="submit" name="sales_edit" id="create_invoice" class="btn btn-success" value="जतन करा">-->
													<input type="submit" name="qbill" id="create_invoice" class="btn btn-success" value="बिल करा">
                                            <a href="sales?show_history=true" class="btn btn-dark ">मागे</a>
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							<?php else: ?>
							<h5 class="text-muted text-center">सेल्स इन्व्हॉईस मिळाले नाही</h5>
							<?php endif ?>
							<?php } else {?>
							<form method="post">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td align="center">
													<h4>नवीन विक्री तयार करा</h4>
												</td>
											</tr>
											<tr>
												<td>
													<div class="row justify-content-between">
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">ग्राहक</lable>
															<select name="customer_id" id="customer_id" class="form-select mb-3" required>
																<option value="">ग्राहक निवडा</option>
																<?php $getcustomert = mysqli_query($connect,"SELECT * from customer where customer_status=1 order by customer_id desc") ?>
																<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
																<?php while ($getcus=mysqli_fetch_assoc($getcustomert)): ?>
																<option value="<?= $getcus['customer_id'] ?>">
																	<?= $getcus['customer_id'] ?> | <?= $getcus['customer_name'] ?> (<?= $getcus['customer_mobno'] ?>)
																</option>
																<?php endwhile ?>
																<?php endif ?>
															</select>
														</div>
														<div class="col-12 col-md-4 mt-4">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#customer" data-bs-whatever="@mdo">+</button>
														</div><br>
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="sdate" id="order_date" class="form-control mb-3" value="<?= date('Y-m-d')?>">
														</div>
													</div>
													<table id="invoice-item-table" class="table table-bordered mb-0">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th width="15%" class="text-nowrap">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
																<th>प्रमाण</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
																<th>कृती</th>
															</tr>
														</thead>
														<tbody class="align-middle">
															<tr align="center">
																<td>1</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php //$query = mysqli_query($connect,"select * from product")  //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
																		<!--<option value="<?//= $row1['product_id'] ?>">-->
																			<?//= $row1['product_name'] ?>
																		</option>
																		<?php //endwhile ?>
																		<?php //endif ?>
																	</select>
																</td>
																<td>
																    <input type="text" name="varity[]" class="form-control text-center varity" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																<td>
																	<button type="button" class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>
																</td>
															</tr>
															<tr class="total-footer">
															    <td colspan="5" rowspan="7"></td>
																<th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center tot_amt" id="final_total_amt" name="total" readonly>
																</td>
															</tr>
															<tr>
																<th>
																गाडी भाडे 
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="car_rental" placeholder="कार भाड्याची रक्कम" name="car_rental_amt" oninput="allowType(event, 'number'),calcTotal()">
																	<input class="form-control text-center my-3" id="car_name" name="driver_name" placeholder="ड्राइवर नाव">
																</td>	
																</td>
																<td rowspan="6"></td>
															</tr>
															
															<tr>
																<th>
																 एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center amt" readonly>
																</td>
															</tr>
															<tr>
															    <th>
																	तारीख
																</th>
																<td align="center">
																	<input type="date" class="form-control text-center mb-2" id="advdate" name="advdate" value="<?= date('Y-m-d')?>">
																	<input class="form-control text-center subadvance" name="amt" oninput="allowType(event, 'number'),calcTotal()">
																</td>
															</tr>
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" oninput="allowType(event, 'number'),calcTotal()">
																</td>
															</tr>
															
															<tr>
																<th>
																	शिल्लक
																</th>
																<td align="center">
																	<input class="form-control text-center" id="bal" name="balance" readonly>
																</td>
															</tr>
															<tr>
																<th>Select Payment</th>
																<td colspan="1">
																	<select name="payment" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option value="cash">रोख</option>
																		<option value="sbi">आदित्य नर्सरी SBI</option>
																		<option value="mgb">आदित्य नर्सरी MGB</option>
																		<option value="ds_bank">डीएस बँक</option>
																		<option value="other_bank">इतर बँक</option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th class="text-center">
												    <input type="submit" name="quotation" class="btn btn-dark" value="कोटेशन द्या">
													<input type="submit" name="sales" id="create_invoice" class="btn btn-success" value="बिल करा">
													
												</th>
											
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							<?php } ?>
						</div>
						<!--sales end-->
						<!--product start-->
						<div class="tab-pane fade <?= $nav_tabs['products'] ? 'show active' : '' ?>" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
								<div class="row">
									<div class="col-sm-12 col-xs-12">
										<?php
										//fetch products
										if (isset($_GET['pid'])){
										$query_data=mysqli_query($connect, "select * from product where product_id='" .$_GET['pid'] ."'");
										$product_get= mysqli_fetch_assoc($query_data);
										?>
										<form method="post" enctype="multipart/form-data">
											<div class="row">
											    <div class="col-12 col-md-5">
                                    <div class="form-group">
                                        <label for="cat_id" class="form-label">प्रॉडक्ट श्रेणी <span class="text-danger">*</span></label>
                                            <select name="cat_id" id="cat_id" class="form-select m-0 px-3 py-0">
												<option selected>निवडा...</option>
							<?php $getStates = mysqli_query($connect,"select * from category_product"); ?>
							<?php if (mysqli_num_rows($getStates)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
							<option value="<?= $stRow['cat_id']?>" <?php if($stRow['cat_id']==$product_get['cat_id']) {echo "selected";}?>>
								<?= $stRow['cat_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
									</div>
                                </div>
                                <div class="col-12 col-md-1">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#pcat_id" data-bs-whatever="@mdo" style="margin-top:30px">+</button>
														</div>
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
													    
														<label for="pname" class="form-label">प्रॉडक्ट नाव<span class="text-danger">*</span></label>
														<input type="text" name="product_name" class="form-control" id="pname" placeholder="Enter प्रॉडक्ट नाव" required value="<?php echo $product_get['product_name']; ?>">
													</div>
												</div>
												
													<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="price" class="form-label mt-1">प्रॉडक्ट विविधता</label><span class="text-danger">*</span>
														<input id="price" type="text" name="product_varity" class="form-control" required value="<?php echo $product_get['product_varity']; ?>">
													</div>
												</div>
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="qty" class="form-label">प्रॉडक्ट प्रमाण<span class="text-danger">*</span></label>
														<input oninput="allowType(event, 'number')" type="text" class="form-control" name="product_qty" id="qty" placeholder="Enter Quantity" required value="<?php echo $product_get['product_qty']; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="price" class="form-label mt-1">प्रॉडक किंमत</label><span class="text-danger">*</span>
														<input id="price" type="text" placeholder="Enter Price" name="product_amount" oninput="allowType(event, 'decimal', 2)"  class="form-control" required value="<?php echo $product_get['product_amount']; ?>">
													</div>
												</div>
												<div class="col-6">
													<label for="des" class="form-label">प्रॉडक वर्णन</label>
													<textarea id="des" class="form-control" name="product_info"><?php echo $product_get['product_info']; ?></textarea>
												</div>
											</div>
											<button type="submit" name="product_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>

                                        <a href="sales?show_products=true" class="btn btn-dark mt-3">मागे</a>										</form>
										<?php }else{ ?>
										<form method="post" enctype="multipart/form-data">
											<div class="row">
											    <div class="col-12 col-md-5">
                                    <div class="form-group">
                                        <label for="cat_id" class="form-label">प्रॉडक्ट श्रेणी <span class="text-danger">*</span></label>
                                            <select name="cat_id" id="cat_id" class="form-select">
												<option selected>निवडा...</option>
							<?php $getStates = mysqli_query($connect,"select * from category_product"); ?>
							<?php if (mysqli_num_rows($getStates)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getStates)): ?>
							<option value="<?= $stRow['cat_id']?>">
								<?= $stRow['cat_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
									</div>
                                </div>
                                <div class="col-12 col-md-1">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#pcat_id" data-bs-whatever="@mdo" style="margin-top:30px">+</button>
														</div>
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="pname" class="form-label">प्रॉडक्ट नाव<span class="text-danger">*</span></label>
														<input type="text" name="product_name" class="form-control" id="pname" required>
													</div>
												</div>
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="price" class="form-label mt-1">प्रॉडक्ट विविधता</label><span class="text-danger">*</span>
														<input id="price" type="text" name="product_varity" class="form-control" required>
													</div>
												</div>
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="qty" class="form-label">प्रॉडक्ट प्रमाण<span class="text-danger">*</span></label>
														<input oninput="allowType(event, 'number')" type="text" class="form-control number_only" name="product_qty" id="qty" required>
													</div>
												</div>
												
												<div class="col-12 col-md-6 mt-2">
													<div class="form-group">
														<label for="price" class="form-label mt-1">प्रॉडक किंमत</label><span class="text-danger">*</span>
														<input id="price" type="text" oninput="allowType(event, 'decimal', 2)" name="product_amount" class="form-control" required>
													</div>
												</div>
												
												<div class="col-12 col-lg-6">
													<label for="des" class="form-label">प्रॉडक वर्णन</label>
													<textarea id="des" class="form-control" name="product_info"></textarea>
												</div>
											</div>
										
											<button type="submit" name="product_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="sales?show_products=true" class="btn btn-dark mt-3">मागे</a>
										</form>
										<?php } ?>
									</div>
								</div>
								
								<div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container-pro">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				                <div class="table-responsive">
                					<table border="1" id="protbl" class="table table-striped table-bordered table-hover multicheck-container">
                						<thead>
                							<tr>
                								<th>
                									<?php //if ($auth_permissions->brand->can_delete): ?>
                								    <div class="d-inline-flex align-items-center select-all">
                								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
                			                            <div class="dropdown">
                			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
                			                            		<i class='bx bx-slider-alt fs-6'></i>
                			                            	</button>
                			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
                			                            		<li>
                			                            			<a title="प्रॉडक हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('प्रॉडक हटवा..?');">
                			                            				<i class="btn-round bx bx-trash me-2"></i>प्रॉडक हटवा
                			                            			</a>
                			                            		</li>
                			                            	</ul>
                			                            </div>
                								    </div>
                									<?php //endif ?>
                								</th>
                    								<th> श्रेणी</th>
                                                   
                									<th>नाव</th>
                									<th>एकूण प्रमाण</th>
                									<!--<th>Available Quantity</th>-->
                									<th>किंमत</th>
                									<th>तारीख</th>
                									<th>वर्णन</th>
                						   </tr>
                						</thead>
            						<tbody>
                                        <?php $getPro = mysqli_query($connect, "SELECT * FROM product LEFT JOIN category_product
                                            ON product.cat_id = category_product.cat_id WHERE product_status='1' ORDER BY product_id DESC");
                                        ?>
                                        <?php if (mysqli_num_rows($getPro)>0): ?>
                                            <?php while ($product = mysqli_fetch_assoc($getPro)): 
                                            extract($product);
                                            ?>
                                            <tr>
                                            <td class="form-group">
                                                <input type="checkbox" class="multi-check-item" name="product_id[]" value="<?= $product_id ?>">
                                                <span class="badge bg-gradient-bloody text-white shadow-sm">
                                                    <?= $product_id ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?= $cat_name?>
                                            </td>
                                            	<td>
            														 <a class="text-decoration-none" href="sales?show_products=true&pid=<?= $product_id;?>"><?= $product_name?>
            													</td>
            													<td>
            														<?= $product_qty?>
            													</td>
            													<?php
            													// $getqty=mysqli_query($connect,"SELECT pqty,pid FROM sales_details WHERE pid=$product_id");
            												//     $getqty=mysqli_query($connect,"SELECT SUM(pqty) as totaqty FROM sales_details where pid=$product_id");
            												// $rowqty=mysqli_fetch_assoc($getqty);
            												// $pqty=$rowqty['totaqty'];
            												// $totalqty= $product_qty - $pqty;
            													?>
            													<!--<td><?//php echo $totalqty; ?></td>-->
            													<td>
            														<?= $product_amount?>
            													</td>
            													<td>
            														<?= date('d M Y',strtotime($created_date))?>
            													</td>
            													<td>
            														<?= $product_info?>
            													</td>
                                        </tr>
                                            <?php endwhile ?>
                                        <?php endif ?>
            						</tbody>
					            </table>
				            </div>
						</div>
						<!--product end-->
						<!--Purchase start-->
						<div class="tab-pane fade <?= $nav_tabs['purchase'] ? 'show active' : '' ?>" id="pills-purchase" role="tabpanel" aria-labelledby="pills-purchase-tab">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<?php
									if (isset($_GET['pur_id'])){
		$query1=mysqli_query($connect, "select * from purchase where purchase_id='" .$_GET['pur_id'] ."'");

		$row= mysqli_fetch_assoc($query1);
	
									?>
									<form method="post">
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="cusname" class="form-label">प्रॉडक्ट नाव<span class="text-danger">*</span></label>
													<!--<input type="text" name="pname" class="form-control" id="cusname" value="<?php //echo $row['purchase_name']; ?>" placeholder="Enter प्रॉडक्ट नाव" required>-->
													<select name="purchase_name" id="pur_id" class="form-select">
												<option selected>निवडा...</option>
							<?php $getProducts = mysqli_query($connect,"select * from product"); ?>
							<?php if (mysqli_num_rows($getProducts)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getProducts)): ?>
							<option value="<?= $stRow['product_name']?>" <?php if($stRow['product_name']==$row['purchase_name']){echo "selected";}?>>
								<?= $stRow['product_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="" class="form-label">प्रमाण<span class="text-danger">*</span></label>
													<input type="number" class="form-control" name="pqty" id="" oninput="allowType(event, 'number')" value="<?php echo $row['purchase_qty']; ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">किंमत</label><span class="text-danger">*</span>
													<input id="" type="text" name="pprice" class="form-control" value="<?php echo $row['purchase_price']; ?>" required oninput="allowType(event, 'decimal', 2)">
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">तयार केले</label><span class="text-danger">*</span>
													<input id="" type="date" placeholder="Enter created date" name="pcreated" class="form-control" value="<?php echo $row['purchase_created']; ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">अपेक्षित</label><span class="text-danger">*</span>
													<input id="" type="date" placeholder="Enter expected date" name="pexpected" class="form-control" value="<?php echo $row['purchase_expected']; ?>" required>
												</div>
											</div>
											<input id="pur_qty" type="hidden" name="pold_qty" class="form-control" placeholder="Total Quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly="" value="<?= $row['pold_qty']?>">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">सप्लायर नाव</label><span class="text-danger">*</span>
													<select name="supplier_name" id="cat_id" class="form-select">
												<option selected>निवडा...</option>
							<?php $getsup = mysqli_query($connect,"select * from supplier"); ?>
							<?php if (mysqli_num_rows($getsup)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getsup)): ?>
							<option value="<?= $stRow['supplier_name']?>" <?php if($stRow['supplier_name']==$row['supplier_name']){echo "selected";}?>>
								<?= $stRow['supplier_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
												</div>
											</div>
										</div>
										<button type="submit" name="purchase_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
										<a href="sales?show_purchase=true" class="btn btn-dark mt-3">मागे</a>
									</form>
									<?php } else {?>
									<form method="post">
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="cusname" class="form-label">प्रॉडक्ट नाव<span class="text-danger">*</span></label>
												<select name="purchase_name" id="pur_id" class="form-select">
												<option selected>निवडा...</option>
							<?php $getProducts = mysqli_query($connect,"select * from product"); ?>
							<?php if (mysqli_num_rows($getProducts)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getProducts)): ?>
							<option value="<?= $stRow['product_name']?>">
								<?= $stRow['product_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="Email" class="form-label">प्रमाण<span class="text-danger">*</span></label>
													<input type="number" class="form-control" name="pqty" id="pqty" required oninput="allowType(event, 'number')">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">किंमत</label><span class="text-danger">*</span>
													<input id="customer mobile" type="text" name="pprice" oninput="allowType(event, 'decimal', 2)" class="form-control" required>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<label for="Address" class="form-label">तयार केले</label><span class="text-danger">*</span>
												<input id="" type="date" placeholder="Enter date" name="pcreated" class="form-control" required>
											</div>
											
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<label for="" class="form-label">अपेक्षित</label><span class="text-danger">*</span>
												<input id="" type="date" placeholder="Enter date" name="pexpected" class="form-control" required>
											</div>
											<input id="pur_qty" type="hidden" name="pold_qty" class="form-control" placeholder="Total Quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly="">
											<div class="col-12 col-md-6 mt-2">
												<label for="" class="form-label">सप्लायर नाव</label><span class="text-danger">*</span>
												<select name="supplier_name" id="cat_id" class="form-select">
												<option selected>निवडा...</option>
							<?php $getsup = mysqli_query($connect,"select * from supplier"); ?>
							<?php if (mysqli_num_rows($getsup)>0): ?>
							<?php while($stRow = mysqli_fetch_assoc($getsup)): ?>
							<option value="<?= $stRow['supplier_name']?>">
								<?= $stRow['supplier_name']?>
							</option>
							<?php endwhile ?>
							<?php endif ?>
									</select>
											</div>
										</div>
										<button type="submit" name="purchase_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
										<a href="sales?show_purchase=true" class="btn btn-dark mt-3">मागे</a>
									</form>
									<?php } ?>
								</div>
							</div>
							<!--purchase list-->
			    				<div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container-pur">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
			             	    <div class="table-responsive">
					<table border="1" id="purchasetbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			                            		<li>
			                            			<a title="खरेदी हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('प्रॉडक हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>खरेदी हटवा
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
									<th>उत्पादनाचे नांव</th>
									<th>एकूण प्रमाण</th>
									<!--<th>Available Quantity</th>-->
									<th>किंमत</th>
									<th>तयार केलेली तारीख</th>
									<th>अपेक्षित</th>
									<th>पुरवठादाराचे नाव</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getPurchase = mysqli_query($connect, "SELECT * FROM purchase WHERE purchase_status='1' ORDER BY purchase_id DESC");
                            ?>
                            <?php if (mysqli_num_rows($getPurchase)>0): ?>
                                <?php while ($purchase = mysqli_fetch_assoc($getPurchase)): 
                                extract($purchase);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="purchase_id[]" value="<?= $purchase_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $purchase_id ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="sales?show_purchase=true&pur_id=<?= $purchase_id;?>"><?= $purchase_name?></a>
                                </td>
                                	<td>
										<?= $purchase_qty?>
									</td>
													<td>
														<?= $purchase_price?>
													</td>
												
													<td>
														<?= date('d M Y',strtotime($purchase_created))?>
													</td>
													<td>
														<?= date('d M Y',strtotime($purchase_expected))?>
													</td>
														<td>
														<?= $supplier_name?>
													</td>
												
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
					</table>
				</div>
						    </div>
						<!--</div>-->
						<!--Purchase end-->
						<!--Supplier start-->
						<div class="tab-pane fade <?= $nav_tabs['supplier'] ? 'show active' : '' ?>" id="pills-supplier" role="tabpanel" aria-labelledby="pills-supplier-tab">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<?php
									if (isset($_GET['supid'])){
		$query1=mysqli_query($connect, "select * from supplier where supplier_id='" .$_GET['supid'] ."'");

		$row= mysqli_fetch_array($query1);
	
									?>
									<form method="post">
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="cusname" class="form-label">सप्लायर नाव<span class="text-danger">*</span></label>
													<input type="text" name="sname" class="form-control" id="cusname" value="<?php echo $row['supplier_name']; ?>" required>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="Email" class="form-label">ईमेल</label>
													<input type="email" class="form-control" name="semail" id="Email" value="<?php echo $row['supplier_email']; ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">मोबईल नंबर</label><span class="text-danger">*</span>
													<input oninput="allowType(event, 'mobile')" id="customer mobile" type="tel" minlength="10" maxlength="10"  name="smobile" class="form-control" value="<?php echo $row['supplier_mobno']; ?>" required>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="store_name" class="form-label">सप्लायर दुकान नाव </label>
													<input type="text" class="form-control" name="store_name" id="store_name" value="<?php echo $row['store_name']; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<label for="Address" class="form-label">सप्लायर डेस्क्रिपशन</label>
												<textarea id="Address" class="form-control" placeholder="" name="spl_info"><?php echo $row['supplier_info']; ?></textarea>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<label for="Address" class="form-label">सप्लायर ऍड्रेस</label>
												<textarea id="Address" class="form-control" placeholder="" name="spl_add"><?php echo $row['supplier_address']; ?></textarea>
											</div>
										</div>
										<button type="submit" name="supplier_edit" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
										 <a href="sales?show_supplier=true" class="btn btn-dark mt-3">मागे</a>
									</form>
									<?php } else {?>
									<form method="post">
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="cusname" class="form-label">सप्लायर नाव<span class="text-danger">*</span></label>
													<input type="text" name="sname" class="form-control" id="cusname" required>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="Email" class="form-label">ईमेल</label>
													<input type="email" class="form-control" name="semail" id="Email">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="customer mobile" class="form-label">मोबईल नंबर</label><span class="text-danger">*</span>
													<input oninput="allowType(event, 'mobile')" id="customer mobile" type="tel" minlength="10" maxlength="10" name="smobile" class="form-control" required>
												</div>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<div class="form-group">
													<label for="store_name" class="form-label">सप्लायर दुकान नाव <span class="text-danger">*</span></label>
													<input type="text" name="store_name" class="form-control" id="store_name">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6 mt-2">
												<label for="Address" class="form-label">सप्लायर  डेस्क्रिपशन</label>
												<textarea class="form-control" placeholder="" name="spl_info"></textarea>
											</div>
											<div class="col-12 col-md-6 mt-2">
												<label for="Address" class="form-label">सप्लायर ऍड्रेस</label>
												<textarea id="Address" class="form-control" placeholder="" name="spl_add"></textarea>
											</div>
										</div>
										<button type="submit" name="supplier_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
										 <a href="sales?show_supplier=true" class="btn btn-dark mt-3">मागे</a>
									</form>
									<?php } ?>
								</div>
							</div>
							<div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex export-container-sup">
                                    <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                                    <!--    Filters <i class="bx bx-filter"></i>-->
                                    <!--</button>-->
                                    <!-- Filter Modal -->
                                    <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="vendor-filters-form" class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Filter by city</label>
                                                            <select class="form-select" id="vendor-filter-city">
                                                                <option value="">All</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Filter by pin</label>
                                                            <select class="form-select" id="vendor-filter-pin">
                                                                <option value="">All</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Filter by category</label>
                                                            <select class="form-select" id="vendor-filter-cat">
                                                                <option value="">All</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Filter by subscription</label>
                                                            <select class="form-select" id="vendor-filter-sub">
                                                                <option value="">All</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Filter by status</label>
                                                            <select class="form-select" id="vendor-filter-status">
                                                                <option value="">All</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                                    <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
				            <div class="table-responsive">
					               <table border="1" id="suppliertbl" class="table table-striped table-bordered table-hover multicheck-container">
						                    <thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			                            		<li>
			                            			<a title="सप्लायर हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('सप्लायर हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>सप्लायर हटवा
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>नाव</th>
    								<th>मोबईल नंबर</th>
    								<th>ईमेल</th>
    								<th>दुकानाचे नाव</th>
    								<th>तारीख</th>
    								<th>ऍड्रेस</th>
    								<th>डेस्क्रिपशन</th>
						   </tr>
						</thead>
						                    <tbody>
                                                <?php $getSup = mysqli_query($connect, "SELECT * FROM supplier WHERE sup_status='1' ORDER BY supplier_id DESC");
                                                ?>
                                                <?php if (mysqli_num_rows($getSup)>0): ?>
                                                    <?php while ($ressupplier = mysqli_fetch_assoc($getSup)): 
                                                    extract($ressupplier);
                                                    ?>
                                            <tr>
                                            <td class="form-group">
                                                <input type="checkbox" class="multi-check-item" name="supplier_id[]" value="<?= $supplier_id ?>">
                                                <span class="badge bg-gradient-bloody text-white shadow-sm">
                                                    <?= $supplier_id ?>
                                                </span>
                                            </td>
                                	    <td>
										        <a class="text-decoration-none" href="sales?show_supplier=true&supid=<?= $supplier_id;?>"><?= $supplier_name?>
										</td>
													<td>
														<?= $supplier_mobno?>
													</td>
													
													<td>
														<?= $supplier_email?>
													</td>
												    <td><?= $store_name?></td>
												    <td>
														<?= date('d M Y',strtotime($create_date))?>
													</td>
													<td>
														<?= $supplier_address?>
													</td>
													<td>
														<?= $supplier_info?>
													</td>
														
                                                 </tr>
                                            <?php endwhile ?>
                                        <?php endif ?>
            						</tbody>
            					</table>
            				</div>
						</div>
						<!--supplier end-->
						<!--sales history start-->
						<div class="tab-pane fade <?= $nav_tabs['sale_history'] ? 'show active' : '' ?>" id="pills-salesh" role="tabpanel" aria-labelledby="pills-salesh-tab">
							<div class="row">
								<div class="col-12">
									<div class="d-flex mb-3 justify-content-end">
									    <button class="btn ms-sm-2 btn-success" data-bs-toggle="modal" data-bs-target="#advsalesModal">ऍडव्हान्स</button>
									    <div class="modal fade" id="advsalesModal" tabindex="-1" aria-labelledby="advsalesLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="advsalesModalLabel">ऍडव्हान्स</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body text-center">
													<div class="row">
														<div class="col-12">
															<form method="post">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<select class="form-select item_name text-start" name="cus_id" id="cus_id" required>
																				<option value="">ग्राहक निवडा</option>
																				<?php $query = mysqli_query($connect,"select * from customer c,sales s WHERE c.customer_id=s.customer_id GROUP BY s.customer_id") ?>
																				<?php if ($query && mysqli_num_rows($query)): ?>
																				<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																				<option value="<?= $row1['customer_id'] ?>">
																					<?= $row1['customer_id'] ?> | <?= $row1['customer_name'] ?>, (<?= $row1['customer_mobno'] ?>)
																				</option>
																				<?php endwhile ?>
																				<?php endif ?>
																			</select>
																		</div>
																		<div class="col-12 my-3">
																			<div class="form-group">
																				<input id="bal_amt" type="text" name="bal_amt" class="form-control" placeholder="प्रलंबित रक्कम" readonly oninput="allowType(event, 'number')">
																			</div>
																		</div>
																		<div class="col-12">
																			<div class="form-group">
																				<input id="adv_amt" type="text" name="again_adv_amt" placeholder="रक्कम" class="form-control"  oninput="allowType(event, 'number')" required>
																			</div>
																			<div class="form-group mt-3">
																				<input id="totbal" type="text" name="totbal" class="form-control" placeholder="शिल्लक रक्कम" oninput="allowType(event, 'number')" required readonly>
																			</div>
																		</div>
																	</div>
																</div>
																<button type="submit" name="adv_sales" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							        </div>
								
									<div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container-salesh">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				                    <div class="table-responsive">
					<table border="1" id="salestbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			                            		<li>
			                            			<a title="Delete" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('विक्री हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>विक्री हटवा
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<!--<th>आयडी</th>-->
                                    <th>ग्राहकाचे नाव</th
                                    >
									<th>तारीख</th>
									<th>गाडी भाडे</th>
									<th>ड्राइवर नाव</th>
									<th>एकूण</th>
									<th>ऍडव्हान्स</th>
									<th>शिल्लक</th>
									<th>पेमेंट मोड</th>
									<th>कृती</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and s.sales_status='1' order by s.sale_id DESC") ?>
                            <?php if (mysqli_num_rows($getsalesDetails)>0): ?>
                                <?php 
                                $salesDetails = array();
                                while ($salesFetch = mysqli_fetch_assoc($getsalesDetails)): 
                                array_push($salesDetails, $salesFetch);
                                extract($salesFetch);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <!--<td>-->
                                <!--    <span class="badge bg-gradient-bloody text-white shadow-sm">-->
                                <!--        <?//= $sale_id ?>-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td>
                                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#info<?php echo $salesFetch['sale_id'];?>">
                                        <?= $customer_name; ?>
                                    </a>
                                </td>
                                
                                <td>
																<?= date('d M Y',strtotime($sdate))?>
															</td>
															<td>
																<?= $car_rental_amt?>
															</td>
															<td>
																<?= $driver_name?>
															</td>
															<td>
															    <?php if($car_rental_amt==''){?>
															    <?= $total?>
															    <?php }else {?>
																<?= $car_rental_amt + $total?>
																<?php } ?>
															</td>
															<td>
																<?= $advance?>
															</td>
															<td>
																<?= $balance?>
															</td>
															<td>
																<?= $pay_mode?>
															</td>
                                
                                <td>
									<!--<a href="sales?sale_id=<?//= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Edit Sale" data-original-title="Edit Sale"><i class="fa fa-edit text-info"></i></a>-->
									<a href="sales?sale_id=<?= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="बिल करा" data-original-title="बिल करा"><i class="fa fa-edit text-info"></i></a>
									
									<a href="invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Invoice" data-original-title="Invoice"><i class="fa fa-print text-dark"></i></a>
									<a href="sales_advance_invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Advance Invoice" data-original-title="Advance Invoice"><i class="fa fa-print text-cyan"></i></a>
									<!--<a href="sales_delete?sid=<?php //echo $sale_id?>" class="text-inverse" title="Delete" data-bs-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash text-danger"></i></a>-->
									</td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
					</table>
				</div>		
			
								</div>
                                <!--priview modal-->
                                <?php 
                                error_reporting(0);
                                foreach ($salesDetails as $salesFetch):?>
                                <?php extract($salesFetch);?>
<div class="modal fade" id="info<?php echo $sale_id;?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoLabel<?php echo $sale_id;?>">चलन तपशील</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $customer_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल नंबर</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $customer_mobno?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span> <?php $date=date('d M Y',strtotime($sdate))?>
                                            <?= $date?></span>
						        					</td>
						        				</tr>
						        				<?php
						        				$getCusDebAmt=mysqli_query ($connect, "SELECT SUM(total+car_rental_amt) as debAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowDebAmt=mysqli_fetch_assoc($getCusDebAmt);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>डेबिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowDebAmt['debAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				<?php
						        				$getcusCre=mysqli_query ($connect, "SELECT SUM(balance+car_rental_amt) as credAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowcre=mysqli_fetch_assoc($getcusCre);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>क्रेडिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowcre['credAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				
						        				
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">पावती</h6>
						        					</td>
						        				</tr>
						        			</tbody>
						        		</table>
						        		<table class="table table-bordered text-center fs-6">
                                            <thead>
                                                <tr>
                                                    <th>अ.क्र.</th>
                                                    <th>मालाचे विवरण</th>
                                                    <th>रोपांची संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getcuspro = "SELECT * FROM sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN sales d ON s.sale_id=d.sale_id WHERE s.sale_id='$sale_id'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $product_id?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $pqty?></td>
                                                <td><?= $pprice?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">एकूण</th>
                                                  <td class="text-center">₹ <?= $total?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">कारचे भाडे रु</th>
                                                  <td class="text-center">₹ <?= $car_rental_amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">ड्राइवर नाव</th>
                                                  <td class="text-center"><?= $driver_name?></td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">तारीख आणि एकूण</th>
                                                  <td class="text-center">तारीख: <?= date('d M Y',strtotime($advdate))?>, ₹ <?= $amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                      <th colspan="4">ऍडव्हान्स</th>
                                                      <td class="text-center">
                                                          ₹ <?= $advance?>/-
                                                      </td>
                                            </tr>
                                            <tr align="right">      
                                                      <th colspan="4">शिल्लक</th>
                                                      <td class="text-center">
                                                        ₹ <?= $balance?>/-
                                                          
                                                       </td>
                                            </tr>   
                                            </tbody>
                                            
                                    </table>

						        	</div>
                                </div>
                                <!--<div class="modal-footer">-->
                                <!--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>-->
                                <!--    <button type="button" class="btn btn-success" onclick="window.print()">छापणे</button>-->
                                <!--  </div>-->
                                </div>
                              </div>
                            </div>							
                         <?php endforeach?>
                        </div>
					</div>
						<!--sales history end-->
						
						<!--quotation history start-->
						<div class="tab-pane fade <?= $nav_tabs['quotation'] ? 'show active' : '' ?>" id="pills-quotation" role="tabpanel" aria-labelledby="pills-quotation-tab">
							<div class="row">
								<div class="col-12">
									<div class="d-flex mb-3 justify-content-end">
									    <button class="btn ms-sm-2 btn-success" data-bs-toggle="modal" data-bs-target="#advsalesModal">ऍडव्हान्स</button>
									    <div class="modal fade" id="advsalesModal" tabindex="-1" aria-labelledby="advsalesLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="advsalesModalLabel">ऍडव्हान्स</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body text-center">
													<div class="row">
														<div class="col-12">
															<form method="post">
																<div class="row">
																	<div class="col-12">
																		<div class="form-group">
																			<select class="form-select item_name text-start" name="cus_id" id="cus_id" required>
																				<option value="">ग्राहक निवडा</option>
																				<?php $query = mysqli_query($connect,"select * from customer c,sales s WHERE c.customer_id=s.customer_id GROUP BY s.customer_id") ?>
																				<?php if ($query && mysqli_num_rows($query)): ?>
																				<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																				<option value="<?= $row1['customer_id'] ?>">
																					<?= $row1['customer_id'] ?> | <?= $row1['customer_name'] ?>, (<?= $row1['customer_mobno'] ?>)
																				</option>
																				<?php endwhile ?>
																				<?php endif ?>
																			</select>
																		</div>
																		<div class="col-12 my-3">
																			<div class="form-group">
																				<input id="bal_amt" type="text" name="bal_amt" class="form-control" placeholder="प्रलंबित रक्कम" readonly oninput="allowType(event, 'number')">
																			</div>
																		</div>
																		<div class="col-12">
																			<div class="form-group">
																				<input id="adv_amt" type="text" name="again_adv_amt" placeholder="रक्कम" class="form-control"  oninput="allowType(event, 'number')" required>
																			</div>
																			<div class="form-group mt-3">
																				<input id="totbal" type="text" name="totbal" class="form-control" placeholder="शिल्लक रक्कम" oninput="allowType(event, 'number')" required readonly>
																			</div>
																		</div>
																	</div>
																</div>
																<button type="submit" name="adv_sales" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							        </div>
								
									<div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container-quot">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				                    <div class="table-responsive">
					<table border="1" id="quottbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			                            		<li>
			                            			<a title="Delete" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('विक्री हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>विक्री हटवा
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<!--<th>आयडी</th>-->
                                    <th>ग्राहकाचे नाव</th
                                    >
									<th>तारीख</th>
									<th>गाडी भाडे</th>
									<th>ड्राइवर नाव</th>
									<th>एकूण</th>
									<th>ऍडव्हान्स</th>
									<th>शिल्लक</th>
									<th>पेमेंट मोड</th>
									<th>कृती</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and s.sales_status='1' order by s.sale_id DESC") ?>
                            <?php if (mysqli_num_rows($getsalesDetails)>0): ?>
                                <?php 
                                $salesDetails = array();
                                while ($salesFetch = mysqli_fetch_assoc($getsalesDetails)): 
                                array_push($salesDetails, $salesFetch);
                                extract($salesFetch);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <!--<td>-->
                                <!--    <span class="badge bg-gradient-bloody text-white shadow-sm">-->
                                <!--        <?//= $sale_id ?>-->
                                <!--    </span>-->
                                <!--</td>-->
                                <td>
                                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#info<?php echo $salesFetch['sale_id'];?>">
                                        <?= $customer_name; ?>
                                    </a>
                                </td>
                                
                                <td>
																<?= date('d M Y',strtotime($sdate))?>
															</td>
															<td>
																<?= $car_rental_amt?>
															</td>
															<td>
																<?= $driver_name?>
															</td>
															<td>
															    <?php if($car_rental_amt==''){?>
															    <?= $total?>
															    <?php }else {?>
																<?= $car_rental_amt + $total?>
																<?php } ?>
															</td>
															<td>
																<?= $advance?>
															</td>
															<td>
																<?= $balance?>
															</td>
															<td>
																<?= $pay_mode?>
															</td>
                                
                                <td>
									<a href="sales?sale_id=<?= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Edit Sale" data-original-title="Edit Sale"><i class="fa fa-edit text-info"></i></a>
									
									<a href="invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Invoice" data-original-title="Invoice"><i class="fa fa-print text-dark"></i></a>
									<a href="sales_advance_invoice?cid=<?= $customer_id?>&sid=<?= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Advance Invoice" data-original-title="Advance Invoice"><i class="fa fa-print text-cyan"></i></a>
									<!--<a href="sales_delete?sid=<?php //echo $sale_id?>" class="text-inverse" title="Delete" data-bs-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash text-danger"></i></a>-->
									</td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
					</table>
				</div>		
			
								</div>
                                <!--priview modal-->
                                <?php 
                                error_reporting(0);
                                foreach ($salesDetails as $salesFetch):?>
                                <?php extract($salesFetch);?>
<div class="modal fade" id="info<?php echo $sale_id;?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoLabel<?php echo $sale_id;?>">चलन तपशील</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $customer_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल नंबर</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $customer_mobno?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span> <?php $date=date('d M Y',strtotime($sdate))?>
                                            <?= $date?></span>
						        					</td>
						        				</tr>
						        				<?php
						        				$getCusDebAmt=mysqli_query ($connect, "SELECT SUM(total+car_rental_amt) as debAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowDebAmt=mysqli_fetch_assoc($getCusDebAmt);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>डेबिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowDebAmt['debAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				<?php
						        				$getcusCre=mysqli_query ($connect, "SELECT SUM(balance+car_rental_amt) as credAmt FROM `sales` WHERE customer_id=$customer_id");
						        				$rowcre=mysqli_fetch_assoc($getcusCre);
						        				?>
						        				<tr>
						        					<td>
						        						<strong>क्रेडिट रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        				    <strong>₹ <?= $rowcre['credAmt'];?> /-</strong>
						        					</td>
						        				</tr>
						        				
						        				
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">पावती</h6>
						        					</td>
						        				</tr>
						        			</tbody>
						        		</table>
						        		<table class="table table-bordered text-center fs-6">
                                            <thead>
                                                <tr>
                                                    <th>अ.क्र.</th>
                                                    <th>मालाचे विवरण</th>
                                                    <th>रोपांची संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $getcuspro = "SELECT * FROM sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN sales d ON s.sale_id=d.sale_id WHERE s.sale_id='$sale_id'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $product_id?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $pqty?></td>
                                                <td><?= $pprice?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">एकूण</th>
                                                  <td class="text-center">₹ <?= $total?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">कारचे भाडे रु</th>
                                                  <td class="text-center">₹ <?= $car_rental_amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">ड्राइवर नाव</th>
                                                  <td class="text-center"><?= $driver_name?></td>
                                        </tr>
                                            <tr align="right">
                                                  <th colspan="4">तारीख आणि एकूण</th>
                                                  <td class="text-center">तारीख: <?= date('d M Y',strtotime($advdate))?>, ₹ <?= $amt?>/-</td>
                                        </tr>
                                            <tr align="right">
                                                      <th colspan="4">ऍडव्हान्स</th>
                                                      <td class="text-center">
                                                          ₹ <?= $advance?>/-
                                                      </td>
                                            </tr>
                                            <tr align="right">      
                                                      <th colspan="4">शिल्लक</th>
                                                      <td class="text-center">
                                                        ₹ <?= $balance?>/-
                                                          
                                                       </td>
                                            </tr>   
                                            </tbody>
                                            
                                    </table>

						        	</div>
                                </div>
                                <!--<div class="modal-footer">-->
                                <!--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>-->
                                <!--    <button type="button" class="btn btn-success" onclick="window.print()">छापणे</button>-->
                                <!--  </div>-->
                                </div>
                              </div>
                            </div>							
                         <?php endforeach?>
                        </div>
					</div>
						<!--quotation history end-->
						<!--quotation start-->
						<div class="tab-pane fade <?= $nav_tabs['quotation_sales'] ? 'show active' : '' ?>" id="pills-quotation_sales" role="tabpanel" aria-labelledby="pills-quotation_sales-tab">
							<?php
							if(isset($_GET['sale_id'])){
						      $rsa = false;
							  $gets=mysqli_query($connect,"SELECT * FROM sales WHERE sale_id='{$_GET['sale_id']}'");
							  if (mysqli_num_rows($gets) > 0) {
							      $rsa = mysqli_fetch_assoc($gets);
							      $getSaleDetail = mysqli_query($connect, "SELECT * FROM sales_details WHERE sale_id = '{$rsa['sale_id']}'");
							      $rsa['sale_details'] = array();
							      if (mysqli_num_rows($getSaleDetail) > 0) {
							          while($sdRow = mysqli_fetch_assoc($getSaleDetail)) {
							              $rsa['sale_details'][] = $sdRow;
							          }
							      }
							  }
							?>
							<?php if ($rsa): ?>
							<form method="post">
								<div class="table-responsive">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td align="center">
													<h4>विक्री अद्यतनित करा</h4>
												</td>
											</tr>
											<tr>
												<td>
													<div class="row justify-content-between">
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">ग्राहक</lable>
															<select name="customer_id" id="customer_id" class="form-select mb-3" required>
																<option value="">ग्राहक निवडा</option>
																<?php $getcustomert = mysqli_query($connect,"SELECT * from customer where customer_status=1 order by customer_id desc") ?>
																<?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
																<?php while ($getcus=mysqli_fetch_assoc($getcustomert)): ?>
																<option value="<?= $getcus['customer_id'] ?>" <?= ($rsa['customer_id']==$getcus['customer_id']) ? 'selected' : '' ?>>
																	<?= $getcus['customer_id'] ?> | <?= $getcus['customer_name'] ?>(<?= $getcus['customer_mobno'] ?>)
																</option>
																<?php endwhile ?>
																<?php endif ?>
															</select>
														</div>
														<div class="col-12 col-md-4 mt-4">
															<button type="button" class="btn btn-sm btn-outline-success text-center" data-bs-toggle="modal" data-bs-target="#customer" data-bs-whatever="@mdo">+</button>
														</div><br>
														<div class="col-12 col-md-4">
															<lable class="form-lable fw-bold">तारीख</lable>
															<input type="date" name="sdate" id="order_date" class="form-control mb-3" value="<?= date('Y-m-d', strtotime($rsa['sdate']))?>">
														</div>
													</div>
													<table id="invoice-item-table" class="table table-bordered mb-0">
														<thead>
															<tr align="center">
																<th class="text-nowrap">अनु. क्र.</th>
																<th width="15%" class="text-start">श्रेणी</th>
																<th width="20%" class="text-start">प्रॉडक्ट नाव</th>
																<th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
																<th>प्रमाण</th>
																<th>किंमत</th>
																<th>उप एकूण</th>
																<th>कृती</th>
															</tr>
														</thead>
														<tbody class="align-middle">
														    <?php if ($rsa['sale_details'] && count($rsa['sale_details'])>0): ?>
														    <?php foreach ($rsa['sale_details'] as $k => $sdtls): ?>
														    <tr align="center">
																<td><?= $k + 1 ?></td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>" <?= ($sdtls['cat_id'] == $row1['cat_id']) ? 'selected' : '' ?>>
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="<?= $sdtls['sid'] ?>">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['product_id'] ?>" <?= ($sdtls['pid'] == $row1['product_id']) ? 'selected' : '' ?>>
																			<?= $row1['product_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="text" name="varity[]" class="form-control text-center varity" value="<?= $sdtls['varity'] ?>" readonly>
																</td>
																<td>
																	<input type="text" name="pqty[]" value="<?= $sdtls['pqty'] ?>" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" value="<?= $sdtls['pprice'] ?>" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()"">
																</td>
																<td>
																	<input type="text" name="sub_total[]" value="<?= $sdtls['sub_total'] ?>" readonly class="form-control text-center final_amount">
																</td>
																<td>
																	<button type="button" class="btn btn-sm btn-outline-<?= $k==0 ? 'success add_row' : 'danger remove_row' ?> fw-bold text-center"><?= $k==0 ? '+' : 'x' ?></button>
																</td>
															</tr>
														    <?php endforeach ?>
														    <?php else: ?>
														    <tr align="center">
																<td>1</td>
																<td>
																    <!--<input type="hidden" name="cat_id[]" value="<?//= $sdtls['cat_id'] ?>">-->
																	<select class="form-select cat_id text-start" name="cat_id[]" required onchange="catProduct(this)">
																	    <!--onchange="changePrice(this)-->
																		<option value="">श्रेणी निवडा</option>
																		<?php $query = mysqli_query($connect,"select * from category_product") ?>
																		<?php if ($query && mysqli_num_rows($query)): ?>
																		<?php while ($row1=mysqli_fetch_assoc($query)): ?>
																		<option value="<?= $row1['cat_id'] ?>">
																			<?= $row1['cat_name'] ?>
																		</option>
																		<?php endwhile ?>
																		<?php endif ?>
																	</select>
																</td>
																<td>
																    <input type="hidden" name="sid[]" value="new">
																	<select class="form-select item_name text-start proid" name="pid[]" required onchange="changePrice(this)">
																		<option value="">प्रॉडक्ट निवडा</option>
																		<?php //$query = mysqli_query($connect,"select * from product") ?>
																		<?php //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
																		<!--<option value="<?//= $row1['product_id'] ?>">-->
																			<?//= $row1['product_name'] ?>
																		</option>
																		<?php //endwhile ?>
																		<?php //endif ?>
																	</select>
																</td>
																<td>
																	<input type="text" name="pqty[]" class="form-control text-center number_only item_quantity" oninput="allowType(event, 'number'),calcTotal()">
																</td>
																<td>
																	<input type="text" name="pprice[]" class="form-control text-center item_price" oninput="allowType(event, 'decimal', 2),calcTotal()">
																</td>
																<td>
																	<input type="text" name="sub_total[]" readonly class="form-control text-center final_amount">
																</td>
																<td>
																	<button type="button" class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>
																</td>
															</tr>
														    <?php endif ?>
															<tr class="total-footer">
																<td colspan="5" rowspan="7"></td>
															    <th>
																	उप एकूण
																</th>
																<td align="center">
																	<input class="form-control text-center final_total_amt" id="final_total_amt" name="total" value="<?= $rsa['total'] ?>" readonly>
																</td>
																
															</tr>
														    <tr>
																<th>
																	गाडी भाडे

																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="car_rental" placeholder="कार भाड्याची रक्कम" name="car_rental_amt" value="<?= $rsa['car_rental_amt'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																	<input class="form-control text-center my-3" id="car_name" name="driver_name" placeholder="ड्राइवर नाव" value="<?= $rsa['driver_name'] ?>">
																</td>
																<td rowspan="7"></td>
															</tr>
															<tr>
															    <th>
																	एकूण
																</th>
																<td align="center">
																    <?php //$gt = $rsa['amt'] + $rsa['car_rental_amt'] ?>
																	<input type="text" class="form-control text-center amt"  readonly value="<?= $rsa['amt']?>">
																</td>
																
															</tr>
															<tr>
																<th>
																	तारीख
																</th>
																<td align="center">
																	<input type="date" class="form-control text-center mb-2" id="advdate" name="advdate" value="<?= $rsa['advdate']?>">
																	<input class="form-control text-center subadvance" name="amt" oninput="allowType(event, 'number'),calcTotal()" value="<?= $rsa['amt']?>">
																</td>
															</tr>
															<tr>
																<th>
																	ऍडव्हान्स
																</th>
																<td align="center">
																	<input class="form-control text-center my-3" id="adv" name="advance" value="<?= $rsa['advance'] ?>" oninput="allowType(event, 'number'),calcTotal()">
																</td>
															</tr>
															<tr>
																<th>
																	शिल्लक
																</th>
																<td align="center">
																	<input class="form-control text-center" id="bal" name="balance" value="<?= $rsa['balance'] ?>" readonly>
																</td>
															</tr>
															<tr>
																<th>पेमेंट निवडा</th>
																<td colspan="1">
																	<select name="payment" class="form-select">
																		<option value="">पेमेंट निवडा</option>
																		<option <?= ($rsa['pay_mode']=='cash') ? 'selected' : '' ?> value="cash">रोख</option>
																		<option <?= ($rsa['pay_mode']=='sbi') ? 'selected' : '' ?> value="sbi">आदित्य नर्सरी SBI</option>
																		<option <?= ($rsa['pay_mode']=='mgb') ? 'selected' : '' ?> value="mgb">आदित्य नर्सरी MGB</option>
																		<option <?= ($rsa['pay_mode']=='ds_bank') ? 'selected' : '' ?> value="ds_bank">डीएस बँक</option>
																		<option <?= ($rsa['pay_mode']=='other_bank') ? 'selected' : '' ?> value="other_bank">इतर बँक</option>
																	</select>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th class="text-center">
													<input type="submit" name="quotation_sales_edit" id="create_invoice" class="btn btn-success" value="जतन करा">
                                            <a href="sales?show_history=true" class="btn btn-dark ">मागे</a>
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							<?php else: ?>
							<h5 class="text-muted text-center">सेल्स इन्व्हॉईस मिळाले नाही</h5>
							<?php endif ?>
							<?php } ?>
					</div>
						<!--quotation end-->
						
						<!--Customer Details start-->
						<div class="tab-pane fade <?= $nav_tabs['cus_details'] ? 'show active' : '' ?>" id="pills-cusdet" role="tabpanel" aria-labelledby="pills-cusdet-tab">
							<div class="row">
								<div class="col-12">
										<div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container-cus">
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				                        <div class="table-responsive">
					<table border="1" id="customertbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <div class="d-inline-flex align-items-center select-all">
								        <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
			                            <div class="dropdown">
			                            	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">
			                            		<i class='bx bx-slider-alt fs-6'></i>
			                            	</button>
			                            	<ul class="dropdown-menu" aria-labelledby="category-action">
			                            		<li>
			                            			<a title="Delete" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('ग्राहक हटवा..?');">
			                            				<i class="btn-round bx bx-trash me-2"></i>ग्राहक हटवा
			                            			</a>
			                            		</li>
			                            	</ul>
			                            </div>
								    </div>
									<?php //endif ?>
								</th>
    								<th>आयडी</th>
                                    <th>ग्राहकाचे नाव</th
                                    >
                                    <th>मोबाईल नंबर</th>
                                    <th>इमेल आयडी</th>
                                    <th>लिंग</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getBrand = mysqli_query($connect, "SELECT * FROM customer WHERE customer_status='1' ORDER BY customer_id DESC") ?>
                            <?php if (mysqli_num_rows($getBrand)>0): ?>
                                <?php while ($brand = mysqli_fetch_assoc($getBrand)): 
                                extract($brand);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" name="customer_id[]" value="<?= $customer_id ?>">
                                </td>
                                <td>
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $customer_id ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="customer_add?cus_id=<?= $customer_id;?>">
                                        <?= $customer_name; ?>
                                    </a>
                                </td>
                                
                                <td>
                                    <?= $customer_mobno; ?>
                                </td>
                                <td>
                                    <?= $customer_email; ?>
                                </td>
                                <td>
                                    <?= $customer_gender ?>
                                </td>
                            </tr>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
					</table>
				</div>
								</div>
							</div>
						</div>
						<!--Customer Details end-->
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="customer" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="advLabel">नवीन ग्राहक जोडा</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
							<form method="post">
                            <div class="row">
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname" placeholder="ग्राहकाचे नाव" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email" placeholder="इमेल आयडी">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                        <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel" placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control" required oninput="allowType(event, 'mobile')">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
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
                                
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य </label>
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
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">जिल्हे </label>
                                        <select class="form-select" id="city" name="city">
							                <option>निवडा...</option>
						                </select>                                    
						            </div>
                                </div>
                                
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">तालुका</label>
                                            <select class="form-select" id="tal" name="taluka">
							                    <option>निवडा...</option>
						                    </select>  
									</div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">गाव</label>
                                        <select class="form-select" id="village" name="village">
							                    <option>निवडा...</option>
						                </select>                                   
						            </div>
                                </div>
                            </div>     
                            
                            <!--<div class="row">-->
                            <!--   <div class="col-12">-->
                            <!--        <label for="Address" class="form-label">Address</label>-->
                                   
                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_info"></textarea>-->
                                   
                            <!--    </div>-->
                            <!--</div>-->
                            
                            <button type="submit" name="customer_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="customer_list" class="btn btn-dark mt-3">मागे</a>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addStockModalLabel">स्टॉक जोडा</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<div class="row">
					<div class="col-12">
						<form method="post">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<select class="form-select item_name text-start" name="pid" id="pid" required>
											<option value="">Select Products</option>
											<?php $query = mysqli_query($connect,"select * from product") ?>
											<?php if ($query && mysqli_num_rows($query)): ?>
											<?php while ($row1=mysqli_fetch_assoc($query)): ?>
											<option value="<?= $row1['product_id'] ?>">
												<?= $row1['product_name'] ?>
											</option>
											<?php endwhile ?>
											<?php endif ?>
										</select>
									</div>
									<div class="col-12 my-3">
										<div class="form-group">
											<input id="aviqty" type="text" name="poqty" placeholder="शिल्लक प्रमाण" class="form-control" readonly oninput="allowType(event, 'number')">
										</div>
									</div>
									<div class="col-12">
										<div class="form-group">
											<input id="pnqty" type="text" name="pnqty" class="form-control" placeholder="संख्य" required oninput="allowType(event, 'number')">
										</div>
									</div>
								</div>
							</div>
							<button type="submit" name="add_stock" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="pcat_id" tabindex="-1" aria-labelledby="pcat_idLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pcat_idLabel">नवीन प्रॉडक्ट श्रेणी जोडा</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
					<form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">प्रॉडक्ट श्रेणीचे नाव<span class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>
                                
                            </div>     
                           
                            <button type="submit" name="pro_cat_add" class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                            <a href="product_category_list" class="btn btn-dark mt-3">मागे</a>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>									
<script>
$(document).ready(function() {
	$('.number_only').on('input', function() {
		this.value = this.value.replace(/[^0-9]/g, '');
	});
	$('.remove_row').on('click', function() {
	    $(this).closest('tr').remove();
		manageCount();
		calcTotal();
	});
	$("#bal_amt, #adv_amt").on("input change", advsub);
	calcTotal();
	
	$("select#pid").change(function() {
		var q = $("#pid option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { pqty: q }
		}).done(function(data) {
			$("#aviqty").val(data);
		});
	});
	
	$("#cus_id").change(function() {
		var b = $("#cus_id option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { balamt: b }
		}).done(function(data) {
			$("#bal_amt").val(data);
		});
	});
});
$('.add_row').on('click', function() {
	const table = $('#invoice-item-table');
	const cloned = $(this).closest('tr').clone();
	cloned.find('.add_row')
		.removeClass('add_row')
		.removeClass('btn-outline-success')
		.addClass('btn-outline-danger')
		.addClass('remove_row').on('click', function() {
			$(this).closest('tr').remove();
			manageCount();
			calcTotal();
		})
		.text('x');
	cloned.find('select, input').val('');
	cloned.find('[name="sid[]"]').val('new');
	cloned.insertBefore('.total-footer', table);
	manageCount();
 	calcTotal();
});

function manageCount() {
	const sr = $('#invoice-item-table tbody tr td:nth-child(1):not([colspan])');
	for (i = 0; i < sr.length; i++) {
		$(sr[i]).text(i + 1);
	}
}
function calcTotal() {
	const table = $('#invoice-item-table');
	const item = $('select', table);
	const qty = $('.item_quantity', table);
	const price = $('.item_price', table);
	const total = $('.final_amount', table);
    const adv = $('#adv').val();
    const amt = $('.amt').val();
	let final = 0;
	for (let i = 0; i < qty.length; i++) {
		const _t = $(qty[i]).val() * $(price[i]).val();
		final += _t;
		$(total[i]).val(_t.toFixed(2));
	}
	$('#final_total_amt').val(final.toFixed(2));
	let car = Number($('#car_rental').val());
	let gr_total = final + car;
	$('.amt').val(gr_total.toFixed(2));
    $('#bal').val((gr_total - Number($('.subadvance').val()) - Number(adv)).toFixed(2));
}

function changePrice(el) {
	const pid = el.value;
	const row = $(el).closest('tr');
	$.ajax({
		url: "ajax_master",
		method: "POST",
		dataType: 'json',
		data: { get_product_qty_price: pid },
		success: res => {
			$('.item_price', row).val(res.price);
			$('.item_quantity', row).val(res.qty);
			$('.varity', row).val(res.varity);
			calcTotal();
		}
	});
}

function catProduct(el) {
	const cat_id = el.value;
	const row = $(el).closest('tr');
	$.ajax({
		url: "ajax_master",
		method: "POST",
	    data: { cat_product: cat_id }
		}).done(function(data) {
			$(".proid", row).html(data);
		});
	}

function advsub() {
    let amt = $('#bal_amt').val();
    let adv = $('#adv_amt').val();
    let _resbal = Number(amt) - Number(adv);
    
    $('#totbal').val(!isNaN(_resbal) ? _resbal : 0).trigger('change');
}

$(document).ready(function() {
	$("select#pur_id").change(function() {
		var q = $("#pur_id option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { qty: q }
		}).done(function(data) {
			$("#pur_qty").val(data);
		});
	});
});
$(document).ready(function() {
	$("select#pid").change(function() {
		var q = $("#pid option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: { pqty: q }
		}).done(function(data) {
			$("#aviqty").val(data);
		});
	});
});

//customer state,city,village
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
<?php include "footer.php";?>