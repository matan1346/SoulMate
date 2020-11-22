<?php

/**
 * @author Matan
 * @copyright 2017
 */
session_start();

/**
 * userName
 * userBirthYear
 * userLookingFor
 * userAnimals
 * UserFavThing
 * 
 */

require_once 'functions.php';

//print_r($_SESSION);

$Message = '';
$FirstUser = false;

if(isset($_SESSION['FirstUser']) && $_SESSION['FirstUser'])
{
    $FirstUser = true;
    $Message = $_SESSION['First_userName'].', פרטיך נקלטו במערכת שלנו, כעת ניתן למלא את פרטי המשתמש השני.';
    
}

if(isset($_POST['SendMatch']))
{
    
    if(isset($_SESSION['FirstUser']) && $_SESSION['FirstUser'])
    {
        //Advancewd to the Second User
        //echo $_SESSION['First_userName'].', פרטיך נקלטו במערכת שלנו, כעת ניתן למלא את פרטי המשתמש השני.';
        
        if($_SESSION['First_userLookingFor'] == 3 || $_POST['userLookingFor'] == 3 ||
             ($_SESSION['First_userLookingFor'] + $_POST['userLookingFor'])%2 == 0){
                //Match 
                echo 'match found!';
                
             $MatchLevel = 0;
             
             $MatchLevel += (50-(10*abs($_SESSION['First_userBirthYear'] - $_POST['userBirthYear'])));
                
             
             
                
             }
        else{
            //not match
            echo 'sorry guys!';
            
        }
        
        $FirstUser = false;
        CleanUserData();
    }
    else
    {
        CleanUserData();
        //Settle First User Data
        $_SESSION['FirstUser'] = true;
        $_SESSION['First_userName'] = $_POST['userName'];
        $_SESSION['First_userBirthYear'] = $_POST['userBirthYear'];
        $_SESSION['First_userLookingFor'] = $_POST['userLookingFor'];
        $_SESSION['First_userAnimals'] = $_POST['userAnimals'];
        $_SESSION['First_userFavThing'] = $_POST['userFavThing'];
        $Message = $_SESSION['First_userName'].', פרטיך נקלטו במערכת שלנו, כעת ניתן למלא את פרטי המשתמש השני.';
        $FirstUser = true;
        echo 'hey';
    }
    
    //Handle form
    //echo 'testMatch!';
    
    
    echo '<pre>'.print_r($_POST, true).'</pre>';
    
    
}



?>
<!doctype html>

<html>
<head>
    <meta charset="utf-8" />

    <title>Match System</title>
    <meta name="description" content="Mach Syswtem" />
    <meta name="author" content="Matan" />
    <link rel="stylesheet" href="css/style.css" />

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0" />/-->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
  <!--<script src="js/scripts.js"></script>/-->
    <h1>מבצע התאמה 2017 - מצא/י את הנשמה התאומה שלך</h1>
    <?php echo $Message; ?>
    <h3><?php echo 'משתמש '.((!$FirstUser) ? 'ראשון' : 'שני')?></h3>
    <div id="FormContainer">
        <form method="POST" action="?match">
            <table>
            <tr>
                <td>שם:</td>
                <td><input type="text" name="userName" size="10" autocomplete="off" placeholder="השם שלך..." /></td>
            </tr>
            <tr>
                <td>שנת לידה:</td>
                <td><input type="number" name="userBirthYear" autocomplete="off" placeholder="שנת הלידה שלך..." /></td>
            </tr>
            <tr>
                <td>מחפש/ת נפש תאומה:</td>
                <td>
                    <input type="radio" name="userLookingFor" id="LookingFor1" value="1" checked="checked"/> <label for="LookingFor1">למטרות רומנטיות</label><br />
                    <input type="radio" name="userLookingFor" id="LookingFor2" value="2" /> <label for="LookingFor2">למטרות ידידות</label><br />
                    <input type="radio" name="userLookingFor" id="LookingFor3" value="3" /> <label for="LookingFor3">מה שיוצא אני מרוצה..</label>
                </td>
            </tr>
            <tr>
                <td>חיות שאני אוהב/ת:</td>
                <td>
                    <input type="checkbox" name="userAnimals[]" id="SelectAn1" value="1" /> <label for="SelectAn1">חתולים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn2" value="2" /> <label for="SelectAn2">כלבים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn3" value="3" /> <label for="SelectAn3">אוגרים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn4" value="4" /> <label for="SelectAn4">דגי זהב</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn5" value="5" /> <label for="SelectAn5">בני אדם</label>
                </td>
            </tr>
            <tr>
                <td>הדבר האהוב עליי בעולם:</td>
                <td><input type="text" name="userFavThing" size="25" autocomplete="off" placeholder="הדבר הכי אהוב עליך בעולם..." /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><input type="submit" name="SendMatch" value="בדוק התאמה" /></td>
            </tr>
            </table>
        </form>
    </div>
  
  
  
  
</body>
</html>