<?php require "config.php" ?>
<?php
$from = isset($_GET['date-from']) ? date('Y-m-d', strtotime($_GET['date-from'])) : null;
$to = isset($_GET['date-to']) ? date('Y-m-d', strtotime($_GET['date-to'])) : null;

// Aditya::subtitle('गाडी भाडे तपशील यादी');
// if (isset($_GET['delete']) && isset($_GET['cr_id'])) {
//     escapePOST($_GET);
//     foreach ($_GET['cr_id'] as $dir) {
//         $delete = mysqli_query($connect, "UPDATE car_rental SET car_status='0' WHERE cr_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: car_rental_category?action=Success&action_msg=गाडी भाडे तपशील हटवले..!');
//         exit();
//     } else {
//         header('Location: car_rental_category&action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }

if (isset($_POST['adv'])) {
    escapeExtract($_POST);

    $carinsert = "INSERT INTO `car_rental_adv`(adv_cr_id,advdate,advrs,reason) VALUES ('$cr_id','$advdate','$advrs','$reason')";

    $rescar = mysqli_query($connect, $carinsert);
    $adv_id = mysqli_insert_id($connect);

    mysqli_query($connect, "UPDATE car_rental SET deposit_rs = deposit_rs - {$advrs} WHERE cr_id = '{$cr_id}'");

    if ($rescar) {
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header("Location: car_rental_list?car_cat_id={$_GET['car_cat_id']}&action=Success&action_msg=ग्राहकाचे ₹ {$advrs} /- जमा झाले");
        exit();
    } else {
        header("Location: car_rental_list?{$_GET['car_cat_id']}&action=Success&action_msg=काहीतरी चूक झाली");
        exit();
    }
}
$carList = array();
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">गाडी भाडे तपशील</h6>
        <div class="dropdown-center">
            <a href="car_rental_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="car_rental_add">नवीन तयार करा</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv">ऍडव्हान्स</a></li>
            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container"></div>
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
                                                    <input type="date" name="date-to" id="date_to" class="form-control js-flatpickr">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">रद्द करा</button>
                                        <button  data-bs-dismiss="modal" type="button" onclick="ajaxCarRant(1)" class="btn btn-sm btn-primary" id="apply-date-range">लागू
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
                                        <form id="carRental-filter-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">नावा नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `name` FROM car_rental WHERE car_cat_id = " . $_GET['car_cat_id'] . " AND `name` IS NOT NULL AND `name` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["name"]) . '">' . ($row["name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावा नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `village_name` FROM car_rental WHERE car_cat_id = " . $_GET['car_cat_id'] . " AND `village_name` IS NOT NULL AND `village_name` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="gav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["village_name"]) . '">' . ($row["village_name"]) . '</option>';
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
                                        <button data-bs-dismiss="modal" onclick="ajaxCarRant(1)"
                                            form="carRental-filter-form" class="btn btn-dark">फिल्टर
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxCarRant(1)"
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

<!--Advance modal-->
<div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advLabel">ऍडव्हान्स
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">नाव</label>
                        <select name="cr_id" class="form-control mb-3" required>
                            <option>कर्मचारी निवडा</option>
                            <?php $getcustomert = mysqli_query($connect, "SELECT * from car_rental where car_status='1'") ?>
                            <?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
                                <?php while ($getcus = mysqli_fetch_assoc($getcustomert)): ?>
                                    <option value="<?= $getcus['cr_id'] ?>">
                                        <?= $getcus['name'] ?>
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">तारीख</label>
                        <input type="date" class="form-control" id="adate" name="advdate"
                            value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="rs" class="col-form-label">रुपये</label>
                        <input type="text" class="form-control" id="rs" name="advrs"
                            oninput="allowType(event,'number')">
                    </div>
                    <div class="mb-3">
                        <label for="pick_up_extra" class="col-form-label">कारण</label>
                        <input type="text" class="form-control" id="pick_up_extra" name="reason">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="adv" class="btn btn-primary">जतन करा</button>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
<!-- <script>
carRentalListTbl = $('#carrentaltbl').DataTable({
    lengthMenu: [
        [10, 25, 50, 100, 500, -1],
        [10, 25, 50, 100, 500, 'सर्व'],
    ],
    initComplete: function(settings, json) {
        const nameFilter = this.api().table().column(7).data().unique();
        $('#nav-filter').html('<option value="">सर्व</option>');
        for (let i = 0; i < nameFilter.length; i++) {
            if (nameFilter[i]) {
                $('#nav-filter').append(`<option value="${nameFilter[i]}">${nameFilter[i].toTitleCase()}</option>`);
            }
        }
        const filterPin = this.api().table().column(2).data().unique();
        $('#gav-filter').html('<option value="">सर्व</option>');
        for (let i = 0; i < filterPin.length; i++) {
            if (filterPin[i]) {
                $('#gav-filter').append(`<option value="${filterPin[i]}">${filterPin[i].toTitleCase()}</option>`);
            }
        }
    },
    drawCallback: function () {
        let api = this.api();
        $(api.table().footer()).find('th:eq(1)').html(
            api.column(4, {page:'current'}).data().sum().toFixed(2)
        );
        $(api.table().footer()).find('th:eq(2)').html(
            api.column(5, {page:'current'}).data().sum().toFixed(2)
        );
        $(api.table().footer()).find('th:eq(3)').html(
            api.column(6, {page:'current'}).data().sum().toFixed(2)
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
carRentalListTbl.buttons().container().prependTo('.export-container');
$('#carRental-filter-form').on('submit', function(e) {
    e.preventDefault();
    const form = this.elements;
    carRentalListTbl.column(7).search(form['nav-filter'].value).draw();
    carRentalListTbl.column(2).search(form['gav-filter'].value).draw();

    $('#filterModal').modal('hide');
});
function rangeSelect(range) {
    let from = document.querySelector('[name="date-from"]');
    let to = document.querySelector('[name="date-to"]');
    let date = new Date();
    switch(range) {
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
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };
</script>

<!--     --    -- --     --      -->

<script>
    function ajaxCarRant(page = 1, search = '') {


        var village = $('#gav-filter').val();
        var name = $('#nav-filter').val();
        var From = $('#date_from').val();
        var To = $('#date_to').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        console.log(name);
        console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_car_rental_list",
            data: {
                From : From ,
                To : To ,
                name: name,
                village: village,
                CategoryID: <?php echo $_GET['car_cat_id'] ?>,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#example2');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxCarRant(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxCarRant(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxCarRant(1);
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
    unselectSinglOption('gav-filter');
    unselectSinglOption('nav-filter');

    ajaxCarRant(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>