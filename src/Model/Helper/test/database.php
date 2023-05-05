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
//require '../Database.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

// use the `Database` from Model Helper
use App\Model\Helper\Database;
use Faker\Factory;

// use some PHP core classes
use pdo;
// use pdoexception;


// Instantiate an object of the `Database` class as `database`
$database = new Database(Database::TYPE_PDO); // <- pdo or mysqli ;)

$faker = Factory::create('en_GB'); // <- use the factory to create a Faker\Generator instance. 
// ^^^^^^ TRY: 'fr_FR' or 'en_US' or 'en_GB' or 'en_CA' or 'en_AU' or 'en_NZ' or 'ja_JP' or 'pt_BR' or 'ru_RU' or 'zh_CN' or 'zh_TW'

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




// ===================== TEST #3 ==========================
// ==========[ FAKE POPULATE THE `users` TABLE ]===========
// ========================================================

if ($hasTestArg && $testArg === 'test3') :

  // get the number of rows to populate from the user's input, or default to 10
  $rowsToPopulate = isset($argv[2]) ? $argv[2] : 10;
  
  // loop through the number of rows to populate
  for ($n = 0; $n < $rowsToPopulate; $n++) {
    // generate some fake data
    $firstName = $faker->firstName();
    $lastName = $faker->lastName();
    $email = $faker->unique->email();
    $password = $faker->password();

    // hash the password
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    // create a `create_user_query` sql query
    $create_user_query = sprintf(<<<SQL
      INSERT INTO `%s` 
        (%s, %s, %s, %s)
      VALUES
        (:email, :first_name, :last_name, :password)
      SQL, 

      // table
      Database::TABLE_USERS,

      // fields
      Database::FIELD_EMAIL,
      Database::FIELD_FIRST_NAME,
      Database::FIELD_LAST_NAME,
      Database::FIELD_PASSWORD
    );


    // Prepare the `create_user_query` sql query as a PDO statement (i.e. $pdo_stmt)
    $pdo_stmt = $database->pdo->prepare($create_user_query);

    // execute the `$pdo_stmt` with the fake data
    $result = $pdo_stmt->execute([
      Database::FIELD_EMAIL => $email,
      Database::FIELD_FIRST_NAME => $firstName,
      Database::FIELD_LAST_NAME => $lastName,
      Database::FIELD_PASSWORD => $hashPassword
    ]);

    // Log the fake data to a file named `test3.log`
    $log = sprintf(<<<LOG
      === [%d] ===
      email: %s
      password: %s
      hashPassword: %s
      first_name: %s
      last_name: %s

      LOG,

      $n + 1,
      $email,
      $password,
      $hashPassword,
      $firstName,
      $lastName
    );

    // write the log to the file
    file_put_contents('test3.log', $log, FILE_APPEND);


    // DEBUG [4dbsmaster]: tell me about the result
    printf("\n\x1b[2m\x1b[33m[DB](TEST3|FAKER): email (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) and password (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) have been added to the database successfully @ row \x1b[0m\x1b[1m#%d\x1b[2m\x1b[33m :) \x1b[0m\n", $email, $password, $n + 1);

  }


  // DEBUG [4dbsmaster]: tell me about it ;)
  printf("\x1b[35m[DB] (TEST3|FAKER): %d users have been added to the database!!! \x1b[0m", $rowsToPopulate);

endif; 

// <- ========[ End of Test #3 ]===========





// ===================== TEST #4 ==========================
// ==========[ FAKE POPULATE THE `books` TABLE ]===========
// ========================================================

if ($hasTestArg && $testArg === 'test4') :

  // get the number of rows to populate from the user's input, or default to 10
  $rowsToPopulate = isset($argv[2]) ? $argv[2] : 10;

  // define the number of words 
  // for the title
  $nbTitleWords = 4;
  // for the content
  $nbContentWords = 100;

  // loop through the number of rows to populate
  for ($n = 0; $n < $rowsToPopulate; $n++) {

    // generate some fake data
    $title = $faker->sentence($nbTitleWords);
    $content = $faker->sentence($nbContentWords);
    $id_user = rand(2, $rowsToPopulate); // <- faking the user's id w/ a random number between 2 and given `rowsToPopulate` value

    // create a `create_book_query` sql query
    $create_book_query = sprintf(<<<SQL
      INSERT INTO `%s` 
        (%s, %s, %s)
      VALUES
        (:title, :content, :id_user)
      SQL, 

      // table
      Database::TABLE_BOOKS,

      // fields
      Database::FIELD_TITLE,
      Database::FIELD_CONTENT,
      Database::FIELD_ID_USER
    );


    // Prepare the `create_user_query` sql query as a PDO statement (i.e. $pdo_stmt)
    $pdo_stmt = $database->pdo->prepare($create_book_query);

    // execute the `$pdo_stmt` with the fake data
    $result = $pdo_stmt->execute([
      Database::FIELD_TITLE => $title,
      Database::FIELD_CONTENT => $content,
      Database::FIELD_ID_USER => $id_user
    ]);

    // Log the fake data to a file named `test3.log`
    $log = sprintf(<<<LOG
      === [%d] ===
      title: %s
      content: %s
      id_user: %s

      LOG,

      $n + 1,
      $title,
      $content,
      $id_user
    );

    // write the log to the file
    file_put_contents('test4.log', $log, FILE_APPEND);


    // DEBUG [4dbsmaster]: tell me about the result
    printf("\n\x1b[2m\x1b[33m[DB](TEST4|FAKER): title (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) and content (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) have been added to the database successfully 4 id_user (\x1b[0m\x1b[1m%d\x1b[2m\x1b[33m) :) \x1b[0m\n", 
      (strlen($title) > 10) ? substr($title, 0, 10) . '...' : $title, 
      (strlen($content) > 20) ? substr($content, 0, 20) . '...' : $content, 
      $id_user);

  }


  // DEBUG [4dbsmaster]: tell me about it ;)
  printf("\x1b[35m[DB] (TEST4|FAKER): %d books have been added to the database!!! \x1b[0m", $rowsToPopulate);

endif;
// <- ========[ End of Test #4 ]===========
