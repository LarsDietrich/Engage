
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Engage DB testing and setup</title>
    </head>
    <body>
<?php
mysql_connect("localhost", "presentadmin", "herE843") or die(mysql_error());
echo "Connected to MySQL<br />\n";
mysql_select_db("presentdb") or die(mysql_error());
echo "Connected to Database<br />\n";

// Create a MySQL table in the selected database
// mysql_query("CREATE TABLE tpolls(
// id INT NOT NULL AUTO_INCREMENT, 
// PRIMARY KEY(id),
//  tid INT,
//  question VARCHAR(255), 
//  ans1 TEXT,
//  ans2 TEXT,
//  ans3 TEXT)")
//  or die(mysql_error());  

// echo "Table Created!";

// Retrieve all the data from the "example" table
$result = mysql_query("SELECT * FROM ttopics") or die(mysql_error());  

while($row = mysql_fetch_array($result)){
  echo "Name: ".$row['name']." - ".$row['id']."<br />\n";
}
?>
    </body>
</html>
