<?php require "config.php" ?>
<?php
$from = isset($_GET['date-from']) ? date('Y-m-d', strtotime($_GET['date-from'])) : null;
$to = isset($_GET['date-to']) ? date('Y-m-d', strtotime($_GET['date-to'])) : null;
$filterBy = isset($_GET['filter-by']) ? $_GET['filter-by'] : null;

$zenduList = array();
Aditya::subtitle('झेंडू बुकिंग यादी');
if (isset($_GET['delete']) && isset($_GET['zendu_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['zendu_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM zendu_booking WHERE customer_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE zendu_booking SET zb_status='0' WHERE zendu_id='{$dir}'");
    }
    if ($delete) {
        header("Location: zendu_booking_list?action=Success&action_msg=झेंडू बुकिंग हटवले..!");
        exit();
    } else {
        header('Location: zendu_booking_list?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}

if (isset($_POST['deposit'])) {
    escapeExtract($_POST);

    $editdeposit = mysqli_query($connect, "UPDATE zendu_booking SET 
           depositdate = '$depositdate',
           pending_amt='$finally_left',
           deposit_again ='$deposit_again',
           finally_left = '$finally_left'
           WHERE zendu_id ='$zendu_id'");
    if ($editdeposit) {
        header('Location: zendu_booking_list?action=Success&action_msg=शेतकऱ्यांचे ₹ ' . $deposit_again . ' /- जमा झाले..!');
        exit();
        //   header("Location: zendu_booking_deposit_invoice?zid={$zendu_id}");
        //   exit();
        //   header("Location: zendu_booking_list");
        //   exit();
    } else {
        header('Location: zendu_booking_list');
        exit();
    }
}

//add stock
if (isset($_POST['add_stock'])) {
    escapeExtract($_POST);
    $_cQty = $ocat_qty + $cat_nqty;
    $update = mysqli_query($connect, "update marigold_category set
            cat_id='$cat_id',
            cat_qty = '$_cQty',
            cat_date='" . date('Y-m-d') . "'
            where cat_id = '$cat_id'");

    if ($update) {
        header('Location: zendu_booking_list?action=Success&action_msg=' . $cat_name . ' नवीन स्टॉक जोडला..!');
        exit();
    } else {
        header('Location: zendu_booking_list?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">झेंडू बुकिंग </h6>
        <!--         <a class="btn btn-sm btn-success float-end" href="zendu_booking_add" style="margin-top:-25px;">-->
        <!--<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>-->
        <div class="dropdown-center">
            <a href="sal_car_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="zendu_booking_add">नवीन तयार करा</a></li>
                <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deposit">ठेव</button></li>
                <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addStockModal">स्टॉक
                        जोडा</button></li>
                <!--<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#gave" data-bs-whatever="@mdo">Gave</a></li>-->
            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container-zendu"></div>
                        <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#rangeModal">
                            कालावधी <i class="bx bx-calendar-week"></i>
                        </button>
                        <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>


                        <div class="modal fade" id="rangeModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content shadow border">
                                    <div class="modal-body">
                                        <form id="date-range-form" class="row g-3 mt-0">
                                            <div class="col-12">
                                                <input type="hidden" name="car_cat_id"
                                                    value="<?= $_GET['car_cat_id'] ?? '' ?>">
                                                <label class="form-label">कालावधी</label>
                                                <select class="form-select form-select-sm" id="report-date-range">
                                                    <option value="">कालावधी निवडा</option>
                                                    <option value="today">
                                                        <?= translate('today') ?>
                                                    </option>
                                                    <option value="yesterday">
                                                        <?= translate('yesterday') ?>
                                                    </option>
                                                    <option value="last_7_days">
                                                        <?= sprintf(translate('last_n_days'), 7) ?>
                                                    </option>
                                                    <option value="last_30_days">
                                                        <?= sprintf(translate('last_n_days'), 30) ?>
                                                    </option>
                                                    <option value="last_90_days">
                                                        <?= sprintf(translate('last_n_days'), 90) ?>
                                                    </option>
                                                    <option value="last_month">
                                                        <?= translate('last_month') ?>
                                                    </option>
                                                    <option value="last_year">
                                                        <?= translate('last_year') ?>
                                                    </option>
                                                    <option value="all">सर्व</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">लाल देणारी तारीख ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
 $sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT red_giving_date FROM zendu_booking WHERE red_giving_date IS NOT NULL AND red_giving_date != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="red_giving_date">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["red_giving_date"]) . '">' . ($row["red_giving_date"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label for="" class="form-label">तारखे पासून</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">
                                                        <i class="bx bx-calendar-week"></i>
                                                    </span>
                                                    <input type="date" name="date-from" id="date_from"
                                                        class="form-control js-flatpickr">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="" class="form-label">तारखे पर्यंत</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">
                                                        <i class="bx bx-calendar-week"></i>
                                                    </span>
                                                    <input type="date" name="date-to" id="date_to"
                                                        class="form-control js-flatpickr">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">रद्द करा</button>
                                        <button data-bs-dismiss="modal" type="button" onclick="ajaxZenduBooking(1)"
                                            class="btn btn-sm btn-primary" id="apply-date-range">लागू
                                            करा</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                // Function to handle date range selection
                                function handleDateRangeSelection() {
                                    var selectedRange = $("#report-date-range").val();
                                    var today = new Date().toISOString().split('T')[0]; // Get current date

                                    switch (selectedRange) {
                                        case "today":
                                            $("#date-range-form input[name='date-from']").val(today);
                                            $("#date-range-form input[name='date-to']").val(today);
                                            break;
                                        case "yesterday":
                                            var yesterday = new Date();
                                            yesterday.setDate(yesterday.getDate() - 1);
                                            $("#date-range-form input[name='date-from']").val(yesterday.toISOString().split('T')[0]);
                                            $("#date-range-form input[name='date-to']").val(yesterday.toISOString().split('T')[0]);
                                            break;
                                        case "last_7_days":
                                            var last7Days = new Date();
                                            last7Days.setDate(last7Days.getDate() - 6);
                                            $("#date-range-form input[name='date-from']").val(last7Days.toISOString().split('T')[0]);
                                            $("#date-range-form input[name='date-to']").val(today);
                                            break;
                                        case "last_30_days":
                                            var last30Days = new Date();
                                            last30Days.setDate(last30Days.getDate() - 29);
                                            $("#date-range-form input[name='date-from']").val(last30Days.toISOString().split('T')[0]);
                                            $("#date-range-form input[name='date-to']").val(today);
                                            break;
                                        case "last_90_days":
                                            var last90Days = new Date();
                                            last90Days.setDate(last90Days.getDate() - 89);
                                            $("#date-range-form input[name='date-from']").val(last90Days.toISOString().split('T')[0]);
                                            $("#date-range-form input[name='date-to']").val(today);
                                            break;
                                        case "last_month":
                                            var lastMonth = new Date();
                                            lastMonth.setMonth(lastMonth.getMonth() - 1);
                                            var firstDayLastMonth = new Date(lastMonth.getFullYear(), lastMonth.getMonth(), 1);
                                            var lastDayLastMonth = new Date(lastMonth.getFullYear(), lastMonth.getMonth() + 1, 0);
                                            $("#date-range-form input[name='date-from']").val(firstDayLastMonth.toISOString().split('T')[0]);
                                            $("#date-range-form input[name='date-to']").val(lastDayLastMonth.toISOString().split('T')[0]);
                                            break;
                                        case "last_year":
                                            var lastYear = new Date();
                                            lastYear.setFullYear(lastYear.getFullYear() - 1);
                                            $("#date-range-form input[name='date-from']").val(lastYear.getFullYear() + "-01-01");
                                            $("#date-range-form input[name='date-to']").val(lastYear.getFullYear() + "-12-31");
                                            break;
                                        case "all":
                                            $("#date-range-form input[name='date-from']").val('');
                                            $("#date-range-form input[name='date-to']").val('');
                                            break;
                                        // Add more cases as needed...
                                    }

                                }

                                // Event listener for date range selection change
                                $("#report-date-range").change(function () {
                                    handleDateRangeSelection();
                                });

                                // // Event listener for applying date range
                                // $("#apply-date-range").click(function () {
                                //     // Get the selected date range and handle it as needed
                                //     handleDateRangeSelection();

                                //     // Add any additional actions you want to perform on applying the date range here

                                //     // Close the modal
                                //     $("#rangeModal").modal("hide");
                                // });
                            });
                        </script>
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
                                        <form id="zendu-booking-filter-form" class="row g-3">



                                            <div class="col-12">
                                                <label class="form-label">लाल देणारी तारीख ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
 $sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT red_giving_date FROM zendu_booking WHERE red_giving_date IS NOT NULL AND red_giving_date != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="red_giving_date">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["red_giving_date"]) . '">' . ($row["red_giving_date"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">शेतकऱ्याचे नाव ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
 $sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT `name` FROM zendu_booking WHERE `name` IS NOT NULL AND `name` != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="farmer_name_filter">

                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["name"]) . '">' . ($row["name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">लाल वनस्पती ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
$sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT red_plants FROM zendu_booking WHERE red_plants IS NOT NULL AND red_plants != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="red_Plant_filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["red_plants"]) . '">' . ($row["red_plants"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">पिवळी वनस्पती ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
$sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT yellow_plants FROM zendu_booking WHERE yellow_plants IS NOT NULL AND yellow_plants != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="yellow_plants_filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["yellow_plants"]) . '">' . ($row["yellow_plants"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">पेमेंट मोड ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
// $sql = "SELECT DISTINCT village FROM zendu_booking";
                                                $sql = "SELECT DISTINCT pay_mode FROM zendu_booking WHERE pay_mode IS NOT NULL AND pay_mode != ''";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="payment_mode_filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["pay_mode"]) . '">' . ($row["pay_mode"]) . '</option>';
                                                    }
                                                    ?>
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
                                        <button type="submit" data-bs-dismiss="modal" onclick="ajaxZenduBooking(1)"
                                            class="btn btn-dark">फिल्टर लागू करा</button>
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
                                <select name="suppliertbl_length" id="Zendu_table_Row_Limit"
                                    onchange="ajaxZenduBooking(1)" aria-controls="suppliertbl"
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
                        <div class="dataTables_filter"><label>Search:<input id="Search_filter_Zendu" type="search"
                                    class="form-control form-control-sm" oninput="logInputValue()" placeholder=""
                                    aria-controls="suppliertbl"></label></div>
                    </div>
                </div>
                <div class="table-responsive" id="Zendu_table">

                </div>















            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="reportsDateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow border">
            <div class="modal-body">
                <form id="date-range-form" class="row g-3 mt-0">
                    <div class="col-12">
                        <label class="form-label">फिल्टर निवडा</label>
                        <select class="form-select form-select-sm" id="report-date-range" name="filter-by">
                            <option value="booking_date">बुकिंग तारीख</option>
                            <option value="red_giving_date">लाल देणारी तारीख</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">कालावधी</label>
                        <select class="form-select form-select-sm" id="report-date-range"
                            onchange="rangeSelect(this.value)">
                            <option value="">कालावधी निवडा</option>
                            <option value="today">
                                <?= translate('today') ?>
                            </option>
                            <option value="yesterday">
                                <?= translate('yesterday') ?>
                            </option>
                            <option value="last_7_days">
                                <?= sprintf(translate('last_n_days'), 7) ?>
                            </option>
                            <option value="last_30_days">
                                <?= sprintf(translate('last_n_days'), 30) ?>
                            </option>
                            <option value="last_90_days">
                                <?= sprintf(translate('last_n_days'), 90) ?>
                            </option>
                            <option value="last_month">
                                <?= translate('last_month') ?>
                            </option>
                            <option value="last_year">
                                <?= translate('last_year') ?>
                            </option>
                            <option value="all">सर्व</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">तारखे पासून</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">
                                <i class="bx bx-calendar-week"></i>
                            </span>
                            <input type="date" name="date-from" class="form-control js-flatpickr"
                                value="<?= $from ? date('Y-m-d', strtotime($from)) : date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">तारखे पर्यंत</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">
                                <i class="bx bx-calendar-week"></i>
                            </span>
                            <input type="date" name="date-to" class="form-control js-flatpickr"
                                value="<?= $to ? date('Y-m-d', strtotime($to)) : date('Y-m-d') ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">रद्द करा</button>
                <button type="submit" form="date-range-form" class="btn btn-sm btn-primary">लागू करा</button>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">स्टॉक जोडा</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="row">
                    <div class="col-12">
                        <form method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-select item_name text-start" name="cat_id" id="cid"
                                            required>
                                            <option value="">श्रेणी निवडा</option>
                                            <?php $query = mysqli_query($connect, "select * from marigold_category where cat_status='1'") ?>
                                            <?php if ($query && mysqli_num_rows($query)): ?>
                                                <?php while ($row1 = mysqli_fetch_assoc($query)): ?>
                                                    <option value="<?= $row1['cat_id'] ?>">
                                                        <?= $row1['cat_name'] ?>
                                                    </option>
                                                <?php endwhile ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                    <div class="col-12 my-3">
                                        <div class="form-group">
                                            <input id="aviqty" type="text" name="ocat_qty" class="form-control"
                                                oninput="allowType(event,'number')" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input id="pnqty" type="text" name="cat_nqty" class="form-control"
                                                oninput="allowType(event,'number')" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_stock" class="btn btn-success me-2 text-white mt-3">जतन
                                करा</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="depositLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="depositLabel">ठेव</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="zendu_id" class="col-form-label">नाव</label>
                        <select name="zendu_id" id="zid" class="form-control mb-3 zid" required>
                            <option value="">शेतकरी निवडा</option>
                            <?php $getzendu = mysqli_query($connect, "SELECT name,zendu_id from zendu_booking where zb_status='1'") ?>
                            <?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
                                <?php while ($getrow = mysqli_fetch_assoc($getzendu)): ?>
                                    <option value="<?= $getrow['zendu_id'] ?>">
                                        <?= $getrow['name'] ?>
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
                            <input type="hidden" name="zendu_id" id='zendu_id' class="form-control" readonly
                                oninput="allowType(event,'number')">
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="deposit_again" class="form-label">पुन्हा ठेव<span
                                    class="text-danger">*</span></label><br>
                            <input type=text name="deposit_again" oninput="allowType(event,'number')" id='deposit_again'
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label for="finally_left" class="form-label">अखेर बाकी<span
                                    class="text-danger">*</span></label><br>
                            <input type=text name="finally_left" id='finally_left' class="form-control" readonly
                                oninput="allowType(event,'number')">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="deposit" class="btn btn-success">जतन करा</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<script>
    $(document).ready(function () {
        $("select.zid").change(function () {
            var x = $(".zid option:selected").val();
            //alert(x);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: { pendingamt: x }
            }).done(function (data) {
                $("#pending_amt").val(data);
            });
        });
    });
    $(document).ready(function () {
        $("select#zid").change(function () {
            var x = $("#zid option:selected").val();
            //   alert(x);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: { zenduid: x }
            }).done(function (data) {
                $("#zendu_id").val(data);
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

    $(document).ready(function () {
        $("select#cid").change(function () {
            var q = $("#cid option:selected").val();
            //alert(q);
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: { _cqty: q }
            }).done(function (data) {
                $("#aviqty").val(data);
            });
        });
    });
</script>
<!-- <script>
    zenduBookingListTbl = $('#zendutbl').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, 'सर्व'],
        ],
        // initComplete: function (settings, json) {
        //     const _date_booking = this.api().table().column(3).data().unique();
        //     $('#booking-filter-date').html('<option value="">सर्व</option>');
        //     for (let i = 0; i < _date_booking.length; i++) {
        //         if (_date_booking[i]) {
        //             $('#booking-filter-date').append(`<option value="${_date_booking[i]}">${_date_booking[i].toTitleCase()}</option>`);
        //         }
        //     }
        //     const filterCity = this.api().table().column(2).data().unique();
        //     $('#farmer-filter').html('<option value="">सर्व</option>');
        //     for (let i = 0; i < filterCity.length; i++) {
        //         if (filterCity[i]) {
        //             $('#farmer-filter').append(`<option value="${filterCity[i]}">${filterCity[i].toTitleCase()}</option>`);
        //         }
        //     }
        //     const filterRed = this.api().table().column(6).data().unique();
        //     $('#red-filter-plant').html('<option value="">सर्व</option>');
        //     for (let i = 0; i < filterRed.length; i++) {
        //         if (filterRed[i]) {
        //             $('#red-filter-plant').append(`<option value="${filterRed[i]}">${filterRed[i].toTitleCase()}</option>`);
        //         }
        //     }
        //     const filterCat = this.api().table().column(8).data().unique();
        //     $('#yellow-filter-plant').html('<option value="">सर्व</option>');
        //     for (let i = 0; i < filterCat.length; i++) {
        //         if (filterCat[i]) {
        //             $('#yellow-filter-plant').append(`<option value="${filterCat[i]}">${filterCat[i].toTitleCase()}</option>`);
        //         }
        //     }
        //     const payModeFilter = this.api().table().column(21).data().unique();
        //     $('#payment_mode_filter').html('<option value="">सर्व</option>');
        //     for (let i = 0; i < payModeFilter.length; i++) {
        //         if (payModeFilter[i]) {
        //             $('#payment_mode_filter').append(`<option value="${payModeFilter[i]}">${payModeFilter[i].toTitleCase()}</option>`);
        //         }
        //     }
        // },
        drawCallback: function () {
            let api = this.api();
            $(api.table().footer()).find('th:eq(7)').html(
                api.column(7, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(9)').html(
                api.column(9, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(10)').html(
                api.column(10, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(11)').html(
                api.column(11, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(12)').html(
                api.column(12, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(13)').html(
                api.column(13, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(14)').html(
                api.column(14, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(15)').html(
                api.column(15, { page: 'current' }).data().sum()
            );
            $(api.table().footer()).find('th:eq(16)').html(
                api.column(16, { page: 'current' }).data().sum().toFixed(2)
            );
            $(api.table().footer()).find('th:eq(17)').html(
                api.column(17, { page: 'current' }).data().sum().toFixed(2)
            );
            $(api.table().footer()).find('th:eq(18)').html(
                api.column(18, { page: 'current' }).data().sum().toFixed(2)
            );
            $(api.table().footer()).find('th:eq(19)').html(
                api.column(19, { page: 'current' }).data().sum().toFixed(2)
            );
            $(api.table().footer()).find('th:eq(20)').html(
                api.column(20, { page: 'current' }).data().sum().toFixed(2)
            );
        },
        buttons: [{
            extend: 'collection',
            text: 'Export',
            className: 'btn-sm btn-outline-dark me-2',
            buttons: [
                'copy',
                'excel',
                'csv',
                //'pdf',
                'print'
            ]
        }]
    });
    zenduBookingListTbl.buttons().container().prependTo('.export-container-zendu');
    $('#zendu-booking-filter-form').on('submit', function (e) {
        e.preventDefault();
        const form = this.elements;
        zenduBookingListTbl.column(3).search(form['booking-filter-date'].value).draw();
        zenduBookingListTbl.column(2).search(form['farmer-filter'].value).draw();
        zenduBookingListTbl.column(6).search(form['red-filter-plant'].value).draw();
        zenduBookingListTbl.column(8).search(form['yellow-filter-plant'].value).draw();
        zenduBookingListTbl.column(21).search(form['payment_mode_filter'].value).draw();

        $('#filterModal').modal('hide');
    });
    function rangeSelect(range) {
        let from = document.querySelector('[name="date-from"]');
        let to = document.querySelector('[name="date-to"]');
        let date = new Date();
        switch (range) {
            case 'today':
                from.value = date.getToday('-');
                date.setDate(date.getDate() + 1);
                to.value = date.getToday('-');
                break;
            case 'yesterday':
                to.value = date.getToday('-');
                date.setDate(date.getDate() - 1);
                from.value = date.getToday('-');
                break;
            case 'last_7_days':
                date.setDate(date.getDate() + 1);
                to.value = date.getToday('-');
                date.setDate(date.getDate() - 7);
                from.value = date.getToday('-');
                break;
            case 'last_30_days':
                date.setDate(date.getDate() + 1);
                to.value = date.getToday('-');
                date.setDate(date.getDate() - 30);
                from.value = date.getToday('-');
                break;
            case 'last_90_days':
                date.setDate(date.getDate() + 1);
                to.value = date.getToday('-');
                date.setDate(date.getDate() - 90);
                from.value = date.getToday('-');
                break;
            case 'last_month':
                date.setMonth(date.getMonth(), 0)
                from.value = date.getToday('-');
                date.setDate(1);
                to.value = date.getToday('-');
                break;
            case 'last_year':
                date.setYear(date.getFullYear() - 1);
                from.value = `${date.getFullYear()}-01-01`;
                to.value = `${date.getFullYear()}-12-31`;
                break;
            case 'all':
                from.value = '1970-01-01';
                date.setDate(date.getDate() + 1);
                to.value = date.getToday('-');
                break;
        }
    }
</script> -->
<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt.buttons.pdfHtml5.customize = function (doc) { doc.defaultStyle.font = 'NotoSans'; };
</script>

<!--     --    -- --     --      -->

<script>
    // Function to check all checkboxes in the same group
    function checkAll(masterCheckbox) {
        console.log("Hello")
        var checkboxes = $(masterCheckbox).closest('table').find('.multi-check-item');
        checkboxes.prop('checked', masterCheckbox.checked);
    }
</script>


<script>
    function unselectfillter() {

        // Example usage
        unselectOption('red_giving_date');
        unselectOption('farmer_name_filter');
        unselectOption('red_Plant_filter');
        unselectOption('payment_mode_filter');
        unselectOption('yellow_plants');
        // filter('CITY', '', 'cus-filter-taluka');
        ajaxZenduBooking(1);
    }
</script>
<script>
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>




<!-- table_sales_history -->
<script>
    function ajaxZenduBooking(page = 1, search = '') {
        // Retrieve selected values from the dropdowns
        var red_giving_date = $('#red_giving_date').val();
        var farmer_name_filter = $('#farmer_name_filter').val();
        var red_Plant_filter = $('#red_Plant_filter').val();
        var payment_mode_filter = $('#payment_mode_filter').val();
        var yellow_plants = $('#yellow_plants').val();
        // var inuptSearch = $('#input_search').val();
        var tableRowLimit = $('#Zendu_table_Row_Limit').val();
        var From = $('#date_from').val();
        var To = $('#date_to').val();
        // console.log("Selected Customer: " + red_giving_date);
        // console.log("Selected Gav: " + farmer_name_filter);
        // console.log("Selected Payment Mode: " + red_Plant_filter);
        // console.log("Selected Payment Status: " + payment_mode_filter);
        // console.log("Table Row Limit: " + yellow_plants);
        $("#Zendu_table").html(loader);
        $.ajax({
            type: "POST",
            url: "ajex_zendu_booking_list",
            data: {
                From : From ,
                To : To ,
                red_giving_date: red_giving_date,
                farmer_name_filter: farmer_name_filter,
                red_Plant_filter: red_Plant_filter,
                yellow_plants: yellow_plants,
                payment_mode_filter: payment_mode_filter,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // console.log("///////////////");
            $("#Zendu_table").html(data);
            initializeDataTable()
        });
    }
</script>

<script>
    $(document).ready(function () {
        ajaxZenduBooking(1);
    });
</script>
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
    function ChangePage(page) {
        var inputValue = $('#Search_filter_Zendu').val();
        ajaxZenduBooking(page, inputValue)
    }
</script>


<script>
    // jQuery function to log the input value and call ajaxSalesHistory
    function logInputValue() {
        var inputValue = $('#Search_filter_Zendu').val();

        console.log('Input Value:', inputValue);
        ajaxZenduBooking(1, inputValue);
    }
</script>

<script>
    function performDelete(tableName, page = 1) {
        if (confirm('विक्री हटवा..?')) {
            // Get checked checkbox values
            var checkedValues = $('#delete_check_box_Zendu:checked').map(function () {
                return this.value;
            }).get();

            console.log(checkedValues);
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
                    console.log(response);
                    alert(response);
                    ajaxCustomerData(page);
                },
                error: function (xhr, status, error) {
                    // Handle the error
                    console.error(error);
                }
            });
        }
    }
</script>
<script>
    function initializeDataTable() {
        $('.export-container-zendu').empty();
        cusListTbl = $('#zendutbl').DataTable({
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
            info: false // Disable information about number of entries
        });


        cusListTbl.buttons().container().prependTo('.export-container-zendu');
    }

</script>