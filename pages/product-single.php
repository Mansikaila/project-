<?php
include '../includes/header.php';
include '../includes/connection.php';
?>
<?php

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle the case when the user is not logged in
    echo "User is not logged in!";
    exit;  // Exit the script if user is not logged in
}
?>
 
<!-- Product Details Section -->
<div class="hero-wrap hero-bread" style="background-image: url('/theshoesbox/assets/images/bg_6.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Shop</span></p>
                <h1 class="mb-0 bread">Shop</h1>
            </div>
        </div>
    </div>
</div>

<?php
$pro_id = $_GET['pro_id'];
$sql = "SELECT brand.name as bname, product.id, product.name, product.price, product.pro_img, product.pro_details 
        FROM brand, product 
        WHERE brand.id=product.brand_id AND product.id='$pro_id'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
?>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="/theshoesbox/assets/images/product-1.png" class="image-popup prod-img-bg"><img src="/theshoesbox/admin/assets/images/product/<?php echo $row['pro_img'] ?> " class="img-fluid"></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3><?php echo $row['name'] ?></h3>
                <p class="text-left mr-4">
                    <a href="#" class="mr-2" style="color: #000;">Brand: <?php echo $row['bname'] ?></a>
                </p>

                <!-- Rating Section -->
                <div class="rating d-flex">
                    <p class="text-left mr-4">
                        <a href="#" class="mr-2" style="color: #000;">Rating: </a>
                        <?php 
                        $product_id = $row['id'];
                        $avg_rating = 0; // Default value

                        // Fetch the average rating from the database
                        $rating_sql = "SELECT ROUND(AVG(rating), 1) AS avg_rating FROM ratings WHERE product_id = '$product_id'";
                        $rating_result = $con->query($rating_sql);
                        if ($rating_result->num_rows > 0) {
                            $rating_row = $rating_result->fetch_assoc();
                            $avg_rating = $rating_row['avg_rating'];
                        }

                        // Display filled or unfilled stars based on average rating
                        for ($i = 1; $i <= 5; $i++) {
                            $star_class = ($i <= $avg_rating) ? 'ion-ios-star' : 'ion-ios-star-outline';
                            echo '<a href="javascript:void(0)" class="rating-star" data-rating="' . $i . '" data-productid="' . $product_id . '"><span class="' . $star_class . '"></span></a>';
                        }
                        ?>
                    </p>
                </div>

                <p class="price"><span><?php echo $row['price'] ?></span></p>
                <p><?php echo $row['pro_details'] ?></p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <div class="select-wrap">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="" id="" class="form-control">
                                    <option value="">Small</option>
                                    <option value="">Medium</option>
                                    <option value="">Large</option>
                                    <option value="">Extra Large</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <p>
                   <a href="#" class="btn btn-black py-3 px-5 mr-2 add-to-cart" data-productId="<?php echo $row['id'] ?>" data-userId="<?php echo $user_id ?>">Add to Cart</a>
                    <a href="/theshoesbox/pages/address-details.php?pro_id=<?php echo $pro_id;?>" class="btn btn-primary py-3 px-5">Buy now</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
include '../includes/footer.php';
?>


<script>
    // Add Cart
	$(".add-to-cart").on("click", function() {
		var productId = $(this).data('productid');
		var userId = $(this).data('userid');
		$.ajax({
			type: "POST",
			url: "/theshoesbox/processes/cart-process.php",
			data: {
				action: "insert",
				productId: productId,
				userId: userId,
			},
			success: function(res) {
				if (res == "Product Added Successfully") {
					swal({
						title: "Success",
						text: res,
						type: "success"
					}, function() {
						window.location = '/theshoesbox/pages/cart.php';
					});
				} else if (res == "Product already In Cart. Please choose a different Product.") {
					swal("Oops!!", res, "error");
				} else {
					swal("Oops!!", res, "error");
				}
			}
		});
	});
// Handle Star Click for Ratings<script>
    // Handle Star Click for Ratings
    $(document).on('click', '.rating-star', function () {
        var productId = $(this).data('productid');
        var rating = $(this).data('rating');
        var userId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;

        // Check if the user is logged in
        if (!userId) {
            swal({
                title: "Oops!",
                text: "You need to log in to rate a product.",
                icon: "error"
            });
            return;
        }

        // Submit the rating via AJAX
        $.ajax({
            type: "POST",
            url: "/theshoesbox/processes/rating-process.php",
            data: {
                product_id: productId,
                rating: rating,
                user_id: userId
            },
            success: function (response) {
                try {
                    // Parse the response to handle JSON (if applicable)
                    var res = JSON.parse(response);

                    if (res.status === "success") {
                        swal({
                            title: "Thank You!",
                            text: "Your rating has been recorded.",
                            icon: "success"
                        });

                        // Update stars dynamically
                        updateStars(productId, rating);
                    } else if (res.status === "error") {
                        swal("Oops!", res.message, "error");
                    } else {
                        swal("Oops!", "Unexpected response from server.", "error");
                    }
                } catch (e) {
                    // Fallback for non-JSON responses
                    if (response.trim() === "Rating submitted successfully.") {
                        swal({
                            title: "Thank You!",
                            text: "Your rating has been recorded.",
                            icon: "success"
                        });

                        updateStars(productId, rating);
                    } else {
                        swal("Oops!", response, "error");
                    }
                }
            },
            error: function () {
                swal("Error!", "Unable to submit rating. Please try again.", "error");
            }
        });
    });

    // Update the star icons dynamically after rating submission
    function updateStars(productId, rating) {
        $('.rating-star[data-productid="' + productId + '"]').each(function (index) {
            var star = $(this).find('span');
            if (index < rating) {
                star.removeClass('ion-ios-star-outline').addClass('ion-ios-star');
            } else {
                star.removeClass('ion-ios-star').addClass('ion-ios-star-outline');
            }
        });
    }



// Update the star icons dynamically after rating submission
function updateStars(productId, rating) {
    var stars = $('.rating-star[data-productid="' + productId + '"]');
    stars.each(function(index) {
        if (index < rating) {
            $(this).find('span').removeClass('ion-ios-star-outline').addClass('ion-ios-star');
        } else {
            $(this).find('span').removeClass('ion-ios-star').addClass('ion-ios-star-outline');
        }
    });
}
    
</script>
