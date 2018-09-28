<?php
/*
 * This is the script that the form on index.php submits to
 * Its job is to:
 * 1. Get the data from the form request
 * 2. Validate form for errors
 * 2. Load the generated pirate name with corresponding picture if no errors
 * 3. Store the results in the SESSION
 * 4. Redirect the visitor back to index.php
 */

require('includes/helpers.php');
require 'PirateName.php';
require 'Form.php';

use P2Pirate\PirateName;
use P2Form\Form;

# Initiate Session
session_start();

# Instantiate classes
$pirateName = new PirateName('names.json');
$form = new Form($_GET);

# Get data from form request
$firstNameLetter = $form->getLetter('firstName');
$lastNameLetter = $form->getLetter('lastName');
$firstName = $form->get('firstName');
$month = $form->get('month');
$lastName = $form->get('lastName');
$reverse = $form->has('reverseName');

# Validate form
$errors = $form->validate([
    'firstName' => 'required|alpha',
    'month' => 'required',
    'lastName' => 'required|alpha'
]);

# Get the Pirate Name if no errors found
if(!$form->hasErrors) {
   $newPirateName = $pirateName->getPirateName($firstNameLetter, $month, $lastNameLetter);
}


# Store results data in the SESSION so it's available when we redirect back to index.php
$_SESSION['results'] = [
    'firstName' => $firstName,
    'month' => $month,
    'lastName' => $lastName,
    'newPirateName' => $newPirateName,
    'errors' => $errors,
    'hasErrors' => $form->hasErrors,
    'reverseName' => $reverse,
];

# Redirect back to the form on index.php
header('Location: index.php');

