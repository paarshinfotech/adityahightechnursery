<?php require "config.php" ?>
<?php
// Aditya::subtitle('खर्च यादी');
// if (isset($_GET['delete']) && isset($_GET['ex_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['ex_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE expenses SET ex_status='0' WHERE ex_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: expenses_category?action=Success&action_msg=खर्च हटवले..!');
//         exit();
//     } else {
//         header('Location: expenses_category?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
// ?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">खर्च</h6>
        <a class="btn btn-sm btn-success float-end" href="expenses_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
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
                                        <form id="expense-filter-form" class="row g-3">


                                            <div class="col-12">
                                                <label class="form-label">तारीख ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `ex_date` FROM expenses WHERE ex_cat_id = " . $_GET['ex_cat_id'] . " AND `ex_date` IS NOT NULL AND `ex_create_date` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="date-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["ex_date"]) . '">' . ($row["ex_date"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">नावा नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `ex_name` FROM expenses WHERE ex_cat_id = " . $_GET['ex_cat_id'] . " AND  `ex_name` IS NOT NULL AND `ex_name` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["ex_name"]) . '">' . ($row["ex_name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">खर्चाचा प्रकार ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `ex_type` FROM expenses WHERE ex_cat_id = " . $_GET['ex_cat_id'] . " AND `ex_type` IS NOT NULL AND `ex_type` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="type-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["ex_type"]) . '">' . ($row["ex_type"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">पेमेंट मोड ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `payment_mode` FROM expenses WHERE ex_cat_id = " . $_GET['ex_cat_id'] . " AND `payment_mode` IS NOT NULL AND `payment_mode` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="pay-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["payment_mode"]) . '">' . ($row["payment_mode"]) . '</option>';
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
                                        <button onclick="ajaxExpenses(1)" data-bs-dismiss="modal" form="expense-filter-form" class="btn btn-dark">फिल्टर
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxExpenses(1)"
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
<?php include "footer.php"; ?>

<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt.buttons.pdfHtml5.customize = function (doc) { doc.defaultStyle.font = 'NotoSans'; };
</script>

<!--     --    -- --     --      -->

<script>
    function ajaxExpenses(page = 1, search = '') {


        var date = $('#date-filter').val();
        var name = $('#nav-filter').val();
        var type = $('#type-filter').val();
        var payment = $('#pay-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        console.log(date);
        console.log(name);
        console.log(type);
        console.log(payment);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_expenses",
            data: {

                tableRowLimit: tableRowLimit,
                Search: search,
                page: page,
                Ex_Cat_id: <?php echo $_GET['ex_cat_id'] ?> ,
                Date : date ,
                Name : name ,
                Type : type ,
                Payment : payment 
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#expenseTbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxExpenses(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxExpenses(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxExpenses(1);
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
    // unselectOption(['date-filter', 'nav-filter', 'type-filter' , 'pay-filter']);
    unselectSinglOption("date-filter");
    unselectSinglOption("nav-filter");
    unselectSinglOption("type-filter");
    unselectSinglOption("pay-filter");


    // filter('CITY', '', 'cus-filter-taluka');
    ajaxExpenses(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>