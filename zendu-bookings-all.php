<?php
require_once "config.php";
Aditya::subtitle('सर्व झेंडू बुकिंग');

$from = isset($_GET['date-from']) ? $_GET['date-from'] : date('d-m-Y');
$to = isset($_GET['date-to']) ? $_GET['date-to'] : date('d-m-Y', strtotime("{$from} + 1 day"));

require_once "header.php";?>
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
			    <h4 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class='bx bx-left-arrow-circle'></i></a>
					<span>सर्व झेंडू बुकिंग</span>
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
                                                                            <label class="form-label">लाल देण्याची तारीख ने फिल्टर करा</label>
                                                                            <select class="form-select" id="reddate-filter">
                                                                                <option value="">सर्व</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <label class="form-label">पिवळा देण्याची तारीख ने फिल्टर करा</label>
                                                                            <select class="form-select" id="yellowdate-filter">
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
                                                                    <button class="btn btn-outline-light border text-danger me-auto" data-bs-dismiss="modal" onclick="clearDataTableFilters(zenduBookingListTbl, '#zendu-booking-filter-form')">सर्व फिल्टर हटवा</button>
                                                                    <button type="button" class="btn btn-outline-dark border" data-bs-dismiss="modal">बंद करा</button>
                                                                    <button type="submit" form="zendu-booking-filter-form" class="btn btn-dark">फिल्टर लागू करा</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                    
                                </div>
                    </div>
        				 <div class="table-responsive">
					<table border="1" id="zendutbl" class="table table-striped table-bordered table-hover multicheck-container">
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
                                    <th>लाल देण्याची तारीख</th>
                                    <th>पिवळा देण्याची तारीख</th>
                                    <th>शेतकऱ्याचे नाव</th>
									<th>लाल वनस्पती </th>
                                    <th>लाल वनस्पती संख्या</th>
									<th>पिवळी वनस्पती </th>
                                    <th>पिवळी वनस्पती संख्या</th>
                                    <th>एकूण रक्कम</th>
                                    <th>प्रलंबित</th>
                                    <th>अखेर बाकी</th>
						   </tr>
						</thead>
						<tbody>
                            <?php $getZbooking = mysqli_query($connect, "select * from zendu_booking where zb_status='1' AND booking_date >= '{$from}' AND booking_date < '{$to}' order by booking_date ASC") ?>
                            <?php if (mysqli_num_rows($getZbooking)>0): ?>
                                <?php 
                                $zenduList = array();
                                while ($zenduBook = mysqli_fetch_assoc($getZbooking)): 
                                array_push($zenduList, $zenduBook);
                                extract($zenduBook);
                                ?>
                                <tr>
                                <td class="form-group">
                                    <!--<input type="checkbox" class="multi-check-item" name="zendu_id[]" value="<?//= $zendu_id ?>">-->
                                    <span class="badge bg-gradient-bloody text-white shadow-sm">
                                        <?= $zendu_id ?>
                                    </span>
                                </td>
                               
                                <!--<td>-->
                                <!--    <a class="text-decoration-none" href="zendu_booking_add?zendu_id=<?//= $zendu_id;?>">-->
                                <!--        <?//= $cat_name; ?>-->
                                <!--    </a>-->
                                <!--</td>-->
                                <td class="text-success fw-bold"><?= date('d M Y',strtotime($booking_date))?></td>
                                               
                                                <td class="text-danger fw-bold"><?= date('d M Y',strtotime($red_giving_date)) ?></td>
                                                <td class="text-warning fw-bold"><?= date('d M Y',strtotime($yellow_giving_date))?></td>
                                                 
                                                  <td data-bs-toggle="modal" data-bs-target="#info<?php echo $zenduBook['zendu_id'];?>"class="text-success"><?= $name?></td>
                                           <td><?= $red_plants?></td>	  
											
											<!--<td><?= $sub_cat_qty + $sub_cat_qty1?></td> previous calculation-->
											<td><?= (is_numeric($sub_cat_qty) ? $sub_cat_qty : 0) + (is_numeric($sub_cat_qty1) ? $sub_cat_qty1 : 0) ?></td>

											
											<td><?= $yellow_plants?></td> 
                                         
											<!--<td><?= $yellowcount + $sub_cat_qtyy1 ?></td> previous calculation-->
											<td><?= (is_numeric($yellowcount) ? $yellowcount : 0) + (is_numeric($sub_cat_qtyy1) ? $sub_cat_qtyy1 : 0) ?></td> 
                                                <td><?= $total_amount?></td>
                                                <td><?= $pending_amt?></td> 
                                                <td><?= $finally_left?></td>
                                            </tr>
                                            <?php error_reporting(0);
                                            $totRedCount += $red_plants_count;
                                            $totYellowCount += $yellow_plants_count;
                                            $totAmt += $total_amount;
                                            $totPen += $pending_amt;
                                            $totFinallyLeft += $finally_left;
                                            
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
                    					    <!--<?= $totRedCount; ?>-->
                    					 </th>
                    					<th></th>
                    					<th>
                    					    <!--<?= $totYellowCount; ?>-->
                    					</th>
									
                    					<th>
                    					    <!--<?= $totAmt; ?>-->
                    					 </th>
                    					<th>
                    					    <!--<?= $totPen; ?>-->
                    					 </th>
                    					<th>
                    					    <!--<?= $totFinallyLeft; ?>-->
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
foreach ($zenduList as $zenduBook): ?>
                    <?php extract($zenduBook);
                    ?>
         <div class="modal fade" id="info<?php echo $zendu_id;?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $zendu_id;?>" aria-hidden="true">
            <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="infoLabel<?php echo $zendu_id;?>">शेतकऱ्यांची माहिती</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table">
						        			<tbody>
						        				<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">मूलभूत माहिती</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>नाव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $name?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>मोबाईल</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $mobile?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span class="text-danger fw-bold"><?= date('d M Y',strtotime($booking_date));?></span>
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
						        						<h6 class="text-success mb-0">वनस्पतींचे वर्णन</h6>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>लाल वनस्पती  
						        					    </strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($red_plants==0 && $subcat_id==0 && $sub_cat_qty==0 && $rate==0 && $subcat_id1==0 && $sub_cat_qty1==0 && $rate1==0){?>
						        					    <span>NULL</span>
						        					    <?php } else{?>
						        						<span><?= $red_plants?>: <?= $subcat_id?> (<?= $sub_cat_qty?>)x(<?= $rate?>),<?= $subcat_id1?> (<?= $sub_cat_qty1?>)x(<?= $rate1?>) </span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>लाल रोपे एकूण 	रु
						        						</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					 <!--   <?php if($total_rs==0 && $total_rs1==0){?>-->
						        						<!--<span>0</span>-->
						        						<!--<?php } else{?>-->
						        						<!--<span><?= $total_rs + $total_rs1?></span>-->
						        						<!--<?php } ?>  previous addition logic-->
						        						
						        						<?php $totalSum = $total_rs + $total_rs1; ?>
                                                        <span><?= ($totalSum == 0) ? 0 : $totalSum ?></span>  <!--updated version-->

						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी वनस्पती</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($yellow_plants==0 && $ysubcat_id==0 && $yellowcount==0 && $ratey==0 && $subcat_idy1==0 && $sub_cat_qtyy1==0 && $ratey1==0){?>
						        						<span>NULL</span>
						        						<?php } else{?>
						        						<span><?= $yellow_plants?>: <?= $ysubcat_id?> (<?= $yellowcount?>)x(<?= $ratey?>),<?= $subcat_idy1?> (<?= $sub_cat_qtyy1?>)x(<?= $ratey1?>) </span>
						        						<?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी रोपे एकूण रु</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					   <?php $totalSum = $total_rsy + $yellow_total; ?>
                                                        <span><?= ($totalSum == 0) ? 0 : $totalSum ?></span>
						        					</td>
						        				</tr>
						        				
						        					<tr>
						        					<td colspan="3" class="bg-light">
						        						<h6 class="text-success mb-0">खात्याची माहिती</h6>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>एकूण रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $total_amount?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>ऍडव्हान्स रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        						<span><?= $adv_amt?></span>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>प्रलंबित रक्कम</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($pending_amt==0){?>
						        						<span>0</span><?php }else{?>
						        						<span><?= $pending_amt?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>जमा करण्याची तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<?php if($depositdate==''){
						        					    ?>
						        					    <td>
						        						<span>DD/MM/YY</span>
						        					</td>
						        					    <?php
						        					}else{?>
						        					<td>
						        						<span><?= date('d M Y',strtotime($depositdate))?></span>
						        					</td>
						        					<?php } ?>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पुन्हा ठेव</strong>
						        					</td>
						        					<td>: </td>
						        					<td>
						        					    <?php if($deposit_again==0){?>
						        						<span>0</span><?php } else{?>
						        						<span><?= $deposit_again?></span><?php } ?>
						        					</td>
						        				</tr>
						        			
						        				<tr>
						        					<td>
						        						<strong>अखेर बाकी</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($finally_left==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span><?= $finally_left?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>लाल देणारी तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($red_giving_date==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-danger fw-bold"><?= date('d M Y',strtotime($red_giving_date))?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>पिवळी देणारी तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($yellow_giving_date==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-warning fw-bold"><?= date('d M Y',strtotime($yellow_giving_date))?></span><?php } ?>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td>
						        						<strong>वितरण तारीख</strong>
						        					</td>
						        					<td>: </td>
						        					<td><?php if($date_given==0){?>
						        						<span>0</span>
						        						<?php } else{?>
						        						<span class="text-success fw-bold"><?= date('d M Y',strtotime($date_given))?></span><?php } ?>
						        					</td>
						        				</tr>
						        				
						        			</tbody>
						        		</table>
						        	</div>
                                </div>
                            </div>
                        </div>
                        </div>
       <?php endforeach?>
		<!--end page wrapper -->
<?php include "footer.php"; ?>
<script>
    zenduBookingListTbl = $('#zendutbl').DataTable({
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
            $('#reddate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterCity.length; i++) {
                if (filterCity[i]) {
                    $('#reddate-filter').append(`<option value="${filterCity[i]}">${filterCity[i].toTitleCase()}</option>`);
                }
            }
            const filterRed = this.api().table().column(3).data().unique();
            $('#yellowdate-filter').html('<option value="">सर्व</option>');
            for (let i = 0; i < filterRed.length; i++) {
                if (filterRed[i]) {
                    $('#yellowdate-filter').append(`<option value="${filterRed[i]}">${filterRed[i].toTitleCase()}</option>`);
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
        $(api.table().footer()).find('th:eq(8)').html(
            api.column(8, { page: 'current' }).data().sum()
        );
        $(api.table().footer()).find('th:eq(9)').html(
            api.column(9, { page: 'current' }).data().sum()
        );
         $(api.table().footer()).find('th:eq(10)').html(
            api.column(10, { page: 'current' }).data().sum()
        );
         $(api.table().footer()).find('th:eq(11)').html(
            api.column(11, { page: 'current' }).data().sum()
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
    zenduBookingListTbl.buttons().container().prependTo('.export-container-zendu');
    $('#zendu-booking-filter-form').on('submit', function(e){
        e.preventDefault();
        const form = this.elements;
        zenduBookingListTbl.column(1).search(form['bookdate-filter'].value).draw();
        zenduBookingListTbl.column(2).search(form['reddate-filter'].value).draw();
        zenduBookingListTbl.column(3).search(form['yellowdate-filter'].value).draw();
        zenduBookingListTbl.column(4).search(form['nav-filter'].value).draw();
        
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