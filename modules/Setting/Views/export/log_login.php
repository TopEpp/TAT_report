<body>
	<table border="1" style="border-collapse:collapse;">
		<thead>
			<tr>
				<th colspan="5" style="text-align:center;background:#70D3DE;">
					Log Login<?php echo (!empty($range_label)) ? ' (' . $range_label . ')' : ''; ?>
				</th>
			</tr>
			<tr>
				<th style="background:#B7E9EF;">LOGIN DATE</th>
				<th style="background:#B7E9EF;">USER ID</th>
				<th style="background:#B7E9EF;">USERNAME</th>
				<th style="background:#B7E9EF;">ORG ID</th>
				<th style="background:#B7E9EF;">IP ADDRESS</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $d) { ?>
				<tr>
					<td style="mso-number-format:'\@';"><?php echo $d['LOGIN_DATE'] ?></td>
					<td style="mso-number-format:'\@';"><?php echo $d['USER_ID'] ?></td>
					<td><?php echo $d['USERNAME'] ?></td>
					<td style="mso-number-format:'\@';"><?php echo $d['ORG_ID'] ?></td>
					<td style="mso-number-format:'\@';"><?php echo $d['IP_ADDRESS'] ?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</body>
