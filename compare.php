
<head>
      <meta charset = "UTF-8">
      <title>Cereal Snacker</title>
      <link href = "./final.css" rel = "stylesheet">
</head>


<body>


 <ul class = navbar>
      <div class="topnav">
      	<a   class = "op" href="./index.html">Home</a>
        <a   class = "op" href="./sort.php?options=NULL">Sort Cereal</a>
        <a  class = "op" href="./compare.php">Compare Cereal</a>
      </div>
  </ul>

<div id = "page2">
<p class = "instruct pg2"> Select Two Cereals to Compare!</p>

<?php

error_reporting(0);
ini_set('display_errors', 0);

date_default_timezone_set('UTC');
 
  try {
    $file_db = new PDO('sqlite:cereal.sqlite3');
    $file_db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
    $memory_db = new PDO('sqlite::memory:');
    $memory_db->setAttribute(PDO::ATTR_ERRMODE, 
                              PDO::ERRMODE_EXCEPTION);

    $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
                    name TEXT, 
                    calories INTEGER,
                    protein INTEGER,
                    fat INTEGER,
                    sugars INTEGER,
                    carbo INTEGER,
                	rating NUMERIC)");
 
    $memory_db->exec("CREATE TABLE messages (
                      name TEXT, 
                      calories INTEGER,
                      protein INTEGER,
                      fat INTEGER,
                      sugars INTEGER,
                      carbo INTEGER,
                  	  rating NUMERIC)");
   
             
    $messages = array(
                  array('name' => 'Hello!',
                        'calories' => 13,
                        'protein' => 13),
                  array('name' => 'Hello again!',
                        'calories' => 133,
                        'protein' => 13),
                  array('name' => 'Hi!',
                        'calories' => 133,
                        'protein' => 13)
                );
 
    $insert = "INSERT INTO messages (name, calories, protein, fat, sugars, carbo, rating) 
                VALUES (:name, :calories, :protein, :fat, :sugars, :carbo, :rating)";
    $stmt = $file_db->prepare($insert);
 
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':calories', $calories);
    $stmt->bindParam(':protein', $protein);
    $stmt->bindParam(':fat', $fat);
    $stmt->bindParam(':sugars', $sugars);
    $stmt->bindParam(':carbo', $carbo);
    $stmt->bindParam(':rating', $rating);

    foreach ($messages as $m) {
      // Set values to bound variables
      $name = $m['name'];
      $calories = $m['calories'];
      $protein = $m['protein'];
      $fat = $m['fat'];
      $sugars = $m['sugars'];
      $carbo = $m['carbo'];
 	  $rating = $m['rating'];
      // Execute statement
      $stmt->execute(); 
    }
 
    // Prepare INSERT statement to SQLite3 memory db
    $insert = "INSERT INTO messages (name, calories, protein, fat, sugars, carbo, rating) 
                VALUES (:name, :calories, :protein, :fat, :sugars, :carbo, :rating)";
    $stmt = $memory_db->prepare($insert);
 
    // Select all data from file db messages table 
    $pick1 = $_GET['pick1'];
    $pick2 = $_GET['pick2'];
    $allNames = $file_db->query("SELECT name, rating FROM cereal");
    $allNames2 = $file_db->query("SELECT name, rating FROM cereal");
    $optionOne = $file_db->query("SELECT * FROM cereal WHERE rating = '{$pick1}'");
    $optionTwo = $file_db->query("SELECT * FROM cereal WHERE rating = '{$pick2}'");
 
 //------------------------------------------------------------------------------------
echo "		<form class = doubleSearch>
   				<select class = 'sone' name = 'pick1'>
   					<option value = 'nott'> Enter Option </option>";

foreach ($allNames as $p1) {
echo "				<option value = {$p1['rating']}> {$p1['name']} </option>";

}
      
echo "
 				</select>";
//-------------------------------------------------------------------------------------

echo "
   				<select class = 'stwo' name = 'pick2'>
   					<option value = 'nott'> Enter Option </option>";

foreach ($allNames2 as $p2) {
echo "				<option value = {$p2['rating']}> {$p2['name']} </option>";

}
      
echo "
 				</select>
  				<input class = 'subbut' type = 'submit'>
			</form>";

//-------------------------------------------------------------------------------------

echo "<div class = 'cerbar pg2'>

</div>";

echo "<div class = 'allblue tbl'>";

    foreach ($optionOne as $o) {
      echo "<p class = 'oneside headers'> {$o['name']} </p>";
    }

    foreach ($optionTwo as $t) {
      echo "<p class = 'twoside headers'> {$t['name']} </p>";
    }

    echo "<div class = midsection>
    		<p class = 'smh'>Calories</p>
    		<p class = 'smh'>Protein</p>
    		<p class = 'smh'>Fat</p>
    		<p class = 'smh'>Sugars</p>
    		<p class = 'smh'>Carbs</p>
    	   </div>";

