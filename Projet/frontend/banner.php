<?php
function renderMenuToHTML($currentPageId)
{
  if (isset($_SESSION['login'])) {
    $menuItems = array(
      'index.php' => 'Home',
      'recipes.php' => 'Recipes',
      'signup.php' => 'Sign Up',
      'news.php' => 'News',
      'objectives.php' => 'My Objectives',
      'dashboard.php' => 'Mon Dashboard'
    );
  } else {
    $menuItems = array(
      'index.php' => 'Home',
      'recipes.php' => 'Recipes',
      'signup.php' => 'Sign Up',
      'news.php' => 'News',
    );
  }

  echo '<header role="banner" style="background-color: rgba(0,0,0,0.3);">';
  echo '<nav class="navbar navbar-expand-md navbar-dark bg-dark">';
  echo '<div class="container">';
  echo '<a class="navbar-brand" href="index.php">EAT\'S ME</a>';
  echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">';
  echo '<span class="navbar-toggler-icon"></span>';
  echo '</button>';

  echo '<div class="collapse navbar-collapse" id="navbarsExample05">';
  echo '<ul class="navbar-nav ml-auto pl-lg-5 pl-0">';
  echo '<li class="nav-item">';

  foreach ($menuItems as $menuItemLink => $menuItemName) {
    if ($menuItemLink == $currentPageId) {
      echo '<li class="nav-item">';
      echo '<a class="nav-link active" href="' . $menuItemLink . '">' . $menuItemName . '</a></li>';
    } else {
      echo '<li class="nav-item">';
      echo '<a class="nav-link" href="' . $menuItemLink . '">' . $menuItemName . '</a></li>';
    }
  }

  echo '</ul>';

  echo '<ul class="navbar-nav ml-auto">';
  echo '<li class="nav-item cta-btn">';

  // On vérifie si l'utilisateur est connecté
  if (isset($_SESSION['login'])) {
    echo '<a class="nav-link" href="logout.php">Sign Out</a>';
  } else {
    echo '<a class="nav-link" href="signin.php">Sign in</a>';
  }

  echo '</li>';
  echo '</ul>';

  echo '</div>';
  echo '</div>';
  echo '</nav>';
  echo '</header>';
}
