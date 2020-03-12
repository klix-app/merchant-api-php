<?php

require_once 'ShippingOptions.php';

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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
	<style>
		.actions {
			margin: 10px;
			float: right;
		}
	</style>
</head>

<body>
<h1>Klix Checkout</h1>
<form id="returnForm" action="checkout.php" method="post">
	<input type="hidden" hidden="hidden" readonly="readonly" name="language" id="language" value="lv"/>
	<input type="hidden" hidden="hidden" readonly="readonly" name="orderId" id="orderId" value="<?php echo gen_uuid(); ?>"/>
	<h2>Available delivery options</h2>
	<fieldset>
		<?php
		$shippingOptions = new \ShippingOptions();
		foreach ($shippingOptions->getShippingOptions() as $shippingOption) {
			echo '<div class="checkbox">';
			echo '<input type="checkbox" name="shippingMethods[]" value="' . $shippingOption->getId() . '" checked>'
				. $shippingOption->getTitle() . ' - <input type="number" placeholder="Shipping cost" value="'
				. $shippingOption->getAmount() . '"/> ' . $shippingOption->getCurrency() . '</input>';
			echo '</div>';
		}
		?>
	</fieldset>
	<h2>Order items</h2>
	<table class="table" id="order-lines">
		<thead class="thead-light">
		<tr>
			<th id="orderItemId">orderItemId</th>
			<th id="amount">amount</th>
			<th id="currency">currency</th>
			<th id="taxRate">taxRate</th>
			<th id="label">label</th>
			<th id="count">count</th>
			<th id="unit">unit</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<input type="hidden" name="orderItems" id="orderItems"/>
	<div class="actions">
		<button type="button" class="btn btn-secondary" id="add-order-line">Add order line</button>
		<button type="button" class="btn btn-primary" id="submit-order">Checkout with Klix</button>
	</div>
</form>
<script type="text/javascript">
	function uuid() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	}

	function createCell(row, cellIndex, editable, defaultValue) {
		const cell = row.insertCell(cellIndex);
		cell.setAttribute("contenteditable", editable);
		cell.innerText = defaultValue;
		return cell;
	}

	function addOrderLine() {
		const orderLinesTable = document.querySelector("#order-lines");
		const row = orderLinesTable.insertRow();
		createCell(row, 0, false, uuid());
		createCell(row, 1, true, '100.00');
		createCell(row, 2, false, 'EUR');
		createCell(row, 3, true, '0.21');
		createCell(row, 4, true, 'Product ' + row.rowIndex);
		createCell(row, 5, true, row.rowIndex);
		createCell(row, 6, false, 'PIECE');
	}

	document.querySelector("#add-order-line").addEventListener("click", addOrderLine);

	document.querySelector("#submit-order").addEventListener("click", event => {
		const orderLinesTable  = document.querySelector("#order-lines");
		const data = [];
		for (let rowIndex = 1; rowIndex < orderLinesTable.rows.length; rowIndex++) {
			const row = orderLinesTable.rows.item(rowIndex);
			const columns = {};
			orderLinesTable.querySelectorAll('th').forEach((header, headerIndex) => {
				columns[header.id] = row.cells[headerIndex].innerText;
			});
			data.push(columns);
		}

		const orderItemsHiddenInput = document.querySelector("#orderItems");
		orderItemsHiddenInput.value = JSON.stringify(data);
		document.querySelector("#returnForm").submit();
	});

	addOrderLine();
</script>
</body>
</html>
