<?php

/**
 * @author Matan
 * @copyright 2017
 */
 
session_start();

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
        if($_SESSION['First_userLookingFor'] == 3 || $_POST['userLookingFor'] == 3 ||
             ($_SESSION['First_userLookingFor'] == 1 && $_POST['userLookingFor'] == 1) ||
             ($_SESSION['First_userLookingFor'] == 2 && $_POST['userLookingFor'] == 2)){
        
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
             }
        else{
            //not match
            $Message = $_SESSION['First_userName'].' ו'.$_POST['userName'].', שניכם מחפשים נפש תאומה למטרות שונות זו מזו, נסו שוב.'.'<br />';
        }
        session_unset();
        $FirstUser = false;
    }
    else
    {
        session_unset();
        //Settle First User Data
        $_SESSION['FirstUser'] = true;
        $_SESSION['First_userName'] = $_POST['userName'];
        $_SESSION['First_userBirthYear'] = $_POST['userBirthYear'];
        $_SESSION['First_userLookingFor'] = $_POST['userLookingFor'];
        
        //Settle First User Animal Selects
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

$userTurn = 'משתמש ראשון';
if($FirstUser)
    $userTurn = 'משתמש שני';
?>
<!doctype html>

<html>
<head>
    <meta charset="utf-8" />

    <title>Match System</title>
    <meta name="description" content="Match System" />
    <meta name="author" content="Matan" />
    <link rel="stylesheet" href="css/style.css" />

  <!--<link rel="stylesheet" href="css/styles.css?v=1.0" />/-->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>
    <div id="userMessages">
        <h1>מבצע התאמה 2017 - מצא/י את הנפש התאומה שלך</h1>
        <?php echo $Message; ?>
        <h3><?php echo $userTurn; ?></h3>
    </div>
    
    <div id="FormContainer">
        <form method="POST" action="?match">
            <table>
            <tr>
                <td>שם:</td>
                <td><input type="text" name="userName" size="10" /></td>
            </tr>
            <tr>
                <td>שנת לידה:</td>
                <td><input type="number" name="userBirthYear" /></td>
            </tr>
            <tr>
                <td>מחפש/ת נפש תאומה:</td>
                <td>
                    <input type="radio" name="userLookingFor" value="1" checked="checked"/> למטרות רומנטיות<br />
                    <input type="radio" name="userLookingFor" value="2" /> למטרות ידידות<br />
                    <input type="radio" name="userLookingFor" value="3" /> מה שיוצא אני מרוצה..
                </td>
            </tr>
            <tr>
                <td>חיות שאני אוהב/ת:</td>
                <td>
                    <input type="checkbox" name="userAnimal1" value="Yes" /> חתולים<br />
                    <input type="checkbox" name="userAnimal2" value="Yes" /> כלבים<br />
                    <input type="checkbox" name="userAnimal3" value="Yes" /> אוגרים<br />
                    <input type="checkbox" name="userAnimal4" value="Yes" /> דגי זהב<br />
                    <input type="checkbox" name="userAnimal5" value="Yes" /> בני אדם
                </td>
            </tr>
            <tr>
                <td>הדבר האהוב עליי בעולם:</td>
                <td><input type="text" name="userFavThing" size="25" /></td>
            </tr>
            
            </table>
            <div id="SubmitHolder"><input type="submit" name="SendMatch" value="בדוק התאמה" /></div>
        </form>
    </div>
  
  
  
  
</body>
</html>