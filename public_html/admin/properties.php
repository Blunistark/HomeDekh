<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management | HomeDhek Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Dropdown toggle */
        .dropdown-toggle:focus + .dropdown-menu {
            display: block;
        }
        
        /* Price range slider */
        .price-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            outline: none;
            border-radius: 4px;
        }
        
        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #1a4977;
            border-radius: 50%;
            cursor: pointer;
        }
        
        .price-slider::-moz-range-thumb {
            width: 16px;
            height: 16px;
            background: #1a4977;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="flex justify-between items-center h-16 px-4">
            <div class="flex items-center">
                <button id="sidebar-toggle" class="text-gray-500 focus:outline-none focus:text-gray-700 lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="ml-4 lg:ml-0">
                    <span class="text-[#1a4977] font-bold text-xl">HomeDhek Admin</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-gray-500 focus:outline-none focus:text-gray-700 relative">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">4</span>
                    </button>
                </div>
                <div class="relative">
                    <div class="flex items-center text-gray-700 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white">
                            A
                        </div>
                        <span class="ml-2 text-sm font-medium hidden md:block">Admin User</span>
                        <i class="fas fa-chevron-down ml-2 text-xs hidden md:block"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 bg-white shadow-md w-64 pt-16 transform transition-transform duration-300 lg:translate-x-0 z-10 -translate-x-full">
            <div class="overflow-y-auto h-full">
                <nav class="mt-5 px-2">
                    <div class="space-y-1">
                        <a href="./" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-home mr-3 text-gray-500"></i>
                            Dashboard
                        </a>
                        <a href="properties.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-[#1a4977] text-white">
                            <i class="fas fa-building mr-3"></i>
                            Properties
                        </a>
                        <a href="users.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-users mr-3 text-gray-500"></i>
                            Users
                        </a>
                        <a href="inquiries.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-comment-dots mr-3 text-gray-500"></i>
                            Inquiries
                        </a>
                        <a href="settings.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>
                    </div>
                    
                    <div class="mt-10">
                        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Shortcuts</h3>
                        <div class="mt-2 space-y-1">
                            <a href="add-property.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-[#1a4977] hover:bg-blue-50">
                                <i class="fas fa-plus-circle mr-3 text-[#1a4977]"></i>
                                Add New Property
                            </a>
                            <a href="pending-approvals.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-clock mr-3 text-gray-500"></i>
                                Pending Approvals
                                <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded-full">3</span>
                            </a>
                            <a href="export-data.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-download mr-3 text-gray-500"></i>
                                Export Data
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 lg:ml-64 ml-0">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Properties</h1>
                    <div class="mt-4 sm:mt-0">
                        <a href="add-property.php" class="bg-[#1a4977] text-white px-4 py-2 rounded-md flex items-center text-sm">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add New Property
                        </a>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="font-semibold text-gray-900">Filters</h2>
                        <button id="toggle-advanced-filters" class="text-sm text-[#1a4977] flex items-center">
                            <span id="advanced-filters-text">Show Advanced Filters</span>
                            <i class="fas fa-chevron-down ml-1 text-xs" id="advanced-filters-icon"></i>
                        </button>
                    </div>
                    
                    <!-- Basic Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <input type="text" id="search" class="w-full border rounded-lg px-3 py-2 pl-9" placeholder="Search by name or location">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label for="property-type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                            <select id="property-type" class="w-full border rounded-lg px-3 py-2">
                                <option value="">All Types</option>
                                <option value="pg">PG</option>
                                <option value="hostel">Hostel</option>
                                <option value="apartment">Apartment</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" class="w-full border rounded-lg px-3 py-2">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Advanced Filters (Hidden by default) -->
                    <div id="advanced-filters" class="hidden border-t pt-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="price-range" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                <div class="px-2">
                                    <input type="range" id="price-range" min="0" max="50000" value="20000" step="500" class="price-slider mb-2">
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500">₹0</span>
                                        <span class="text-xs text-gray-500" id="price-display">₹20,000</span>
                                        <span class="text-xs text-gray-500">₹50,000+</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="category" class="w-full border rounded-lg px-3 py-2">
                                    <option value="">All Categories</option>
                                    <option value="girls">Girls Only</option>
                                    <option value="boys">Boys Only</option>
                                    <option value="coed">Co-ed</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="sort-by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                <select id="sort-by" class="w-full border rounded-lg px-3 py-2">
                                    <option value="latest">Latest Added</option>
                                    <option value="name-asc">Name (A-Z)</option>
                                    <option value="name-desc">Name (Z-A)</option>
                                    <option value="price-asc">Price (Low to High)</option>
                                    <option value="price-desc">Price (High to Low)</option>
                                    <option value="rating-desc">Rating (High to Low)</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Amenities</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="wifi" class="mr-2">
                                    <label for="wifi" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-wifi text-gray-400 mr-1"></i> WiFi
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ac" class="mr-2">
                                    <label for="ac" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-wind text-gray-400 mr-1"></i> AC
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="food" class="mr-2">
                                    <label for="food" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-utensils text-gray-400 mr-1"></i> Food
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="tv" class="mr-2">
                                    <label for="tv" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-tv text-gray-400 mr-1"></i> TV
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="bathroom" class="mr-2">
                                    <label for="bathroom" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-bath text-gray-400 mr-1"></i> Attached Bathroom
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="refrigerator" class="mr-2">
                                    <label for="refrigerator" class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-snowflake text-gray-400 mr-1"></i> Refrigerator
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button id="reset-filters" class="border border-gray-300 bg-white text-gray-700 px-4 py-2 rounded-md text-sm mr-2">
                                Reset Filters
                            </button>
                            <button id="apply-filters" class="bg-[#1a4977] text-white px-4 py-2 rounded-md text-sm">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="flex items-center mb-4 sm:mb-0">
                            <input type="checkbox" id="select-all" class="mr-2">
                            <label for="select-all" class="text-sm font-medium text-gray-700">Select All</label>
                            <span class="ml-2 text-sm text-gray-500" id="selected-count">(0 selected)</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <button id="bulk-activate" class="border border-green-500 bg-green-50 text-green-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-check-circle mr-1"></i>
                                Activate
                            </button>
                            <button id="bulk-deactivate" class="border border-yellow-500 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-pause-circle mr-1"></i>
                                Deactivate
                            </button>
                            <button id="bulk-delete" class="border border-red-500 bg-red-50 text-red-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-trash-alt mr-1"></i>
                                Delete
                            </button>
                            <button id="bulk-export" class="border border-blue-500 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-md text-sm flex items-center" disabled>
                                <i class="fas fa-download mr-1"></i>
                                Export
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Properties Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">
                                        <span class="sr-only">Select</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Added
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Property 1 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="1">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sunshine PG for Girls</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">PG</div>
                                        <div class="text-xs text-blue-600">Girls Only</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near Stanford University</div>
                                        <div class="text-xs text-gray-500">0.5 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹12,000/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 15, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=1" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=1" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="1" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Property 2 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="2">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Campus View Residency</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.6</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Hostel</div>
                                        <div class="text-xs text-purple-600">Co-ed</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near MIT</div>
                                        <div class="text-xs text-gray-500">0.8 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹15,000/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 14, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=2" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=2" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="2" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Property 3 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="3">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Green Valley Boys Hostel</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.5</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Hostel</div>
                                        <div class="text-xs text-green-600">Boys Only</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near Harvard University</div>
                                        <div class="text-xs text-gray-500">1.2 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹9,000/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 13, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=3" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=3" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="3" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Property 4 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="4">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Bliss Ladies Hostel</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.5</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">PG</div>
                                        <div class="text-xs text-blue-600">Girls Only</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near Stanford University</div>
                                        <div class="text-xs text-gray-500">1.2 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹6,800/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 12, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=4" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=4" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="4" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Property 5 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="5">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Tranquil Women's Hostel</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.9</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Hostel</div>
                                        <div class="text-xs text-blue-600">Girls Only</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near Stanford University</div>
                                        <div class="text-xs text-gray-500">1.5 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹10,500/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 10, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=5" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=5" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="5" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Property 6 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="property-select" data-id="6">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                                <img src="https://images.unsplash.com/photo-1554995207-c18c203602cb?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Harmony Ladies PG</div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                                    <span class="text-xs text-gray-500">4.3</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">PG</div>
                                        <div class="text-xs text-blue-600">Girls Only</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Near Stanford University</div>
                                        <div class="text-xs text-gray-500">0.9 km</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">₹9,000/month</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        May 9, 2025
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="edit-property.php?id=6" class="text-[#1a4977] hover:text-[#0d2f4e]" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="view-property.php?id=6" class="text-gray-600 hover:text-gray-900" title="View" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 delete-property" data-id="6" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">27</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <a href="#" aria-current="page" class="z-10 bg-[#1a4977] border-[#1a4977] text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    1
                                </a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    2
                                </a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">
                                    3
                                </a>
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">
                                    4
                                </a>
                                <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    5
                                </a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 sm:w-96 mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Deletion</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete this property? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-delete" class="bg-white text-gray-700 px-4 py-2 rounded-md border text-sm">
                    Cancel
                </button>
                <button id="confirm-delete" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div id="bulk-delete-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 sm:w-96 mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Confirm Bulk Deletion</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete <span id="bulk-delete-count">0</span> properties? This action cannot be undone.</p>
            <div class="flex justify-end space-x-3">
                <button id="cancel-bulk-delete" class="bg-white text-gray-700 px-4 py-2 rounded-md border text-sm">
                    Cancel
                </button>
                <button id="confirm-bulk-delete" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Advanced filters toggle
            document.getElementById('toggle-advanced-filters').addEventListener('click', function() {
                const advancedFilters = document.getElementById('advanced-filters');
                const icon = document.getElementById('advanced-filters-icon');
                const text = document.getElementById('advanced-filters-text');
                
                if (advancedFilters.classList.contains('hidden')) {
                    advancedFilters.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                    text.textContent = 'Hide Advanced Filters';
                } else {
                    advancedFilters.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                    text.textContent = 'Show Advanced Filters';
                }
            });
            
            // Price range slider
            const priceRange = document.getElementById('price-range');
            const priceDisplay = document.getElementById('price-display');
            
            priceRange.addEventListener('input', function() {
                priceDisplay.textContent = '₹' + parseInt(this.value).toLocaleString();
            });
            
            // Select all properties
            const selectAll = document.getElementById('select-all');
            const propertyCheckboxes = document.querySelectorAll('.property-select');
            const selectedCount = document.getElementById('selected-count');
            const bulkButtons = document.querySelectorAll('#bulk-activate, #bulk-deactivate, #bulk-delete, #bulk-export');
            
            selectAll.addEventListener('change', function() {
                propertyCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                
                updateSelectedCount();
            });
            
            propertyCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(propertyCheckboxes).every(cb => cb.checked);
                    const anyChecked = Array.from(propertyCheckboxes).some(cb => cb.checked);
                    
                    selectAll.checked = allChecked;
                    selectAll.indeterminate = anyChecked && !allChecked;
                    
                    updateSelectedCount();
                });
            });
            
            function updateSelectedCount() {
                const count = Array.from(propertyCheckboxes).filter(cb => cb.checked).length;
                selectedCount.textContent = `(${count} selected)`;
                
                if (count > 0) {
                    bulkButtons.forEach(button => {
                        button.disabled = false;
                        button.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                } else {
                    bulkButtons.forEach(button => {
                        button.disabled = true;
                        button.classList.add('opacity-50', 'cursor-not-allowed');
                    });
                }
                
                document.getElementById('bulk-delete-count').textContent = count;
            }
            
            // Reset filters
            document.getElementById('reset-filters').addEventListener('click', function() {
                document.getElementById('search').value = '';
                document.getElementById('property-type').value = '';
                document.getElementById('status').value = '';
                document.getElementById('price-range').value = 20000;
                document.getElementById('price-display').textContent = '₹20,000';
                document.getElementById('category').value = '';
                document.getElementById('sort-by').value = 'latest';
                
                // Uncheck all amenities
                document.querySelectorAll('#amenities input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
            });
            
            // Delete property
            const deleteButtons = document.querySelectorAll('.delete-property');
            const deleteModal = document.getElementById('delete-modal');
            const cancelDelete = document.getElementById('cancel-delete');
            const confirmDelete = document.getElementById('confirm-delete');
            let propertyToDelete = null;
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    propertyToDelete = this.getAttribute('data-id');
                    deleteModal.classList.remove('hidden');
                });
            });
            
            cancelDelete.addEventListener('click', function() {
                deleteModal.classList.add('hidden');
                propertyToDelete = null;
            });
            
            confirmDelete.addEventListener('click', function() {
                // In a real implementation, this would make an AJAX request to delete the property
                console.log(`Deleting property with ID: ${propertyToDelete}`);
                
                // For demo purposes, let's just hide the row
                const row = document.querySelector(`.property-select[data-id="${propertyToDelete}"]`).closest('tr');
                row.classList.add('hidden');
                
                deleteModal.classList.add('hidden');
                propertyToDelete = null;
                
                // Show a confirmation message
                alert('Property deleted successfully');
            });
            
            // Bulk delete
            const bulkDeleteButton = document.getElementById('bulk-delete');
            const bulkDeleteModal = document.getElementById('bulk-delete-modal');
            const cancelBulkDelete = document.getElementById('cancel-bulk-delete');
            const confirmBulkDelete = document.getElementById('confirm-bulk-delete');
            
            bulkDeleteButton.addEventListener('click', function() {
                const count = Array.from(propertyCheckboxes).filter(cb => cb.checked).length;
                
                if (count > 0) {
                    bulkDeleteModal.classList.remove('hidden');
                }
            });
            
            cancelBulkDelete.addEventListener('click', function() {
                bulkDeleteModal.classList.add('hidden');
            });
            
            confirmBulkDelete.addEventListener('click', function() {
                // In a real implementation, this would make an AJAX request to delete the selected properties
                const selectedIds = Array.from(propertyCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-id'));
                
                console.log(`Deleting properties with IDs: ${selectedIds.join(', ')}`);
                
                // For demo purposes, let's just hide the rows
                selectedIds.forEach(id => {
                    const row = document.querySelector(`.property-select[data-id="${id}"]`).closest('tr');
                    row.classList.add('hidden');
                });
                
                // Reset selected count
                selectAll.checked = false;
                updateSelectedCount();
                
                bulkDeleteModal.classList.add('hidden');
                
                // Show a confirmation message
                alert(`${selectedIds.length} properties deleted successfully`);
            });
            
            // Bulk activate/deactivate
            document.getElementById('bulk-activate').addEventListener('click', function() {
                const selectedIds = Array.from(propertyCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-id'));
                
                console.log(`Activating properties with IDs: ${selectedIds.join(', ')}`);
                
                // Show a confirmation message
                alert(`${selectedIds.length} properties activated successfully`);
            });
            
            document.getElementById('bulk-deactivate').addEventListener('click', function() {
                const selectedIds = Array.from(propertyCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-id'));
                
                console.log(`Deactivating properties with IDs: ${selectedIds.join(', ')}`);
                
                // Show a confirmation message
                alert(`${selectedIds.length} properties deactivated successfully`);
            });
            
            // Bulk export
            document.getElementById('bulk-export').addEventListener('click', function() {
                const selectedIds = Array.from(propertyCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-id'));
                
                console.log(`Exporting properties with IDs: ${selectedIds.join(', ')}`);
                
                // Show a confirmation message
                alert(`${selectedIds.length} properties exported successfully`);
            });
            
            // Apply filters
            document.getElementById('apply-filters').addEventListener('click', function() {
                // In a real implementation, this would make an AJAX request or submit a form
                alert('Filters applied');
            });
        });
    </script>
</body>
</html>