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
<!-- <th>आयडी</th> -->
<th>गाडी भाडे श्रेणीचे नाव</th>
<th>एकूण रक्कम</th>
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

        if (!empty($_POST['Search'])) {
            $SQL_Filter_Query .= "AND cat_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        }
        // if (!empty($_POST['city'])) {
        //     if (!empty($_POST['taluka'])) {
        //         if (!empty($_POST['village'])) {
        //             $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
        //         } else {
        //             $SQL_Filter_Query .= "AND taluka = '" . $_POST['taluka'] . "'";
        //         }
        //     } else {
        //         $SQL_Filter_Query .= "AND city = '" . $_POST['city'] . "'";
        //     }
        // }
        // if (!empty($_POST['village'])) {
        //     $SQL_Filter_Query .= "AND village = '" . $_POST['village'] . "'";
        // }
        // echo $_POST['SelectedCustomer'] . ' // ' . $_POST['SelectedGav'] . ' // ' . $_POST['SelectedPaymentMode'] . ' // ' . $_POST['SelectedPayStatus'] . ' // ';
        // SQL query for counting rows
        //    echo "SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ORDER BY s.sdate DESC ". $SQL_ROW_Query ."; " ;

        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ;";
        $sql = "SELECT COUNT(*) AS total_rows FROM car_rental_category WHERE car_cat_status='1' " . $SQL_Filter_Query . " ;";

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
















            <table border="1" id="example2" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"   onchange="checkAll(this , 'multi-check-item')">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="category-action">
                                        <li>
                                            <a title="गाडी भाडे श्रेणी हटवा" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick="performDelete('CARRENTCATEGORY', 1, '#delete_check_box', ajaxCarRentCategory)">
                                                <i class="btn-round bx bx-trash me-2"></i>गाडी भाडे श्रेणी हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <!-- <th>आयडी</th> -->
                        <th>गाडी भाडे श्रेणीचे नाव</th>
                        <th>एकूण रक्कम</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totCarRentalAmt = 0 ?>
                    <?php $getBrand = mysqli_query($connect, "SELECT * FROM car_rental_category WHERE car_cat_status='1' " .$SQL_Filter_Query. " ORDER BY car_cat_id DESC ".$SQL_ROW_Query." ;") ?>
                    <?php if (mysqli_num_rows($getBrand) > 0): ?>
                        <?php while ($brand = mysqli_fetch_assoc($getBrand)):
                            extract($brand);

                            $getdep = mysqli_query($connect, "SELECT SUM(car_rental) as totdeposit_rs FROM car_rental WHERE car_cat_id='{$car_cat_id}' and car_status='1'");
                            $totdep = mysqli_fetch_assoc($getdep);
                            ?>
                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" id="delete_check_box" name="car_cat_id[]" value="<?= $car_cat_id ?>">

                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $car_cat_id ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="car_rental_list?car_cat_id=<?= $car_cat_id; ?>">
                                        <?= $cat_name; ?>
                                    </a>
                                </td>
                                <td>₹
                                    <?= $totdep['totdeposit_rs'] ?>/-
                                </td>
                            </tr>
                            <?php $totCarRentalAmt += floatval($totdep['totdeposit_rs']) ?>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">एकूण</th>
                        <th class="rupee-after">
                            <?= $totCarRentalAmt; ?>
                        </th>
                    </tr>
                </tfoot>
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
                            value="<?php echo $page ?>" onchange="ChangePage($('#input_chang_page_customer').val());"
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

        <?php } ?>
    <?php } ?>
<?php } ?>