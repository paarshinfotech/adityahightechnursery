<?php
require_once "config.php";

$emty_table = <<<HTML
<table border="1" id="zendutbl" class="table table-striped table-bordered table-hover multicheck-container">
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
              
            </li>
        </ul>
    </div>
</div>
<?php //endif ?>
</th>
<tr>
    <th></th>
    <th>बुकिंग तारीख</th>
    <th>शेतकऱ्याचे नाव</th>
    <th>लाल देणारी तारीख</th>
    <th>गाव</th>
    <th>मोबाईल</th>
    <th>लाल वनस्पती</th>
    <th>संख्या</th>
    <th>पिवळी वनस्पती</th>
    <th>संख्या</th>
    <th>लाल उपवर्ग ट्रे </th>
    <th>लाल उपवर्ग वाफा</th>
    <th>लाल उपवर्ग वर्णन </th>
    <th>पिवळ्या उपवर्ग ट्रे </th>
    <th>पिवळ्या उपवर्ग वाफा</th>
    <th>पिवळ्या उपवर्ग वर्णन</th>
    <th>एकूण रक्कम</th>
    <th>ठेव</th>
    <th>प्रलंबित</th>
    <th>पुन्हा ठेव</th>
    <th>अखेर बाकी</th>
    <th>पेमेंट मोड</th>
    <th>वितरण तारीख</th>
    <th>क्रिया</th>
