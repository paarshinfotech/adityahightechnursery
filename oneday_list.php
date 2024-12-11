<?php require "config.php"; ?>
<?php
Aditya::subtitle('एक दिवसाची आवक आणि जावक यादी');
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch data from the database
$inwards = fetchData("SELECT * FROM inward WHERE idate = '{$date}' and inward_status='1'");
$expenses = fetchData("SELECT * FROM expense WHERE idate = '{$date}' and ex_status='1'");
$bankTrans = fetchData("SELECT * FROM bank_trans WHERE idate = '{$date}' and bank_status='1'");
$cashExp = fetchData("SELECT * FROM cash_expenditure WHERE idate = '{$date}' and cash_status='1'");
$bankInwrd = fetchData("SELECT * FROM bank_inward WHERE idate = '{$date}' and bank_inward_status='1'");
$borrowing = fetchData("SELECT * FROM borrowing WHERE idate = '{$date}' and bo_status='1'");

$largeCol = max(
    count($inwards),
    count($expenses),
    count($bankTrans),
    count($cashExp),
    count($bankInwrd),
    count($borrowing)
);
?>

<?php require "header.php"; ?>
<!-- Start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">एक दिवसाची आवक आणि जावक यादी</h6>
        <a class="btn btn-sm btn-success float-end" href="oneday_add" style="margin-top:-25px;">
            <i class="bx bx-plus-circle me-1"></i>नवीन तयार करा
        </a>
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <div class="ms-auto p-2 d-flex export-container">
                    </div>
                </div>
                <div class="table-responsive">
                    <table border="1" id="example2"
                        class="table table-striped table-bordered table-hover multicheck-container">
                        <thead>
                            <tr>
                                <th>तारीख</th>
                                <th>आवक</th>
                                <th>रुपये</th>
                                <th>आवक मधून सर्व खर्च</th>
                                <th>रुपये</th>
                                <th>बँक व्यवहार खर्च एमजीबी</th>
                                <th>रुपये</th>
                                <th>दादा आणि दशरथ यांनी केलेला रोख खर्च</th>
                                <th>रुपये</th>
                                <th>बँक आवक</th>
                                <th>रुपये</th>
                                <th>कर्ज घेतलेले व्यवहार</th>
                                <th>रुपये</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < $largeCol; $i++): ?>
                                <tr style="">
                                    <td class="text-dark fw-bold">
                                        <?= $i == 0 ? date('d M Y', strtotime($date)) : '' ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$inwards[$i]['inward']) ?>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$inwards[$i]['inward_rs']) ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$expenses[$i]['inward']) ?>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$expenses[$i]['inward_rs']) ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$bankTrans[$i]['inward']) ?>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$bankTrans[$i]['inward_rs']) ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$cashExp[$i]['inward']) ?>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$cashExp[$i]['inward_rs']) ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$bankInwrd[$i]['inward']) ?>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$bankInwrd[$i]['inward_rs']) ?>
                                    </td>
                                    <td>
                                        <?= formatData(@$borrowing[$i]['inward']) ?><span
                                            class="ms-2"><?= @$borrowing[$i]['contact'] ?? '' ?></span>
                                    </td>
                                    <td>
                                        <?= formatAmount(@$borrowing[$i]['inward_rs']) ?>
                                    </td>
                                </tr>
                            <?php endfor ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End page wrapper -->
<?php include "footer.php"; ?>

<?php
// Function to fetch data from the database
function fetchData($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

// Function to format data
function formatData($data)
{
    return !empty($data) ? '₹ ' . $data : '';
}

// Function to format amount
function formatAmount($amount)
{
    return !empty($amount) ? '₹ ' . $amount . '/-' : '';
}
?>
