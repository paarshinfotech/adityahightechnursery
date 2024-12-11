<?php
require_once "config.php";

$emty_table = <<<HTML
<table border="1" id="salestbl-filter" class="table table-striped table-bordered table-hover multicheck-container">
<thead>
                    <tr>
                        <th>
<div class="d-inline-flex align-items-center select-all">
    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
    <div class="dropdown">

    </div>
</div>
<?php //endif ?>
</th>

<th>तारीख</th>
<th>नाव</th>
<!-- <th>मोबाईल</th> -->
<th>रुपये</th>
<!-- <th>प्राप्त तारीख</th> -->
<!-- <th>प्राप्त रुपये</th> -->
</tr>
</thead>
<tbody>
    <tr>
        <td colspan="14" class=" text-center"> No Data Found </td>
    </tr>
</tbody>
</table>
HTML;
// echo $emty_table;
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

<?php if ($_POST['code'] === 'INWARD') { ?>

<?php
                $SQL_Filter_Query = '';

                if (!empty($_POST['Search'])) {
                    $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
                }

                // if (!empty($_POST['village'])) {
                //     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
                // }
        
                $sql = "SELECT COUNT(*) AS total_rows from inward WHERE inward_status='1' " . $SQL_Filter_Query . " ;";

                // Execute the query
                $result = mysqli_query($connect, $sql);

                $row = mysqli_fetch_assoc($result);

                // Access the total rows count
                $totalRows = $row['total_rows'];
                // Check for errors
                if (($totalRows < 1)) {
                    echo ($emty_table);
                } else {

                    // echo "Total Rows: " . $totalRows;
        

                    $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
                    $page = mysqli_real_escape_string($connect, $_POST['page']);

                    $pages = ceil($totalRows / $tableLimit);
                    if ($page > $pages) {
                        $page = $pages;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    $onpage = $page;
                    $offsetFrom = ($page - 1) * $tableLimit;

                    $SQL_ROW_Query = '';
                    if ($tableLimit > 0) {
                        $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
                    }
                    // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;
        
                    ?>



<table border="1" id="E1" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item1')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('INWARD', 1, '#delete_check_box1', ajaxInward)">
                                    <i class="btn-round bx bx-trash me-2"></i>आवक
                                    हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>
            <th>तारीख</th>
            <th>आवक</th>
            <th>रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from inward WHERE inward_status='1' " . $SQL_Filter_Query . " ORDER BY inward_id DESC " . $SQL_ROW_Query . " ;") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                            extract($brand);
                                            ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item1" id="delete_check_box1"
                    name="inward_id[]" value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>

            <td>
                <a class="text-decoration-none" href="?show_inward=true&inward_id=<?= $inward_id; ?>">
                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_inward=true&inward_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $gettotal = mysqli_query($connect, "SELECT SUM(inward_rs) as tot FROM inward where inward_status='1'");
                            $total = mysqli_fetch_assoc($gettotal);
                            ?>
    <tr>
        <th colspan="3" class="text-center fs-6">एकूण</th>
        <th>₹
            <?= $total['tot'] ?>/-
        </th>
    </tr>
</table>




<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage1(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">


        </div>
        <!-- <li class="paginate_button page-item previous ">
                        <a href="#" class="page-link">Prev</a>
                    </li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                        // Adjust this number based on your preference
                                        $ellipsisText = '…';

                                        // Generate Prev button
                                        if ($onpage > 1) {
                                            echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                            echo '<a href="#" onclick="ChangePage1(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                            echo '</li>';
                                        }

                                        // Generate First Page button
                                        if ($onpage > 3) {
                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage1(1)" class="page-link">1</a>';
                                            echo '</li>';

                                            if ($onpage > 4) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }
                                        }

                                        // Generate page links
                                        for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                            if ($i == $onpage) {
                                                echo '<li class="paginate_button page-item active">';
                                                echo '<span class="page-link">' . $i . '</span>';
                                                echo '</li>';
                                            } else {
                                                echo '<li class="paginate_button page-item">';
                                                echo '<a href="#" onclick="ChangePage1(' . $i . ')" class="page-link">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                        }

                                        // Generate ellipsis after the active page
                                        // if ($onpage + 2 < $pages) {
                                        //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                        // }
                            
                                        // Generate Last Page button
                                        if ($onpage < $pages - 1) {
                                            if ($onpage < $pages - 2) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }

                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage1(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                            echo '</li>';
                                        }

                                        // Generate Next button
                                        if ($onpage < $pages) {
                                            echo '<li class="paginate_button page-item next" id="custbl_next">';
                                            echo '<a href="#" onclick="ChangePage1(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                            echo '</li>';
                                        }
                                        ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>




<?php if ($_POST['code'] === 'EXPENSE') { ?>

<?php
                $SQL_Filter_Query = '';

                if (!empty($_POST['Search'])) {
                    $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
                }

                // if (!empty($_POST['village'])) {
//     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
// }
        
                $sql = "SELECT COUNT(*) AS total_rows from expense WHERE ex_status='1' " . $SQL_Filter_Query . " ;";

                // Execute the query
                $result = mysqli_query($connect, $sql);

                $row = mysqli_fetch_assoc($result);

                // Access the total rows count
                $totalRows = $row['total_rows'];
                // Check for errors
                if (($totalRows < 1)) {
                    echo ($emty_table);
                } else {

                    // echo "Total Rows: " . $totalRows;
        

                    $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
                    $page = mysqli_real_escape_string($connect, $_POST['page']);

                    $pages = ceil($totalRows / $tableLimit);
                    if ($page > $pages) {
                        $page = $pages;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    $onpage = $page;
                    $offsetFrom = ($page - 1) * $tableLimit;

                    $SQL_ROW_Query = '';
                    if ($tableLimit > 0) {
                        $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
                    }
                    // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;
        
                    ?>




<table border="1" id="E2" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item2')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('EXPENSE', 1, '#delete_check_box2', ajaxExpense)">
                                    <i class="btn-round bx bx-trash me-2"></i>आवक मधून
                                    सर्व खर्च हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>
            <th>तारीख</th>
            <th>आवक मधून सर्व खर्च</th>
            <th>रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from expense WHERE ex_status='1' " . $SQL_Filter_Query . " ORDER BY inward_id DESC " . $SQL_ROW_Query . " ;") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                            extract($brand);
                                            ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item2" id="delete_check_box2" name="ex_id[]"
                    value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>

            <td>
                <a class="text-decoration-none" href="?show_expense=true&inward_id=<?= $inward_id; ?>">

                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_expense=true&inward_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $gettotal = mysqli_query($connect, "SELECT SUM(inward_rs) as totexpense FROM expense where ex_status='1'");
                            $totaltotexpense = mysqli_fetch_assoc($gettotal);
                            ?>
    <tr>
        <th colspan="3" class="text-center fs-6">एकूण</th>
        <th class="text-nowrap">₹
            <?= $totaltotexpense['totexpense'] ?>/-
        </th>

    </tr>
</table>




<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage2(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">

        </div>
        <!-- <li class="paginate_button page-item previous ">
                <a href="#" class="page-link">Prev</a>
            </li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                        // Adjust this number based on your preference
                                        $ellipsisText = '…';

                                        // Generate Prev button
                                        if ($onpage > 1) {
                                            echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                            echo '<a href="#" onclick="ChangePage2(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                            echo '</li>';
                                        }

                                        // Generate First Page button
                                        if ($onpage > 3) {
                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage2(1)" class="page-link">1</a>';
                                            echo '</li>';

                                            if ($onpage > 4) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }
                                        }

                                        // Generate page links
                                        for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                            if ($i == $onpage) {
                                                echo '<li class="paginate_button page-item active">';
                                                echo '<span class="page-link">' . $i . '</span>';
                                                echo '</li>';
                                            } else {
                                                echo '<li class="paginate_button page-item">';
                                                echo '<a href="#" onclick="ChangePage2(' . $i . ')" class="page-link">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                        }

                                        // Generate ellipsis after the active page
                                        // if ($onpage + 2 < $pages) {
                                        //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                        // }
                            
                                        // Generate Last Page button
                                        if ($onpage < $pages - 1) {
                                            if ($onpage < $pages - 2) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }

                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage2(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                            echo '</li>';
                                        }

                                        // Generate Next button
                                        if ($onpage < $pages) {
                                            echo '<li class="paginate_button page-item next" id="custbl_next">';
                                            echo '<a href="#" onclick="ChangePage2(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                            echo '</li>';
                                        }
                                        ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>



<?php if ($_POST['code'] === 'BANK') { ?>

<?php
                $SQL_Filter_Query = '';

                if (!empty($_POST['Search'])) {
                    $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
                }

                // if (!empty($_POST['village'])) {
//     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
// }
        
                $sql = "SELECT COUNT(*) AS total_rows from bank_trans WHERE bank_status='1' " . $SQL_Filter_Query . " ;";

                // Execute the query
                $result = mysqli_query($connect, $sql);

                $row = mysqli_fetch_assoc($result);

                // Access the total rows count
                $totalRows = $row['total_rows'];
                // Check for errors
                if (($totalRows < 1)) {
                    echo ($emty_table);
                } else {

                    // echo "Total Rows: " . $totalRows;
        

                    $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
                    $page = mysqli_real_escape_string($connect, $_POST['page']);

                    $pages = ceil($totalRows / $tableLimit);
                    if ($page > $pages) {
                        $page = $pages;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    $onpage = $page;
                    $offsetFrom = ($page - 1) * $tableLimit;

                    $SQL_ROW_Query = '';
                    if ($tableLimit > 0) {
                        $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
                    }
                    // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;
        
                    ?>








<table border="1" id="E3" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item3')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('BANK', 1, '#delete_check_box3', ajaxBank)">
                                    <i class="btn-round bx bx-trash me-2"></i>बँक
                                    व्यवहार खर्च एमजीबी हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>

            <th>तारीख</th>
            <th>बँक व्यवहार खर्च एमजीबी</th>
            <th>रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from bank_trans WHERE bank_status='1' " . $SQL_Filter_Query . " ORDER BY inward_id DESC " . $SQL_ROW_Query . " ;") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                            extract($brand);
                                            ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item3 " id="delete_check_box3"
                    name="bank_id[]" value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>
            <td>
                <a class="text-decoration-none" href="?show_bank=true&bank_id=<?= $inward_id; ?>">

                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_bank=true&bank_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $gettotal = mysqli_query($connect, "SELECT SUM(inward_rs) as totbank FROM bank_trans WHERE bank_status='1'");
                            $totalbaktrans = mysqli_fetch_assoc($gettotal);
                            ?>
    <tr>
        <th colspan="3" class="text-center fs-6">एकूण</th>
        <th class="text-nowrap">₹
            <?= $totalbaktrans['totbank'] ?>/-
        </th>

    </tr>
</table>

<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage3(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">

        </div>
        <!-- <li class="paginate_button page-item previous ">
        <a href="#" class="page-link">Prev</a>
    </li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                        // Adjust this number based on your preference
                                        $ellipsisText = '…';

                                        // Generate Prev button
                                        if ($onpage > 1) {
                                            echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                            echo '<a href="#" onclick="ChangePage3(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                            echo '</li>';
                                        }

                                        // Generate First Page button
                                        if ($onpage > 3) {
                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage3(1)" class="page-link">1</a>';
                                            echo '</li>';

                                            if ($onpage > 4) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }
                                        }

                                        // Generate page links
                                        for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                            if ($i == $onpage) {
                                                echo '<li class="paginate_button page-item active">';
                                                echo '<span class="page-link">' . $i . '</span>';
                                                echo '</li>';
                                            } else {
                                                echo '<li class="paginate_button page-item">';
                                                echo '<a href="#" onclick="ChangePage3(' . $i . ')" class="page-link">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                        }

                                        // Generate ellipsis after the active page
                                        // if ($onpage + 2 < $pages) {
                                        //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                        // }
                            
                                        // Generate Last Page button
                                        if ($onpage < $pages - 1) {
                                            if ($onpage < $pages - 2) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }

                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage3(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                            echo '</li>';
                                        }

                                        // Generate Next button
                                        if ($onpage < $pages) {
                                            echo '<li class="paginate_button page-item next" id="custbl_next">';
                                            echo '<a href="#" onclick="ChangePage3(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                            echo '</li>';
                                        }
                                        ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>


<?php if ($_POST['code'] === 'CASH') { ?>

<?php
                $SQL_Filter_Query = '';

                if (!empty($_POST['Search'])) {
                    $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
                }

                // if (!empty($_POST['village'])) {
//     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
// }
        
                $sql = "SELECT COUNT(*) AS total_rows from cash_expenditure WHERE cash_status='1' " . $SQL_Filter_Query . " ;";

                // Execute the query
                $result = mysqli_query($connect, $sql);

                $row = mysqli_fetch_assoc($result);

                // Access the total rows count
                $totalRows = $row['total_rows'];
                // Check for errors
                if (($totalRows < 1)) {
                    echo ($emty_table);
                } else {

                    // echo "Total Rows: " . $totalRows;
        

                    $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
                    $page = mysqli_real_escape_string($connect, $_POST['page']);

                    $pages = ceil($totalRows / $tableLimit);
                    if ($page > $pages) {
                        $page = $pages;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    $onpage = $page;
                    $offsetFrom = ($page - 1) * $tableLimit;

                    $SQL_ROW_Query = '';
                    if ($tableLimit > 0) {
                        $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
                    }
                    // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;
        
                    ?>








<table border="1" id="E4" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item4')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('CASH', 1, '#delete_check_box4', ajaxBank)">
                                    <i class="btn-round bx bx-trash me-2"></i>दादा व
                                    दशरथ हस्ते नगदी खर्च हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>

            <th>तारीख</th>
            <th>दादा व दशरथ हस्ते नगदी खर्च </th>
            <th>रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from cash_expenditure WHERE cash_status='1' " . $SQL_Filter_Query . " ORDER BY inward_id DESC " . $SQL_ROW_Query . " ;") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                            extract($brand);
                                            ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item4" id="delete_check_box4"
                    name="cash_id[]" value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>

            <td>
                <a class="text-decoration-none" href="?show_cash=true&cash_id=<?= $inward_id; ?>">

                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_cash=true&cash_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $gettotal = mysqli_query($connect, "SELECT SUM(inward_rs) as totcash FROM cash_expenditure WHERE cash_status='1'");
                            $totalcash = mysqli_fetch_assoc($gettotal);
                            ?>
    <tr>
        <th colspan="3" class="text-center fs-6">एकूण</th>
        <th class="text-nowrap">₹
            <?= $totalcash['totcash'] ?>/-
        </th>

    </tr>
</table>

<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage4(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">

        </div>
        <!-- <li class="paginate_button page-item previous ">
<a href="#" class="page-link">Prev</a>
</li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                        // Adjust this number based on your preference
                                        $ellipsisText = '…';

                                        // Generate Prev button
                                        if ($onpage > 1) {
                                            echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                            echo '<a href="#" onclick="ChangePage4(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                            echo '</li>';
                                        }

                                        // Generate First Page button
                                        if ($onpage > 3) {
                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage4(1)" class="page-link">1</a>';
                                            echo '</li>';

                                            if ($onpage > 4) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }
                                        }

                                        // Generate page links
                                        for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                            if ($i == $onpage) {
                                                echo '<li class="paginate_button page-item active">';
                                                echo '<span class="page-link">' . $i . '</span>';
                                                echo '</li>';
                                            } else {
                                                echo '<li class="paginate_button page-item">';
                                                echo '<a href="#" onclick="ChangePage4(' . $i . ')" class="page-link">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                        }

                                        // Generate ellipsis after the active page
                                        // if ($onpage + 2 < $pages) {
                                        //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                        // }
                            
                                        // Generate Last Page button
                                        if ($onpage < $pages - 1) {
                                            if ($onpage < $pages - 2) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }

                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage4(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                            echo '</li>';
                                        }

                                        // Generate Next button
                                        if ($onpage < $pages) {
                                            echo '<li class="paginate_button page-item next" id="custbl_next">';
                                            echo '<a href="#" onclick="ChangePage4(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                            echo '</li>';
                                        }
                                        ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>



<?php if ($_POST['code'] === 'INCOME') { ?>

<?php
                $SQL_Filter_Query = '';

                if (!empty($_POST['Search'])) {
                    $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
                }

                // if (!empty($_POST['village'])) {
//     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
// }
        
                $sql = "SELECT COUNT(*) AS total_rows from cash_expenditure WHERE cash_status='1' " . $SQL_Filter_Query . " ;";

                // Execute the query
                $result = mysqli_query($connect, $sql);

                $row = mysqli_fetch_assoc($result);

                // Access the total rows count
                $totalRows = $row['total_rows'];
                // Check for errors
                if (($totalRows < 1)) {
                    echo ($emty_table);
                } else {

                    // echo "Total Rows: " . $totalRows;
        

                    $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
                    $page = mysqli_real_escape_string($connect, $_POST['page']);

                    $pages = ceil($totalRows / $tableLimit);
                    if ($page > $pages) {
                        $page = $pages;
                    }
                    if ($page < 1) {
                        $page = 1;
                    }

                    $onpage = $page;
                    $offsetFrom = ($page - 1) * $tableLimit;

                    $SQL_ROW_Query = '';
                    if ($tableLimit > 0) {
                        $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
                    }
                    // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;
        
                    ?>







<table border="1" id="E5" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item5')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('INCOME', 1, '#delete_check_box5', ajaxIncome)">
                                    <i class="btn-round bx bx-trash me-2"></i>बँक आवक
                                    हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>

            <th>तारीख</th>
            <th>बँक आवक </th>
            <th>रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from bank_inward WHERE bank_inward_status='1' ORDER BY inward_id DESC") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                            extract($brand);
                                            ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item5" id="delete_check_box5"
                    name="bank_inward_id[]" value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>

            <td>
                <a class="text-decoration-none" href="?show_income=true&bank_inward_id=<?= $inward_id; ?>">

                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_income=true&bank_inward_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $gettotal = mysqli_query($connect, "SELECT SUM(inward_rs) as totbankinward FROM bank_inward WHERE bank_inward_status='1'");
                            $total_bank_inward = mysqli_fetch_assoc($gettotal);
                            ?>
    <tr>
        <th colspan="3" class="text-center fs-6">एकूण</th>
        <th class="text-nowrap">₹
            <?= $total_bank_inward['totbankinward'] ?>/-
        </th>

    </tr>
</table>



<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage5(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">

        </div>
        <!-- <li class="paginate_button page-item previous ">
<a href="#" class="page-link">Prev</a>
</li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                        // Adjust this number based on your preference
                                        $ellipsisText = '…';

                                        // Generate Prev button
                                        if ($onpage > 1) {
                                            echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                            echo '<a href="#" onclick="ChangePage5(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                            echo '</li>';
                                        }

                                        // Generate First Page button
                                        if ($onpage > 3) {
                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage5(1)" class="page-link">1</a>';
                                            echo '</li>';

                                            if ($onpage > 4) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }
                                        }

                                        // Generate page links
                                        for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                            if ($i == $onpage) {
                                                echo '<li class="paginate_button page-item active">';
                                                echo '<span class="page-link">' . $i . '</span>';
                                                echo '</li>';
                                            } else {
                                                echo '<li class="paginate_button page-item">';
                                                echo '<a href="#" onclick="ChangePage5(' . $i . ')" class="page-link">' . $i . '</a>';
                                                echo '</li>';
                                            }
                                        }

                                        // Generate ellipsis after the active page
                                        // if ($onpage + 2 < $pages) {
                                        //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                        // }
                            
                                        // Generate Last Page button
                                        if ($onpage < $pages - 1) {
                                            if ($onpage < $pages - 2) {
                                                echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                            }

                                            echo '<li class="paginate_button page-item">';
                                            echo '<a href="#" onclick="ChangePage5(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                            echo '</li>';
                                        }

                                        // Generate Next button
                                        if ($onpage < $pages) {
                                            echo '<li class="paginate_button page-item next" id="custbl_next">';
                                            echo '<a href="#" onclick="ChangePage5(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                            echo '</li>';
                                        }
                                        ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>



<?php if ($_POST['code'] === 'USANA') { ?>

<?php
        $SQL_Filter_Query = '';

        if (!empty($_POST['Search'])) {
            $SQL_Filter_Query .= "AND ex_cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        }

        // if (!empty($_POST['village'])) {
//     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
// }

        $sql = "SELECT COUNT(*) AS total_rows from borrowing WHERE bo_status='1' " . $SQL_Filter_Query . " ;";

        // Execute the query
        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);

        // Access the total rows count
        $totalRows = $row['total_rows'];
        // Check for errors
        if (($totalRows < 1)) {
            echo ($emty_table);
        } else {

            // echo "Total Rows: " . $totalRows;


            $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
            $page = mysqli_real_escape_string($connect, $_POST['page']);

            $pages = ceil($totalRows / $tableLimit);
            if ($page > $pages) {
                $page = $pages;
            }
            if ($page < 1) {
                $page = 1;
            }

            $onpage = $page;
            $offsetFrom = ($page - 1) * $tableLimit;

            $SQL_ROW_Query = '';
            if ($tableLimit > 0) {
                $SQL_ROW_Query = 'LIMIT ' . $tableLimit . ' OFFSET ' . $offsetFrom;
            }
            // SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1'  AND c.customer_name = 'AABBCC'  AND c.village = 'PPQQRR'  AND s.paystatus = 'paid'   AND s.pay_mode = 'card' ORDER BY s.sdate DESC;

            ?>










<table border="1" id="usnatbl" class="table table-striped table-bordered table-hover multicheck-container">
    <thead>
        <tr>
            <th>
                <?php //if ($auth_permissions->brand->can_delete): ?>
                <div class="d-inline-flex align-items-center select-all">
                    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                        onchange="checkAll(this , 'multi-check-item6')">
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bx bx-slider-alt fs-6'></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="category-action">
                            <li>
                                <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('USANA', 1, '#delete_check_box6', ajaxUsana)">
                                    <i class="btn-round bx bx-trash me-2"></i>उसना
                                    व्यवहार हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>

            <th>तारीख</th>
            <th>नाव</th>
            <th>मोबाईल</th>
            <th>रुपये</th>
            <th>प्राप्त तारीख</th>
            <th>प्राप्त रुपये</th>

        </tr>
    </thead>
    <tbody>
        <?php $getBrand = mysqli_query($connect, "select * from borrowing WHERE bo_status='1' ".$SQL_Filter_Query." ORDER BY inward_id DESC ".$SQL_ROW_Query." ;") ?>
        <?php if (mysqli_num_rows($getBrand) > 0): ?>
        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                                                                extract($brand);
                                                                ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item multi-check-item6" id="delete_check_box6" name="bo_id[]"
                    value="<?= $inward_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $inward_id ?>
                </span>
            </td>

            <td>
                <a class="text-decoration-none" href="?show_usana=true&bo_id=<?= $inward_id; ?>">

                    <?= date('d M Y', strtotime($idate)); ?>
                </a>
            </td>
            <td><a class="text-decoration-none" href="?show_usana=true&bo_id=<?= $inward_id; ?>">
                    <?= $inward ?>
                </a>
            </td>
            <td>
                <?= $contact ?>
            </td>
            <td>₹
                <?= $inward_rs ?>/-
            </td>
            <?php if ($receive_date == '') { ?>
            <td>00/00/0000</td>
            <?php } else { ?>
            <td>
                <?= date('d M Y', strtotime($receive_date)) ?>
            </td>
            <?php } ?>
            <td>₹
                <?= $receive_rs ?>/-
            </td>

        </tr>
        <?php endwhile ?>
        <?php endif ?>
    </tbody>
    <?php $getbo = mysqli_query($connect, "SELECT SUM(inward_rs) as totb FROM borrowing WHERE bo_status='1' ");
                                                $totalbo = mysqli_fetch_assoc($getbo);

                                                $getSrec = mysqli_query($connect, "SELECT SUM(receive_rs) as totrecrs FROM borrowing WHERE bo_status='1'");
                                                $totBres = mysqli_fetch_assoc($getSrec)
                                                    ?>
    <tr>
        <th colspan="4" class="text-center fs-6">एकूण</th>

        <th class="text-nowrap">₹
            <?= $totalbo['totb'] ?>/-
        </th>
        <td></td>
        <th class="text-nowrap">₹
            <?= $totBres['totrecrs'] ?>/-
        </th>

    </tr>
</table>


<div class="row">
    <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
        <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
            <?php echo $page ?> of
            <?php echo $pages > 0 ? $pages : 1 ?>
            Pages
        </div>
        <div>
            <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_customer"
                value="<?php echo $page ?>" onchange="ChangePage6(this.value)"
                class="paginate_button page-item previous form-control" style="width: 80px; padding: 3px;">

        </div>
        <!-- <li class="paginate_button page-item previous ">
<a href="#" class="page-link">Prev</a>
</li> -->
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="salestbl-filter_paginate">
            <ul class="pagination">
                <?php
                                // Adjust this number based on your preference
                                $ellipsisText = '…';

                                // Generate Prev button
                                if ($onpage > 1) {
                                    echo '<li class="paginate_button page-item previous" id="custbl_previous">';
                                    echo '<a href="#" onclick="ChangePage6(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                    echo '</li>';
                                }

                                // Generate First Page button
                                if ($onpage > 3) {
                                    echo '<li class="paginate_button page-item">';
                                    echo '<a href="#" onclick="ChangePage6(1)" class="page-link">1</a>';
                                    echo '</li>';

                                    if ($onpage > 4) {
                                        echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                    }
                                }

                                // Generate page links
                                for ($i = max(1, $onpage - 1); $i <= min($pages, $onpage + 1); $i++) {
                                    if ($i == $onpage) {
                                        echo '<li class="paginate_button page-item active">';
                                        echo '<span class="page-link">' . $i . '</span>';
                                        echo '</li>';
                                    } else {
                                        echo '<li class="paginate_button page-item">';
                                        echo '<a href="#" onclick="ChangePage6(' . $i . ')" class="page-link">' . $i . '</a>';
                                        echo '</li>';
                                    }
                                }

                                // Generate ellipsis after the active page
                                // if ($onpage + 2 < $pages) {
                                //     echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                // }
                    
                                // Generate Last Page button
                                if ($onpage < $pages - 1) {
                                    if ($onpage < $pages - 2) {
                                        echo '<li class="paginate_button page-item disabled"><span class="page-link">' . $ellipsisText . '</span></li>';
                                    }

                                    echo '<li class="paginate_button page-item">';
                                    echo '<a href="#" onclick="ChangePage6(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                    echo '</li>';
                                }

                                // Generate Next button
                                if ($onpage < $pages) {
                                    echo '<li class="paginate_button page-item next" id="custbl_next">';
                                    echo '<a href="#" onclick="ChangePage6(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                    echo '</li>';
                                }
                                ?>
            </ul>
        </div>
    </div>




</div>

<?php } ?>
<?php } ?>
<?php } ?>