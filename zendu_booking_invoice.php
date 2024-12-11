<?php
require_once "config.php";
if (isset($_GET['zid'])){

$getZendu = "SELECT * FROM zendu_booking WHERE zendu_id='{$_GET['zid']}'";
$result = mysqli_query($connect, $getZendu);
$zendu=mysqli_fetch_assoc($result);
extract($zendu);
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
                    <a href="zendu_booking_list">
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
							    <h6 class="fw-bold">दि.: <?php $date=date('d M Y',strtotime($booking_date))?>
                                            <?= $date?></h6>
						    </div>
					    </div>

					 <div class="row justify-content-end mt-3 text-center">
					        <div class="col-4">
							     <h6 class="fw-bold">गाव: <?= $village?></h6>
							    
						    </div>
						    <div class="col-4">
							    <h6 class="fw-bold">मो.नं.<?= $mobile?></h6>
						    </div>
						    <div class="col-4">
							    <h6 class="fw-bold">रोपे देण्याची    दि.<?= date('d M Y',strtotime($red_giving_date))?></h6>
						    </div>
					    </div>
					
				    <div id="content m-0">
                                <div id="background">
                                         <img src="logo/invoice/a3.png">
    	                            </div>
    	                            <table class="table table-bordered text-center fs-6">
                                            <thead>
                                                <tr>
                                                    <!--<th>अ.क्र.</th>-->
                                                    <!--<th>मालाचे विवरण</th>-->
                                                    <!--<th>रोपांची संख़्या</th>-->
                                                    <!--<th>दर</th>-->
                                                    <!--<th>एकुण रक्कम</th>-->
                                                    <th>अ.क्र</th>
                                                    <th colspan="2">मालाचे विवरण</th>
                                                    
                                                    <th>रोपांची संख़्या</th>
                                                    <th>दर</th>
                                                    <th>एकुण रक्कम</th>
    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                            //     if(isset($_GET['cid'])):
                                            //     $getcuspro = "SELECT * FROM sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$_GET['sid']}'";
                                            //   $getpro=mysqli_query($connect,$getcuspro);  
                                            //     while($pro=mysqli_fetch_assoc($getpro)):
                                            //         extract($pro);
                                            
                                            
                                            
                                           
                                                ?>
                                                <?php if($subcat_id!='निवडा उपवर्ग'){?>
                                                <tr>
                                                    <td ><?= $zendu_id?></td>
                                                    <td><?= $red_plants?></td>
                                                    <td><?= $subcat_id?></td>
                                                    <td><?= $sub_cat_qty?></td>
                                                    <td>₹ <?= $rate?>/-</td>
                                                    <td>₹ <?= $total_rs 
                                                    ?>/-</td>
                                                </tr>
                                                <?php } ?>
                                                <?php if($subcat_id1!='निवडा उपवर्ग'){?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $red_plants?></td>
                                                    <td><?= $subcat_id1?></td>
                                                    <td><?= $sub_cat_qty1?></td>
                                                     <td>₹ <?= $rate1?>/-</td>
                                                     <td>₹ <?= $total_rs1?>/-</td>
                                                </tr>
                                                <?php } ?>
                                                
                                                <?php if($ysubcat_id!='निवडा उपवर्ग'){?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $yellow_plants?></td>
                                                    <td><?= $ysubcat_id?></td>
                                                    <td><?= $yellowcount?></td>
                                                     <td>₹ <?= $ratey?>/-</td>
                                                     <td>₹ <?= $total_rsy?>/-</td>
                                                </tr>
                                                 <?php } ?>
                                                 
                                                 <?php if($subcat_idy1!='निवडा उपवर्ग'){?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $yellow_plants?></td>
                                                    <td><?= $subcat_idy1?></td>
                                                    <td><?= $sub_cat_qtyy1?></td>            <td>₹ <?= $ratey1?>/-</td>
                                                    <td>₹ <?= $yellow_total?>/-</td>
                                                </tr>
                                                <?php } ?>
                                                 <tr align="right">
                                                  <th colspan="5">एकूण</th>
                                                  <td class="text-center">₹ <?= $total_amount?>/-</td>
                                        </tr>
                                        <tr align="right">
                                                  <th colspan="5">ऍडव्हान्स</th>
                                                  <td class="text-center">
                                                      ₹ <?= $adv_amt?>/-
                                                  </td>
                                        </tr>
                                        <tr align="right">      
                                                  <th colspan="5">शिल्लक</th>
                                                  <td class="text-center">
                                                     ₹ <?= $pending_amt?>/-
                                                      
                                                   </td>
                                        </tr>  
                                                
                                            
                                            </tbody>
                                            
                                            <?php //endif ?>
                                    </table>
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