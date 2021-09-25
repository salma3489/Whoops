
<?php
session_start();
require_once "Inc/dbConnection.php";
?>

<?php
require_once "Inc/header.php";
?>



<?php if(isset($_SESSION['errors'])){?>
<div class="alert alert-danger w-25 m-5 ">
    <strong>
    <?php foreach($_SESSION['errors'] as $error) { ?>
        <p><?php echo $error ?></p>
    <?php } unset($_SESSION['errors']) ?>
    </strong>
</div>
<?php } ?>
    <div class="login-form">
        
        <form action="handlers/handle-changepass.php" method="POST" enctype = "multipart/form-data">
            <h4 class="mb-3">change Password</h4>  
            <div class="form-group">
                Password <input name="password" type="password" class="form-control" required="required">
            </div>
            <div class="form-group">
            New Password <input name="NewPass" type="password" class="form-control" required="required">
            </div>
            <div class="form-group">
                Confirm New Password <input name="confirmNewPass" type="password" class="form-control" required="required">
            </div>
            <div class="form-group mt-5">
                <button type="submit" name="submit" class="btn btn-primary">Save Password</button>
            </div>
        </form>
    </div>
    


<?php
require_once "Inc/footer.php";
?>