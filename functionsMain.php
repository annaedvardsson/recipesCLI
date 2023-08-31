<?php

require_once 'functionsSupport.php';

define("SOURCE_FILE", "recipes.txt");

function searchByName() {
   
    echo '********************' . PHP_EOL;
    $input = strtolower(readline('Enter recipe name: '));
    
    $noRecipie = true;

    $recipes = recipesFileToArray();
    foreach ($recipes as $recipeName => $ingredients) {
        if ($input == $recipeName) {
            echo 'This recipe requires the following ingredients: ' . implode(',', $ingredients) . PHP_EOL;
            $noRecipie = false;
            break;
        }
    }

    if ($noRecipie) {
        system('clear');
        echo PHP_EOL . "There is no recipe named \033[1;35m" . $input . "\033[0m";
        echo '. These are the available recipes.' . PHP_EOL;

        dislayRecipes($recipes);
    }

    readline();
}

function searchByIngredients() {

    echo '********************' . PHP_EOL;
    $input = strtolower(readline('Enter available ingredients (separated by , and space): '));
    $availableIngredients = explode(', ', $input);
    
    $followableRecipes = [];
    
    $recipes = recipesFileToArray();
    foreach ($recipes as $recipeName => $ingredients) {
        $diff = array_diff($ingredients, $availableIngredients); // diff = empty if all $ingredients are found within $availableIngredients
        
        if (empty($diff)) {
            $followableRecipes[$recipeName] = $ingredients;
        }
    }

    // Display results
    if (!empty($followableRecipes)) {
        echo PHP_EOL . 'With the given ingredients you can follow these recipe(s):' . PHP_EOL;
        dislayRecipes($followableRecipes);
    } else {
        echo 'You need to add additional ingredients to find any recipes.' . PHP_EOL;
    }

    readline();
}

function addRecipe() {

    $recipes = recipesFileToArray();

    // Add recipe name and verify that it is unique
    do {
        echo '*******************************' . PHP_EOL;
        $input = strtolower(readline('Add recipe name: '));
        if (array_key_exists($input, $recipes)) {
            system('clear');
            echo 'This recipe name already exist!' . PHP_EOL;
        }
    } while (array_key_exists($input, $recipes));

    readline_add_history($input);

    // Add ingredients
    echo PHP_EOL . 'Add ingredients and press enter between each ingredient.' . PHP_EOL;
    echo '(Press enter on empty line to complete recipe.)' . PHP_EOL;

    $ingredient = ' ';
    while ($ingredient != '') {
        $ingredient = strtolower(readline('Add ingredient: '));
        if ($ingredient != '') {
            readline_add_history($ingredient);
        }
    }
    
    // Add new recipe to file 
    file_put_contents(SOURCE_FILE, implode(',', readline_list_history()) . PHP_EOL, FILE_APPEND);
    readline_clear_history();

    echo '*******************************' . PHP_EOL;
    echo ucfirst($input) . ' recipe added';
    readline();
}

function deleteRecipe() {

    // List recipes and save recipe array
    $recipes = listRecipes();

    // Delete recipe
    echo '********************' . PHP_EOL;
    $input = strtolower(readline('Enter recipe name to be deleted: '));

    if (array_key_exists($input, $recipes)) {
            unset($recipes[$input]);
            file_put_contents(SOURCE_FILE, recipesAsString($recipes));

            echo 'Recipe deleted!' . PHP_EOL;

    } else {
        echo 'There is no recipe with that name!' . PHP_EOL;
    }

    readline();
}

function listRecipes() {

    $recipes = recipesFileToArray();
    dislayRecipes($recipes);
    return $recipes;
}
