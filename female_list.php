<?php require "config.php" ?>
<?php
// Aditya::subtitle('कर्मचारी महिला यादी');
// if (isset($_GET['delete']) && isset($_GET['emp_id'])){
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['emp_id'] as $dir){
//     //     $delete = mysqli_query($connect, "DELETE FROM employee WHERE emp_id='{$dir}'");
//     // }
//      $delete = mysqli_query($connect, "UPDATE employees SET emp_status='0' WHERE emp_id='{$dir}'");
//     }
//         if($delete){
//     	header("Location: employee_list?action=Success&action_msg=कर्मचारी  हटवले..!");
// 		exit();
//         }else{
//         header('Location: employee_list?action=Success&action_msg=काहीतरी चूक झाली');
//       	exit();
//         }
// }
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">कर्मचारी महिला यादी</h6>
        <div class="dropdown-center">
            <a href="employee_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="employee_add">नवीन तयार करा</a></li>
                <!--<li><a class="dropdown-item"  href="employee_list">सर्व बघा</a></li>-->
                <li><a class="dropdown-item" href="female_attendance">हजेरी</a></li>
                <li><a class="dropdown-item" href="female_salery">पगार</a></li>
                <li><a class="dropdown-item" href="pickup">उचल / ऍडव्हान / उसने</a></li>


            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">
                        <div class="export-container"></div>
                    </div>
                </div>
                <div class="row justify-content-between d-flex">
                    <div class=" w-auto ">
                        <div class="dataTables_length" id="suppliertbl_length">
                            <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxMaleEmpolyee(1)"
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
                <div class="table-responsive " id="table_data">

                </div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>

<!--     --    -- --     --      -->

<script>
    function ajaxMaleEmpolyee(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_male_list",
            data: {
                Gender : 'female' ,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#example2');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxMaleEmpolyee(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxMaleEmpolyee(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxMaleEmpolyee(1);
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

<!-- <script>
    function unselectfillter(){
        
    // Example usage
    unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
    filter('CITY', '', 'cus-filter-taluka');
    ajaxMaleEmpolyee(1);
    }
</script> -->
<!-- <script>
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script> -->
<script src="assets/js/new_function.js"></script>