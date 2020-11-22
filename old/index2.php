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

$Message = '';
$FirstUser = false;

if(isset($_SESSION['FirstUser']) && $_SESSION['FirstUser'])
{
    $FirstUser = true;
    $Message = $_SESSION['First_userName'].', פרטיך נקלטו במערכת שלנו, כעת ניתן למלא את פרטי המשתמש השני.';
    
}

if(isset($_POST['SendMatch']))
{
    
    if(true)/*CheckInputsValidation())*/
    {
        
        /*if(!isset($_POST['userAnimals']))
            $_POST['userAnimals'] = array();*/
        
        if(isset($_SESSION['FirstUser']) && $_SESSION['FirstUser'])
        {
            //Advancewd to the Second User
            
            /*if($_SESSION['First_userLookingFor'] == 3 || $_POST['userLookingFor'] == 3 ||
                 ($_SESSION['First_userLookingFor'] + $_POST['userLookingFor'])%2 == 0){*/
            
            if($_SESSION['First_userLookingFor'] == 3 || $_POST['userLookingFor'] == 3 ||
                 ($_SESSION['First_userLookingFor'] == 1 && $_POST['userLookingFor'] == 1) ||
                 ($_SESSION['First_userLookingFor'] == 1 && $_POST['userLookingFor'] == 2)){
            
                    //Match 
                    
                    $MatchScore = 0;
                    
                    //Calculating the score by the years
                    $MatchScore += (50-(10*(abs($_SESSION['First_userBirthYear']-$_POST['userBirthYear']))));
                    
                    
                    
                    //Adding for each animal option +8 to score if both exists or both does not exists
                    if(isset($_SESSION['First_userAnimal1'], $_POST['userAnimal1']) || 
                        (!isset($_SESSION['First_userAnimal1']) && !isset($_POST['userAnimal1'])))
                        $MatchScore += 8;
                    if(isset($_SESSION['First_userAnimal2'], $_POST['userAnimal2']) || 
                        (!isset($_SESSION['First_userAnimal2']) && !isset($_POST['userAnimal2'])))
                        $MatchScore += 8;
                    if(isset($_SESSION['First_userAnimal3'], $_POST['userAnimal3']) || 
                        (!isset($_SESSION['First_userAnimal3']) && !isset($_POST['userAnimal3'])))
                        $MatchScore += 8;
                    if(isset($_SESSION['First_userAnimal4'], $_POST['userAnimal4']) || 
                        (!isset($_SESSION['First_userAnimal4']) && !isset($_POST['userAnimal4'])))
                        $MatchScore += 8;
                    if(isset($_SESSION['First_userAnimal5'], $_POST['userAnimal5']) || 
                        (!isset($_SESSION['First_userAnimal5']) && !isset($_POST['userAnimal5'])))
                        $MatchScore += 8;
                    
                    /*
                    $First_userAnimals_Size = sizeof($_SESSION['First_userAnimals']);
                    $userAnimals_Size = sizeof($_POST['userAnimals']);
                    for($index = 1;$index <= 5;$index++){
                        $firstFlag = false;
                        
                        
                        //$size = sizeof($UserAnimals);
                        for($i = 0;$i < $First_userAnimals_Size;$i++){
                            if($_SESSION['First_userAnimals'][$i] == $index)
                                $firstFlag = true;
                        }
                        
                        
                        $secondFlag = false;
                        
                        for($j = 0;$j < $userAnimals_Size;$j++){
                            if($_POST['userAnimals'][$j] == $index)
                                $secondFlag = true;
                        }
                        
                        if(($firstFlag && $secondFlag) || (!$firstFlag && !$secondFlag))
                          $MatchScore += 8;  
                    }*/
                    
                    //Check if the favourite things are equals... if yes - add 10 to score..
                    if(strcmp($_POST['userFavThing'], $_SESSION['First_userFavThing']) === 0)
                        $MatchScore += 10;
                    
                     
                    //Building the output message..
                    $Message = $_SESSION['First_userName'].' ו'.$_POST['userName'].', המערכת חישבה את ציון ההתאמה שלכם.'.'<br />';
                    $Message .= 'ציון ההתאמה שלכם הוא: '.$MatchScore.'.<br />';
                    
                    if($MatchScore < 50)
                        $Message .= 'מומלץ בחום לשמור על מרחק...';
                    else if($MatchScore >= 50 && $MatchScore <= 75)
                        $Message .= 'ציון סביר, לא מדהים';
                    else
                        $Message .= 'ציון מעולה! אתם זיווג משמיים';
                    $Message .= '<br />עוד סיבוב?';
                    
                    $FirstUser = false;
                 }
            else{
                //not match
            }
            
            //CleanUserData();
            session_unset();
        }
        else
        {
            //CleanUserData();
            session_unset();
            //Settle First User Data
            $_SESSION['FirstUser'] = true;
            $_SESSION['First_userName'] = $_POST['userName'];
            $_SESSION['First_userBirthYear'] = $_POST['userBirthYear'];
            $_SESSION['First_userLookingFor'] = $_POST['userLookingFor'];
            //$_SESSION['First_userAnimals'] = $_POST['userAnimals'];
            if(isset($_POST['userAnimal1']) && strcmp($_POST['userAnimal1'], 'Yes') == 0)
                $_SESSION['First_userAnimal1'] = true;
            if(isset($_POST['userAnimal2']) && strcmp($_POST['userAnimal2'], 'Yes') == 0)
                $_SESSION['First_userAnimal2'] = true;
            if(isset($_POST['userAnimal3']) && strcmp($_POST['userAnimal3'], 'Yes') == 0)
                $_SESSION['First_userAnimal3'] = true;
            if(isset($_POST['userAnimal4']) && strcmp($_POST['userAnimal4'], 'Yes') == 0)
                $_SESSION['First_userAnimal4'] = true;
            if(isset($_POST['userAnimal5']) && strcmp($_POST['userAnimal5'], 'Yes') == 0)
                $_SESSION['First_userAnimal5'] = true;
            
            $_SESSION['First_userFavThing'] = $_POST['userFavThing'];
            $Message = $_SESSION['First_userName'].', פרטיך נקלטו במערכת שלנו, כעת ניתן למלא את פרטי המשתמש השני.';
            $FirstUser = true;
        }
    }
}

