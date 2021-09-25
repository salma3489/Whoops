<?php
session_start();
require_once "Inc/header.php";
?>

<?php if(isset($_SESSION['errors'])){?>
<div class="alert alert-danger w-25 m-5">
    <strong>
        <p><?php echo $_SESSION['errors'] ?></p>
    <?php  unset($_SESSION['errors']) ?>
</strong>
</div>
<?php } ?>

<div class="login-form">
    <form action="handlers/handle-login.php" method="post">
        <h2 class="text-center">Log in</h2>       
        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Log in</button>
        </div>
               
    </form>
</div>


<?php
require_once "Inc/footer.php";

?>