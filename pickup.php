<?php require "config.php" ?>
<?php
Aditya::subtitle((translate('advance') . ' / ' . translate('borrowing')));
//pick up rs
if (isset($_POST['pickup'])) {
    escapeExtract($_POST);

    $atten = "INSERT INTO employee_advance(ead_emp_id, ead_amount, ead_date, ead_reason) VALUES ('{$emp_id}', '{$pickup_rs}', '{$pdate}','{$reason}')";
    $respick = mysqli_query($connect, $atten);
    // mysqli_query($connect,"UPDATE salcar_sallery SET total_amt=total_amt-$pickup_rs");
    if ($respick) {
        header('Location: pickup?action=Success&action_msg=कर्मचाऱ्याने ₹ ' . $pickup_rs . ' /- उसने घेतले..!');
    } else {
        header('Location: pickup?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

if (isset($_GET['delete']) && isset($_GET['ead_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['ead_id'] as $dir) {
        $delete = mysqli_query($connect, "DELETE FROM employee_advance WHERE ead_id='{$dir}'");
    }
    //  $delete = mysqli_query($connect, "UPDATE employee_advance SET ead_status='0' WHERE ead_id='{$dir}'");
    //  mysqli_query($connect,"update employees SET")
    //}
    if ($delete) {
        header("Location: pickup?action=Success&action_msg=अडवान्स / उसने हटवले..!");
        exit();
    } else {
        header('Location: pickup?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}


if (isset($_POST['pickup_edit'])) {
    escapeExtract($_POST);

    $updatePickup = mysqli_query($connect, "UPDATE `employee_advance` SET
    ead_emp_id = '{$emp_id}',
    ead_amount = '{$pickup_rs}',
    ead_date = '{$pdate}',
    ead_reason = '{$reason}' WHERE ead_id='{$_POST['ead_id']}'");
    // mysqli_query($connect,"UPDATE salcar_sallery SET total_amt=total_amt-$pickup_rs");
    if ($updatePickup) {
        header('Location: pickup?action=Success&action_msg=अपडेट केले..!');
    } else {
        header('Location: pickup?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
?>
<?php require "header.php" ?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="page-header-title">
                    <?= translate('advance') ?> /
                    <?= translate('borrowing') ?>
                </h6>
            </div>

            <div class="col-auto mt-2">
                <div class="dropdown-center">
                    <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end"
                        data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
                        <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                    <ul class="dropdown-menu">

                        <li><a class="dropdown-item" href="employee_add">नवीन तयार करा</a></li>
                        <li><a class="dropdown-item" href="employee_list">सर्व बघा</a></li>

                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pickup">उचल </a></li>
                    </ul>
                </div>
            </div>

        </div>

        <!--<hr/>-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container"></div>
                        <!-- <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            Filters <i class="bx bx-filter"></i>
                        </button>
                        Filter Modal
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="vendor-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">Filter by city</label>
                                                <select class="form-select" id="vendor-filter-city">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by pin</label>
                                                <select class="form-select" id="vendor-filter-pin">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by category</label>
                                                <select class="form-select" id="vendor-filter-cat">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by subscription</label>
                                                <select class="form-select" id="vendor-filter-sub">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Filter by status</label>
                                                <select class="form-select" id="vendor-filter-status">
                                                    <option value="">All</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal"
                                            onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear
                                            all filters</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form"
                                            class="btn btn-dark">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>









                <div class="row justify-content-between d-flex">
                    <div class=" w-auto ">
                        <div class="dataTables_length" id="suppliertbl_length">
                            <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                <select name="suppliertbl_length" id="Customer_table_Row_Limit"
                                    onchange="ajaxPickupData(1)" aria-controls="suppliertbl"
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
                        <div class="dataTables_filter"><label>Search:<input id="Search_filter_Pickpu" type="search"
                                    class="form-control form-control-sm" oninput="logInputValuePickup()"
                                    placeholder="" aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="table_Pick_UP">

                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<!--pickuprs-->

<div class="modal fade" id="pickup" tabindex="-1" aria-labelledby="pickupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupLabel">अडवान्स / उसने द्या</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="pickuprs">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">कर्मचारी <span
                                        class="text-danger">*</span></label>
                                <select name="emp_id" id="emp_id" class="form-control mb-3 emp_id" required>
                                    <option value="">कर्मचारी निवडा</option>
                                    <?php $getemp = mysqli_query($connect, "SELECT * from employees WHERE emp_status='1'") ?>
                                    <?php if ($getemp && mysqli_num_rows($getemp)): ?>
                                        <?php while ($gete = mysqli_fetch_assoc($getemp)): ?>
                                            <option value="<?= $gete['emp_id'] ?>">
                                                <?= $gete['emp_name'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">उचल दिल्याची तारीख <span
                                        class="text-danger">*</span> </label>
                                <input type="date" class="form-control" id="adate" name="pdate"
                                    value="<?php echo date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <!--<div class="col-12 col-md-6 mt-2">-->
                        <!--      <div class="form-group">-->
                        <!--      <label for="total_amt" class="form-label">एकूण देय रक्कम<span class="text-danger">*</span></label>-->
                        <input type="hidden" name="total_amt" class="form-control totamt total_amt" id="total_amt"
                            oninput="allowType(event, 'number')">
                        <!--    </div>-->
                        <!--</div>-->

                        <div class="col-12 col-md-6">
                            <label for="pickup_rs" class="col-form-label">उचल दिलेली रक्कम <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control pickup_rs" id="pickup_rs"
                                oninput="allowType(event, 'number')" name="pickup_rs" required>
                        </div>
                        <!--<div class="col-12 col-md-6">-->
                        <!--            <label for="balance_rs" class="col-form-label">शिल्लक रु</label>-->
                        <input type="hidden" class="form-control balance_rs" id="balance_rs"
                            oninput="allowType(event, 'number')" name="balance_rs" readonly>
                        <!--</div>-->
                        <div class="col-12 col-md-6">
                            <label for="reason" class="col-form-label">कशासाठी घेतले</label>
                            <input type="text" class="form-control" id="reason" name="reason">
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="pickup" form="pickuprs" class="btn btn-success">जतन करा</button>
            </div>
        </div>
    </div>
</div>


<?php require_once 'footer.php' ?>
<script>
    $(document).ready(function () {
        $(".emp_id").change(function () {
            var t = $(".emp_id option:selected").val();
            //alert(t);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: { emp_Sal: t }
            }).done(function (data) {
                $(".totamt").val(data);
            });
        });
    });
    $(document).ready(function () {
        $("#total_days, #daily_rs").on("input", mul);
        $(".total_amt, .pickup_rs").on("input", sub);
    });
    function mul() {
        let tamt = $('#total_days').val();
        let aamt = $('#daily_rs').val();
        let result1 = Number(tamt) * Number(aamt);
        $('#total_amt').val(!isNaN(result1) ? result1 : 0).trigger('change');
    }
    function sub() {
        let tamtsal = $('.total_amt').val();
        let pickrs = $('.pickup_rs').val();
        let _bal = Number(tamtsal) - Number(pickrs);
        $('.balance_rs').val(!isNaN(_bal) ? _bal : 0).trigger('change');
    }	
</script>


<!--  -->
<!-- CustomerData -->
<!--  -->
<script>
    function ajaxPickupData(page = 1, search = '') {
        // Retrieve selected values from the dropdowns
        // var inuptSearch = $('#input_search').val();
        var tableRowLimit = $('#Customer_table_Row_Limit').val();

        // console.log("Table Row Limit: " + tableRowLimit);
        $("#table_Pick_UP").html(loader);
        $.ajax({
            type: "POST",
            url: "ajex_pickup",
            data: {
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // console.log("///////////////");
            $("#table_Pick_UP").html(data);
            initializeDataTable('export-container', '#example2')
        });
    }
</script>
<script>
    // jQuery function to log the input value and call ajaxSalesHistory
    function logInputValuePickup() {
        var inputValue = $('#Search_filter_Pickpu').val();

        // console.log('Input Value:', inputValue);
        ajaxPickupData(1, inputValue);
    }
</script>
<script>
    $(document).ready(function () {
        ajaxPickupData(1);
    });
</script>

<!-- 
<script>
    // Function to check all checkboxes in the same group
    function checkAll(masterCheckbox) {
		// console.log("Hello")
        var checkboxes = $(masterCheckbox).closest('table').find('.multi-check-item');
        checkboxes.prop('checked', masterCheckbox.checked);
    }
</script> -->


<script>
function ChangePage(page){
	var inputValue = $('#Search_filter_Pickpu').val();
	ajaxPickupData(page, inputValue )
}
</script>
<!-- <script src="assets/js/new_function.js"></script> -->
<script>
function performDelete(tableName, page = 1, checkboxSelector, ajaxCallback) {
    if (confirm('विक्री हटवा..?')) {
        // Get checked checkbox values
        var checkedValues = $(checkboxSelector + ':checked').map(function() {
            return this.value;
        }).get();

        // console.log(checkedValues);
        // Perform AJAX call
        $.ajax({
            type: 'POST',
            url: 'ajax_delete_checked_item', // Replace with your server-side script
            data: {
                checkboxValues: checkedValues,
                tableName: tableName
            },
            success: function(response) {
                // Handle the success response
                // console.log(response);
                alert(response);
                ajaxCallback(page);
            },
            error: function(xhr, status, error) {
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
    var cusListTbl = $( DataTableId).DataTable({
        dom: 'Bftip', // Buttons, search, and pagination, excluding information
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
    selectIds.forEach(function(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    });
}

function checkAll(masterCheckbox, multicheckitem) {
    // // console.log("Hello")
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