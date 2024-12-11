<?php require "config.php" ?>
<?php
Aditya::subtitle('सर्व बियाणे आवक व जावक बुकिंग');
$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('d-m-Y');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('d-m-Y', strtotime("{$from} + 1 day"));
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<h6 class="mb-0 text-uppercase">बियाणे आवक व जावक तपशील</h6>
            <div class="dropdown-center">
               <a href="seeds_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top:-25px;">
               <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="seeds_add">नवीन तयार करा</a></li>
                     <li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#deposit">ठेव</a></li>
                  </ul>
            </div>
		<hr/>
		<div class="card">
			<div class="card-body">
			     <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#reportsDateRangeModal">
                              कालावधी
                            <i class="bx bx-calendar-week"></i></button>
                       <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="seeds-filter-form" class="row g-3">
                                             <div class="col-12">
                                                <label class="form-label">बुकिंग तारीख फिल्टर करा </label>
                                                <select class="form-select" id="bookdate-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">शेतकऱ्यांचे नाव नुसार फिल्टर करा</label>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावानुसार फिल्टर करा </label>
                                                <select class="form-select" id="gav-filter">
                                                    <option value="">सर्व</option>
                                                </select>
                                            </div>
                                           
                                            
                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(seedsListTbl, '#seeds-filter-form')">सर्व फिल्टर हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">बंद करा</button>
                                        <button type="submit" form="seeds-filter-form" class="btn btn-dark">फिल्टर लागू करा</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
				
				 <div class="table-responsive">
					<table border="1" id="seedsTbl" class="table table-striped table-bordered table-hover multicheck-container">
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
			         <!--                   			<a title="बियाणे आवक व जावक  हटवा" class="multi-action-btn dropdown-item text-danger" data-multi-action="delete" data-multi-action-page="" href="?delete=true" onclick="return confirm('बियाणे आवक व जावक  हटवा..?');">-->
			         <!--                   				<i class="btn-round bx bx-trash me-2"></i>बियाणे आवक व जावक  हटवा-->
			         <!--                   			</a>-->
			         <!--                   		</li>-->
			         <!--                   	</ul>-->
			         <!--                   </div>-->
								    <!--</div>-->
									<?php //endif ?>
									बुकिंग नं.
								</th>
    								<th>श्रेणी </th>
    								<th>शेतकऱ्यांचे नाव</th>
                                    <th>गाव</th>
                                    <th>मोबाईल</th>
                                    <th>डाग</th>
                                    <th>बिल क्र</th>
                                    <th>बुकिंग तारीख</th>

                                    <th>एकूण</th>
                                    
						   </tr>
						</thead>
						<tbody>
						    <?php //if(isset($_GET['cat_id'])){?>
                            <?php 
                            //$getBrand = mysqli_query($connect, "SELECT * FROM seeds_category c seeds_sales s, seeds_sales_details d WHERE s.seeds_status='1' and c.sale_id=d.sale_id and c.sale_id='{$_GET['cat_id']}' ORDER BY s.sale_id DESC") 
                            $getBrand = mysqli_query($connect, "select * from seeds_sales s LEFT JOIN seeds_sales_details d ON s.sale_id=d.sale_id INNER JOIN seeds_category c ON c.cat_id=d.pro_cat_id and s.seeds_status='1' AND s.sdate >= '{$from}' AND s.sdate < '{$to}'group BY s.sale_id DESC") 
                            
                            ?>
                            <?php if (mysqli_num_rows($getBrand)>0): ?>
                                <?php 
                                $seedsList = array();
                                while ($fetch = mysqli_fetch_assoc($getBrand)):
                                array_push($seedsList, $fetch);
                                extract($fetch);
                                
                                // $getdep=mysqli_query($connect,"SELECT SUM(deposit_rs) as totdeposit_rs FROM car_rental WHERE sale_id='{$sale_id}' and status='1'");
                                //         $totdep=mysqli_fetch_assoc($getdep);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <!--<input type="checkbox" class="multi-check-item" name="sale_id[]" value="<?//= $sale_id ?>">-->
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $sale_id ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <a class="text-decoration-none" href="seeds_add?sale_id=<?= $sale_id;?>">
                                        <?= $cat_name; ?>
                                    </a>
                                </td>
                                 <td data-bs-toggle="modal" data-bs-target="#info<?php echo $fetch['sale_id'];?>"class="text-primary"><?= $far_name?></td>
                                                <td><?= $village?></td>
                                                 <td><?= $mob_no?></td>
                                                <td><?= $dag?></td>
                                                <td><?= $bill_no?></td>
                                               
                                                <td class="text-success fw-bold"><?= date('d M Y',strtotime($sdate))?></td>
                                            
                                                <td><?= $total?></td> 
                                                
                                                
                            </tr>
                            <?php error_reporting(0); $totalSeedsAmt += $total?>
                                <?php endwhile ?>
                            <?php endif ?>
                            <?php //} ?>
						</tbody>
						<?php error_reporting(0);?>
        						<tfoot>
        				        <tr>
            					    <th colspan="8">एकूण</th>
                					<th><?= $totalSeedsAmt; ?></th>
    				            </tr>
        			            </tfoot>
					</table>
				</div>
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
<!--end page wrapper -->
<div class="modal fade" id="deposit" tabindex="-1" aria-labelledby="depositLabel" aria-hidden="true">
                                        <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="depositLabel">ठेव रक्कम</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="mb-3">
            <label for="sale_id" class="col-form-label">नाव</label>
            	<select name="sale_id" id="cid" class="form-control cid" required><option>शेतकरी निवडा</option>	
										<?php $getzendu = mysqli_query($connect,"SELECT * from seeds_sales where seeds_status='1'") ?>
																	<?php if ($getzendu && mysqli_num_rows($getzendu)): ?>
																		<?php while ($getrow=mysqli_fetch_assoc($getzendu)):?>
																		<option value="<?= $getrow['sale_id'] ?>"><?= $getrow['far_name'] ?></option>
																		<?php endwhile ?>
																	<?php endif ?>
										
														</select>
          </div>
          
          <div class="mb-3">
            <label for="depositdate" class="col-form-label">तारीख</label>
            <input type="date" class="form-control" id="depositdate" name="depositdate" value="<?php echo date('Y-m-d')?>">
          </div>
             <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="pending_amt" class="form-label">प्रलंबित रक्कम<span class="text-danger">*</span></label><br>
                                                
                                                <input type="text" name="pending_amt" id='pending_amt' class="form-control" readonly>
                                          
                                                <input type="hidden" name="sale_id" id='sale_id' class="form-control" readonly>
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="deposit_again" class="form-label">ठेव<span class="text-danger">*</span></label><br>
                                                <input type=text name="deposit_again" id='deposit_again' class="form-control">
                                                </div>
                                                    </div>
                                                <div class="col-12 col-md-12">
                                                <div class="form-group">
                                                <label for="finally_left" class="form-label">शेवटी लेफ्ट<span class="text-danger">*</span></label><br>
                                                <input type=text name="finally_left" id='finally_left' class="form-control" readonly>
                                                </div>
                                                    </div>
                                                    
       
                                    </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                                        <button type="submit" name="deposit" class="btn btn-primary">जतन करा</button>
                                       
                                         </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>
