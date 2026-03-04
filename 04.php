<?php
if(!isset($_POST['name'])) {
    echo "Please enter your name.";
} else {
    $name = $_POST['name'];
    echo "Hello, " . htmlspecialchars($name) . "!";
}
?>
<form action="" method="post">
    <input type="text" name="name" placeholder="Enter your name">
    <input type="submit" value="Submit">
</form>