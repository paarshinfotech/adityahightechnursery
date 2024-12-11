<?php require "config.php" ?>
<?php
Aditya::subtitle('ग्राहक यादी');
if (isset($_GET['delete']) && isset($_GET['customer_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['customer_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE customer SET customer_status='0' WHERE customer_id='{$dir}'");
    }
    if ($delete) {
        header("Location: customer_list?action=Success&action_msg=ग्राहक हटवले..!");
        exit();
    } else {
        header('Location: customer_list?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">ग्राहक</h6>
        <a class="btn btn-sm btn-success float-end" href="customer_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container">

                        </div>
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
                                        <form id="customer-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">जिल्ह्यांनुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `city` FROM customer WHERE `city` IS NOT NULL AND `city` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="cus-filter-city"
                                                    onchange="filter('CITY', this.value, 'cus-filter-taluka')">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["city"]) . '">' . ($row["city"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">तालुक्यानुसार फिल्टर करा </label>

                                                <select class="form-select" id="cus-filter-taluka"
                                                    onchange="filter('TALUKA', this.value, 'cus-filter-village')">
                                                    <option value="">सर्व</option>

                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावानुसार फिल्टर करा</label>

                                                <select class="form-select" id="cus-filter-village">
                                                    <option value="">सर्व</option>

                                                </select>
                                            </div>


                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal" onclick="unselectfillter()">सर्व
                                            फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button onclick="ajaxCustomerData(1)" data-bs-dismiss="modal"
                                            form="customer-filters-form" class="btn btn-dark">फिल्टर
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
                                <select name="suppliertbl_length" id="Customer_table_Row_Limit"
                                    onchange="ajaxCustomerData(1)" aria-controls="suppliertbl"
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
                        <div class="dataTables_filter"><label>Search:<input id="Search_filter_Customer" type="search"
                                    class="form-control form-control-sm" oninput="logInputValueCustomer()"
                                    placeholder="" aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="table_customer_data">

                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>



<!--     --    -- --     --      -->

<script>
    function ajaxCustomerData(page = 1, search = '') {


        var city = $('#cus-filter-city').val();
        var taluka = $('#cus-filter-taluka').val();
        var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#Customer_table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_customer_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_customer_list",
            data: {
                taluka: taluka,
                city: city,
                village: village,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_customer_data").html(data);
            console.log(data);
            initializeDataTable('export-container', '#custbl');
        });
    }
</script>



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
            if (code === "CITY") {
                filter('TALUKA', '', 'cus-filter-village')
            }
        });
    }

</script>



<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter_Customer').val();
        ajaxCustomerData(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter_Customer').val();
        // //console.log('Input Value:', inputValue);
        ajaxCustomerData(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxCustomerData(1);
    });
</script>




<script>
    function unselectfillter() {

        // Example usage
        unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
        filter('CITY', '', 'cus-filter-taluka');
        ajaxCustomerData(1);
    }
</script>
<!-- <script>
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script> -->
<!-- <script src="assets/js/new_function.js"></script> -->
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
            ],
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

    function unselectOption(selectIds) {
        selectIds.forEach(function (selectId) {
            $('#' + selectId).prop('selectedIndex', 0);
        });
    }

    function checkAll(masterCheckbox, multicheckitem) {
        // //console.log("Hello")
        var checkboxes = $(masterCheckbox).closest('table').find('.' + multicheckitem);
        checkboxes.prop('checked', masterCheckbox.checked);
    }

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