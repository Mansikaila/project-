<?php
include '../includes/header.php';
?>
<div class="hero-wrap hero-bread" style="background-image: url('/theshoesbox/assets/images/bg_6.jpg');">
  <div class="container">
    <div class="row no-gutters slider-text align-items-center justify-content-center">
      <div class="col-md-9 ftco-animate text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="/theshoesbox/index.php">Home</a></span><span> Contact</span></p>
        <h1 class="mb-0 bread">Contact Us</h1>
      </div>
    </div>
  </div>
</div>

<section class="ftco-section contact-section bg-light">
  <div class="container">
    <div class="row d-flex mb-5 contact-info">
      <div class="w-100"></div>
      <div class="col-md-3 d-flex">
        <div class="info bg-white p-4">
          <p><span>Address:</span> Nakshatra -5 , Sadhu vasvani Road , Rajkot,Gujarat 361004</p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="info bg-white p-4">
          <p><span>Phone:</span> <a href="tel://1234567920">+91 8128844154</a></p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="info bg-white p-4">
          <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@Walkway.com</a></p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="info bg-white p-4">
          <p><span>Website</span> <a href="/theshoesbox/index.php">theshoesbox.com</a></p>
        </div>
      </div>
    </div>
    <div class="row block-9">
      <div class="col-md-7 order-md-last d-flex">
        <div class="bg-white p-5 contact-form">
          <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name">
          </div>
          <div class="form-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="Your Email">
          </div>
          <div class="form-group">
            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
          </div>
          <div class="form-group">
            <textarea name="message" id="message" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
          </div>

          <div class="my-3" id="errorDiv"></div>

          <div class="form-group">
            <input type="submit" name="sendmessage" id="sendmessage" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include '../includes/footer.php';
?>

<!-- ajax -->
<script>
  $("#document").ready(function() {
    $("#sendmessage").on("click", function() {
      var name = $("#name").val()
      var email = $("#email").val()
      var subject = $("#subject").val()
      var message = $("#message").val()
      $.ajax({
        type: "POST",
        url: "/theshoesbox/processes/contact-process.php",
        data: {
          name: name,
          email: email,
          subject: subject,
          message: message,
        },
        success: function(res) {
          if (res == "Success") window.location.href = "/theshoesbox/pages/contact.php"
          else $("#errorDiv").html(`
            <div class="alert alert-danger" role="alert">
              ${res}
            </div>
          `)
        }
      });
    });
  });
</script>