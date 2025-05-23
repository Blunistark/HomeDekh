<!DOCTYPE html><html lang="en" dir="ltr"><head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zubuz || Responsive HTML 5 Template</title>

  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <!--- End favicon-->

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Raleway:wght@600;700&display=swap" rel="stylesheet">
  <!-- End google font  -->

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/slick.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/fontawesome.css">


  <!-- Code Editor  -->

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/app.min.css">
</head>

<body id="body" class="light-mode">

  <div class="zubuz-preloader-wrap">
    <div class="zubuz-preloader">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>



  <!-- <div class="zubuz-sidemenu-wraper">
      <div class="zubuz-sidemenu-column">
        <div class="zubuz-sidemenu-item">
          <p>languages support</p>
          <button class="value-change-btn" id="zubuz-ltr-rtl" type="button"><span>ltl</span><span>rtl</span></button>
          <div class="zubuz-open-close-btn">
            <div class="zubuz-rtl-open">
              <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.3473 3.83574C14.0225 1.05475 17.9775 1.05475 18.6527 3.83574C19.0888 5.63222 21.147 6.48476 22.7257 5.52285C25.1696 4.03378 27.9662 6.83045 26.4772 9.27429C25.5152 10.853 26.3678 12.9112 28.1643 13.3473C30.9452 14.0225 30.9452 17.9775 28.1643 18.6527C26.3678 19.0888 25.5152 21.147 26.4772 22.7257C27.9662 25.1696 25.1696 27.9662 22.7257 26.4772C21.147 25.5152 19.0888 26.3678 18.6527 28.1643C17.9775 30.9452 14.0225 30.9452 13.3473 28.1643C12.9112 26.3678 10.853 25.5152 9.2743 26.4772C6.83045 27.9662 4.03379 25.1696 5.52285 22.7257C6.48476 21.147 5.63222 19.0888 3.83574 18.6527C1.05475 17.9775 1.05475 14.0225 3.83574 13.3473C5.63222 12.9112 6.48476 10.853 5.52285 9.27429C4.03378 6.83045 6.83045 4.03378 9.27429 5.52284C10.853 6.48476 12.9112 5.63222 13.3473 3.83574Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20.75 16C20.75 18.6234 18.6234 20.75 16 20.75C13.3766 20.75 11.25 18.6234 11.25 16C11.25 13.3766 13.3766 11.25 16 11.25C18.6234 11.25 20.75 13.3766 20.75 16Z" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <span class="zubuz-sidemenu-close">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 18L18 6M6 6L18 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </span>
          </div>
        </div>

        <div class="zubuz-sidemenu-item">
          <p>cursor</p>
          <div class="zubuz-cursor-btn">
            <button class="value-change-btn remove active-bg" type="button"><span>Normal</span></button>
            <button class="value-change-btn add active-bg" type="button"><span>advanced</span></button>
          </div>
        </div>
      </div>
    </div>

    <div class="cursor"></div>
    <div class="cursor2"></div> -->





 <?php include "header.php"?>
  <!--End landex-header-section -->

<div class="zubuz-hero-section white-bg" style="background-image: url(images/hero-shape1.png)">
    <div class="container">
      <div class="zubuz-hero-content center position-relative">
        <h1>Manage your money better than ever</h1>
        <p>Our finance app is designed to help individuals & businesses manage their financial activities and transactions. It serves various purposes related to personal and business finance.</p>
        
        <!-- Updated Search Bar Integration -->
        <div class="search-container">
          <input type="text" class="search-input" placeholder="Search College" id="searchInput">
          <button class="search-button" id="searchButton">Search by College</button>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get the search button element
    const searchButton = document.getElementById('searchButton');
    
    // Add click event listener to the button
    searchButton.addEventListener('click', function() {
      // Redirect to pgs.html when clicked
      window.location.href = 'pgs.html';
    });
  });
