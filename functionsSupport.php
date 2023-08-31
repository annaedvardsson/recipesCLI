<?php

function recipesFileToArray() {
    $fileContent = file_get_contents(SOURCE_FILE);
    $lines = explode(PHP_EOL, $fileContent);

    $recipes = [];
    foreach ($lines as $line) {
        if (!empty($line)) {
            $ingredients = explode(',', $line);
            $recipeName = array_shift($ingredients); // Set first item as key and remove from ingredients
            $recipes[$recipeName] = $ingredients;
        }
    }

    return $recipes;
}

function recipesAsString($recipes) {
    $recipesAsString = '';
    foreach ($recipes as $recipeName => $ingredients) {
        $recipesAsString .= $recipeName . ',' . implode(',', $ingredients) . PHP_EOL;
    }

    return $recipesAsString;
}

function dislayRecipes($recipes) {
    echo "\033[33m" . "*************************" . "\033[0m" . PHP_EOL;
    echo 'Recipe name (ingredients)' . PHP_EOL;
    echo "\033[33m" . "*************************" . "\033[0m" . PHP_EOL;
    foreach ($recipes as $recipeName => $ingredients) {
        echo ucfirst($recipeName) . " ";
        echo '(' . implode(', ', $ingredients) . ')';
        echo PHP_EOL;
    }
}
