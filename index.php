<?php

require_once 'functionsMain.php';

do {
    $option = displayMenu();
    
    switch ($option) {
        case '0':
            searchByName();
            break;
        case '1':
            searchByIngredients();
            break;
        case '2':
            addRecipe();
            break;
        case '3':
            deleteRecipe();
            break;
        case '4':
            listRecipes();
            readline();
            break;
        case '5':
            exit('See you another time!');
    }
} while ($option != 5);

function displayMenu() {
    do {
        system('clear');
        // system('cls'); // For Command Prompt
        // system('Clear-Host'); // For PowerShell

        echo "\033[36m*************************\033[0m" . PHP_EOL;
        echo 'MENU' . PHP_EOL;
        echo "\033[1;36m*************************\033[0m" . PHP_EOL;
        echo '0. Search recipe by name' . PHP_EOL;
        echo '1. Search recipes by ingredients' . PHP_EOL;
        echo '2. Add recipe' . PHP_EOL;
        echo '3. Delete recepie' . PHP_EOL;
        echo '4. List all recipes' . PHP_EOL;
        echo '5. Quit' . PHP_EOL . PHP_EOL;
        (int) $option = readline('Select 1-5 and press enter: ');
    } while ($option > 5 || $option < 0);
    system('clear');

    return $option;
}
