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
 * MOTTO: We'll always do more 😜!!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */

// ==== Display all PHP errors and warnings ====
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// =============================================

// declare the namespace of this models test
namespace App\Model\Test;

// require the `autoload.php` file
require_once __DIR__ . '/../../../vendor/autoload.php';

// require the `UserModel.php` file
// require_once '../UserModel.php';
// require_once '../Helper/Database.php';

// use the `UserModel` from the `App\Model` namespace
use App\Model\UserModel;

// use some PHP core classes
//use pdo;
// use pdoexception;


// Create an object of the `UserModel` class as `userModel`
$userModel = new UserModel();


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
    

endif; // <- ========[ End of Test #1 / findAll ]===========




// ===================== TEST #2 ========================
// ==[  ]==
// ======================================================

if ($hasTestArg && in_array($testArg, ['test2'])) :


endif; // <- ========[ End of Test #2 ]===========
