<!-- side area start -->
<div class="col-sm-4">
  <div class="card mt-4">
    <div class="card-body bg-primary-subtle border border-primary-subtle rounded-3">
      <img src="images/lesawi2ads.jpg" class="img-fluid mb-3" alt="Bloging image">
      <div class="text-center">
        <p>Section 1.10.33 of "de Finibus Bonorum et Malorum", written by Cicero in 45 BC "At vero eos et
          accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque
          corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique
          sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga."
        </p>
      </div>
    </div>
    <div class="card bg-primary-subtle border border-primary-subtle rounded-3  m-1">
      <div class="card-header bg-dark text-light m-1">
        <h2 class="lead text-center">Log In or Subscribe</h2>
      </div>
      <div class="card-body m-1">
        <div class="form-group">
          <a href="Contact.php">
            <button class="form-control btn btn-success text-center text-white mb-2" type="button">
              Contact Us
            </button>
          </a>
          <a class="text-white" href="Login.php">
            <button class="form-control btn btn-danger text-center text-white mb-2" type="button">
              Log In
            </button>
        </div>
        </a>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
          <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">
            Subscribe Now
          </button>
        </div>
      </div>
    </div>
    <br>
    <div>
      <div class="card bg-primary-subtle border border-primary-subtle rounded-3 ">
        <div class="card-header bg-primary text-light">
          <h2 class="lead">Categories</h2>
        </div>
        <div class="card-body">
          <?php
          $ConnetingDB;
          $sql = "SELECT * FROM category ORDER BY id desc";
          $stmt = $ConnectingDB->query($sql);
          while ($DataRows = $stmt->fetch()) {
            $CategoryId = $DataRows["id"];
            $CategoryName = $DataRows["title"];
            ?>
            <a href="Blog.php?category=<?php echo $CategoryName; ?>">
              <span class="heading">
                <?php echo htmlentities($CategoryName) ?>
              </span>
            </a>
            <br>
          <?php } ?>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-header bg-info text-white">
        <h2 class="lead">Recent Posts</h2>
      </div>
    </div>
    <div class="card-body">
      <?php
      $ConnectingDB;
      $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
      $stmt = $ConnectingDB->query($sql);
      while ($DataRows = $stmt->fetch()) {
        $Id = $DataRows["id"];
        $Title = $DataRows["title"];
        $Author = $DataRows["author"];
        $DateTime = $DataRows["datetime"];
        $Image = $DataRows["image"];
        ?>
        <div class="media bg-primary-subtle">
          <div class="text-center">
            <img src="uploads/<?php echo $Image; ?>" class="img-thumbnail img-fluid mt-2" width="120" height="124" alt="
                <?php echo $Title; ?>
                ">
            <div class="media-body ml-2">
              <a class="text-right" href="FullPost.php?id=<?php echo $Id; ?>" target="_blank">
                <h6 class="lead">
                  <?php echo htmlentities($Title); ?>
                </h6>
              </a>
              <p>
                Written by:
                <?php echo htmlentities($Author) ?>
                <br>
                On:
                <?php echo htmlentities($DateTime) ?>
              </p>
            </div>
          </div>
          <hr>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<!-- side area end  -->

</div>
</div>
<!-- header end  -->
<br>

<!-- footer start -->
<div style="height: 10px; background: #27aae1;"></div>
<footer class="bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="lead text-center">Product of Lesawi Services | Cell: 061 525 0362 | <span id="year"></span> &copy;
          All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>
<!-- footer end -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
  integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
  </script>
<script>
  document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
</body>

</html>