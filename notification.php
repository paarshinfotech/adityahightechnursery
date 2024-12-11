<?php require_once 'config.php' ?>
<?php
Peplo::Subtitle('Send Notifications');
isPermitted('custom_push', 'add');
if (isset($_POST['add_to_cronjobs'])) {
    escapePOST($_POST);
    $sqlCols = array();
    $sqlVals = array();
    $type = 'notification';
    if (isset($_POST['notification_type'])) {
        array_push($sqlCols, 'notification_type');
        array_push($sqlVals, "'{$_POST['notification_type']}'");
        $type = $_POST['notification_type'];
    }
    if (isset($_POST['campaign_name'])) {
        $_POST['campaign_name'] = ucwords($_POST['campaign_name']);
        array_push($sqlCols, 'campaign_name');
        array_push($sqlVals, "'{$_POST['campaign_name']}'");
        $campaign_id = strtoupper(substr(str_replace(' ', '', $_POST['campaign_name']), 0, 4)) . date('ymdHis');
        array_push($sqlCols, 'campaign_id');
        array_push($sqlVals, "'{$campaign_id}'");
    }
    if (isset($_POST['send_by'])) {
        array_push($sqlCols, 'send_by');
        array_push($sqlVals, "'{$_POST['send_by']}'");
    }
    if (isset($_POST['send_by_id'])) {
        array_push($sqlCols, 'send_by_id');
        array_push($sqlVals, "'{$_POST['send_by_id']}'");
    }
    if (isset($_POST['subject'])) {
        array_push($sqlCols, 'subject');
        array_push($sqlVals, "'{$_POST['subject']}'");
    }
    if (isset($_POST['message'])) {
        $_POST['message'] = str_replace('%', '%%', $_POST['message']);
        array_push($sqlCols, 'message');
        array_push($sqlVals, "'{$_POST['message']}'");
    }
    if (isset($_POST['template_media']) && !empty($_POST['template_media']) && json_decode($_POST['template_media'])) {
        array_push($sqlCols, 'media');
        array_push($sqlVals, "'{$_POST['template_media']}'");
    } elseif (isset($_FILES['media']) && $_FILES['media']['error'][0] !== 4) {
        $mediaImg = $_FILES['media'];
        $email_media = array();
        foreach ($mediaImg['name'] as $key => $img) {
            if ($mediaImg['error'][$key] !== 4) {
                $ext = pathinfo($img, PATHINFO_EXTENSION);
                $new_name = 'EMAIL-MEDIA' . '-' . date('YmdHis') . $key . '.' . $ext;
                if (move_uploaded_file($mediaImg['tmp_name'][$key], 'image/' . $new_name)) {
                    array_push($email_media, $new_name);
                }
            }
        }
        $media = json_encode($email_media);
        array_push($sqlCols, 'media');
        array_push($sqlVals, "'{$media}'");
    }
    if (isset($_POST['sale_type'])) {
        array_push($sqlCols, 'sale_type');
        array_push($sqlVals, "'{$_POST['sale_type']}'");
    }
    if (isset($_POST['sale_amount'])) {
        array_push($sqlCols, 'sale_amount');
        array_push($sqlVals, "'{$_POST['sale_amount']}'");
    }
    array_push($sqlCols, 'user_id');
    array_push($sqlVals, '\'%1$s\'');
    array_push($sqlCols, 'user_email');
    array_push($sqlVals, '\'%2$s\'');
    array_push($sqlCols, 'user_mobile');
    array_push($sqlVals, '\'%3$s\'');
    $created_on = date('Y-m-d H:i:s');
    array_push($sqlCols, 'created_on');
    array_push($sqlVals, "'{$created_on}'");
    $sql = "INSERT INTO cronjobs(" . implode(', ', $sqlCols) . ") VALUES (" . implode(', ', $sqlVals) . ")";
    $users = array();
    function setUsers($type, $user_id, $user_email, $user_mobile)
    {
        global $users;
        array_push(
            $users,
            array(
                'user_id' => $user_id,
                'user_email' => $user_email,
                'user_mobile' => $user_mobile
            )
        );
    }
    switch ($_POST['send_by']) {
        case 'online_users':
            $getUsers = mysqli_query($connect, "SELECT * FROM customer WHERE is_walking='0'");
            if (mysqli_num_rows($getUsers) > 0) {
                while ($row = mysqli_fetch_assoc($getUsers)) {
                    setUsers($type, $row['cus_id'], $row['email'], $row['mobile']);
                }
            }
            break;
        case 'walkin_users':
            $getUsers = mysqli_query($connect, "SELECT * FROM customer WHERE is_walking='1'");
            if (mysqli_num_rows($getUsers) > 0) {
                while ($row = mysqli_fetch_assoc($getUsers)) {
                    setUsers($type, $row['cus_id'], $row['email'], $row['mobile']);
                }
            }
            break;
        case 'vendors':
            $getUsers = mysqli_query($connect, "SELECT * FROM vendor");
            if (mysqli_num_rows($getUsers) > 0) {
                while ($row = mysqli_fetch_assoc($getUsers)) {
                    setUsers($type, $row['vid'], $row['vemail'], $row['vcontact']);
                }
            }
            break;
        case 'staff_users':
            // use $_POST['send_by_id'] to get staff of vendor
            $getUsers = mysqli_query($connect, "SELECT * FROM staff where vendor_id='{$_POST['send_by_id']}'");
            if (mysqli_num_rows($getUsers) > 0) {
                while ($row = mysqli_fetch_assoc($getUsers)) {
                    setUsers($type, $row['staff_id'], $row['email'], $row['mobile_no']);
                }
            }
            break;
        case 'suppliers':
            // use $_POST['send_by_id'] to get suppliers of vendor
            $getUsers = mysqli_query($connect, "SELECT * FROM supplier where sup_vid='{$_POST['send_by_id']}'");
            if (mysqli_num_rows($getUsers) > 0) {
                while ($row = mysqli_fetch_assoc($getUsers)) {
                    setUsers($type, $row['sup_id'], $row['sup_email'], $row['sup_mobile']);
                }
            }
            break;
        case 'category':
            // use $_POST['send_by_id'] to get users that have purchases in that particular category
            break;
        case 'department':
            // use $_POST['send_by_id'] to get users that have purchases in that particular department
            break;
        case 'sub_category':
            // use $_POST['send_by_id'] to get users that have purchases in that particular sub_category
            break;
        case 'barand':
            // use $_POST['send_by_id'] to get users that have purchases in that particular brand
            break;
        case 'product':
            // use $_POST['send_by_id'] to get users that have purchases in that particular product
            break;
        case 'sale':
            // use $_POST['sale_type'] & $_POST['sale_amount'] to get users that have purchases in that particular sale type & amount
            break;
    }
    foreach ($users as $usr) {
        mysqli_query($connect, sprintf($sql, $usr['user_id'], $usr['user_email'], $usr['user_mobile']));
    }
    header('Location: notification?action=Success&action_msg=action added in que');
    exit();
}
?>
<?php require 'sidebar.php' ?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xl-11 mx-auto">
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bx-sms me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Send Notification/SMS/Email</h5>
                        </div>
                        <hr>
                        <form class="row g-3" method="post" id="send-notify-form" enctype="multipart/form-data">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Notifcation Type</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="notification_type"
                                                    id="type_notification" value="notification">
                                                <label class="form-check-label" for="type_notification">
                                                    Notification
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="notification_type"
                                                    id="type_sms" value="sms">
                                                <label class="form-check-label" for="type_sms">
                                                    SMS
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="notification_type"
                                                    id="type_email" value="email">
                                                <label class="form-check-label" for="type_email">
                                                    Email
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="campaign_name" class="form-label fw-bold">Campaign Name</label>
                                        <input type="text" name="campaign_name" id="campaign_name"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="send_by" class="form-label fw-bold">Send By</label>
                                        <select name="send_by" class="form-select form-select-sm" id="send_by" required>
                                            <option value="">Send By</option>
                                            <option value="online_users">Marketplace Users</option>
                                            <option value="walkin_users">Biz Users</option>
                                            <option value="vendors">Vendors</option>
                                            <option value="staff_users">Staff Users</option>
                                            <option value="suppliers">Supplier Users</option>
                                            <option value="category">By Department</option>
                                            <option value="department">By Category</option>
                                            <option value="sub_category">By Subcategory</option>
                                            <option value="barand">By Brand</option>
                                            <option value="product">By Product</option>
                                            <option value="sale">By Sale</option>
                                        </select>
                                    </div>
                                    <div class="col-12" id="send-by-options" style="display: none;">
                                        <label for="send_by_id" class="form-label fw-bold">Choose Options</label>
                                        <select id="send_by_id" name="send_by_id" class="form-select form-select-sm"
                                            required disabled>
                                        </select>
                                    </div>
                                    <div class="col-12" id="sale-container" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Choose Options</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sale_type"
                                                            id="sale_type_above" value="above" required disabled>
                                                        <label class="form-check-label" for="sale_type_above">
                                                            Above
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="sale_type"
                                                            id="sale_type_below" value="below" required disabled>
                                                        <label class="form-check-label" for="sale_type_below">
                                                            Below
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="sale_amount" class="form-label fw-bold">Sale Amount</label>
                                                <input type="text" class="form-control form-control-sm" id="sale_amount"
                                                    name="sale_amount" required disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="subject-container" style="display: none;">
                                        <label for="subject" class="form-label fw-bold">Subject</label>
                                        <input type="text" class="form-control form-control-sm" id="subject"
                                            name="subject" required disabled>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-bold">Message</label>
                                        <textarea class="form-control form-control-sm" rows="5" name="message"
                                            id="message" required></textarea>
                                    </div>
                                    <div class="col-12" id="media-container" style="display: none;">
                                        <label for="media" class="form-label fw-bold">Media</label>
                                        <input type="file" class="form-control form-control-sm" id="media"
                                            name="media[]" multiple accept=".pdf, .jpg, .jpeg, .png" disabled>
                                        <textarea name="template_media" hidden></textarea>
                                        <div class="template_media row mt-1 g-2"></div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" name="add_to_cronjobs"
                                            class="btn btn-sm btn-primary px-3">Send</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="template-list" style="display: none;">
                                <label for="template" class="form-label fw-bold">Choose From Template</label>
                                <ul class="list-group template-list" style="max-height: 335px;overflow-y: auto;">
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end page wrapper -->
<script>
const templates = {
    sms: false,
    email: false,
    notification: false
}
const sendByOptions = ['staff_users', 'suppliers', 'category', 'department', 'sub_category', 'barand', 'product',
    'sale'];
