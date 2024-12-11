<?php require "config.php" ?>
<?php
// Aditya::subtitle('जेसीबी यादी');
// if (isset($_GET['delete']) && isset($_GET['jcb_id'])) {
//     escapePOST($_GET);

//     //del profile and driver 
//     foreach ($_GET['jcb_id'] as $dir) {
//         //     $delete = mysqli_query($connect, "DELETE FROM customer WHERE customer_id='{$dir}'");
//         // }
//         $delete = mysqli_query($connect, "UPDATE jcb SET jcb_status='0' WHERE jcb_id='{$dir}'");
//     }
//     if ($delete) {
//         header('Location: jcb_category?action=Success&action_msg=जेसीबी हटवले..!');
//         exit();
//     } else {
//         header('Location: jcb_category?action=Success&action_msg=काहीतरी चूक झाली');
//         exit();
//     }
// }

if (isset($_POST['adv'])) {
    escapeExtract($_POST);
    $carinsert = "INSERT INTO `jcb_adv`(cr_id,advdate,advrs,reason,giver,taker) VALUES ('$cr_id','$advdate','$advrs','$reason','$giver','$taker')";
    $rescar = mysqli_query($connect, $carinsert);
    $adv_id = mysqli_insert_id($connect);
    mysqli_query($connect, "UPDATE jcb SET total_amt = total_amt - {$advrs} WHERE jcb_id = '{$cr_id}'");
    if ($rescar) {
        header('Location: jcb_category?action=Success&action_msg=ग्राहकाचे ₹ ' . $advrs . ' /- ऍडव्हान्स जमा झाले..!');
        exit();
    } else {
        header("Location: jcb_category");
        exit();
    }
}
?>
<?php require "header.php" ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">जेसीबी</h6>

        <div class="dropdown-center">
            <a href="jcb_add" type="button" class="btn btn-sm btn-success  float-end" data-bs-toggle="dropdown"
                aria-expanded="false" style="margin-top:-25px;">
                <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="jcb_add">नवीन तयार करा</a></li>
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#adv"
                        data-bs-whatever="@mdo">ऍडव्हान्स</a></li>

            </ul>
        </div>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex ">
                        <div class="export-container"></div>
                        <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="modal"
                            data-bs-target="#filterModal">
                            फिल्टर <i class="bx bx-filter"></i>
                        </button>
                        <!-- Filter Modal -->
                        <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="filterModalLabel">फिल्टर</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="jcb-filter-form" class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label">नावा नुसार फिल्टर करा</label>
                                                <?php
                                                $id = mysqli_real_escape_string($connect , $_GET['jcb_cat_id']);
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `name` FROM jcb WHERE `name` IS NOT NULL AND `name` != '' And jcb_cat_id= '$id' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="nav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $name = htmlspecialchars($row["name"]); // Sanitize output
                                                        echo "<option value='$name'>$name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">गावा नुसार फिल्टर करा</label>
                                                <?php
                                                // SQL query to get unique villages
                                                $sql = "SELECT DISTINCT `village_name` FROM jcb WHERE `village_name` IS NOT NULL AND `village_name` != '' And jcb_cat_id= '$id' ;";

                                                $result = mysqli_query($connect, $sql);
                                                ?>
                                                <select class="form-select" id="gav-filter">
                                                    <option value="">सर्व</option>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $village_name = htmlspecialchars($row["village_name"]); // Sanitize output
                                                        echo "<option value='$village_name'>$village_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-outline-light border text-danger me-auto"
                                            data-bs-dismiss="modal"
                                            onclick="unselectfillter()">सर्व फिल्टर
                                            हटवा</button>
                                        <button type="button" class="btn btn-outline-dark border"
                                            data-bs-dismiss="modal">बंद करा</button>
                                        <button  data-bs-dismiss="modal" onclick="ajaxJCBlist(1)" form="jcb-filter-form" class="btn btn-dark">फिल्टर लागू
                                            करा</button>
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
                                <select name="suppliertbl_length" id="table_Row_Limit" onchange="ajaxJCBlist(1)"
                                    aria-controls="suppliertbl" class="form-select form-select-sm">
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
<!--Details Info Modal-->
<?php foreach ($infoDetails as $rowjcb): ?>
    <?php extract($rowjcb);
    $totBal1 = $total_amt - $advrs;
    ?>
    <div class="modal fade" id="info<?php echo $jcb_id; ?>" tabindex="-1" aria-labelledby="infoLabel<?php echo $jcb_id; ?>"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="infoLabel<?php echo $jcb_id; ?>">ग्राहकाची माहिती</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 my-0 py-2 max-h-500 oy-auto">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <td colspan="5" class="bg-light">
                                        <h6 class="text-success mb-0">मूलभूत माहिती</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>श्रेणी</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $cat_name ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>नाव</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $name ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>मोबाईल</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $mobile ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>तारीख</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= date('d M Y', strtotime($jdate)); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>गावाचे नाव</strong>
                                    </td>
                                    <td>: </td>
                                    <td>
                                        <span>
                                            <?= $village_name ?>
                                        </span>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="5" class="bg-light">
                                        <h6 class="text-success mb-0">इतर माहिती</h6>
                                    </td>
                                </tr>

                                <tr>
                                    <th>ऍडव्हान्स तारीख</th>
                                    <th>ऍडव्हान्स रु</th>
                                    <th>कारण</th>
                                    <th>देणारा</th>
                                    <th>घेणारा</th>
                                </tr>
                                <tr>
                                    <?php
                                    error_reporting(0);
                                    $advcar = mysqli_query($connect, "select * from jcb_adv WHERE cr_id='$jcb_id' order by adv_id DESC");
                                    while ($_resadv = mysqli_fetch_assoc($advcar)):
                                        //extract($_resadv);   
                                        ?>
                                        <td>
                                            <?= date('d M Y', strtotime($_resadv['advdate'])) ?>
                                        </td>
                                        <td>
                                            <?= $_resadv['advrs'] ?>
                                        </td>
                                        <td>
                                            <?= $_resadv['reason'] ?>
                                        </td>
                                        <td>
                                            <?= $_resadv['giver'] ?>
                                        </td>
                                        <td>
                                            <?= $_resadv['taker'] ?>
                                        </td>
                                    </tr>
                                    <?php $sumAdv = mysqli_query($connect, "SELECT SUM(advrs) as sumADV FROM `jcb_adv` WHERE cr_id='$jcb_id'");
                                    $rSumAdv = mysqli_fetch_assoc($sumAdv);
                                    ?>
                                <?php endwhile ?>

                                <tr>
                                    <th colspan="1">Total Advance </th>
                                    <td>
                                        <?= $rSumAdv['sumADV']; ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="1">Total Balance</th>
                                    <td>
                                        <?= $totBal1 ?>
                                    </td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>
