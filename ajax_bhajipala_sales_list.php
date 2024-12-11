<?php
require_once "config.php";

$emty_table = <<<HTML
            <table border="1" id="bhajipalaTbl" class="table table-striped table-bordered table-hover multicheck-container">
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

    </div>
</div>
</th>
<th>शेतकऱ्यांचे नाव</th>
<th>गाव</th>
<th>मोबाईल</th>
<!--<th>बुकिंग तारीख</th>-->
<th>प्रॉडक्ट नाव </th>
<!--<th>दिलेली तारीख</th>-->
<th>देण्याची तारीख</th>
<th>दिलेली तारीख</th>
<th>एकूण</th>
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


        if (!empty($_POST['village'])) {
            $SQL_Filter_Query .= "AND village = '" . mysqli_real_escape_string($connect, $_POST['village']) . "'";
        }
        if (!empty($_POST['Name'])) {
            $SQL_Filter_Query .= "AND far_name = '" . mysqli_real_escape_string($connect, $_POST['Name']) . "'";
        }
        if (!empty($_POST['product'])) {
            $SQL_Filter_Query .= "AND p.product_name = '" . mysqli_real_escape_string($connect, $_POST['product']) . "'";
        }
        // if (!empty($_POST['Search'])) {
        //     $SQL_Filter_Query .= "AND s.far_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        // }

        if (!empty($_POST['Search'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $SQL_Filter_Query .= "AND  (s.far_name LIKE '%$searchTerm%' OR mob_no LIKE '%$searchTerm%' OR s.sale_id LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        }
        


        $sql = "SELECT COUNT(DISTINCT s.sale_id) AS total_rows
            FROM bhajipala_sales s
            INNER JOIN bhajipala_sales_details d ON s.sale_id = d.sale_id
            INNER JOIN product p ON p.product_id = d.pid
            WHERE s.is_not_delete = '1' " . $SQL_Filter_Query . " ;";

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

            ?>





            <table border="1" id="bhajipalaTbl" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6"
                                    onchange="checkAll(this , 'multi_check_Bhajipala' )">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="category-action">
                                        <li>
                                            <a title="Delete" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick=" performDelete('BHAJIPALA', page = 1, '#delete_check_box_Bhajipala' , ajaxBhajipalaSaleData) ">
                                                <i class="btn-round bx bx-trash me-2"></i>बुकिंग तपशील हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>शेतकऱ्यांचे नाव</th>
                        <th>गाव</th>
                        <th>मोबाईल</th>
                        <!--<th>बुकिंग तारीख</th>-->
                        <th>प्रॉडक्ट नाव </th>
                        <!--<th>दिलेली तारीख</th>-->
                        <th>देण्याची तारीख</th>
                        <th>दिलेली तारीख</th>
                        <th>एकूण</th>
                        <th>कृती</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getBooking = mysqli_query($connect, "SELECT s.sale_id, s.far_name, s.village, s.mob_no, s.total, s.deli_date, s.given_date,
                                        GROUP_CONCAT(DISTINCT p.product_name ORDER BY p.product_name ASC SEPARATOR '\n') AS product_names
                                 FROM bhajipala_sales s
                                 INNER JOIN bhajipala_sales_details d ON s.sale_id = d.sale_id
                                 INNER JOIN product p ON p.product_id = d.pid
                                 WHERE s.is_not_delete = '1' " . $SQL_Filter_Query . "
                                 GROUP BY s.sale_id
                                 ORDER BY s.sale_id DESC
                                 " . $SQL_ROW_Query . " ;");

                    ?>
                    <?php if (mysqli_num_rows($getBooking) > 0): ?>
                        <?php
                        $bookList = array();
                        while ($bookingRow = mysqli_fetch_assoc($getBooking)):
                            array_push($bookList, $bookingRow);
                        endwhile;

                        foreach ($bookList as $resBook):
                            extract($resBook);
                            ?>
                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" id="delete_check_box_Bhajipala" class="multi-check-item multi_check_Bhajipala"
                                        name="sale_id[]" value="<?= $sale_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $far_name ?></a>
                                </td>
                                <td>
                                    <?= $village ?>
                                </td>
                                <td data-bs-toggle="modal" data-bs-target="#info<?php echo $sale_id; ?>" class="text-primary"><a
                                        class="text-decoration-none">
                                        <?= $mob_no; ?>
                                    </a>
                                    <!--<a class="text-decoration-none" href="bhajipala_sales?sale_id=<? //= $sale_id;?>">-->
                                    <!--    <? //= $mob_no; ?>-->
                                    <!--</a>-->
                                </td>
                                <!--<td><? //= date('d M Y',strtotime($sdate))?></td>-->
                                <td>
                                <?= implode(', ', array_map('htmlspecialchars', explode("\n", $product_names))) ?>

                                </td>
                                <td class="text-danger fw-bold">
                                    <?= date('d M Y', strtotime($deli_date)) ?>
                                </td>
                                <td class="text-dark fw-bold">
                                    <?= $given_date ? date('d M Y', strtotime($given_date)) : '-' ?>
                                </td>
                                <td class="rupee-after text-end">
                                    <?= sprintf('%0.2f', $total) ?>
                                </td>
                                <td>
                                    <a href="bhajipala_invoice?sid=<?= $sale_id ?>" class="text-inverse p-r-10" data-bs-toggle="tooltip"
                                        title="" data-original-title="Booking Invoice"><i class="fa fa-print"></i></a>
                                    <a href="bhajipala_sales?sale_id=<?php echo $sale_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="" data-original-title="Edit"><i
                                            class="fa fa-edit text-primary"></i></a>
                                    <a href="bhajipala_sales_deposit_invoice?sid=<?= $sale_id ?>" class="text-inverse p-r-10"
                                        data-bs-toggle="tooltip" title="" data-original-title="Deposit Invoice"><i
                                            class="fa fa-print"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <?php $getBooking = mysqli_query($connect, "SELECT SUM(s.total) AS total_sales FROM bhajipala_sales s INNER JOIN bhajipala_sales_details d ON s.sale_id = d.sale_id INNER JOIN product p ON p.product_id = d.pid WHERE s.is_not_delete = '1' " . $SQL_Filter_Query . " ;");
                        // if(mysqli_num_rows($getBooking) > 0):
                            $Sum_Totle = mysqli_fetch_assoc($getBooking);
                        ?>
                        <th class="rupee-after text-end"><?php echo $Sum_Totle['total_sales'] ?></th>
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
            </div>

            <?php
            error_reporting(0);
            //if(isset($resBook)){?>
            <?php foreach ($bookList as $resBook): ?>
                <?php extract($resBook);
                ?>
                <div class="modal fade" id="info<?php echo $sale_id; ?>" tabindex="-1"
                    aria-labelledby="infoLabel<?php echo $sale_id; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-primary" id="infoLabel<?php echo $sale_id; ?>">शेतकऱ्याची बुकिंग तपशील</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 my-0 py-2 max-h-500 oy-auto">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="bg-light">
                                                    <h6 class="text-primary mb-0">मूलभूत माहिती</h6>
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
                                                    <strong>बुकिंग तारीख</strong>
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
                                                    <strong>दिलेली तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= date('d M Y', strtotime($given_date)); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>देण्याची तारीख</strong>
                                                </td>
                                                <td>: </td>
                                                <td>
                                                    <span>
                                                        <?= $deli_date; ?>
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
                                                    <h6 class="text-primary mb-0">उत्पादनांचे वर्णन</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>अ.क्र.</th>
                                                <th>मालाचे विवरण</th>
                                                <th>संख़्या</th>
                                                <th>दर</th>
                                                <th>एकुण रक्कम</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (isset($resBook['sale_id'])):
                                                $getcuspro = "SELECT * FROM bhajipala_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN bhajipala_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$resBook['sale_id']}'";
                                                $getpro = mysqli_query($connect, $getcuspro);
                                                while ($pro = mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $pid ?>
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
                                                    <th colspan="4">ऍडव्हान्स</th>
                                                    <td class="text-center">
                                                        ₹
                                                        <?= $advance ?>/-
                                                    </td>
                                                </tr>
                                                <tr align="right">
                                                    <th colspan="4">प्रलंबित रक्कम</th>
                                                    <td class="text-center">
                                                        <?= $balance ?>
                                                    </td>
                                                </tr>
                                                <tr align="right">
                                                    <th colspan="4">ठेव रक्कम</th>
                                                    <td class="text-center">
                                                        <?= $deposit ?>
                                                    </td>
                                                </tr>
                                                <tr align="right">
                                                    <th colspan="4">शिल्लक</th>
                                                    <td class="text-center">
                                                        <?= $finally_left ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php endif ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php } ?>
    <?php } ?>
<?php

}
?>