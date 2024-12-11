<?php require "config.php" ?>
<?php
Aditya::subtitle('गाडी भाडे श्रेणी यादी');
// if (isset($_GET['delete']) && isset($_GET['car_cat_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['car_cat_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE car_rental_category SET car_cat_status='0' WHERE car_cat_id='{$dir}'");
//     }
//     if ($delete) {
//         header("Location: carrental_category_list?action=Success&action_msg=गाडी भाडे श्रेणी हटवले..!");
//         exit();
//     } else {
//         header('Location: carrental_category_list?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">गाडी भाडे श्रेणी </h6>
        <a class="btn btn-sm btn-success float-end" href="carrental_category_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">

                    </div>
                </div>
            </div>
            <div class="row justify-content-between d-flex">
                <div class=" w-auto ">
                    <div class="dataTables_length" id="suppliertbl_length">
                        <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                            <select name="suppliertbl_length" id="table_Row_Limit"
                                onchange="ajaxCarrentalCategoryData(1)" aria-controls="suppliertbl"
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
                                class="form-control form-control-sm" oninput="logInputValueCustomer()" placeholder=""
                                aria-controls="suppliertbl"></label></div>
                </div>
            </div>
            <div class="table-responsive" id="table_data" style="margin: 10px;">

            </div>
        </div>
    </div>
</div>


<!--end page wrapper -->
<?php include "footer.php"; ?>
<!--     --    -- --     --      -->

<script>
    function ajaxCarrentalCategoryData(page = 1, search = '') {


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
            url: "ajax_carrental_category_list",
            data: {

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
        ajaxCarrentalCategoryData(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxCarrentalCategoryData(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxCarrentalCategoryData(1);
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
    ajaxCarrentalCategoryData(1);
    }
</script> -->
<!-- <script>
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script> -->
<script src="assets/js/new_function.js"></script>