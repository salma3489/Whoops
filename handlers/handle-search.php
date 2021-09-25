<?php
  require_once "../Inc/dbConnection.php";
?>

<?php
require_once "../Inc/header.php";
?>

<?php
	$query = $_GET['query']; 
	
	$min_length = 2;
	
	if(strlen($query) >= $min_length){
		
		$query = htmlspecialchars($query); 
		
		$query = $conn -> real_escape_string($query);
		
		$raw_results = mysqli_query($conn, "SELECT * FROM `questions` WHERE (`Title` LIKE '%".$query."%')");
			
			
		if(mysqli_num_rows($raw_results) > 0){ 
			
			while($results = mysqli_fetch_array($raw_results)){?>
				<div class="container mt-5">
					<?php
					echo "<p><h3>".$results['Title']."</h3>".$results['QuestDetails']."</p>";
					$QuestID=$results['Quest_id'];
					$raw_ans_results = mysqli_query($conn, "SELECT * FROM `ans` WHERE `Q_ID`=$QuestID");
    				$answers=mysqli_fetch_all($raw_ans_results, MYSQLI_ASSOC);
					foreach($answers as $answer){ 
						echo "<p>".$answer['ansDetails']."</p>";
					}?>
				</div><?php
			}
			
		}
		else{
			echo "No results";
		}
		
	}
	else{
		echo "Minimum length is ".$min_length;
	}
?>



<?php
require_once "../Inc/footer.php";
?>