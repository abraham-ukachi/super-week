<?php
/**
 * @license MIT 
 * super-week
 *
 * Copyright (c) 2023 Abraham Ukachi
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights 
 * to use, copy, modify, merge, publish, distribute, sub-license, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copy-right notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS, OR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES, OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OF OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @project super-week 
 * @name Router - Super Week
 * @file index.php
 * @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
 * @version: 0.0.1
 * 
 * Usage:
 *  1+|> // how-to route  
 *   -|>
 *
 */



/*
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
* MOTTO: We'll always do more 😜!!!
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/


// ---===--- enabling error reporting ---====---
error_reporting(E_ALL);
ini_set("display_errors", 1);
// ---===---===---===---===---===---===---===---


// require the autoloader
require __DIR__ . '/vendor/autoload.php';


// instantiate the `AltoRouter` class with an object named `router`
$router = new AltoRouter();



// using controllerss
use App\Controller\UserController; // <- use the `UserController`
use App\Controller\AuthController; // <- use the `AuthController`








// Define some constant variables
const APP_NAME = 'super-week';
const BASE_DIR = '/' . APP_NAME;

// set the base path of our `router` using `BASE_DIR`
$router->setBasePath(BASE_DIR);











// #########################
// ####   GET - Routes  ####
// #########################


/**
 * Route that displays the home page
 *
 * @example http://localhost/super-week/
 *
 * @method GET
 * @route '/'
 *
 */
$router->map('GET', '/', function() {
  // Create a welcome message as per project requirement  
  $welcomeMessage = 'Welcome to the home page';
  
  // Require the home page from 'View/'
  require __DIR__ . '/src/View/home.php';
});




/**
 * Route that displays a the users page
 *
 * @example http://localhost/super-week/users
 *
 * @method GET
 * @route '/users'
 *
 */
$router->map('GET', '/users', function() {
  // Create a welcome message as per project requirement  
  $welcomeMessage = "Welcome to the user's list";

  // Require the users page from 'View/'
  require __DIR__ . '/src/View/users.php';


  // Instantiate the `UserController`
  $userController = new UserController();

  // get a list of all users as `usersList`
  $usersList = $userController->list();

  // echo the `usersList` in a paragraph tag
  echo "<p>" . $usersList . "</p>";
});




/**
 * Route that displays a register form,
 * and allows a user to get registered
 *
 * @example http://localhost/super-week/register
 *
 * @method GET
 * @route '/register'
 */
$router->map('GET', '/register', function() {

  // TODO: ? Create & Instantiate a RegisterController
  
  // display the register page from the `View/` folder
  require __DIR__ . '/src/View/register.php';
});



/**
 * Route that displays a login form,
 * and allows a user to get logged in
 *
 * @example http://localhost/super-week/login
 *
 * @method GET
 * @route '/login'
 */
$router->map('GET', '/login', function() {

  // TODO: ? Create & Instantiate a LoginController
  
  // display the login page from the `View/` folder
  require __DIR__ . '/src/View/login.php';
});





/**
 * Route that displays a specific user's page
 *
 * @example http://localhost/super-week/users/3
 *
 * @method GET
 * @route '/users/[i:userId]'
 *
 */
$router->map('GET', '/users/[i:userId]', function($userId) {
  // Create a welcome message as per project requirement  
  $welcomeMessage = "Welcome to the page of User $userId";
  
  // Require the users page from 'View/'
  require __DIR__ . '/src/View/user.php';
});














// ##########################
// ####   POST - Routes  ####
// ##########################




/**
 * Route that allows a user to get registered
 *
 * @example fetch('register', {method: 'POST', body: form})
 *
 * @method POST
 * @route '/register'
 *
 */
$router->map('POST', '/register', function() {
  // Instantiate the `AuthController`
  $authController = new AuthController();
  
  // Call the `register()` method
  $authController->register();

  // Get the response after the `register()` method is called
  $response = $authController->getResponse();

  // echo the `response` in a JSON format
  echo json_encode($response);

});


/**
 * Route that allows a user to login 
 *
 * @example fetch('login', {method: 'POST', body: form})
 *
 * @method POST
 * @route '/login'
 *
 */
$router->map('POST', '/login', function() {
  // Instantiate the `AuthController`
  $authController = new AuthController();
  
  // Call the `login()` method
  $authController->login();

  // Get the response after the `login()` method is called
  $response = $authController->getResponse();

  // echo the `response` in a JSON format
  echo json_encode($response);

});






// ###########################
// ####   PATCH - Routes  ####
// ###########################







// #########################
// ####   PUT - Routes  ####
// #########################







// ############################
// ####   DELETE - Routes  ####
// ############################



// Match the router
$match = $router->match();


// Check if there's a match
if (is_array($match) && is_callable($match['target'])) {
  call_user_func_array($match['target'], $match['params']);

} else { // <- no route matched

  // show a 404 Error Page
  header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
