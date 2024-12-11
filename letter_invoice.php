<?php
require_once "config.php";
//$invoicesDestails=array();
if (isset($_GET['lid'])){

$getInvoice = "SELECT * FROM letter_pad WHERE lid='{$_GET['lid']}'";
// $getbillingDetails = "SELECT * FROM billing b,customer c,billing_details d WHERE b.cus_id=c.id AND b.cus_id='{$_GET['cus_id']}' AND b.bill_id=d.d_bill_id";
$resinvoice = mysqli_query($connect, $getInvoice);
$invoice=mysqli_fetch_assoc($resinvoice);
// while($invoice=mysqli_fetch_assoc($resBill)){
//         array_push($invoicesDestails,$invoice);
//     }
}
?>
<style>
.bgimg{
    object-fit: contain;
	width: 75%;
	height: 75%;
	opacity: 0.18;
	text-align:center;
    z-index:1;
}
/*.centered {*/
/*  top: 310px;*/
/*  left: 16px;*/
/*  font-size:8px;*/
/*  position: absolute;*/
/*  text-align:center;*/
/*}*/
#background {
	/*position: absolute;*/
	/*z-index: -1;*/
	/*top: 0;*/
	/*bottom: 0;*/
	/*left: 0;*/
	/*right: 0;*/
	position: absolute;
    z-index: -1;
    top: 0;
    bottom: 0;
    left: 300px;
    /* right: 0;
}
#background .img {
	object-fit: contain;
	width: 100%;
	height: 100%;
	opacity: 0.15;
	*/}
#background .img {	    
    object-fit: contain;
    text-align:center;
    width: 80%;
    height: 50%;
    opacity: 0.20;
    /* text-align: center; */
    /* margin-right: 80px; */
    /*margin-top: -55px;*/
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

.centered {
  margin-top: 150px;
  left: 16px;
  font-size:5px;
  position: absolute;
  text-align:center;
}

    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap');
        * {
            line-height: 1.2;
            font-family: 'Noto Sans';
            font-weight: 500;
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
}
</style>

<?php require_once "header.php"; ?> 
<div class="page-wrapper">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-12">
                <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="letter_list"><button class="btn btn-dark btn-outline btnprint text-end" type="button"> <span><i class="fa fa-arrow-left"></i> Back</span> </button></a>
                    <button class="btn btn-dark btn-outline btnprint text-end" type="button" onclick="window.print()"> <span><i class="fa fa-print"></i> Print</span> </button>  
                </div>
                <div class="card card-body printableArea mt-2">
                                        <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <img src="logo/invoice/lhead.png" alt="logo" width="100%" height="85%">
                                <!--<h4 class="fw-bold">рдореЛ. <span class="text-nowrap fw-bold fs-4 text-dark mt-2">8055339604,9765969828,9765694691</span>-->
                                <!--</h4>-->
                            </div>
                        </div>
                    </div>
         <!--           <div class="row justify-content-between mtp">-->
         <!--               <div class="col-1"></div>-->
					    <!--    <div class="col-5">-->
							  <!--  <h5 class="fw-bold">Customer: <i class="text-nowrap fs-6 text-muted"><?//= ucwords($invoice['far_name'])?></i></h5>-->
							  <!--  <h5 class="fw-bold">Village: <i class="text-nowrap fs-6 text-muted"><?//= ucwords($invoice['village'])?></i></h5>-->
						   <!-- </div>-->
						   <!-- <div class="col-lg-3 col-5">-->
							  <!--  <h5 class="fw-bold">Date: <i class="text-muted fs-6"><?//= date('d/m/Y', strtotime($invoice['idate']))?></i></h5>-->
							    
							  <!--  <h5 class="fw-bold">Mobile No. <i class="text-muted fs-6"><?//= $invoice['mob_no']?></i></h5>-->
						   <!-- </div>-->
						   <!-- <div class="col-1"></div>-->
						    
					    <!--</div>-->
					    <div class="row">
					            <div class="position-absolute d-flex align-items-center justify-content-center top-25">
					            <img class="bgimg" src="logo/invoice/glogo.png">
					            </div>
					                <div class="fs-6">
					                <?= html_entity_decode($invoice['letters']) ?>
					                </div>
					            </div>     
                                <!--<img  src="logo/invoice/lfoot.png" alt="logo" width="100%">-->
					  <!--</div>-->
				</div>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php";?>