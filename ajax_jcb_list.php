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
<th>श्रेणी</th>
<th>नाव</th>
<th>तास/सहल</th>
<th>दर</th>
<th>एकूण रक्कम</th>
<th>एकूण आगाऊ</th>
<th>एकूण शिल्लक</th>
<th>तारीख</th>
<th>मोबाईल</th>
<th>गावाचे नाव</th>
<th>कामाचे स्वरूप</th>
<th>जेसीबी</th>
<th>टॅक्टर</th>
<th>तास</th>
<th>देणारा</th>
<th>घेणारा</th>
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

        if (!empty($_POST['Search'])) {
            $searchTerm = mysqli_real_escape_string($connect, $_POST['Search']);
            $SQL_Filter_Query .= " AND  (`name` LIKE '%$searchTerm%' OR mobile LIKE '%$searchTerm%' OR jcb_id LIKE '%$searchTerm%') ";
            // $SQL_Order_Query = "ORDER BY CASE WHEN customer_id = '".$searchTerm."' THEN 1 WHEN customer_mobno = '".$searchTerm."' THEN 2 ELSE 3 END, customer_id DESC";

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
        if (!empty($_POST['Name'])) {
            $SQL_Filter_Query .= "AND name = '" . $_POST['Name'] . "'";
        }
        if (!empty($_POST['village'])) {
            $SQL_Filter_Query .= "AND village_name = '" . $_POST['village'] . "'";
        }
        // echo $_POST['SelectedCustomer'] . ' // ' . $_POST['SelectedGav'] . ' // ' . $_POST['SelectedPaymentMode'] . ' // ' . $_POST['SelectedPayStatus'] . ' // ';
        // SQL query for counting rows
        //    echo "SELECT * FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ORDER BY s.sdate DESC ". $SQL_ROW_Query ."; " ;

        // echo "SELECT COUNT(*) AS total_rows FROM sales s JOIN customer c ON s.customer_id = c.customer_id WHERE s.sales_status = '1'   AND s.demo_status = '1' " . $SQL_Filter_Query . " ;";
        $sql = "SELECT COUNT(*) AS total_rows from jcb c LEFT JOIN jcb_adv a ON c.jcb_id=a.cr_id INNER JOIN jcb_category r ON c.jcb_cat_id=r.jcb_cat_id and c.jcb_cat_id='" . mysqli_real_escape_string($connect, $_POST['CatID']) . "' and c.jcb_status='1' " . $SQL_Filter_Query . " ;";

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















<table border="1" id="jcbTbl" class="table table-striped table-bordered table-hover multicheck-container">
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
                                <a title="जेसीबी हटवा" class="multi-action-btn dropdown-item text-danger"
                                    data-multi-action="delete" data-multi-action-page="" href="#"
                                    onclick="performDelete('JCB', 1, '#delete_check_box', ajaxJCBlist)">
                                    <i class="btn-round bx bx-trash me-2"></i>जेसीबी हटवा
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php //endif ?>
            </th>
            <th>श्रेणी</th>
            <th>नाव</th>
            <th>तास/सहल</th>
            <th>दर</th>
            <th>एकूण रक्कम</th>
            <th>एकूण आगाऊ</th>
            <th>एकूण शिल्लक</th>
            <th>तारीख</th>
            <th>मोबाईल</th>
            <th>गावाचे नाव</th>
            <th>कामाचे स्वरूप</th>
            <th>जेसीबी</th>
            <th>टॅक्टर</th>
            <th>तास</th>
            <th>देणारा</th>
            <th>घेणारा</th>
            <th>कृती</th>
        </tr>
    </thead>
    <tbody>
        <?php
                    if (isset($_POST['CatID'])) {
                        // $getjcb="select * from jcb e,jcb_category c WHERE e.jcb_cat_id='{$_GET['jcb_cat_id']}' and c.jcb_cat_id=e.jcb_cat_id and jcb_status='1' order by e.jcb_id DESC";
                        $getjcb = "select * from jcb c LEFT JOIN jcb_adv a ON c.jcb_id=a.cr_id INNER JOIN jcb_category r ON c.jcb_cat_id=r.jcb_cat_id and c.jcb_cat_id='" . mysqli_real_escape_string($connect, $_POST['CatID']) . "' and c.jcb_status='1' " . $SQL_Filter_Query . " group by c.jcb_id DESC " . $SQL_ROW_Query . " ;";
                        $view = mysqli_query($connect, $getjcb);

                        ?>
        <?php if (mysqli_num_rows($view) > 0): ?>
        <?php
                            $infoDetails = array();
                            while ($rowjcb = mysqli_fetch_assoc($view)):
                                array_push($infoDetails, $rowjcb);
                                extract($rowjcb);
                                ?>
        <tr>
            <td class="form-group">
                <input type="checkbox" class="multi-check-item" id="delete_check_box" name="jcb_id[]"
                    value="<?= $jcb_id ?>">
                <span class="badge bg-gradient-bloody text-white shadow-sm">
                    <?= $jcb_id ?>
                </span>
            </td>
            <td>
                <?= $cat_name; ?>
            </td>

            <td data-bs-toggle="modal" data-bs-target="#info<?php echo $rowjcb['jcb_id']; ?>" class="text-success">
                <?= $name ?>
            </td>



            <td>
                <?= $trip ?>
            </td>
            <td>
                <?= $rate ?>
            </td>
            <td>
                <?= $total_amt ?>
            </td>
            <?php
                                    if (isset($cr_id)) {
                                        $cusadv = mysqli_query($connect, "select SUM(advrs) as advrscus from jcb_adv where cr_id='{$cr_id}'");
                                        $rowAdvtot = mysqli_fetch_assoc($cusadv); ?>
            <td>
                <?= $rowAdvtot['advrscus'] ?>
            </td>
            <?php } else { ?>
            <td>₹ 0/-</td>
            <?php } ?>
            <?php if (isset($totBal)) { ?>
            <td>
                <?= $totBal ?>
            </td>
            <?php } else { ?>
            <td>₹ 0/-</td>
            <?php } ?>
            <td>
                <?= date('d M Y', strtotime($jdate)); ?>
            </td>
            <td>
                <a class="text-decoration-none" href="jcb_add?jcb_id=<?= $jcb_id; ?>">
                    <?= $mobile ?>
                </a>
            </td>
            <td>
                <?= $village_name ?>
            </td>
            <td>
                <?= $nwork ?>
            </td>
            <td>
                <?= $jcb ?>
            </td>

            <td>
                <?= $tactor ?>
            </td>
            <td>
                <?= $hrs ?>
            </td>
            <?php if (isset($giver)) { ?>
            <td>
                <?= $giver ?>
            </td>
            <?php } else { ?>
            <td>...</td>
            <?php } ?>
            <?php if (isset($takar)) { ?>
            <td>
                <?= $takar ?>
            </td>
            <?php } else { ?>
            <td>...</td>
            <?php } ?>
            <td>
                <?php if (isset($adv_id)) { ?>
                <a href="jcb_invoice?jcb_id=<?php echo $jcb_id ?>&adv_id=<?= $adv_id ?>" class="text-inverse p-r-10"
                    data-bs-toggle="tooltip" title="" data-original-title="Invoice"><i class="fa fa-print"></i></a>
                <?php } ?>
                <a href="jcb_add?jcb_id=<?php echo $jcb_id ?>" class="text-inverse p-r-10" data-bs-toggle="tooltip"
                    title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
        <?php endwhile ?>
        <?php endif ?>
        <?php
                        error_reporting(0);
                        $totBalance += $totBal; ?>
        <?php } ?>


    </tbody>
    <?php $ID = mysqli_real_escape_string($connect, $_POST['CatID']) ?>
    <?php $getadv = mysqli_query($connect, "SELECT COUNT(jcb_id) as cus FROM jcb where jcb_status='1' and jcb_cat_id='" . $ID . "' " . $SQL_Filter_Query);
                $tcus = mysqli_fetch_assoc($getadv);

                $getadv = mysqli_query($connect, "SELECT SUM(advrs) as totadv FROM jcb_adv a,jcb j WHERE j.jcb_id=a.cr_id and jcb_status='1' and jcb_cat_id='" . $ID . "' " . $SQL_Filter_Query);
                $tadv = mysqli_fetch_assoc($getadv);

                $gettotal = mysqli_query($connect, "SELECT SUM(trip) as tottrip FROM jcb where jcb_status='1' and jcb_cat_id='" . $ID . "' " . $SQL_Filter_Query);
                $ttrip = mysqli_fetch_assoc($gettotal);


                $getdep = mysqli_query($connect, "SELECT SUM(rate) as rate FROM jcb where jcb_status='1' and jcb_cat_id='" . $ID . "' " . $SQL_Filter_Query);
                $trate = mysqli_fetch_assoc($getdep);

                $getdep = mysqli_query($connect, "SELECT SUM(total_amt) as totamt FROM jcb where jcb_status='1' and jcb_cat_id='" . $ID . "' " . $SQL_Filter_Query);
                $totamt = mysqli_fetch_assoc($getdep);
                ?>
    <tr>
        <th class="text-center fs-6">Total</th>
        <th colspan="2" class="text-center fs-6">
            <?= $tcus['cus'] ?>
        </th>

        <th>
            <?= $ttrip['tottrip'] ?>
        </th>
        <th>
            <?= $trate['rate'] ?>
        </th>
        <th>₹
            <?= $totamt['totamt'] ?>/-
        </th>
        <th>₹
            <?= $tadv['totadv'] ?>/-
        </th>
        <th>₹
            <?= $totBalance ?>/-
        </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
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
<?php foreach ($infoDetails as $rowjcb): ?>
<?php extract($rowjcb);
                $totBal1 = $total_amt - $advrs;
                ?>
<div class="modal fade" id="info<?php echo $jcb_id; ?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $jcb_id; ?>"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="infoLabel<?php echo $jcb_id; ?>">ग्राहकाची माहिती</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12 my-0 py-2 max-h-500 oy-auto">

                    <table class="table">
                        <tbody>
                            <tr>
                                <td colspan="5" class="bg-light">
                                    <h6 class="text-success mb-0">मूलभूत माहिती</h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>श्रेणी</strong>
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
                                    <span>
                                        <?= date('d M Y', strtotime($jdate)); ?>
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
                                <td colspan="5" class="bg-light">
                                    <h6 class="text-success mb-0">इतर माहिती</h6>
                                </td>
                            </tr>

                            <tr>
                                <th>ऍडव्हान्स तारीख</th>
                                <th>ऍडव्हान्स रु</th>
                                <th>कारण</th>
                                <th>देणारा</th>
                                <th>घेणारा</th>
                            </tr>
                            <tr>
                                <?php
                                                error_reporting(0);
                                                $advcar = mysqli_query($connect, "select * from jcb_adv WHERE cr_id='$jcb_id' order by adv_id DESC");
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
                                <td>
                                    <?= $_resadv['giver'] ?>
                                </td>
                                <td>
                                    <?= $_resadv['taker'] ?>
                                </td>
                            </tr>
                            <?php $sumAdv = mysqli_query($connect, "SELECT SUM(advrs) as sumADV FROM `jcb_adv` WHERE cr_id='$jcb_id'");
                                                $rSumAdv = mysqli_fetch_assoc($sumAdv);
                                                ?>
                            <?php endwhile ?>

                            <tr>
                                <th colspan="1">Total Advance </th>
                                <td>
                                    <?= $rSumAdv['sumADV']; ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="1">Total Balance</th>
                                <td>
                                    <?= $totBal1 ?>
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