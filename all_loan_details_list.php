<?php require "config.php" ?>
<?php
Aditya::subtitle('सर्व उधारी तपशील यादी');
if (isset($_GET['delete']) && isset($_GET['ald_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['ald_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE ald_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE all_loan_details SET loan_status='0' WHERE ald_id='{$dir}'");
    }
    if ($delete) {
        header("Location: all_loan_details_list?action=Success&action_msg=उधारी तपशील हटवले..!");
        exit();
    } else {
        header('Location: all_loan_details_list?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}

if (isset($_POST['deposit'])) {
    escapeExtract($_POST);

    $editdeposit = mysqli_query($connect, "UPDATE all_loan_details SET 
           ddate = '" . date('Y-m-d') . "',
           pending_amt='$deposit_again',
           deposit_again ='$deposit_again',
           again_pending = '$bal_amt'
           WHERE ald_id ='$ald_id'");

    if ($editdeposit) {
        header('Location: all_loan_details_list?action=Success&action_msg=ग्राहकाची ₹ ' . $deposit_again . ' /- जमा झाले');
        exit();
    } else {
        header('Location: all_loan_details_list?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">उधारी तपशील</h6>
        <div class="dropdown-center">
            <a href="all_loan_details_add" type="button" class="btn btn-sm btn-success  float-end"
                data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="all_loan_details_add">नवीन तयार करा</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv">ठेव</a></li>
            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex">
                        <div class=" export-container"></div>
                        <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>
                        <!--Filter Modal -->
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
                                        <form id="allLoan-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">नावा नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `far_name` FROM all_loan_details WHERE loan_status='1' AND `far_name` IS NOT NULL AND `far_name` != '' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="nav-filter-allLoan">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["far_name"]) . '">' . ($row["far_name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावा नुसार फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `village` FROM all_loan_details WHERE  loan_status='1' AND `village` IS NOT NULL AND `village` != '' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="gav-filter-allLoan">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["village"]) . '">' . ($row["village"]) . '</option>';
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
                                        <button  data-bs-dismiss="modal" onclick="ajaxAllLoanDetaillist(1)" form="allLoan-filters-form" class="btn btn-dark">फिल्टर
                                            लागू करा</button>
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
                                <select name="suppliertbl_length" id="table_Row_Limit"
                                    onchange="ajaxAllLoanDetaillist(1)" aria-controls="suppliertbl"
                                    class="form-select form-select-sm">
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

<!--deposit_modal-->
<div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advLabel">ग्राहक ठेव</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="depositeLoan">
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">नाव</label>
                        <select name="ald_id" class="form-control mb-3 ald_id" required>
                            <option>Select Users</option>
                            <?php $getcustomert = mysqli_query($connect, "SELECT * from all_loan_details") ?>
                            <?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
                                <?php while ($getcus = mysqli_fetch_assoc($getcustomert)): ?>
                                    <option value="<?= $getcus['ald_id'] ?>">
                                        <?= $getcus['far_name'] ?>
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">तारीख</label>
                        <input type="date" class="form-control" id="ddate" name="advdate"
                            value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="rs" class="col-form-label">प्रलंबित रक्कम</label>
                        <input type="text" class="form-control pending_amt" id="pending_amt" name="pending_amt"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="rs" class="col-form-label">ठेव</label>
                        <input type="text" class="form-control deposit_again" id="deposit_again" name="deposit_again"
                            oninput="allowType(event, 'number')">
                    </div>
                    <div class="mb-3">
                        <label for="rs" class="col-form-label">शिल्लक</label>
                        <input type="text" class="form-control finally_left" id="finally_left" name="bal_amt" readonly>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="deposit" form="depositeLoan" class="btn btn-success">जतन करा</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        $("select.ald_id").change(function () {
            var x = $(".ald_id option:selected").val();
            //alert(x);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    pamt: x
                }
            }).done(function (data) {
                $("#pending_amt").val(data);
            });
        });
    });
    $(document).ready(function () {
        $(".pending_amt, .deposit_again").on("input", sub_deposit);
    });

    function sub_deposit() {
        let tamt = $('.pending_amt').val();
        let aamt = $('.deposit_again').val();
        let result1 = Number(tamt) - Number(aamt);
        $('.finally_left').val(!isNaN(result1) ? result1 : 0).trigger('change');
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
    function ajaxAllLoanDetaillist(page = 1, search = '') {


        // var Booking = $('#bookdate-filter').val();
        var Name = $('#nav-filter-allLoan').val();
        var village = $('#gav-filter-allLoan').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_all_loan_details_list",
            data: {
                Name : Name ,
                village: village,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#AllLoanListTbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxAllLoanDetaillist(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxAllLoanDetaillist(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxAllLoanDetaillist(1);
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
    function unselectfillter() {

        // Example usage
        // unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
        unselectSinglOption('gav-filter-allLoan');
        unselectSinglOption('nav-filter-allLoan');
        // unselectSinglOption('bookdate-filter');
        ajaxAllLoanDetaillist(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }
</script>
<script src="assets/js/new_function.js"></script>