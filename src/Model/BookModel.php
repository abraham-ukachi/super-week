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
* @name Book Model
* @test test/book_model.php
* @file BookModel.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Example usage:
*   
*   1+|> // Get all books using the `findAll()` method
*    -|> 
*    -|> use App\Model\BookModel;
*    -|>
*    -|> $bookModel = new BookModel();
*    -|> $books = $bookModel->findAll();
*    -|> 
*/


// declare a namespace for this `BookModel` class
namespace App\Model;


// use these classes
use App\Model\Helper\Database;
use pdo;
// use datetime;
// use PDO;
// use PDOException;


/**
 * A class that represents our `books` table in the database
 * NOTE: This class currently extends a Database class
 *
 * TODO: Create an abstract Model class that extends the abstract Database class, 
 *       which in turn should implement a DatabaseInterface
 */
class BookModel extends Database {

  // Declare some constants


  // Declare some public properties


  // Declare some private properties
  private ?int $id = null;
  private ?string $title = null;
  private ?string $content = null;
  private ?int $userId = null;


  /**
   * User constructor.
   * NOTE: This constructor is called when a new instance of the User class is created
   *
   * @param string|null $title - the title of the book
   * @param string|null $content - the content of the book
   * @param int|null $userId - the id of the user who created the book
   * @param int|null $id - the id of the book
   */
  public function __construct(?string $title = null, ?string $content = null, ?int $userId = null, ?int $id = null) {
    // call the parent/Database constructor
    parent::__construct(Database::TYPE_PDO); // <- via PDO

    // connect to the database 
    $this->dbConnection();


    // If an $id is provided...
    if ($id) {
      // ...find the book by its id
      $book = $this->findById($id);
      // and populate the properties of this book
      $this->populateProps($book);

    } else if ($title && $content && $userId) { // <- all parameters (ie. title, content & userId) are provided...
      // ...create a new book
      $book = $this->create($title, $content, $userId);
      // and populate the properties of this book
      $this->populateProps($book);
    }

    
  }


  // PUBLIC SETTERS
  
  /**
   * Sets the title of the book
   * NOTE: This method updates the `title` property only after 
   * updating the `title` column in the database w/ the given $title
   * 
   * @param string $title - the title of the book to set / update
   * @param int|null $id - the id of the book to update
   *
   * @return void
   */
  public function setTitle(string $title, ?int $id = null): void {
    // If no $id is provided...
    $id = $id ?? $this->id; // <- use the current id


    // create an sql query named `update_title_query`,
    $update_title_query = sprintf(<<<SQL
      UPDATE %s
      SET %s = :title
      WHERE %s = :id
    SQL,
    
    // update (table)
    $this::TABLE_BOOKS,

    // fields
    $this::FIELD_TITLE, // <- set

    $this::FIELD_ID // <- where

    );
    
    try { // <- try to prepare and execute the `update_title_query`
      
      // prepare the `update_title_query` as a PDO statement
      $pdo_stmt = $this->pdo->prepare($update_title_query);
      
      // execute our PDO statement
      $pdo_stmt->execute([
        ':title' => $title,
        ':id' => $id
      ]);

      // Now, we can set/update the `title` property
      $this->title = $title;

    } catch (PDOException $e) { // <- catch any PDO exceptions
      // log the error message
      error_log($e->getMessage());
    }

  }
  
  
  /**
   * Sets the content of the book
   * NOTE: This method updates the `content` property only after 
   * updating the `content` column in the database w/ the given $lastName
   * 
   * @param string $content - the content of the book to set / update
   * @param int|null $id - the id of the book to update
   *
   * @return void
   */
  public function setContent(string $content, ?int $id = null): void {
    // If no $id is provided...
    $id = $id ?? $this->id; // <- use the current id

    // create an sql query named `update_content_query`,
    $update_content_query = sprintf(<<<SQL
      UPDATE %s
      SET %s = :content
      WHERE %s = :id
    SQL,
    
    // update (table)
    $this::TABLE_BOOKS,

    // fields
    $this::FIELD_CONTENT, // <- set
    $this::FIELD_ID // <- where

    );
    
    try { // <- try to prepare and execute the `update_content_query`
      
      // prepare the `update_content_query` as a PDO statement
      $pdo_stmt = $this->pdo->prepare($update_content_query);
      
      // execute our PDO statement
      $pdo_stmt->execute([
        ':content' => $content,
        ':id' => $id
      ]);

      // Now, we can set the `content` property
      $this->content = $content;

    } catch (PDOException $e) { // <- catch any PDO exceptions
      // log the error message
      error_log($e->getMessage());
    }

  }


