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
* @name Database - Test
* @file database.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.2
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
namespace App\Model\Helper\Test;

// require the `Database.php` file
require '../Database.php';

// use the `Database` from Model Helper
use App\Model\Helper\Database;

// use some PHP core classes
use pdo;
// use pdoexception;


// Instantiate an object of the `Database` class as `database`
$database = new Database(Database::TYPE_PDO); // <- pdo or mysqli ;)

// $database->setDatabaseUsername('abraham-ukachi');
// $database->setDatabasePassword('root');
// $database->setDatabasePort(80);


// connect to the database
$database->dbConnection();


// check connection
if ($database->connect_errno) {
  echo $database->connect_error;
  exit();
}

// DEBUG [4dbsmaster]: tell me about it ;)
printf("\n\x1b[34m[PDO]: ✅ Database connected successfully !!!\x1b[0m\n");


// DEBUG [4dbsmaster]: tell me about the `users` table ;)
// echo mmh\Database::TABLE_USERS;


// define some variables
$firstName = 'Abraham';
$lastName = 'Ukachi';
$email = 'abraham.ukachi@laplateforme.io';

$bookTitle = 'The Art of War';
$bookContent = 'The Art of War is an ancient Chinese military treatise dating from the Late Spring and Autumn Period. The work, which is attributed to the ancient Chinese military strategist Sun Tzu, is composed of 13 chapters. Each one is devoted to an aspect of warfare and how it applies to military strategy and tactics. For almost 1,500 years it was the lead text in an anthology that would be formalised as the Seven Military Classics by Emperor Shenzong of Song in 1080. The Art of War remains the most influential strategy text in East Asian warfare and has influenced both Eastern and Western military thinking, business tactics, legal strategy and beyond. The book contained a detailed explanation and analysis of the Chinese military, from weapons and strategy to rank and discipline. Sun also stressed the importance of intelligence operatives and espionage to the war effort. Because Sun has long been considered to be one of historys finest military tacticians and analysts, his teachings and strategies formed the basis of advanced military training for millennia to come.';


// check if there's a test argument passed to script
$hasTestArg = isset($argc) ? true : false;
// get the 1st argument variable as `testArg`
$testArg = isset($argv[1]) ? $argv[1] : '';



// ===================== TEST #1 ========================
// ==[ FORMAT QUERY & INSERT 1 ROW INTO `users` TABLE ]==
// ======================================================

if ($hasTestArg && $testArg === 'test1') :

  // create a placeholder variable-function as `S`
  $S = 'strval';

  $query = "
    INSERT INTO `{$S(Database::TABLE_USERS)}` (
    
      `{$S(Database::FIELD_EMAIL)}`, 
      `{$S(Database::FIELD_FIRST_NAME)}`, 
      `{$S(Database::FIELD_LAST_NAME)}`
    ) 
    VALUES (
     '$email', 
     '$firstName', 
     '$lastName' 
   )
  "; 
    
  $database->pdo->exec($query);

  printf("\x1b[33m[PDO](TEST1): ✅ $firstName has been added to the database successfully :) \x1b[0m");

endif; // <- ========[ End of Test #1 ]===========




// ===================== TEST #2 ========================
// ==[ FORMAT QUERY & INSERT 1 ROW INTO `users` TABLE ]==
// ======================================================

if ($hasTestArg && $testArg === 'test2') :

// create our sql query
$query = sprintf(<<<SQL
  INSERT INTO `%s` 
    (%s, %s, %s)
  VALUES
    (:email, :first_name, :last_name)
  SQL, 

  // table
  Database::TABLE_USERS,

  // fields
  Database::FIELD_EMAIL,
  Database::FIELD_FIRST_NAME,
  Database::FIELD_LAST_NAME
);

// DEBUG [4dbsmaster]: tell me about this query ;
printf("\n$query\n\n");


// prepare our sql query
$pdo_stmt = $database->pdo->prepare($query);
// execute the `pdo_stmt`
$result = $pdo_stmt->execute([
  ':email' => $email,
  ':first_name' => $firstName,
  ':last_name' => $lastName
]);

// DEBUG [4dbsmaster]: tell me about the result
var_dump($result);

if ($result) {
  printf("\x1b[33m[PDO](TEST2): ✅ $firstName has been added to the database successfully :) \x1b[0m");
}else {
  printf("\x1b[31m[PDO](TEST2): ❌ failed to $firstName to the database successfully :( \x1b[0m");
}

endif; // <- ========[ End of Test #2 ]===========