$('[name="notification_type"]').on('change', function() {
    getTemplate(this.value.toLowerCase());
    $('#template-list').slideDown();
    $('[name="subject"]').val('');
    $('[name="message"]').val('');
    $('[name="template_media"]').val('');
    $('.template_media').html('');
    if (this.value == 'email') {
        $('#subject-container').slideDown();
        $('#media-container').slideDown();
        $('[name="subject"]').prop('disabled', false);
        $('[name="media[]"]').prop('disabled', false);
    } else {
        $('#subject-container').slideUp();
        $('#media-container').slideUp();
        $('[name="subject"]').prop('disabled', true);
        $('[name="media[]"]').prop('disabled', true);
    }
});
$('[name="send_by"]').on('change', function() {
    if (sendByOptions.includes(this.value)) {
        let data = {};
        if (this.value == 'sale') {
            $('[name="send_by_id"]').html('');
            $('#send-by-options').slideUp();
            $('[name="send_by_id"]').prop('disabled', true);
            $('#sale-container').slideDown();
            $('[name="sale_amount"]').prop('disabled', false);
            $('[name="sale_type"]').prop('disabled', false)
        } else {
            switch (this.value) {
                case 'staff_users':
                    data.get_vendors = true;
                    break;
                case 'suppliers':
                    data.get_vendors = true;
                    break;
                case 'category':
                    data.get_department = true;
                    break;
                case 'department':
                    data.get_category = true;
                    break;
                case 'sub_category':
                    data.get_sub_category = true;
                    break;
                case 'barand':
                    data.get_brands = true;
                    break;
                case 'product':
                    data.get_products = true;
                    break;
            }
            $.ajax({
                url: 'ajax_master',
                type: 'POST',
                data: data,
                success: function(res) {
                    $('#sale-container').slideUp();
                    $('[name="sale_type"]').prop('disabled', true)
                    $('[name="sale_amount"]').prop('disabled', true);
                    $('[name="send_by_id"]').html(res);
                    $('#send-by-options').slideDown();
                    $('[name="send_by_id"]').prop('disabled', false);
                }
            });
        }
    } else {
        $('[name="send_by_id"]').html('');
        $('#send-by-options').slideUp();
        $('[name="send_by_id"]').prop('disabled', true);
        $('#sale-container').slideUp();
        $('[name="sale_type"]').prop('disabled', true)
        $('[name="sale_amount"]').prop('disabled', true);
    }
});