  // PUBLIC GETTERS


  /**
   * Returns a random book
   *
   * Example usage:
   *  -|> use App\Model\BookModel;
   *  -|>
   *  -|> $bookModel = new BookModel();
   *  -|> $book = $bookModel->getRandom();
   *  -|>
   *  -|> echo $book->getTitle();
   *
   * @return BookModel|null - a random book
   */
  public function getRandom(): ?BookModel {
    // create an sql query named `get_random_book_query`,
    $get_random_book_query = sprintf(<<<SQL
      SELECT %s 
      FROM %s
      ORDER BY RAND()
      LIMIT 1
    SQL,

    // select (field)
    self::FIELD_ID,

    // select (table)
    self::TABLE_BOOKS

    );
    
    try { // <- try to prepare and execute the `get_random_book_query`
      
      // prepare the `get_random_book_query` as a PDO statement
      $pdo_stmt = $this->pdo->prepare($get_random_book_query);
      
      // execute our PDO statement
      $pdo_stmt->execute();

      // fetch the book as an associative array
      $book = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

      // return a new BookModel instance
      return new BookModel(null, null, null, $book[self::FIELD_ID]);

    } catch (PDOException $e) { // <- catch any PDO exceptions
      // log the error message
      error_log($e->getMessage());
    }
  }




  /**
   * Returns a total count of all the books in the database
   *
   * @param int|null $userId - the id of the user who created the book
   *
   * @return int 
   */
  public function countAll(?int $userId = null): int {
    // find all the books in the database as `allBooks`
    $allBooks = $this->findAll($userId);
    // return `allBooks` count
    return count($allBooks);
  }

  
  /**
   * Returns the id of the book
   *
   * @return int
   */
  public function getId(): int {
    return $this->id ?? -1;
  }


  /**
   * Returns the title of the book
   *
   * @return string 
   */
  public function getTitle(): string {
    return $this->title ?? '';
  }

  /**
   * Returns the content of the book
   *
   * @return string 
   */
  public function getContent(): string {
    return $this->content ?? '';
  }


  /**
   * Returns the id of the user who created the book
   *
   * @return int
   */
  public function getUserId(): int {
    return $this->userId ?? -1;
  }


  // PUBLIC METHODS


  /**
   * Method used to find all the books in the database
   * NOTE: If a $userId is provided, only the books created by that user will be returned
   *
   * @param int|null $userId - the id of the user who created the book
   * @param int|null $limit - the max number of books to return
   *
   * @return array - an associative array of all the books in the database
   */
  public function findAll(?int $userId = null, ?int $limit = null): array {
    // create an sql query named `find_books_query`,
    // using a heredoc syntax - https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
    $find_books_query = sprintf(<<<SQL
      SELECT %s, %s, %s, %s
      FROM %s
    SQL,

    // select (fields)
    self::FIELD_ID,
    self::FIELD_TITLE,
    self::FIELD_CONTENT,
    self::FIELD_ID_USER,

    // from (table)
    self::TABLE_BOOKS
    );

    // If a $userId is provided...
    if ($userId) {
      // ...append a WHERE clause to the `find_books_query`
      $find_books_query .= sprintf(<<<SQL
        WHERE %s = :userId
      SQL,

      // where (field)
      self::FIELD_ID_USER
      );
    }

    // If a $limit is provided...
    if ($limit) {
      // ...append a LIMIT clause to the `find_books_query`
      $find_books_query .= sprintf(<<<SQL
        LIMIT %d
      SQL,

      // limit (number)
      $limit
      );
    }

    // prepare the `find_books_query` as a PDO statement
    $pdo_stmt = $this->pdo->prepare($find_books_query);

    // execute our PDO statement
    $pdo_stmt->execute($userId ? [':userId' => $userId] : []);

    // fetch all the results from `pdo_stmt` as an associative array
    $results = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

    // HACK: Refactor the titles and contents in `$results` to prevent XSS attacks
    $results = array_map(function($result) {
      return [
        self::FIELD_ID => $result[self::FIELD_ID],
        self::FIELD_TITLE => htmlspecialchars($result[self::FIELD_TITLE]),
        self::FIELD_CONTENT => htmlspecialchars(strip_tags($result[self::FIELD_CONTENT])),
        self::FIELD_ID_USER => $result[self::FIELD_ID_USER]
      ];
    }, $results);

    // return the results
    return $results;
  }




