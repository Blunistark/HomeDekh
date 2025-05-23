<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeDhek - College Accommodation Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page {
            display: none;
        }
        .active-page {
            display: block;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            background-color: white;
            z-index: 50;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }
        .mobile-menu.show {
            display: block;
        }
    </style>
</head>
<body class="bg-white font-[Inter]">
    <!-- App Container -->
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="#" class="text-[#1a4977] font-bold text-xl" data-page="home">HomeDhek</a>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="home">Home</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="pgs">View All PGS</a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="saved">Saved</a>
                        <button class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium">Sign In</button>
                    </div>
                    <div class="md:hidden">
                        <button id="mobile-menu-button" class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <div class="flex flex-col space-y-3">
                <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="home">Home</a>
                <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="pgs">View All PGS</a>
                <a href="#" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium" data-page="saved">Saved</a>
                <button class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium w-full">Sign In</button>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow relative">
            <!-- PGS Page -->
            <div id="pgs-page" class="page active-page">
                <!-- Search Section -->
                <div class="bg-white border-b">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-6">Find Your Perfect College Accommodation</h1>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-grow">
                                <div class="flex items-center border rounded-lg p-2 bg-white shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" placeholder="Search by location, college, or property name" class="ml-2 w-full outline-none text-sm">
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button id="filterButton" class="bg-white border rounded-lg p-2 px-4 text-sm flex items-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter
                                </button>
                                <button class="bg-[#1a4977] text-white rounded-lg p-2 px-4 text-sm shadow-sm">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Sidebar Overlay -->
                <div id="filterOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

                <!-- Filter Sidebar -->
                <div id="filterSidebar" class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg z-30 transform translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
                    <div class="p-5 flex flex-col h-full">
                        <div class="flex justify-between items-center mb-5">
                            <h2 class="font-bold text-lg">Filter Options</h2>
                            <button id="closeFilterButton" class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h3 class="font-medium text-sm mb-3">Price Range (₹/month)</h3>
                            <div class="mb-2">
                                <input type="range" id="priceRange" min="0" max="20000" value="20000" class="w-full accent-[#1a4977]">
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>₹0</span>
                                    <span id="priceValue">₹20,000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Accommodation Type Filter -->
                        <div class="mb-6">
                            <h3 class="font-medium text-sm mb-3">Accommodation Type</h3>
                            <div class="relative">
                                <select class="appearance-none border rounded-md px-3 py-2 pr-8 text-sm bg-white w-full">
                                    <option>All Types</option>
                                    <option>PG</option>
                                    <option>Hostel</option>
                                    <option>Apartment</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities Filter -->
                        <div class="mb-6">
                            <h3 class="font-medium text-sm mb-3">Amenities</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="wifi" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="wifi" class="ml-2 text-sm text-gray-600">WiFi</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="food" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="food" class="ml-2 text-sm text-gray-600">Food</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="tv" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="tv" class="ml-2 text-sm text-gray-600">TV</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="bathroom" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="bathroom" class="ml-2 text-sm text-gray-600">Attached Bathroom</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ac" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="ac" class="ml-2 text-sm text-gray-600">AC</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="gym" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="gym" class="ml-2 text-sm text-gray-600">Gym</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="laundry" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="laundry" class="ml-2 text-sm text-gray-600">Laundry</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="studyroom" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="studyroom" class="ml-2 text-sm text-gray-600">Study Room</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="parking" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="parking" class="ml-2 text-sm text-gray-600">Parking</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="refrigerator" class="h-4 w-4 text-[#1a4977] rounded border-gray-300 focus:ring-[#1a4977]">
                                    <label for="refrigerator" class="ml-2 text-sm text-gray-600">Refrigerator</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto flex gap-3">
                            <button id="resetFilters" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg text-sm">Reset</button>
                            <button id="applyFilters" class="flex-1 bg-[#1a4977] text-white py-2 rounded-lg text-sm">Apply Filters</button>
                        </div>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <!-- Applied Filters -->
                    <div id="appliedFilters" class="mb-4 flex flex-wrap gap-2 hidden">
                        <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                            TV
                            <button class="ml-1 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                        <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                            WiFi
                            <button class="ml-1 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                        <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full flex items-center">
                            AC
                            <button class="ml-1 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                        <button id="clearAllFilters" class="text-[#1a4977] text-xs font-medium">Clear All</button>
                    </div>

                    <!-- Results Header -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <div>
                            <h2 id="resultsCount" class="font-bold text-lg text-gray-900">3 Results Found</h2>
                            <p class="text-sm text-gray-500">Near Stanford University</p>
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <div class="relative flex-grow sm:flex-grow-0">
                                <select class="appearance-none border rounded-md px-3 py-2 pr-8 text-sm bg-white w-full">
                                    <option>Recommended</option>
                                    <option>Price: Low to High</option>
                                    <option>Price: High to Low</option>
                                    <option>Rating</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <!-- Accommodation Card 1 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 flex-grow flex flex-col">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Stanford University</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Sunshine PG for Girls</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">4.8</span>
                                    </div>
                                    <span class="text-xs text-gray-500">0.5 km</span>
                                </div>
                                <div class="flex flex-wrap gap-1 mb-2">
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">WiFi</span>
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">AC</span>
                                </div>
                                <div class="mt-auto">
                                    <p class="font-medium text-sm mb-2">₹12,000<span class="text-xs text-gray-500">/month</span></p>
                                    <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm view-details-btn" data-property="sunshine">View Details</button>
                                </div>
                            </div>
                        </div>

                        <!-- Accommodation Card 2 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Co-ed</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 flex-grow flex flex-col">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">MIT</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Campus View Residency</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                                        <!-- Back Button -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-[#1a4977] back-to-listings">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to listings
                    </a>
                </div>

                <!-- Property Header -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
                    <h1 class="text-2xl font-bold text-gray-900" id="property-title">Sunshine PG for Girls</h1>
                    <div class="flex flex-wrap items-center gap-3 mt-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="property-location">Near Stanford University</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span id="property-distance">0.5 km from campus</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-sm font-medium" id="property-rating">4.8</span>
                            </div>
                            <span class="text-xs text-gray-500 ml-1" id="property-reviews">(124 reviews)</span>
                        </div>
                        <button class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Share
                        </button>
                        <button class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900" id="details-save-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Save
                        </button>
                    </div>
                </div>

                <!-- Image Gallery -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
                    <div class="relative">
                        <div class="grid grid-cols-4 gap-2 h-[400px]">
                            <div class="col-span-4 md:col-span-2 row-span-2 relative rounded-tl-lg rounded-bl-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Main bedroom" class="w-full h-full object-cover" id="main-property-image">
                                <div class="absolute bottom-0 left-0 bg-black bg-opacity-60 text-white px-3 py-1 text-sm m-2 rounded" id="property-price">
                                    ₹12,000<span class="text-xs">/month</span>
                                </div>
                            </div>
                            <div class="hidden md:block col-span-1 row-span-1 rounded-tr-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Common area" class="w-full h-full object-cover gallery-img">
                            </div>
                            <div class="hidden md:block col-span-1 row-span-1 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Kitchen" class="w-full h-full object-cover gallery-img">
                            </div>
                            <div class="hidden md:block col-span-1 row-span-1 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560185127-6ed189bf02f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Study area" class="w-full h-full object-cover gallery-img">
                            </div>
                            <div class="hidden md:block col-span-1 row-span-1 rounded-br-lg overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Exterior" class="w-full h-full object-cover gallery-img">
                            </div>
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        <div class="flex mt-2 overflow-x-auto gap-2 md:hidden">
                            <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden border-2 border-[#1a4977]">
                                <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Bedroom" class="w-full h-full object-cover thumb-img">
                            </div>
                            <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Common area" class="w-full h-full object-cover thumb-img">
                            </div>
                            <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Kitchen" class="w-full h-full object-cover thumb-img">
                            </div>
                            <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560185127-6ed189bf02f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Study area" class="w-full h-full object-cover thumb-img">
                            </div>
                            <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Exterior" class="w-full h-full object-cover thumb-img">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Left Column - Property Details -->
                        <div class="w-full lg:w-2/3">
                            <!-- Navigation Tabs -->
                            <div class="border-b border-gray-200 mb-6">
                                <nav class="flex -mb-px">
                                    <a href="#overview" class="border-b-2 border-[#1a4977] py-4 px-6 text-sm font-medium text-[#1a4977] tab-link" data-tab="overview">Overview</a>
                                    <a href="#amenities" class="border-b-2 border-transparent py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 tab-link" data-tab="amenities">Amenities</a>
                                    <a href="#location" class="border-b-2 border-transparent py-4 px-6 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 tab-link" data-tab="location">Location</a>
                                </nav>
                            </div>

                            <!-- Overview Section -->
                            <section id="overview" class="tab-content active">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">About this place</h2>
                                <div class="text-gray-700 space-y-4">
                                    <p>Sunshine PG for Girls is a premium paying guest accommodation located just 500 meters from Stanford University. We offer comfortable, safe, and affordable living spaces for female students with all modern amenities and a homely atmosphere.</p>
                                    <p>Our PG accommodation features spacious rooms with comfortable beds, study tables, and ample storage space. We provide high-speed WiFi, regular housekeeping, and 24/7 security to ensure a comfortable and safe living environment. The common areas include a fully equipped kitchen, dining area, and a cozy lounge for relaxation and socializing. We also offer laundry facilities and a dedicated study room for our residents.</p>
                                </div>

                                <!-- Pricing Section -->
                                <div class="mt-8">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
                                    <div class="bg-white rounded-lg border overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Type</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (per month)</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-user mr-2 text-gray-400"></i>
                                                            Single Sharing
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹8,000</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">3 beds</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-users mr-2 text-gray-400"></i>
                                                            Double Sharing
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹6,000</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">5 beds</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-users mr-2 text-gray-400"></i>
                                                            Triple Sharing
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₹4,500</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">2 beds</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>

                            <!-- Amenities Section -->
                            <section id="amenities" class="tab-content hidden">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Amenities</h2>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    <div class="bg-white p-4 rounded-lg border flex items-center">
                                        <div class="bg-blue-50 p-2 rounded-full mr-3">
                                            <i class="fas fa-wifi text-[#1a4977]"></i>
                                        </div>
                                        <span class="text-gray-700">WiFi</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border flex items-center">
                                        <div class="bg-blue-50 p-2 rounded-full mr-3">
                                            <i class="fas fa-utensils text-[#1a4977]"></i>
                                        </div>
                                        <span class="text-gray-700">Food</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border flex items-center">
                                        <div class="bg-blue-50 p-2 rounded-full mr-3">
                                            <i class="fas fa-tv text-[#1a4977]"></i>
                                        </div>
                                        <span class="text-gray-700">TV</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border flex items-center">
                                        <div class="bg-blue-50 p-2 rounded-full mr-3">
                                            <i class="fas fa-bath text-[#1a4977]"></i>
                                        </div>
                                        <span class="text-gray-700">Attached Bathroom</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border flex items-center">
                                        <div class="bg-blue-50 p-2 rounded-full mr-3">
                                            <i class="fas fa-snowflake text-[#1a4977]"></i>
                                        </div>
                                        <span class="text-gray-700">Refrigerator</span>
                                    </div>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 mt-8 mb-4">Additional Services</h3>
                                <ul class="space-y-2 text-gray-700">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Daily housekeeping
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        24/7 security
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Laundry services (additional charges may apply)
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                        Common study area
                                    </li>
                                </ul>
                            </section>

                            <!-- Location Section -->
                            <section id="location" class="tab-content hidden">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Location</h2>
                                <p class="text-gray-700 mb-4">122 College Avenue, Stanford, CA 94305</p>
                                
                                <!-- Map -->
                                <div class="bg-gray-200 h-64 rounded-lg mb-6 relative">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-gray-500">Map loading...</p>
                                    </div>
                                    <button class="absolute bottom-4 right-4 bg-white text-[#1a4977] px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                                        Open in Google Maps
                                    </button>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Nearby Places</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg border">
                                        <h4 class="font-medium text-gray-900">Stanford University</h4>
                                        <p class="text-sm text-gray-600">0.5 km (7 min walk)</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border">
                                        <h4 class="font-medium text-gray-900">University Library</h4>
                                        <p class="text-sm text-gray-600">0.8 km (10 min walk)</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border">
                                        <h4 class="font-medium text-gray-900">Shopping Center</h4>
                                        <p class="text-sm text-gray-600">1.2 km (15 min walk)</p>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg border">
                                        <h4 class="font-medium text-gray-900">Bus Station</h4>
                                        <p class="text-sm text-gray-600">0.3 km (5 min walk)</p>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Right Column - Contact Info -->
                        <div class="w-full lg:w-1/3">
                            <div class="bg-white rounded-lg border p-6 sticky top-24">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Owner</h3>
                                
                                <div class="flex items-center mb-6">
                                    <div class="h-12 w-12 rounded-full overflow-hidden mr-3">
                                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Mrs. Jennifer Smith" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Mrs. Jennifer Smith</h4>
                                        <p class="text-sm text-gray-600">Property Owner</p>
                                    </div>
                                </div>
                                
                                <button class="w-full bg-[#1a4977] text-white py-3 rounded-lg mb-3 flex items-center justify-center">
                                    <i class="fas fa-phone-alt mr-2"></i>
                                    Call Owner
                                </button>
                                
                                <button class="w-full bg-white border border-gray-300 text-gray-700 py-3 rounded-lg mb-3 flex items-center justify-center">
                                    <i class="far fa-calendar-alt mr-2"></i>
                                    Schedule a Visit
                                </button>
                                
                                <button class="w-full bg-green-500 text-white py-3 rounded-lg mb-4 flex items-center justify-center">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    WhatsApp
                                </button>
                                
                                <p class="text-xs text-gray-500 text-center mb-6">Mention that you found this on HomeDhek</p>
                                
                                <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-tag text-yellow-500 mr-2"></i>
                                        <h4 class="font-medium text-gray-900">Special Offer</h4>
                                    </div>
                                    <p class="text-sm text-gray-700">Book now and get 10% off on your first month's rent</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Similar Properties Section -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Similar Properties</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Similar Property Card 1 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Near Stanford University</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Serene Girls Hostel</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">4.7</span>
                                    </div>
                                    <span class="text-xs text-gray-500">0.7 km</span>
                                </div>
                                <p class="font-medium text-sm">₹7,500<span class="text-xs text-gray-500">/month</span></p>
                            </div>
                        </div>

                        <!-- Similar Property Card 2 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Near Stanford University</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Bliss Ladies Hostel</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">4.5</span>
                                    </div>
                                    <span class="text-xs text-gray-500">1.2 km</span>
                                </div>
                                <p class="font-medium text-sm">₹6,800<span class="text-xs text-gray-500">/month</span></p>
                            </div>
                        </div>

                        <!-- Similar Property Card 3 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Near Stanford University</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Harmony Ladies PG</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">4.3</span>
                                    </div>
                                    <span class="text-xs text-gray-500">0.9 km</span>
                                </div>
                                <p class="font-medium text-sm">₹9,000<span class="text-xs text-gray-500">/month</span></p>
                            </div>
                        </div>

                        <!-- Similar Property Card 4 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                            <div class="relative aspect-[4/3]">
                                <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                                <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm favorite-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                    <div class="flex flex-wrap gap-1">
                                        <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Girls Only</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="flex items-center gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-xs text-gray-500">Near Stanford University</span>
                                </div>
                                <h3 class="font-medium text-sm sm:text-base mb-1">Tranquil Women's Hostel</h3>
                                <div class="flex items-center gap-1 mb-2">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs ml-1">4.9</span>
                                    </div>
                                    <span class="text-xs text-gray-500">1.5 km</span>
                                </div>
                                <p class="font-medium text-sm">₹10,500<span class="text-xs text-gray-500">/month</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">HomeDhek</h3>
                        <p class="text-gray-400 text-sm">Find your perfect accommodation near universities and colleges across India.</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-white" data-page="home">Home</a></li>
                            <li><a href="#" class="hover:text-white" data-page="pgs">Find PGs</a></li>
                            <li><a href="#" class="hover:text-white">Hostels</a></li>
                            <li><a href="#" class="hover:text-white">Apartments</a></li>
                            <li><a href="#" class="hover:text-white">About Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Cities</h3>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li><a href="#" class="hover:text-white">Delhi</a></li>
                            <li><a href="#" class="hover:text-white">Mumbai</a></li>
                            <li><a href="#" class="hover:text-white">Bangalore</a></li>
                            <li><a href="#" class="hover:text-white">Hyderabad</a></li>
                            <li><a href="#" class="hover:text-white">Chennai</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                        <ul class="space-y-2 text-gray-400 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                                <span>123 Main Street, New Delhi, 110001</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-phone-alt mt-1 mr-2"></i>
                                <span>+91 98765 43210</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-envelope mt-1 mr-2"></i>
                                <span>info@homedhek.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-sm text-gray-400">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p>&copy; 2025 HomeDhek. All rights reserved.</p>
                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="hover:text-white">Privacy Policy</a>
                            <a href="#" class="hover:text-white">Terms of Service</a>
                            <a href="#" class="hover:text-white">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Property data for dynamic content
            const propertyData = {
                'sunshine': {
                    title: 'Sunshine PG for Girls',
                    location: 'Near Stanford University',
                    distance: '0.5 km from campus',
                    rating: '4.8',
                    reviews: '(124 reviews)',
                    price: '₹12,000',
                    image: 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
                },
                'campus': {
                    title: 'Campus View Residency',
                    location: 'Near MIT',
                    distance: '0.8 km from campus',
                    rating: '4.6',
                    reviews: '(98 reviews)',
                    price: '₹15,000',
                    image: 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
                },
                'green': {
                    title: 'Green Valley Boys Hostel',
                    location: 'Near Harvard University',
                    distance: '1.2 km from campus',
                    rating: '4.5',
                    reviews: '(76 reviews)',
                    price: '₹9,000',
                    image: 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
                }
            };

            // Page navigation
            const pages = document.querySelectorAll('.page');
            const navLinks = document.querySelectorAll('[data-page]');
            let lastActivePage = 'pgs';

            function showPage(pageId) {
                pages.forEach(page => {
                    if (page.id === pageId + '-page') {
                        page.classList.add('active-page');
                    } else {
                        page.classList.remove('active-page');
                    }
                });

                // Update active nav link
                navLinks.forEach(link => {
                    if (link.dataset.page === pageId) {
                        link.classList.add('text-[#1a4977]', 'border-b-2', 'border-[#1a4977]');
                        link.classList.remove('text-gray-600');
                    } else {
                        link.classList.remove('text-[#1a4977]', 'border-b-2', 'border-[#1a4977]');
                        link.classList.add('text-gray-600');
                    }
                });

                lastActivePage = pageId;
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showPage(this.dataset.page);
                    
                    // Close mobile menu if open
                    document.querySelector('.mobile-menu').classList.remove('show');
                });
            });

            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('show');
            });

            // Filter sidebar functionality
            const filterButton = document.getElementById('filterButton');
            const closeFilterButton = document.getElementById('closeFilterButton');
            const filterSidebar = document.getElementById('filterSidebar');
            const filterOverlay = document.getElementById('filterOverlay');
            const applyFilters = document.getElementById('applyFilters');
            const resetFilters = document.getElementById('resetFilters');
            const clearAllFilters = document.getElementById('clearAllFilters');
            const appliedFilters = document.getElementById('appliedFilters');
            const priceRange = document.getElementById('priceRange');
            const priceValue = document.getElementById('priceValue');
            
            // Update price value display
            priceRange.addEventListener('input', function() {
                priceValue.textContent = '₹' + parseInt(this.value).toLocaleString();
            });
            
            // Open filter sidebar
            filterButton.addEventListener('click', function() {
                filterSidebar.classList.remove('translate-x-full');
                filterOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
            
            // Close filter sidebar
            function closeFilterSidebar() {
                filterSidebar.classList.add('translate-x-full');
                filterOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
            
            closeFilterButton.addEventListener('click', closeFilterSidebar);
            filterOverlay.addEventListener('click', closeFilterSidebar);
            
            // Apply filters
            applyFilters.addEventListener('click', function() {
                // Get selected amenities
                const selectedAmenities = [];
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    selectedAmenities.push(checkbox.id);
                });
                
                // Show applied filters
                if (selectedAmenities.length > 0) {
                    appliedFilters.classList.remove('hidden');
                    
                    // Update results count (simulating filter effect)
                    document.getElementById('resultsCount').textContent = '4 Results Found';
                } else {
                    appliedFilters.classList.add('hidden');
                }
                
                closeFilterSidebar();
            });
            
            // Reset filters
            resetFilters.addEventListener('click', function() {
                // Reset checkboxes
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                // Reset price range
                priceRange.value = 20000;
                priceValue.textContent = '₹20,000';
            });
            
            // Clear all applied filters
            clearAllFilters.addEventListener('click', function() {
                appliedFilters.classList.add('hidden');
                document.getElementById('resultsCount').textContent = '3 Results Found';
                
                // Reset all filter inputs
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                priceRange.value = 20000;
                priceValue.textContent = '₹20,000';
            });
            
            // Heart toggle functionality for favorites
            const favoriteButtons = document.querySelectorAll('.favorite-btn');
            
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const path = this.querySelector('svg path');
                    const svg = this.querySelector('svg');
                    
                    if (path.getAttribute('fill') === 'none') {
                        path.setAttribute('fill', 'currentColor');
                        svg.classList.remove('text-gray-400');
                        svg.classList.add('text-red-500');
                    } else {
                        path.setAttribute('fill', 'none');
                        svg.classList.remove('text-red-500');
                        svg.classList.add('text-gray-400');
                    }
                });
            });

            // Save button in details page
            const detailsSaveBtn = document.getElementById('details-save-btn');
            if (detailsSaveBtn) {
                detailsSaveBtn.addEventListener('click', function() {
                    const path = this.querySelector('svg path');
                    const svg = this.querySelector('svg');
                    
                    if (path.getAttribute('fill') === 'none') {
                        path.setAttribute('fill', 'currentColor');
                        svg.classList.remove('text-gray-400');
                        svg.classList.add('text-red-500');
                        this.querySelector('svg').nextSibling.textContent = ' Saved';
                    } else {
                        path.setAttribute('fill', 'none');
                        svg.classList.remove('text-red-500');
                        svg.classList.add('text-gray-400');
                        this.querySelector('svg').nextSibling.textContent = ' Save';
                    }
                });
            }
            
            // View details button functionality
            const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const propertyId = this.dataset.property;
                    const property = propertyData[propertyId];
                    
                    // Update property details
                    document.getElementById('property-title').textContent = property.title;
                    document.getElementById('property-location').textContent = property.location;
                    document.getElementById('property-distance').textContent = property.distance;
                    document.getElementById('property-rating').textContent = property.rating;
                    document.getElementById('property-reviews').textContent = property.reviews;
                    document.getElementById('property-price').innerHTML = property.price + '<span class="text-xs">/month</span>';
                    document.getElementById('main-property-image').src = property.image;
                    
                    // Show details page
                    showPage('details');
                });
            });
            
            // Back to listings button
            const backToListingsBtn = document.querySelector('.back-to-listings');
            backToListingsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showPage(lastActivePage);
            });
            
            // Tab navigation in property details
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabLinks.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(t => {
                        t.classList.remove('border-[#1a4977]', 'text-[#1a4977]');
                        t.classList.add('border-transparent', 'text-gray-500');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.remove('border-transparent', 'text-gray-500');
                                        this.classList.add('border-[#1a4977]', 'text-[#1a4977]');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show selected tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
            
            // Remove saved item functionality
            const removeSavedButtons = document.querySelectorAll('.remove-saved-btn');
            const savedItemsContainer = document.getElementById('saved-items-container');
            const emptySavedState = document.getElementById('empty-saved-state');
            
            removeSavedButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const savedItem = this.closest('.saved-item');
                    savedItem.remove();
                    
                    // Check if there are any saved items left
                    if (savedItemsContainer.children.length === 0) {
                        emptySavedState.classList.remove('hidden');
                    }
                });
            });
            
            // Mobile thumbnail gallery navigation
            const thumbImages = document.querySelectorAll('.thumb-img');
            const mainImage = document.getElementById('main-property-image');
            
            thumbImages.forEach(img => {
                img.addEventListener('click', function() {
                    // Update main image
                    mainImage.src = this.src;
                    
                    // Update active thumbnail
                    thumbImages.forEach(thumb => {
                        thumb.parentElement.classList.remove('border-[#1a4977]');
                    });
                    this.parentElement.classList.add('border-[#1a4977]');
                });
            });
            
            // Initialize the app on first load
            showPage('pgs');
        });
    </script>
</body>
</html>



