<?php require "config.php" ?>
<?php
Aditya::subtitle('डेमो इतिहास यादी');
//soft delete sales
if (isset($_GET['delete']) && isset($_GET['sale_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE sales SET sales_status='0' WHERE sale_id='{$dir}'");
    }
    if ($delete) {
        header("Location: demo_history?action=Success&action_msg=डेमो बिल हटवले..!");
        exit();
    } else {
        header('Location: demo_history?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">डेमो इतिहास</h6>
        <a class="btn btn-sm btn-success float-end" href="demo_bill" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container-salesh"></div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                            data-bs-target="#SalesfilterModal">
                            फिल्टर
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="SalesfilterModal" tabindex="-1"
                            aria-labelledby="SalesfilterModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="SalesfilterModalLabel">फिल्टर</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal fade" id="SalesfilterModal" tabindex="-1"
                                        aria-labelledby="SalesfilterModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="SalesfilterModalLabel">फिल्टर
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" id="salesHis-filter-form" class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">ग्राहक ने फिल्टर
                                                                करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT customer_name FROM customer WHERE customer_name IS NOT NULL AND customer_name != ''";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="sales-customers">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["customer_name"]) . '">' . ($row["customer_name"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">गावा ने फिल्टर करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT village FROM customer WHERE village IS NOT NULL AND village != ''";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="gav-cus">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["village"]) . '">' . ($row["village"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>



                                                        <div class="col-12">
                                                            <label class="form-label">पेमेंट मोड ने फिल्टर
                                                                करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT pay_mode FROM sales WHERE pay_mode IS NOT NULL AND pay_mode != ''";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="sales-filter-payment-mode">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["pay_mode"]) . '">' . ($row["pay_mode"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">पेमेंट स्टेटस ने फिल्टर
                                                                करा</label>
                                                            <?php
                                                            // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM customer";
                                                            $sql = "SELECT DISTINCT paystatus FROM sales WHERE paystatus IS NOT NULL AND paystatus != ''";

                                                            $result = mysqli_query($connect, $sql);

                                                            ?>
                                                            <select class="form-select" id="sales-filter-pay-status">
                                                                <option value="">सर्व</option>
                                                                <?php
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . ($row["paystatus"]) . '">' . ($row["paystatus"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button class="btn btn-outline-light border text-danger me-auto"
                                                        data-bs-dismiss="modal" onclick="unselectfilltersales()">सर्व
                                                        फिल्टर हटवा</button>
                                                    <button type="button" class="btn btn-outline-dark border"
                                                        data-bs-dismiss="modal">बंद करा</button>
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                                                        onclick="ajaxSalesHistory(page = 1)">फिल्टर लागू
                                                        करा</button>
                                                    <!-- <p  form="salesHis-filter-form" class="btn btn-dark">फिल्टर लागू करा</p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal"
                                            onclick="clearDataTableFilters(cusListTbl, '#sales-filter-form')">सर्व
                                            फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button type="submit" form="sales-filter-form" class="btn btn-dark">फिल्टर लागू
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxSalesHistory(1)"
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
                                    class="form-control form-control-sm" oninput="logInputValue()" placeholder=""
                                    aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="table_sales_history">





                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>
<!--priview modal-->


<!-- table_sales_history -->
<script>
    function ajaxSalesHistory(page = 1, search = '') {
        // Retrieve selected values from the dropdowns
        var selectedCustomer = $('#sales-customers').val();
        var selectedGav = $('#gav-cus').val();
        var selectedPaymentMode = $('#sales-filter-payment-mode').val();
        var selectedPayStatus = $('#sales-filter-pay-status').val();
        // var inuptSearch = $('#input_search').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log("Selected Customer: " + selectedCustomer);
        //console.log("Selected Gav: " + selectedGav);
        //console.log("Selected Payment Mode: " + selectedPaymentMode);
        //console.log("Selected Payment Status: " + selectedPayStatus);
        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_sales_history").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_sales_history",
            data: {
                SelectedCustomer: selectedCustomer,
                SelectedGav: selectedGav,
                SelectedPaymentMode: selectedPaymentMode,
                SelectedPayStatus: selectedPayStatus,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_sales_history").html(data);
            initializeDataTable('export-container-salesh', '#salestbl-filter')
        });
    }

    // function ajaxSalesHistoryModel(ID) {
    //     console.log("it woek")
    //     // $("#info").html(loader);
    //     $.ajax({
    //         type: "POST",
    //         url: "ajax_sales_history",
    //         data: {
    //             code: "MODEL",
    //             ID: ID
    //         }
    //         console.log("it woek")
    //     }).done(function(data) {
    //         // //console.log("///////////////");
    //         $("#info").html(data);
    //         console.log("it woek")
    //         // initializeDataTable('export-container-salesh', '#salestbl-filter')
    //     });
    // }
</script>
<script>
    $(document).ready(function () {
        ajaxSalesHistory(1);
    });
</script>
<script>
    function ChangePageSales(page) {
        var inputValue = $('#Search_filter').val();
        ajaxSalesHistory(page, inputValue)
    }
</script>
<script>
    // jQuery function to log the input value and call ajaxSalesHistory
    function logInputValue() {
        var inputValue = $('#Search_filter').val();

        //console.log('Input Value:', inputValue);
        ajaxSalesHistory(1, inputValue);
    }
</script>
<script src="assets/js/new_function.js"></script>
