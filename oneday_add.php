<?php
require_once "config.php";
Aditya::subtitle('एक दिवसाची आवक आणि जावक');
$nav_tabs = array(
    'Inward' => false,
    'expense' => false,
    'bank' => false,
    'cash' => false,
    'income' => false,
    'usana' => false,
);
if (isset($_GET['show_inward'])) {
    $nav_tabs['Inward'] = true;
} elseif (isset($_GET['show_expense'])) {
    $nav_tabs['expense'] = true;
} elseif (isset($_GET['show_bank'])) {
    $nav_tabs['bank'] = true;
} elseif (isset($_GET['show_cash'])) {
    $nav_tabs['cash'] = true;
} elseif (isset($_GET['show_income'])) {
    $nav_tabs['income'] = true;
} elseif (isset($_GET['show_usana'])) {
    $nav_tabs['usana'] = true;
} else {
    $nav_tabs['Inward'] = true;
}

$getinward = "select * from inward order by inward_id ASC";
$inwards = mysqli_query($connect, $getinward);

$getinward_id = "select inward_id from inward";
$inwards_id = mysqli_query($connect, $getinward_id);
$_inward_id = mysqli_fetch_assoc($inwards_id);

$getexpense = "select * from expense order by inward_id ASC";
$exp = mysqli_query($connect, $getexpense);

$getbank_trans = "select * from bank_trans order by inward_id ASC";
$banktrans = mysqli_query($connect, $getbank_trans);

$getcash = "select * from cash_expenditure order by inward_id ASC";
$rescash = mysqli_query($connect, $getcash);

$getbank_inward = "select * from bank_inward order by inward_id ASC";
$resbank_inward = mysqli_query($connect, $getbank_inward);

$getborrowing = "select * from borrowing order by inward_id ASC";
$resborrowing = mysqli_query($connect, $getborrowing);

