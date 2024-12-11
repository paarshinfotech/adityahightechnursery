<?php
require_once "config.php";

$emty_table = <<<HTML
<table border="1" id="outStanding-salestbl" class="table table-striped table-bordered table-hover multicheck-container">
<thead>
                    <tr>
                        <th>ऑर्डर नंबर</th>
                        <th>ग्राहकाचे नाव</th>
                        <th>मोबाईल</th>
                        <th>तारीख</th>
                        <th>गाडी भाडे</th>
                        <th>ड्राइवर नाव</th>
                        <th>एकूण</th>
                        <th>ऍडव्हान्स</th>
                        <th>शिल्लक</th>
                        <th>पेमेंट मोड</th>
                        <!--<th>कृती</th>-->
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
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $searchCondition .= "AND  (customer_name LIKE '%$searchTerm%' OR sale_id LIKE '%$searchTerm%' ) ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        } else {
            $searchCondition = "";
        }

        // Build the SQL query to count rows
        $sqlCount = "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id  WHERE s.sales_status = '1' AND s.balance != '0' AND s.demo_status = '1'" . $searchCondition;

        // Add a semicolon at the end of the SQL query
        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1' AND s.balance != '0' AND s.demo_status = '1' ".$SQL_Filter_Query." ;";

        $sql = "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id  WHERE s.sales_status = '1' AND s.balance != '0' AND s.demo_status = '1'" . $searchCondition;

        // $sql = "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1' AND s.balance != '0' AND s.demo_status = '1' ".$SQL_Filter_Query ;
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





            <table border="1" id="outStanding-salestbl" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>ऑर्डर नंबर</th>
                        <th>ग्राहकाचे नाव</th>
                        <th>मोबाईल</th>
                        <th>तारीख</th>
                        <th>गाडी भाडे</th>
                        <th>ड्राइवर नाव</th>
                        <th>एकूण</th>
                        <th>ऍडव्हान्स</th>
                        <th>शिल्लक</th>
                        <th>पेमेंट मोड</th>
                        <!--<th>कृती</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php $getsalesDetails = mysqli_query($connect, "SELECT * FROM sales s,customer c WHERE s.customer_id=c.customer_id and s.sales_status='1' and s.balance!='0' and sales_status='1' AND demo_status='1'" . $searchCondition . "  order by s.sale_id DESC " . $SQL_ROW_Query . " ;") ?>
                    <?php if (mysqli_num_rows($getsalesDetails) > 0): ?>
                        <?php
                        $salesDetails = array();
                        while ($salesFetch = mysqli_fetch_assoc($getsalesDetails)):
                            array_push($salesDetails, $salesFetch);
                            extract($salesFetch);
                            ?>
                            <tr>
                                <td>
                                    <?= $sale_id ?>
                                </td>
                                <td>
                                    <?= $customer_name; ?>
                                </td>
                                <td>
                                    <?= $customer_mobno; ?>
                                </td>

                                <td>
                                    <a class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#info<?php echo $salesFetch['sale_id']; ?>">
                                        <?= date('d M Y', strtotime($sdate)) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $car_rental_amt ?>
                                </td>
                                <td>
                                    <?= $driver_name ?>
                                </td>
                                <td>
                                    <?php if ($car_rental_amt == '') { ?>
                                        <?= $total ?>
                                    <?php } else { ?>
                                        <?= $car_rental_amt + $total ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?= $advance ?>
                                </td>
                                <td>
                                    <?= $balance ?>
                                </td>
                                <td>
                                    <?= $pay_mode ?>
                                </td>

                                <!--                       <td>-->
                                <!--<a href="sales?sale_id=<? //= $sale_id?>&show_sales=true" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Edit Sale" data-original-title="Edit Sale"><i class="fa fa-edit text-info"></i></a>-->

                                <!--<a href="invoice?cid=<? //= $customer_id?>&sid=<? //= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Invoice" data-original-title="Invoice"><i class="fa fa-print text-dark"></i></a>-->
                                <!--<a href="sales_advance_invoice?cid=<? //= $customer_id?>&sid=<? //= $sale_id?>" class="text-inverse p-r-10" data-bs-toggle="tooltip" title="Advance Invoice" data-original-title="Advance Invoice"><i class="fa fa-print text-cyan"></i></a>-->
                                <!--<a href="sales_delete?sid=<?php //echo $sale_id?>" class="text-inverse" title="Delete" data-bs-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash text-danger"></i></a>-->
                                <!--</td>-->
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
                            value="<?php echo $page ?>" onchange="ChangePage(page = this.value);"
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
            foreach ($salesDetails as $salesFetch): ?>
                <?php extract($salesFetch); ?>
                <div class="modal fade" id="info<?php echo $sale_id; ?>" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="infoLabel<?php echo $sale_id; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoLabel<?php echo $sale_id; ?>">चलन तपशील</h5>
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
                                                        <?= $customer_name ?>
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
                                                        <?= $customer_mobno ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>गाव</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $village ?>
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
                                                        <?php $date = date('d M Y', strtotime($sdate)) ?>
                                                        <?= $date ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php
                                            $getCusDebAmt = mysqli_query($connect, "SELECT SUM(total+car_rental_amt) as debAmt FROM `sales` WHERE customer_id=$customer_id");
                                            $rowDebAmt = mysqli_fetch_assoc($getCusDebAmt);
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong>डेबिट रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <strong>₹
                                                        <?= $rowDebAmt['debAmt']; ?> /-
                                                    </strong>
                                                </td>
                                            </tr>
                                            <?php
                                            $getcusCre = mysqli_query($connect, "SELECT SUM(balance+car_rental_amt) as credAmt FROM `sales` WHERE customer_id=$customer_id");
                                            $rowcre = mysqli_fetch_assoc($getcusCre);
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong>क्रेडिट रक्कम</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <!--<strong>₹ <? //= $rowcre['credAmt'];?> /-</strong>-->
                                                    <strong>₹
                                                        <?= $balance; ?> /-
                                                    </strong>
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
                                            $getpro = mysqli_query($connect, $getcuspro);
                                            while ($pro = mysqli_fetch_assoc($getpro)):
                                                extract($pro);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $product_id ?>
                                                    </td>
                                                    <td>
                                                        <?= $product_name ?>
                                                    </td>
                                                    <td>
                                                        <?= $pqty ?>
                                                    </td>
                                                    <td>
                                                        <?= $pprice ?>
                                                    </td>
                                                    <td>₹
                                                        <?= $sub_total ?>/-
                                                    </td>
                                                    <!--<td class="text-end"><? //= $total?></td>-->
                                                </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                <th colspan="4">एकूण</th>
                                                <td class="text-center">₹
                                                    <?= $total ?>/-
                                                </td>
                                            </tr>
                                            <tr align="right">
                                                <th colspan="4">कारचे भाडे रु</th>
                                                <td class="text-center">₹
                                                    <?= $car_rental_amt ?>/-
                                                </td>
                                            </tr>
                                            <tr align="right">
                                                <th colspan="4">ड्राइवर नाव</th>
                                                <td class="text-center">
                                                    <?= $driver_name ?>
                                                </td>
                                            </tr>
                                            <tr align="right">
                                                <th colspan="4">तारीख आणि एकूण</th>
                                                <td class="text-center">तारीख:
                                                    <?= date('d M Y', strtotime($advdate)) ?>, ₹
                                                    <?= $amt ?>/-
                                                </td>
                                            </tr>
                                            <tr align="right">
                                                <th colspan="4">ऍडव्हान्स</th>
                                                <td class="text-center">
                                                    ₹
                                                    <?= $advance ?>/-
                                                </td>
                                            </tr>
                                            <tr align="right">
                                                <th colspan="4">शिल्लक</th>
                                                <td class="text-center">
                                                    ₹
                                                    <?= $balance ?>/-

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
            <?php endforeach ?>
        <?php } ?>
    <?php } ?>
<?php } ?>