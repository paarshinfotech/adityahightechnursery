<?php
// update_records.php
require_once "config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you have a database connection
    if (isset($_POST['tableName'])) {
        $table = $_POST['tableName'];

        // Get IDs from the AJAX request
        $ids = isset($_POST['checkboxValues']) ? $_POST['checkboxValues'] : [];
        // print_r($ids);
        // Validate and sanitize the IDs
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, function ($id) {
            return $id > 0; // Only positive integers are allowed
        });
        // print_r($ids);

        if (empty($ids)) {
            echo "Invalid or empty IDs provided.";
            exit();
        }

        $sql = '';
        $name = '';

        // ...

        switch ($table) {
            case 'SALES':
                $sql = "UPDATE sales SET demo_status='0' WHERE sale_id IN (" . implode(',', $ids) . ")";
                $name = "विक्री";
                break;

            case 'CUSTOMER':
                $sql = "UPDATE customer SET customer_status='0' WHERE customer_id IN (" . implode(',', $ids) . ")";
                $name = "ग्राहक";
                break;

            case 'ZENDU':
                $sql = "UPDATE zendu_booking SET zb_status='0' WHERE zendu_id IN (" . implode(',', $ids) . ")";
                $name = "बुकिंग";
                break;

            case 'PURCHASE':
                $sql = "UPDATE purchase SET purchase_status='0' WHERE purchase_id IN (" . implode(',', $ids) . ")";
                $name = "खरेदी";
                break;

            case 'SUPPLIER':
                $sql = "UPDATE supplier SET sup_status='0' WHERE supplier_id IN (" . implode(',', $ids) . ")";
                $name = "पुरवठादार";
                break;

            case 'PRODUCT':
                $sql = "UPDATE product SET product_status='0' WHERE product_id IN (" . implode(',', $ids) . ")";
                $name = "प्रॉडक्ट";
                break;

            case 'BHAJIPALA':
                $sql = "UPDATE bhajipala_sales SET is_not_delete='0' WHERE sale_id IN (" . implode(',', $ids) . ")";
                $name = "बहुचरी विक्री";
                break;

            case 'PRODUCTCATEGORY':
                $sql = "UPDATE category_product SET product_cat_status='0' WHERE cat_id IN (" . implode(',', $ids) . ")";
                $name = "प्रॉडक्ट श्रेणी";
                break;
            case 'ZENDUCATEGORY':
                $sql = "UPDATE marigold_category SET cat_status='0' WHERE cat_id IN (" . implode(',', $ids) . ")";
                $name = "झेंडू श्रेणी";
                break;

            case 'LETTERLIST':
                $sql = "UPDATE  letter_pad SET letter_status='0' WHERE lid IN (" . implode(',', $ids) . ")";
                $name = "लेटर पॅड";
                break;

            case 'EXPENSESCATEGORY':
                $sql = "UPDATE expenses_category SET ex_cat_status='0' WHERE ex_cat_id IN (" . implode(',', $ids) . ")";
                $name = "खर्च श्रेणी";
                break;

            case 'CARRENTALCATEGORY':
                $sql = "UPDATE car_rental_category SET car_cat_status='0' WHERE car_cat_id IN (" . implode(',', $ids) . ")";
                $name = "गाडी भाडे श्रेणी";
                break;

            case 'SEEDCATEGORY':
                $sql = "UPDATE seeds_category SET status='0' WHERE cat_id IN (" . implode(',', $ids) . ")";
                $name = "बियाणे आवक व जावक श्रेणी";
                break;

            case 'JCBCATEGORY':
                $sql = "UPDATE jcb_category SET jcb_cat_status='0' WHERE jcb_cat_id IN (" . implode(',', $ids) . ")";
                $name = "जेसीबी श्रेणी";
                break;

            case 'EXPENSES':
                $sql = "UPDATE expenses SET ex_status='0' WHERE ex_id IN (" . implode(',', $ids) . ")";
                $name = "खर्च";
                break;

            case 'EMPLOYEE':
                $sql = "UPDATE employees SET emp_status='0' WHERE emp_id IN (" . implode(',', $ids) . ")";
                $name = "कर्मचारी";
                break;

            case 'INWARD':
                $sql = "UPDATE inward SET inward_status='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "आवक";
                break;

            case 'EXPENSE':
                $sql = "UPDATE expense SET ex_status='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "मधून सर्व खर्च";
                break;

            case 'BANK':
                $sql = "UPDATE bank_trans SET bank_status='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "बँक व्यवहार";
                break;

            case 'CASH':
                $sql = "UPDATE cash_expenditure SET cash_status='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "दादा व दशरथ हस्ते नगदी खर्च";
                break;

            case 'INCOME':
                $sql = "UPDATE bank_inward SET bank_inward_status ='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "बँक आवक";
                break;

            case 'USANA':
                $sql = "UPDATE borrowing SET bo_status='0' WHERE inward_id IN (" . implode(',', $ids) . ")";
                $name = "उसना व्यवहार";
                break;

            case 'CARRENTCATEGORY':
                $sql = "UPDATE car_rental_category SET car_cat_status='0' WHERE car_cat_id IN (" . implode(',', $ids) . ")";
                $name = "गाडी भाडे श्रेणी";
                break;

            case 'CARRANT':
                $sql = "UPDATE car_rental SET car_status='0' WHERE cr_id IN (" . implode(',', $ids) . ")";
                $name = "गाडी भाडे श्रेणी";
                break;

            case 'SEED':
                $sql = "UPDATE seeds_sales SET seeds_status='0' WHERE sale_id IN (" . implode(',', $ids) . ")";
                $name = "बियाणे ";
                break;

            case 'MOBILEDARY':
                $sql = "UPDATE mobile_diary SET status='0' WHERE mob_id IN (" . implode(',', $ids) . ")";
                $name = "बियाणे ";
                break;

            case 'ALLLOAN':
                $sql = "UPDATE all_loan_details SET loan_status='0' WHERE ald_id IN (" . implode(',', $ids) . ")";
                $name = "बियाणे ";
                break;

            case 'SALCAR':
                $sql = "UPDATE salcar SET salcar_status='0' WHERE sal_id IN (" . implode(',', $ids) . ")";
                $name = "साल कार ";
                break;

            case 'JCB':
                $sql = "UPDATE jcb SET jcb_status='0' WHERE jcb_id IN (" . implode(',', $ids) . ")";
                $name = "जेसीबी";
                break;

            // Add more cases for different tables as needed...

            default:
                echo "Invalid table name";
                exit();
        }

        // ...


        if (!empty($sql)) {
            // Use prepared statement to prevent SQL injection
            $stmt = mysqli_prepare($connect, $sql);

            if ($stmt) {
                // Execute the statement
                if (mysqli_stmt_execute($stmt)) {
                    echo $name . " डेटा हटवला आहे";
                } else {
                    echo "Error updating records: " . mysqli_stmt_error($stmt);
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($connect);
            }
        }
    }
}


