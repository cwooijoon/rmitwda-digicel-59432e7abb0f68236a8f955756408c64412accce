<?php
// This is edit procossor page
?>
<html>
<head>
	<title>Edit Processor</title>
</head>
<body>
	<h2>Edit Processor</h2>
	<form method="POST" action="update">
		<table>
			<tr>
				<td>Category:</td>
				<td>
					<input type="text" name="category_name" value="Processor" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>Brand:</td>
				<td>
					<select name="brand_id">
						<option value="<?php echo $template->processors->brand_id; ?>"><?php echo $template->processors->brand_name; ?></option>
					</select>
				</td>
				<td>
					<a href="/Test/brands/new">Click here</a> to add a new brand.
				</td>
			</tr>
			<tr>
				<td>Processor Name:</td>
				<td>
					<input type="text" name="proc_name" value="<?php echo $template->processors->proc_name; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['proc_name'])) {
						echo $template->errors['proc_name'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Processor Model:</td>
				<td>
					<input type="text" name="proc_model" value="<?php echo $template->processors->proc_model; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['proc_model'])) {
						echo $template->errors['proc_model'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Processor Speed:</td>
				<td>
					<input type="text" name="proc_speed" value="<?php echo $template->processors->proc_speed; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['proc_speed'])) {
						echo $template->errors['proc_speed'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Stock Available:</td>
				<td>
					<input type="text" name="stock" value="<?php echo $template->processors->stock; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['stock'])) {
						echo $template->errors['stock'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Price:</td>
				<td>
					<input type="text" name="price" value="<?php echo $template->processors->price; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['price'])) {
						echo $template->errors['price'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Warranty:</td>
				<td>
					<input type="text" name="warranty" value="<?php echo $template->processors->warranty; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['warranty'])) {
						echo $template->errors['warranty'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>Notes or Comments:</td>
				<td>
					<input type="text" name="comments" value="<?php echo $template->processors->comments; ?>" />
				</td>
				<td>
					<?php
						if (isset($template->errors['comments'])) {
						echo $template->errors['comments'];
						}
					?>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="update_processor" value="Update" />
				</td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</form>
</body>
</html>

