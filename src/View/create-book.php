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
* @name Create Book Page
* @file create-book.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Usage:
*   1-|> open http://localhost/super-week/books/write
* 
*/


/*
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
* MOTTO: I'll always do more 😜!!!
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/


?><!DOCTYPE html>
    
<!-- HTML -->
<html lang="en">

<!-- HEAD -->
<head>
  <!-- Our 4 VIP metas -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">
  <meta name="description" content="Super Week is a 7-day school project to help students revisit the basics of PHP autoloading, namespaces, routing, and templating.">
  
  <!-- Title -->
  <title>Create Book | Super Week</title>


  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <!-- Mulish - Font -->
  <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;700&display=swap" rel="stylesheet">
  
  <!-- Material Icons - https://github.com/google/material-design-icons/tree/master/font -->
  <!-- https://material.io/resources/icons/?style=baseline -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

   
  <!-- Base -->
  <base href="/super-week/">
  
   
  <!-- Stylesheet #JIC -->
  <link rel="stylesheet" href="assets/stylesheets/shared-styles.css">
  <!-- <link rel="stylesheet" href="assets/stylesheets/home.css"> -->


  <!-- Script -->
  <script>

    // Let's do some stuff when this page loads...
    window.addEventListener('load', (event) => { 
      // ...do something awesome here ;)
    });
    
  </script>

  <!-- Script #JIC -->
  <script type="module" src="assets/scripts/app.js" defer></script>
  <!-- <script type="module" src="assets/scripts/home.js" defer></script> -->
  
</head>
<!-- End of HEAD -->
  
<body>
  <code><?= APP_NAME ?> <span>Job 03</span></code>
  <h1>New Book</h1>

  <!-- Status Messages -->
  <div class="status-messages">
    <!-- Error - Status Message -->
    <div class="error status-message" hidden>
      <span class="material-icons icon">error_outline</span>
      <p class="message">Error</p>
    </div>

    <!-- Success - Status Message -->
    <div class="success status-message" hidden>
      <span class="material-icons">thumb_up_alt</span>
      <p class="message">Success</p>
      <button contained hidden>Go to login page</button>
    </div>

  </div>
  <!-- End of Status Messages -->




  <!-- Book Form -->
  <form id="bookForm">

    <!-- Title - Input Wrapper -->
    <div class="input-wrapper title-input">
      <!-- Title - Label -->
      <label for="titleInput" raised>Title</label>
      <!-- Title - Input -->
      <input id="titleInput" required 
        type="text" 
        name="title" 
        placeholder="Enter a book title"
        minlength="10"
        maxlength="60"
        pattern="^[a-zA-Z\s\-]+$"
       />

      <!-- Input Indicator -->
      <div class="input-indicator"><span bar></span><span val></span></div>
    </div>
    

    <!-- Content - Input Wrapper -->
    <div class="input-wrapper content">
      <!-- Content - Label -->
      <label for="contentTextArea" raised>Content</label>
      <!-- Content - Text Area -->
      <textarea id="conentTextArea" required
        name="content"  
        placeholder="Write something about your book"
        minlength="20"
        maxlength="500"
      ></textarea>

      <!-- Input Indicator -->
      <div class="input-indicator"><span bar></span><span val></span></div>
    </div>

     
    <!-- Create Book - Button -->
    <button type="submit" id="createBookButton" contained>Create Book As <?= $firstName ?></button>
    
  </form>
  <!-- End of Book Form -->

  <!-- Go To Buttons -->
  <div class="goto-buttons">
    <!-- Go To Books - Button --> 
    <button class="goto-books" contained hidden onclick="() => location.href = 'books'">See All Books</button>

    <!-- Go To Home - Button --> 
    <a href="home"><button class="goto-home" contained hidden>Go To Home Page</button></a>
  </div>

</body>

</html>
<!-- End of HTML -->
