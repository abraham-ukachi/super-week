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
* @name Book Model - Test
* @file book_model.php
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


// use the `UserModel` & `BookModel` from the `App\Model` namespace
use App\Model\UserModel;
use App\Model\BookModel;
use Faker\Factory;

// using some PHP core classes
// use pdo;
// use pdoexception;


// Create an object of both `UserModel` `BookModel` class as `bookModel`
$userModel = new UserModel();
$bookModel = new BookModel();
$faker = Factory::create('en_US'); // <- use the factory to create a Faker\Generator instance named `$faker`

// DEBUG [4dbsmaster]: tell me about it ;)
printf("\n\x1b[34m[BookModel - Test]: Welcome 👋🏽 !!!\x1b[0m\n");



// TODO: define some variables here ;)


// check if there's a test argument passed to script
$hasTestArg = isset($argc) ? true : false;
// get the 1st argument variable as `testArg1`
$testArg1 = isset($argv[1]) ? $argv[1] : '';
// get the 2nd argument variable as `testArg2`
$testArg2 = isset($argv[2]) ? $argv[2] : '';
// get the 3rd argument variable as `testArg3`
$testArg3 = isset($argv[3]) ? $argv[3] : '';
// get the 4th argument variable as `testArg4`
$testArg4 = isset($argv[4]) ? $argv[4] : '';


// ===================== TEST #1 ========================
// =================[ FIND ALL BOOKS ]===================
// ======================================================
// +++ example: php book_model.php findAll 3

// If there's a test argument and it's `findAll` or `test1`...
if ($hasTestArg && in_array($testArg1, ['findAll', 'test1'])) :
  // ...use the second argument as `userId`
  $userId = !empty($testArg2) ? $testArg2 : null;
  
  // ...get all books using the `findAll()` method
  $allBooks = $bookModel->findAll($userId);
  
  // print the list of all books
  printf("\n\x1b[33m[BookModel - Test]: Here's a list of all books %s:\x1b[0m\n", $userId ? "of user #$userId" : '');

  print_r($allBooks);
    

endif; 
// <- ========[ End of Test #1 / findAll ]===========




// ===================== TEST #2 ========================
// ================[ CREATE A NEW BOOK ]=================
// ======================================================
// +++ example: php book_model.php create "My Book Title" "My Book Content" 3

if ($hasTestArg && in_array($testArg1, ['create', 'test2'])) :
  // get a total number of users as `totalUsers`
  $totalUsers = $userModel->countAll();

  // generate some fake book data
  $title = $testArg2 ?? $faker->sentence(3);
  $content = $testArg3 ?? $faker->sentence(10);
  $userId = $testArg4 ?? $faker->numberBetween(1, $totalUsers);
  
  // create a new book with the fake data
  $newBook = $bookModel->create($title, $content, $userId);

  // If a new boo was created...
  // TODO: Use a try/catch block to catch any exception
  if ($newBook) {
    // ...IDEA: log this book in a `test2.log` file

    // Create a `log` string variable
    $log = sprintf(<<<LOG
    
    === "[New Book Created]" ===
    id: %d
    title: %s
    content: %s
    id_user: %d
    =========================

    LOG,

    $newBook['id'],
    $newBook['title'],
    $newBook['content'],
    $newBook['id_user']

    );

    // Append this `log` in a `test2.log` file
    file_put_contents('test2.log', $log, FILE_APPEND);

    // find the user with the specified `userId`
    $user = $userModel->findById($userId);
    
    // DEBUG [4dbsmaster]: tell me about the new book
    printf("\n\x1b[2m\x1b[33m[BOOK-MODEL](TEST2|CREATE): A new book with title (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) and content (\x1b[0m\x1b[4m\x1b[33m%s\x1b[0m\x1b[2m\x1b[33m) of \x1b[0m\x1b[1muser #%d\x1b[0m\x1b[2m\x1b[33m (%s) have been added to the database successfully :) \x1b[0m\n", $title, $content, $userId, $user['first_name']);

  } else { // <- error creating new book

    // DEBUG [4dbsmaster]: tell me about the error
    printf("\n\x1b[2m\x1b[31m[BOOK-MODEL](TEST2|CREATE): Failed to create a new book :(\x1b[0m\n");
  }

endif; 
// <- ========[ End of Test #2 ]===========









// ===================== TEST #3 ========================
// ===============[ FIND A BOOK BY ID ]==================
// ======================================================

