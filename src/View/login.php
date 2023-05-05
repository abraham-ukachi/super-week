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
* @name Login Page
* @file login.php
* @author: Abraham Ukachi <abraham.ukachi@laplateforme.io>
* @version: 0.0.1
* 
* Usage:
*   1-|> open http://localhost/super-week/login
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
  
  <!-- Title -->
  <title>Login | Super Week</title>


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
  <code><?= APP_NAME ?> <span>Job 02.4</span></code>
  <h1>Log in</h1>

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




  <!-- Login Form -->
  <form id="loginForm">

    <!-- Email - Input Wrapper -->
    <div class="input-wrapper email">
      <!-- Email - Label -->
      <label for="emailInput" raised>Email</label>
      <!-- Email - Input -->

      <input id="emailInput" required
        type="email" 
        name="email"  
        placeholder="Enter your email"
        minlength="8"
        maxlength="60"
        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
      />

      <!-- Pattern explanation:
      
      1. ^ : Start of the string <<<
      2. [a-zA-Z0-9._%+-]+ : One or more alphanumeric characters, dots, 
         underscores, hyphens, percentage signs, or plus signs <<<
      3. @ : The "@" symbol <<<
      4. [a-zA-Z0-9.-]+ : One or more alphanumeric characters, dots, or hyphens for the domain name <<<
      5. \. : A literal "." character to separate the domain name and the top-level domain <<<
      6. [a-zA-Z]{8,} : Eight or more alphabetical characters for the top-level domain <<<
      7. $ : End of the string <<<
      -->

      <!-- Input Indicator -->
      <div class="input-indicator"><span bar></span><span val></span></div>
    </div>
    
    
    <!-- Password - Input Wrapper -->
    <div class="input-wrapper password">
      <!-- Password - Label -->
      <label for="passwordInput" raised>Password</label>
      <!-- Password - Input -->
      <input id="passwordInput" required
        type="password" 
        name="password"
        placeholder="Enter your password" 
      />
      <!-- Input Indicator -->
      <div class="input-indicator"><span bar></span><span val></span></div>
    </div>

    
    <!-- Login - Button -->
    <button type="submit" id="loginButton" contained>Log in</button>
    
  </form>
  <!-- End of Login Form -->

</body>

</html>
<!-- End of HTML -->
