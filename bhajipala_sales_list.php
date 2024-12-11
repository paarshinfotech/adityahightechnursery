<?php require "config.php" ?>
<?php
Aditya::subtitle('बुकिंग तपशील');
if (isset($_GET['delete']) && isset($_GET['sale_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['sale_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE sale_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE bhajipala_sales SET is_not_delete='0' WHERE sale_id='{$dir}'");
    }
    if ($delete) {
        header("Location: bhajipala_sales_list?action=Success&action_msg=बुकिंग तपशील हटवले..!");
        exit();
    } else {
        header('Location: bhajipala_sales_list?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}

if (isset($_POST['deposit'])) {
    escapeExtract($_POST);

    $editdeposit = mysqli_query($connect, "UPDATE bhajipala_sales SET 
           depositdate = '$depositdate',
           balance='$finally_left',
           deposit ='$deposit_again',
           finally_left = '$finally_left'
           WHERE sale_id ='$sale_id'");
    if ($editdeposit) {
        //   header("Location: seeds_sales_list");
        //   exit();
        header("Location: bhajipala_sales_deposit_invoice?sid={$sale_id}");
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
        <h6 class="mb-0 text-uppercase">बुकिंग तपशील</h6>
        <div class="dropdown-center">
            <a href="bhajipala_sales" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="bhajipala_sales">नवीन तयार करा</a></li>
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
                                                <label class="form-label">प्रॉडक्ट नाव ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT product_name FROM `product` WHERE product_status = 1 ;";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="product_name-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["product_name"]) . '">' . ($row["product_name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>




                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">शेतकऱ्यांचे नाव नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `far_name` FROM bhajipala_sales WHERE `is_not_delete`= 1;";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="far_name-filter">
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
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `village` FROM bhajipala_sales WHERE `is_not_delete`= 1 ;";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="village-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["village"]) . '">' . ($row["village"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-12">
                                                <label class="form-label">देण्याची तारीख फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                // $sql = "SELECT DISTINCT `city` FROM customer WHERE `city` IS NOT NULL AND `city` != '';";
                                                
                                                // $result = mysqli_query($connect, $sql);
                                                
                                                ?>
                                                <select class="form-select" id="givendate-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    // while ($row = mysqli_fetch_assoc($result)) {
                                                    //     echo '<option value="' . ($row["city"]) . '">' . ($row["city"]) . '</option>';
                                                    // }
                                                    ?>
                                                </select>
                                            </div> -->
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal" onclick="unselectfillter()">सर्व
                                            फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button data-bs-dismiss="modal" class="btn btn-dark"
                                            onclick="ajaxBhajipalaSaleData(1)">फिल्टर लागू
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
                                <select name="suppliertbl_length" id="Customer_table_Row_Limit"
                                    onchange="ajaxBhajipalaSaleData(1)" aria-controls="suppliertbl"
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
                        <div class="dataTables_filter"><label>Search:<input id="Search_filter_bhajipala_sales"
                                    type="search" class="form-control form-control-sm"
                                    oninput="logInputValuebhajipala()" placeholder=""
                                    aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="table_bhajipala_sales_list">

                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>
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
                        <select name="sale_id" id="cid"
                            class="form-control bhajipala_sales_list_cid" required>
                            <option>शेतकरी निवडा</option>
                            <?php $getzendu = mysqli_query($connect, "SELECT far_name, sale_id from bhajipala_sales") ?>
                            <?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
                                <?php while ($getrow = mysqli_fetch_assoc($getzendu)): ?>
                                    <option value="<?= $getrow['sale_id'] ?>">
                                        <?= $getrow['far_name'] ?>
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>
                        </select>

                        <!-- <div class="col-12 " id="serch_input_customer">
                            <label class="form-label fw-bold">ग्राहक</label>
                            <div class="input-group search-box" id="Search_input_fild">
                                <input type="text" name="customer_Search" id="cid" class="form-control mb-3"
                                    oninput="searchCustomers(this.value)" placeholder="ग्राहक शोधा..." required>
                                <input type="hidden" name="far_name" id="customer_id" required>
                            </div>
                            <div class="search-results position-relative" id="customer_search_results_Div">
                            </div>
                        </div> -->


                        <!-- <script>
                            function searchCustomers(value) {
                                //console.log(value)
                                $.ajax({
                                    type: "GET",
                                    url: "ajax_load_customer_data",
                                    data: {
                                        searchInput: value
                                    },
                                    success: function (data) {
                                        $('#customer_search_results_Div').html(
                                            data);
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                            // depositdate
                            function updateCustomerSearch(ID, Name, Mod, Totle) {
                                // Assuming you have the input field with id 'customer_search'
                                // $('#customer_search').val(value);
                                //console.log(ID, Name)
                                $('.customer_search').val(Name + " | " + Mod);
                                $('#customer_id').val(Name);
                                $('#customer_search_results_Div').html('');

                            }
                        </script>
                    </div> -->

                        <div class="mb-3">
                            <label for="depositdate" class="col-form-label">तारीख</label>
                            <input type="date" class="form-control" id="depositdate" name="depositdate"
                                value="<?php echo date('Y-m-d') ?>">
                        </div>


                        <div class="col-12 col-md-12 mt-2">
                            <div class="form-group">
                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span
                                        class="text-danger">*</span></label><br>
                                <input type="text" name="pending_amt" id='pending_amt' class="form-control" readonly>
                                <input type="hidden" name="sale_id" id='sale_id' class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mt-2">
                            <div class="form-group">
                                <label for="deposit_again" class="form-label">ठेव<span
                                        class="text-danger">*</span></label><br>
                                <input type=text name="deposit_again" id='deposit_again' class="form-control"
                                    oninput="allowType(event, 'number')">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 mt-2">
                            <div class="form-group">
                                <label for="finally_left" class="form-label">शेवटी लेफ्ट<span
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
</div>
</div>
</div>
</div>

<?php //} ?>
<script>
    $(document).ready(function () {
        $("#cid").change(function () {
            var s = $("#cid option:selected").val();

            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    balAmt: s
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
                    sid: x
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

<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };
</script>


<!--     --    -- --     --      -->

<script>
    const loader = `
  <style>
    .loader {
      font-weight: bold;
      font-family: sans-serif;
      font-size: 30px;
      animation: l1 1s linear infinite alternate;
    }
    .loader:before {
      content: "Loading...";
    }
    @keyframes l1 {
      to {
        opacity: 0;
      }
    }
  </style>
  <div style="width: 100%; height: 500px; display: flex; align-items: center; justify-content: center;">
    <div class="loader"></div>
  </div>
`;
</script>
<script>
    function ajaxBhajipalaSaleData(page = 1, search = '') {
        // Retrieve selected values from the dropdowns
        // var inuptSearch = $('#input_search').val();
        var product = $('#product_name-filter').val();
        var Name = $('#far_name-filter').val();
        var village = $('#village-filter').val();
        var tableRowLimit = $('#Customer_table_Row_Limit').val();

        //console.log(product);
        //console.log(Name);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_bhajipala_sales_list").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_bhajipala_sales_list",
            data: {
                Name: Name,
                product: product,
                village: village,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            //console.log("///////////////");
            $("#table_bhajipala_sales_list").html(data);
            //     if (cusListTbl) {
            //     cusListTbl.destroy();
            // }
            initializeDataTable('export-container', '#bhajipalaTbl');
            // initializeDataTable();
        });
    }
</script>

<script>
    // jQuery function to log the input value and call ajaxSalesHistory
    function logInputValuebhajipala() {
        var inputValue = $('#Search_filter_bhajipala_sales').val();

        //console.log('Input Value:', inputValue);
        ajaxBhajipalaSaleData(1, inputValue);
    }
</script>
<script>
    $(document).ready(function () {
        ajaxBhajipalaSaleData(1);
    });
</script>




<script>
    // Function to check all checkboxes in the same group
    function checkAll(masterCheckbox) {
        //console.log("Hello")
        var checkboxes = $(masterCheckbox).closest('table').find('.multi-check-item');
        checkboxes.prop('checked', masterCheckbox.checked);
    }
</script>





<script>
    function unselectfillter() {

        // Example usage
        // unselectOption(['product_name-filter', 'far_name-filter', 'village-filter']);
        unselectOption('product_name-filter');
        unselectOption('far_name-filter');
        unselectOption('village-filter');
        ajaxBhajipalaSaleData(1);
    }
</script>

<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter_bhajipala_sales').val();
        ajaxBhajipalaSaleData(page, inputValue)
    }
</script>

<script>
    function performDelete(tableName, page = 1, checkboxSelector, ajaxCallback) {
        if (confirm('विक्री हटवा..?')) {
            // Get checked checkbox values
            var checkedValues = $(checkboxSelector + ':checked').map(function () {
                return this.value;
            }).get();

            //console.log(checkedValues);
            // Perform AJAX call
            $.ajax({
                type: 'POST',
                url: 'ajax_delete_checked_item', // Replace with your server-side script
                data: {
                    checkboxValues: checkedValues,
                    tableName: tableName
                },
                success: function (response) {
                    // Handle the success response
                    //console.log(response);
                    alert(response);
                    ajaxCallback(page);
                },
                error: function (xhr, status, error) {
                    // Handle the error
                    console.error(error);
                }
            });
        }
    }

    function initializeDataTable(exportClass, DataTableId) {
        // Clear the export container
        $('.' + exportClass).empty();

        // Initialize DataTable
        var cusListTbl = $(DataTableId).DataTable({
            dom: 'Bftip', // Buttons, search, and pagination, excluding information
            order: [
                [1, 'asc'] // Set the default order based on the second column (index 1) in ascending order
            ], // Buttons, search, and pagination, excluding information
            buttons: [{
                extend: 'collection',
                text: 'Export',
                className: 'btn-sm btn-outline-dark me-2',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'print'
                ]
            }],
            searching: false, // Disable search bar
            paging: false, // Disable pagination
            info: false // Disable information about the number of entries
        });

        // Move the buttons container to the specified export container
        cusListTbl.buttons().container().prependTo('.' + exportClass);
    }

    // function unselectOption(selectIds) {
    //     selectIds.forEach(function(selectId) {
    //         $('#' + selectId).prop('selectedIndex', 0);
    //     });
    // }
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }


    function checkAll(masterCheckbox, multicheckitem) {
        // //console.log("Hello")
        var checkboxes = $(masterCheckbox).closest('table').find('.' + multicheckitem);
        checkboxes.prop('checked', masterCheckbox.checked);
    }
</script>
// const loader = `
<style>
    .loader {
        font - weight: bold;
        font - family: sans - serif;
        font - size: 30 px;
        animation: l1 1 s linear infinite alternate;
    }

    .loader: before {
        content: "Loading...";
    }

    @keyframes l1 {
        to {
            opacity: 0;
        }
    }
</style>
<script>
    const loader = `
  <style>
    .loader {
      font-weight: bold;
      font-family: sans-serif;
      font-size: 30px;
      animation: l1 1s linear infinite alternate;
    }
    .loader:before {
      content: "Loading...";
    }
    @keyframes l1 {
      to {
        opacity: 0;
      }
    }
  </style>
  <div style="width: 100%; height: 500px; display: flex; align-items: center; justify-content: center;">
    <div class="loader"></div>
  </div>
`;
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js">
</script>
<script src="assets/js/BSSelect.min.js"></script>
<script>
    new BSSelect('.bhajipala_sales_list_cid');
</script>