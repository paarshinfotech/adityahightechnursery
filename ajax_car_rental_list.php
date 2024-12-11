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
<th>श्रेणीचे नाव</th>
<th>नाव</th>
<th>खर्चाचे कारण</th>
<th>खर्चाचा प्रकार</th>
<th>रक्कम</th>
<th>पेमेंट मोड</th>
<th>तारीख</th>
<th>खर्च बीजक</th>
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
        //  BETWEEN '$from' AND '$to'
        $SQL_DATE = '';
        if (!empty($_POST['From']) && !empty($_POST['To'])) {
            $SQL_DATE = " AND cdate BETWEEN '" . mysqli_real_escape_string($connect, $_POST['From']) . "' AND '" . mysqli_real_escape_string($connect, $_POST['To']) . "' ";
        }


        $SQL_Filter_Query = '';

        if (!empty($_POST['Search'])) {
            $SQL_Filter_Query .= "AND name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        }

        if (!empty($_POST['village'])) {
            $SQL_Filter_Query .= " AND village_name = '" . mysqli_real_escape_string($connect, $_POST['village']) . "'";
        }
        if (!empty($_POST['name'])) {
            $SQL_Filter_Query .= " AND `name` = '" . mysqli_real_escape_string($connect, $_POST['name']) . "'";
        }

        $sql = "SELECT COUNT(*) AS total_rows FROM car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.adv_cr_id INNER JOIN car_rental_category r ON c.car_cat_id=r.car_cat_id AND c.car_cat_id='" . mysqli_real_escape_string($connect, $_POST['CategoryID']) . "'  AND c.car_status='1' " . $SQL_Filter_Query . " " . $SQL_DATE . " ;";

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
            $carList = [];
            ?>



















            <table border="1" id="example2" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                                    onchange="checkAll(this , 'multi-check-item')">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="category-action">
                                        <li>
                                            <a title="गाडी भाडे तपशील हटवा" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick="performDelete('CARRANT', 1, '#delete_check_box', ajaxCarRant)">
                                                <i class="btn-round bx bx-trash me-2"></i>गाडी भाडे तपशील हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>तारीख</th>
                        <th>गावाचे नाव</th>
                        <th>श्रेणी</th>
                        <th>भाड्याने गाडी</th>
                        <th>उचल डिझेल</th>
                        <th>शिल्लक रुपये</th>
                        <th>नाव</th>
                        <th>ऍडव्हान्स रु</th>
                        <th>ऍडव्हान्स तारीख</th>
                        <!--<th>Reason</th>-->
                        <th>क्रिया</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_POST['CategoryID'])) {
                        // if ($from && $to) {
                        //     $filter = "AND c.cdate >= '{$from}' AND c.cdate < '{$to}'";
                        // } else {
                        //     $filter = '';
                        // }
                        // echo "SELECT * FROM car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.adv_cr_id INNER JOIN car_rental_category r ON c.car_cat_id=r.car_cat_id AND c.car_cat_id='" . mysqli_real_escape_string($connect, $_POST['CategoryID']) . "'  AND c.car_status='1' " . $SQL_Filter_Query . " GROUP BY c.cr_id ORDER BY c.cr_id DESC " . $SQL_ROW_Query . " ;";
                        // SELECT * FROM car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.adv_cr_id INNER JOIN car_rental_category r ON c.car_cat_id=r.car_cat_id AND c.car_cat_id='2' AND c.car_status='1' GROUP BY c.cr_id ORDER BY c.cr_id DESC LIMIT 10 OFFSET 0;
                        $getcar_rental = "SELECT * FROM car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.adv_cr_id INNER JOIN car_rental_category r ON c.car_cat_id=r.car_cat_id AND c.car_cat_id='2' AND c.car_status='1' " . $SQL_Filter_Query . " " . $SQL_DATE . " GROUP BY c.cr_id ORDER BY c.cr_id DESC " . $SQL_ROW_Query . " ;";
                        $view = mysqli_query($connect, $getcar_rental);
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        ?>
                        <?php if (mysqli_num_rows($view) > 0): ?>
                            <?php


                            // print_r(mysqli_fetch_assoc($view));
                            while ($rowcar_rental = mysqli_fetch_assoc($view)):
                                array_push($carList, $rowcar_rental);
                                extract($rowcar_rental);
                                ?>
                                <tr>
                                    <td class="form-group">
                                        <input type="checkbox" class="multi-check-item" id="delete_check_box" name="cr_id[]"
                                            value="<?= $cr_id ?>">
                                        <span class="badge bg-gradient-bloody text-white shadow-sm">
                                            <?= $cr_id ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= date('d M Y', strtotime($cdate)); ?>
                                    </td>
                                    <td>
                                        <?= $village_name ?>
                                    </td>
                                    <td>
                                        <a class="text-decoration-none" href="car_rental_add?cr_id=<?= $cr_id; ?>">
                                            <?= $cat_name; ?>
                                        </a>
                                    </td>
                                    <td class="rupee-after">
                                        <?= sprintf('%0.2f', (empty($car_rental) ? 0 : $car_rental)) ?>
                                    </td>
                                    <td class="rupee-after">
                                        <?= sprintf('%0.2f', (empty($pick_up_diesel) ? 0 : $pick_up_diesel)) ?>
                                    </td>
                                    <td class="rupee-after">
                                        <?= sprintf('%0.2f', $deposit_rs) ?>
                                    </td>
                                    <td data-bs-toggle="modal" data-bs-target="#info<?php echo $rowcar_rental['cr_id']; ?>"
                                        class="text-success">
                                        <?= $name ?>
                                    </td>
                                    <td>
                                        <?= $advrs ?>
                                    </td>
                                    <td>
                                        <?= $advdate ?>
                                    </td>
                                    <!--<td><? //= $reason?></td>-->
                                    <td>
                                        <a href="car_rental_invoice?cr_id=<?php echo $cr_id ?>&adv_id=<?= $adv_id ?>"
                                            class="text-inverse p-r-10" data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i
                                                class="fa fa-print"></i></a>
                                        <a href="car_rental_add?cr_id=<?php echo $cr_id ?>" class="text-inverse p-r-10" data-bs-toggle="tooltip"
                                            title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        <?php endif ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-center fs-6">Total</th>
                            <th class="rupee-after">0.00</th>
                            <th class="rupee-after">0.00</th>
                            <th class="rupee-after">0.00</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                <?php } ?>
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
            <!--Details Info Modal-->
            <?php
            foreach ($carList as $rowcar_rental):
                extract($rowcar_rental);
                $totBal1 = floatval($deposit_rs) - floatval($advrs);
                ?>
                <div class="modal fade" id="info<?php echo $cr_id; ?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $cr_id; ?>"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-success" id="infoLabel<?php echo $cr_id; ?>">
                                    कर्मचारी माहिती</h5>
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
                                                        <?= $con ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= date('d M Y', strtotime($cdate)); ?>
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
                                                        <?= $village_name ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>श्रेणीचे नाव</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $cat_name ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>गाडी भाडे</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>₹
                                                        <?= $car_rental ?>/-
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>उचल डिझेल</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>₹
                                                        <?= $pick_up_diesel ?>/-
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="bg-light">
                                                    <h6 class="text-success mb-0">इतर माहिती</h6>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>ऍडव्हान्स तारीख</th>
                                                <th>ऍडव्हान्स रु</th>
                                                <th>कारण</th>
                                            </tr>
                                            <tr>
                                                <?php
                                                $advcar = mysqli_query($connect, "select * from car_rental_adv WHERE adv_cr_id='$cr_id' order by adv_id DESC");
                                                while ($_resadv = mysqli_fetch_assoc($advcar)):
                                                    //extract($_resadv);   
                                                    ?>
                                                    <td>
                                                        <?= date('d M Y', strtotime($_resadv['advdate'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= $_resadv['advrs'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $_resadv['reason'] ?>
                                                    </td>
                                                </tr>
                                                <?php $sumAdv = mysqli_query($connect, "SELECT SUM(advrs) as sumADV FROM `car_rental_adv` WHERE adv_cr_id='$cr_id'");
                                                $rSumAdv = mysqli_fetch_assoc($sumAdv);
                                                ?>
                                            <?php endwhile ?>
                                            <tr>
                                                <th colspan="1">एकूण ऍडव्हान्स</th>
                                                <td>₹
                                                    <?= empty($rSumAdv['sumADV']) ? '0.00' : $rSumAdv['sumADV']; ?> /-
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th colspan="1">एकूण शिल्लक</th>
                                                <td>₹
                                                    <?= $deposit_rs ?>/-
                                                </td>
                                                <td></td>
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