function getTemplate(type = false) {
    const data = {
        get_tempate: true
    };
    if (type) {
        data.type = type;
    }
    if (!templates[type]) {
        $.ajax({
            url: 'ajax_master',
            type: 'POST',
            data: data,
            success: function(res) {
                if (res.status === 200) {
                    if (res.data.length > 0) {
                        res.data.forEach((temp) => {
                            if (templates[temp.type.toLowerCase()]) {
                                templates[temp.type.toLowerCase()][temp.temp_id] = temp;
                            } else {
                                templates[temp.type.toLowerCase()] = {};
                                templates[temp.type.toLowerCase()][temp.temp_id] = temp;
                            }
                        });
                    }
                    renderTemplates(res.data);
                }
            }
        });
    } else {
        renderTemplates(Object.values(templates[type]));
    }
}

function selectTemplate(type, temp_id) {
    let temp = templates[type][temp_id];
    if (type !== 'email') {
        $('[name="message"]').val(temp.message);
    } else {
        $('[name="subject"]').val(temp.subject);
        $('[name="message"]').val(temp.message);
        $('[name="template_media"]').val(temp.media);
        for (media of JSON.parse(temp.media)) {
            $('.template_media').append($(`<div class="col-6 col-sm-4 col-md-3">
                                                    <img src="image/${media}" class="w-100 bg-light img-fluid rounded-3 shadow-sm border" loading="lazy" style="object-fit:contain;aspect-ratio: 3/2;">
                                                </div>`));
        }
    }
}

function renderTemplates(data) {
    let tempList = '';
    if (data.length > 0) {
        data.forEach((temp) => {
            tempList += `<li class="list-group-item d-flex justify-content-between align-items-start">
                                <label class="ms-2 me-auto">
                                    <div class="d-flex gap-2">
                                        <input type="radio" name="template" onchange="selectTemplate('${temp.type.toLowerCase()}', this.value)" value="${temp.temp_id}" class="form-check-input">
                                        <div>
                                            <div class="fw-bold">
                                                ${temp.temp_title}
                                            </div>
                                            <div class="fw-bold">
                                                ${temp.subject ? 'Subject - ' + temp.subject : ''}
                                            </div>
                                            <div class="template-text">
                                                ${temp.message.substr(0, 50)}
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </li>`;
        });
    } else {
        tempList += `<li class="list-group-item d-flex justify-content-between align-items-start">
                            <label class="ms-2 me-auto">
                                <div class="fw-bold">
                                    No Templates Available
                                </div>
                            </label>
                        </li>`;
    }
    if ($('.template-list').html(tempList)) {
        return true;
    }
    return false;
}
</script>
<?php require_once 'footer.php' ?>