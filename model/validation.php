<?php
function validName($fname){
    return strlen($fname) >= 2;
}

function validChoices($userChoices){
    $choices = getChoices();
    foreach ($userChoices as $selection ){
        if(!in_array($selection, $choices)){
            return false;
        }
    }
    return true;
}