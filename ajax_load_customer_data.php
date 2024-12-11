<?php
require_once "config.php";

function executeQuery($connect, $query , $funName)
{
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<ul id="customer_search_results" class="list-group position-absolute w-100 bg-white border-2 text-start" style="max-height: 15rem;overflow-y: scroll;border: #ababab 2px solid; z-index: 1;" >';
        while ($row = mysqli_fetch_assoc($result)) : ?>
            <li class="list-group-item"
                onclick="<?= $funName?>(<?php echo $row['customer_id'] ?> , '<?php echo $row['customer_name'] ?>' ,  '<?php echo $row['customer_mobno'] ?>' ,  '<?php echo $row['total'] ?>') ">
                <?= $row['customer_id'] ?> |
                <?= $row['customer_name'] ?> , (
                <?= $row['customer_mobno'] ?> )
            </li>
        <?php endwhile;
        echo '</ul>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['type']) && $_GET['type'] == 'advance' && isset($_GET['searchInput'])) {
        $searchInput = mysqli_real_escape_string($connect, $_GET['searchInput']);

        $query = is_numeric($searchInput)
            ? "SELECT * FROM customer c JOIN sales s ON c.customer_id = s.customer_id WHERE c.customer_mobno LIKE '%$searchInput%' GROUP BY s.customer_id LIMIT 10"
            : "SELECT * FROM customer c JOIN sales s ON c.customer_id = s.customer_id WHERE c.customer_name LIKE '%$searchInput%' GROUP BY s.customer_id LIMIT 10";

        executeQuery($connect, $query , 'updateCustomerSearchAdvance');
    } elseif (isset($_GET['searchInput'])) {
        $searchInput = mysqli_real_escape_string($connect, $_GET['searchInput']);

        $query = is_numeric($searchInput)
            ? "SELECT * FROM customer WHERE customer_status=1 AND customer_mobno LIKE '%$searchInput%' LIMIT 10"
            : "SELECT * FROM customer WHERE customer_status=1 AND customer_name LIKE '%$searchInput%' LIMIT 10";

        executeQuery($connect, $query , 'updateCustomerSearch');
    }
}
?>
