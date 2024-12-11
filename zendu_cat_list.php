<?php require "config.php" ?>
<?php
// Aditya::subtitle('झेंडू  श्रेणी यादी');
// if (isset($_GET['delete']) && isset($_GET['cat_id'])){
//     escapePOST($_GET);
   
//     //del profile and driver 
//     foreach ($_GET['cat_id'] as $dir){
//     //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//     // }
//      $delete = mysqli_query($connect, "UPDATE marigold_category SET cat_status='0' WHERE cat_id='{$dir}'");
//     }
//         if($delete){
//     	header("Location: zendu_cat_list?action=Success&action_msg=झेंडू  श्रेणी हटवले..!");
// 		exit();
//         }else{
//         header('Location: zendu_cat_list?action=Success&action_msg=काहीतरी चूक झाली');
//       	exit();
//         }
// }
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">झेंडू  श्रेणी </h6>
            <a class="btn btn-sm btn-success float-end" href="zendu_cat_add" style="margin-top:-25px;">
			<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
		<hr/>
		<div class="card">
			<div class="card-body">
			     <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                       <div class="export-container"> </div>
                    </div>
                </div>
				<div class="row justify-content-between d-flex">
                    <div class=" w-auto ">
                        <div class="dataTables_length" id="suppliertbl_length">
                            <label style="display: inline-flex; align-items: center; gap: 5px; ">Show
                                <select name="suppliertbl_length" id="table_Row_Limit"
                                    onchange="ajaxZanduCategoryData(1)" aria-controls="suppliertbl"
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
				 <div class="table-responsive" id="table_responsive">
					
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<?php include "footer.php"; ?>

<!--     --    -- --     --      -->

<script>
    function ajaxZanduCategoryData(page = 1, search = '') {

    
        // var city = $('#cus-filter-city').val();
        // var taluka = $('#cus-filter-taluka').val();
        // var village = $('#cus-filter-village').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_responsive").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_zendu_cat_list",
            data: {
                
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_responsive").html(data);
            initializeDataTable('export-container', '#example2' );
        });
    }
</script>




<script>
function ChangePage(page){
	var inputValue = $('#Search_filter').val();
	ajaxZanduCategoryData(page, inputValue )
}
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxZanduCategoryData(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxZanduCategoryData(1);
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
    ajaxZanduCategoryData(1);
    }
</script> -->
<!-- <script>
    function unselectOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script> -->
<script src="assets/js/new_function.js"></script>
