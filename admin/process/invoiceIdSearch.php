<?php

require('../database/connection.php');
if (isset($_GET['inid'])) {
    $order_id = $_GET['inid'];

    if ($order_id == '') {
        echo '<meta http-equiv="refresh" content="0">';
        exit();
    }

    $orders_rs =  Database::search("SELECT * FROM orders WHERE id='$order_id'");
    if ($orders_rs->num_rows > 0) {
        $order_row = $orders_rs->fetch_assoc();
?>
        <tr>
            <td><?php echo $order_row['id'] ?></td>
            <td>
                <?php
                $oderId = $order_row['id'];
                $total_rs = Database::search("SELECT SUM(order_item.qty * product.price) AS total_cost FROM order_item INNER JOIN product ON order_item.product_id=product.product_id WHERE orders_id='$oderId'");
                $tota_row = $total_rs->fetch_assoc();

                $order_item_rs = Database::search("SELECT * FROM order_item WHERE orders_id='$oderId'");



                $addressId = $order_row['address_id'];
                $address_rs = Database::search("SELECT * FROM address WHERE id='$addressId'");

                $length = $order_item_rs->num_rows;
                // echo $length;
                $addres_row = $address_rs->fetch_assoc();

                $addres_row['city_id'];

                $city_rs = Database::search("SELECT * FROM city WHERE id='" . $addres_row['city_id'] . "'");
                // $city_row = $city_rs->fetch_assoc();

                // $total = 0;
                $newTotal = 0;
                while ($city_row = $city_rs->fetch_assoc()) {
                    $shippingCharge = $city_row["shipping_charge"];

                    $fullTotal = $shippingCharge * $length;

                    $total = $tota_row['total_cost'];
                    $newTotal = $total + $fullTotal;
                } ?>
                Rs.<?php echo $newTotal ?>
            </td>
            <td>
                <span><?php echo $order_row['date_time'] ?></span>
            </td>
            <td>
                <?php
                // $addressId = $order_row['address_id'];
                $address_rs = Database::search("SELECT * FROM address WHERE id='$addressId'");

                if ($address_rs->num_rows != 0) {
                    $addres_row = $address_rs->fetch_assoc();
                ?>
                    <span><?php echo $addres_row['line1'] ?> <br><?php echo $addres_row['line2'] ?> <br><?php echo $addres_row['mobile'] ?> </span>
                <?php
                } else { ?>

                <?php } ?>

            </td>
            <td>
                <div class="table-data-feature">

                    <button class="item" data-toggle="tooltip"
                        onclick="showOrderDetails('<?php echo $oderId ?>');"
                        data-placement="top" title="More">
                        <i class="zmdi zmdi-more"></i>
                    </button>
                </div>
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