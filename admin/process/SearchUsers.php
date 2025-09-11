<?php

require('../database/connection.php');
if (isset($_GET['text'])) {
    $searchText = $_GET['text'];

    if ($searchText == '') {
        echo '<meta http-equiv="refresh" content="0">';
        exit();
    }

    $user_rs =  Database::search("SELECT * FROM user WHERE email LIKE '%" . $searchText . "%'");
    if ($user_rs->num_rows > 0) {
        $user_row = $user_rs->fetch_assoc();
        $user_status_id =  $user_row['user_status_id'];
        $user_role_id =  $user_row['user_type_id'];

        $user_status_rs = Database::search("SELECT * FROM user_status WHERE id='$user_status_id'");
        $user_status_row = $user_status_rs->fetch_assoc();

        $user_role_rs = Database::search("SELECT * FROM user_type WHERE id='$user_role_id'");
        $user_role_row = $user_role_rs->fetch_assoc();
?>
        <tr>
            <td>
                <?php echo $user_row['id'] ?>
            </td>
            <td>
                <div class="table-data__info">
                    <h6><?php echo $user_row['first_name'] . " " . $user_row['last_name'] ?> </h6>
                    <span>
                        <a href="#"><?php echo $user_row['email'] ?></a>
                    </span>
                </div>
            </td>
            <td>
                <?php if ($user_status_id != 1) { ?>
                    <button class="role admin" onclick="stateChange('<?php echo $user_status_id ?>','<?php echo $user_row['id'] ?>');"><?php echo $user_status_row['name'] ?></button>
                <?php } else { ?>
                    <button class="role member" onclick="stateChange('<?php echo $user_status_id ?>','<?php echo $user_row['id'] ?>');"><?php echo $user_status_row['name'] ?></button>
                <?php } ?>
            </td>
            <td>
                <div class="rs-select2--trans rs-select2--sm">
                    <?php if ($user_role_id == 1) { ?>
                        <button class="role member"><?php echo $user_role_row['name'] ?></button>
                    <?php } else { ?>
                        <button class="role user"><?php echo $user_role_row['name'] ?></button>
                    <?php } ?>
                </div>
            </td>
            <td>
                <span class="more">
                    <i class="zmdi zmdi-more"></i>
                </span>
            </td>
        </tr>
<?php  } else {
        echo ("Invalide Order ID");
        // echo '<meta http-equiv="refresh" content="0">';
    }
} else {
    echo 'something went wrong';
}

?>