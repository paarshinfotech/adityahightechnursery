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
<th>कामगाराचे नाव</th>
<th>मोबाईल नंबर</th>
<th>तारीख</th>
<th>पगार रु</th>
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
        //     $SQL_Filter_Query .= "AND far_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        // }
        if (!empty($_POST['Search'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $SQL_Filter_Query .= "AND  (worker_name LIKE '%$searchTerm%' OR contact LIKE '%$searchTerm%' OR sal_id LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        }


        if (!empty($_POST['Name'])) {
            $SQL_Filter_Query .= "AND worker_name = '" . mysqli_real_escape_string($connect, $_POST['Name']) . "'";
        }
        if (!empty($_POST['Date'])) {
            $SQL_Filter_Query .= "AND sdate = '" . mysqli_real_escape_string($connect, $_POST['Date']) . "'";
        }
        // if (!empty($_POST['Name'])) {
        //     $SQL_Filter_Query .= "AND far_name = '" . mysqli_real_escape_string($connect, $_POST['Name']) . "'";
        // }

        $sql = "SELECT COUNT(*) AS total_rows from salcar where salcar_status='1' " . $SQL_Filter_Query . " ;";

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











            <table border="1" id="salCarTbl" class="table table-striped table-bordered table-hover multicheck-container">
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
                                            <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick="performDelete('SALCAR', 1, '#delete_check_box', ajaxSalCarlist)">
                                                <i class="btn-round bx bx-trash me-2"></i>साल कार हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>कामगाराचे नाव</th>
                        <th>मोबाईल नंबर</th>
                        <th>तारीख</th>
                        <th>पगार रु</th>
                        <!--<th>Reason</th>-->
                        <!--<th>Leave</th>-->
                        <!--<th>Leave Date</th>-->
                        <!--<th>Leave Reason</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php $getsalcar = "select * from salcar where salcar_status='1' " . $SQL_Filter_Query . " order by sal_id DESC " . $SQL_ROW_Query . " ;";
                    $resSalcar = mysqli_query($connect, $getsalcar);
                    if (mysqli_num_rows($resSalcar) > 0):

                        $carList = array();
                        while ($fetch = mysqli_fetch_assoc($resSalcar)):
                            array_push($carList, $fetch);
                            extract($fetch);
                            ?>

                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" id="delete_check_box" name="sal_id[]"
                                        value="<?= $sal_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sal_id ?>
                                    </span>
                                </td>

                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $fetch['sal_id']; ?>" class="text-success">
                                    <?= $worker_name; ?>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="sal_car_add?sal_id=<?= $sal_id; ?>">
                                        <?= $contact; ?>
                                    </a>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($sdate)); ?>
                                </td>
                                <td>
                                    <?= $sallery; ?>
                                </td>
                                <!--<td><? //= $pick_up_rs?></td>-->
                                <!--<td><? //= $reason?></td>-->
                                <!--<td><? //= $leave?></td>-->
                                <!--<td><? //= $date_leave?></td>-->
                                <!-- <td><? //= $reason_leave?></td>-->
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
            <?php
            error_reporting(0);
            foreach ($carList as $fetch): ?>
                <?php extract($fetch); ?>
                <div class="modal fade" id="info<?php echo $sal_id; ?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $sal_id; ?>"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-success" id="infoLabel<?php echo $sal_id; ?>">कामगार तपशील</h5>
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
                                                        <?= $worker_name ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>मोबाईल नंबर</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $contact ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>रुजू होण्याची तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= date('d M Y', strtotime($sdate)); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>पगार रु</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>₹
                                                        <?= $sallery ?> /-
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php
                                            error_reporting(0);
                                            $getDays = mysqli_query($connect, "SELECT * FROM `salcar_sallery` WHERE ma_id=$sal_id");
                                            $rowDays = mysqli_fetch_assoc($getDays);

                                            $getAb = mysqli_query($connect, "SELECT COUNT(is_present) as totab FROM `salcar_atten` WHERE sal_id=$sal_id AND is_present='absent'");
                                            $rowAb = mysqli_fetch_assoc($getAb);
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong>एकूण कामकाजाचे दिवस</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($rowDays['total_days'] == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $rowDays['total_days'] ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>एकूण रजा</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($rowAb['totab'] == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $rowAb['totab'] ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>एकूण पगार </strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($rowDays['total_amt'] == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>₹
                                                            <?= $rowDays['total_amt'] ?>/-
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="bg-light">
                                                    <h6 class="text-success mb-0">उचल रु</h6>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>उचल रु तारीख</th>
                                                <th>उचल रु</th>
                                                <th>कारण</th>
                                            </tr>
                                            <tr>
                                                <?php
                                                error_reporting(0);
                                                $_getPickUp = mysqli_query($connect, "select * from salcar_pickup_rs WHERE ma_id='$sal_id' order by male_pickup_id DESC");
                                                while ($_rowPickUp = mysqli_fetch_assoc($_getPickUp)):
                                                    //extract($_rowPickUp);   
                                                    ?>
                                                    <td>
                                                        <?= date('d M Y', strtotime($_rowPickUp['pdate'])) ?>
                                                    </td>
                                                    <td>₹
                                                        <?= $_rowPickUp['pickup_rs'] ?> /-
                                                    </td>
                                                    <td>
                                                        <?= $_rowPickUp['reason'] ?>
                                                    </td>
                                                </tr>
                                                <?php $sumAdv = mysqli_query($connect, "SELECT SUM(pickup_rs) as sumpickrs FROM `salcar_pickup_rs` WHERE ma_id='$sal_id'");
                                                $rSumAdv = mysqli_fetch_assoc($sumAdv);
                                                ?>
                                            <?php endwhile ?>

                                            <tr>
                                                <th colspan="1">एकूण उचल </th>
                                                <td>₹
                                                    <?= $rSumAdv['sumpickrs'] ?>/-
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