<?php 
session_start();

// if (!isset($_SESSION['username'])) {
//   echo "<script>window.location.href='http://localhost/read2rent/login.php';
// 				  alert('you have to register first!');
// 				 </script>";
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <link rel="stylesheet" href="dashboard.css">
</body>
</html>
<template id="book-template">
    <style>
      /* Layout Container */
      :host {
        container-type: inline-size;
        cursor: grab;
        display: block;
      }
      
      /* Base Styles */
      ::slotted(img) {
        display:block;
        width:100%;
        height: auto;
        border-radius: 0px 2px 2px 0px;
        background-color: var(--cover-color);
      }
      .book {
        font-size: var(--font-size, 1rem);
        font-weight: 400;
      }
      .meta {
        line-height: 1.3;
      }
      .title {
        font-size: 1.25em;
        font-family: "Merriweather", serif;
        margin-bottom:.5rem;
      }
      .author {
        font-size: .875em;
        font-family: sans-serif;
        margin: .5rem 0 1rem;
      }
      .btn {
        display: none;
        padding: 1em 1.5em;
        color: #FFF;
        background-color: #222;
        border:0;
        border-radius: 2em;
        font-size: 1rem;
      }
      
      /* Small Variant */
      @container (max-width: 200px) {
        .book {
          --font-size: .5rem;
        }
        .author {
          display: none;
        }
      }
      
      /* Medium Variant */
      @container ((min-width: 201px) and (max-width: 399px)) {
        .book {
          --font-size: 1rem;
          display: grid;
          align-items: start;
          grid-template-columns: 1fr 1fr;
          gap: 1rem;
        }
      }
      
      /* Large Variant */
      @container (min-width: 400px) {
        ::slotted(img) {
          transform: translateZ(40px);
          box-shadow: 5px 5px 20px rgba(0,0,0,0.1);
        }
        .book {
          --font-size: 1.75rem;
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          gap: 2rem;
          padding: 2rem;
        }
        .image {
          perspective:1000px;
          flex: 0 1 20rem;
        }
        .front {
          position: relative;
          transition: transform .5s ease;
          transform-style: preserve-3d;
          transform: rotateY(-25deg);
          
        }
        .front::before {
          position: absolute;
          content: ' ';
          left: 100%;
          top: 1%;
          width: 80px;
          height: 98%;
          transform: translate(-55%,0) rotateY(90deg);
          background: linear-gradient(
      90deg
      , #fff 0%, #f9f9f9 5%, #fff 10%, #f9f9f9 15%, #fff 20%, #f9f9f9 25%, #fff 30%, #f9f9f9 35%, #fff 40%, #f9f9f9 45%, #fff 50%, #f9f9f9 55%, #fff 60%, #f9f9f9 65%, #fff 70%, #f9f9f9 75%, #fff 80%, #f9f9f9 85%, #fff 90%, #f9f9f9 95%, #fff 100% );
        }
        .front::after {
          position: absolute;
          top: 0;
          left: 1%;
          content: ' ';
          width: 100%;
          height: 100%;
          transform: translateZ(-40px);
          background-color: var(--cover-color, #000);
          border-radius: 0 2px 2px 0;
          box-shadow: -10px 0 50px 10px rgba(0,0,0,0.3);
        }
        .btn {
          display: inline-block;
        }
        .btn:hover {
        background-color: #444; /* Change background color on hover */
        transform: scale(1.1); /* Scale up the button on hover */
        }
      }

    </style>
    <article class="book">
      <div class="image">
        <div class="front">
          <slot name="cover"></slot>
        </div>
      </div>
      <div class="meta">
        <h2 class="title"><slot name="title"></slot></h2>
        <p class="author"><slot name="author"></slot></p>
        <button class="btn" onclick="handleButtonClick()">Get now</button> 
      </div>
    </article>
  </template>
    <!-- END BOOK TEMPLATE -->
  
    
  
  <div class="layout">
    <!-- HEADER  -->
    <header class="header">
      <h1 class="logo">Reads2Rent</h1>
    </header>
  
    <!-- FEATURED STAGE -->
    <div class="stage js-drag-container">
      <h2 class="capitals">Featured</h2>
      
        <book-element color="#52947c">
          <img slot="cover" src="https://assets.codepen.io/1256430/oz.avif" alt="" />
          <span slot="title">The Wizard of Oz</span>
          <span slot="author">L. Frank Baum</span>
        </book-element>
  
    </div>
  
    <!-- MAIN CONTENT AREA -->
    <main class="content">
      <h2 class="capitals">Bestsellers</h2>
  
      <div class="support-notice">
        ⚠️ Your browser does not support Container Queries - Switch to a <a href="https://caniuse.com/css-container-queries">modern browser</a> to see this demo.
      </div>
  
      <div class="booklist js-drag-container">
        
        <book-element color="#BA423D">
          <img slot="cover" src="https://assets.codepen.io/1256430/1984.avif" alt="" />
          <span slot="title">1984</span>
          <span slot="author">George Orwell</span>
        </book-element>
  
        <book-element color="#d2d5dc">
          <img slot="cover" src="https://assets.codepen.io/1256430/little-women.avif" alt="" />
          <span slot="title">Little Women</span>
          <span slot="author">Louisa May Alcott</span>
        </book-element>
  
        <book-element color="#fefef2">
          <img slot="cover" src="https://assets.codepen.io/1256430/fahrenheit-451.avif" alt="" />
          <span slot="title">Fahrenheit 451</span>
          <span slot="author">Ray Bradbury</span>
        </book-element>
        
        <book-element color="#0c0d12">
          <img slot="cover" src="https://assets.codepen.io/1256430/moby-dick.avif" alt="" />
          <span slot="title">Moby Dick</span>
          <span slot="author">Herman Melville</span>
        </book-element>
        
        <book-element color="#1480a8"> 
          <img slot="cover" src="https://assets.codepen.io/1256430/pride.avif" alt="" />
          <span slot="title">Pride and Prejudice</span>
          <span slot="author">Jane Austen</span>
        </book-element>
        
        <book-element color="#cb0f2d">
          <img slot="cover" src="https://assets.codepen.io/1256430/sputnik-sweetheart.avif" alt="" />
          <span slot="title">Sputnik Sweetheart</span>
          <span slot="author">Haruki Murakami</span>
        </book-element>

        <book-element color="#cb0f2d">
          <img slot="cover" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3bVPoh8b-V6Z6HSFi1YyKzl5iKKJwkQzF_wxAxlE3vQ&s" alt="" />
          <span slot="title">Intelligent Investor</span>
          <span slot="author">Benjamin Graham</span>
        </book-element>
  
      </div>

      <h2 class="capitals">Top Rated</h2>
  
      <div class="support-notice">
        ⚠️ Your browser does not support Container Queries - Switch to a <a href="https://caniuse.com/css-container-queries">modern browser</a> to see this demo.
      </div>
  
      <div class="booklist js-drag-container">
        
        <book-element color="#BA423D">
          <img slot="cover" src="https://m.media-amazon.com/images/I/81R2N4PRuUL._AC_UF1000,1000_QL80_.jpg" alt="" />
          <span slot="title">Diary of a Wimpy Kid </span>
          <span slot="author">Jeff Kinney</span>
        </book-element>
  
        <book-element color="#d2d5dc">
          <img slot="cover" src="https://assets.codepen.io/1256430/little-women.avif" alt="" />
          <span slot="title">Little Women</span>
          <span slot="author">Louisa May Alcott</span>
        </book-element>
  
        <book-element color="#fefef2">
          <img slot="cover" src="https://assets.codepen.io/1256430/fahrenheit-451.avif" alt="" />
          <span slot="title">Fahrenheit 451</span>
          <span slot="author">Ray Bradbury</span>
        </book-element>
        
        <book-element color="#0c0d12">
          <img slot="cover" src="https://assets.codepen.io/1256430/moby-dick.avif" alt="" />
          <span slot="title">Moby Dick</span>
          <span slot="author">Herman Melville</span>
        </book-element>
        
        <book-element color="#1480a8"> 
          <img slot="cover" src="https://assets.codepen.io/1256430/pride.avif" alt="" />
          <span slot="title">Pride and Prejudice</span>
          <span slot="author">Jane Austen</span>
        </book-element>
        
        <book-element color="#cb0f2d">
          <img slot="cover" src="https://assets.codepen.io/1256430/sputnik-sweetheart.avif" alt="" />
          <span slot="title">Sputnik Sweetheart</span>
          <span slot="author">Haruki Murakami</span>
        </book-element>

        <book-element color="#cb0f2d">
          <img slot="cover" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3bVPoh8b-V6Z6HSFi1YyKzl5iKKJwkQzF_wxAxlE3vQ&s" alt="" />
          <span slot="title">Intelligent Investor</span>
          <span slot="author">Benjamin Graham</span>
        </book-element>
  
      </div>
    </main>
  
    <!-- 
    <!-- SHOPPING CART -->
    <!-- <div class="cart js-drag-container"> -->
      <!-- <h2 class="capitals"><i class="fas fa-shopping-cart"></i> Cart</h2> -->

      
      <!-- <book-element color="#067682">
        <img slot="cover" src="https://assets.codepen.io/1256430/don-quixote.avif" alt="" />
        <span slot="title">Don Quixote</span>
        <span slot="author">Miguel de Cervantes</span>
      </book-element> -->
  
    </div> -->
  </div>

  <!-- HTML for the modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Enter your details</h2>
      <form id="purchaseForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
  
   CSS for the modal 
  <style>
    /* The Modal */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
    }
    
    /* Modal Content/Box */
    .modal-content {
        background-color: #fff;
        margin: 5% auto; /* 5% from the top and centered */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        width: 80%; /* Could be more or less, depending on screen size */
    }
    
    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
        color: #333;
        text-decoration: none;
        cursor: pointer;
    }
    
    /* Modal Title */
    .modal-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    /* Form Styles */
    .modal-form label {
        font-weight: bold;
    }
    
    .modal-form input[type="text"],
    .modal-form input[type="email"],
    .modal-form button[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-top: 8px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    .modal-form button[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    
    .modal-form button[type="submit"]:hover {
        background-color: #45a049;
    }
    </style>
  
   JavaScript to control the modal 
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");
  
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
  
    // When the user clicks the button, open the modal
    function handleButtonClick() {
      modal.style.display = "block";
    }
  
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  
    // Function to handle form submission
    document.getElementById("purchaseForm").onsubmit = function(event) {
      event.preventDefault(); // Prevent default form submission
  
      // Get form data
      var formData = new FormData(event.target);
      var name = formData.get("name");
      var email = formData.get("email");
  
      // You can perform further actions with the form data here, such as validation, sending data to a server, etc.
      console.log("Name: " + name);
      console.log("Email: " + email);
  
      // Close the modal after form submission
      modal.style.display = "none";
    };
  </script>

 <!-- Logout Button 
<button method="GET" id="logoutButton"  style="
  position: fixed;
  top: 0.90rem; /* Changed from bottom to top */
  right: 5rem;
  padding: 0.70rem 1rem;
  background-color: #000000;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  font-size: 0.95rem;
  z-index: 1000;
  transition: background-color 0.3s ease, transform 0.3s ease;
">
  <i class="fas fa-sign-out-alt"></i> 
</button>
<script>
  const logoutButton = document.getElementById('logoutButton');
  logoutButton.addEventListener('click', logout);
  function logout() {
  window.location.href = 'http://localhost/read2rent/login.php';
  <?php session_destroy();
  unset($_SESSION['username']);
?>
  alert('you have succesfully logout!');
  }
  </script>
   INCLUDE DRAGULA.JS 
  <script src="https://unpkg.com/dragula@3.7.2/dist/dragula.min.js"></script>
  <script src="dashboard.js"></script>


  <button style="position: fixed; top: 1rem; right: 1rem; padding: 0.65rem; z-index: 1000; background-color: rgb(0, 0, 0); color: rgb(255, 255, 255); border: none; border-radius: 2px; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 8px; cursor: pointer; font-size: 1rem; transition: background-color 0.3s ease 0s, transform 0.3s ease 0s;"><i class="fas fa-moon"></i></button> -->

<!-- Logout Button -->
<button id="logoutButton" style="
  position: fixed;
  top: 0.90rem;
  right: 5rem;
  padding: 0.70rem 1rem;
  background-color: #000000;
  color: #ffffff;
  border: none;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  font-size: 0.95rem;
  z-index: 1000;
  transition: background-color 0.3s ease, transform 0.3s ease;
">
  <i class="fas fa-sign-out-alt"></i> 
</button>

<script>
  const logoutButton = document.getElementById('logoutButton');
  logoutButton.addEventListener('click', logout);
  function logout() {
    window.location.href = 'http://localhost/read2rent/login.php';
    <?php
      session_destroy();
      unset($_SESSION['username']);
    ?>
    alert('you have successfully logged out!');
  }
</script>

<!-- Include Dragula.js -->
<script src="https://unpkg.com/dragula@3.7.2/dist/dragula.min.js"></script>
<script src="dashboard.js"></script>

<!-- Dark Mode Button -->
<button style="
  position: fixed;
  top: 1rem;
  right: 1rem;
  padding: 0.65rem;
  z-index: 1000;
  background-color: rgb(0, 0, 0);
  color: rgb(255, 255, 255);
  border: none;
  border-radius: 2px;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 8px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease, transform 0.3s ease;
">
  <i class="fas fa-moon"></i>
</button>
  
