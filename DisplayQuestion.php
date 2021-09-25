<?php
session_start();
require_once "Inc/dbConnection.php";
?>

<?php
if(isset($_GET['id']))
{
    $questID = $_GET['id'];
	$_SESSION['questID']=$questID;
	$Query="SELECT * from `questions` WHERE `Quest_id` = $questID";
	$runQuery=mysqli_query($conn, $Query);
	$Quest=mysqli_fetch_assoc($runQuery);

	$ansQuery="SELECT * from `ans` WHERE `Q_ID` = $questID";
	$runQuery=mysqli_query($conn, $ansQuery);
	$ans=mysqli_fetch_all($runQuery, MYSQLI_ASSOC);

	$ansQuery="SELECT count(`ID`) as total FROM `ans` WHERE `Q_ID`=$questID";
    $ansRunQuery = mysqli_query($conn, $ansQuery);
    $current_ans=mysqli_fetch_assoc($ansRunQuery);
}
?>

<?php
require_once "Inc/header.php";
?>

<nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="index.php"><img src="images/Screenshot 2021-09-13 014732.png" alt="Whoops!.com"> </a>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-lg-0 mr-5 ml-5">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  
                </ul>

              
                <form action="handlers/handle-search.php" method="GET">
	                  <input class="mx-5 w-100 " placeholder="Search for key word" type="text" name="query">
                </form>


                <?php
                if(!empty($_SESSION['userID'])){
                    $userID=$_SESSION['userID'];
                    $userquery = "SELECT * FROM `users` WHERE `id` = $userID";
                    $userRunQuery = mysqli_query($conn, $userquery);
                    if($current_user = mysqli_fetch_assoc($userRunQuery)){?>
                        <div class="userDetails ml-5">
                          <img class = "rounded-circle ml-5 w-25" src="images/<?= $current_user['img'] ?>">
                          <a href="profile.php" class="text-decoration-none text-white"><?= $current_user['Username'] ?></a>
                        </div>
              <?php }
                }?>
                

                <div class="sign-buttons ml-auto">
                <?php if(!isset($_SESSION['userID'])){?>
                <a class="btn btn-primary ml-5" href="Login.php">Login</a>
                <?php } ?>
                <?php if(!isset($_SESSION['userID'])){?>
                <a class="btn btn-primary" href="signUp.php">register</a>
                <?php } ?>

                    <?php if(isset($_SESSION['userID'])) {?>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                    <?php } ?>
                </div>
              </div>
            </div>
        </nav>

<div class="container mt-4">

    <h1><?php echo $Quest['Title'] ?></h1>
    <p small class="text-muted"><?php echo $Quest['created_at'] ?></p>
    <p><?php echo $Quest['QuestDetails'] ?></p>
	<p class="font-weight-bold mt-5">Answers (<?php echo $current_ans['total'] ?>)</p>
    <?php  foreach($ans as $Answer){
    
		$ansID=$Answer['ID'];
		$_SESSION['ID']=$ansID;

		$voteQuery="SELECT count(`vote_id`) as total FROM `votes` WHERE `ans_id`=$ansID AND `vote_up`=1";
    	$voteRunQuery = mysqli_query($conn, $voteQuery);
    	$current_vote = mysqli_fetch_assoc($voteRunQuery);?>
		<div class="row"><?php
			if(!empty($_SESSION['userID'])){?>
			<div class="col-md-1">
				<form action="handlers/handle-voteUp.php?ansID=<?php echo $ansID ?>" method="POST">
					<a href="handlers/handle-voteUp.php?ansID=<?php echo $ansID ?>" type="submit" name="submit"><img src="images/up.png"></a>
				</form>
				<p class="mt-1 ml-2 mb-0"><?php echo $current_vote['total'] ?></p>
				<form action="handlers/handle-voteDown.php?ansID=<?php echo $ansID ?>" method="POST">
					<a href="handlers/handle-voteDown.php?ansID=<?php echo $ansID ?>" type="submit" name="submit"><img src="images/down.png"></a>
				</form>
			</div>
			<?php } ?>
			<div class="col-md-11">
				<p class="mt-3"><?php echo $Answer['ansDetails'] ?></p>
			</div>
		</div>
		<p>__________________________________________________________________________________</p>
    <?php } 
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



    <?php
    if(!empty($_SESSION['userID'])){
        $userID=$_SESSION['userID'];?>
        <div class="ans-form mt-5">
            <form action="handlers/handle-addAns.php?id=<?php echo $Quest['Quest_id'] ?>" METHOD="POST">
                <label for="formGroupExampleInput" class="form-label font-weight-bold">Body </label>
			    
				        <textarea name="content" class="editor" cols="60" rows="5">Add Your Answer</textarea>
		        
                <div class="mt-5">
                    <button type="submit" name="submit" class="btn btn-primary">Add Answer</button>
                </div>
            </form>
        </div>
<?php }?>


    
</div>


<script src="build/ckeditor.js"></script>
		<script>ClassicEditor
				.create( document.querySelector( '.editor' ), {
					
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
						'link',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'imageUpload',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'undo',
						'redo',
						'codeBlock'
					]
				},
				language: 'en',
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:inline',
						'imageStyle:block',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
					licenseKey: '',
					
					
					
				} )
				.then( editor => {
					window.editor = editor;
			
					
					
					
				} )
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: p5v2i286s6o6-fwvgoahv95qv' );
					console.error( error );
				} );
		</script>


<?php

require_once "Inc/footer.php";

?>