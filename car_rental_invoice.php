<?php
require_once "config.php";
if (isset($_GET['cr_id']) && isset($_GET['adv_id'])){
$carList = array();
$getCar = "select * from car_rental c,car_rental_adv a WHERE c.cr_id='{$_GET['cr_id']}' AND a.adv_id='{$_GET['adv_id']}' AND c.cr_id=a.adv_cr_id";
// $getCar = "select * from car_rental c LEFT JOIN car_rental_adv a ON c.cr_id=a.cr_id WHERE c.cr_id='{$_GET['cr_id']}' AND a.adv_id='{$_GET['adv_id']}'";
$result = mysqli_query($connect, $getCar);
$fetch=mysqli_fetch_assoc($result);
array_push($carList, $fetch);
extract($fetch);
}
?>
<style>
.text-blue{color:#191970;}
#background {
	position: absolute;
	z-index: -1;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
}
#background img {
	object-fit: contain;
	width: 100%;
	height: 100%;
	opacity: 0.18;
}
#content{
    position:relative;
    z-index:5;
}

#bg-text
{
    color:lightgrey;
    font-size:50px;
    width:100%;
    height:100%;
    text-align: center;
    z-index: 1;
    opacity: .2;
    /*transform:rotate(300deg);
    -webkit-transform:rotate(300deg);*/
}
@media print {
    * {
        box-shadow: none !important;
    }
    header, .sidebar-wrapper, .sidebar-wrapper *
    .topbar, .topbar *,
    .navbar, .navbar *,
    footer, .page-footer, .page-footer *,
    .page-titles,
    .btnprint,
    .user-box, .user-box * ,.switcher-wrapper *{
        display: none !important;
    }
    .no-print {
        display: none !important;
    }
    .page-wrapper, .printableArea {
    	padding: 0 !important;
    	margin: 0 !important;
    	background-color: white;
    }
    .mtp{margin-top: 180px;}
    img {
	object-fit: contain;
	margin-top:-50px;
	width: 100%;
	height: 100%;
}
}
</style>

