<?php
require "Config/config.php";
require "includes/header.php";
require "includes/navigation.php";
?>
<!-- Page Content -->
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
      if (isset($_GET['p_id'])) {
        $post_id = $_GET['p_id'];
        $thepost = InitQueries()->queries->get('posts', array("post_id", "=", $post_id));
        if ($thepost->count() > 0) {
          foreach ($thepost->getResults() as $result) { ?>

            <h2>
              <a href="#"><?php echo $result->post_title; ?></a>
            </h2>
            <p class="lead">
              by <a href="index.php"><?php echo $result->post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $result->post_date; ?> at 10:00 PM</p>
            <hr>
            <img class="img-responsive" src="http://placehold.it/900x300" alt="">
            <hr>
            <p><?php echo $result->post_content; ?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>


      <?php
          }
        }
      }

      ?>
      <!-- Blog Comments -->
      <?php
      if (isset($_POST['create_comment'])) {
        if (InitQueries()->queries->Insert('comment', array(
          'comment_post_id' => $post_id,
          'comment_author' => $_POST['comment_author'],
          'comment_email' => $_POST['comment_email'],
          'comment_content' => $_POST['comment_content'],
          'comment_status' => 'unapproved',
          'comment_date' => date("Y-m-d H:i:s")
        ))) {
          InitQueries()->queries->IncreaseComments($post_id);
        };
      }
      ?>

      <!-- Comments Form -->
      <div class="well">
        <h4>Leave a Comment:</h4>
        <form action="" method="POST" role="form">
          <div class="form-group">
            <label for="author">Author</label>
            <input type="text" class="form-control" name="comment_author">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="comment_email">
          </div>
          <div class="form-group">
            <label for="comment">Comment</label>
            <textarea name="comment_content" class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <hr>

      <!-- Posted Comments -->
      <?php
      $thecomments = InitQueries()->queries->otherQueries($post_id);
      if ($thecomments->count() > 0) {
        foreach ($thecomments->getResults() as $results) { ?>
          <div class="media">
            <a class="pull-left" href="#">
              <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>
            <div class="media-body">
              <h4 class="media-heading"><?php echo $results->comment_author; ?>
                <small><?php echo $results->comment_date; ?></small>
              </h4>
              <?php echo $results->comment_content; ?>
            </div>
          </div>

      <?php
        }
      } else {
        echo 'No Comments Yet';
      }

      ?>


    </div>

    <!-- Blog Sidebar Widgets Column -->
    <?php include "includes/sidebar.php"; ?>

  </div>
  <!-- /.row -->

  <hr>

  <?php
  include "includes/footer.php"
  ?>