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

<th>नाव</th>
                        <th>एकूण रक्कम</th>
                        <th>ठेव रक्कम</th>
                        <th>प्रलंबित रक्कम</th>
                        <th>पुन्हा ठेव</th>
                        <th>पुन्हा प्रलंबित रक्कम</th>
                        <th>तारीख</th>
                        <th>गाव</th>
                        <th>मोबाईल</th>
                        <th>वर्णन वनस्पती</th>
                        <th>तारीख दिली</th>
                        <th>वितरण तारीख</th>
                        <th>शून्य</th>

                        <th>कृती</th>
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
            $SQL_Filter_Query .= "AND  (far_name LIKE '%$searchTerm%' OR mob_no LIKE '%$searchTerm%' OR ald_id LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        }


        if (!empty($_POST['village'])) {
            $SQL_Filter_Query .= "AND village = '" . mysqli_real_escape_string($connect, $_POST['village']) . "'";
        }
        if (!empty($_POST['Name'])) {
            $SQL_Filter_Query .= "AND far_name = '" . mysqli_real_escape_string($connect, $_POST['Name']) . "'";
        }
        // if (!empty($_POST['Name'])) {
        //     $SQL_Filter_Query .= "AND far_name = '" . mysqli_real_escape_string($connect, $_POST['Name']) . "'";
        // }

        $sql = "SELECT COUNT(*) AS total_rows from all_loan_details where loan_status='1' " . $SQL_Filter_Query . " ;";

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

















            <table border="1" id="AllLoanListTbl" class="table table-striped table-bordered table-hover multicheck-container">
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
                                                data-multi-action="delete" data-multi-action-page="" href="?delete=true"
                                                onclick="performDelete('ALLLOAN', 1, '#delete_check_box', ajaxAllLoanDetaillist)">
                                                <i class="btn-round bx bx-trash me-2"></i>उधारी तपशील हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>

                        <th>नाव</th>
                        <th>एकूण रक्कम</th>
                        <th>ठेव रक्कम</th>
                        <th>प्रलंबित रक्कम</th>
                        <th>पुन्हा ठेव</th>
                        <th>पुन्हा प्रलंबित रक्कम</th>
                        <th>तारीख</th>
                        <th>गाव</th>
                        <th>मोबाईल</th>
                        <th>वर्णन वनस्पती</th>
                        <th>तारीख दिली</th>
                        <th>वितरण तारीख</th>
                        <th>शून्य</th>

                        <th>कृती</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $getDetails = "select * from all_loan_details where loan_status='1' " . $SQL_Filter_Query . " order by ald_date DESC " . $SQL_ROW_Query . "";
                    $resDetails = mysqli_query($connect, $getDetails);
                    if (mysqli_num_rows($resDetails) > 0):

                        $infoList = array();
                        while ($fetch = mysqli_fetch_assoc($resDetails)):
                            array_push($infoList, $fetch);
                            extract($fetch);
                            ?>

                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" class="multi-check-item" id="delete_check_box" name="ald_id[]"
                                        value="<?= $ald_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $ald_id ?>
                                    </span>
                                </td>


                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $fetch['ald_id']; ?>" class="text-success">
                                    <?= $far_name ?>
                                </td>

                                <td>
                                    <?= $total_amt ?>
                                </td>
                                <td>
                                    <?= $deposit_amt ?>
                                </td>
                                <td>
                                    <?= $pending_amt ?>
                                </td>
                                <td>
                                    <?= $deposit_again ?>
                                </td>
                                <td>
                                    <?= $again_pending ?>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($ald_date)); ?>
                                </td>
                                <td>
                                    <?= $village ?>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="all_loan_details_add?ald_id=<?= $ald_id; ?>">
                                        <?= $mob_no; ?>
                                    </a>
                                </td>

                                <td>
                                    <?= $des_plant ?>
                                </td>
                                <?php if ($given_date == '0000-00-00') { ?>
                                    <td>NULL</td>
                                <?php } else { ?>
                                    <td>
                                        <?= date('d M Y', strtotime($given_date)) ?>
                                    </td>
                                <?php } ?>

                                <?php if ($deli_date == '0000-00-00') { ?>
                                    <td>NULL</td>
                                <?php } else { ?>
                                    <td>
                                        <?= date('d M Y', strtotime($deli_date)) ?>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?= $nill ?>
                                </td>

                                <td>
                                    <a href="all_loan_invoice.php?ald_id=<?php echo $ald_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i class="fa fa-print"></i></a>
                                    <a href="all_loan_details_add?ald_id=<?php echo $ald_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
                <?php
                $gettotCustomers = mysqli_query($connect, "SELECT COUNT(ald_id) as totusers FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowu = mysqli_fetch_assoc($gettotCustomers);

                $gettotalamt = mysqli_query($connect, "SELECT SUM(total_amt) as totcount FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowtotAmt = mysqli_fetch_assoc($gettotalamt);

                $getDep = mysqli_query($connect, "SELECT SUM(deposit_amt) as totdep FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowdepamt = mysqli_fetch_assoc($getDep);

                $getpenamt = mysqli_query($connect, "SELECT SUM(pending_amt) as totpen FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowPen = mysqli_fetch_assoc($getpenamt);

                $getdepAgain = mysqli_query($connect, "SELECT SUM(deposit_again) as totagain FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowAgain = mysqli_fetch_assoc($getdepAgain);

                $getpenAgain = mysqli_query($connect, "SELECT SUM(again_pending) as totapen FROM `all_loan_details` where loan_status='1' " . $SQL_Filter_Query);
                $rowPenAgain = mysqli_fetch_assoc($getpenAgain);
                ?>
                <tfoot>
                    <tr>
                        <th colspan="1" class="text-center fs-6">एकूण</th>

                        <th>ग्राहक
                            <?= $rowu['totusers'] ?>
                        </th>
                        <th>₹
                            <?= $rowtotAmt['totcount'] ?>/-
                        </th>
                        <th>₹
                            <?= $rowdepamt['totdep'] ?>/-
                        </th>
                        <th>₹
                            <?= $rowPen['totpen'] ?>/-
                        </th>
                        <th>₹
                            <?= $rowAgain['totagain'] ?>/-
                        </th>
                        <th>₹
                            <?= $rowPenAgain['totapen'] ?>/-
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
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
            <?php foreach ($infoList as $fetch): ?>
                <?php extract($fetch);
                ?>
                <div class="modal fade" id="info<?php echo $ald_id; ?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $ald_id; ?>"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-success" id="infoLabel<?php echo $ald_id; ?>">शेतकऱ्याची माहिती</h5>
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
                                                        <?= $far_name ?>
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
                                                        <?= $mob_no ?>
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
                                                        <?= date('d M Y', strtotime($ald_date)); ?>
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
                                                    <strong>वनस्पती</strong>
                                                </td>
                                                <td>: </td>
                                                <td>

                                                    <span>
                                                        <?= $des_plant ?>
                                                    </span>
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
                                                        <?= $total_amt ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>आगाऊ रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $deposit_amt ?>
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>प्रलंबित रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($pending_amt == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $pending_amt ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <!--<tr>-->
                                            <!--	<td>-->
                                            <!--		<strong>Deposit Date</strong>-->
                                            <!--	</td>-->
                                            <!--	<td>: </td>-->
                                            <!--	<td>-->
                                            <!--		<span>-->
                                            <!--		    <?= date('d M Y', strtotime($ddate)) ?></span>-->
                                            <!--	</td>-->
                                            <!--</tr>-->
                                            <tr>
                                                <td>
                                                    <strong>पुन्हा ठेव</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($deposit_again == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $deposit_again ?>
                                                        </span>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <strong>बाकी रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <?php if ($again_pending == 0) { ?>
                                                        <span>0</span>
                                                    <?php } else { ?>
                                                        <span>
                                                            <?= $again_pending ?>
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