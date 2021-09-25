
<?php
session_start();
require_once "Inc/dbConnection.php";
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

<?php

    $id=$_GET['id'];
    $userquery = "SELECT * FROM `questions` WHERE `Quest_id` = $id";
    $userRunQuery = mysqli_query($conn, $userquery);
    if($current_quest = mysqli_fetch_assoc($userRunQuery)){
      
    }
?>

<div class="editquestion mt-5">
    <?php if(isset($_SESSION['errors'])){?>
            <div class="alert alert-danger w-25 m-5 ">
                <strong>
                <?php foreach($_SESSION['errors'] as $error) { ?>
                        <p><?php echo $error ?></p>
                <?php } unset($_SESSION['errors']) ?>
                </strong>
            </div>
<?php } ?>
    <form class="m-5" action="handlers/handle-editQuestion.php?id=<?= $current_quest['Quest_id'] ?>" METHOD="POST">
        <h1>Edit Question</h1>
        <div class="mb-3 mt-4">
            <label for="formGroupExampleInput" class="form-label">Title</label>
            <input name="Title" type="text" value="<?= $current_quest['Title'] ?>" class="form-control w-50" placeholder="e.g. Is there an R function for finding the index ofan elemnt in vector">
        </div>

        <label for="formGroupExampleInput" class="form-label">Body</label>
        <div class="mb-1">
            <textarea name="content" class="editor" cols="60" rows="5"><?= $current_quest['QuestDetails'] ?></textarea>
        </div>
        <div class="mt-5">
            <button type="submit" name="submit" class="btn btn-primary">Edit Question</button>
        </div>
    </form>
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