if (isset($_POST['inward_add'])) {
    escapeExtract($_POST);

    $inward = "INSERT INTO `inward`(idate,inward,inward_rs) VALUES ('$idate','$inward','$inward_rs')";

    $resinward = mysqli_query($connect, $inward) or die(mysqli_error($connect));


    if ($resinward) {
        // header('Location: customer_list?action=Success&action_msg=Customer Added');
        header('Location: oneday_add?show_inward=true&action=Success&action_msg=नवीन जोडले..!');

    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

if (isset($_POST['expense_add'])) {
    escapeExtract($_POST);

    $inward = "INSERT INTO `expense`(idate,inward,inward_rs) VALUES ('$edate','$inward','$inward_rs')";

    mysqli_query($connect, "UPDATE inward SET inward_rs=inward_rs - $inward_rs WHERE inward_id='{$_inward_id['inward_id']}'");

    $resinward = mysqli_query($connect, $inward) or die(mysqli_error($connect));


    if ($resinward) {
        header('Location: oneday_add?show_expense=true&action=Success&action_msg=नवीन जोडले..!');
        // header('Location: oneday_add?show_expense=true');
        //   exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['bank_trans_add'])) {
    escapeExtract($_POST);

    $inward = "INSERT INTO `bank_trans`(idate,inward,inward_rs) VALUES ('$edate','$inward','$inward_rs')";
    $resinward = mysqli_query($connect, $inward);
    if ($resinward) {
        header('Location: oneday_add?show_bank=true&action=Success&action_msg=नवीन जोडले..!');
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['cash_add'])) {
    escapeExtract($_POST);
    $inward = "INSERT INTO `cash_expenditure`(idate,inward,inward_rs) VALUES ('$idate','$inward','$inward_rs')";
    $resinward = mysqli_query($connect, $inward);
    if ($resinward) {
        header('Location: oneday_add?show_cash=true&action=Success&action_msg=नवीन जोडले..!');
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

if (isset($_POST['bank_inward_add'])) {
    escapeExtract($_POST);
    $inward = "INSERT INTO `bank_inward`(idate,inward,inward_rs) VALUES ('$idate','$inward','$inward_rs')";
    $resinward = mysqli_query($connect, $inward);
    if ($resinward) {
        header('Location: oneday_add?show_income=true&action=Success&action_msg=नवीन जोडले..!');
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['borrowing_add'])) {
    escapeExtract($_POST);

    $inward = "INSERT INTO `borrowing`(idate,inward,contact,inward_rs,receive_rs,receive_date) VALUES ('$edate','$one_inward','$contact','$inward_rs','$receive_rs','$receive_date')";
    $resinward = mysqli_query($connect, $inward);
    if ($resinward) {
        header('Location: oneday_add?show_usana=true&action=Success&action_msg=नवीन जोडले..!');
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

//edit
if (isset($_POST['inward_edit'])) {
    escapeExtract($_POST);
    $updateInward = mysqli_query($connect, "UPDATE inward SET idate = '$idate',
     inward = '$inward',
     inward_rs='$inward_rs' WHERE inward_id='{$_GET['inward_id']}'");
    if ($updateInward) {
        header('Location: oneday_add?show_inward=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['expense_edit'])) {
    escapeExtract($_POST);
    $updateInward = mysqli_query($connect, "UPDATE expense SET idate = '$edate',
     inward = '$inward',
     inward_rs='$inward_rs' WHERE inward_id='{$_GET['inward_id']}'");

    mysqli_query($connect, "UPDATE inward SET inward_rs=inward_rs - $inward_rs WHERE inward_id='{$_inward_id['inward_id']}'");
    if ($updateInward) {
        header('Location: oneday_add?show_expense=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['bank_trans_edit'])) {
    escapeExtract($_POST);
    $updateInward = mysqli_query($connect, "UPDATE bank_trans SET idate = '$edate',
     inward = '$inward',
     inward_rs='$inward_rs' WHERE inward_id='{$_GET['bank_id']}'");

    if ($updateInward) {
        header('Location: oneday_add?show_bank=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['cash_edit'])) {
    escapeExtract($_POST);
    $updateInward = mysqli_query($connect, "UPDATE cash_expenditure SET 
     idate = '$idate',
     inward = '$inward',
     inward_rs='$inward_rs' WHERE inward_id='{$_GET['cash_id']}'");

    if ($updateInward) {
        header('Location: oneday_add?show_cash=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['bank_inward_edit'])) {
    escapeExtract($_POST);
    $updateInward = mysqli_query($connect, "UPDATE bank_inward SET 
     idate = '$idate',
     inward = '$inward',
     inward_rs='$inward_rs' WHERE inward_id='{$_GET['bank_inward_id']}'");
    if ($updateInward) {
        header('Location: oneday_add?show_income=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
if (isset($_POST['borrowing_edit'])) {
    escapeExtract($_POST);

    $upBo = mysqli_query($connect, "UPDATE borrowing SET 
     idate = '$edate',
     inward = '$one_inward',
     contact = '$contact',
     inward_rs='$inward_rs',
     receive_rs='$receive_rs',
     receive_date='$receive_date'
     WHERE inward_id='{$_GET['bo_id']}'");

    //  mysqli_query($connect,"UPDATE borrowing SET inward_rs=inward_rs - $receive_rs WHERE inward_id='{$_GET['bo_id']}'");

    if ($upBo) {
        header('Location: oneday_add?show_usana=true&action=Success&action_msg=अपडेट केले..!');
        exit();
    } else {
        header('Location: oneday_add?action=Success&action_msg=somthing went wrong');
        exit();
    }
}


//delete
// if (isset($_GET['delete']) && isset($_GET['inward_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['inward_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE inward SET inward_status='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_inward=true&action=Success&action_msg=आवक हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_inward=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
// if (isset($_GET['delete']) && isset($_GET['ex_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['ex_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE expense SET ex_status='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_expense=true&action=Success&action_msg=आवक मधून सर्व खर्च हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_expense=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
// if (isset($_GET['delete']) && isset($_GET['bank_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['bank_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE bank_trans SET bank_status='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_bank=true&action=Success&action_msg=बँक व्यवहार खर्च एमजीबी हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_bank=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
// if (isset($_GET['delete']) && isset($_GET['cash_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['cash_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE cash_expenditure SET cash_status='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_cash=true&action=Success&action_msg=दादा व दशरथ हस्ते नगदी खर्च हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_cash=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
// if (isset($_GET['delete']) && isset($_GET['bank_inward_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['bank_inward_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE bank_inward SET bank_inward_status
// ='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_income=true&action=Success&action_msg=बँक आवक हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_income=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }

// if (isset($_GET['delete']) && isset($_GET['bo_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['bo_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE inward_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE borrowing SET bo_status='0' WHERE inward_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: oneday_add?show_usana=true&action=Success&action_msg=उसना व्यवहार हटवले..');
//         exit();
//     } else {
//         header('Location: oneday_add?show_usana=true&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
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
                            <button class="nav-link dark <?= $nav_tabs['Inward'] ? 'active' : '' ?>"
                                id="pills-inward-tab" data-bs-toggle="pill" data-bs-target="#pills-inward" type="button"
                                role="tab" aria-controls="pills-inward" aria-selected="true">आवक</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['expense'] ? 'active' : '' ?>"
                                id="pills-expense-tab" data-bs-toggle="pill" data-bs-target="#pills-expense"
                                type="button" role="tab" aria-controls="pills-expense" aria-selected="false">आवक मधून
                                सर्व खर्च </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['bank'] ? 'active' : '' ?>" id="pills-bank-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-bank" type="button" role="tab"
                                aria-controls="pills-bank" aria-selected="false">बँक व्यवहार खर्च एमजीबी</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['cash'] ? 'active' : '' ?>" id="pills-cash-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-cash" type="button" role="tab"
                                aria-controls="pills-cash" aria-selected="false">दादा व दशरथ हस्ते नगदी खर्च </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['income'] ? 'active' : '' ?>"
                                id="pills-income-tab" data-bs-toggle="pill" data-bs-target="#pills-income" type="button"
                                role="tab" aria-controls="pills-income" aria-selected="false">बँक आवक </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link dark <?= $nav_tabs['usana'] ? 'active' : '' ?>" id="pills-usana-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-usana" type="button" role="tab"
                                aria-controls="pills-usana" aria-selected="false">उसना व्यवहार </button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">

                        <!--inward start-->
                        <div class="tab-pane fade <?= $nav_tabs['Inward'] ? 'show active' : '' ?>" id="pills-inward"
                            role="tabpanel" aria-labelledby="pills-inward-tab">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <?php
                                    if (isset($_GET['inward_id'])) {
                                        $getInward = mysqli_query($connect, "SELECT * FROM inward WHERE inward_id={$_GET['inward_id']}");
                                        $rowInward = mysqli_fetch_assoc($getInward);
                                        extract($rowInward);
                                        ?>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= $idate; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">आवक</label>
                                                        <input type="text" class="form-control" name="inward" id="inward"
                                                            value="<?= $inward ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')"
                                                            value="<?= $inward_rs ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="inward_edit"
                                                class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    <?php } else { ?>
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">आवक</label>
                                                        <input type="text" class="form-control" name="inward" id="inward">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="inward_add"
                                                class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    <?php } ?>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="ms-auto p-2 d-flex export-container">
                                        <div class="export-container1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-between d-flex">
                                    <div class=" w-auto ">
                                        <div class="dataTables_length" id="suppliertbl_length">
                                            <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                                <select name="suppliertbl_length" id="table_Row_Limit1"
                                                    onchange="ajaxInward(1)" aria-controls="suppliertbl"
                                                    class="form-select form-select-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="500">500</option>
                                                    <option value="-1">All</option>
                                                </select> entries</label>ṅ
                                        </div>
                                    </div>
                                    <div class="  w-auto">
                                        <div class="dataTables_filter"><label>Search:<input id="Search_filter1"
                                                    type="search" class="form-control form-control-sm"
                                                    oninput="logInputValueCustomer()" placeholder=""
                                                    aria-controls="suppliertbl"></label></div>
                                    </div>
                                </div>
                                <div class="table-responsive" id="table_data1">

                                </div>
                            </div>

                        </div>
                        <!--inward end-->




                        <!--expense start-->


                        <div class="tab-pane fade <?= $nav_tabs['expense'] ? 'show active' : '' ?>" id="pills-expense"
                            role="tabpanel" aria-labelledby="pills-expense-tab">
                            <?php
                            if (isset($_GET['inward_id'])) {
                                $getInward = mysqli_query($connect, "SELECT * FROM expense WHERE inward_id={$_GET['inward_id']}");
                                $rowInward = mysqli_fetch_assoc($getInward);
                                extract($rowInward);
                                ?>
                                <form method="post">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="date" class="form-label">तारीख<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="edate" class="form-control" id="date"
                                                    value="<?= $idate ?>" required>
                                            </div>
                                        </div>
                                        <?php
                                        error_reporting(0);
                                        $getinward_id1 = "select * from inward";
                                        $inwards_id1 = mysqli_query($connect, $getinward_id1);
                                        $_inward_id1 = mysqli_fetch_assoc($inwards_id1);

                                        $getIn = mysqli_query($connect, "SELECT SUM(inward_rs) as totirs,idate FROM inward WHERE idate='{$_inward_id1['idate']}'");
                                        $rowIn = mysqli_fetch_assoc($getIn);

                                        ?>
                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label for="inward" class="form-label">आवक मधून सर्व खर्च </label>
                                                <input type="text" class="form-control" name="inward" id="inward"
                                                    value=<?= $rowIn['totirs'] ?>>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mt-2">
                                            <div class="form-group">
                                                <label for="inward_rs" class="form-label">रुपये <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="inward_rs" required
                                                    id="inward_rs" value="<?= $inward_rs ?>"
                                                    oninput="allowType(event,'number')">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="expense_edit"
                                        class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                    <a href="oneday_list?date=<?= date('Y-m-d') ?>" class="btn btn-dark mt-3">मागे</a>
                                </form>
                            <?php } else { ?>
                                <form method="post">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="date" class="form-label">तारीख<span
                                                        class="text-danger">*</span></label>
                                                <input type="date" name="edate" class="form-control" id="date"
                                                    value="<?= date('Y-m-d') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label for="inward" class="form-label">आवक मधून सर्व खर्च</label>
                                                <input type="text" class="form-control" name="inward" id="inward">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="inward_rs" class="form-label">रुपये <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="inward_rs" required
                                                    id="inward_rs" oninput="allowType(event,'number')">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="expense_add"
                                        class="btn btn-success me-2 text-white mt-3">Submit</button>
                                    <a href="oneday_list?date=<?= date('Y-m-d') ?>" class="btn btn-dark mt-3">मागे</a>
                                </form>
                            <?php } ?>
                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex ">
                                    <div class="export-container2">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit2"
                                                onchange="ajaxExpense(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>ṅ
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter2"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueCustomer()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_data2">

                            </div>
                        </div>
                        <!--expense end-->



                        <!--bank start-->
                        <div class="tab-pane fade <?= $nav_tabs['bank'] ? 'show active' : '' ?>" id="pills-bank"
                            role="tabpanel" aria-labelledby="pills-bank-tab">
                            <?php
                            if (isset($_GET['bank_id'])) {
                                $getBank = mysqli_query($connect, "SELECT * FROM `bank_trans` WHERE inward_id='{$_GET['bank_id']}'");
                                $rowBank = mysqli_fetch_assoc($getBank);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="edate" class="form-control" id="date"
                                                            value="<?= $rowBank['idate'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">बँक व्यवहार खर्च
                                                            एमजीबी</label>
                                                        <input type="text" class="form-control" name="inward" id="inward"
                                                            value="<?= $rowBank['inward'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" value="<?= $rowBank['inward_rs'] ?>"
                                                            oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="bank_trans_edit"
                                                class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="edate" class="form-control" id="date"
                                                            value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">बँक व्यवहार खर्च
                                                            एमजीबी</label>
                                                        <input type="text" class="form-control" name="inward" id="inward">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="bank_trans_add"
                                                class="btn btn-success me-2 text-white mt-3">Submit</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex export-container">
                                    <div class="export-container3">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit3"
                                                onchange="ajaxBank(1)" aria-controls="suppliertbl"
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
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter3"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueCustomer()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_data3">

                            </div>


                        </div>
                        <!--bank end-->




                        <!--cash start-->
                        <div class="tab-pane fade <?= $nav_tabs['cash'] ? 'show active' : '' ?>" id="pills-cash"
                            role="tabpanel" aria-labelledby="pills-cash-tab">
                            <?php
                            if (isset($_GET['cash_id'])) {
                                $getcash = mysqli_query($connect, "SELECT * FROM `cash_expenditure` WHERE inward_id='{$_GET['cash_id']}'");
                                $rowcash = mysqli_fetch_assoc($getcash);
                                ?>

                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= $rowcash['idate'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">दादा व दशरथ हस्ते नगदी खर्च
                                                        </label>
                                                        <input type="text" class="form-control" name="inward" id="inward"
                                                            value="<?= $rowcash['inward'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" value="<?= $rowcash['inward_rs'] ?>"
                                                            oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="cash_edit"
                                                class="btn btn-success me-2 text-white mt-3">Submit</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">दादा व दशरथ हस्ते नगदी खर्च
                                                        </label>
                                                        <input type="text" class="form-control" name="inward" id="inward">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="cash_add"
                                                class="btn btn-success me-2 text-white mt-3">Submit</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex export-container">
                                    <div class="export-container4">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit4"
                                                onchange="ajaxCash(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>ṅ
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter4"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueCustomer()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_data4">



                            </div>
                        </div>
                        <!--cash end-->



                        <!--income start-->
                        <div class="tab-pane fade <?= $nav_tabs['income'] ? 'show active' : '' ?>" id="pills-income"
                            role="tabpanel" aria-labelledby="pills-income-tab">
                            <?php
                            if (isset($_GET['bank_inward_id'])) {
                                $getBankInward = mysqli_query($connect, "SELECT * FROM `bank_inward` WHERE inward_id='{$_GET['bank_inward_id']}'");
                                $rowBinward = mysqli_fetch_assoc($getBankInward);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= $rowBinward['idate'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">बँक आवक </label>
                                                        <input type="text" class="form-control" name="inward" id="inward"
                                                            value="<?= $rowBinward['inward'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')"
                                                            value="<?= $rowBinward['inward_rs'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="bank_inward_edit"
                                                class="btn btn-success me-2 text-white mt-3">Submit</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="idate" class="form-control" id="date"
                                                            value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">बँक आवक </label>
                                                        <input type="text" class="form-control" name="inward" id="inward">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="inward_rs" required
                                                            id="inward_rs" oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="bank_inward_add"
                                                class="btn btn-success me-2 text-white mt-3">Submit</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex export-container">
                                    <div class="export-container5">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit5"
                                                onchange="ajaxIncome(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>ṅ
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter5"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueCustomer()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_data5">


                            </div>
                        </div>
                        <!--income end-->




                        <!--usana start-->
                        <div class="tab-pane fade <?= $nav_tabs['usana'] ? 'show active' : '' ?>" id="pills-usana"
                            role="tabpanel" aria-labelledby="pills-usana-tab">
                            <?php
                            if (isset($_GET['bo_id'])) {
                                $getBo = mysqli_query($connect, "SELECT * FROM `borrowing` WHERE inward_id='{$_GET['bo_id']}'");
                                $rowBo = mysqli_fetch_assoc($getBo);
                                ?>

                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="edate" class="form-control" id="date"
                                                            value="<?= $rowBo['idate'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">नाव</label>
                                                        <input type="text" class="form-control" name="one_inward"
                                                            id="inward" required value="<?= $rowBo['inward'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="receive_rs" class="form-label">प्राप्त तारीख</label>
                                                        <input type="date" class="form-control" name="receive_date"
                                                            id="receive_rs" value="<?= $rowBo['receive_date'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="contact" class="form-label">मोबाईल</label>
                                                        <input type="tel" class="form-control" name="contact" id="contact"
                                                            minlength="10" maxlength="10"
                                                            oninput="allowType(event,'mobile')"
                                                            value="<?= $rowBo['contact'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये</label>
                                                        <input type="text" class="form-control" name="inward_rs"
                                                            id="inward_rs" required oninput="allowType(event,'number')"
                                                            value="<?= $rowBo['inward_rs'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="receive_rs" class="form-label">प्राप्त रुपये</label>
                                                        <input type="text" class="form-control" name="receive_rs"
                                                            id="receive_rs" oninput="allowType(event,'number')"
                                                            value="<?= $rowBo['receive_rs'] ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="borrowing_edit"
                                                class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="date" class="form-label">तारीख<span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" name="edate" class="form-control" id="date"
                                                            value="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">

                                                    <div class="form-group">
                                                        <label for="inward" class="form-label">नाव</label>
                                                        <input type="text" class="form-control" name="one_inward"
                                                            id="inward" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="receive_rs" class="form-label">प्राप्त तारीख</label>
                                                        <input type="date" class="form-control" name="receive_date"
                                                            id="receive_rs">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="contact" class="form-label">मोबाईल</label>
                                                        <input type="tel" class="form-control" name="contact" id="contact"
                                                            minlength="10" maxlength="10"
                                                            oninput="allowType(event,'mobile')">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="inward_rs" class="form-label">रुपये</label>
                                                        <input type="text" class="form-control" name="inward_rs"
                                                            id="inward_rs" required oninput="allowType(event,'number')">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-4 mt-2">
                                                    <div class="form-group">
                                                        <label for="receive_rs" class="form-label">प्राप्त रुपये</label>
                                                        <input type="text" class="form-control" name="receive_rs"
                                                            id="receive_rs" oninput="allowType(event,'number')">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" name="borrowing_add"
                                                class="btn btn-success me-2 text-white mt-3">जतन करा</button>
                                            <a href="oneday_list?date=<?= date('Y-m-d') ?>"
                                                class="btn btn-dark mt-3">मागे</a>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="d-flex mb-3">
                                <div class="ms-auto p-2 d-flex export-container-usna">
                                    <div class="export-container6"></div>
                                </div>
                            </div>
                            <div class="row justify-content-between d-flex">
                                <div class=" w-auto ">
                                    <div class="dataTables_length" id="suppliertbl_length">
                                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                            <select name="suppliertbl_length" id="table_Row_Limit6"
                                                onchange="ajaxUsana(1)" aria-controls="suppliertbl"
                                                class="form-select form-select-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="500">500</option>
                                                <option value="-1">All</option>
                                            </select> entries</label>ṅ
                                    </div>
                                </div>
                                <div class="  w-auto">
                                    <div class="dataTables_filter"><label>Search:<input id="Search_filter6"
                                                type="search" class="form-control form-control-sm"
                                                oninput="logInputValueCustomer()" placeholder=""
                                                aria-controls="suppliertbl"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive" id="table_data6">


                            
                            </div>
                        </div>
                        <!--usana end-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<script src="assets/js/new_function.js"></script>
<!--     --    -- --     --      -->





<!-- inward js -->
<script>
    function ajaxInward(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit1').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data1").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'INWARD',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data1").html(data);
            initializeDataTable('export-container1', '#E1');
        });
    }

    function ChangePage1(page) {
        var inputValue = $('#Search_filter1').val();
        ajaxInward(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter1').val();
        // //console.log('Input Value:', inputValue);
        ajaxInward(1, inputValue);
    }

    $(document).ready(function () {
        ajaxInward(1);
    });
</script>






<!-- expense Js  2-->
<script>
    function ajaxExpense(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit2').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data2").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'EXPENSE',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data2").html(data);
            initializeDataTable('export-container2', '#E2');
        });
    }

    function ChangePage(page) {
        var inputValue = $('#Search_filter2').val();
        ajaxExpense(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter2').val();
        // //console.log('Input Value:', inputValue);
        ajaxExpense(1, inputValue);
    }

    $(document).ready(function () {
        ajaxExpense(1);
    });
</script>




<!-- bank JS -->
<script>
    function ajaxBank(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit3').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data3").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'BANK',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data3").html(data);
            initializeDataTable('export-container3', '#E3');
        });
    }

    function ChangePage3(page) {
        var inputValue = $('#Search_filter3').val();
        ajaxBank(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter3').val();
        // //console.log('Input Value:', inputValue);
        ajaxBank(1, inputValue);
    }

    $(document).ready(function () {
        ajaxBank(1);
    });
</script>




<!-- cash JS -->
<script>
    function ajaxCash(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit4').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data4").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'CASH',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data4").html(data);
            initializeDataTable('export-container4', '#E4');
        });
    }

    function ChangePage4(page) {
        var inputValue = $('#Search_filter4').val();
        ajaxCash(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter4').val();
        // //console.log('Input Value:', inputValue);
        ajaxCash(1, inputValue);
    }

    $(document).ready(function () {
        ajaxCash(1);
    });
</script>





<!-- income JS -->
<script>
    function ajaxIncome(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit5').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data5").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'INCOME',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data5").html(data);
            initializeDataTable('export-container5', '#E5');
        });
    }

    function ChangePage5(page) {
        var inputValue = $('#Search_filter5').val();
        ajaxIncome(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter5').val();
        // //console.log('Input Value:', inputValue);
        ajaxIncome(1, inputValue);
    }

    $(document).ready(function () {
        ajaxIncome(1);
    });
</script>





<!-- usana JS -->
<script>
    function ajaxUsana(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit6').val();




        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data6").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_oneday_add",
            data: {
                code: 'USANA',
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data6").html(data);
            initializeDataTable('export-container6', '#E6');
        });
    }

    function ChangePage6(page) {
        var inputValue = $('#Search_filter6').val();
        ajaxUsana(page, inputValue)
    }

    function logInputValueCustomer() {
        var inputValue = $('#Search_filter6').val();
        // //console.log('Input Value:', inputValue);
        ajaxUsana(1, inputValue);
    }

    $(document).ready(function () {
        ajaxUsana(1);
    });
</script>