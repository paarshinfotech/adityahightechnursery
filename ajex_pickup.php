<?php
require_once "config.php";

$emty_table = <<<HTML
<table border="1" id="example2" class="table table-striped table-bordered table-hover multicheck-container">
<thead>
                    <tr>
                        <th>
                            <!-- <?php //if ($auth_permissions->brand->can_delete): ?> -->
<div class="d-inline-flex align-items-center select-all">
    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">
    <div class="dropdown">
        <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
            aria-expanded="false">
            <i class='bx bx-slider-alt fs-6'></i>
        </button>
        <ul class="dropdown-menu" aria-labelledby="category-action">
            <li>
                <!-- <a title="Delete" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete"
                    data-multi-action-page="" href="?delete=true" onchange="checkAll(this)">
                    <i class="btn-round bx bx-trash me-2"></i>ग्राहक
                    हटवा
                </a> -->
            </li>
        </ul>
    </div>
</div>
<?php //endif ?>
</th>
<th>
    दिल्याची तारीख
</th>
<th>
    कर्मचाऱ्याचे नाव
</th>
<th>
    दिलेली रक्कम</th>
<th>
    कशासाठी घेतले

</th>
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

    <?php if (true) { ?>

        <?php
        $SQL_Filter_Query = '';

        // if (!empty($_POST['Search'])) {
        //     $SQL_Filter_Query .= "AND emp_name LIKE '%" . mysqli_real_escape_string($connect, mysqli_real_escape_string($connect, $_POST['Search'])) . "%'";
        // }
        if (!empty($_POST['Search'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $SQL_Filter_Query .= " AND  (emp_name LIKE '%$searchTerm%' OR ead_id LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        }
        // echo $_POST['SelectedCustomer'] . ' // ' . $_POST['SelectedGav'] . ' // ' . $_POST['SelectedPaymentMode'] . ' // ' . $_POST['SelectedPayStatus'] . ' // ';
        // SQL query for counting rows
        //    echo "SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ORDER BY s.sdate DESC ". $SQL_ROW_Query ."; " ;

        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ;";
        $sql = "SELECT COUNT(*) AS total_rows FROM employees e,employee_advance a WHERE e.emp_status='1' and e.emp_id=ead_emp_id " . $SQL_Filter_Query . " ;";

        // Execute the query
        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);

        // Access the total rows count
        $totalRows = mysqli_real_escape_string($connect, $row['total_rows']);;
        // Check for errors
        if (($totalRows < 1)) {
            echo ($emty_table);
        } else {

            // echo "Total Rows: " . $totalRows;


            $tableLimit = mysqli_real_escape_string($connect, $_POST['tableRowLimit']);
            $page = mysqli_real_escape_string($connect,$_POST['page']);

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





            <table border="1" id="example2" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" id="delete_check_box_Pickup"
                                    onchange="checkAll(this , 'multi_check_Pickup' )"
                                    class="multi-check-all mt-0 form-check-input fs-6">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>

                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>
                            <?= translate('given_date') ?>
                        </th>
                        <th>
                            <?= translate('employee_name') ?>
                        </th>
                        <th>
                            <?= translate('given_amount') ?>
                        </th>
                        <th>
                            <?= translate('taken_for_what') ?>
                        </th>
                        <!-- <th><?= translate('advance_deducted') ?></th> -->
                        <!--<th>एकूण देय रक्कम / प्रलंबित अडवान्स / उसने</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php $getEmpAdv = mysqli_query($connect, "SELECT * FROM employees e,employee_advance a WHERE e.emp_status='1' and e.emp_id=ead_emp_id " . $SQL_Filter_Query . " ORDER BY a.ead_id desc " . $SQL_ROW_Query . ";") ?>
                    <?php if (mysqli_num_rows($getEmpAdv) > 0): ?>
                        <?php
                        $pickup = array();
                        while ($resAdv = mysqli_fetch_assoc($getEmpAdv)):
                            array_push($pickup, $resAdv);
                            extract($resAdv);
                            ?>
                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" id="delete_check_box_Pickup" class="multi-check-item multi_check_Pickup"
                                        name="ead_id[]" value="<?= $ead_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $ead_id ?>
                                    </span>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($ead_date)) ?>
                                </td>
                                <td>

                                    <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#pickup<?= $ead_id ?>">
                                        <?= $emp_name ?>
                                    </a>
                                </td>

                                <td>
                                    <?= $ead_amount; ?>
                                </td>

                                <td>
                                    <?= $ead_reason ?>
                                </td>
                                <!--<td><? //= $balance_rs?></td>-->
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 col-md-5 d-flex gap-2 align-items-center ">
                    <div class="dataTables_info" id="salestbl-filter_info" role="status" aria-live="polite">Showing
                        <?php echo $page ?> of
                        <?php echo $pages > 0 ? $pages : 1 ?>
                        Pages
                    </div>
                    <div>
                        <input type="number" min="1" max="<?php echo $pages ?>" id="input_chang_page_Pickup"
                            value="<?php echo $page ?>" onchange="ChangePage($('#input_chang_page_Pickup').val());"
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
                                echo '<a href="#" onclick="ChangePage(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                echo '</li>';
                            }

                            // Generate First Page button
                            if ($onpage > 3) {
                                echo '<li class="paginate_button page-item">';
                                echo '<a href="#" onclick="ChangePage(1)" class="page-link">1</a>';
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
                                    echo '<a href="#" onclick="ChangePage(' . $i . ')" class="page-link">' . $i . '</a>';
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
                                echo '<a href="#" onclick="ChangePage(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                echo '</li>';
                            }

                            // Generate Next button
                            if ($onpage < $pages) {
                                echo '<li class="paginate_button page-item next" id="custbl_next">';
                                echo '<a href="#" onclick="ChangePage(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            <?php
            error_reporting(0);
            foreach ($pickup as $resAdv):
                extract($resAdv);
                ?>
                <div class="modal fade" id="pickup<?= $ead_id ?>" tabindex="-1" aria-labelledby="pickup<?= $ead_id ?>Label"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pickup<?= $ead_id ?>Label">अडवान्स / उसने द्या</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="pickupedit">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="adate" class="col-form-label">कर्मचारी <span
                                                        class="text-danger">*</span></label>
                                                <input type="hidden" name="ead_id" value="<?= $ead_id ?>">
                                                <select name="emp_id" id="emp_id" class="form-control mb-3 emp_id" required>
                                                    <option value="">कर्मचारी निवडा</option>
                                                    <?php $getemp = mysqli_query($connect, "SELECT * from employees WHERE emp_status='1'") ?>
                                                    <?php if ($getemp && mysqli_num_rows($getemp)): ?>
                                                        <?php while ($gete = mysqli_fetch_assoc($getemp)): ?>
                                                            <option value="<?= $gete['emp_id'] ?>" <?php if ($gete['emp_id'] == $ead_emp_id) {
                                                                  echo "selected";
                                                              } ?>>
                                                                <?= $gete['emp_name'] ?>
                                                            </option>
                                                        <?php endwhile ?>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="adate" class="col-form-label">उचल दिल्याची तारीख <span
                                                        class="text-danger">*</span> </label>
                                                <input type="date" class="form-control" id="adate" name="pdate" value="<?= $ead_date ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <!--<div class="col-12 col-md-6 mt-2">-->
                                        <!--      <div class="form-group">-->
                                        <!--      <label for="total_amt" class="form-label">एकूण देय रक्कम<span class="text-danger">*</span></label>-->
                                        <input type="hidden" name="total_amt" class="form-control totamt total_amt" id="total_amt"
                                            oninput="allowType(event, 'number')">
                                        <!--    </div>-->
                                        <!--</div>-->

                                        <div class="col-12 col-md-6">
                                            <label for="pickup_rs" class="col-form-label">उचल दिलेली रक्कम <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control pickup_rs" id="pickup_rs"
                                                oninput="allowType(event, 'number')" name="pickup_rs" required
                                                value="<?= $ead_amount ?>">
                                        </div>
                                        <!--<div class="col-12 col-md-6">-->
                                        <!--            <label for="balance_rs" class="col-form-label">शिल्लक रु</label>-->
                                        <input type="hidden" class="form-control balance_rs" id="balance_rs"
                                            oninput="allowType(event, 'number')" name="balance_rs" readonly>
                                        <!--</div>-->
                                        <div class="col-12 col-md-6">
                                            <label for="reason" class="col-form-label">कशासाठी घेतले</label>
                                            <input type="text" class="form-control" id="reason" name="reason"
                                                value="<?= $ead_reason ?>">
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                                <button type="submit" name="pickup_edit" form="pickupedit" class="btn btn-success">जतन करा</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    <?php } ?>
<?php } ?>