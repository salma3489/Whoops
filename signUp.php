<?php
session_start();
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

<style>
    .img{
        background-color: #e9ecef;
        color: black;
        border-radius: 0.5px;
    }
</style>

<div class="login-form">
    <form action="handlers/handle-signup.php" method="POST" enctype = "multipart/form-data">
        <h2 class="text-center">Registeration</h2>  
        <div class="form-group">
            Username <input name="username" type="text" class="form-control" placeholder="username" required="required">
        </div>     
        <div class="form-group">
            Email address <input type="text" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            Password <input name="password" type="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            Confirm Password <input name="confirmPass" type="password" class="form-control" placeholder="Confirm Password" required="required">
        </div>
        <div class="form-group">
            age <input name="age" type="text" class="form-control" placeholder="Age" required="required">
        </div>
        <div class="form-group">
            Gender:
            <input type="radio" name="gender" value="female">Female 
            <input type="radio" name="gender" value="male">Male 
            <input type="radio" name="gender" value="other">Other 
        </div>
        <div class="form-group">
            <label class="form-label font-weight-bold">Profile Picture</label>
            <input type = "file" name = "img">
        </div>
        <div class="form-group mt-5">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Create Account</button>
        </div>
               
    </form>
</div>


<?php
require_once "Inc/footer.php";

?>