</script>

          
          <!-- Dropdown for search suggestions -->
          <div class="search-dropdown" id="searchDropdown">
            <!-- Dropdown items will be populated dynamically -->
          </div>
        </div>
        <!-- End Updated Search Bar Integration -->
        
        <div class="zubuz-hero-shape">
          <img src="images/shape.png" alt="">
        </div>
      </div>
      <div class="zubuz-hero-bottom">
        <div class="zubuz-hero-thumb wow fadeInUpX">
          <img src="images/hero-mocup1.png" alt="">
        </div>
        <div class="zubuz-hero-card card1 wow zoomIn">
          <img src="images/h-card1.png" alt="">
        </div>
        <div class="zubuz-hero-card card2 wow zoomIn">
          <img src="images/h-card2.png" alt="">
        </div>
        <div class="zubuz-hero-card card3 wow zoomIn">
          <img src="images/h-card4.png" alt="">
        </div>
        <div class="zubuz-hero-card card4 wow zoomIn">
          <img src="images/h-card3.png" alt="">
        </div>
      </div>
    </div>
  </div>

<style>
/* Updated Search Bar Styles to match the image */
.search-container {
  display: flex;
  max-width: 500px;
  margin: 30px auto;
  position: relative;
}

.search-input {
  flex-grow: 1;
  height: 56px;
  padding: 0 20px;
  border: 1px solid #e0e0e0;
  border-radius: 80px;
  font-size: 16px;
  color: #333;
  outline: none;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  width: 100%;
}

.search-button {
  position: absolute;
  right: 5px;
  top: 5px;
  height: calc(100% - 10px);
  padding: 0 25px;
  border: none;
  border-radius: 50px;
  background-color: #d8a6f3;
  color: black;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.3s;
  white-space: nowrap;
}

.search-button:hover {
  background-color: #c88ee9;
}

/* Dropdown styling */
.search-dropdown {
  position: absolute;
  top: 60px;
  left: 0;
  width: 100%;
  background: white;
  border: 1px solid #e0e0e0;
  border-radius: 20px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  z-index: 100;
  max-height: 300px;
  overflow-y: auto;
  display: none;
}

.dropdown-item {
  padding: 12px 20px;
  cursor: pointer;
  transition: background-color 0.2s;
  text-align: left;
}