if ($hasTestArg && in_array($testArg1, ['findById', 'test3'])) :
  // get a total number of books as `totalBooks`
  $totalBooks = $bookModel->countAll();
  
  // get the 2nd argument variable as `bookId`
  $bookId = isset($testArg2) ? $testArg2 : $faker->numberBetween(1, $totalBooks); // <- if it exists, use it, else use an empty string

  // Initialize a `log` variable
  $log = sprintf(<<<LOG
  
  ==== "[Book ID NOT Provided]" ====
  book_id: ???
  date_time: %s
  ======================

  LOG, date('Y-m-d H:i:s'));


  // If the `bookId` is not empty...
  if (!empty($bookId)) {
    // ...find the book with that id as `book`
    $book = $bookModel->findById($bookId);

    
    // if a book was found with that id...
    if ($book) { 
    // ...TEST [4dbsmaster]: tell me about the book
    printf("\n\x1b[2m\x1b[33m[BOOK-MODEL](TEST3|FINDBYID): Here's the book with id (\x1b[0m\x1b[4m\x1b[33m%d\x1b[0m\x1b[2m\x1b[33m):\x1b[0m\n", $bookId);

    // print the book
    print_r($book);


    // Update the `$log`
    $log = sprintf(<<<LOG
    
    ==== "[Book Found]" ====
    book_id: %d
    date_time: %s
    ======================

    LOG, $bookId, date('Y-m-d H:i:s'));

    } else { // <- no book found with that id

      // DEBUG [4dbsmaster]: tell me about the error
      printf("\n\x1b[2m\x1b[34m[BOOK-MODEL](TEST3|FINDBYID): \x1b[0m\x1b[34mNo book found with id (\x1b[0m\x1b[4m\x1b[34m%d\x1b[0m\x1b[2m\x1b[34m) :( \x1b[0m\n", $bookId);

      
      // Update the `$log`
      $log = sprintf(<<<LOG
      
      ==== "[Book NOT Found]" ====
      book_id: %d
      date_time: %s
      ======================

      LOG, $bookId, date('Y-m-d H:i:s'));

    }


  } else { // <- no book provided

    // TEST [4dbsmaster]: tell me about the error
    printf("\n\x1b[2m\x1b[31m[BOOK-MODEL](TEST3|FINDBYID): \x1b[0m\x1b[31mNo book provided :( \x1b[0m\n");

  }


  // save the `$log` in a `test3.log` file
  file_put_contents('test3.log', $log, FILE_APPEND);

endif; 
// <- ========[ End of Test #3 ]===========




// ======================= TEST #4 ========================
// =================[ GET A RANDOM BOOK ]==================
// ========================================================

if ($hasTestArg && in_array($testArg1, ['getRandom', 'test4'])) :
  
  // get a random book as `randomBook`
  $randomBook = $bookModel->getRandom();
  
  // get the id of the random book as `randomBookId`
  $randomBookId = $randomBook->getId();
  // get the title of the random book as `randomBookTitle`
  $randomBookTitle = $randomBook->getTitle();
  // get the content of the random book as `randomBookContent`
  $randomBookContent = $randomBook->getContent();
  // get the id of the user who created the random book as `randomBookUserId`
  $randomBookUserId = $randomBook->getUserId();
  
   
  // Initialize a `log` variable
  $log = sprintf(<<<LOG
  
  ==== "[Random Book 😜]" ====
  id: %d
  title: %s
  conent: %s
  id_user: %d
  ----------------------------
  date_time: %s
  ============================

  LOG, 
  $randomBookId,
  $randomBookTitle,
  $randomBookContent,
  $randomBookUserId,
  date('Y-m-d H:i:s'));

  
  // log the result in a `test4.log` file
  file_put_contents('test4.log', $log, FILE_APPEND);


  // ...TEST [4dbsmaster]: tell me about the random book
  printf("\n\x1b[2m\x1b[33m[BOOK-MODEL](TEST4|GET-RANDOM): Random book retrieved from database: \n
    \x1b[0;33mid: \x1b[0m%d\n
    \x1b[0;33mtitle: \x1b[0;2m%s\n
    \x1b[0;33mcontent: \x1b[0;2m%s\n
    \x1b[0;33mid_user: \x1b[0m%d\n
    \n
  ", $randomBookId, $randomBookTitle, $randomBookContent, $randomBookUserId);


endif; 
// <- ========[ End of Test #4 ]===========







