<?php require "config.php" ?>
<?php
Aditya::subtitle('आउट स्टँडिंग रिपोर्ट्स यादी');

//adv_sales
if (isset($_POST['adv_sales'])) {
	escapePOST($_POST);
	$advance = $_POST['bal_amt'];
	$again_adv_amt = $_POST['again_adv_amt'];
	$balance = $_POST['totbal'];
	$paystatus = ($balance > 0) ? 'unpaid' : 'paid';
	$status = ($paystatus != 'unpaid') ? 'completed' : 'pending';

	$_BAL = $advance - $again_adv_amt;
	$advSaleRes = mysqli_query($connect, "UPDATE sales SET
    again_adv_amt='{$advance}',
    advance='{$again_adv_amt}',
    balance='$_BAL',
    paystatus = '{$paystatus}',
    status = '{$status}' WHERE sale_id='{$_POST['cus_id']}'");

	if ($advSaleRes) {
		header('Location: outstanding_report?action=Success&action_msg=ग्राहकाची ₹ ' . $again_adv_amt . ' /- जमा झाले..!');
		exit();
	} else {
		header("Location: outstanding_report");
		exit();
	}
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">आउट स्टँडिंग रिपोर्ट्स</h6>
		<a class="btn btn-sm btn-success float-end" href="sales" style="margin-top:-25px;">
			<i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
		<hr />
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12">
						
						<?php include 'includ_Advance.php' ?>

						<div class="d-flex mb-3">
							<div class="ms-auto p-2 d-flex ">
								<div class="export-container"></div>
								<!--<button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">-->
								<!--    फिल्टर <i class="bx bx-filter"></i>-->
								<!--</button>-->
								<!--Filter Modal -->
								<!-- <div class="modal fade" id="filterModal" data-bs-backdrop="static"
									data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel"
									aria-hidden="true">
									<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal"
													aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<form id="customer-filters-form" class="row g-3">
													<div class="col-12">
														<label class="form-label">ग्राहक फिल्टर करा</label>
														<select class="form-select" id="cus-filter">
															<option value="">सर्व</option>
														</select>
													</div>

												</form>
											</div>
											<div class="modal-footer border-top-0">
												<button class="btn btn-outline-light border text-danger me-auto"
													data-bs-dismiss="modal"
													onclick="clearDataTableFilters(cusListTbl, '#customer-filters-form')">सर्व
													फिल्टर हटवा</button>
												<button type="button" class="btn btn-outline-dark border"
													data-bs-dismiss="modal">बंद करा</button>
												<button type="submit" form="customer-filters-form"
													class="btn btn-dark">फिल्टर लागू करा</button>
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
										<select name="suppliertbl_length" id="table_Row_Limit"
											onchange="ajaxOutstandingReportData(1)" aria-controls="suppliertbl"
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
								<div class="dataTables_filter"><label>Search:<input id="Search_filter"
											type="search" class="form-control form-control-sm"
											oninput="logInputValueOutstandingRepor()" placeholder=""
											aria-controls="suppliertbl"></label></div>
							</div>
						</div>
						<div class="table-responsive" id="table_Outstanding_Repor_data">

						</div>

					</div>
					<!--priview modal-->
					
				</div>
			</div>
		</div>
	</div>
</div>
<!--end page wrapper -->
<script>
$(document).ready(function() {
	$("#bal_amt, #adv_amt").on("input change", advsub);
	$("#cus_id").change(function() {
		var b = $("#cus_id option:selected").val();
		//alert(q);
		$.ajax({
			type: "POST",
			url: "ajax_master",
			data: {
				balamt: b
			}
		}).done(function(data) {
			$("#bal_amt").val(data);
		});
	});
});

function advsub() {
	let amt = $('#bal_amt').val();
	let adv = $('#adv_amt').val();
	let _resbal = Number(amt) - Number(adv);

	$('#totbal').val(!isNaN(_resbal) ? _resbal : 0).trigger('change');
}
</script>
<?php include "footer.php"; ?>

<script src="assets/js/vfs_fonts.js"></script>
<script>
$.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
	.buttons.pdfHtml5.customize = function(doc) {
		doc.defaultStyle.font = 'NotoSans';
	};
</script>


<!--  -->
<!-- CustomerData -->
<!--  -->
<script>
function ajaxOutstandingReportData(page = 1, search = '') {
	// Retrieve selected values from the dropdowns
	// var inuptSearch = $('#input_search').val();
	var tableRowLimit = $('#table_Row_Limit').val();
	var inputValue = $('#Search_filter').val();

	//console.log("page data : " + page);
	//console.log("input Value data : " + inputValue);

	//console.log("Table Row Limit: " + tableRowLimit);
	
	$("#table_Outstanding_Repor_data").html(loader);
	$.ajax({
		type: "POST",
		url: "ajax_outstanding_report_data",
		data: {
			tableRowLimit: tableRowLimit,
			Search: search,
			page: page
		}
	}).done(function(data) {
		// //console.log("///////////////");
		$("#table_Outstanding_Repor_data").html(data);

		initializeDataTable('export-container', '#outStanding-salestbl');
	});
}
</script>
<script>
// jQuery function to log the input value and call ajaxSalesHistory
function logInputValueOutstandingRepor() {
	var inputValue = $('#Search_filter').val();

	// //console.log('Input Value:', inputValue);
	ajaxOutstandingReportData(1, inputValue);
}
</script>
<script>
$(document).ready(function() {
	ajaxOutstandingReportData(1);
});
</script>


<script>
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
</script>
<script>
// const loader = `<div style="width: 100%; height: 30vh; "><div  class="loaderStyles" ></div></div>`;
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

// document.body.innerHTML = loaderDiv;
</script>
<script>
function ChangePage(page){
	var inputValue = $('#Search_filter').val();
	ajaxOutstandingReportData(page, inputValue )
}
</script>