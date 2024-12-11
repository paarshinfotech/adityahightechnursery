<?php require "config.php" ?>
<?php
// Aditya::subtitle('बियाणे आवक व जावक यादी');
// if (isset($_GET['delete']) && isset($_GET['sale_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['sale_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE seeds_sales SET seeds_status='0' WHERE sale_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: seeds_category?action=Success&action_msg=बियाणे आवक व जावक  हटवले..!');
//         exit();
//     } else {
//         header('Location: seeds_category?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
if (isset($_POST['deposit'])) {
    escapeExtract($_POST);

    $editdeposit = mysqli_query($connect, "UPDATE seeds_sales SET 
           depositdate = '$depositdate',
           balance='$finally_left',
           deposit ='$deposit_again',
           pay_mode='$pay_mode',
           finally_left = '$finally_left'
           WHERE sale_id ='$sale_id'");
    if ($editdeposit) {
        //   header("Location: seeds_sales_list");
        //   exit();
        header("Location: seeds_sales_deposit_invoice?sid={$sale_id}");
        exit();
    } else {
        header('Location: seeds_sales_list');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">बियाणे आवक व जावक तपशील</h6>
        <div class="dropdown-center">
            <a href="seeds_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="seeds_add">नवीन तयार करा</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deposit">ठेव</a></li>
            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container"></div>
                        <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="seeds-filter-form" class="row g-3">
                                            

                                            <div class="col-12">
                                                <label class="form-label">बुकिंग तारीख फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `sdate` FROM seeds_sales WHERE `sdate` IS NOT NULL AND `sdate` != '' AND cat_id = ".$_GET['cat_id']." ;";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="bookdate-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["sdate"]) . '">' . ($row["sdate"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">शेतकऱ्यांचे नाव नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `far_name` FROM seeds_sales WHERE `far_name` IS NOT NULL AND `far_name` != '' AND cat_id = ".$_GET['cat_id']." ;";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["far_name"]) . '">' . ($row["far_name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावानुसार फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `village` FROM seeds_sales WHERE `village` IS NOT NULL AND `village` != '' AND cat_id = ".$_GET['cat_id']." ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="gav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $village = htmlspecialchars($row["village"]); // Sanitize output
                                                        echo "<option value='$village'>$village</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal"
                                            onclick="unselectfillter()">सर्व
                                            फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button data-bs-dismiss="modal" onclick="ajaxSeedData(1)" form="seeds-filter-form" class="btn btn-dark">फिल्टर लागू
                                            करा</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="row justify-content-between d-flex">
                    <div class=" w-auto ">
                        <div class="dataTables_length" id="suppliertbl_length">
                            <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxSeedData(1)"
                                    aria-controls="suppliertbl" class="form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                    <option value="-1">All</option>
                                </select> entries</label>
                        </div>
                    </div>
                    <div class="  w-auto">
                        <div class="dataTables_filter"><label>Search:<input id="Search_filter" type="search"
                                    class="form-control form-control-sm" oninput="logInputValueCustomer()"
                                    placeholder="" aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="table_data">

                </div>

            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="depositLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depositLabel">ठेव रक्कम</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="sale_id" class="col-form-label">नाव</label>
                        <select name="sale_id" id="cid" class="form-control cid" required>
                            <option>शेतकरी निवडा</option>
                            <?php $getzendu = mysqli_query($connect, "SELECT * from seeds_sales where seeds_status='1' group by far_name desc") ?>
                            <?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
                                <?php while ($getrow = mysqli_fetch_assoc($getzendu)): ?>
                                    <option value="<?= $getrow['sale_id'] ?>">
                                        <?= $getrow['far_name'] ?>
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="depositdate" class="col-form-label">तारीख</label>
                        <input type="date" class="form-control" id="depositdate" name="depositdate"
                            value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span
                                    class="text-danger">*</span></label><br>

                            <input type="text" name="pending_amt" id='pending_amt' class="form-control" readonly>

                            <input type="hidden" name="sale_id" id='sale_id' class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="deposit_again" class="form-label my-2">ठेव<span
                                    class="text-danger">*</span></label><br>
                            <input type=text name="deposit_again" id='deposit_again' class="form-control"
                                oninput="allowType(event, 'number')">
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="deposit_again" class="form-label my-2">पेमेंट मोड<span
                                    class="text-danger">*</span></label><br>
                            <select name="pay_mode" class="form-select">
                                <option value="">पेमेंट निवडा</option>
                                <option value="cash">रोख</option>
                                <option value="rtgs">RTGS</option>
                                <option value="neet">NEET</option>
                                <option value="phomepay">फोनपे</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="finally_left" class="form-label my-2">शेवटी लेफ्ट<span
                                    class="text-danger">*</span></label><br>
                            <input type=text name="finally_left" id='finally_left' class="form-control" readonly>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="deposit" class="btn btn-primary">जतन करा</button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
error_reporting(0);
foreach ($seedsList as $fetch): ?>
    <?php extract($fetch);
    ?>
    <div class="modal fade" id="info<?php echo $sale_id; ?>" tabindex="-1"
        aria-labelledby="infoLabel<?php echo $sale_id; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="infoLabel<?php echo $sale_id; ?>">शेतकऱ्यांची माहिती</h5>
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
                                        <strong>तारीख</strong>
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
                                    <td>
                                        <strong>डाग</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $dag ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>बिल क्र</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $bill_no ?>
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

                                if (isset($fetch['sale_id'])):
                                    $getcuspro = "SELECT * FROM seeds_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN seeds_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$fetch['sale_id']}'";
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
                                        <th colspan="4">Total</th>
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
<script>
    $(document).ready(function () {
        $("#cid").change(function () {
            var s = $("#cid option:selected").val();

            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    balamtSeeds: s
                }
            }).done(function (data) {
                $("#pending_amt").val(data);
            });
        });
    });

    $(document).ready(function () {
        $("#cid").change(function () {
            var x = $("#cid option:selected").val();
            //   alert(x);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    sales_id: x
                }
            }).done(function (data) {
                $("#sale_id").val(data);
            });
        });
    });
    $(document).ready(function () {

        //this calculates values automatically finally left
        pending_sub();
        $("#pending_amt, #deposit_again").on("input", function () {
            pending_sub();
        });
    });

    function pending_sub() {
        let totpending = document.getElementById('pending_amt').value;
        let depagain = document.getElementById('deposit_again').value;
        let finalleft = parseInt(totpending) - parseInt(depagain);
        if (!isNaN(finalleft)) {
            document.getElementById('finally_left').value = finalleft;
        }
    }
</script>
<?php include "footer.php"; ?>

<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };
</script>

<!--     --    -- --     --      -->

<script>
    function ajaxSeedData(page = 1, search = '') {


        var Booking = $('#bookdate-filter').val();
        var Name = $('#nav-filter').val();
        var village = $('#gav-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_seeds_list",
            data: {
                village : village ,
                Name : Name ,
                Booking : Booking ,
                cat_Id: <?php echo $_GET['cat_id'] ?>,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#seedsTbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxSeedData(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxSeedData(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxSeedData(1);
    });
</script>



<!-- 
<script>
    function filter(code, value, divID) {


        //console.log("Table Row Limit: " + code + value);

        $.ajax({
            type: "POST",
            url: "ajax_customer_filter",
            data: {
                code: code,
                value: value
            }
        }).done(function (data) {
            // //console.log(data);

            $("#" + divID).html(data);
            if(code === "CITY"){
                filter('TALUKA', '' , 'cus-filter-village')
            }
        });
    }

</script>
 -->

<script>
    function unselectfillter(){
        
    // Example usage
    // unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
    unselectSinglOption('gav-filter');
    unselectSinglOption('nav-filter');
    unselectSinglOption('bookdate-filter');
    ajaxSeedData(1);
    }
</script>
 <script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>