$userTurn = 'משתמש ראשון';
if($FirstUser)
    $userTurn = 'משתמש שני';
?>
<!doctype html>

<html>
<head>
    <meta charset="utf-8" />

    <title>Match System</title>
    <meta name="description" content="Mach System" />
    <meta name="author" content="Matan" />
    <link rel="stylesheet" href="css/style.css" />

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0" />/-->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
  <!--<script src="js/scripts.js"></script>/-->
    <div id="userMessages">
        <h1>מבצע התאמה 2017 - מצא/י את הנשמה התאומה שלך</h1>
        <?php echo $Message; ?>
        <h3><?php echo $userTurn; ?></h3>
    </div>
    
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
                    <!--<input type="checkbox" name="userAnimals[]" id="SelectAn1" value="1" /> <label for="SelectAn1">חתולים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn2" value="2" /> <label for="SelectAn2">כלבים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn3" value="3" /> <label for="SelectAn3">אוגרים</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn4" value="4" /> <label for="SelectAn4">דגי זהב</label><br />
                    <input type="checkbox" name="userAnimals[]" id="SelectAn5" value="5" /> <label for="SelectAn5">בני אדם</label>/-->
                    <input type="checkbox" name="userAnimal1" id="SelectAn1" value="1" /> <label for="SelectAn1">חתולים</label><br />
                    <input type="checkbox" name="userAnimal2" id="SelectAn2" value="2" /> <label for="SelectAn2">כלבים</label><br />
                    <input type="checkbox" name="userAnimal3" id="SelectAn3" value="3" /> <label for="SelectAn3">אוגרים</label><br />
                    <input type="checkbox" name="userAnimal4" id="SelectAn4" value="4" /> <label for="SelectAn4">דגי זהב</label><br />
                    <input type="checkbox" name="userAnimal5" id="SelectAn5" value="5" /> <label for="SelectAn5">בני אדם</label>
                </td>
            </tr>
            <tr>
                <td>הדבר האהוב עליי בעולם:</td>
                <td><input type="text" name="userFavThing" size="25" autocomplete="off" placeholder="הדבר הכי אהוב עליך בעולם..." /></td>
            </tr>
            
            </table>
            <div style="margin: 0 auto;width: max-content;"><input type="submit" name="SendMatch" value="בדוק התאמה" /></div>
        </form>
    </div>
  
  
  
  
</body>
</html>