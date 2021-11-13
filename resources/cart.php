<?php require_once("config.php") ?>


<?php

if (isset($_GET['add'])) {
    $query = query("SELECT * from products where product_id=" . escape_string($_GET['add']) . " ");
    confirm($query);

    while ($row = fetch_array($query)) {
        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {
            $_SESSION['product_' . $_GET['add']] += 1;
            redirect("../public_html/teslaelectronics/checkout.php");
        } else {
            set_message("We only have " . $row['product_quantity'] . " " . "available quantity for {$row['product_title']}");
            redirect("../public_html/teslaelectronics/checkout.php");
        }
    }
}


if (isset($_GET['remove'])) {
    $query = query("SELECT * from products where product_id=" . escape_string($_GET['remove']) . " ");
    confirm($query);

    $_SESSION['product_' . $_GET['remove']]--;
    redirect("../public_html/teslaelectronics/checkout.php");
}

if (isset($_GET['delete'])) {
    $_SESSION['product_' . $_GET['delete']] = 0;

    unset($_SESSION['item-total']);
    unset($_SESSION['item_quantity']);

    redirect("../public_html/teslaelectronics/checkout.php");
}


function cart()
{
    $total = 0;
    $item_quantity = 0;
    $sub = 0;

    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity =1;

    foreach ($_SESSION as $name => $value) {
        if ($value > 0) {

            if (substr($name, 0, 8) === "product_") {

                $length = strlen($name) - 8;
                $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE product_id=" . escape_string($id) . " ");
                confirm($query);

                while ($row = fetch_array($query)) {
                    $sub = $value * $row['product_price'];
                    $item_quantity += $value;

                    $product_image = display_image($row['product_image']);

                    $product = <<<DELIMETER

                <tr>
                    <td>{$row['product_title']} <br>
                    <img width='100' src="../../resources/{$product_image}">
                    </td>
                    <td>{$row['product_price']}</td>
                    <td>{$_SESSION[$name]}</td>
                    <td>{$sub}</td>
                    <td><a href="../../resources/cart.php?remove={$row['product_id']}" class='btn btn-warning'><span class='glyphicon glyphicon-minus'></span></a> <a href="../../resources/cart.php?add={$row['product_id']}" class='btn btn-success'><span class='glyphicon glyphicon-plus'></span></a></td>
                    <td><a href="../../resources/cart.php?delete={$row['product_id']}" class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>

                <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                <input type="hidden" name="quantity_{$quantity}" value="{$value}">
        DELIMETER;

                    echo $product;

                    $item_name++;
                    $item_number++;
                    $amount++;
                    $quantity++;
                }

                $_SESSION['item-total'] = $total += $sub;
                $_SESSION['item_quantity'] = $item_quantity;
            }
        }
    }
}


function show_paypal() {

    if(isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {

        $paypal_button = <<<DELIMETER

        <input type="image" name="upload" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">

        DELIMETER;

        return $paypal_button;
    }
    
}



function process_transaction()
{

    if(isset($_GET['tx'])) {
        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];
    

        
        // session_destroy();
    }
    
    else {
        redirect("index.php");
    }

    $total = 0;
    $item_quantity = 0;


    foreach ($_SESSION as $name => $value) {
        if ($value > 0) {

            if (substr($name, 0, 8) === "product_") {

                $length = strlen($name) - 8;
                $id = substr($name, 8, $length);

                $send_order = query(" INSERT INTO orders (order_amount, order_transaction, order_status, order_currency) VALUES ('{$amount}', '{$currency}', '{$transaction}', '{$status}') ");
        
                $last_id = last_id();
        
                confirm($send_order);

                $query = query("SELECT * FROM products WHERE product_id=" . escape_string($id) . " ");
                confirm($query);

                while ($row = fetch_array($query)) {
                    $sub = $value * $row['product_price'];
                    $item_quantity += $value;
                    $product_price = $row['product_price'];
                    $product_quantity = $row['product_price'];

                    $insert_report = query(" INSERT INTO reports (product_id, order_id, product_price, product_quantity) VALUES ('{$id}', '{$last_id}', '{$product_price}', '{$value}', {$product_quantity}) ");
                    confirm($insert_report);
                   
                }

                $total += $sub;
                echo $item_quantity;
            }
        }
    }
}








?>