?>



<?php
//     if ($table === 'PRODUCT') {
//         $sql = "UPDATE product SET product_status='0' WHERE product_id IN (" . implode(',', $ids) . ")";
//         $name = "Product IDs: " . implode(',', $ids);
//     } elseif ($table === 'BHAJIPALA') {
//         $sql = "UPDATE bhajipala_sales SET is_not_delete='0' WHERE sale_id IN (" . implode(',', $ids) . ")";
//         $name = "Bhajipala IDs: " . implode(',', $ids);
//     } else {
//         echo "Invalid table name";
//         exit();
//     }

//     if (!empty($sql)) {
//         $stmt = mysqli_prepare($connect, $sql);

//         if ($stmt) {
//             if (mysqli_stmt_execute($stmt)) {
//                 echo $name . " डेटा हटवला आहे";
//             } else {
//                 // Log the error message for debugging
//                 error_log("Error executing query: " . mysqli_stmt_error($stmt));
//                 echo $name . " डेटा हटविण्यात अयशस्वी";
//             }

//             mysqli_stmt_close($stmt);
//         } else {
//             // Log the error message for debugging
//             error_log("Error preparing query: " . mysqli_error($connect));
//             echo $name . " डेटा हटविण्यात अयशस्वी";
//         }
//     }
// }
?>