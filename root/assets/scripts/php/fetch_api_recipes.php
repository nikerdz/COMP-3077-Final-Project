<?php
require_once('../../../config/constants.php');
require_once('../../../config/db_config.php');

$apiKey = 'b808dba1f3e0483ba84aeee37ced3394'; // Replace with your actual API key
$numberOfRecipes = 100; // Number of recipes to fetch
$apiUrl = "https://api.spoonacular.com/recipes/random?number={$numberOfRecipes}&apiKey={$apiKey}";

$response = file_get_contents($apiUrl);
$recipes = json_decode($response, true)['recipes'];

// Fetch the Spoonacular user's ID
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = 'spoonacular'");
$stmt->execute();
$spoonacularUserId = $stmt->fetchColumn();

// Prepare the SQL statement for inserting recipes
$insertRecipe = $pdo->prepare("
    INSERT INTO recipes (title, image_url, cuisine_type, difficulty, vegetarian, gluten_free, dairy_free, meal_type, servings, ready_in_minutes, preparation_time, cooking_time, ingredients, instructions, is_api, created_by)
    VALUES (:title, :image_url, :cuisine_type, :difficulty, :vegetarian, :gluten_free, :dairy_free, :meal_type, :servings, :ready_in_minutes, :preparation_time, :cooking_time, :ingredients, :instructions, :is_api, :created_by)
");

foreach ($recipes as $recipe) {
    $ingredients = array_map(function($ingredient) {
        return $ingredient['original'];
    }, $recipe['extendedIngredients']);
    $ingredientsList = implode("\n", $ingredients);

    $instructions = array_map(function($step) {
        return $step['step'];
    }, $recipe['analyzedInstructions'][0]['steps'] ?? []);
    $instructionsText = implode("\n", $instructions);

    $insertRecipe->execute([
        ':title' => $recipe['title'],
        ':image_url' => $recipe['image'],
        ':cuisine_type' => implode(', ', $recipe['cuisines']),
        ':difficulty' => 'Medium', // Spoonacular doesn't provide difficulty; set a default or determine based on other factors
        ':vegetarian' => $recipe['vegetarian'] ? 1 : 0,
        ':gluten_free' => $recipe['glutenFree'] ? 1 : 0,
        ':dairy_free' => $recipe['dairyFree'] ? 1 : 0,
        ':meal_type' => 'Dinner', // Determine based on recipe details or set a default
        ':servings' => $recipe['servings'],
        ':ready_in_minutes' => $recipe['readyInMinutes'],
        ':preparation_time' => null, // Spoonacular doesn't separate prep and cook times; you might need to estimate
        ':cooking_time' => null,
        ':ingredients' => $ingredientsList,
        ':instructions' => $instructionsText,
        ':is_api' => true,
        ':created_by' => $spoonacularUserId,
    ]);
}