<!--Advance modal-->
<div class="modal fade" id="adv" tabindex="-1" aria-labelledby="advLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advLabel">ऍडव्हान्स</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">नाव</label>
                        <select name="cr_id" class="form-control mb-3" required>
                            <option>निवडा..</option>
                            <?php $getcustomert = mysqli_query($connect, "SELECT * from jcb where jcb_cat_id='$jcb_cat_id' and jcb_status!=0") ?>
                            <?php if ($getcustomert && mysqli_num_rows($getcustomert)): ?>
                                <?php while ($getcus = mysqli_fetch_assoc($getcustomert)): ?>
                                    <option value="<?= $getcus['jcb_id'] ?>">
                                        <?= $getcus['name'] ?>, (
                                        <?= $getcus['jdate'] ?>)
                                    </option>
                                <?php endwhile ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adate" class="col-form-label">तारीख</label>
                        <input type="date" class="form-control" id="adate" name="advdate"
                            value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="rs" class="col-form-label">रुपये</label>
                        <input type="text" class="form-control" id="rs" name="advrs"
                            oninput="allowType(event,'number')">
                    </div>
                    <div class="mb-3">
                        <label for="pick_up_extra" class="col-form-label">कारण</label>
                        <input type="text" class="form-control" id="pick_up_extra" name="reason">
                    </div>
                    <div class="mb-3">
                        <label for="giver" class="col-form-label">देणारा</label>
                        <input type="text" class="form-control" name="giver">
                    </div>
                    <div class="mb-3">
                        <label for="taker" class="col-form-label">घेणारा</label>
                        <input type="text" class="form-control" name="taker">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">बंद करा</button>
                <button type="submit" name="adv" class="btn btn-success">जतन करा</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

<script src="assets/js/vfs_fonts.js"></script>
<script>
    $.fn.dataTableExt.buttons.csvHtml5.charset = 'UTF-8', $.fn.dataTableExt.buttons.csvHtml5.bom = true, $.fn.dataTableExt
        .buttons.pdfHtml5.customize = function (doc) {
            doc.defaultStyle.font = 'NotoSans';
        };
</script>

<!--     --    -- --     --      -->

<script>
    function ajaxJCBlist(page = 1, search = '') {


        // var city = $('#cus-filter-city').val();
        var Name = $('#nav-filter').val();
        var village = $('#gav-filter').val();
        var tableRowLimit = $('#table_Row_Limit').val();

        //console.log(city);
        //console.log(taluka);
        //console.log(village);


        //console.log("Table Row Limit: " + tableRowLimit);
        $("#table_data").html(loader);
        $.ajax({
            type: "POST",
            url: "ajax_jcb_list",
            data: {
                Name : Name ,
                village : village ,
                CatID: <?php echo $_GET['jcb_cat_id'] ?>,
                tableRowLimit: tableRowLimit,
                Search: search,
                page: page
            }
        }).done(function (data) {
            // //console.log("///////////////");
            $("#table_data").html(data);
            initializeDataTable('export-container', '#jcbTbl');
        });
    }
</script>




<script>
    function ChangePage(page) {
        var inputValue = $('#Search_filter').val();
        ajaxJCBlist(page, inputValue)
    }
</script>



<script>
    function logInputValueCustomer() {
        var inputValue = $('#Search_filter').val();
        // //console.log('Input Value:', inputValue);
        ajaxJCBlist(1, inputValue);
    }
</script>



<script>
    $(document).ready(function () {
        ajaxJCBlist(1);
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

<script>
    function unselectfillter(){
        
    // Example usage
    // unselectOption(['cus-filter-taluka', 'cus-filter-city', 'cus-filter-village']);
    // filter('CITY', '', 'cus-filter-taluka');
    unselectSingleOption('nav-filter');
    unselectSingleOption('gav-filter');

    ajaxJCBlist(1);
    }
</script>
<script>
    function unselectSingleOption(selectId) {
        $('#' + selectId).prop('selectedIndex', 0);
    }

</script>
<script src="assets/js/new_function.js"></script>