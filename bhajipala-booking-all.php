<?php
require_once "config.php";
Aditya::subtitle('सर्व भाजी पाला बुकिंग');
$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('d-m-Y');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('d-m-Y', strtotime("{$from} + 1 day"));
require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			    <h4 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class='bx bx-left-arrow-circle'></i></a>
					<span>सर्व भाजी पाला बुकिंग</span>
				</h4>
			    <div class="card">
			        <div class="card-body">
			          <div class="d-flex mb-3">
                        <div class="ms-auto p-2 d-flex export-container-zendu">
                        <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#reportsDateRangeModal">
                              कालावधी
                            <i class="bx bx-calendar-week"></i></button>
                            <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                                 फिल्टर <i class="bx bx-filter"></i>
                            </button>
                        
                            <!-- Modal -->
                            <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="zendu-booking-filter-form" class="row g-3">
                                                                        <div class="col-12">
                                                                            <label class="form-label">बुकिंग तारीख ने फिल्टर करा</label>
                                                                            <select class="form-select" id="bookdate-filter">
                                                                                <option value="">सर्व</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label">दिलेली तारीख ने फिल्टर करा</label>
                                                                            <select class="form-select" id="givendate-filter">
                                                                                <option value="">सर्व</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label">देण्याची तारीख ने फिल्टर करा</label>
                                                                            <select class="form-select" id="delidate-filter">
                                                                                <option value="">सर्व</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label">शेतकऱ्याचे नाव ने फिल्टर करा</label>
                                                                            <select class="form-select" id="nav-filter">
                                                                                <option value="">सर्व</option>
                                                                            </select>
                                                                        </div>
                                                                        <!--<div class="col-12">-->
                                                                        <!--    <label class="form-label">लाल उपवर्ग ट्रे ने फिल्टर करा </label>-->
                                                                        <!--    <select class="form-select" id="redsubcat-filter">-->
                                                                        <!--        <option value="">सर्व</option>-->
                                                                        <!--    </select>-->
                                                                        <!--</div>-->
                                                                        <!--<div class="col-12">-->
                                                                        <!--    <label class="form-label">लाल उपवर्ग वाफा ने फिल्टर करा </label>-->
                                                                        <!--    <select class="form-select" id="redvafa-filter">-->
                                                                        <!--        <option value="">सर्व</option>-->
                                                                        <!--    </select>-->
                                                                        <!--</div>-->
                                                                        <!--<div class="col-12">-->
                                                                        <!--    <label class="form-label">पिवळ्या उपवर्ग ट्रे ने फिल्टर करा </label>-->
                                                                        <!--    <select class="form-select" id="yellow-filter-tray">-->
                                                                        <!--        <option value="">सर्व</option>-->
                                                                        <!--    </select>-->
                                                                        <!--</div>                                            <div class="col-12">-->
                                                                        <!--    <label class="form-label">पिवळ्या उपवर्ग वाफा ने फिल्टर करा </label>-->
                                                                        <!--    <select class="form-select" id="yellow-filter-vafa">-->
                                                                        <!--        <option value="">सर्व</option>-->
                                                                        <!--    </select>-->
                                                                        <!--</div>-->
                                                                       
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer border-top-0">
                                                                    <button class="btn btn-outline-light border text-danger me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(bhajipalListTbl, '#zendu-booking-filter-form')">सर्व फिल्टर हटवा</button>
                                                                    <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">बंद करा</button>
                                                                    <button type="submit" form="zendu-booking-filter-form" class="btn btn-dark">फिल्टर लागू करा</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                    
                                </div>
                    </div>
        				 <div class="table-responsive">
					<table border="1" id="bhajipalTbl" class="table table-striped table-bordered table-hover multicheck-container">
						<thead>
							<tr>
								<th>
									<?php //if ($auth_permissions->brand->can_delete): ?>
								    <!--<div class="d-inline-flex align-items-center select-all">-->
								    <!--    <input type="checkbox" class="multi-check-all mt-0 form-check-input fs-6">-->
			         <!--                   <div class="dropdown">-->
			         <!--                   	<button class="btn btn-sm dropdown" type="button" id="category-action" data-bs-toggle="dropdown" aria-expanded="false">-->
			         <!--                   		<i class='bx bx-slider-alt fs-6'></i>-->
			         <!--                   	</button>-->
			         <!--                   	<ul class="dropdown-menu" aria-labelledby="category-action">-->
			         <!--                   		<li>-->
			         <!--                   			<a title="झेंडू बुकिंग हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('झेंडू  बुकिंग हटवा..?');">-->
			         <!--                   				<i class="btn-round bx bx-trash me-2"></i>झेंडू बुकिंग हटवा-->
			         <!--                   			</a>-->
			         <!--                   		</li>-->
			         <!--                   	</ul>-->
			         <!--                   </div>-->
								    <!--</div>-->
									<?php //endif ?>
									बुकिंग नं.
								</th>
    							    <th>बुकिंग तारीख</th>
                                    <th>दिलेली तारीख</th>
                                    <th>देण्याची तारीख</th>
                                    <th>शेतकऱ्याचे नाव</th>
                                   <th>प्रॉडक्टचे नाव</th>       
                                    <th>संख्या</th>
                                    <th>दर</th>
                                    <th>एकूण रक्कम</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getBhajipalaSales = mysqli_query($connect, "SELECT s.*, d.*, p.* FROM bhajipala_sales s JOIN bhajipala_sales_details d ON s.sale_id = d.sale_id JOIN product p ON d.pid = p.product_id WHERE s.is_not_delete = '1' AND s.sdate >= '{$from}' AND s.sdate < '{$to}' ORDER BY s.sdate ASC") ?>
                            <?php if (mysqli_num_rows($getBhajipalaSales)>0): ?>
                                <?php 
                                $bhajipalaList = array();
                                while ($bhajipalaFetch = mysqli_fetch_assoc($getBhajipalaSales)): 
                                array_push($bhajipalaList, $bhajipalaFetch);
                                extract($bhajipalaFetch);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <!--<input type="checkbox" class="multi-check-item" name="zendu_id[]" value="<?//= $zendu_id ?>">-->
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                               
                                <!--<td>-->
                                <!--    <a class="text-decoration-none" href="zendu_booking_add?zendu_id=<?//= $zendu_id;?>">-->
                                <!--        <?//= $cat_name; ?>-->
                                <!--    </a>-->
                                <!--</td>-->
                                <td class="text-success fw-bold"><?= date('d M Y',strtotime($sdate))?></td>
                                               
                                                <td class="text-dark fw-bold"><?= date('d M Y',strtotime($given_date)) ?></td>
                                                <td class="text-danger fw-bold"><?= date('d M Y',strtotime($deli_date))?></td>
                                                 
                                                  <td data-bs-toggle="modal" data-bs-target="#info<?php echo $sale_id;?>"class="text-success"><?= $far_name?></td>
                                                 <td><?= $product_name?></td>
                                                  <td><?= $pqty?></td>
                                                  <td class="rupee-after"><?= $pprice?></td> 
                                                  <td class="rupee-after"><?= $sub_total?></td>
                                            </tr>
                                            <?php error_reporting(0);
                                            $totPQTY += $pqty;
                                            $totPrice += $pprice;
                                            $subTot += $sub_total;
                                            
                                            ?>
                                <?php endwhile ?>
                            <?php endif ?>
						</tbody>
						<?php error_reporting(0);?>
        						<tfoot>
        				            <tr>
        				                <th></th>
        				                <th></th>
        				                <th></th>
        				                <th></th>
        				                <th></th>
        				                
                					    <th>एकूण</th>
                    					<th>
                    					    <!--<?= $totPQTY; ?>-->
                    					 </th>
                    					<th class="rupee-after">
                    					    <!--<?= $totPrice; ?>-->
                    					</th>
                    					<th class="rupee-after">
                    					    <!--<?= $subTot; ?>-->
                    					 </th>
        				                </tr>
        			            </tfoot>
					</table>
				</div>
        				<div class="reports-table-footer"></div>
			        </div>
			    </div>
		    </div>
		</div>
		<div class="modal fade" id="reportsDateRangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reportsDateRangeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-body">
				<form id="date-range-form" class="row g-3 mt-0">
					<div class="col-12">
						<input type="hidden" name="show" value="sales-all">
						<label class="form-label">कालावधी</label>
						<select class="form-select form-select-sm" id="report-date-range" onchange="rangeSelect(this.value)">
							<option value="">कालावधी निवडा</option>
							<option value="today"><?= translate('today') ?></option>
							<option value="yesterday"><?= translate('yesterday') ?></option>
							<option value="last_7_days"><?= sprintf(translate('last_n_days'), 7) ?></option>
							<option value="last_30_days"><?= sprintf(translate('last_n_days'), 30) ?></option>
							<option value="last_90_days"><?= sprintf(translate('last_n_days'), 90) ?></option>
							<option value="last_month"><?= translate('last_month') ?></option>
							<option value="last_year"><?= translate('last_year') ?></option>
							<option value="all">सर्व</option>
						</select>
					</div>
					<div class="col-6">
						<label for="" class="form-label">तारखे पासून</label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="date" name="date-from" class="form-control js-flatpickr" value="<?= date('Y-m-d') ?>" >
							<!--data-hs-flatpickr-options='{"dateFormat": "d-m-Y"}'-->
						</div>
					</div>
					<div class="col-6">
						<label for="" class="form-label">तारखे पर्यंत</label>
						<div class="input-group input-group-sm">
							<span class="input-group-text">
								<i class="bi-calendar-week fs-5"></i>
							</span>
							<input type="date" name="date-to" class="form-control js-flatpickr" value="<?= date('Y-m-d') ?>" >
							<!--data-hs-flatpickr-options='{"dateFormat": "d-m-Y"}'-->
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
<?php 
error_reporting(0);
//if(isset($bhajipalaFetch)){?>
<?php foreach ($bhajipalaList as $bhajipalaFetch): ?>
                    <?php extract($bhajipalaFetch);
                    ?>
         <div class="modal fade" id="info<?php echo $sale_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="infoLabel<?php echo $sale_id;?>">शेतकऱ्याची बुकिंग तपशील</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-primary mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $far_name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $mob_no?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>बुकिंग तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($sdate));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>दिलेली तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($given_date));?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>देण्याची तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $deli_date;?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>गावाचे नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $village?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-primary mb-0">उत्पादनांचे वर्णन</h6>
						        					</td>
						        				</tr>
						        		
						        			</tbody>
						        		</table>
						        		<table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>अ.क्र.</th>
                                                    <th>मालाचे विवरण</th>
                                                     <th>प्रकार</th>
                                                    <!--<th>संख़्या</th>-->
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                if(isset($bhajipalaFetch['sale_id'])):
                                                $getcuspro = "SELECT * FROM bhajipala_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN bhajipala_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$bhajipalaFetch['sale_id']}'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $pid?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $product_varity?></td>
                                                
                                                <td><?= $product_amount?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">एकूण</th>
                                                  <td class="text-center">₹ <?= $total?>/-</td>
                                        </tr>
                                            
                                        <tr align="right">
                                                  <th colspan="4">ऍडव्हान्स</th>
                                                  <td class="text-center">
                                                      ₹ <?= $advance?>/-
                                                  </td>
                                        </tr>
                                        <tr align="right">
                                                  <th colspan="4">प्रलंबित रक्कम</th>
                                                  <td class="text-center"><?= $balance?></td>
                                        </tr>
                                        <tr align="right">
                                                  <th colspan="4">ठेव रक्कम</th>
                                                  <td class="text-center">
                                                      <?= $deposit?>
                                                  </td>
                                        </tr>
                                        <tr align="right">      
                                                  <th colspan="4">शिल्लक</th>
                                                  <td class="text-center">
                                                     <?= $finally_left?>
                                                      
                                                   </td>
                                        </tr>   
                                            </tbody>
                                            
                                            <?php endif ?>
                                    </table>
						        	</div>
                                </div>
                            </div>
                        </div>
                        </div>
       <?php endforeach?> 
