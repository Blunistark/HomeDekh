<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Accommodation Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-white font-[Inter]">
    <!-- App Container -->
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-[#1a4977] font-bold text-xl"><a href="./" class="text-[#1a4977] font-bold text-xl">HomeDhek</a></span>
                    </div>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="./" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Home</a>
                        <a href="pgs.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">View All PGS</a>
                        <a href="saved.php" class="text-gray-600 hover:text-gray-900 px-3 py-2 text-sm font-medium">Saved</a>
                                  <button class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm font-medium" onclick="window.location.href='sign-up.php'">Sign In</button>
                    </div>
                    <div class="md:hidden">
                        <button class="text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow relative">
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

                <!-- Accommodation Grid - Always 2 columns on mobile and more on larger screens -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Accommodation Card 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
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
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Card 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
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
                                    <span class="text-xs ml-1">4.6</span>
                                </div>
                                <span class="text-xs text-gray-500">0.8 km</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Food</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Gym</span>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹15,000<span class="text-xs text-gray-500">/month</span></p>
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation Card 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 flex flex-col h-full">
                        <div class="relative aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Accommodation" class="w-full h-full object-cover">
                            <button class="absolute top-2 right-2 bg-white p-1.5 rounded-full shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span class="bg-white/90 text-[#1a4977] text-xs px-2 py-0.5 rounded-full font-medium">Boys Only</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow flex flex-col">
                            <div class="flex items-center gap-1 mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-500">Harvard University</span>
                            </div>
                            <h3 class="font-medium text-sm sm:text-base mb-1">Green Valley Boys Hostel</h3>
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-xs ml-1">4.5</span>
                                </div>
                                <span class="text-xs text-gray-500">1.2 km</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mb-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Laundry</span>
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">Study Room</span>
                            </div>
                            <div class="mt-auto">
                                <p class="font-medium text-sm mb-2">₹9,000<span class="text-xs text-gray-500">/month</span></p>
                                <button class="w-full bg-[#1a4977] text-white py-1.5 rounded-lg text-sm">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <nav class="flex items-center gap-1">
                        <button class="px-3 py-1 border rounded-md text-sm text-gray-500 bg-white">Previous</button>
                        <button class="px-3 py-1 border rounded-md text-sm bg-[#1a4977] text-white">1</button>
                        <button class="px-3 py-1 border rounded-md text-sm text-gray-700 bg-white">2</button>
                        <button class="px-3 py-1 border rounded-md text-sm text-gray-700 bg-white">3</button>
                        <button class="px-3 py-1 border rounded-md text-sm text-gray-500 bg-white">Next</button>
                    </nav>
                </div>
            </div>
        </main>

        <!-- Footer -->
 <?php include "footer.php"?>
    </div>

    <script>
        // Filter sidebar functionality
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Add heart toggle functionality for favorites
            const heartButtons = document.querySelectorAll('button');
            
            heartButtons.forEach(button => {
                if (button.querySelector('svg path[d*="M4.318 6.318"]')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const path = this.querySelector('svg path');
                        if (path.getAttribute('fill') === 'none') {
                            path.setAttribute('fill', 'currentColor');
                            this.querySelector('svg').classList.remove('text-gray-400');
                            this.querySelector('svg').classList.add('text-red-500');
                        } else {
                            path.setAttribute('fill', 'none');
                            this.querySelector('svg').classList.remove('text-red-500');
                            this.querySelector('svg').classList.add('text-gray-400');
                        }
                    });
                }
            });
            
            // View details button functionality
            const viewDetailsButtons = document.querySelectorAll('button.w-full');
            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const accommodationName = this.closest('.p-3').querySelector('h3').textContent;
                    alert(`Viewing details for ${accommodationName}`);
                });
            });
            
            // Filter tag removal
            const filterTags = document.querySelectorAll('#appliedFilters span button');
            filterTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    this.parentElement.remove();
                    
                    // Check if there are any remaining filter tags
                    if (document.querySelectorAll('#appliedFilters span').length === 0) {
                        appliedFilters.classList.add('hidden');
                        document.getElementById('resultsCount').textContent = '3 Results Found';
                    } else {
                        document.getElementById('resultsCount').textContent = '4 Results Found';
                    }
                });
            });
        });
    </script>
</body>
</html>