.dropdown-item:hover {
  background-color: #f5f5f5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .search-container {
    max-width: 90%;
  }
  
  .search-button {
    padding: 0 15px;
    font-size: 14px;
  }
  
  .search-input {
    padding-right: 80px; /* Make space for the button */
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const searchButton = document.getElementById('searchButton');
  const searchDropdown = document.getElementById('searchDropdown');
  
  // Sample college data for demonstration
  const colleges = [
    "Harvard University",
    "Stanford University", 
    "Massachusetts Institute of Technology",
    "California Institute of Technology",
    "Princeton University",
    "Yale University",
    "Columbia University",
    "University of Chicago",
    "University of Pennsylvania",
    "Cornell University"
  ];
  
  // Initialize dropdown with all colleges
  function initializeDropdown() {
    // Clear previous results
    searchDropdown.innerHTML = '';
    
    // Add all colleges to dropdown
    colleges.forEach(college => {
      const item = document.createElement('div');
      item.className = 'dropdown-item';
      item.textContent = college;
      
      // When clicking an item, fill the search box
      item.addEventListener('click', function() {
        searchInput.value = college;
        searchDropdown.style.display = 'none';
      });
      
      searchDropdown.appendChild(item);
    });
  }
  
  // Show dropdown when typing
  searchInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    
    // Clear previous results
    searchDropdown.innerHTML = '';
    
    if (query.length > 0) {
      // Filter colleges based on input
      const filteredColleges = colleges.filter(college => 
        college.toLowerCase().includes(query)
      );
      
      // Add filtered results to dropdown
      if (filteredColleges.length > 0) {
        filteredColleges.forEach(college => {
          const item = document.createElement('div');
          item.className = 'dropdown-item';
          item.textContent = college;
          
          // When clicking an item, fill the search box
          item.addEventListener('click', function() {
            searchInput.value = college;
            searchDropdown.style.display = 'none';
          });
          
          searchDropdown.appendChild(item);
        });
        
        searchDropdown.style.display = 'block';
      } else {
        searchDropdown.style.display = 'none';
      }
    } else {
      // Show all colleges when input is empty
      initializeDropdown();
      searchDropdown.style.display = 'block';
    }
  });
  
  // Show dropdown when focusing on input
  searchInput.addEventListener('focus', function() {
    if (searchDropdown.children.length === 0) {
      initializeDropdown();
    }
    searchDropdown.style.display = 'block';
  });
  
  // Hide dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
      searchDropdown.style.display = 'none';
    }
  });
  
  // Search functionality
  searchButton.addEventListener('click', function() {
    performSearch(searchInput.value);
  });
  
  // Allow search on Enter key press
  searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      performSearch(searchInput.value);
    }
  });
  
  function performSearch(query) {
    if (query.trim() !== '') {
      // Implement your search logic here
      console.log('Searching for:', query);
      // Example: window.location.href = '/search?q=' + encodeURIComponent(query);
    } else {
      alert('Please enter a search term');
    }
  }
});
</script>

  <!-- End section -->
  

  <div class="section dark-bg zubuz-section-padding4">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="zubuz-brand-logo-content">
            <h3>Over 50,000 people rely on our app for their money choices</h3>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="zubuz-brand-slider">
            <div class="zubuz-brand-item">
              <img src="images/b_1.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_2.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_3.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_4.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_5.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_6.png" alt="">
            </div>
          </div>
          <div class="zubuz-brand-slider2">
            <div class="zubuz-brand-item">
              <img src="images/b_1.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_2.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_3.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_4.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_5.png" alt="">
            </div>
            <div class="zubuz-brand-item">
              <img src="images/b_6.png" alt="">
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- End section -->

  <div class="section zubuz-section-padding2 white-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="zubuz-thumb thumb-pr">
            <img src="images/mocup01.png" alt="">
            <div class="zubuz-thumb-card">
              <img src="images/card1.png" alt="">
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-flex align-items-center">
          <div class="zubuz-default-content">
            <h2>Easily monitor all financial activitie</h2>
            <p>Users can input their income & expenses, categorize transactions, and view reports and summaries of their spending habits.</p>
            <div class="zubuz-extara-mt">
              <p><span class="font-semibold">Budgeting:</span> It enables effective budgeting and expense tracking, helping you stay on top of your financial goals.</p>
              <p><span class="font-semibold">Expense Tracking:</span> Users can input their income & expenses, categorize transactions, and view reports and summaries of their spending habits.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End section -->

  <div class="section zubuz-section-padding5 white-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 order-lg-2">
          <div class="zubuz-thumb thumb-pl">
            <img src="images/mocup2.png" alt="">
            <div class="zubuz-thumb-card2">
              <img src="images/card2.png" alt="">
            </div>
          </div>
        </div>
        <div class="col-lg-7 d-flex align-items-center">
          <div class="zubuz-default-content">
            <h2>Bank account & credit card linked</h2>
            <p>Easily link their bank accounts & credit cards to view account balances, monitor transactions and receive alerts for unusual activity.</p>
            <div class="zubuz-extara-mt">
              <div class="zubuz-iconbox-wrap-left">
                <div class="zubuz-iconbox-icon">
                  <img src="images/icon1.png" alt="">
                </div>
                <div class="zubuz-iconbox-data">
                  <span>Saving & Goal Setting</span>
                  <p>Easily set money aside and build your savings for the future plan and track your financial goals.</p>
                </div>
              </div>
              <div class="zubuz-iconbox-wrap-left">
                <div class="zubuz-iconbox-icon">
                  <img src="images/icon2.png" alt="">
                </div>
                <div class="zubuz-iconbox-data">
                  <span>Credit Score Monitoring</span>
                  <p>Our finance app provides credit score monitoring to help users monitor their credit health.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End section -->

  <div class="section zubuz-section-padding3 light-bg">
    <div class="container">
      <div class="zubuz-section-title center">
        <h2>Features to improve your financial life</h2>
      </div>
      <div class="row">
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon3.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Financial Planning</h3>
              <p>Users easily can create & track all types budgets, set financial goals, and plan for their future.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon4.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Security Features</h3>
              <p>Security is a crucial aspect of our finance app. Security measures to protect users' financial data.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon5.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Tax Preparation</h3>
              <p>Preparing all the filing taxes, and optimizing deductions for ensuring compliance with tax laws.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon6.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Offline Access</h3>
              <p>Offline access means you can use essential features and data without an internet connection.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon7.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Currency Conversion</h3>
              <p>Al the travelers or international business, our finance app also offer currency conversion tools.</p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="zubuz-iconbox-wrap center">
            <div class="zubuz-iconbox-icon">
              <img src="images/icon8.png" alt="">
            </div>
            <div class="zubuz-iconbox-data">
              <h3>Integration Support</h3>
              <p>The ability to connect with other financial tools accounting software, or payment platforms.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Section -->

  

  <div class="section zubuz-section-padding2 light-bg">
    <div class="container">
      <div class="zubuz-section-title center">
        <h2>We've earned a 4.8-star Trustpilot rating</h2>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="zubuz-testimonial-wrap">
            <div class="zubuz-testimonial-rating">
              <ul>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
              </ul>
            </div>
            <div class="zubuz-testimonial-data">
              <h3>Best finance budgeting app ever!</h3>
              <p>"This finance app has been a game-changer for me! It's made budgeting and tracking my expenses so much easier. I love how intuitive and user-friendly it is."</p>
            </div>
            <div class="zubuz-testimonial-author">
              <div class="zubuz-testimonial-author-thumb">
                <img src="images/t_user1.png" alt="">
              </div>
              <div class="zubuz-testimonial-author-data">
                <span>Jonas Aly</span>
                <p>Founder @ Company</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="zubuz-testimonial-wrap">
            <div class="zubuz-testimonial-rating">
              <ul>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
              </ul>
            </div>
            <div class="zubuz-testimonial-data">
              <h3>Super helpful to watch my spend</h3>
              <p>"I can't thank this app enough for helping me stay on top of my bills. The bill payment reminders have saved me from late fees, & more organized with my finances."</p>
            </div>
            <div class="zubuz-testimonial-author">
              <div class="zubuz-testimonial-author-thumb">
                <img src="images/t_user2.png" alt="">
              </div>
              <div class="zubuz-testimonial-author-data">
                <span>Mark Bures</span>
                <p>Businessman</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="zubuz-testimonial-wrap">
            <div class="zubuz-testimonial-rating">
              <ul>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
              </ul>
            </div>
            <div class="zubuz-testimonial-data">
              <h3>Great app that saves money</h3>
              <p>"The app's integration with my bank accounts is seamless. I can easily check my balances and transactions without having to log in separately."</p>
            </div>
            <div class="zubuz-testimonial-author">
              <div class="zubuz-testimonial-author-thumb">
                <img src="images/t_user3.png" alt="">
              </div>
              <div class="zubuz-testimonial-author-data">
                <span>William Kolas</span>
                <p>Student</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="zubuz-testimonial-wrap">
            <div class="zubuz-testimonial-rating">
              <ul>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
                <li><img src="images/star-green.svg" alt=""></li>
              </ul>
            </div>
            <div class="zubuz-testimonial-data">
              <h3>Seriously life changing app!</h3>
              <p>"The financial insights and reports have been eye-opening. I now have a better understanding of my spending habit and can make adjustment to save more."</p>
            </div>
            <div class="zubuz-testimonial-author">
              <div class="zubuz-testimonial-author-thumb">
                <img src="images/t_user4.png" alt="">
              </div>
              <div class="zubuz-testimonial-author-data">
                <span>Andrew Chan</span>
                <p>Manager@ AB Company</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="zubuz-testimonial-btn">
        <a class="zubuz-default-btn" href="/testimonials">
          <span>View All Reviews</span>
        </a>
      </div>
    </div>
  </div>
  <!-- End Section -->

  <div class="section zubuz-section-padding3 white-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="zubuz-section-title">
            <h2>Browse our latest news and articles</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-4 col-lg-6">
          <div class="zubuz-blog-wrap">
            <a href="">
              <div class="zubuz-blog-thumb">
                <img src="images/blog1.png" alt="">
                <div class="zubuz-blog-categorie">
                  Business
                </div>
              </div>
            </a>
            <div class="zubuz-blog-data">
              <p>June 18, 2024</p>
              <a href="">
                <h3>What is a good solution for finance apps?</h3>
              </a>
              <a class="zubuz-blog-btn" href="">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.5 2.25L24.25 11M24.25 11L15.5 19.75M24.25 11L1.75 11" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </a>
            </div>

          </div>
        </div>
        <div class="col-xl-4 col-lg-6">
          <div class="zubuz-blog-wrap">
            <a href="">
              <div class="zubuz-blog-thumb">
                <img src="images/blog2.png" alt="">
                <div class="zubuz-blog-categorie">
                  Technology
                </div>
              </div>
            </a>
            <div class="zubuz-blog-data">
              <p>June 18, 2024</p>
              <a href="">
                <h3>What makes banking app development ideal?</h3>
              </a>
              <a class="zubuz-blog-btn" href="">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.5 2.25L24.25 11M24.25 11L15.5 19.75M24.25 11L1.75 11" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-6">
          <div class="zubuz-blog-wrap">
            <a href="">
              <div class="zubuz-blog-thumb">
                <img src="images/blog3.png" alt="">
                <div class="zubuz-blog-categorie">
                  Management
                </div>
              </div>
            </a>
            <div class="zubuz-blog-data">
              <p>June 18, 2024</p>
              <a href="">
                <h3>Finance apps that will help you make money!</h3>
              </a>
              <a class="zubuz-blog-btn" href="">
                <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.5 2.25L24.25 11M24.25 11L15.5 19.75M24.25 11L1.75 11" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Section -->

  <div class="zubuz-cta-section blue-bg">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 order-lg-2 d-flex align-items-center">
          <div class="zubuz-default-content light">
            <h2>Start managing your money now!</h2>
            <p>Your financial future is just a download away. Get our app and experience the benefits of better money management.</p>
            <div class="zubuz-extara-mt">
              <div class="zubuz-app-wrap">
                <a class="zubuz-app" href="/contact-us"><img src="images/play-store.png" alt=""></a>
                <a class="zubuz-app" href="/contact-us"><img src="images/app-store.png" alt=""></a>
                <div class="zubuz-cta-shape">
                  <img src="images/shape2.png" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="zubuz-cta-thumb">
            <img src="images/cta-mocup.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End section -->



  <footer class="zubuz-footer-section main-footer white-bg">
    <div class="container">
      <div class="zubuz-footer-top">
        <div class="row">
          <div class="col-xl-4 col-lg-12">
            <div class="zubuz-footer-textarea">
              <a href="">
                <img src="images/logo-dark.svg" alt="">
              </a>
              <p>We're your innovation partner, delivering cutting-edge solutions that elevate your business to the next level.</p>
              <div class="zubuz-subscribe-one">
                <form action="#">
                  <input type="email" placeholder="Email Address">
                  <button class="zubuz-default-btn zubuz-subscription-btn one" id="zubuz-subscription-btn" type="submit">
                    <span>Subscribe</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-4">
            <div class="zubuz-footer-menu extar-margin">
              <div class="zubuz-footer-title">
                <p>Navigation</p>
              </div>
              <ul>
                <li><a href="">Demos</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Services</a></li>
                <li><a href="">Pages</a></li>
                <li><a href="">Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-2 col-md-4">
            <div class="zubuz-footer-menu">
              <div class="zubuz-footer-title">
                <p>Utility pages</p>
              </div>
              <ul>
                <li><a href="">Instructions</a></li>
                <li><a href="">Style guide</a></li>
                <li><a href="">Licenses</a></li>
                <li><a href="">404 Not found</a></li>
                <li><a href="">Password protected</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-3 col-md-4">
            <div class="zubuz-footer-menu extar-margin">
              <div class="zubuz-footer-title">
                <p>Resources</p>
              </div>
              <ul>
                <li><a href="">Support</a></li>
                <li><a href="">Privacy policy</a></li>
                <li><a href="">Terms & Conditions</a></li>
                <li><a href="">Strategic finance</a></li>
                <li><a href="">Video guide</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="zubuz-footer-bottom">
        <div class="zubuz-social-icon order-md-2">
          <ul>
            <li>
              <a href="https://twitter.com/" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li>
              <a href="https://facebook.com/" target="_blank">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <li>
              <a href="https://www.linkedin.com/" target="_blank">
                <i class="fab fa-linkedin"></i>
              </a>
            </li>
            <li>
              <a href="https://github.com/" target="_blank">
                <i class="fab fa-github"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="zubuz-copywright">
          <p> ©Copyright 2024, All Rights Reserved by Mthemeus</p>
        </div>
      </div>

    </div>
  </footer>





  <!-- scripts -->
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/menu.js"></script>
  <script src="js/isotope.pkgd.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/slick.js"></script>
  <script src="js/countdown.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/faq.js"></script>
  <!-- <script src="assets/js/advanced-cursor.js"></script> -->
  <!-- <script src="assets/js/dark.js"></script> -->

  <script src="js/app.js"></script>



</body></html>