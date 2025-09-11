<?php
require('../database/connection.php');

if (isset($_GET['pid'])) {
    $product_id = $_GET['pid'];
    // echo $product_id;

    $product_rs =  Database::search("SELECT * FROM product WHERE product_id='$product_id'");
    if ($product_rs->num_rows > 0) {
        $product_row = $product_rs->fetch_assoc();
?>
        <tr class="tr-shadow">
            <td>
                <?php echo $product_row['product_id'] ?>
            </td>
            <?php
            $user_id = $product_row['user_id'];
            $user_rs = Database::search("SELECT * FROM user WHERE id='$user_id'");
            $user_row = $user_rs->fetch_assoc();
            ?>
            <td><?php echo $user_row['first_name'] . " " . $user_row['last_name'] ?></td>
            <td>
                <div class="image">
                    <a href="#">
                        <img src="../webImg/productImages/<?php echo $product_row['product_id'] ?>/image1.png" alt="" class="product-image" />
                    </a>
                </div>
            </td>

            <td class="desc"><?php echo $product_row['product_name'] ?></td>
            <td>
                Rs.<input type="number" value="<?php echo $product_row['discount'] ?>" id="discount_<?php echo $product_row['product_id'] ?>">
                <button onclick="giveDiscount('<?php echo $product_row['product_id'] ?>');">Update</button>
            </td>
            <td>
                <?php if ($product_row['product_status_id'] != 1) { ?>
                    <button onclick="changeStatus(' <?php echo $product_row['product_id'] ?>','<?php echo $product_row['product_status_id'] ?>');" class="status--denied">Deactivated</button>
                <?php } else { ?>
                    <button onclick="changeStatus(' <?php echo $product_row['product_id'] ?>','<?php echo $product_row['product_status_id'] ?>');" class="status--process">Active</button>
                <?php } ?>
            </td>
            <td>RS.<?php echo $product_row['price'] ?></td>
            <!-- <td>
                                                        <div class="table-data-feature">
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Send">
                                                                <i class="zmdi zmdi-mail-send"></i>
                                                            </button>
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Edit">
                                                                <i class="zmdi zmdi-edit"></i>
                                                            </button>
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                            <button class="item" data-toggle="tooltip"
                                                                data-placement="top" title="More">
                                                                <i class="zmdi zmdi-more"></i>
                                                            </button>
                                                        </div>
                                                    </td> -->
            <td><?php echo $product_row['qty'] ?></td>
        </tr>
        <tr class="spacer"></tr>
<?php

    } else {
        echo ("Invalide Product ID");
        echo '<meta http-equiv="refresh" content="0">';
    }
}

?>