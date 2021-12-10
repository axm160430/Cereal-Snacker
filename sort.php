
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


<div id = "page">
<p class = "instruct"> Select a Method to Sort Your Cereal!</p>
<form class = "frm">
   <select name = 'options' class = 'sbar'>
              <option class = "otion" value = 'NULL' selected="selected"> Enter Option </option>
              <option class = "otion" value = 'name'> Name </option>
              <option class = "otion" value = 'calories'> Calories </option>
              <option class = "otion" value = 'protein'> Protein </option>
              <option class = "otion" value = 'fat'> Fat </option>
              <option class = "otion" value = 'sugars'> Sugars </option>
              <option class = "otion" value = 'carbo'> Carbs </option>
  </select>
  <input class = "subbut" type = 'submit'>
</form>

<div class = 'cerbar'>

</div>
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
                    carbo INTEGER)");
 
    $memory_db->exec("CREATE TABLE messages (
                      name TEXT, 
                      calories INTEGER,
                      protein INTEGER,
                      fat INTEGER,
                      sugars INTEGER,
                      carbo INTEGER)");
   

 
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
 
 
    $insert = "INSERT INTO messages (name, calories, protein, fat, sugars, carbo) 
                VALUES (:name, :calories, :protein, :fat, :sugars, :carbo)";
    $stmt = $file_db->prepare($insert);
 
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':calories', $calories);
    $stmt->bindParam(':protein', $protein);
    $stmt->bindParam(':fat', $fat);
    $stmt->bindParam(':sugars', $sugars);
    $stmt->bindParam(':carbo', $carbo);
    foreach ($messages as $m) {
      $name = $m['name'];
      $calories = $m['calories'];
      $protein = $m['protein'];
      $fat = $m['fat'];
      $sugars = $m['sugars'];
      $carbo = $m['carbo'];
 
      $stmt->execute();
    }
 
    $insert = "INSERT INTO messages (name, calories, protein, fat, sugars, carbo) 
                VALUES (:name, :calories, :protein, :fat, :sugars, :carbo)";
    $stmt = $memory_db->prepare($insert);
 
    $options = $_GET['options'];
    $result = $file_db->query("SELECT * FROM 'cereal' ORDER BY name IS NOT NULL, {$options} ASC");
 
 echo "<table class = 'tbl'> 
              <tr class = 'headers'>
                  <th class = 'hder'> Name </th>
                  <th class = 'hder'> Calories </th>
                  <th class = 'hder'> Protiens </th>
                  <th class = 'hder'> Fats </th>
                  <th class = 'hder'> Sugars </th>
                  <th class = 'hder'> Carbs </th>
              </tr>";

    foreach ($result as $m) {
      
             echo"<tr class = 'bodies'>
                    <td class = 'bdy'>{$m['name']}</td>
                    <td class = 'bdy'>{$m['calories']}</td>
                    <td class = 'bdy'>{$m['protein']}</td>
                    <td class = 'bdy'>{$m['fat']}</td>
                    <td class = 'bdy'>{$m['sugars']}</td>
                    <td class = 'bdy'>{$m['carbo']}</td>
                  </tr>";
      //echo "<p class = 'crerealName'> {$m['name']} </p>";
    }

     echo"</table>";

  }
catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  } 


?>
</div>
</body>