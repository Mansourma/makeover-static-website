// search function

const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('search-button');

searchButton.addEventListener('click', () => {
  searchProducts(searchInput.value);
});

searchInput.addEventListener('keydown', event => {
  if (event.key === 'Enter') {
    searchProducts(searchInput.value);
  }
});

function searchProducts(query) {
  const products = [ /* an array of all the products */ ];
  const results = [];

  // Calculate the Levenshtein distance between the query and each product title
  products.forEach(product => {
    const distance = levenshteinDistance(query.toLowerCase(), product.title.toLowerCase());

    // If the distance is less than or equal to 3 (meaning the user misspelled the word),
    // add the product to the results array
    if (distance <= 3) {
      results.push(product);
    }
  });

  console.log(results); // replace this with code to display the results to the user
}

// Function to calculate the Levenshtein distance between two strings
function levenshteinDistance(str1, str2) {
  const matrix = [];

  for (let i = 0; i <= str2.length; i++) {
    matrix[i] = [i];
  }

  for (let j = 0; j <= str1.length; j++) {
    matrix[0][j] = j;
  }

  for (let i = 1; i <= str2.length; i++) {
    for (let j = 1; j <= str1.length; j++) {
      if (str2.charAt(i - 1) === str1.charAt(j - 1)) {
        matrix[i][j] = matrix[i - 1][j - 1];
      } else {
        matrix[i][j] = Math.min(
          matrix[i - 1][j - 1] + 1, // substitution
          matrix[i][j - 1] + 1, // insertion
          matrix[i - 1][j] + 1 // deletion
        );
      }
    }
  }

  return matrix[str2.length][str1.length];
};
// create a search products function
// create a search input
// create a search button
// add event listener to search button
// add event listener to search input
// create a function to calculate the levenshtein distance between two strings
// create a results array
// create a products array
// loop through the products array
// calculate the levenshtein distance between the query and each product title
// if the distance is less than or equal to 3 (meaning the user misspelled the word)
// add the product to the results array
// display the results to the user by replacing console.log with code
// to display the results to the user
// Path: index.html
// search function


