<?php
/**
* @license MIT
* super-week
* Copyright (c) 2023 Abraham Ukachi
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
*
* @project super-week 
* @name User Model - Test
* @file user_model.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
*
*/


/*
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * MOTTO: I'll always do more 😜!!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */



// declare the namespace of this models test
namespace App\Model\Test;


// ==== Display all PHP errors and warnings ====
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// =============================================


// require the `autoload.php` file
require_once __DIR__ . '/../../../vendor/autoload.php';

// set the default timezone to 'Europe/Paris'
date_default_timezone_set('Europe/Paris');
// start the session
session_start();


// require the `UserModel.php` file
// require_once '../UserModel.php';
// require_once '../Helper/Database.php';

// use the `UserModel` from the `App\Model` namespace
use App\Model\UserModel;
use Faker\Factory;

// use some PHP core classes
//use pdo;
// use pdoexception;


// Create an object of the `UserModel` class as `userModel`
$userModel = new UserModel();
$faker = Factory::create('en_US'); // <- use the factory to create a Faker\Generator instance named `$faker`

// DEBUG [4dbsmaster]: tell me about it ;)
printf("\n\x1b[34m[UserModel - Test]: Welcome 👋🏽 !!!\x1b[0m\n");



// TODO: define some variables here ;)


// check if there's a test argument passed to script
$hasTestArg = isset($argc) ? true : false;
// get the 1st argument variable as `testArg`
$testArg = isset($argv[1]) ? $argv[1] : '';



// ===================== TEST #1 ========================
// ===========[ DISPLAY A LIST OF ALL USERS ]============
// ======================================================

// If there's a test argument and it's `findAll` or `test1`...
if ($hasTestArg && in_array($testArg, ['findAll', 'test1'])) :
  // ...get all users using the `findAll()` method
  $allUsers = $userModel->findAll();
  
  // print the list of all users
  printf("\n\x1b[33m[UserModel - Test]: Here's a list of all users:\x1b[0m\n");

  print_r($allUsers);
    

endif; 
// <- ========[ End of Test #1 / findAll ]===========




// ===================== TEST #2 ========================
// ================[ CREATE A NEW USER ]=================
// ======================================================

if ($hasTestArg && in_array($testArg, ['create', 'test2'])) :
  // generate some fake user data with a unique email
  $email = $faker->unique()->email();
  $firstName = $faker->firstName();
  $lastName = $faker->lastName();
  $password = $faker->password();
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
  // create a new user with the fake data
  $newUser = $userModel->create($email, $firstName, $lastName, $hashedPassword);

  // If a new user was created...
  if ($newUser) {
    // ...IDEA: log this user in a `test2.log` file

    // Create a `log` string variable
    $log = sprintf(<<<LOG
    
    === "[New User Created]" ===
    id_user: %d
    email: %s
    first_name: %s
    last_name: %s
    password: %s
    hashedPassword: %s
    =========================

    LOG,

    $newUser['id'],
    $newUser['email'],
    $newUser['first_name'],
    $newUser['last_name'],
    $password,
    $newUser['password']

    );

    // Append this `log` in a `test2.log` file
    file_put_contents('test2.log', $log, FILE_APPEND);

    // DEBUG [4dbsmaster]: tell me about the new user
    printf("\n\x1b[2m\x1b[33m[USER-MODEL](TEST2|CREATE): email (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) and password (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) of \x1b[0m\x1b[1m%s\x1b[2m\x1b[33m have been added to the database successfully :) \x1b[0m\n", $email, $password, $firstName . ' ' . $lastName);

  } else { // <- error creating new user

    // DEBUG [4dbsmaster]: tell me about the error
    printf("\n\x1b[2m\x1b[31m[USER-MODEL](TEST2|CREATE): Failed to create a new user :( \x1b[0m\n");
  }

endif; 
// <- ========[ End of Test #2 ]===========









// ===================== TEST #3 ========================
// ==============[ FIND A USER BY EMAIL ]================
// ======================================================

