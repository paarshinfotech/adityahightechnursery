<?php require "config.php" ?>
<?php
Aditya::subtitle('प्रॉडक्ट श्रेणी यादी');
// if (isset($_GET['delete']) && isset($_GET['cat_id'])){
//     escapePOST($_GET);
   
//     //del profile and driver 
//     foreach ($_GET['cat_id'] as $dir){
//     //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//     // }
//      $delete = mysqli_query($connect, "UPDATE category_product SET product_cat_status='0' WHERE cat_id='{$dir}'");
//     }
//         if($delete){
//     	header("Location: product_category_list?action=Success&action_msg=प्रॉडक्ट श्रेणी हटवले..!");
// 		exit();
//         }else{
//         header('Location: product_category_list?action=Success&action_msg=काहीतरी चूक झाली');
//       	exit();
//         }
// }
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">प्रॉडक्ट श्रेणी </h6>
            <a class="btn btn-sm btn-success float-end" href="product_category_add" style="margin-top:-25px;">
			<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
		<hr/>
		<div class="card">
			<div class="card-body">
			     <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">
                        <div class="export-container"></div>
                        <!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
                        <!--    Filters <i class="bx bx-filter"></i>-->
                        <!--</button>-->
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">Filters</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <button class="btn btn-link px-0 me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(vendorListTbl, '#vendor-filters-form')">Clear all filters</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" form="vendor-filters-form" class="btn btn-dark">Apply</button>
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
                                    onchange="ajaxProductCategoryData(1)" aria-controls="suppliertbl"
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
<!--     --    -- --     --      -->

<script>
    function ajaxProductCategoryData(page = 1, search = '') {

    
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
            url: "ajax_product_category_list",
            data: {
                
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#example2' );
        });
    }
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
function ChangePage(page){
	var inputValue = $('#Search_filter').val();
	ajaxProductCategoryData(page, inputValue )
}
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxProductCategoryData(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxProductCategoryData(1);
    });
</script>




<script>
    function unselectfillter(){
        
    // Example usage
    unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
    filter('CITY', '', 'cus-filter-taluka');
    ajaxProductCategoryData(1);
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
        var checkedValues = $(checkboxSelector + ':checked').map(function() {
            return this.value;
        }).get();

        // Perform AJAX call
        $.ajax({
            type: 'POST',
            url: 'ajax_delete_checked_item', // Replace with your server-side script
            data: {
                checkboxValues: checkedValues,
                tableName: tableName
            }
        }).done(function(data) {
            console.log(data);  // <-- Corrected from response to data
            alert(data);
            ajaxCallback(page);
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