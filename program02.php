<!DOCTYPE HTML>
<html>
<head>
   <meta name="author" content="David Hughen" />
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
   <link href="style02.css" rel="stylesheet" type="text/css" />
   <title>Survey</title>
   <!-- This is a comment -->
</head>
	<body id="php_body">
	<img src="food!.jpg" id="food_pic" alt="">

<?php
// Author: David Hughen
// Date:   February 13, 2015
// Course: CS 368 - Advanced Web Programming
// This php program records surveys from users
// about their dining experience.

// Defined constants
define('STEAK', 1);
define('BURGER', 2);
define('PORK', 3);
define('PIZZA', 4);
define('SALMON', 5);

?>
	<?php
		// Total number of customers served
		$totalCounter = 0;
		
		// Total of all service ratings
		$serviceTotal = 0;
		
		// Total number of orders for each food type
		$steakTotal = 0;
		$burgerTotal = 0;
		$porkTotal = 0;
		$pizzaTotal = 0;
		$salmonTotal = 0;
		
		// Total rating for each food type;
		$steakRating = 0;
		$burgerRating = 0;
		$porkRating = 0;
		$pizzaRating = 0;
		$salmonRating = 0;
		
		$user = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		$currentDate = date("Y/m/d/H/i/s");
		
		$mType = $_POST['ddl_meal'];
		$mRating = $_POST['ddl_rate_meal'];
		$sRating = $_POST['ddl_rate_service'];
		
		
		// Open the file for writing
		$surveyOutput = fopen("surveyFile.txt", "a");
		
		// Lock the file for writing
		flock($surveyOutput, LOCK_EX);
		
		// File could not be found so exit
		if(!$surveyOutput)
		{
			echo "<h1>File could not be found. Program is exiting</h1>";
			exit;
		}
			
		// Write a record to the survey
		fwrite($surveyOutput, "\n" . $user . " " . $currentDate . " " . $mType . " " . $mRating . " " . $sRating);	
		
	
		// Unlock the file for further use
		flock($surveyOutput, LOCK_UN);
		
		// Close the file
		fclose($surveyOutput);
		

		// Open the file for reading
		$surveyInput = fopen("surveyFile.txt", "r");
		
		// Lock the file for reading
		flock($surveyInput, LOCK_SH);
		
		// File could not be found so exit
		if(!$surveyInput)
		{
			echo "<h1>File could not be found. Program is exiting</h1>";
			exit;
		}
		
		// Get rid of the first line in the file
		$firstLine = fgets($surveyInput, 999);
		
		// Process the records
		while(!feof($surveyInput))
		{
			$result = fgetcsv($surveyInput, 999, ' ');
			
			
			$meal          = $result[2];
			$mealRating    = $result[3];
			$serviceRating = $result[4];
			
			$totalCounter += 1;
			
			$serviceTotal += $serviceRating;
			
			switch($meal)
			{
				case STEAK:
					$steakTotal++;
					$steakRating += $mealRating;
					break;
				case BURGER:
					$burgerTotal++;
					$burgerTotal += $mealRating;
					break;
				case PORK:
					$porkTotal++;
					$porkRating += $mealRating;
					break;
				case PIZZA:
					$pizzaTotal++;
					$pizzaRating += $mealRating;
					break;
				case SALMON;
					$salmonTotal++;
					$salmonRating += $mealRating;
					break;
			}
		} 
		
		// Unlock the file for further use
		flock($surveyInput, LOCK_UN);
		
		// Close the file
		fclose($surveyInput);	
	?>
		<h1 id="titleHeader">Survey Review:</h1>
	
	<div id="tableDiv">
		<table id="payTable" class="payTable" border="1">
			<tr>
				<td><h1><?php echo "Total Surveys: " . $totalCounter; ?></h1></td> 
			</tr>
			<tr>
				<td><h1><?php echo "Average service Rating: " . number_format($serviceTotal / $totalCounter, 2, '.', ','); ?></h1></td> 
			</tr>
			<tr>
				<td id="steakRow"><h1><?php echo "Average ratings for each food group: "; ?></h1>
						<h2><?php 	@$steakAverage = ($steakRating / $steakTotal);
		
									// Divide by 0 error
									if($steakAverage === false)
										$steakAverage = 0;
									echo "Steak: " . number_format($steakAverage, 2, '.', ','); ?></h2>
									
						<h2><?php   @$burgerAverage = ($burgerRating / $burgerTotal);
						
									// Divide by 0 error
									if($burgerAverage === false)
										$burgerAverage = 0;
									echo "Burger: " . number_format($burgerAverage, 2, '.', ','); ?></h2>
									
						<h2><?php   @$porkAverage = ($porkRating / $porkTotal);
						
									// Divide by 0 error
									if($porkAverage === false)
										$porkAverage = 0;
									echo "Pork: " . number_format($porkAverage, 2, '.', ','); ?></h2>
									
						<h2><?php   @$pizzaAverage = ($pizzaRating / $pizzaTotal);
						
									// Divide by 0 error
									if($pizzaAverage === false)
										$pizzaAverage = 0;
									echo "Pizza: " . number_format($pizzaAverage, 2, '.', ','); ?></h2>
						
						<h2><?php   @$salmonAverage = ($salmonRating / $salmonTotal);
						
									// Divide by 0 error
									if($salmonAverage === false)
										$salmonAverage = 0;
									echo "Salmon: " . number_format($salmonAverage, 2, '.', ','); ?></h2>
				</td> 
			</tr>
		
		</table>
	</div>
	</body>
</html>