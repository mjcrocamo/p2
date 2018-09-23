<?php
require 'logic.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
          rel='stylesheet'
          integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO'
          crossorigin='anonymous'>
    <link rel="stylesheet" type="text/css" media="screen" href="/styles/styles.css" />
    <title>What's in a Pirate Name?</title>
</head>
<body>
    <section id="main">
    <h1 class="title">What's in a Pirate Name?</h1>

    <h3>Ever wonder what your pirate name would be?<br/>
        Enter your first name, your birthday month, and last name 
        to find out!</h3>

    <form method="POST" action="searchname.php">

        <fieldset>
            <div class="formlabel">Enter First Name</div>
            <label>
                <input type="text" name="firstname" value="<?= $firstName ?? '' ?>">
            </label>

            <div class="formlabel">Select Birthday Month</div>
            <div class="radiobuttons">
                <label>
                    <input type="radio" name="month" value="Jan"<?php if (isset($month) and $month == "Jan") echo "checked"?>>
                    <span class="monthname">Jan</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Feb"<?php if (isset($month) and $month == "Feb") echo "checked"?>>
                    <span class="monthname">Feb</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Mar"<?php if (isset($month) and $month == "Mar") echo "checked"?>>
                    <span class="monthname">Mar</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Apr"<?php if (isset($month) and $month == "Apr") echo "checked"?>>
                    <span class="monthname">Apr</span>
                </label>
                <label>
                    <input type="radio" name="month" value="May"<?php if (isset($month) and $month == "May") echo "checked"?>>
                    <span class="monthname">May</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Jun"<?php if (isset($month) and $month == "Jun") echo "checked"?>>
                    <span class="monthname">Jun</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Jul"<?php if (isset($month) and $month == "Jul") echo "checked"?>>
                    <span class="monthname">Jul</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Aug"<?php if (isset($month) and $month == "Aug") echo "checked"?>>
                    <span class="monthname">Aug</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Sep"<?php if (isset($month) and $month == "Sep") echo "checked"?>>
                    <span class="monthname">Sep</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Oct"<?php if (isset($month) and $month == "Oct") echo "checked"?>>
                    <span class="monthname">Oct</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Nov"<?php if (isset($month) and $month == "Nov") echo "checked"?>>
                    <span class="monthname">Nov</span>
                </label>
                <label>
                    <input type="radio" name="month" value="Dec"<?php if (isset($month) and $month == "Dec") echo "checked"?>>
                    <span class="monthname">Dec</span>
                </label>
            </div>

            <div class="formlabel">Enter Last Name</div>
            <label>
                <input type='text' name='lastname' value='<?= $lastName ?? '' ?>'>
            </label>
        </fieldset>

        <input type="submit" value="Discover Ye'Old Pirate Name" class="btn btn-primary">
    </form>

    <div id="results">
       <!-- <?php if (isset($firstName) and isset($month) and isset($lastName)): ?>
            <div class="alerts">
                <div class="alert alert-primary" role="alert">
                    Your input name was <em><?= $firstName ?></em> <em><?= $lastName ?></em>.
                    Your input month was <em><?= $month ?></em>.
                </div>
            </div>
        <?php endif; ?>-->

        <?php if (isset($newPirateName) and empty($newPirateName)): ?>
            <div class="alerts">
                <div class="alert alert-warning" role="alert">
                    No results found
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($newPirateName) and empty($newPirateName) == false): ?>
            <div class="piratename">
                <div class="pirate">Your pirate name is:</div> 
                <em><?= $newPirateName[0] ?></em> <em><?= $newPirateName[1] ?></em> <em><?= $newPirateName[2] ?></em>
            </div>
            <img class="piratepic" src=<?= $image ?> alt="Pirate Skull and Bones">
        <?php endif ?>
    </div>
    </section>
</body>
</html>