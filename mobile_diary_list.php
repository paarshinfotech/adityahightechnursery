<?php require "config.php" ?>
<?php
// Aditya::subtitle('मोबाइल डायरी  यादी');
// if (isset($_GET['delete']) && isset($_GET['mob_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['mob_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM mobile_diary WHERE mob_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE mobile_diary SET status='0' WHERE mob_id='{$dir}'");
//     }
//     if ($delete) {
//         header("Location: mobile_diary_list?action=Success&action_msg=मोबाइल डायरी  हटवले..!");
//         exit();
//     } else {
//         header('Location: mobile_diary_list?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">मोबाइल डायरी </h6>
        <a class="btn btn-sm btn-success float-end" href="mobile_diary_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
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
                                        <form id="mobile-filters-form" class="row g-3">

                                            <div class="col-12">
                                                <label class="form-label">गावानुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `village` FROM mobile_diary WHERE `village` IS NOT NULL AND `village` != '' ;";

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
                                        <button  data-bs-dismiss="modal" onclick="ajaxMobileDiarylist(1)" form="mobile-filters-form" class="btn btn-dark">फिल्टर
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxMobileDiarylist(1)"
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
<!-- <script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };
</script> -->


<!--     --    -- --     --      -->

<script>
    function ajaxMobileDiarylist(page = 1, search = '') {


        // var Booking = $('#bookdate-filter').val();
        // var Name = $('#nav-filter').val();
        var village = $('#gav-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_mobile_diary_list",
            data: {
                village: village,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#mobtbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxMobileDiarylist(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxMobileDiarylist(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxMobileDiarylist(1);
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
        unselectSinglOption('gav-filter');
        // unselectSinglOption('nav-filter');
        // unselectSinglOption('bookdate-filter');
        ajaxMobileDiarylist(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>