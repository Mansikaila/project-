<?php
include '../includes/header.php';
if (!isset($_SESSION['username'])) {
	echo "<script>window.location.href='/theshoesbox/pages/login.php';</script>";
}
include '../includes/connection.php';
?>
<?php
$user_id = $_SESSION['user_id'];
?>

<div class="hero-wrap hero-bread" style="background-image: url('/theshoesbox/assets/images/bg_6.jpg');">
	<div class="container">
		<div class="row no-gutters slider-text align-items-center justify-content-center">
			<div class="col-md-9 ftco-animate text-center">
				<p class="breadcrumbs"><span class="mr-2"><a href="/theshoesbox/index.php">Home</a></span> <span>Profile</span></p>
				<h1 class="mb-0 bread">Profile</h1>
			</div>
		</div>
	</div>
</div>

<div class="bootstrap-modal">
	<!-- Update profile -->
	<div class="modal fade" id="update">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Update Your Profile</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h6 class="card-title">Your Id</h6>
					<div class="form-group">
						<input type="text" class="form-control input-small" name="id" id="editid" disabled>
					</div>
					<h6 class="card-title">Enter Your Name</h6>
					<div class="form-group">
						<input type="text" class="form-control input-default" name="name" id="editname" placeholder="Enter Your Name">
					</div>
					<h6 class="card-title">Enter Your Email</h6>
					<div class="form-group">
						<input type="text" class="form-control input-default" name="email" id="editemail" placeholder="Enter Your Email">
					</div>
					<h6 class="card-title">Enter Your PhoneNo</h6>
					<div class="form-group">
						<input type="number" class="form-control input-default" name="phoneno" id="editphoneno" placeholder="Enter Your PhoneNo">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
					<button type="button" class="btn btn-primary" id="savechange">Save changes</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Forgot Model -->
	<div class="modal fade" id="forget">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Forgot Password</h5>
					<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h6 class="card-title">Enter Your Old Password</h6>
					<div class="form-group">
						<input type="password" class="form-control input-default" name="oldpass" id="oldpass" placeholder="Enter Old Password">
					</div>
					<h6 class="card-title">Enter New Password</h6>
					<div class="form-group">
						<input type="password" class="form-control input-default" name="newpass" id="newpass" placeholder="Enter New Password">
					</div>
					<h6 class="card-title">Repeat Your Password</h6>
					<div class="form-group">
						<input type="password" class="form-control input-default" name="repass" id="repass" placeholder="Repeat Your Password">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
					<button type="button" class="btn btn-primary" id="updatepassword">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="ftco-section contact-section bg-light">
	<div class="container">
		<h3 class="mb-4 billing-heading">Profile</h3>
		<div class="row">
			<div class="col-md-8 mb-5">
				<div class="card shadow">
					<div class="bg-white p-5 contact-form">
						<?php
						$sql = "SELECT * FROM users WHERE id = $user_id";
						$data = mysqli_query($con, $sql);
						$row = mysqli_fetch_assoc($data);
						echo '	<p><strong class="text-dark">Name:</strong><label class="col-lg-9">' . $row['name'] . '</label></p>
								<p><strong class="text-dark">Email:</strong><label class="col-lg-9">' . $row['email'] . '</label></p>
								<p><strong class="text-dark">Phone:</strong><label class="col-lg-9">' . $row['phoneno'] . '</label></p>';
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-5">
				<div class="card shadow">
					<div class="info bg-white p-4 text-center">
						<p><a href="/theshoesbox/pages/orders.php"><span>Your Orders</span></a></p>
						<div class="row">
							<div class="col-12">
								<hr class="my-3"> <!-- Vertical line -->
							</div>
						</div>
						<p><a href="#" data-toggle="modal" id="edit" data-target="#update" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-email="<?php echo $row['email'] ?>" data-phoneno="<?php echo $row['phoneno'] ?>"><span>Edit Your Profile</span></a></p>
						<div class="row">
							<div class="col-12">
								<hr class="my-3"> <!-- Vertical line -->
							</div>
						</div>
						<p><a href="#" data-toggle="modal" data-target="#forget"><span>Forgot Password</span></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
include '../includes/footer.php';
?>

<script>
	// Edit Profile Model
	$('#edit').on("click", function() {
		var id = $(this).data('id');
		var name = $(this).data('name');
		var email = $(this).data('email');
		var phoneno = $(this).data('phoneno');
		$('#editid').val(id);
		$('#editname').val(name);
		$('#editemail').val(email);
		$('#editphoneno').val(phoneno);
	});
	// Update Profile
	$("#savechange").on("click", function() {
		var id = $("#editid").val();
		var name = $("#editname").val();
		var email = $("#editemail").val();
		var phoneno = $("#editphoneno").val();
		$.ajax({
			type: "POST",
			url: "/theshoesbox/processes/profile-process.php",
			data: {
				action: "profileupdate",
				id: id,
				name: name,
				email: email,
				phoneno: phoneno,
			},
			success: function(res) {
				if (res == "Profile Update Successfully") {
					swal({
						title: "Success",
						text: res,
						type: "success"
					}, function() {
						window.location = '/theshoesbox/pages/profile.php';
					});
				} else {
					swal("Oops!!", res, "error");
				}
			}
		});
	});

	// Update Password
	$("#updatepassword").on("click", function() {
		var id = <?php echo $row['id']; ?>;
		var oldpass = $("#oldpass").val();
		var newpass = $("#newpass").val();
		var repass = $("#repass").val();
		$.ajax({
			type: "POST",
			url: "/theshoesbox/processes/profile-process.php",
			data: {
				action: "updatepassword",
				id: id,
				oldpass: oldpass,
				newpass: newpass,
				repass: repass,
			},
			success: function(res) {
				if (res == "Password Change Successfuly.") {
					swal({
						title: "Success",
						text: res,
						type: "success"
					}, function() {
						window.location = '/theshoesbox/pages/profile.php';
					});
				} else {
					swal("Oops!!", res, "error");
				}
			}
		});
	});
</script>