<?php
include '../includes/header.php';
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='/theshoesbox/pages/login.php';</script>";
}
?>
<?php
$user_id = $_SESSION['user_id'];
?>

<div class="hero-wrap hero-bread" style="background-image: url('/theshoesbox/assets/images/bg_6.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/theshoesbox/index.php">Home</a></span> <span>Cart</span></p>
                <h1 class="mb-0 bread">My Wishlist</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT product.id, product.name, product.price, product.pro_img
                                    FROM product
                                    INNER JOIN cart ON product.id = cart.product_id
                                    WHERE cart.user_id = $user_id";

                            $result = $con->query($sql);
                            $lastProductId = null;

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $lastProductId = $row['id']; // Save the last product ID
                                    echo '<tr class="text-center">';
                                   echo '    <td class="product-remove"><a href="#" class="delete-product" data-productId="' . $row['id'] . '" data-userId="' . $user_id . '"><span class="ion-ios-close"></span></a></td>';
                                    echo '    <td class="image-prod">';
                                    echo '        <a href="/theshoesbox/pages/product-single.php?pro_id=' . $row['id'] . '"><div class="img" style="background-image:url(/theshoesbox/admin/assets/images/product/' . $row['pro_img'] . ');"></div></a>';
                                    echo '    </td>';
                                    echo '    <td class="product-name">';
                                    echo '        <a href="/theshoesbox/pages/product-single.php?pro_id=' . $row['id'] . '"><h3>' . $row['name'] . '</h3></a>';
                                    echo '    </td>';
                                    echo '    <td class="price">₹ ' . $row['price'] . '</td>';
                                    echo '    <td class="quantity">';
                                    echo '        <div class="input-group mb-3">';
                                    echo '            <button class="quantity-minus px-3" type="button">-</button>';
                                    echo '            <input type="text" name="quantity" class="quantity form-control input-number" value="1" min="1" max="100">';
                                    echo '            <button class="quantity-plus px-3" type="button">+</button>';
                                    echo '        </div>';
                                    echo '    </td>';
                                    echo '    <td class="total">₹ ' . ($row['price'] * 1) . '</td>';
                                    echo '    <td><a href="/theshoesbox/pages/address-details.php?pro_id=' . $row['id'] . '" class="btn btn-primary py-2 px-3" id="purchase">Purchase</a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7">No items in the cart.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-start">
            <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3>Cart Totals</h3>
                    <hr>
                    <p class="d-flex total-price">
                        <span>Total</span>
                        <span id="cart-total">$0.00</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include '../includes/footer.php';
?>
<script>
    function updateCartTotal() {
        var total = 0;
        $('.cart-list tbody tr').each(function() {
            var price = parseFloat($(this).find('.price').text().replace('₹', '').trim());
            var quantity = parseInt($(this).find('.quantity input').val());
            var productTotal = price * quantity;
            total += productTotal;

            $(this).find('.total').text('₹ ' + productTotal.toFixed(2));
        });
        $('#cart-total').text('₹ ' + total.toFixed(2));
    }

    $('.quantity-minus').click(function() {
        var input = $(this).closest('.input-group').find('.quantity');
        var value = parseInt(input.val(), 10);

        if (value > 1) {
            input.val(value - 1);
            updateCartTotal();
        }
    });
    $('.quantity-plus').click(function() {
        var input = $(this).closest('.input-group').find('.quantity');
        var value = parseInt(input.val(), 10);

        if (value < 100) {
            input.val(value + 1);
            updateCartTotal();
        }
    });
    updateCartTotal();


    // Delete Cart
$(document).on("click", ".delete-product", function(e) {
    e.preventDefault(); // Prevent default anchor behavior
    var productId = $(this).data('productid');
    var userId = $(this).data('userid');

    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this product!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    },
    function() {
        $.ajax({
            type: "POST",
            url: "/theshoesbox/processes/cart-process.php",
            data: {
                action: "delete",
                productId: productId,
                userId: userId,
            },
            success: function(res) {
                if (res == "Product Delete Successfully") {
                    swal({
                        title: "Success",
                        text: res,
                        type: "success"
                    }, function() {
                        window.location = '/theshoesbox/pages/cart.php';
                    });
                } else {
                    swal("Oops!!", res, "error");
                }
            }
        });
    });
});

</script>
