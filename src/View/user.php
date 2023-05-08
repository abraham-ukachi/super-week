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
* @name Home Page
* @file home.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Usage:
*   1-|> open http://localhost/super-week/users
* 
*/


/*
* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
* MOTTO: We'll always do more 😜!!!
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

  <!-- PHP (1): If the user was found... -->
  <?php if ($userFound): ?>
  <!-- ...PHP (1): Show the title w/ user id -->

  <!-- Title -->
  <title>User #<?= $userId ?> | Super Week</title>

  <?php else: ?> <!-- (Else|PHP (1)) -->

  <!-- Title -->
  <title>User NOT found :( | Super Week</title>

  <?php endif; ?>
  <!-- End of PHP (1) -->


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
  <!-- <script type="module" src="assets/scripts/home.js" defer></script> -->
  
</head>
<!-- End of HEAD -->
  
<body>
  <code><?= APP_NAME ?> <span>Job 03</span></code>
  <h1>User #<?= $userId ?></h1>


  <!-- PHP (2): If the user was found... -->
  <?php if ($userFound): ?>
  <!-- ...PHP (2): Show the user's details in JSON format -->
  
  <pre><?= $userJSON ?></pre>

  <?php else: ?> <!-- (Else|PHP (1)) -->

  <!-- Status Messages -->
  <div class="status-messages">
    <!-- Error - Status Message -->
    <div class="error status-message">
      <span class="material-icons icon">error_outline</span>
      <p class="message">User #<?= $userId ?> does not exist!</p>
    </div>

  </div>
  <!-- End of Status Messages -->

  <?php endif; ?>
  <!-- End of PHP (1) -->

</body>

</html>
<!-- End of HTML -->
