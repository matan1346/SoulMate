<?php

/**
 * @author lolkittens
 * @copyright 2017
 */

function CleanUserData()
{
    unset(
        $_SESSION['FirstUser'],
        $_SESSION['First_userName'],
        $_SESSION['First_userBirthYear'],
        $_SESSION['First_userLookingFor'],
        $_SESSION['First_usernimals'],
        $_SESSION['First_userFavThing']
    );
}

?>