<?php 
error_reporting(0);
foreach ($seedsList as $fetch): ?>
                    <?php extract($fetch);
                    ?>
         <div class="modal fade" id="info<?php echo $sale_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $sale_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="infoLabel<?php echo $sale_id;?>">शेतकऱ्यांची माहिती</h5>
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
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= date('d M Y',strtotime($sdate));?></span>
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
						        					<td>
						        						<strong>डाग</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $dag?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>बिल क्र</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $bill_no?></span>
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
                                                    <th>संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                if(isset($fetch['sale_id'])):
                                                $getcuspro = "SELECT * FROM seeds_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN seeds_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$fetch['sale_id']}'";
                                              $getpro=mysqli_query($connect,$getcuspro);  
                                                while($pro=mysqli_fetch_assoc($getpro)):
                                                    extract($pro);
                                                ?>
                                            <tr>
                                                <td><?= $pid?></td>
                                                <td><?= $product_name?></td>
                                                <td><?= $pqty?></td>
                                                <td><?= $pprice?></td>
                                                <td>₹ <?= $sub_total?>/-</td>
                                            <!--<td class="text-end"><?//= $total?></td>-->
                                            </tr>
                                            <?php endwhile ?>
                                            <tr align="right">
                                                  <th colspan="4">Total</th>
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
<script>
     $(document).ready(function(){
     $("#cid").change(function(){
          var s = $("#cid option:selected").val();
        
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { balamtSeeds : s } 
          }).done(function(data){
              $("#pending_amt").val(data);
          });
      });
  });
  
  $(document).ready(function(){
    $("#cid").change(function(){
          var x = $("#cid option:selected").val();
        //   alert(x);
          $.ajax({
              type: "POST",
              url: "ajax_master", 
              data: { sales_id : x  } 
          }).done(function(data){
              $("#sale_id").val(data);
          });
      });
  });
     $(document).ready(function() {
    
     //this calculates values automatically finally left
    pending_sub();
    $("#pending_amt, #deposit_again").on("input", function() {
        pending_sub();
    });
});
   function pending_sub() {
             let totpending = document.getElementById('pending_amt').value;
            let depagain = document.getElementById('deposit_again').value;
			let finalleft = parseInt(totpending) - parseInt(depagain);
            if (!isNaN(finalleft)) {
				document.getElementById('finally_left').value = finalleft;
            }
        }
</script>       
<?php include "footer.php"; ?>
<script>
    seedsListTbl = $('#seedsTbl').DataTable({
         lengthMenu: [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, 'सर्व'],
        ],
        initComplete: function(settings, json) {
            const filterBookdate = this.api().table().column(7).data().unique();
            $('#bookdate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterBookdate.length; i++) {
                if (filterBookdate[i]) {
                    $('#bookdate-filter').append(`<option value="${filterBookdate[i]}">${filterBookdate[i].toTitleCase()}</option>`);
                }
            }
            const filternav = this.api().table().column(2).data().unique();
            $('#nav-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filternav.length; i++) {
                if (filternav[i]) {
                    $('#nav-filter').append(`<option value="${filternav[i]}">${filternav[i].toTitleCase()}</option>`);
                }
            }
            const filtergav = this.api().table().column(3).data().unique();
            $('#gav-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filtergav.length; i++) {
                if (filtergav[i]) {
                    $('#gav-filter').append(`<option value="${filtergav[i]}">${filtergav[i].toTitleCase()}</option>`);
                }
            }
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
    seedsListTbl.buttons().container().prependTo('.export-container');
    $('#seeds-filter-form').on('submit', function(e){
        e.preventDefault();
        const form = this.elements;
        seedsListTbl.column(7).search(form['bookdate-filter'].value).draw();
        seedsListTbl.column(2).search(form['nav-filter'].value).draw();
        seedsListTbl.column(3).search(form['gav-filter'].value).draw();
        
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