</tr>
</tr>
</thead>
<tbody>
    <tr>
        <td colspan="15" class=" text-center"> No Data Found </td>
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
            $SQL_Filter_Query .= "AND `name` LIKE '%" . mysqli_real_escape_string($connect, mysqli_real_escape_string($connect, $_POST['Search'])) . "%'";
        }

        $SQL_DATE = '';
        if (!empty($_POST['From']) && !empty($_POST['To'])) {
            $SQL_DATE = " AND booking_date BETWEEN '" . mysqli_real_escape_string($connect, $_POST['From']) . "' AND '" . mysqli_real_escape_string($connect, $_POST['To']) . "' ";
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
        if (!empty($_POST['red_giving_date'])) {
            $SQL_Filter_Query .= "AND red_giving_date = '" . mysqli_real_escape_string($connect, $_POST['red_giving_date']) . "'";
        }
        if (!empty($_POST['farmer_name_filter'])) {
            $SQL_Filter_Query .= "AND `name` = '" . mysqli_real_escape_string($connect, $_POST['farmer_name_filter']) . "'";
        }
        if (!empty($_POST['red_Plant_filter'])) {
            $SQL_Filter_Query .= "AND red_plants = '" . mysqli_real_escape_string($connect, $_POST['red_Plant_filter']) . "'";
        }
        if (!empty($_POST['yellow_plants'])) {
            $SQL_Filter_Query .= "AND yellow_plants = '" . mysqli_real_escape_string($connect, $_POST['yellow_plants']) . "'";
        }
        if (!empty($_POST['payment_mode_filter'])) {
            $SQL_Filter_Query .= "AND pay_mode = '" . mysqli_real_escape_string($connect, $_POST['payment_mode_filter']) . "'";
        }
        // echo $_POST['SelectedCustomer'] . ' // ' . $_POST['SelectedGav'] . ' // ' . $_POST['SelectedPaymentMode'] . ' // ' . $_POST['SelectedPayStatus'] . ' // ';
        // SQL query for counting rows
        //    echo "SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ORDER BY s.sdate DESC ". $SQL_ROW_Query ."; " ;

        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ;";
        $sql = "SELECT COUNT(*) AS total_rows FROM zendu_booking WHERE zb_status='1' " . $SQL_Filter_Query . "  " . $SQL_DATE . " ;";

        // Execute the query
        $result = mysqli_query($connect, $sql);

        $row = mysqli_fetch_assoc($result);

        // Access the total rows count
        $totalRows = mysqli_real_escape_string($connect, $row['total_rows']);;
        // Check for errors
        if (($totalRows < 1)) {
            // if (true) {
            echo ($emty_table);
            // echo "HEllO THERE";

        } else {

            // echo "Total Rows: " . $totalRows;


            // $tableLimit = $_POST['tableRowLimit'];
            // $page = $_POST['page'];

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















            <table border="1" id="zendutbl" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" onchange="checkAll(this)" class="multi-check-all mt-0 form-check-input fs-6">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="category-action">
                                        <li>
                                            <a title="झेंडू बुकिंग हटवा" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick="performDelete('ZENDU' , <?php echo $page ?>);">
                                                <i class="btn-round bx bx-trash me-2"></i>झेंडू बुकिंग हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>बुकिंग तारीख</th>
                        <th>शेतकऱ्याचे नाव</th>
                        <th>लाल देणारी तारीख</th>
                        <th>गाव</th>
                        <th>मोबाईल</th>
                        <th>लाल वनस्पती</th>
                        <th>संख्या</th>
                        <th>पिवळी वनस्पती</th>
                        <th>संख्या</th>
                        <th>लाल उपवर्ग ट्रे </th>
                        <th>लाल उपवर्ग वाफा</th>
                        <th>लाल उपवर्ग वर्णन </th>
                        <th>पिवळ्या उपवर्ग ट्रे </th>
                        <th>पिवळ्या उपवर्ग वाफा</th>
                        <th>पिवळ्या उपवर्ग वर्णन</th>
                        <th>एकूण रक्कम</th>
                        <th>ठेव</th>
                        <th>प्रलंबित</th>
                        <th>पुन्हा ठेव</th>
                        <th>अखेर बाकी</th>
                        <th>पेमेंट मोड</th>
                        <th>वितरण तारीख</th>
                        <th>क्रिया</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $getZbooking = mysqli_query($connect, "SELECT * FROM zendu_booking WHERE zb_status='1' " . $SQL_Filter_Query . " " . $SQL_DATE . " ORDER BY booking_date ASC " . $SQL_ROW_Query . ";");
                    // echo "SELECT * FROM zendu_booking WHERE zb_status='1' " . $SQL_Filter_Query . "ORDER BY booking_date ASC " . $SQL_ROW_Query . ";"; ?>


                    <?php if (mysqli_num_rows($getZbooking) > 0): ?>
                        <?php
                        $zenduList = array();
                        $zenduBooks = mysqli_fetch_assoc($getZbooking);
                        while ($zenduBook = mysqli_fetch_assoc($getZbooking)):
                            // fast_output();
                            array_push($zenduList, $zenduBook);
                            extract($zenduBook);
                            ?>

                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" id="delete_check_box_Zendu" name="zendu_id[]"
                                        value="<?= $zendu_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $zendu_id ?>
                                    </span>
                                </td>
                                <!--<td>-->
                                <!--    <a class="text-decoration-none" href="zendu_booking_add?zendu_id=<? //= $zendu_id;?>">-->
                                <!--        <? //= $cat_name; ?>-->
                                <!--    </a>-->
                                <!--</td>-->
                                <td class="text-dark fw-bold">
                                    <?= date('d M Y', strtotime($booking_date)) ?>
                                </td>
                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $zenduBook['zendu_id']; ?>" class="text-success">
                                    <?= $name ?>
                                </td>
                                <td class="text-danger fw-bold">
                                    <?= date('d M Y', strtotime($red_giving_date)) ?>
                                </td>
                                <td>
                                    <?= $village ?>
                                </td>
                                <td>
                                    <?= $mobile ?>
                                </td>
                                <?php if ($red_plants == 'श्रेणी निवडा') { ?>
                                    <td></td>
                                <?php } else { ?>
                                    <td>
                                        <?= $red_plants ?>
                                    </td>
                                <?php } ?>
                                <td class="text-end">
                                    <?= $red_plants_count ?>
                                </td>
                                <?php if ($yellow_plants == 'श्रेणी निवडा') { ?>
                                    <td></td>
                                <?php } else { ?>
                                    <td>
                                        <?= $yellow_plants ?>
                                    </td>
                                <?php } ?>
                                <td class="text-end">
                                    <?= $yellow_plants_count ?>
                                </td>
                                <td class="text-end">
                                    <?= intval($sub_cat_qty) ?>
                                </td>
                                <td class="text-end">
                                    <?= intval($sub_cat_qty1) ?>
                                </td>
                                <td class="text-end">
                                    <?= intval($sub_cat_qty) + intval($sub_cat_qty1) ?>
                                </td>
                                <!-- /\13 -->
                                <td class="text-end">
                                    <?= intval($yellowcount) ?>
                                </td>
                                <td class="text-end">
                                    <?= intval($sub_cat_qtyy1) ?>
                                </td>
                                <td class="text-end">
                                    <?= intval($yellowcount) + intval($sub_cat_qtyy1) ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $total_amount) ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $adv_amt) ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $pending_amt) ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $deposit_again) ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $finally_left) ?>
                                </td>
                                <td>
                                    <?= translate($pay_mode) ?>
                                </td>
                                <!--<td><? //= date('d M Y',strtotime($red_giving_date))?></td> -->
                                <!--<td><? //= date('d M Y',strtotime($yellow_giving_date))?></td> -->
                                <td>
                                    <?php if ($date_given == '0000-00-00') {
                                    } else { ?>
                                        <?= date('d M Y', strtotime($date_given)) ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <a href="zendu_booking_invoice?zid=<?php echo $zendu_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="इनव्हॉइस बुकिंग" data-original-title="इनव्हॉइस बुकिंग"><i
                                            class="fa fa-print"></i></a>
                                    <a href="zendu_booking_add?zid=<?php echo $zendu_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="बुकिंग अपडेट" data-original-title="बुकिंग अपडेट"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="zendu_booking_deposit_invoice?zid=<?php echo $zendu_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="ठेव इनव्हॉइस" data-original-title="ठेव इनव्हॉइस"><i
                                            class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        <?php endwhile ?>

                    <?php endif ?>
                </tbody>
                <?php
                // Execute the query to get totals
                $getTotalsQuery = mysqli_query(
                    $connect,
                    "
    SELECT 
        SUM(red_plants_count) AS total_red_plants_count,
        SUM(sub_cat_qty) AS total_sub_cat_qty,
        SUM(sub_cat_qty1) AS total_sub_cat_qty1,
        SUM(yellow_plants_count) AS total_yellow_plants_count,
        SUM(yellowcount) AS total_yellowcount,
        SUM(sub_cat_qtyy1) AS total_sub_cat_qtyy1,
        SUM(total_amount) AS total_total_amount,
        SUM(adv_amt) AS total_adv_amt,
        SUM(pending_amt) AS total_pending_amt,
        SUM(deposit_again) AS total_deposit_again,
        SUM(finally_left) AS total_finally_left
    FROM zendu_booking
    WHERE zb_status='1' " . $SQL_Filter_Query . " " . $SQL_DATE );


                // Check if the query was successful
                if ($getTotalsQuery) {
                    // Fetch the result as an associative array
                    $totals = mysqli_fetch_assoc($getTotalsQuery); ?>

                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>एकूण</th>
                        <th class="text-end">
                            <?php echo $totals['total_red_plants_count'] ?>
                        </th>
                        <!-- red_plants_count
                        yellow_plants_count
                        sub_cat_qty
                        sub_cat_qty1 -->
                        <th></th>
                        <th class="text-end">
                            <?php echo $totals['total_yellow_plants_count'] ?>
                        </th>
                        <th class="text-end">
                            <?php echo $totals['total_sub_cat_qty'] ?>
                        </th>
                        <th class="text-end"></th>
                        <th class="text-end">
                            <?php echo $totals['total_yellowcount'] ?>
                        </th>
                        <th class="text-end">
                            <?php echo $totals['total_sub_cat_qtyy1'] ?>
                        </th>
                        <th class="text-end"></th>
                        <th></th>

                        <th class="rupee-after  text-end">
                            <?php echo $totals['total_total_amount'] ?>
                        </th>
                        <th class="rupee-after text-end">
                            <?php echo $totals['total_adv_amt'] ?>
                        </th>
                        <th class="rupee-after text-end">
                            <?php echo $totals['total_pending_amt'] ?>
                        </th>
                        <th class="rupee-after text-end">
                            <?php echo $totals['total_deposit_again'] ?>
                        </th>
                        <th class="rupee-after text-end">
                            <?php echo $totals['total_finally_left'] ?>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tfoot>

                    <?php
                } else {
                    echo "Error executing query: " . mysqli_error($connect);
                }

                // Close the database connection
                mysqli_close($connect);
                ?>

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
            </div>
            <?php
            foreach ($zenduList as $zenduBooks): ?>
                <?php extract($zenduBooks) ?>
                <div class="modal fade" id="info<?php echo $zendu_id; ?>" tabindex="-1"
                    aria-labelledby="infoLabel<?php echo $zendu_id; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-success" id="infoLabel<?php echo $zendu_id; ?>">शेतकऱ्यांची माहिती</h5>
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
                                                    <span>
                                                        <?= $name ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>मोबाईल</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $mobile ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span class="text-danger fw-bold">
                                                        <?= date('d M Y', strtotime($booking_date)); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>गावाचे नाव</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $village ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="bg-light">
                                                    <h6 class="text-success mb-0">वनस्पतींचे वर्णन</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>वनस्पतींचे वर्णन</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($red_plants == 0 && $subcat_id == 0 && $sub_cat_qty == 0 && $rate == 0 && $subcat_id1 == 0 && $sub_cat_qty1 == 0 && $rate1 == 0) { ?>
                                                        <span> - </span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $red_plants ?>:
                                                            <?php if ($subcat_id && $sub_cat_qty): ?>
                                                                <?= $subcat_id ?> (
                                                                <?= $sub_cat_qty ?> x
                                                                <?= sprintf('%0.2f', $rate) ?>)
                                                            <?php endif ?>
                                                            <?php if ($subcat_id1 && $sub_cat_qty1): ?>
                                                                <?= $subcat_id1 ?> (
                                                                <?= $sub_cat_qty1 ?> x
                                                                <?= sprintf('%0.2f', $rate1) ?>)
                                                            <?php endif ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>लाल रोपे एकूण</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?= sprintf('%0.2f', floatval($total_rs) + floatval($total_rs1)) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पिवळी वनस्पती</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($yellow_plants == 0 && $ysubcat_id == 0 && $yellowcount == 0 && $ratey == 0 && $subcat_idy1 == 0 && $sub_cat_qtyy1 == 0 && $ratey1 == 0) { ?>
                                                        <span> - </span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $yellow_plants ?>:
                                                            <?php if ($ysubcat_id && $yellowcount): ?>
                                                                <?= $ysubcat_id ?> (
                                                                <?= $yellowcount ?> x
                                                                <?= sprintf('%0.2f', $ratey) ?>)
                                                            <?php endif ?>
                                                            <?php if ($subcat_idy1 && $sub_cat_qtyy1): ?>
                                                                <?= $subcat_idy1 ?> (
                                                                <?= $sub_cat_qtyy1 ?> x
                                                                <?= sprintf('%0.2f', $ratey1) ?>)
                                                            <?php endif ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पिवळी रोपे एकूण रु</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <!--<?= sprintf('%0.2f', $total_rsy) ?>-->
                                                    <?= sprintf('%0.2f', floatval($total_rsy) + floatval($yellow_total)) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="bg-light">
                                                    <h6 class="text-success mb-0">खात्याची माहिती</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>एकूण रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= sprintf('%0.2f', $total_amount) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>ऍडव्हान्स रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= sprintf('%0.2f', $adv_amt) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>प्रलंबित रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= sprintf('%0.2f', $pending_amt) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>जमा करण्याची तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $depositdate ? date('d M Y', strtotime($depositdate)) : ' - ' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पुन्हा ठेव</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= sprintf('%0.2f', $deposit_again) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>अखेर बाकी</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= sprintf('%0.2f', $finally_left) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पेमेंट मोड</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= translate($pay_mode) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>लाल देणारी तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($red_giving_date == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span class="text-danger fw-bold">
                                                            <?= date('d M Y', strtotime($red_giving_date)) ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पिवळी देणारी तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($yellow_giving_date == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span class="text-warning fw-bold">
                                                            <?= date('d M Y', strtotime($yellow_giving_date)) ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>वितरण तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($date_given == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span class="text-success fw-bold">
                                                            <?= date('d M Y', strtotime($date_given)) ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    <?php } ?>
<?php } ?>