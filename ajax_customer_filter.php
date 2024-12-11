<?php
require_once "config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['code'] === 'CITY') {
        ?>
        <?php
        if (empty($_POST['value'])) {
            // $sql = " `city` = '" . $_POST['value'] . "' and " ;
            echo '<option value="">सर्व</option>';
        } else {
            $sql = " `city` = '" . $_POST['value'] . "' and ";
            // SQL query to get unique villages
            // $sql = "SELECT DISTINCT village FROM customer";
            $sql = "SELECT DISTINCT `taluka` FROM customer WHERE " . $sql . " `taluka` IS NOT NULL AND `taluka` != '';";

            // echo datasource($sql);
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<option value="">सर्व</option>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . ($row["taluka"]) . '">' . ($row["taluka"]) . '</option>';
                }
            } else {
                echo '<option value="">आवश्यक फाउंट नाही</option>';
            }
        }
        ?>




    <?php } elseif ($_POST['code'] === 'TALUKA') {
        ?>
        <?php
        if (empty($_POST['value'])) {
            echo '<option value="">सर्व</option>';
        } else {
            // SQL query to get unique villages
            // $sql = "SELECT DISTINCT village FROM customer";
            $sql = "SELECT DISTINCT `village` FROM customer WHERE taluka = '" . $_POST['value'] . "' AND `village` IS NOT NULL AND `village` != '';";
            // echo $_POST['value'] . " //////////////////";

            echo "//" . $sql . "//";
            $result = mysqli_query($connect, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<option value="">सर्व</option>';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . ($row["village"]) . '">' . ($row["village"]) . '</option>';
                }
            } else {
                echo `<option value="">आवश्यक फाउंट नाही</option>`;
            }
        }
    ?>
    <?php } ?>
<?php } ?>