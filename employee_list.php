<?php require "config.php" ?>
<?php
Aditya::subtitle('कर्मचारी यादी');
if (isset($_GET['delete']) && isset($_GET['emp_id'])) {
    escapePOST($_GET);

    //del profile and driver 
    foreach ($_GET['emp_id'] as $dir) {
        //     $delete = mysqli_query($connect, "DELETE FROM employee WHERE emp_id='{$dir}'");
        // }
        $delete = mysqli_query($connect, "UPDATE employees SET emp_status='0' WHERE emp_id='{$dir}'");
    }
    if ($delete) {
        header("Location: employee_list?action=Success&action_msg=कर्मचारी  हटवले..!");
        exit();
    } else {
        header('Location: employee_list?action=Success&action_msg=काहीतरी चूक झाली');
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">कर्मचारी यादी</h6>
        <a class="btn btn-sm btn-success float-end" href="employee_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>

        <!--<div class="dropdown-center">-->
        <!--             <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">-->
        <!--             <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>-->
        <!--                <ul class="dropdown-menu">-->
        <!--                  <li><a class="dropdown-item"  href="employee_add">नवीन तयार करा</a></li>-->
        <!--<li><a class="dropdown-item"  href="employee_list">सर्व बघा</a></li>-->
        <!--                  <li><a class="dropdown-item"  href="attendance">हजेरी</a></li>-->
        <!--                   <li><a class="dropdown-item" href="sallery">पगार</a></li>-->
        <!--                  <li><a class="dropdown-item"  href="pickup">उचल / ऍडव्हान / उसने</a></li>-->


        <!--                </ul>-->
        <!--          </div>-->
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
                                        <form id="emp-filter-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">कर्मचाऱ्याचे नाव ने फिल्टर करा</label>
                                                 <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `emp_name` FROM employees WHERE `emp_name` IS NOT NULL AND `emp_name` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                     <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["emp_name"]) . '">' . ($row["emp_name"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">रुजू होण्याची तारीख ने फिल्टर करा </label>
                                                 <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `emp_joined` FROM employees WHERE `emp_joined` IS NOT NULL AND `emp_joined` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="joining-date-filter">
                                                    <option value="">सर्व</option>
                                                     <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["emp_joined"]) . '">' . ($row["emp_joined"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">लिंग ने फिल्टर करा</label>
                                                 <?php
                                                // SQL query to get unique villages
                                                // $sql = "SELECT DISTINCT village FROM customer";
                                                $sql = "SELECT DISTINCT `emp_gender` FROM employees WHERE `emp_gender` IS NOT NULL AND `emp_gender` != '';";

                                                $result = mysqli_query($connect, $sql);

                                                ?>
                                                <select class="form-select" id="gender-filter">
                                                    <option value="">सर्व</option>
                                                     <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . ($row["emp_gender"]) . '">' . ($row["emp_gender"]) . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal"
                                            onclick="unselectfillter()">सर्व फिल्टर
                                            हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button onclick="ajaxEmployee(1)" data-bs-dismiss="modal" form="emp-filter-form" class="btn btn-dark">फिल्टर लागू
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
                                <select name="suppliertbl_length" id="table_Row_Limit"
                                    onchange="ajaxEmployee(1)" aria-controls="suppliertbl"
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
<?php include "footer.php"; ?>

<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt.buttons.pdfHtml5.customize = function (doc) { doc.defaultStyle.font = 'NotoSans'; };
</script>

<!--     --    -- --     --      -->

<script>
    function ajaxEmployee(page = 1, search = '') {

    
        var name = $('#nav-filter').val();
        var joining = $('#joining-date-filter').val();
        var gender = $('#gender-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        console.log(joining);
        console.log(gender);
        console.log(name);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_employee_list",
            data: {
                
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page,
                Name : name,
                Gender: gender,
                Joining : joining 

            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#emptbl' );
        });
    }
</script>




<script>
function ChangePage(page){
	var inputValue = $('#Search_filter').val();
	ajaxEmployee(page, inputValue )
}
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxEmployee(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxEmployee(1);
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
    unselectSinglOption("joining-date-filter");
    unselectSinglOption("nav-filter");
    unselectSinglOption("gender-filter");
    // unselectSinglOption("pay-filter");


    // filter('CITY', '', 'cus-filter-taluka');
    ajaxEmployee(1);
    }
</script>
<script>
    function unselectSinglOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>
