<?php
$i = 0;
while ($i < 10) {
    echo $i . "<br>";
    $i++;
}
echo "--------------------------<br>";
for ($i = 10; $i > 0; $i--) {
    echo $i . "<br>";
}
echo "--------------------------<br>";
do {
    echo $i . "<br>";
    $i++;
} while ($i < 20);
echo "--------------------------<br>";
// 宣告陣列names，並賦值為三個名字
$names = ["Alice", "Bob", "Charlie", "David", "Eve"];
foreach ($names as $item) {
    echo $item . "<br>";
}
echo "--------------------------<br>";
date_default_timezone_set("Asia/Taipei");
echo date("Y-m-d H:i:s"). "<br>";
echo "--------------------------<br>";
$data=array(
    "name" => "Dragon",
    "age" => 28,
    "city" => "New Taipei City"
);
echo "Name: " . $data["name"] . "<br>";
echo "Age: " . $data["age"] . "<br>";  
echo "City: " . $data["city"] . "<br>";
echo "--------------------------<br>";
$table = array(
    array("name" => "Dragon","age" => 28,"city" => "New Taipei City"),
    array("name" => "Alice","age" => 25,"city" => "Taipei City"),
    array("name" => "Bob","age" => 30,"city" => "Taichung City")
);
echo "<table border='1'>";
echo "<tr><th>Name</th><th>Age</th><th>City</th></tr>";
foreach ($table as $row) {
    echo "<tr>";
    foreach ($row as $key => $value) {
        echo "<td>" . $value . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>