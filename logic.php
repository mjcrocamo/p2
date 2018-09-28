<?php
/*
 * This is the logic file for index.php; it's job is to check the
 * SESSION for results, and if available, store the results in variables
 * to display in index.php
 */
session_start();

$hasErrors = false;
$reverseName = false;

# Get `results` data from session, if available
if(isset($_SESSION['results'])) {
    $results = $_SESSION['results'];

    $firstName = $results['firstName'];
    $month = $results['month'];
    $lastName = $results['lastName'];
    $newPirateName = $results['newPirateName'];

    $errors = $results['errors'];
    $hasErrors = $results['hasErrors'];
    $reverseName = $results["reverseName"];
}

# Logic to generate random image
$imageURLs = [
    "images/bird_28.png",
    "images/penguin_28.png",
    "images/pirate-pipe_28.png",
    "images/pirate-skull_28.png"
];

$randomImageKey = array_rand($imageURLs, 1);

$image = $imageURLs[$randomImageKey];

# Clear session data so our search is cleared when the page is refreshed
session_unset();
