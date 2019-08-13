<div>
	<div><h1>Payment Information</h1></div>
	<form class="forms" name="card-info" onsubmit="return validateCard()" action="validate.php">
		<div class="center">
			<div>
				<label>Card type:</label>
				<select required>
					<option value="">--</option>
					<option value="Visa">Visa</option>
					<option value="Mastercard">Mastercard</option>
					<option value="American Express">American Express</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="input-group">
				<input type="text" name="cardNumber" required>
				<label>Card Number:</label>
			</div>
			<div class="input-group">
				<input type="text" name="cvv" required>
				<label>Cvv:</label>
			</div>
			<div class="input-group">
				<input type="text" name="Name" required>
				<label>Name on Card:</label>
			</div>
			<div>
				<input type="radio" name="pay" checked="checked">Pay Once
				<input type="radio" name="pay">Allow reoccuring payments
			</div>
			<div class="button-container">
				<div>
					<a href="javascript:history.back();"><div class="button form"><p>Back</p></div></a>
					<input type="submit" name="Submit" value="Submit">
				</div>
			</div>
		</div>
	</form>
</div>