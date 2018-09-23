<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Load the generated pirate name with corresponding picture
 * 3. Store the results in the SESSION
 * 4. Redirect the visitor back to index.php
 */

# Initiate Session
session_start();

# Helpful for debugging
require('helpers.php');

# Get data from form request
$firstNameLetter = strtoupper($_POST['firstname'][0]);
$month = $_POST['month'];
$lastNameLetter = strtoupper($_POST['lastname'][0]);

# Load pirate name conversion data
$namesJson = file_get_contents('names.json');
$names = json_decode($namesJson, true);

# Initialize array to store pirate name
$newPirateName = [];

# Generate name data according to what the user submitted
foreach($names as $jsonLabel => $name) {
    foreach($name as $key => $pirateName) {
        if($jsonLabel == "FirstName") {
            if($key == $firstNameLetter) {
                array_push($newPirateName,$name[$key]);
            }
        } else if($jsonLabel == "Birthday") {
            if($key == $month) {
                array_push($newPirateName,$name[$key]);
            }
        } else {
            if($key == $lastNameLetter) {
                array_push($newPirateName,$name[$key]);
            }
        }
    }
}

# Store our results data in the SESSION so it's available when we redirect back to index.php
$_SESSION['results'] = [
    'firstName' => $_POST['firstname'],
    'month' => $month,
    'lastName' => $_POST['lastname'],
    'newPirateName' => $newPirateName
];

# Redirect back to the form on index.php
header('Location: index.php');