if ($hasTestArg && in_array($testArg, ['findByEmail', 'test3'])) :

  // get the 2nd argument variable as `userEmail`
  $userEmail = isset($argv[2]) ? $argv[2] : ''; // <- if it exists, use it, else use an empty string

  // Initialize a `log` variable
  $log = sprintf(<<<LOG
  
  ==== "[Email NOT Provided]" ====
  email: ???
  date_time: %s
  ======================

  LOG, date('Y-m-d H:i:s'));


  // If the `userEmail` is not empty...
  if (!empty($userEmail)) {
    // ...find the user with that email as `user`
    $user = $userModel->findByEmail($userEmail);

    
    // if a user was found with that email...
    if ($user) { 
    // ...TEST [4dbsmaster]: tell me about the user
    printf("\n\x1b[2m\x1b[33m[USER-MODEL](TEST3|FINDBYEMAIL): Here's the user with email (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m):\x1b[0m\n", $userEmail);

    // print the user
    print_r($user);


    // Update the `$log`
    $log = sprintf(<<<LOG
    
    ==== "[User Found]" ====
    email: %s
    date_time: %s
    ======================

    LOG, $userEmail, date('Y-m-d H:i:s'));

    } else { // <- no user found with that email

      // DEBUG [4dbsmaster]: tell me about the error
      printf("\n\x1b[2m\x1b[34m[USER-MODEL](TEST3|FINDBYEMAIL): \x1b[0m\x1b[34mNo user found with email (\x1b[0m\x1b[4m\x1b[34m%s\x1b[0m\x1b[2m\x1b[34m) :( \x1b[0m\n", $userEmail);

      
      // Update the `$log`
      $log = sprintf(<<<LOG
      
      ==== "[User NOT Found]" ====
      email: %s
      date_time: %s
      ======================

      LOG, $userEmail, date('Y-m-d H:i:s'));

    }


  } else { // <- no email provided

    // TEST [4dbsmaster]: tell me about the error
    printf("\n\x1b[2m\x1b[31m[USER-MODEL](TEST3|FINDBYEMAIL): \x1b[0m\x1b[31mNo email provided :( \x1b[0m\n");

  }


  // save the `$log` in a `test3.log` file
  file_put_contents('test3.log', $log, FILE_APPEND);

endif; 
// <- ========[ End of Test #3 ]===========




// ======================= TEST #4 ========================
// =============[ CONNECT A REGISTERED USER ]==============
// ========================================================

if ($hasTestArg && in_array($testArg, ['connect', 'test4'])) :

  // get the 2nd argument variable as `userEmail`
  $userEmail = isset($argv[2]) ? $argv[2] : ''; // <- if it exists, use it, else use an empty string

  // get the 3rd argument variable as `userPassword`
  $userPassword = isset($argv[3]) ? $argv[3] : ''; // <- if it exists, use it, else use an empty string



  // Initialize a `log` variable
  $log = sprintf(<<<LOG
  
  ==== "[User NOT Connected ❌]" ====
  email: %s
  password: %s
  date_time: %s
  ======================

  LOG, 
  $userEmail, $userPassword,
  date('Y-m-d H:i:s'));


  // If the email and password are not empty...
  if (!empty(trim($userEmail)) && !empty(trim($userPassword))) {
    // ...try to connect the user
    try {
      // connect the user
      $user = $userModel->connect($userEmail, $userPassword);
      
      // user is connected if `user` is not FALSE
      $userIsConnected = $user !== false;

      // If the user is connected...
      if ($userIsConnected) {
        // ...TEST [4dbsmaster]: tell me about the user
        printf("\n\x1b[2m\x1b[33m[USER-MODEL](TEST4|CONNECT): \x1b[0m\x1b[33mUser with email (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) is connected :) \x1b[0m\n", $userEmail);

        // print the user
        print_r($user);

        // update the `$log` 
        $log = sprintf(<<<LOG

        ==== "[User Connected ✅]" ====
        id: %d
        email: %s
        password: %s
        date_time: %s
        ======================

        LOG,
        $user['id'], $user['email'], $user['password'],
        date('Y-m-d H:i:s'));
          
      }else { // <- user is not connected

        // update the `$log` 
        $log = sprintf(<<<LOG

        ==== "[Connected Failed 😢]" ====
        email: %s
        password: %s
        date_time: %s
        ======================

        LOG,
        $userEmail, $userPassword,
        date('Y-m-d H:i:s'));


        // DEBUG [4dbsmaster]: tell me about the error
        printf("\n\x1b[2m\x1b[31m[USER-MODEL](TEST4|CONNECT): \x1b[0m\x1b[31mFailed to connect the user with email (\x1b[0m\x1b[4m\x1b[31m%s\x1b[0m\x1b[2m\x1b[31m) :( Try again ! \x1b[0m\n", $userEmail);
      }

    } catch (Exception $e) {
      // DEBUG [4dbsmaster]: tell me about the error
      printf("\n\x1b[2m\x1b[31m[USER-MODEL](TEST4|CONNECT): \x1b[0m\x1b[31m%s \x1b[0m\n", $e->getMessage());
    }


    // log the result in a `test4.log` file
    file_put_contents('test4.log', $log, FILE_APPEND);

  } else { // <- email or password is empty

    // DEBUG [4dbsmaster]: tell me about the error
    printf("\n\x1b[2m\x1b[31m[USER-MODEL](TEST4|CONNECT): \x1b[0m\x1b[31mEmail or password is empty :( \x1b[0m\n");
  }


endif; 
// <- ========[ End of Test #4 ]===========







