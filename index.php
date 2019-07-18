<?php
/*
//========================================================================//
//================================ Rule List==============================//
//========================================================================//
1. required
2. string
3. int
4. max:value
5. min:value

*/
require 'Validator.php';
$rules = array(
    'name' => 'required|min:10',
    'address' => 'required'
);
if (isset($_POST['submit'])) {
    $validation = new Validator($_POST, $rules);

    foreach ($validation->getErrors() as $error) {
        echo "<li>" . $error . "</li>";
    }
    if ($validation->pass()) {
        echo "Form Suuccess";
    }
}



?>


<form method="post" action="">
    <!-- name field-->
    <label for="name">Name</label>
    <input id="name" type="text" name="name">
    <!-- address field -->
    <label for="address">Address</label>
    <input id="address" type="text" name="address">
    <!-- nicname field we not check validatio just for demo purpose-->
    <label for="address">Nick Name</label>
    <input id="address" type="text" name="nick_name">

    <input type="submit" value="Submit" name="submit">
</form>