//----------------------------------------------------------------------------------
    echo "<div class = 'ansone'>";

    $countero = 0;

    if($o['calories'] == $t['calories'])
    {
    	echo "<p class = 'yellow res'> {$o['calories']} </p>";
    }
    else if($o['calories'] < $t['calories'])
    {
    	echo "<p class = 'green res'> {$o['calories']} </p>";
    	$countero++;
    }
    else{
    	echo "<p class = 'red res'> {$o['calories']} </p>";
    }


    if($o['protein'] == $t['protein'])
    {
    	echo "<p class = 'yellow res'> {$o['protein']} </p>";
    }
    else if($o['protein'] < $t['protein'])
    {
    	echo "<p class = 'green res'> {$o['protein']} </p>";
    	$countero++;
    }
    else{
    	echo "<p class = 'red res'> {$o['protein']} </p>";
    }


    if($o['fat'] == $t['fat'])
    {
    	echo "<p class = 'yellow res'> {$o['fat']} </p>";
    }
    else if($o['fat'] < $t['fat'])
    {
    	echo "<p class = 'green res'> {$o['fat']} </p>";
    	$countero++;
    }
    else{
    	echo "<p class = 'red res'> {$o['fat']} </p>";
    }


     if($o['sugars'] == $t['sugars'])
    {
    	echo "<p class = 'yellow res'> {$o['sugars']} </p>";
    }
    else if($o['sugars'] < $t['sugars'])
    {
    	echo "<p class = 'green res'> {$o['sugars']} </p>";
    	$countero++;
    }
    else{
    	echo "<p class = 'red res'> {$o['sugars']} </p>";
    }


    if($o['carbo'] == $t['carbo'])
    {
    	echo "<p class = 'yellow res'> {$o['carbo']} </p>";
    }
    else if($o['carbo'] < $t['carbo'])
    {
    	echo "<p class = 'green res'> {$o['carbo']} </p>";
    	$countero++;
    }
    else{
    	echo "<p class = 'red res'> {$o['carbo']} </p>";
    }

    echo "</div>";

//----------------------------------------------------------------------------------


//----------------------------------------------------------------------------------
    echo "<div class = anstwo>";

    $countert = 0;

    if($o['calories'] == $t['calories'])
    {
    	echo "<p class = 'yellow res'> {$t['calories']} </p>";
    }
    else if($o['calories'] < $t['calories'])
    {
    	echo "<p class = 'red res'> {$t['calories']} </p>";
    }
    else{
    	echo "<p class = 'green res'> {$t['calories']} </p>";
    	$countert++;
    }


    if($o['protein'] == $t['protein'])
    {
    	echo "<p class = 'yellow res'> {$t['protein']} </p>";
    }
    else if($o['protein'] < $t['protein'])
    {
    	echo "<p class = 'red res'> {$t['protein']} </p>";
    	
    }
    else{
    	echo "<p class = 'green res'> {$t['protein']} </p>";
    	$countert++;
    }


    if($o['fat'] == $t['fat'])
    {
    	echo "<p class = 'yellow res'> {$t['fat']} </p>";
    }
    else if($o['fat'] < $t['fat'])
    {
    	echo "<p class = 'red res'> {$t['fat']} </p>";
 
    }
    else{
    	echo "<p class = 'green res'> {$t['fat']} </p>";
    	$countert++;
    }


     if($o['sugars'] == $t['sugars'])
    {
    	echo "<p class = 'yellow res'> {$t['sugars']} </p>";
    }
    else if($o['sugars'] < $t['sugars'])
    {
    	echo "<p class = 'red res'> {$t['sugars']} </p>";
    	
    }
    else{
    	echo "<p class = 'green res'> {$t['sugars']} </p>";
    	$countert++;
    }


    if($o['carbo'] == $t['carbo'])
    {
    	echo "<p class = 'yellow res'> {$t['carbo']} </p>";
    }
    else if($o['carbo'] < $t['carbo'])
    {
    	echo "<p class = 'red res'> {$t['carbo']} </p>";
    	
    }
    else{
    	echo "<p class = 'green res'> {$t['carbo']} </p>";
    	$countert++;
    }

    echo "</div>";
echo "</div>";
//----------------------------------------------------------------------------------


//----------------------------------------------------------------------------------
    echo "<div class = compres>";

    if($countero == $countert)
    {
    	echo "<p class = 'fin res'> It is a TIE! Both cereals won the same number of categories.</p>";
    }
    else if($countero < $countert)
    {
    	echo "<p class = 'fin res'> {$t['name']} Wins! It won {$countert} matchups.</p>";
    }
    else{
    	echo "<p class = 'fin res'> {$o['name']} Wins! It won {$countero} matchups.</p>";
    }

    echo "</div>";

//----------------------------------------------------------------------------------



  }
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  } 


?>

</div>
</body>
<!--
<form>
   <select name = 'pick1'>
              <option value = 'nott'> Enter Option </option>
              <option value = 'name'> Name </option>
              <option value = 'calories'> Calories </option>
              <option value = 'protein'> Protein </option>
              <option value = 'fat'> fat </option>
              <option value = 'sugars'> sugars </option>
              <option value = 'carbo'> carbo </option>
  </select>
  <input type = 'submit'>
</form>
-->