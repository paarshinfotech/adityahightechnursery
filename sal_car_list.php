<?php require "config.php" ?>
<?php
// Aditya::subtitle('साल कार यादी');
// if (isset($_GET['delete']) && isset($_GET['sal_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['sal_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE sal_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE salcar SET salcar_status='0' WHERE sal_id='{$dir}'");
//     }
//     if ($delete) {
//         header("Location: sal_car_list?action=Success&action_msg=साल कार हटवले..!");
//         exit();
//     } else {
//         header('Location: sal_car_list?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }

//add attendance
if (isset($_POST['sal_car_atten'])) {
    escapeExtract($_POST);
    $atten = "INSERT INTO salcar_atten(sal_id, jdate, is_present,leave_reason) VALUES ('$sal_id','$jdate','$is_present','$lreason')";
    $resempa = mysqli_query($connect, $atten);
    if ($resempa) {
        // header('Location: car_rental_list?action=Success&action_msg=Car Rental Added');
        header('Location: sal_car_list');
    } else {
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

//sallery
if (isset($_POST['sallery'])) {
    escapeExtract($_POST);

    $atten = "INSERT INTO `salcar_sallery`(ma_id,sdate,total_days,daily_rs, total_amt) VALUES ('$ma_id','$sdate','$total_days','$daily_rs','$total_amt')";

    $resempa = mysqli_query($connect, $atten);


    if ($resempa) {
        header('Location: sal_car_list');
    } else {
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
        exit();
    }
}

//pick up rs
if (isset($_POST['pickup'])) {
    escapeExtract($_POST);

    $atten = "INSERT INTO salcar_pickup_rs(ma_id, total_amt, pickup_rs, pdate, balance_rs, reason) VALUES ('$ma_id','$total_amt','$pickup_rs','$pdate','$balance_rs','$reason')";
    $respick = mysqli_query($connect, $atten);
    mysqli_query($connect, "UPDATE salcar_sallery SET total_amt=total_amt-$pickup_rs");
    if ($respick) {
        header('Location: sal_car_list');
    } else {
        header('Location: sal_car_list?action=Success&action_msg=somthing went wrong');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">साल कार </h6>
        <div class="dropdown-center">
            <a href="sal_car_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="sal_car_add">नवीन तयार करा</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#male_attendance"
                        data-bs-whatever="@mdo">उपस्थिती</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sal"
                        data-bs-whatever="@mdo">सॅलरी</a></li>

                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#pickup" data-bs-whatever="@mdo">उचल
                        रु</a></li>

                <!--<li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#gave" data-bs-whatever="@mdo">Gave</a></li>-->
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
                                        <form id="salcar-filters-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">कामगाराचे नाव ने फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `worker_name` FROM salcar WHERE `worker_name` IS NOT NULL AND `worker_name` != '' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $worker_name = htmlspecialchars($row["worker_name"]); // Sanitize output
                                                        echo "<option value='$worker_name'>$worker_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">रुजू होण्याची तारीख ने फिल्टर करा </label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `sdate` FROM salcar WHERE `sdate` IS NOT NULL AND `sdate` != '' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="date-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $sdate = htmlspecialchars($row["sdate"]); // Sanitize output
                                                        echo "<option value='$sdate'>$sdate</option>";
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
                                        <button  data-bs-dismiss="modal" onclick="ajaxSalCarlist(1)" form="salcar-filters-form" class="btn btn-dark">फिल्टर
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxSalCarlist(1)"
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

<!--attendance_modal-->
<div class="modal fade" id="male_attendance" tabindex="-1" aria-labelledby="male_attendanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="male_attendanceLabel">कामगारांची उपस्थिती</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="salcaratten">
                    <div class="mb-3">
                        <label for="sal_id" class="col-form-label">नाव</label>
                        <select name="sal_id" id="sal_id" class="form-control mb-3" required>
                            <option>कामगार निवडा</option>
                            <?php $getemp = mysqli_query($connect, "SELECT * from salcar ORDER BY sal_id DESC") ?>
                            <?php if ($getemp && mysqli_num_rows($getemp)): ?>
                                <?php while ($gete = mysqli_fetch_assoc($getemp)): ?>
                                    <option value="<?= $gete['sal_id'] ?>">
                                        <?= $gete['worker_name'] ?>
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jdate" class="col-form-label">तारीख</label>
                        <input type="date" class="form-control" id="jdate" name="jdate"
                            value="<?php echo date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check-inline">
                            <div class="form-group">
                                <input required="" type="radio" onclick="javascript:yesnoCheck();" name="is_present"
                                    id="noCheck" value="present" checked>
                                <label for="noCheck"> उपस्थित</label>

                                <input type="radio" onclick="javascript:yesnoCheck();" name="is_present" id="yesCheck"
                                    value="absent"><label for="yesCheck" class="ms-1"> अनुपस्थित</label>
                            </div>
                        </div>
                        <div id="ifYes" style="visibility:hidden">
                            <input type="text" name='lreason' placeholder="अनुपस्थित कारण" class='form-control mt-2'>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="sal_car_atten" form="salcaratten" class="btn btn-success">जतन करा</button>
            </div>
        </div>
    </div>
</div>

<!--Sallery modal-->
<div class="modal fade" id="sal" tabindex="-1" aria-labelledby="salLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salLabel">कामगार उपस्थिती सॅलरी</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="male_sal">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">नाव</label>
                                <select name="ma_id" id="ma_id" class="form-control mb-3 sal_id" required
                                    onchange="mul(this)">
                                    <option>कामगार निवडा</option>
                                    <?php $getemp = mysqli_query($connect, "SELECT * from salcar d,salcar_atten e WHERE e.sal_id=d.sal_id GROUP BY d.sal_id") ?>
                                    <?php if ($getemp && mysqli_num_rows($getemp)): ?>
                                        <?php while ($gete = mysqli_fetch_assoc($getemp)): ?>
                                            <option value="<?= $gete['sal_id'] ?>">
                                                <?= $gete['worker_name'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">तारीख</label>
                                <input type="date" class="form-control" id="adate" name="sdate"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="amt" class="form-label">एकूण कामकाजाचे दिवस<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="total_days" class="form-control wdays" id="total_days"
                                    placeholder="एकूण दिवस" required oninput="allowType(event, 'number')">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">

                            <div class="form-group">
                                <label for="daily_rs" class="form-label">पगार रु<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control salrs" name="daily_rs" id="daily_rs" required
                                    oninput="allowType(event, 'number')">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="total_amt" class="form-label">एकूण सॅलरी रक्कम<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="total_amt" class="form-control" id="total_amt"
                                placeholder="एकूण सॅलरी रक्कम" required readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="sallery" form="male_sal" class="btn btn-success">जतन करा</button>
            </div>
        </div>
    </div>
</div>

<!--pickuprs-->
<div class="modal fade" id="pickup" tabindex="-1" aria-labelledby="pickupLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupLabel">उचल रु</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="pickuprs">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">नाव</label>
                                <select name="ma_id" id="ma_id" class="form-control mb-3 ma_id wrsal" required>
                                    <option>कामगार निवडा</option>
                                    <?php $getemp = mysqli_query($connect, "SELECT * from salcar_sallery d,salcar e WHERE e.sal_id=d.ma_id GROUP BY d.ma_id") ?>
                                    <?php if ($getemp && mysqli_num_rows($getemp)): ?>
                                        <?php while ($gete = mysqli_fetch_assoc($getemp)): ?>
                                            <option value="<?= $gete['sal_id'] ?>">
                                                <?= $gete['worker_name'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="adate" class="col-form-label">उचल तारीख</label>
                                <input type="date" class="form-control" id="adate" name="pdate"
                                    value="<?php echo date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mt-2">
                            <div class="form-group">
                                <label for="total_amt" class="form-label">एकूण रक्कम<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="total_amt" class="form-control totamt total_amt" id="total_amt"
                                    oninput="allowType(event, 'number')" placeholder="एकूण रक्कम" required readonly>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="pickup_rs" class="col-form-label">उचल रु</label>
                            <input type="text" class="form-control pickup_rs" id="pickup_rs"
                                oninput="allowType(event, 'number')" name="pickup_rs">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="balance_rs" class="col-form-label">शिल्लक रु</label>
                            <input type="text" class="form-control balance_rs" id="balance_rs"
                                oninput="allowType(event, 'number')" name="balance_rs" readonly>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="reason" class="col-form-label">उचल कारण</label>
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


<script>
    $(document).ready(function () {
        $("select.sal_id").change(function () {
            var d = $(".sal_id option:selected").val();
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    salrs: d
                }
            }).done(function (data) {
                $(".salrs").val(data);
            });
        });
    });
    $(document).ready(function () {
        $("select.sal_id").change(function () {
            var r = $(".sal_id option:selected").val();
            $.ajax({
                method: "POST",
                url: "ajax_master",
                data: {
                    workers_days: r
                }
            }).done(function (data) {
                $(".wdays").val(data);
            });
        });
    });

    $(document).ready(function () {
        $("select.wrsal").change(function () {
            var t = $(".wrsal option:selected").val();
            $.ajax({
                type: "POST",
                url: "ajax_master",
                data: {
                    workerstotsal: t
                }
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

    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.visibility = 'visible';
        } else document.getElementById('ifYes').style.visibility = 'hidden';

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
    function ajaxSalCarlist(page = 1, search = '') {


        // var Booking = $('#bookdate-filter').val();
        var Date = $('#date-filter').val();
        var Name = $('#nav-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_sal_car_list",
            data: {
                Date : Date ,
                Name : Name,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#salCarTbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxSalCarlist(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxSalCarlist(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxSalCarlist(1);
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
        unselectSinglOption('date-filter');
        unselectSinglOption('nav-filter');
        // unselectSinglOption('bookdate-filter');
        ajaxSalCarlist(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }
</script>
<script src="assets/js/new_function.js"></script>