<?php
include '../includes/header.php';
if (!isset($_SESSION['username'])) {
	echo "<script>window.location.href='/theshoesbox/pages/login.php';</script>";
}
include '../includes/connection.php';
?>
<!-- <?php
		$userId = $_SESSION['user_id'];
?> -->
<?php
$proId = $_GET['pro_id'];
?>
<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-10 ftco-animate">
				<form action="#" class="billing-form">
					<h3 class="mb-4 billing-heading">Billing Details</h3>
					<div class="row align-items-end">
						<div class="col-md-12">
							<div class="form-group">

								<label for="firstname">First Name</label>
								<input type="text" name="fname" id="fname" class="form-control" placeholder="First Name">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="streetaddress">Street Address</label>
								<input type="text" name="address" id="address" class="form-control" placeholder="House number and street name">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="towncity">Town / City</label>
								<input type="text" name="city" id="city" class="form-control" placeholder="City">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="towncity">State</label>
								<input type="text" name="state" id="state" class="form-control" placeholder="State">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="postcodezip">Postcode / ZIP *</label>
								<input type="number" name="pincode" id="pincode" class="form-control" placeholder="Pincode">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="number" name="phoneno" id="phoneno" class="form-control" placeholder="Phone No">
							</div>
						</div>
						<div class="w-100"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="emailaddress">Email Address</label>
								<input type="text" name="email" id="email" class="form-control" placeholder="Email Address">
							</div>
						</div>
						<p><a href="#" type="submit" name="order" id="order" class="btn btn-primary py-3 px-5">Proceed To an Order</a></p>
					</div>
				</form>
			</div> <!-- .col-md-8 -->
		</div>
	</div>
</section> <!-- .section -->

<?php
include '../includes/footer.php';
?>

<script>
	$("#order").on("click", function() {
		var userId = <?php echo $userId; ?>;
		var proId = <?php echo $proId; ?>;
		var fname = $("#fname").val()
		var address = $("#address").val()
		var city = $("#city").val()
		var state = $("#state").val()
		var pincode = $("#pincode").val()
		var phoneno = $("#phoneno").val()
		var email = $("#email").val()

		$.ajax({
			type: "POST",
			url: "/theshoesbox/processes/address-process.php",
			data: {
				userId: userId,
				proId: proId,
				fname: fname,
				address: address,
				city: city,
				state: state,
				pincode: pincode,
				phoneno: phoneno,
				email: email,
			},
			success: function(res) {
				if (res == "Address Register Successfully.")
					swal({
						title: "Success",
						text: res,
						type: "success"
					}, function() {
						window.location = "/theshoesbox/pages/checkout.php?pro_id=<?php echo $proId; ?>";
					});
				else if (res == "Fill all fields!") swal("Oops!!", res, "warning");
				else swal("Oops!!", res, "error");
			}
		});
	});
</script>