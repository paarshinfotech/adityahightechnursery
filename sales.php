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
} elseif (isset($_GET['show_details'])) {
    $nav_tabs['cus_details'] = true;
} else {
    $nav_tabs['sales'] = true;
}

// product category
if (isset($_POST['pro_cat_add'])) {
    escapeExtract($_POST);

    if (!empty($cat_name)) {
        $sql = "SELECT * FROM category_product WHERE cat_name='$cat_name'";
    } else {
        $sql = "SELECT * FROM category_product WHERE cat_name='$cat_name'";
    }
    $sql_res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($sql_res) != 0) {
        header('Location: sales?show_products=true&action=Success&action_msg=' . $cat_name . ' प्रॉडक्ट श्रेणी आधिपासुन आहे..!');
        exit();
    } else {
        $insert = "INSERT INTO category_product(cat_name) VALUES ('$cat_name')";
        $add = mysqli_query($connect, $insert);

        if ($add) {
            header('Location: sales?show_products=true&action=Success&action_msg=' . $cat_name . ' नवीन प्रॉडक्ट श्रेणी जोडली.!');
            exit();
        } else {
            header('Location: sales?show_products=true&action=Success&action_msg=काहीतरी चूक झाली');
            exit();
        }
    }
}
// add products
if (isset($_POST['product_add'])) {
    escapeExtract($_POST);
    if (!empty($product_name)) {
        $sql = "SELECT * FROM product WHERE product_name='$product_name'";
    } else {
        $sql = "SELECT * FROM product WHERE product_name='$product_name'";
    }
    $sql_res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($sql_res) != 0) {
        header('Location: sales?show_products=true&action=Success&action_msg=' . $product_name . ' प्रॉडक आधिपासुन आहे..!');
        exit();
    } else {
        $proadd = "INSERT INTO product(`product_name`,`product_qty`,`product_amount`, `product_info`,cat_id,product_varity) VALUES ('$product_name','$product_qty','$product_amount','$product_info','$cat_id','$product_varity')";
        $result = mysqli_query($connect, $proadd);
        if ($result) {
            header('Location: sales?show_products=true&action=Success&action_msg=' . $product_name . ' नावाचे प्रॉडक्ट जोडले..!');
            exit();
        } else {
            header('Location: sales?show_products=true&action=Success&action_msg=काहीतरी चूक झाली');
            exit();
        }
    }
}
//update product
if (isset($_POST['product_edit'])) {
    escapeExtract($_POST);

    $update = mysqli_query($connect, "update product set
		product_name = '$product_name',
		product_qty = '$product_qty',
		product_amount = '$product_amount',
		product_info = '$product_info',
		cat_id='$cat_id',
		product_varity='$product_varity'
		where product_id = '" . $_GET['pid'] . "'");

    if ($update) {
        header('Location: sales?show_products=true&action=Success&action_msg= प्रॉडक्ट अपडेट केले...!');
        exit();
    } else {
        header('Location: sales?show_products=true&action=error&action_msg=काहीतरी चूक झाली..!');
        exit();
    }
}
if (isset($_GET['action_msg'])) {
    echo $_GET['action_msg'];
}

//supplier add
if (isset($_POST['supplier_add'])) {
    extract($_POST);
    $sql = "SELECT * FROM supplier WHERE supplier_mobno='$smobile' OR supplier_email='$semail'";
    $sql_res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($sql_res) != 0) {
        header('Location: sales?show_supplier=true&action=Success&action_msg=' . $sname . ' सप्लायर आधिपासुन आहे..!');
        exit();
    } else {

        $insert = "INSERT INTO supplier(`supplier_name`, `supplier_mobno`,  `supplier_email`,`supplier_info`,`supplier_address`,`store_name`) VALUES ('" . mysqli_real_escape_string($connect, $sname) . "','" . mysqli_real_escape_string($connect, $smobile) . "',
		'" . mysqli_real_escape_string($connect, $semail) . "','" . mysqli_real_escape_string($connect, $spl_info) . "','" . mysqli_real_escape_string($connect, $spl_add) . "','" . mysqli_real_escape_string($connect, $store_name) . "')";

        $add = mysqli_query($connect, $insert);
        if ($add) {
            header('Location: sales?show_supplier=true&action=Success&action_msg=' . $sname . 'नवीन सप्लायर जोडले..!');
            exit();
        } else {
            header('Location: sales?show_supplier=true&action=Success&action_msg=काहीतरी चूक झाली');
            exit();
        }
    }
}
//edit supplier
if (isset($_POST['supplier_edit'])) {
    extract($_POST);

    $update = mysqli_query($connect, "update supplier set
			supplier_name = '" . mysqli_real_escape_string($connect, $sname) . "',
			supplier_email = '" . mysqli_real_escape_string($connect, $semail) . "',
			supplier_mobno = '" . mysqli_real_escape_string($connect, $smobile) . "',
			supplier_info = '" . mysqli_real_escape_string($connect, $spl_info) . "',
			supplier_address = '" . mysqli_real_escape_string($connect, $spl_add) . "',
			store_name = '" . mysqli_real_escape_string($connect, $store_name) . "'      where supplier_id = '" . $_GET['supid'] . "'");

    if ($update) {
        header('Location: sales?show_supplier=true&action=Success&action_msg=' . $sname . 'सप्लायर अपडेट झाले..!');
        exit();
    } else {
        header('Location: sales?show_supplier=true&action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}


// add purchase
if (isset($_POST['purchase_add'])) {
    escapeExtract($_POST);

    $insert = "INSERT INTO purchase(`purchase_name`,`pold_qty`,`purchase_qty`,`purchase_price`,`purchase_created`,`purchase_expected`,`supplier_name`) VALUES ('$purchase_name','$pold_qty','$pqty','$pprice','$pcreated','$pexpected','$supplier_name')";
    $add = mysqli_query($connect, $insert);
    $pnQTY = $pold_qty + $pqty;
    $update = mysqli_query($connect, "update product set
		product_qty = '$pnQTY'
		where product_name = '$purchase_name'");
    if ($add) {
        header('Location: sales?show_purchase=true&action=Success&action_msg=नवीन  जोडले..!');
        exit();
    } else {
        header('Location: sales?show_purchase=true&action=error&action_msg=काहीतरी चूक झाली..!');
        exit();
    }
}

//edit purchase
if (isset($_POST['purchase_edit'])) {
    extract($_POST);

    $update = mysqli_query($connect, "update purchase set
			purchase_name = '" . mysqli_real_escape_string($connect, $purchase_name) . "',
			purchase_qty = '" . mysqli_real_escape_string($connect, $pqty) . "',
			purchase_price = '" . mysqli_real_escape_string($connect, $pprice) . "',
			purchase_created = '" . mysqli_real_escape_string($connect, $pcreated) . "',
			purchase_expected = '" . mysqli_real_escape_string($connect, $pexpected) . "',
			supplier_name = '" . mysqli_real_escape_string($connect, $supplier_name) . "'      where purchase_id = '" . $_GET['pur_id'] . "'");

    $pnQTY = $pold_qty + $pqty;
    $update = mysqli_query($connect, "update product set
		product_qty = '$pnQTY'
		where product_name = '$purchase_name'");

    if ($update) {
        header('Location: sales?show_purchase=true&action=Success&action_msg= अपडेट केले...!');
        exit();
    } else {
        header('Location: sales?show_purchase=true&action=error&action_msg=काहीतरी चूक झाली..!');
        exit();
    }
}



//स्टॉक जोडा
if (isset($_POST['add_stock'])) {
    escapeExtract($_POST);
    $pnQTY = $poqty + $pnqty;
    $update = mysqli_query($connect, "update product set
		product_id='$pid',
		product_qty = '$pnQTY'
		where product_id = '$pid'");

    if ($update) {
        header('Location: sales?show_products=true');
        exit();
    } else {
        header('Location: sales?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

//add sales
if (isset($_POST['sales'])) {
    escapePOST($_POST);
    $cid = $_POST['customer_id'];
    $sdate = $_POST['sdate'];
    $pid = $_POST['pid'];
    $quantity = $_POST['pqty'];
    $pprice = $_POST['pprice'];
    $payment = $_POST['payment'];
    $total = $_POST['total'];
    $car_rental_amt = $_POST['car_rental_amt'];
    $driver_name = $_POST['driver_name'];
    $advdate = $_POST['advdate'];
    $amt = $_POST['amt'];
    $date_paymode = $_POST['date_paymode'];
    $sub_total = $_POST['sub_total'];
    $advance = $_POST['advance'];
    $pay_upi_amt = $_POST['pay_upi_amt'];
    $balance = $_POST['balance'];
    $cat_id = $_POST['cat_id'];
    $varity = $_POST['varity'];
    $status = ($balance > 0) ? 'pending' : 'completed';
    $paystatus = ($balance > 0) ? 'unpaid' : 'paid';

    if (mysqli_query($connect, "INSERT INTO `sales`(customer_id, sdate, total,car_rental_amt,driver_name,advdate,amt,date_paymode,advance,pay_upi_amt, balance, pay_mode, paystatus, status) VALUES('$cid', '$sdate', '$total','$car_rental_amt','$driver_name','$advdate','$amt','$date_paymode','$advance','$pay_upi_amt','$balance', '$payment', '$paystatus', '$status')")) {
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
        if ($_salesAdded) {
            // header("Location: invoice?cid={$cid}&sid={$sales_id}");
            // exit();
            header("Location: sales?show_history=true&action=Success&action_msg=नवीन विक्री जोडले..!");
            exit();
        } else {
            header('Location: sales?show_history=true&action=Success&action_msg=काहीतरी चूक झाली');
            exit();
        }
    }
}

//edit sales
if (isset($_POST['sales_edit'])) {
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
    $date_paymode = $_POST['date_paymode'];
    $advance = $_POST['advance'];
    $pay_upi_amt = $_POST['pay_upi_amt'];
    $balance = $_POST['balance'];
    $payment = $_POST['payment'];
    $paystatus = ($balance > 0) ? 'unpaid' : 'paid';
    $status = ($paystatus != 'unpaid') ? 'completed' : 'pending';
    if (mysqli_query($connect, "UPDATE sales SET customer_id = '{$cid}',sdate = '{$sdate}',total = '{$total}',car_rental_amt = '{$car_rental_amt}',driver_name = '{$driver_name}',advdate='{$advdate}',amt='{$amt}',date_paymode = '{$date_paymode}', advance = '{$advance}',pay_upi_amt = '{$pay_upi_amt}',balance = '{$balance}',pay_mode = '{$payment}', paystatus = '{$paystatus}' , status = '{$status}' WHERE sale_id = '{$_GET['sale_id']}'")) {
        $sid_in = '(' . implode(', ', $sid) . ')';
        $getDeleteSale = mysqli_query($connect, "SELECT pid, pqty FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
        if (mysqli_num_rows($getDeleteSale) > 0) {
            while ($delRow = mysqli_fetch_assoc($getDeleteSale)) {
                mysqli_query($connect, "UPDATE product SET product_qty = (product_qty + {$delRow['pqty']}) WHERE product_id = '{$delRow['pid']}'");
            }
        }
        mysqli_query($connect, "DELETE FROM sales_details WHERE sale_id = '{$_GET['sale_id']}' AND sid NOT IN $sid_in");
        $insert = true;
        foreach ($sid as $_i => $_sid) {
            if ($_sid == 'new') {
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
                if (mysqli_num_rows($get_old_product) > 0) {
                    $old_pqty = (int) mysqli_fetch_assoc($get_old_product)['pqty'];
                }
                if (!mysqli_query($connect, "UPDATE sales_details SET pid = '{$pid[$_i]}', pqty = '{$quantity[$_i]}', pprice = '{$pprice[$_i]}', sub_total = '{$sub_total[$_i]}',cat_id = '{$cat_id[$_i]}', varity = '{$varity[$_i]}' WHERE sale_id = '{$_GET['sale_id']}' AND sid = '{$sid[$_i]}'")) {
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



//adv_sales
if (isset($_POST['adv_sales'])) {
    escapePOST($_POST);
    $advance = $_POST['bal_amt'];
    $again_adv_amt = $_POST['again_adv_amt'];
    $balance = $_POST['totbal'];
    $paystatus = ($balance > 0) ? 'unpaid' : 'paid';
    $status = ($paystatus != 'unpaid') ? 'completed' : 'pending';

    $advSaleRes = mysqli_query($connect, "UPDATE sales SET
    again_adv_amt='{$advance}',
    advance='{$again_adv_amt}',
    balance='{$balance}',
    paystatus = '{$paystatus}',
    status = '{$status}' WHERE customer_id='{$_POST['cus_id']}'");

    if ($advSaleRes) {
        // header("Location: sales?show_history=true");
        // exit();
        header('Location: sales?show_history=true&action=Success&action_msg=ग्राहकाची ₹ ' . $again_adv_amt . ' /- जमा झाले..!');
        exit();
    } else {
        header("Location: sales?sale_id='{$_GET['sale_id']}'");
        exit();
    }
}



/*------ Add Customer details ------*/
if (isset($_POST['customer_add'])) {
    escapeExtract($_POST);

    if (!empty($customer_email)) {
        $sql = "SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    } else {
        $sql = "SELECT * FROM customer WHERE customer_mobno='$customer_mobno'";
    }
    $sql_res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($sql_res) != 0) {
        header('Location: sales?show_sales=true&action=Success&action_msg=' . $customer_name . ' ग्राहक आधिपासुन आहे..!');
        exit();
    } else {
        $insert = "INSERT INTO customer(customer_name, customer_mobno, customer_gender, customer_email,state, city, taluka, village) VALUES ('$customer_name','$customer_mobno','$customer_gender','$customer_email','$state','$city','$taluka','$village')";
        $add = mysqli_query($connect, $insert);

        if ($add) {
            // header('Location: sales?action=Success&action_msg=' . $customer_name . ' नवीन ग्राहक जोडले..!');
            // exit();
            echo $add;
        } else {
            // header('Location: sales?show_sales=true&action=Success&action_msg=काहीतरी चूक झाली');
            // exit();
        }
    }
}



?>
<?php require_once "header.php"; ?>

<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['sales'] ? 'active' : '' ?>" id="pills-sales-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-sales" type="button"
                                role="tab">विक्री</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['sale_history'] ? 'active' : '' ?>"
                                id="pills-salesh-tab" data-bs-toggle="pill" data-bs-target="#pills-salesh" type="button"
                                role="tab" aria-controls="pills-salesh" aria-selected="false">विक्री इतिहास</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['products'] ? 'active' : '' ?>"
                                id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product"
                                type="button" role="tab" aria-controls="pills-product"
                                aria-selected="false">उत्पादने</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['purchase'] ? 'active' : '' ?>"
                                id="pills-purchase-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase"
                                type="button" role="tab" aria-controls="pills-purchase" aria-selected="false">खरेदी
                                ऑर्डर</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['supplier'] ? 'active' : '' ?>"
                                id="pills-supplier-tab" data-bs-toggle="pill" data-bs-target="#pills-supplier"
                                type="button" role="tab" aria-controls="pills-supplier"
                                aria-selected="false">पुरवठादार</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['cus_details'] ? 'active' : '' ?>"
                                id="pills-cusdet-tab" data-bs-toggle="pill" data-bs-target="#pills-cusdet" type="button"
                                role="tab" aria-controls="pills-cusdet" aria-selected="false">ग्राहक तपशील</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <!--<button class="nav-link dark <? //= $nav_tabs['cus_details'] ? 'active' : '' ?>" id="pills-cusdet-tab" data-bs-toggle="pill" data-bs-target="#pills-cusdet" type="button" role="tab" aria-controls="pills-cusdet" aria-selected="false">Customer Details</button>-->
                            <button class="btn text-success" data-bs-toggle="modal"
                                data-bs-target="#addStockModal">स्टॉक जोडा</button>
                        </li>
                    </ul>








                    <div class="tab-content" id="pills-tabContent">
                        <!--sales start-->
                        <div class="tab-pane fade <?= $nav_tabs['sales'] ? 'show active' : '' ?>" id="pills-sales"
                            role="tabpanel" aria-labelledby="pills-sales-tab">
                            <?php
                            if (isset($_GET['sale_id'])) {
                                $rsa = false;
                                $gets = mysqli_query($connect, "SELECT * FROM sales WHERE sale_id='{$_GET['sale_id']}'");
                                if (mysqli_num_rows($gets) > 0) {
                                    $rsa = mysqli_fetch_assoc($gets);
                                    $getSaleDetail = mysqli_query($connect, "SELECT * FROM sales_details WHERE sale_id = '{$rsa['sale_id']}'");
                                    $rsa['sale_details'] = array();
                                    if (mysqli_num_rows($getSaleDetail) > 0) {
                                        while ($sdRow = mysqli_fetch_assoc($getSaleDetail)) {
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



                                                        <div class="col-12 col-md-4" id="serch_input_customer">
                                                            <label class="form-label fw-bold">ग्राहक</label>
                                                            <div class="input-group search-box" id="Search_input_fild">
                                                                <?php
                                                                        $getcustomert = mysqli_query($connect, "SELECT * FROM customer WHERE customer_status=1 AND customer_id = " . $rsa['customer_id'] . " LIMIT 1");

                                                                        if ($getcustomert && mysqli_num_rows($getcustomert) > 0) {
                                                                            $getcus = mysqli_fetch_assoc($getcustomert);
                                                                            ?>
                                                                <input type="text" name="customer_Search"
                                                                    value="<?php echo $getcus['customer_name'] . " | " .  $getcus['customer_mobno']?>"
                                                                    id="customer_search" class="form-control mb-3"
                                                                    oninput="searchCustomers(this.value)"
                                                                    placeholder="ग्राहक शोधा..." required>

                                                                <?php
                                                                        }
                                                                        ?>


                                                                <input type="hidden" name="customer_id" id="customer_id"
                                                                    value="<?php echo $rsa['customer_id'] ?>" required>
                                                            </div>
                                                            <div class="search-results position-relative"
                                                                id="customer_search_results_Div">
                                                            </div>
                                                        </div>




                                                        <div class="col-12 col-md-4 mt-4">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-success text-center"
                                                                data-bs-toggle="modal" data-bs-target="#customer"
                                                                data-bs-whatever="@mdo">+</button>
                                                        </div><br>
                                                        <div class="col-12 col-md-4">
                                                            <lable class="form-lable fw-bold">तारीख</lable>
                                                            <input type="date" name="sdate" id="order_date"
                                                                class="form-control mb-3"
                                                                value="<?= date('Y-m-d', strtotime($rsa['sdate'])) ?>">
                                                        </div>
                                                    </div>
                                                    <table id="invoice-item-table" class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr align="center">
                                                                <th class="text-nowrap">अनु. क्र.</th>
                                                                <th>कृती</th>
                                                                <th width="15%" class="text-start">श्रेणी</th>
                                                                <th width="20%" class="text-start">प्रॉडक्ट नाव</th>
                                                                <th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
                                                                <th>प्रमाण</th>
                                                                <th>किंमत</th>
                                                                <th>उप एकूण</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="align-middle">
                                                            <?php if ($rsa['sale_details'] && count($rsa['sale_details']) > 0): ?>
                                                            <?php foreach ($rsa['sale_details'] as $k => $sdtls): ?>
                                                            <tr align="center">
                                                                <td><?= $k + 1 ?></td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>
                                                                </td>
                                                                <td>
                                                                    <!--<input type="hidden" name="cat_id[]" value="<? //= $sdtls['cat_id'] ?>">-->
                                                                    <select class="form-select cat_id text-start"
                                                                        name="cat_id[]" required
                                                                        onchange="catProduct(this)">
                                                                        <!--onchange="changePrice(this)-->
                                                                        <option value="">श्रेणी निवडा</option>
                                                                        <?php $query = mysqli_query($connect, "select * from category_product") ?>
                                                                        <?php if ($query && mysqli_num_rows($query)): ?>
                                                                        <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                                                        <option value="<?= $row1['cat_id'] ?>"
                                                                            <?= ($sdtls['cat_id'] == $row1['cat_id']) ? 'selected' : '' ?>>
                                                                            <?= $row1['cat_name'] ?>
                                                                        </option>
                                                                        <?php endwhile ?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="sid[]"
                                                                        value="<?= $sdtls['sid'] ?>">
                                                                    <select
                                                                        class="form-select item_name text-start proid"
                                                                        name="pid[]" required
                                                                        onchange="changePrice(this)">
                                                                        <option value="">प्रॉडक्ट निवडा</option>
                                                                        <?php $query = mysqli_query($connect, "select * from product") ?>
                                                                        <?php if ($query && mysqli_num_rows($query)): ?>
                                                                        <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                                                        <option value="<?= $row1['product_id'] ?>"
                                                                            <?= ($sdtls['pid'] == $row1['product_id']) ? 'selected' : '' ?>>
                                                                            <?= $row1['product_name'] ?>
                                                                        </option>
                                                                        <?php endwhile ?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="varity[]"
                                                                        class="form-control text-center varity"
                                                                        value="<?= $sdtls['varity'] ?>" readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pqty[]"
                                                                        value="<?= $sdtls['pqty'] ?>"
                                                                        class="form-control text-center number_only item_quantity"
                                                                        oninput="allowType(event, 'number'),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pprice[]"
                                                                        value="<?= $sdtls['pprice'] ?>"
                                                                        class="form-control text-center item_price"
                                                                        oninput="allowType(event, 'decimal', 2),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="sub_total[]"
                                                                        value="<?= $sdtls['sub_total'] ?>" readonly
                                                                        class="form-control text-center final_amount">
                                                                </td>
                                                                <!--<td>-->
                                                                <!--	<button type="button" class="btn btn-sm btn-outline-<? //= $k==0 ? 'success add_row' : 'danger remove_row' ?> fw-bold text-center"><? //= $k==0 ? '+' : 'x' ?></button>-->
                                                                <!--</td>-->
                                                            </tr>
                                                            <?php endforeach ?>
                                                            <?php else: ?>
                                                            <tr align="center">
                                                                <td>1</td>
                                                                <td>
                                                                    <!--<input type="hidden" name="cat_id[]" value="<? //= $sdtls['cat_id'] ?>">-->
                                                                    <select class="form-select cat_id text-start"
                                                                        name="cat_id[]" required
                                                                        onchange="catProduct(this)">
                                                                        <!--onchange="changePrice(this)-->
                                                                        <option value="">श्रेणी निवडा</option>
                                                                        <?php $query = mysqli_query($connect, "select * from category_product") ?>
                                                                        <?php if ($query && mysqli_num_rows($query)): ?>
                                                                        <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                                                        <option value="<?= $row1['cat_id'] ?>">
                                                                            <?= $row1['cat_name'] ?>
                                                                        </option>
                                                                        <?php endwhile ?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="sid[]" value="new">
                                                                    <select
                                                                        class="form-select item_name text-start proid"
                                                                        name="pid[]" required
                                                                        onchange="changePrice(this)">
                                                                        <option value="">प्रॉडक्ट निवडा</option>
                                                                        <?php //$query = mysqli_query($connect,"select * from product") ?>
                                                                        <?php //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
                                                                        <!--<option value="<? //= $row1['product_id'] ?>">-->
                                                                        <? //= $row1['product_name'] ?>
                                                                        </option>
                                                                        <?php //endwhile ?>
                                                                        <?php //endif ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pqty[]"
                                                                        class="form-control text-center number_only item_quantity"
                                                                        oninput="allowType(event, 'number'),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pprice[]"
                                                                        class="form-control text-center item_price"
                                                                        oninput="allowType(event, 'decimal', 2),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="sub_total[]" readonly
                                                                        class="form-control text-center final_amount">
                                                                </td>

                                                            </tr>
                                                            <?php endif ?>
                                                            <tr class="total-footer">
                                                                <td colspan="6" rowspan="7"></td>
                                                                <th>
                                                                    उप एकूण
                                                                </th>
                                                                <td align="center">
                                                                    <input
                                                                        class="form-control text-center final_total_amt"
                                                                        id="final_total_amt" name="total"
                                                                        value="<?= sprintf('%0.2f', $rsa['total']) ?>"
                                                                        readonly>
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    गाडी भाडे

                                                                </th>
                                                                <td align="center">
                                                                    <input class="form-control text-center my-3"
                                                                        id="car_rental" placeholder="कार भाड्याची रक्कम"
                                                                        name="car_rental_amt"
                                                                        value="<?= sprintf('%0.2f', $rsa['car_rental_amt']) ?>"
                                                                        oninput="allowType(event, 'number'),calcTotal()">
                                                                    <input class="form-control text-center my-3"
                                                                        id="car_name" name="driver_name"
                                                                        placeholder="ड्राइवर नाव"
                                                                        value="<?= $rsa['driver_name'] ?>">
                                                                </td>
                                                                <td colspan="7" rowspan="8"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    एकूण
                                                                </th>
                                                                <td align="center">
                                                                    <input type="text"
                                                                        class="form-control text-center amt" readonly
                                                                        value="<?php echo '%0.2f', $rsa['total'] + (isset($rsa['car_rental_amt'])) ? $rsa['car_rental_amt'] : 0 ?>">
                                                                </td>

                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    तारीख
                                                                </th>
                                                                <td align="center">
                                                                    <input type="date"
                                                                        class="form-control text-center mb-2"
                                                                        id="advdate" name="advdate"
                                                                        value="<?= date('Y-m-d', strtotime($rsa['advdate'])) ?>">
                                                                    <input class="form-control text-center subadvance"
                                                                        name="amt"
                                                                        oninput="allowType(event, 'decimal'),calcTotal()"
                                                                        value="<?= sprintf('%0.2f', $rsa['amt']) ?>">
                                                                    <select name="date_paymode"
                                                                        class="form-select mt-2">
                                                                        <option value="">पेमेंट निवडा</option>
                                                                        <option
                                                                            <?= ($rsa['date_paymode'] == 'cash') ? 'selected' : '' ?>
                                                                            value="cash">रोख</option>
                                                                        <option
                                                                            <?= ($rsa['date_paymode'] == 'sbi') ? 'selected' : '' ?>
                                                                            value="sbi">आदित्य नर्सरी SBI</option>
                                                                        <option
                                                                            <?= ($rsa['date_paymode'] == 'mgb') ? 'selected' : '' ?>
                                                                            value="mgb">आदित्य नर्सरी MGB</option>
                                                                        <option
                                                                            <?= ($rsa['date_paymode'] == 'ds_bank') ? 'selected' : '' ?>
                                                                            value="ds_bank">डीएस बँक</option>
                                                                        <option
                                                                            <?= ($rsa['date_paymode'] == 'other_bank') ? 'selected' : '' ?>
                                                                            value="other_bank">इतर बँक</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>बँक व्यवहार</th>
                                                                <td colspan="1">

                                                                    <input class="form-control text-center my-3"
                                                                        id="pay_upi_amt" name="pay_upi_amt"
                                                                        oninput="allowType(event, 'decimal'),calcTotal()"
                                                                        value="<?= sprintf('%0.2f', $rsa['pay_upi_amt']) ?>">
                                                                    <select name="payment" class="form-select">
                                                                        <option value="">पेमेंट निवडा</option>
                                                                        <option
                                                                            <?= ($rsa['pay_mode'] == 'cash') ? 'selected' : '' ?>
                                                                            value="cash">रोख</option>
                                                                        <option
                                                                            <?= ($rsa['pay_mode'] == 'sbi') ? 'selected' : '' ?>
                                                                            value="sbi">आदित्य नर्सरी SBI</option>
                                                                        <option
                                                                            <?= ($rsa['pay_mode'] == 'mgb') ? 'selected' : '' ?>
                                                                            value="mgb">आदित्य नर्सरी MGB</option>
                                                                        <option
                                                                            <?= ($rsa['pay_mode'] == 'ds_bank') ? 'selected' : '' ?>
                                                                            value="ds_bank">डीएस बँक</option>
                                                                        <option
                                                                            <?= ($rsa['pay_mode'] == 'other_bank') ? 'selected' : '' ?>
                                                                            value="other_bank">इतर बँक</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    ऍडव्हान्स
                                                                </th>
                                                                <td align="center">
                                                                    <input class="form-control text-center my-3"
                                                                        id="adv" name="advance"
                                                                        oninput="allowType(event, 'decimal'),calcTotal()"
                                                                        value="<?= sprintf('%0.2f', $rsa['advance']) ?>">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    शिल्लक
                                                                </th>
                                                                <td align="center">
                                                                    <input class="form-control text-center" id="bal"
                                                                        name="balance"
                                                                        value="<?= sprintf('%0.2f', $rsa['balance']) ?>"
                                                                        readonly>
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
                                                    <input type="submit" name="sales_edit" id="create_invoice"
                                                        class="btn btn-success" value="बिल करा">
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                            <?php else: ?>
                            <h5 class="text-muted text-center">सेल्स इन्व्हॉईस मिळाले नाही</h5>
                            <?php endif ?>
                            <?php } else { ?>
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










                                                        <!-- <div class="col-12 col-md-4" id="serch_input_customer">
                                                            <label class="form-label fw-bold">ग्राहक</label>
                                                            <div class="input-group search-box" id="Search_input_fild">
                                                                <input type="text" name="customer_search"
                                                                    id="customer_search" class="form-control mb-3"
                                                                    oninput="searchCustomers()"
                                                                    placeholder="ग्राहक शोधा..." required>
                                                            </div>
                                                            <div class="search-results position-relative"
                                                                id="customer_search_results_Div">
                                                                <ul id="customer_search_results"
                                                                    class="list-group position-absolute w-100">
                                                                    <li class="list-group-item">1 | प्रभाकर नारायण पवार,
                                                                        (९५२९३५०६१४)</li>
                                                                    <li class="list-group-item">2 | प्रभाकर नारायण पवार,
                                                                        (९५२९३५०६१४)</li>
                                                                    <li class="list-group-item">3 | प्रभाकर नारायण पवार,
                                                                        (९५२९३५०६१४)</li>
                                                                    <li class="list-group-item">4 | प्रभाकर नारायण पवार,
                                                                        (९५२९३५०६१४)</li>
                                                                </ul>
                                                            </div>
                                                        </div> -->
                                                        <!-- <input type="hidden" name="customer_id" id="customer_id"> -->







                                                        <div class="col-12 col-md-4" id="serch_input_customer">
                                                            <label class="form-label fw-bold">ग्राहक</label>
                                                            <div class="input-group search-box" id="Search_input_fild">
                                                                <input type="text" name="customer_Search"
                                                                    id="customer_search" class="form-control mb-3" 
                                                                    oninput="searchCustomers(this.value)"
                                                                    placeholder="ग्राहक शोधा..." required>
                                                                <input type="hidden" name="customer_id" id="customer_id"
                                                                    required>
                                                            </div>
                                                            <div class="search-results position-relative"
                                                                id="customer_search_results_Div">
                                                            </div>
                                                        </div>

















                                                        <div class="col-12 col-md-4 mt-4">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-success text-center"
                                                                data-bs-toggle="modal" data-bs-target="#customer"
                                                                data-bs-whatever="@mdo">+</button>
                                                        </div><br>
                                                        <div class="col-12 col-md-4">
                                                            <lable class="form-lable fw-bold">तारीख</lable>
                                                            <input type="date" name="sdate" id="order_date"
                                                                class="form-control mb-3" value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                    <table id="invoice-item-table" class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr align="center">
                                                                <th class="text-nowrap">अनु. क्र.</th>
                                                                <th>कृती</th>
                                                                <th width="15%" class="text-nowrap">श्रेणी</th>
                                                                <th width="20%" class="text-start">प्रॉडक्ट नाव</th>
                                                                <th width="10%" class="text-start">प्रॉडक्ट विविधता</th>
                                                                <th>प्रमाण</th>
                                                                <th>किंमत</th>
                                                                <th>उप एकूण</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class="align-middle">
                                                            <tr align="center">
                                                                <td>1</td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-success add_row fw-bold text-center">+</button>
                                                                </td>
                                                                <td>
                                                                    <!--<input type="hidden" name="cat_id[]" value="<? //= $sdtls['cat_id'] ?>">-->
                                                                    <select class="form-select cat_id text-start"
                                                                        name="cat_id[]" required
                                                                        onchange="catProduct(this)">
                                                                        <!--onchange="changePrice(this)-->
                                                                        <option value="">श्रेणी निवडा</option>
                                                                        <?php $query = mysqli_query($connect, "select * from category_product") ?>
                                                                        <?php if ($query && mysqli_num_rows($query)): ?>
                                                                        <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                                                        <option value="<?= $row1['cat_id'] ?>">
                                                                            <?= $row1['cat_name'] ?>
                                                                        </option>
                                                                        <?php endwhile ?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <select
                                                                        class="form-select item_name text-start proid"
                                                                        name="pid[]" required
                                                                        onchange="changePrice(this)">
                                                                        <option value="">प्रॉडक्ट निवडा</option>
                                                                        <?php //$query = mysqli_query($connect,"select * from product")  //if ($query && mysqli_num_rows($query)):  while ($row1=mysqli_fetch_assoc($query)): ?>
                                                                        <!--<option value="<? //= $row1['product_id'] ?>">-->
                                                                        <? //= $row1['product_name'] ?>
                                                                        </option>
                                                                        <?php //endwhile ?>
                                                                        <?php //endif ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="varity[]"
                                                                        class="form-control text-center varity"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pqty[]"
                                                                        class="form-control text-center number_only item_quantity"
                                                                        oninput="allowType(event, 'number'),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="pprice[]"
                                                                        class="form-control text-center item_price"
                                                                        oninput="allowType(event, 'decimal', 2),calcTotal()">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="sub_total[]" readonly
                                                                        class="form-control text-center final_amount">
                                                                </td>

                                                            </tr>
                                                            <tr class="total-footer">
                                                                <td colspan="6" rowspan="7"></td>
                                                                <th>
                                                                    उप एकूण
                                                                </th>
                                                                <td align="center">
                                                                    <input class="form-control text-center tot_amt"
                                                                        id="final_total_amt" name="total" readonly>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    गाडी भाडे
                                                                </th>
                                                                <td align="center">
                                                                    <input class="form-control text-center my-3"
                                                                        id="car_rental" placeholder="कार भाड्याची रक्कम"
                                                                        name="car_rental_amt"
                                                                        oninput="allowType(event, 'number'),calcTotal()">
                                                                    <input class="form-control text-center my-3"
                                                                        id="car_name" name="driver_name"
                                                                        placeholder="ड्राइवर नाव">
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
                                                    <input type="date" class="form-control text-center mb-2"
                                                        id="advdate" name="advdate" value="<?= date('Y-m-d') ?>">
                                                    <input class="form-control text-center subadvance" name="amt"
                                                        oninput="allowType(event, 'decimal'),calcTotal()">
                                                    <select name="date_paymode" class="form-select mt-2">
                                                        <option value="">पेमेंट निवडा</option>
                                                        <option value="cash">रोख</option>
                                                        <option value="sbi">आदित्य नर्सरी SBI</option>
                                                        <option value="mgb">आदित्य नर्सरी MGB</option>
                                                        <option value="ds_bank">डीएस बँक</option>
                                                        <option value="other_bank">इतर बँक</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>बँक व्यवहार</th>
                                                <td colspan="1">

                                                    <input class="form-control text-center my-3" id="pay_upi_amt"
                                                        name="pay_upi_amt"
                                                        oninput="allowType(event, 'decimal'),calcTotal()">
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
                                            <tr>
                                                <th>
                                                    ऍडव्हान्स
                                                </th>
                                                <td align="center">
                                                    <input class="form-control text-center my-3" id="adv" name="advance"
                                                        oninput="allowType(event, 'decimal'),calcTotal()">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    शिल्लक
                                                </th>
                                                <td align="center">
                                                    <input class="form-control text-center" id="bal" name="balance"
                                                        readonly>
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
                                                <input type="submit" name="sales" id="create_invoice"
                                                    class="btn btn-success" value="बिल करा">
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
                        <div class="tab-pane fade <?= $nav_tabs['products'] ? 'show active' : '' ?>" id="pills-product"
                            role="tabpanel" aria-labelledby="pills-product-tab">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php
                                    //fetch products
                                    if (isset($_GET['pid'])) {
                                        $query_data = mysqli_query($connect, "select * from product where product_id='" . $_GET['pid'] . "'");
                                        $product_get = mysqli_fetch_assoc($query_data);
                                        ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="cat_id" class="form-label">प्रॉडक्ट श्रेणी <span
                                                            class="text-danger">*</span></label>
                                                    <select name="cat_id" id="cat_id" class="form-select">
                                                        <option selected>निवडा...</option>
                                                        <?php $getStates = mysqli_query($connect, "select * from category_product"); ?>
                                                        <?php if (mysqli_num_rows($getStates) > 0): ?>
                                                        <?php while ($stRow = mysqli_fetch_assoc($getStates)): ?>
                                                        <option value="<?= $stRow['cat_id'] ?>" <?php if ($stRow['cat_id'] == $product_get['cat_id']) {
                                                                          echo "selected";
                                                                      } ?>>
                                                            <?= $stRow['cat_name'] ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1">
                                                <button type="button" class="btn btn-sm btn-outline-success text-center"
                                                    data-bs-toggle="modal" data-bs-target="#pcat_id"
                                                    data-bs-whatever="@mdo" style="margin-top:30px">+</button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">

                                                    <label for="pname" class="form-label">प्रॉडक्ट नाव<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="product_name" class="form-control"
                                                        id="pname" placeholder="Enter प्रॉडक्ट नाव" required
                                                        value="<?php echo $product_get['product_name']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label mt-1">प्रॉडक्ट
                                                        विविधता</label><span class="text-danger">*</span>
                                                    <input id="price" type="text" name="product_varity"
                                                        class="form-control" required
                                                        value="<?php echo $product_get['product_varity']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="qty" class="form-label">प्रॉडक्ट प्रमाण<span
                                                            class="text-danger">*</span></label>
                                                    <input oninput="allowType(event, 'number')" type="text"
                                                        class="form-control" name="product_qty" id="qty"
                                                        placeholder="Enter Quantity" required
                                                        value="<?php echo $product_get['product_qty']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label mt-1">प्रॉडक किंमत</label><span
                                                        class="text-danger">*</span>
                                                    <input id="price" type="text" placeholder="Enter Price"
                                                        name="product_amount" oninput="allowType(event, 'decimal', 2)"
                                                        class="form-control" required
                                                        value="<?php echo $product_get['product_amount']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="des" class="form-label">प्रॉडक वर्णन</label>
                                                <textarea id="des" class="form-control"
                                                    name="product_info"><?php echo $product_get['product_info']; ?></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" name="product_edit"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>

                                        <a href="sales?show_products=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } else { ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-md-5">
                                                <div class="form-group">
                                                    <label for="cat_id" class="form-label">प्रॉडक्ट श्रेणी <span
                                                            class="text-danger">*</span></label>
                                                    <select name="cat_id" id="cat_id" class="form-select">
                                                        <option selected>निवडा...</option>
                                                        <?php $getStates = mysqli_query($connect, "select * from category_product"); ?>
                                                        <?php if (mysqli_num_rows($getStates) > 0): ?>
                                                        <?php while ($stRow = mysqli_fetch_assoc($getStates)): ?>
                                                        <option value="<?= $stRow['cat_id'] ?>">
                                                            <?= $stRow['cat_name'] ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1">
                                                <button type="button" class="btn btn-sm btn-outline-success text-center"
                                                    data-bs-toggle="modal" data-bs-target="#pcat_id"
                                                    data-bs-whatever="@mdo" style="margin-top:30px">+</button>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="pname" class="form-label">प्रॉडक्ट नाव<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="product_name" class="form-control"
                                                        id="pname" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label mt-1">प्रॉडक्ट
                                                        विविधता</label><span class="text-danger">*</span>
                                                    <input id="price" type="text" name="product_varity"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="qty" class="form-label">प्रॉडक्ट प्रमाण<span
                                                            class="text-danger">*</span></label>
                                                    <input oninput="allowType(event, 'number')" type="text"
                                                        class="form-control number_only" name="product_qty" id="qty"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="price" class="form-label mt-1">प्रॉडक किंमत</label><span
                                                        class="text-danger">*</span>
                                                    <input id="price" type="text"
                                                        oninput="allowType(event, 'decimal', 2)" name="product_amount"
                                                        class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <label for="des" class="form-label">प्रॉडक वर्णन</label>
                                                <textarea id="des" class="form-control" name="product_info"></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" name="product_add"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="sales?show_products=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex ">
                                    <div class="export-container-pro"></div>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                        data-bs-target="#ProfilterModal">
                                        फिल्टर
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="ProfilterModal" tabindex="-1"
                                        aria-labelledby="ProfilterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ProfilterModalLabel">फिल्टर</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="sales?show_products=true" id="product_fillter"
                                                        class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">श्रेणीनुसार फिल्टर करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
                                                            // $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT cat_name FROM category_product WHERE cat_name IS NOT NULL AND cat_name != '';";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="product_fillter_category">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["cat_name"]) . '">' . ($row["cat_name"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>







                                                        <div class="col-12">
                                                            <label class="form-label">विविधता नुसार फिल्टर करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
                                                            // $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT product_varity FROM product WHERE product_varity IS NOT NULL AND product_varity != '';";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="product_fillter_varity">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["product_varity"]) . '">' . ($row["product_varity"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button class="btn btn-outline-light border text-danger me-auto"
                                                        data-bs-dismiss="modal" onclick="unselectfillterproduct()">सर्व
                                                        फिल्टर हटवा</button>
                                                    <button type="button" class="btn btn-outline-dark border"
                                                        data-bs-dismiss="modal">बंद करा</button>
                                                    <!-- <button type="submit" form="pro-filter-form"
                                                        class="btn btn-dark">फिल्टर लागू करा</button> -->
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                                        onclick="ajaxProductData(page = 1)">फिल्टर लागू करा</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>



                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit_Product"
                                                onchange="ajaxProductData(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class=""><label>Search:<input id="Search_filter_Product" type="search"
                                                class="form-control form-control-sm" oninput="logInputValueProduct()"
                                                placeholder="" aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_product_data">

                            </div>
                        </div>
                        <!--product end-->

























                        <!--Purchase start-->
                        <div class="tab-pane fade <?= $nav_tabs['purchase'] ? 'show active' : '' ?>" id="pills-purchase"
                            role="tabpanel" aria-labelledby="pills-purchase-tab">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php
                                    if (isset($_GET['pur_id'])) {
                                        $query1 = mysqli_query($connect, "select * from purchase where purchase_id='" . $_GET['pur_id'] . "'");

                                        $row = mysqli_fetch_assoc($query1);

                                        ?>
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="cusname" class="form-label">प्रॉडक्ट नाव<span
                                                            class="text-danger">*</span></label>
                                                    <!--<input type="text" name="pname" class="form-control" id="cusname" value="<?php //echo $row['purchase_name']; ?>" placeholder="Enter प्रॉडक्ट नाव" required>-->
                                                    <select name="purchase_name" id="pur_id" class="form-select">
                                                        <option selected>निवडा...</option>
                                                        <?php $getProducts = mysqli_query($connect, "select * from product"); ?>
                                                        <?php if (mysqli_num_rows($getProducts) > 0): ?>
                                                        <?php while ($stRow = mysqli_fetch_assoc($getProducts)): ?>
                                                        <option value="<?= $stRow['product_name'] ?>" <?php if ($stRow['product_name'] == $row['purchase_name']) {
                                                                          echo "selected";
                                                                      } ?>>
                                                            <?= $stRow['product_name'] ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="" class="form-label">प्रमाण<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="pqty" id=""
                                                        oninput="allowType(event, 'number')"
                                                        value="<?php echo $row['purchase_qty']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">किंमत</label><span
                                                        class="text-danger">*</span>
                                                    <input id="" type="text" name="pprice" class="form-control"
                                                        value="<?php echo $row['purchase_price']; ?>" required
                                                        oninput="allowType(event, 'decimal', 2)">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">तयार
                                                        केले</label><span class="text-danger">*</span>
                                                    <input id="" type="date" placeholder="Enter created date"
                                                        name="pcreated" class="form-control"
                                                        value="<?php echo $row['purchase_created']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile"
                                                        class="form-label">अपेक्षित</label><span
                                                        class="text-danger">*</span>
                                                    <input id="" type="date" placeholder="Enter expected date"
                                                        name="pexpected" class="form-control"
                                                        value="<?php echo $row['purchase_expected']; ?>" required>
                                                </div>
                                            </div>
                                            <input id="pur_qty" type="hidden" name="pold_qty" class="form-control"
                                                placeholder="Total Quantity"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                readonly="" value="<?= $row['pold_qty'] ?>">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">सप्लायर
                                                        नाव</label><span class="text-danger">*</span>
                                                    <select name="supplier_name" id="cat_id" class="form-select">
                                                        <option selected>निवडा...</option>
                                                        <?php $getsup = mysqli_query($connect, "select * from supplier"); ?>
                                                        <?php if (mysqli_num_rows($getsup) > 0): ?>
                                                        <?php while ($stRow = mysqli_fetch_assoc($getsup)): ?>
                                                        <option value="<?= $stRow['supplier_name'] ?>" <?php if ($stRow['supplier_name'] == $row['supplier_name']) {
                                                                          echo "selected";
                                                                      } ?>>
                                                            <?= $stRow['supplier_name'] ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="purchase_edit"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="sales?show_purchase=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } else { ?>
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="cusname" class="form-label">प्रॉडक्ट नाव<span
                                                            class="text-danger">*</span></label>
                                                    <select name="purchase_name" id="pur_id" class="form-select">
                                                        <option selected>निवडा...</option>
                                                        <?php $getProducts = mysqli_query($connect, "select * from product"); ?>
                                                        <?php if (mysqli_num_rows($getProducts) > 0): ?>
                                                        <?php while ($stRow = mysqli_fetch_assoc($getProducts)): ?>
                                                        <option value="<?= $stRow['product_name'] ?>">
                                                            <?= $stRow['product_name'] ?>
                                                        </option>
                                                        <?php endwhile ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="Email" class="form-label">प्रमाण<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="pqty" id="pqty"
                                                        required oninput="allowType(event, 'number')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">किंमत</label><span
                                                        class="text-danger">*</span>
                                                    <input id="customer mobile" type="text" name="pprice"
                                                        oninput="allowType(event, 'decimal', 2)" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Address" class="form-label">तयार केले</label><span
                                                    class="text-danger">*</span>
                                                <input id="" type="date" placeholder="Enter date" name="pcreated"
                                                    class="form-control" required>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="" class="form-label">अपेक्षित</label><span
                                                    class="text-danger">*</span>
                                                <input id="" type="date" placeholder="Enter date" name="pexpected"
                                                    class="form-control" required>
                                            </div>
                                            <input id="pur_qty" type="hidden" name="pold_qty" class="form-control"
                                                placeholder="Total Quantity"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                readonly="">
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="" class="form-label">सप्लायर नाव</label><span
                                                    class="text-danger">*</span>
                                                <select name="supplier_name" id="cat_id" class="form-select">
                                                    <option selected>निवडा...</option>
                                                    <?php $getsup = mysqli_query($connect, "select * from supplier"); ?>
                                                    <?php if (mysqli_num_rows($getsup) > 0): ?>
                                                    <?php while ($stRow = mysqli_fetch_assoc($getsup)): ?>
                                                    <option value="<?= $stRow['supplier_name'] ?>">
                                                        <?= $stRow['supplier_name'] ?>
                                                    </option>
                                                    <?php endwhile ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" name="purchase_add"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="sales?show_purchase=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <!--purchase list-->
                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex">
                                    <div class="export-container-pur"></div>
                                </div>
                            </div>








                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="Purchase_table_Row_Limit"
                                                onchange="ajaxPurchaseData(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter_Purchase"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValuePurchase()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_Purchase_data">

                            </div>
                        </div>
                        <!--</div>-->
                        <!--Purchase end-->






















                        <!--Supplier start-->
                        <div class="tab-pane fade <?= $nav_tabs['supplier'] ? 'show active' : '' ?>" id="pills-supplier"
                            role="tabpanel" aria-labelledby="pills-supplier-tab">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php
                                    if (isset($_GET['supid'])) {
                                        $query1 = mysqli_query($connect, "select * from supplier where supplier_id='" . $_GET['supid'] . "'");

                                        $row = mysqli_fetch_array($query1);

                                        ?>
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="cusname" class="form-label">सप्लायर नाव<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="sname" class="form-control" id="cusname"
                                                        value="<?php echo $row['supplier_name']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="Email" class="form-label">ईमेल</label>
                                                    <input type="email" class="form-control" name="semail" id="Email"
                                                        value="<?php echo $row['supplier_email']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="customer mobile" class="form-label">मोबईल
                                                        नंबर</label><span class="text-danger">*</span>
                                                    <input oninput="allowType(event, 'mobile')" id="customer mobile"
                                                        type="tel" minlength="10" maxlength="10" name="smobile"
                                                        class="form-control"
                                                        value="<?php echo $row['supplier_mobno']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="store_name" class="form-label">सप्लायर दुकान नाव
                                                    </label>
                                                    <input type="text" class="form-control" name="store_name"
                                                        id="store_name" value="<?php echo $row['store_name']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Address" class="form-label">सप्लायर डेस्क्रिपशन</label>
                                                <textarea id="Address" class="form-control" placeholder=""
                                                    name="spl_info"><?php echo $row['supplier_info']; ?></textarea>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Address" class="form-label">सप्लायर ऍड्रेस</label>
                                                <textarea id="Address" class="form-control" placeholder=""
                                                    name="spl_add"><?php echo $row['supplier_address']; ?></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" name="supplier_edit"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="sales?show_supplier=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } else { ?>
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="cusname" class="form-label">सप्लायर नाव<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="sname" class="form-control" id="cusname"
                                                        required>
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
                                                    <label for="customer mobile" class="form-label">मोबईल
                                                        नंबर</label><span class="text-danger">*</span>
                                                    <input oninput="allowType(event, 'mobile')" id="customer mobile"
                                                        type="tel" minlength="10" maxlength="10" name="smobile"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <div class="form-group">
                                                    <label for="store_name" class="form-label">सप्लायर दुकान नाव <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="store_name" class="form-control"
                                                        id="store_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Address" class="form-label">सप्लायर डेस्क्रिपशन</label>
                                                <textarea class="form-control" placeholder=""
                                                    name="spl_info"></textarea>
                                            </div>
                                            <div class="col-12 col-md-6 mt-2">
                                                <label for="Address" class="form-label">सप्लायर ऍड्रेस</label>
                                                <textarea id="Address" class="form-control" placeholder=""
                                                    name="spl_add"></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" name="supplier_add"
                                            class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                        <a href="sales?show_supplier=true" class="btn btn-dark mt-3">मागे</a>
                                    </form>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex ">
                                    <div class="export-container-sup"></div>
                                    <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                                    <!--    Filters <i class="bx bx-filter"></i>-->
                                    <!--</button>-->
                                    <!-- Filter Modal -->

                                </div>
                            </div>




                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="Supplier_table_Row_Limit"
                                                onchange="ajaxSupplierData(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter_Supplier"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueSupplier()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_Supplier_data">

                            </div>
                        </div>
                        <!--supplier end-->































                        <!--sales history start-->
                        <div class="tab-pane fade <?= $nav_tabs['sale_history'] ? 'show active' : '' ?>"
                            id="pills-salesh" role="tabpanel" aria-labelledby="pills-salesh-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex mb-3 justify-content-end">
                                        <button class="btn ms-sm-2 btn-success" data-bs-toggle="modal"
                                            data-bs-target="#advsalesModal">ऍडव्हान्स</button>
                                        <div class="modal fade" id="advsalesModal" tabindex="-1"
                                            aria-labelledby="advsalesLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="advsalesModalLabel">ऍडव्हान्स</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <form method="post">
                                                                    <div class="row">
                                                                        <div class="col-12">



                                                                            <!-- name="cus_id" id="cus_id" -->

                                                                            <div class="" id="serch_input_customer">
                                                                                <label
                                                                                    class="form-label fw-bold">ग्राहक</label>
                                                                                <div class="input-group search-box"
                                                                                    id="Search_input_fild">
                                                                                    <input type="text"
                                                                                        name="customer_Search"
                                                                                        id="customer_search_advance"
                                                                                        class="form-control mb-3"
                                                                                        oninput="searchCustomersAdvance(this.value)"
                                                                                        placeholder="ग्राहक शोधा..."
                                                                                        required>
                                                                                    <input type="hidden"
                                                                                        class="form-select item_name"
                                                                                        name="cus_id" id="cus_id"
                                                                                        required>
                                                                                </div>
                                                                                <div class="search-results position-relative"
                                                                                    id="customer_search_results_Div_Advance">
                                                                                </div>
                                                                            </div>




                                                                            <script>
                                                                            function searchCustomersAdvance(value) {
                                                                                //console.log(value)
                                                                                $.ajax({
                                                                                    type: "GET",
                                                                                    url: "ajax_load_customer_data",
                                                                                    data: {
                                                                                        searchInput: value,
                                                                                        type: 'advance'
                                                                                    },
                                                                                    success: function(data) {
                                                                                        $('#customer_search_results_Div_Advance')
                                                                                            .html(data);
                                                                                    },
                                                                                    error: function(xhr, status,
                                                                                        error) {
                                                                                        console.error(
                                                                                            error);
                                                                                    }
                                                                                });
                                                                            }

                                                                            function updateCustomerSearchAdvance(ID,
                                                                                Name, Mob ,  Totle) {
                                                                                // Assuming you have the input field with id 'customer_search'
                                                                                // $('#customer_search').val(value);
                                                                                //console.log(ID, Name)
                                                                                $('#customer_search_advance').val(Name + " | " + Mob);
                                                                                $('#cus_id').val(ID);
                                                                                $('#bal_amt').val((Totle));
                                                                                $('#customer_search_results_Div_Advance')
                                                                                    .html('');

                                                                            }
                                                                            </script>




                                                                            <div class="col-12 my-3">
                                                                                <div class="form-group">
                                                                                    <input id="bal_amt" type="text"
                                                                                        name="bal_amt"
                                                                                        class="form-control"
                                                                                        placeholder="प्रलंबित रक्कम"
                                                                                        readonly
                                                                                        oninput="allowType(event, 'number')">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <input id="adv_amt" type="text"
                                                                                        name="again_adv_amt"
                                                                                        placeholder="रक्कम"
                                                                                        class="form-control"
                                                                                        oninput="allowType(event, 'number')"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group mt-3">
                                                                                    <input id="totbal" type="text"
                                                                                        name="totbal"
                                                                                        class="form-control"
                                                                                        placeholder="शिल्लक रक्कम"
                                                                                        oninput="allowType(event, 'number')"
                                                                                        required readonly>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button type="submit" name="adv_sales"
                                                                        class="btn btn-success me-2 text-white mt-3">जतन
                                                                        करा</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-3">
                                        <div class="ms-auto p-2 d-flex ">
                                            <div class="export-container-salesh">

                                            </div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                                data-bs-target="#SalesfilterModal">
                                                फिल्टर
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="SalesfilterModal" tabindex="-1"
                                                aria-labelledby="SalesfilterModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="SalesfilterModalLabel">फिल्टर
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="" id="salesHis-filter-form" class="row g-3">
                                                                <div class="col-12">
                                                                    <label class="form-label">ग्राहक ने फिल्टर
                                                                        करा</label>
                                                                    <?php
                                                                    // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                                    $sql = "SELECT DISTINCT customer_name FROM customer WHERE customer_name IS NOT NULL AND customer_name != ''";

                                                                    $result = mysqli_query($connect, $sql);

                                                                    ?>
                                                                    <select class="form-select" id="sales-customers">
                                                                        <option value="">सर्व</option>
                                                                        <?php
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . ($row["customer_name"]) . '">' . ($row["customer_name"]) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">गावा ने फिल्टर करा</label>
                                                                    <?php
                                                                    // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                                    $sql = "SELECT DISTINCT village FROM customer WHERE village IS NOT NULL AND village != ''";

                                                                    $result = mysqli_query($connect, $sql);

                                                                    ?>
                                                                    <select class="form-select" id="gav-cus">
                                                                        <option value="">सर्व</option>
                                                                        <?php
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . ($row["village"]) . '">' . ($row["village"]) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>



                                                                <div class="col-12">
                                                                    <label class="form-label">पेमेंट मोड ने फिल्टर
                                                                        करा</label>
                                                                    <?php
                                                                    // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                                    $sql = "SELECT DISTINCT pay_mode FROM sales WHERE pay_mode IS NOT NULL AND pay_mode != ''";

                                                                    $result = mysqli_query($connect, $sql);

                                                                    ?>
                                                                    <select class="form-select"
                                                                        id="sales-filter-payment-mode">
                                                                        <option value="">सर्व</option>
                                                                        <?php
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . ($row["pay_mode"]) . '">' . ($row["pay_mode"]) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">पेमेंट स्टेटस ने फिल्टर
                                                                        करा</label>
                                                                    <?php
                                                                    // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                                    $sql = "SELECT DISTINCT paystatus FROM sales WHERE paystatus IS NOT NULL AND paystatus != ''";

                                                                    $result = mysqli_query($connect, $sql);

                                                                    ?>
                                                                    <select class="form-select"
                                                                        id="sales-filter-pay-status">
                                                                        <option value="">सर्व</option>
                                                                        <?php
                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . ($row["paystatus"]) . '">' . ($row["paystatus"]) . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer border-top-0">
                                                            <button
                                                                class="btn btn-outline-light border text-danger me-auto"
                                                                data-bs-dismiss="modal"
                                                                onclick="unselectfilltersales()">सर्व
                                                                फिल्टर हटवा</button>
                                                            <button type="button" class="btn btn-outline-dark border"
                                                                data-bs-dismiss="modal">बंद करा</button>
                                                            <button type="button" class="btn btn-dark"
                                                                data-bs-dismiss="modal"
                                                                onclick="ajaxSalesHistory(page = 1)">फिल्टर लागू
                                                                करा</button>
                                                            <!-- <p  form="salesHis-filter-form" class="btn btn-dark">फिल्टर लागू करा</p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row justify-content-between d-flex">
                                        <div class=" w-auto ">
                                            <div class="dataTables_length" id="suppliertbl_length">
                                                <label
                                                    style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                                    <select name="suppliertbl_length" id="table_Row_Limit"
                                                        onchange="ajaxSalesHistory(1)" aria-controls="suppliertbl"
                                                        class="form-select form-select-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="500">500</option>
                                                        <option value="-1">All</option>
                                                    </select> entries</label>
                                            </div>
                                        </div>
                                        <div class="  w-auto">
                                            <div class="dataTables_filter"><label>Search:<input id="Search_filter"
                                                        type="search" class="form-control form-control-sm"
                                                        oninput="logInputValue()" placeholder=""
                                                        aria-controls="suppliertbl"></label></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="table_sales_history">





                                    </div>

                                </div>
                                <!--priview modal-->
                                <div class="modal fade" id="info" data-bs-backdrop="static" tabindex="-1"
                                    aria-labelledby="infoLabel" aria-hidden="true">

                                </div>

                            </div>
                        </div>
                        <!--sales history end-->



































                        <!--Customer Details start-->
                        <div class="tab-pane fade <?= $nav_tabs['cus_details'] ? 'show active' : '' ?>"
                            id="pills-cusdet" role="tabpanel" aria-labelledby="pills-cusdet-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex mb-3">
                                        <div class="ms-auto p-2 d-flex ">
                                            <div class="export-container-cus"></div>
                                        </div>
                                    </div>


                                    <div class="row justify-content-between d-flex">
                                        <div class=" w-auto ">
                                            <div class="dataTables_length" id="suppliertbl_length">
                                                <label
                                                    style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                                    <select name="suppliertbl_length" id="Customer_table_Row_Limit"
                                                        onchange="ajaxCustomerData(1)" aria-controls="suppliertbl"
                                                        class="form-select form-select-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="500">500</option>
                                                        <option value="-1">All</option>
                                                    </select> entries</label>
                                            </div>
                                        </div>
                                        <div class="  w-auto">
                                            <div class="dataTables_filter"><label>Search:<input
                                                        id="Search_filter_Customer" type="search"
                                                        class="form-control form-control-sm"
                                                        oninput="logInputValueCustomer()" placeholder=""
                                                        aria-controls="suppliertbl"></label></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="table_customer_data">

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
                                        <label for="cusname" class="form-label">ग्राहकाचे नाव<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="customer_name" class="form-control" id="cusname"
                                            placeholder="ग्राहकाचे नाव" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="Email" class="form-label">इमेल आयडी</label>
                                        <input type="email" class="form-control" name="customer_email" id="Email"
                                            placeholder="इमेल आयडी">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="customer mobile" class="form-label">मोबाईल नंबर
                                            <span class="text-danger">*</span></label>

                                        <input maxlength="10" minlength="10" id="customer mobile" type="tel"
                                            placeholder="मोबाईल नंबर" name="customer_mobno" class="form-control"
                                            required oninput="allowType(event, 'mobile')">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2 mt-2">
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

                                <div class="col-12 col-md-6 mt-2 mt-2">
                                    <div class="form-group">
                                        <label for="cusname" class="form-label">राज्य</label>
                                        <select name="state" id="state" class="form-select">
                                            <option selected>निवडा...</option>
                                            <?php $getStates = mysqli_query($connect, "select * from states"); ?>
                                            <?php if (mysqli_num_rows($getStates) > 0): ?>
                                            <?php while ($stRow = mysqli_fetch_assoc($getStates)): ?>
                                            <option value="<?= $stRow['sname'] ?>">
                                                <?= $stRow['sname'] ?>
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

                            <!--        <textarea id="Address" class="form-control" placeholder="" name="spl_info"></textarea>-->

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
                                            <option value="">प्रॉडक्ट्स निवडा</option>
                                            <?php $query = mysqli_query($connect, "select * from product") ?>
                                            <?php if ($query && mysqli_num_rows($query)): ?>
                                            <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                            <option value="<?= $row1['product_id'] ?>">
                                                <?= $row1['product_name'] ?>
                                            </option>
                                            <?php endwhile ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="col-12 my-3">
                                        <div class="form-group">
                                            <input id="aviqty" type="text" name="poqty" placeholder="शिल्लक प्रमाण"
                                                class="form-control" readonly oninput="allowType(event, 'number')">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input id="pnqty" type="text" name="pnqty" class="form-control"
                                                placeholder="संख्य" required oninput="allowType(event, 'number')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_stock" class="btn btn-success me-2 text-white mt-3">जतन
                                करा</button>
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
                                        <label for="cusname" class="form-label">प्रॉडक्ट श्रेणीचे नाव<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="cat_name" class="form-control" id="cusname" required>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" name="pro_cat_add" class="btn btn-success me-2 text-white mt-3">जतन
                                करा</button>
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
            data: {
                pqty: q
            }
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
            data: {
                balamt: b
            }
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
    const pay_upi_amt = $('#pay_upi_amt').val();
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
    $('#bal').val((gr_total - Number($('.subadvance').val()) - Number(adv) - Number(pay_upi_amt)).toFixed(2));
}

function changePrice(el) {
    const pid = el.value;
    const row = $(el).closest('tr');
    $.ajax({
        url: "ajax_master",
        method: "POST",
        dataType: 'json',
        data: {
            get_product_qty_price: pid
        },
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
        data: {
            cat_product: cat_id
        }
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
            data: {
                qty: q
            }
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
            data: {
                pqty: q
            }
        }).done(function(data) {
            $("#aviqty").val(data);
        });
    });
});

//customer state,city,village
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
<?php //include "footer.php"; ?>


<script src="https://code.jquery.com/jquery-3.6.4.min.js">
</script>
<script>
function searchCustomers(value) {
    //console.log(value)
    $.ajax({
        type: "GET",
        url: "ajax_load_customer_data",
        data: {
            searchInput: value
        },
        success: function(data) {
            $('#customer_search_results_Div').html(
                data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

function updateCustomerSearch(ID, Name , Mod  ,  Totle) {
    // Assuming you have the input field with id 'customer_search'
    // $('#customer_search').val(value);
    //console.log(ID, Name)
    $('#customer_search').val(Name +" | "+ Mod);
    $('#customer_id').val(ID);
    $('#customer_search_results_Div').html('');

}
</script>



<!-- <script>
$(document).ready(function() {
    $('#salesHis-filter-form').submit(ajaxSalesHistory())
});
</script> -->
<script>
// const loader = `<div style="width: 100%; height: 30vh; "><div  class="loaderStyles" ></div></div>`;
// const loader = "<h1>Wate for It</h1>";
function initializeDataTable(exportClass, DataTableId) {
    // Clear the export container
    $('.' + exportClass).empty();

    // Initialize DataTable
    var cusListTbl = $('#' + DataTableId).DataTable({
        dom: 'Bftip', // Buttons, search, and pagination, excluding information
        order: [
            [1, 'asc'] // Set the default order based on the second column (index 1) in ascending order
        ], // Buttons, search, and pagination, excluding information
        buttons: [{
            extend: 'collection',
            text: 'Export',
            className: 'btn-sm btn-outline-dark me-2',
            buttons: [
                'copy',
                'excel',
                'csv',
                'print'
            ]
        }],
        searching: false, // Disable search bar
        paging: false, // Disable pagination
        info: false // Disable information about the number of entries
    });

    // Move the buttons container to the specified export container
    cusListTbl.buttons().container().prependTo('.' + exportClass);
}
// document.body.innerHTML = loaderDiv;
</script>

<!-- table_sales_history -->
<script>
function ajaxSalesHistory(page = 1, search = '') {
    // Retrieve selected values from the dropdowns
    var selectedCustomer = $('#sales-customers').val();
    var selectedGav = $('#gav-cus').val();
    var selectedPaymentMode = $('#sales-filter-payment-mode').val();
    var selectedPayStatus = $('#sales-filter-pay-status').val();
    // var inuptSearch = $('#input_search').val();
    var tableRowLimit = $('#table_Row_Limit').val();

    //console.log("Selected Customer: " + selectedCustomer);
    //console.log("Selected Gav: " + selectedGav);
    //console.log("Selected Payment Mode: " + selectedPaymentMode);
    //console.log("Selected Payment Status: " + selectedPayStatus);
    //console.log("Table Row Limit: " + tableRowLimit);
    $("#table_sales_history").html(loader);
    $.ajax({
        type: "POST",
        url: "ajax_sales_history",
        data: {
            SelectedCustomer: selectedCustomer,
            SelectedGav: selectedGav,
            SelectedPaymentMode: selectedPaymentMode,
            SelectedPayStatus: selectedPayStatus,
            tableRowLimit: tableRowLimit,
            Search: search,
            page: page
        }
    }).done(function(data) {
        // //console.log("///////////////");
        $("#table_sales_history").html(data);
        initializeDataTable('export-container-salesh', '#salestbl-filter')
    });
}

// function ajaxSalesHistoryModel(ID) {
//     console.log("it woek")
//     // $("#info").html(loader);
//     $.ajax({
//         type: "POST",
//         url: "ajax_sales_history",
//         data: {
//             code: "MODEL",
//             ID: ID
//         }
//         console.log("it woek")
//     }).done(function(data) {
//         // //console.log("///////////////");
//         $("#info").html(data);
//         console.log("it woek")
//         // initializeDataTable('export-container-salesh', '#salestbl-filter')
//     });
// }
</script>
<script>
$(document).ready(function() {
    ajaxSalesHistory(1);
});
</script>
<script>
function ChangePageSales(page) {
    var inputValue = $('#Search_filter').val();
    ajaxSalesHistory(page, inputValue)
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValue() {
    var inputValue = $('#Search_filter').val();

    //console.log('Input Value:', inputValue);
    ajaxSalesHistory(1, inputValue);
}
</script>





<!--  -->
<!-- CustomerData -->
<!--  -->
<script>
function ajaxCustomerData(page = 1, search = '') {
    // Retrieve selected values from the dropdowns
    // var inuptSearch = $('#input_search').val();
    var tableRowLimit = $('#Customer_table_Row_Limit').val();
    //console.log("page data : " + page);

    //console.log("Table Row Limit: " + tableRowLimit);
    $("#table_customer_data").html(loader);
    $.ajax({
        type: "POST",
        url: "ajax_customer_data",
        data: {
            tableRowLimit: tableRowLimit,
            Search: search,
            page: page
        }
    }).done(function(data) {
        // //console.log("///////////////");
        $("#table_customer_data").html(data);

        initializeDataTable('export-container-cus', '#customertbl');
    });
}
</script>
<script>
function ChangePageCustomer(page) {
    var inputValue = $('#Search_filter_Customer').val();
    ajaxCustomerData(page, inputValue)
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValueCustomer() {
    var inputValue = $('#Search_filter_Customer').val();

    //console.log('Input Value:', inputValue);
    ajaxCustomerData(1, inputValue);
}
</script>
<script>
$(document).ready(function() {
    ajaxCustomerData(1);
});
</script>








<!--  -->
<!-- purchase Data -->
<!--  -->
<script>
function ajaxPurchaseData(page = 1, search = '') {
    // Retrieve selected values from the dropdowns
    // var inuptSearch = $('#input_search').val();
    var tableRowLimit = $('#Purchase_table_Row_Limit').val();

    //console.log("Table Row Limit: " + tableRowLimit);
    $("#table_Purchase_data").html(loader);
    $.ajax({
        type: "POST",
        url: "ajax_purchase_data",
        data: {
            tableRowLimit: tableRowLimit,
            Search: search,
            page: page
        }
    }).done(function(data) {
        //console.log("///////////////");
        $("#table_Purchase_data").html(data);

        initializeDataTable('export-container-pur', '#purchasetbl');
    });
}
</script>
<script>
function ChangePagePurchase(page) {
    var inputValue = $('#Search_filter_Purchase').val();
    ajaxPurchaseData(page, inputValue)
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValuePurchase() {
    var inputValue = $('#Search_filter_Purchase').val();

    //console.log('Input Value:', inputValue);
    ajaxPurchaseData(1, inputValue);
}
</script>
<script>
$(document).ready(function() {
    ajaxPurchaseData(1);
});
</script>








<!--  -->
<!-- Supplier Data -->
<!--  -->
<script>
function ajaxSupplierData(page = 1, search = '') {
    // Retrieve selected values from the dropdowns
    // var inuptSearch = $('#input_search').val();
    var tableRowLimit = $('#Supplier_table_Row_Limit').val();

    //console.log("Table Row Limit: " + tableRowLimit);
    $("#table_Supplier_data").html(loader);
    $.ajax({
        type: "POST",
        url: "ajax_supplier_data",
        data: {
            tableRowLimit: tableRowLimit,
            Search: search,
            page: page
        }
    }).done(function(data) {
        //console.log("///////////////");
        $("#table_Supplier_data").html(data);
        initializeDataTable('export-container-sup', '#suppliertbl');
    });
}
</script>
<script>
function ChangePageSupplier(page) {
    var inputValue = $('#Search_filter_Supplier').val();
    ajaxSupplierData(page)
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValueSupplier() {
    var inputValue = $('#Search_filter_Supplier').val();

    //console.log('Input Value:', inputValue);
    ajaxSupplierData(1, inputValue);
}
</script>
<script>
$(document).ready(function() {
    ajaxSupplierData(1);
});
</script>









<script>
function ajaxProductData(page = 1, search = '') {
    // Retrieve selected values from the dropdowns
    // var selectedCustomer = $('#sales-customers').val();
    // var selectedGav = $('#gav-cus').val();
    var selectedProductCategory = $('#product_fillter_category').val();
    var selectedProductVarity = $('#product_fillter_varity').val();
    // var inuptSearch = $('#input_search').val();
    var tableRowLimit = $('#table_Row_Limit_Product').val();

    // //console.log("Selected Customer: " + selectedCustomer);
    // //console.log("Selected Gav: " + selectedGav);
    //console.log("Selected Payment Mode: " + selectedProductCategory);
    //console.log("Selected Payment Status: " + selectedProductVarity);
    //console.log("Table Row Limit: " + tableRowLimit);
    $("#table_product_data").html(loader);
    $.ajax({
        type: "POST",
        url: "ajax_product",
        data: {
            // SelectedCustomer: selectedCustomer,
            // SelectedGav: selectedGav,
            selectedProductCategory: selectedProductCategory,
            selectedProductVarity: selectedProductVarity,
            tableRowLimit: tableRowLimit,
            Search: search,
            page: page
        }
    }).done(function(data) {
        //console.log("///////////////");
        $("#table_product_data").html(data);
        initializeDataTable('export-container-pro', '#protbl-filter');
    });
}
</script>

<script>
function ChangePageProduct(page) {
    var inputValue = $('#Search_filter_Product').val();
    ajaxProductData(page, inputValue)
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValueProduct() {
    var inputValue = $('#Search_filter_Product').val();

    //console.log('Input Value:', inputValue);
    ajaxProductData(1, inputValue);
}
</script>
<script>
$(document).ready(function() {
    ajaxProductData(1);
});
</script>
















<script>
function unselectfilltersales() {
    // //console.log("??????");
    // Example usage

    // unselectOption(['sales-customers' , 'gav-cus' ,'gav-cus' , ]);
    unselectOption('sales-customers');
    unselectOption('gav-cus');
    unselectOption('sales-filter-payment-mode');
    unselectOption('sales-filter-pay-status');


    ajaxSalesHistory(1);
}
</script>
<script>
function unselectfillterproduct() {

    unselectOption('product_fillter_category');
    unselectOption('product_fillter_varity');


    ajaxProductData(1);
}
</script>
<script>
function unselectOption(selectId) {
    $('#' + selectId).prop('selectedIndex', 0);
}
</script>

<script>
function performDelete(tableName, page = 1, checkboxSelector, ajaxCallback) {
    if (confirm('विक्री हटवा..?')) {
        // Get checked checkbox values
        var checkedValues = $(checkboxSelector + ':checked').map(function() {
            return this.value;
        }).get();

        //console.log(checkedValues);
        // Perform AJAX call
        $.ajax({
            type: 'POST',
            url: 'ajax_delete_checked_item', // Replace with your server-side script
            data: {
                checkboxValues: checkedValues,
                tableName: tableName
            },
            success: function(response) {
                // Handle the success response
                //console.log(response);
                alert(response);
                ajaxCallback(page);
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.error(error);
            }
        });
    }
}

function initializeDataTable(exportClass, DataTableId) {
    // Clear the export container
    $('.' + exportClass).empty();

    // Initialize DataTable
    var cusListTbl = $(DataTableId).DataTable({
        dom: 'Bftip', // Buttons, search, and pagination, excluding information
        order: [
            [1, 'asc'] // Set the default order based on the second column (index 1) in ascending order
        ], // Buttons, search, and pagination, excluding information
        buttons: [{
            extend: 'collection',
            text: 'Export',
            className: 'btn-sm btn-outline-dark me-2',
            buttons: [
                'copy',
                'excel',
                'csv',
                'print'
            ]
        }],
        searching: false, // Disable search bar
        paging: false, // Disable pagination
        info: false // Disable information about the number of entries
    });

    // Move the buttons container to the specified export container
    cusListTbl.buttons().container().prependTo('.' + exportClass);
}



function checkAll(masterCheckbox, multicheckitem) {
    // //console.log("Hello")
    var checkboxes = $(masterCheckbox).closest('table').find('.' + multicheckitem);
    checkboxes.prop('checked', masterCheckbox.checked);
}



// const loader = "<h1>Wate for It</h1>";
const loader = `
  <style>
    .loader {
      font-weight: bold;
      font-family: sans-serif;
      font-size: 30px;
      animation: l1 1s linear infinite alternate;
    }
    .loader:before {
      content: "Loading...";
    }
    @keyframes l1 {
      to {
        opacity: 0;
      }
    }
  </style>
  <div style="width: 100%; height: 500px; display: flex; align-items: center; justify-content: center;">
    <div class="loader"></div>
  </div>
`;

// Now you can use the 'loaderHTML' variable wherever you need it in your JavaScript code.
</script>
<!-- <script>
function searchCustomers(value) {
    // var searchInput = $('#customer_search').val();

    // Perform AJAX call to fetch search results
    $.ajax({
        type: "POST",
        url: "ajax_search_customers.php", // Replace with your server-side script
        data: {
            searchInput: value
        },
        success: function(data) {
            $('#customer_search_results_Div').html(
                data);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// // Function to set selected customer ID and display in the input
// function selectCustomer(customerId, customerName,
//     customerMobno) {
//     $('#customer_id').val(customerId);
//     $('#customer_search').val(customerName + " (" +
//         customerMobno + ")");
//     $('#customer_search_results').html(
//         ""); // Clear search results
// }
// 
</script> -->

<?php include "footer.php"; ?>