  /**
   * Creates a new book with the given parameters
   * NOTE: This method inserts a new book into the database
   *
   * @param string $title - the title of the book to create
   * @param string $content - the content of the book to create
   * @param int $userId - the id of the user who created the book
   *
   * @return array|false - Returns an array including the book's id of the newly created book, or false if the book was not created
   */
  public function create(string $title, string $content, string $userId): array|false {
    // Initialize the `result` boolean variable
    $result = false;

    // create an sql query named `create_book_query`,
    $create_book_query = sprintf(<<<SQL
      INSERT INTO %s 
        (%s, %s, %s)
      VALUES 
        (:title, :content, :userId)
      SQL,

      // table
      self::TABLE_BOOKS,

      // fields
      self::FIELD_TITLE,
      self::FIELD_CONTENT,
      self::FIELD_ID_USER
    );

    try { // <- try to create a new book

      // prepare the `create_book_query` as a PDO statement
      $pdo_stmt = $this->pdo->prepare($create_book_query);

      // execute our PDO statement with the given parameters
      $pdo_stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':userId' => $userId
      ]);

      // get the last inserted id as `bookId`
      $bookId = $this->pdo->lastInsertId();

      // update the `result` w/ a short-syntax associative array of the new book
      $result = [
        self::FIELD_ID => $bookId,
        self::FIELD_TITLE => $title,
        self::FIELD_CONTENT => $content,
        self::FIELD_ID_USER => $userId
      ];

    } catch (PDOException $e) { // <- catch any PDOException errors

      // log the error
      error_log($e->getMessage());

    }

    // return the `result`
    return $result;
  }



  /**
   * Method used to find a book with the given `$bookId` 
   *
   * @param int $bookId - the id to find the book with
   *
   * @return array|false - Returns an array containing the book's details, or FALSE if the user was not found
   *
   */
  public function findById(string $bookId): array|false {
    // Initialize the `result` boolean variable
    $result = false;


    // create a `find_book_by_id_query` sql query
    $find_book_by_id_query = sprintf(<<<SQL
      SELECT %s, %s, %s, %s
      FROM %s
      WHERE %s = :bookId

    SQL,

    // select (fields)
    self::FIELD_ID,
    self::FIELD_TITLE,
    self::FIELD_CONTENT,
    self::FIELD_ID_USER,

    // from (table)
    self::TABLE_BOOKS,

    // where (field)
    self::FIELD_ID

    );

    try { // <- try to prepare and execute our query

      // prepare the `find_book_by_id_query` as a PDO statement
      $pdo_stmt = $this->pdo->prepare($find_book_by_id_query);

      // execute our PDO statement with the given parameters
      $pdo_stmt->execute([
        ':bookId' => $bookId
      ]);
      
      // fetch the results from `pdo_stmt` as an associative array
      $result = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) { // <- catch any PDOException errors

      // log the error
      error_log($e->getMessage());

    }

    // return the `result`
    return $result;
  }




  // PRIVATE SETTERS

  // PRIVATE GETTERS

  // PRIVATE METHODS

  /**
   * Method used to populate the `bookModel` properties with the given `$book`
   *
   * @param array $book - the user to populate the properties with
   *
   * @return void
   * @private
   */
  private function populateProps(array $book): void {
    // set the `id` property to the `id` of the given `$book`
    $this->id = $book[self::FIELD_ID];
    
    // set the `title` property to the `title` of the given `$book`
    $this->title = $book[self::FIELD_TITLE];
    
    // set the `content` property to the `content` of the given `$book`
    $this->content = $book[self::FIELD_CONTENT];
    
    // set the `userId` property to the `userId` of the given `$book`
    $this->userId = $book[self::FIELD_ID_USER];

  }

}