<?php //} ?>
		<!--end page wrapper -->
<?php include "footer.php"; ?>
<script>
    bhajipalListTbl = $('#bhajipalTbl').DataTable({
         lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, 'सर्व'],
        ],
        initComplete: function(settings, json) {
            const _date_booking = this.api().table().column(1).data().unique();
            $('#bookdate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < _date_booking.length; i++) {
                if (_date_booking[i]) {
                    $('#bookdate-filter').append(`<option value="${_date_booking[i]}">${_date_booking[i].toTitleCase()}</option>`);
                }
            }
            const filterCity = this.api().table().column(2).data().unique();
            $('#givendate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterCity.length; i++) {
                if (filterCity[i]) {
                    $('#givendate-filter').append(`<option value="${filterCity[i]}">${filterCity[i].toTitleCase()}</option>`);
                }
            }
            const filterRed = this.api().table().column(3).data().unique();
            $('#delidate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterRed.length; i++) {
                if (filterRed[i]) {
                    $('#delidate-filter').append(`<option value="${filterRed[i]}">${filterRed[i].toTitleCase()}</option>`);
                }
            }
            const filterCat = this.api().table().column(4).data().unique();
            $('#nav-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterCat.length; i++) {
                if (filterCat[i]) {
                    $('#nav-filter').append(`<option value="${filterCat[i]}">${filterCat[i].toTitleCase()}</option>`);
                }
            }
        },
        
         drawCallback: function() {
        let api = this.api();
       
        $(api.table().footer()).find('th:eq(6)').html(
            api.column(6, { page: 'current' }).data().sum()
        );
        $(api.table().footer()).find('th:eq(7)').html(
            api.column(7, { page: 'current' }).data().sum()
        );
         $(api.table().footer()).find('th:eq(8)').html(
            api.column(8, { page: 'current' }).data().sum()
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
    bhajipalListTbl.buttons().container().prependTo('.export-container-zendu');
    $('#zendu-booking-filter-form').on('submit', function(e){
        e.preventDefault();
        const form = this.elements;
        bhajipalListTbl.column(1).search(form['bookdate-filter'].value).draw();
        bhajipalListTbl.column(2).search(form['givendate-filter'].value).draw();
        bhajipalListTbl.column(3).search(form['delidate-filter'].value).draw();
        bhajipalListTbl.column(4).search(form['nav-filter'].value).draw();
        
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

</script>
<script src="assets/js/vfs_fonts.js"></script>
<script>
	$.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt.buttons.pdfHtml5.customize = function(doc) { doc.defaultStyle.font = 'NotoSans';};
</script>