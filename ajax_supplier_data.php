<?php
require_once "config.php";

$emty_table = <<<HTML
<table border="1" id="suppliertbl" class="table table-striped table-bordered table-hover multicheck-container">
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
<th>नाव</th>
                        <th>मोबईल नंबर</th>
                        <th>ईमेल</th>
                        <th>दुकानाचे नाव</th>
                        <th>तारीख</th>
                        <th>ऍड्रेस</th>
                        <th>डेस्क्रिपशन</th>
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
        //     $SQL_Filter_Query .= "AND supplier_name LIKE '%" . mysqli_real_escape_string($connect, $_POST['Search']) . "%'";
        // }
        if (!empty($_POST['Search'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $SQL_Filter_Query .= "AND  (supplier_name LIKE '%$searchTerm%' OR supplier_id LIKE '%$searchTerm%' OR supplier_mobno LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

        }
        // echo $_POST['SelectedCustomer'] . ' // ' . $_POST['SelectedGav'] . ' // ' . $_POST['SelectedPaymentMode'] . ' // ' . $_POST['SelectedPayStatus'] . ' // ';
        // SQL query for counting rows
        //    echo "SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ORDER BY s.sdate DESC ". $SQL_ROW_Query ."; " ;

        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ;";
        $sql = "SELECT COUNT(*) AS total_rows FROM supplier WHERE sup_status='1' " . $SQL_Filter_Query . " ;";

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


            $tableLimit = $_POST['tableRowLimit'];
            $page = $_POST['page'];

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










            <table border="1" id="suppliertbl" class="table table-striped table-bordered table-hover multicheck-container">
                <thead>
                    <tr>
                        <th>
                            <?php //if ($auth_permissions->brand->can_delete): ?>
                            <div class="d-inline-flex align-items-center select-all">
                                <input type="checkbox" onchange="checkAll(this , 'multi_check_Supplier')" class="multi-check-all mt-0 form-check-input fs-6">
                                <div class="dropdown">
                                    <button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class='bx bx-slider-alt fs-6'></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="category-action">
                                        <li>
                                            <a title="सप्लायर हटवा" class="multi-action-btn dropdown-item text-danger"
                                                data-multi-action="delete" data-multi-action-page="" href="#"
                                                onclick=" performDelete('SUPPLIER', page = 1, '#delete_check_box_Supplier' , ajaxSupplierData)">
                                                <i class="btn-round bx bx-trash me-2"></i>सप्लायर
                                                हटवा
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php //endif ?>
                        </th>
                        <th>नाव</th>
                        <th>मोबईल नंबर</th>
                        <th>ईमेल</th>
                        <th>दुकानाचे नाव</th>
                        <th>तारीख</th>
                        <th>ऍड्रेस</th>
                        <th>डेस्क्रिपशन</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $getSup = mysqli_query($connect, "SELECT * FROM supplier WHERE sup_status='1' " . $SQL_Filter_Query . " ORDER BY supplier_id DESC " . $SQL_ROW_Query . ";");
                    ?>
                    <?php if (mysqli_num_rows($getSup) > 0): ?>
                        <?php while ($ressupplier = mysqli_fetch_assoc($getSup)):
                            extract($ressupplier);
                            ?>
                            <tr>
                                <td class="form-group">
                                    <input type="checkbox" id="delete_check_box_Supplier" class="multi-check-item multi_check_Supplier" name="supplier_id[]" value="<?= $supplier_id ?>">
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $supplier_id ?>
                                    </span>
                                </td>
                                <td>
                                    <a class="text-decoration-none" href="sales?show_supplier=true&supid=<?= $supplier_id; ?>">
                                        <?= $supplier_name ?>
                                </td>
                                <td>
                                    <?= $supplier_mobno ?>
                                </td>

                                <td>
                                    <?= $supplier_email ?>
                                </td>
                                <td>
                                    <?= $store_name ?>
                                </td>
                                <td>
                                    <?= date('d M Y', strtotime($create_date)) ?>
                                </td>
                                <td>
                                    <?= $supplier_address ?>
                                </td>
                                <td>
                                    <?= $supplier_info ?>
                                </td>

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
                            value="<?php echo $page ?>" onchange="ChangePageSupplier(page = this.value);"
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
                                echo '<a href="#" onclick="ChangePageSupplier(' . ($onpage - 1) . ')" class="page-link">Prev</a>';
                                echo '</li>';
                            }

                            // Generate First Page button
                            if ($onpage > 3) {
                                echo '<li class="paginate_button page-item">';
                                echo '<a href="#" onclick="ChangePageSupplier(1)" class="page-link">1</a>';
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
                                    echo '<a href="#" onclick="ChangePageSupplier(' . $i . ')" class="page-link">' . $i . '</a>';
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
                                echo '<a href="#" onclick="ChangePageSupplier(' . $pages . ')" class="page-link">' . $pages . '</a>';
                                echo '</li>';
                            }

                            // Generate Next button
                            if ($onpage < $pages) {
                                echo '<li class="paginate_button page-item next" id="custbl_next">';
                                echo '<a href="#" onclick="ChangePageSupplier(' . ($onpage + 1) . ')" class="page-link">Next</a>';
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>