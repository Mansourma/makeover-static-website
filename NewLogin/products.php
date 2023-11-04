<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "MOHAmed.@98765";
$dbname = "makeover";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve products from database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Generate HTML for product cards
while ($row = mysqli_fetch_assoc($result)) {
  echo '<div class="product-card">';
  echo '<img src="' . $row["image"] . '" alt="Product Image">';
  echo '<h3>' . $row["name"] . '</h3>';
  echo '<p>' . $row["price"] . '</p>';
  echo '<div class="stars" id="' . $row["id"] . '-stars">';
  for ($i = 0; $i < $row["rating"]; $i++) {
    echo '<i class="fa fa-star"></i>';
  }
  for ($i = $row["rating"]; $i < 5; $i++) {
    echo '<i class="fa fa-star-o"></i>';
  }
  echo '</div>';
  echo '<button class="btn btn-primary" onclick="addCartItem({ id: \'' . $row["id"] . '\', name: \'' . $row["name"] . '\', price: \'' . $row["price"] . '\', image: \'' . $row["image"] . '\' })">Add to Cart</button>';
  echo '<button class="btn btn-secondary" onclick="showRatingForm(\'' . $row["id"] . '\')">Rate Product</button>';
  echo '<div class="rating-form" id="' . $row["id"] . '-rating-form" style="display: none;">';
  echo '<h4>Rate ' . $row["name"] . '</h4>';
  echo '<div class="stars">';
  for ($i = 1; $i <= 5; $i++) {
    echo '<i class="fa fa-star" onclick="rateProduct(\'' . $row["id"] . '\', ' . $i . ')"></i>';
  }
  echo '</div>';
  echo '<button class="btn btn-primary" onclick="submitRating(\'' . $row["id"] . '\')">Submit Rating</button>';
  echo '<button class="btn btn-secondary" onclick="hideRatingForm(\'' . $row["id"] . '\')">Cancel</button>';
  echo '</div>';
  echo '</div>';
}

// Close database connection
mysqli_close($conn);
?>
