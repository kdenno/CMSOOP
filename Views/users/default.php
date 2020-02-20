<?php
ob_start();
require "includes/header.php";
require "includes/navigation.php"; ?>
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <h1 class="page-header">
        Page Heading
        <small>Secondary Text</small>
      </h1>

      <!-- Blog Posts -->
      <?php
      $all_posts = $this->queries->getAll('posts');
      if ($all_posts->count() > 0) {
        foreach ($all_posts->getResults() as $result) { ?>
          <h2>
            <a href="post.php?p_id=<?php echo $result->post_id; ?>"><?php echo $result->post_title; ?></a>
          </h2>
          <p class="lead">
            by <a href="index.php"><?php echo $result->post_author; ?></a>
          </p>
          <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $result->post_date; ?> at 10:00 PM</p>
          <hr>
          <img class="img-responsive" src="http://placehold.it/900x300" alt="">
          <hr>
          <p><?php echo substr($result->post_content, 0, 100); ?></p>
          <a class="btn btn-primary" href="post.php?p_id=<?php echo $result->post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
          <hr>


      <?php
        };
      } else {
        echo 'No Posts';
      }
      ?>


    </div>

    <!-- Blog Sidebar Widgets Column -->
    <?php  require "includes/sidebar.php"; 
    ?>

  </div>
  <!-- /.row -->

  <hr>
  <?php
  require "includes/footer.php";
  ?>