<?php

function gen_uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <style>
        input {
            display: block;
            font-size: medium;
            width: 300px
        }

        label {
            display: block
        }

        button {
            font-size: medium
        }
    </style>
</head>

<body>

<form style="font-size: large" id="returnForm" action="payment.php" method="post">
    <input type="hidden" hidden="hidden" readonly="readonly" name="language" id="language" value="lv"/>
    <input type="hidden" hidden="hidden" readonly="readonly" name="orderId" id="orderId"
           value="<?php echo gen_uuid(); ?>"/>
    <label for="price">Price:</label>
    <input type="text" name="price" id="price" value="5.12">
    <label for="currency">Currency:</label>
    <input type="text" name="currency" id="currency" value="EUR">
    <label for="label">Description:</label>
    <input type="text" name="label" id="label" value="Some product">
    <button type="submit">Pay with Klix</button>
</form>


</body>

</html>