<?php require_once "header.php"; ?> 
<div class="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="car_rental_category">
                    <button class="btn btn-dark btn-outline btnprint text-end" type="button"> <span><i class="fa fa-arrow-left"></i> Back</span> </button></a>
                    
                    <button class="btn btn-dark btn-outline btnprint text-end" type="button" onclick="window.print()"> <span><i class="fa fa-print"></i> Print</span> </button>  
                    
                </div>
                <div class="card card-body printableArea mt-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <img src="logo/invoice/li.png" alt="logo">
                                <h6 class="fw-bold">मो. <span class="text-nowrap fw-bold fs-4 text-dark mt-2">8055339604,9765969828,9765694691</span>
                                </h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row justify-content-end mt-3 text-center">
					        <div class="col-6">
							    <h6 class="fw-bold">श्री.   <?= $name?></h6>
							    
						    </div>
						    <div class="col-6">
							    <h6 class="fw-bold">दि.: <?php $date=date('d M Y',strtotime($cdate))?>
                                            <?= $date?></h6>
						    </div>
					    </div>

					 <div class="row justify-content-end mt-3 text-center">
					        <div class="col-6">
							     <h6 class="fw-bold">गाव: <?= $village_name?></h6>
							    
						    </div>
						    <div class="col-6">
							    <h6 class="fw-bold">मो.नं.<?= $con?></h6>
						    </div>
						    
					    </div>
					
				    <div id="content m-0">
                                <div id="background">
                                         <img src="logo/invoice/a3.png">
    	                            </div>
    	                            <div class="col-12 my-0 py-2 max-h-500 oy-auto">
       
						        		<table class="table fs-6">
						        			<tbody>
						        			
						        				<tr>
						        					<td colspan="2">
						        						<strong>Car Rental</strong>
						        					</td>
						        					
						        					<td>
						        						<span><?= $car_rental?></span>
						        					</td>
						        				</tr>
						        				<tr>
						        					<td colspan="2">
						        						<strong>Pick Up Diesel</strong>
						        					</td>
						        					
						        					<td>
						        						<span><?= $pick_up_diesel?></span>
						        					</td>
						        				</tr>
						        				
						        				<tr>
						        				    <th>Advance Date</th>
						        				    <th>Advance Rs</th>
						        				    <th>Reason</th>
						        				</tr>
						        				<tr>
						        				    <?php foreach ($carList as $fetch): extract($fetch);?>
						        				    <td><?= date('d M Y',strtotime($advdate))?></td>
						        				    <td><?= $advrs?></td>
						        				    <td><?= $reason?></td>
						        				</tr>
						        			<?php //$sumAdv=mysqli_query($connect,"SELECT SUM(advrs) as sumADV FROM `car_rental_adv` WHERE cr_id='$cr_id'");
						        			//	$rSumAdv=mysqli_fetch_assoc($sumAdv);
						        				?>
						        				<?php endforeach?>
						        				
						        				<!--<tr>-->
                  <!--                                <th colspan="1">Total Advance </th>-->
                  <!--                                <td><?//= $rSumAdv['sumADV'];?>              </td>-->
                  <!--                                <td></td>-->
                  <!--                              </tr>-->
						        				<tr>
                                                  <th colspan="1">Total Balance</th>
                                                  <td><?= $deposit_rs?>              </td>
                                                  <td></td>
                                                </tr>
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Reason</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span><?= $reason?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Balance Rs</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span><?= $deposit_rs?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        			
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Advance Date</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span><?= date('d M Y',strtotime($advdate))?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Advance Rs</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span><?= $advrs?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        				<!--<tr>-->
						        				<!--	<td>-->
						        				<!--		<strong>Total Balance Rs</strong>-->
						        				<!--	</td>-->
						        				<!--	<td>: </td>-->
						        				<!--	<td>-->
						        				<!--		<span><?= $totBal?></span>-->
						        				<!--	</td>-->
						        				<!--</tr>-->
						        			
						        			</tbody>
						        		</table>
						        	</div>
                               </div>
                    
                    <div class="row">
                        <div class="col-4">
                            <h6 class="text-blue fw-bold">SEED LI.NO.:</h6>
                            <h6 class="fw-bold">LASDN33052201</h6>
                            <h6 class="text-blue fw-bold">ISO.No.:</h6>
                            <h6 class="fw-bold">9001:2015/20EQBW72</h6>
                            <h6 class="text-blue fw-bold">N.H.B.IDENTIFICATION</h6>
                            <h6 class="fw-bold">NO.:NURMHC00187</h6>
                        </div>
                        <div class="col-5">
                            <h6 class="text-danger fw-bold">ADITYA HIGHTECH NURSERY</h6>
                            <div class="row">
                                <div class="col-4">
                                        <h6 class="fw-bold text-nowrap">SBI A/C.</h6>
                                        <h6 class="fw-bold text-nowrap">IFSC COD.</h6>
                                        <h6 class="fw-bold text-nowrap">BRANCH</h6>
                                 </div>
                                <div class="col-5">
                                    <h6 class="fw-bold text-nowrap">:41294691869</h6>
                                    <h6 class="fw-bold text-nowrap">:SBIN0002173</h6>
                                    <h6 class="fw-bold text-nowrap">:RISOD</h6>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-3">
                            <h6 class="text-blue mtp fw-bold ms-2 text-nowrap" style="margin-top: 120px;">
                                करिता: आदित्य नर्सरी
                            </h6>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                
                                टिप: <i class='bx bx-grid-small fw-bold fs-6'></i> आमच्याकडे रोप निर्मीती केली जाते उत्पादनाची कोणतीही हमी  घेतली जात नाही.<i class='bx bx-grid-small fw-bold fs-6'></i> कारण  बियाणे निर्मीती ही कंपनी   मध्ये होते  आमच्याकडे होत नाही.  व कंपनी ही कोणती ही उत्पादन ग्यारंटी घेत      नाही.<i class='bx bx-grid-small'></i> हे बिल चेक वटल्या शिवाय ग्राह्य  धरु नये. <i classs='bx bx-grid-small fw-bold fs-6'></i> शेतकऱ्याला    रोप तयार करण्यासाठी ठरवुन दिलेल्या दिनांक <?=$date?>  च्या नंतर रोपाची  कोणतीही जबाबदारी हि नर्सरी मालकाकडे राहणार नाही व  त्याबाबत कोणतीही तक्रार  ऐकल्या जाणार नाही. याची शेतकरीबंधूनी नोंद घ्यावी.  </div>
                        </div>
                    </div>           
				</div>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php";?>