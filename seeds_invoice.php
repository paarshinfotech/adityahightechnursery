<?php
require_once "config.php";
if (isset($_GET['sale_id'])){
$getsales = "SELECT * FROM seeds_sales WHERE sale_id='{$_GET['sale_id']}'";
$result = mysqli_query($connect, $getsales);
$sale=mysqli_fetch_assoc($result);
extract($sale);
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
                    <a href="seeds_category">
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
							    <h6 class="fw-bold">श्री.<?= $far_name?></h6>
							    
						    </div>
						    <div class="col-6">
							    <h6 class="fw-bold">दि.: <?php $date=date('d M Y',strtotime($sdate))?>
                                            <?= $date?></h6>
						    </div>
					    </div>

					 <div class="row justify-content-end mt-3 text-center">
					        <div class="col-6">
							     <h6 class="fw-bold">गाव: <?= $village?></h6>
							    
						    </div>
						    <div class="col-6">
							    <h6 class="fw-bold">मो.नं.<?= $mob_no?></h6>
						    </div>
						    <!--<div class="col-4">-->
							   <!-- <h6 class="fw-bold">रोपे देण्याची </h6>-->
						    <!--</div>-->
					    </div>
					
				    <div id="content m-0">
                                <div id="background">
                                         <img src="logo/invoice/a3.png">
    	                            </div>
    	                            <table class="table table-bordered text-center fs-6">
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
                                                
                                                if(isset($_GET['sale_id'])):
                                                $getcuspro = "SELECT * FROM seeds_sales_details s INNER JOIN product p ON p.product_id=s.pid INNER JOIN seeds_sales d ON s.sale_id=d.sale_id WHERE s.sale_id='{$_GET['sale_id']}'";
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
                                                  <th colspan="4">शिल्लक</th>
                                                  <td class="text-center">
                                                     ₹ <?= $balance?>/-
                                                      
                                                   </td>
                                        </tr>   
                                            </tbody>
                                            
                                            <?php endif ?>
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
                        <div class="row mt-4">
                            <div class="col-12">
                                
                                टिप: <i class='bx bx-grid-small fw-bold'></i> आमच्याकडे रोप निर्मीती केली जाते उत्पादनाची कोणतीही हमी  घेतली जात नाही.<i class='bx bx-grid-small fw-bold'></i> कारण  बियाणे निर्मीती ही कंपनी   मध्ये होते  आमच्याकडे होत नाही.  व कंपनी ही कोणती ही उत्पादन ग्यारंटी घेत      नाही.<i class='bx bx-grid-small'></i> हे बिल चेक वटल्या शिवाय ग्राह्य  धरु नये. <i classs='bx bx-grid-small fw-bold'></i> शेतकऱ्याला    रोप तयार करण्यासाठी ठरवुन दिलेल्या दिनांक <?=$date?>  च्या नंतर रोपाची  कोणतीही जबाबदारी हि नर्सरी मालकाकडे राहणार नाही व  त्याबाबत कोणतीही तक्रार  ऐकल्या जाणार नाही. याची शेतकरीबंधूनी नोंद घ्यावी.  </div>
                        </div>
                    </div>           
				</div>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php";?>