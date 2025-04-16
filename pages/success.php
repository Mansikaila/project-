<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>

    <!-- ✅ SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 100px;
        }
    </style>
</head>
<body>

    <h2>Processing your order...</h2>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            Swal.fire({
                title: 'Success!',
                html: `
                    <div style="font-size: 18px; line-height: 1.6;">
                        Your payment was successful!<br>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Go to My Orders'
            }).then(() => {
                // ✅ Redirect after popup confirmation
                window.location.href = '/theshoesbox/pages/orders.php';
            });

            // OR: auto-redirect after few seconds
            // setTimeout(() => window.location.href = '/theshoesbox/pages/orders.php', 3000);
        }
    </script>

</body>
</html>
