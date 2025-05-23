<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals | HomeDhek Admin</title>
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
                <button class="text-gray-500 focus:outline-none focus:text-gray-700">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="relative">
                    <button class="flex items-center text-gray-700 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white">
                            A
                        </div>
                        <span class="ml-2 text-sm font-medium hidden md:block">Admin User</span>
                        <i class="fas fa-chevron-down ml-2 text-xs hidden md:block"></i>
                    </button>
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
                        <a href="properties.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-building mr-3 text-gray-500"></i>
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
                            <a href="add-property.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-plus-circle mr-3 text-gray-500"></i>
                                Add New Property
                            </a>
                            <a href="pending-approvals.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-blue-50 text-[#1a4977]">
                                <i class="fas fa-clock mr-3 text-[#1a4977]"></i>
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
                <!-- Breadcrumb -->
                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="./" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-medium">Pending Approvals</span>
                </div>

                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
                    <h1 class="text-2xl font-bold text-gray-900">Pending Approvals</h1>
                    
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <div class="relative">
                            <input type="text" placeholder="Search properties..." class="w-full sm:w-64 border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                                <option value="all">All Property Types</option>
                                <option value="pg">PG</option>
                                <option value="hostel">Hostel</option>
                                <option value="apartment">Apartment</option>
                            </select>
                            
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                                <option value="all">All Statuses</option>
                                <option value="pending_review" selected>Pending Review</option>
                                <option value="changes_requested">Changes Requested</option>
                                <option value="approval_pending">Approval Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center">
                        <div class="rounded-full bg-yellow-100 p-3 mr-4">
                            <i class="fas fa-clock text-yellow-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pending Review</p>
                            <p class="text-2xl font-semibold">3</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center">
                        <div class="rounded-full bg-blue-100 p-3 mr-4">
                            <i class="fas fa-edit text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Changes Requested</p>
                            <p class="text-2xl font-semibold">2</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center">
                        <div class="rounded-full bg-green-100 p-3 mr-4">
                            <i class="fas fa-check text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Approved Today</p>
                            <p class="text-2xl font-semibold">5</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-sm p-4 flex items-center">
                        <div class="rounded-full bg-red-100 p-3 mr-4">
                            <i class="fas fa-times text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Rejected</p>
                            <p class="text-2xl font-semibold">1</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Properties Table -->
                <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Property
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Owner
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Property 1 -->
                                <tr class="hover:bg-gray-50 cursor-pointer property-row" data-id="1">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md mr-4">
                                                <img src="https://via.placeholder.com/150?text=PG" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Sunshine PG for Girls</div>
                                                <div class="text-sm text-gray-500">HSR Layout, Bangalore</div>
                                                <div class="flex items-center mt-1">
                                                    <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 text-xs mr-2">PG</span>
                                                    <span class="px-2 py-0.5 rounded bg-pink-100 text-pink-800 text-xs">Girls</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full overflow-hidden mr-3">
                                                <img src="https://via.placeholder.com/150?text=A" alt="Owner" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Ananya Sharma</div>
                                                <div class="text-sm text-gray-500">Property Owner</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending Review
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>May 16, 2025</div>
                                        <div class="text-xs text-gray-400">2 days ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="review-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="approve-btn text-green-600 hover:text-green-800" data-id="1">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="reject-btn text-red-600 hover:text-red-800" data-id="1">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Property 2 -->
                                <tr class="hover:bg-gray-50 cursor-pointer property-row" data-id="2">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md mr-4">
                                                <img src="https://via.placeholder.com/150?text=Hostel" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Student Haven Hostel</div>
                                                <div class="text-sm text-gray-500">Koramangala, Bangalore</div>
                                                <div class="flex items-center mt-1">
                                                    <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 text-xs mr-2">Hostel</span>
                                                    <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-xs">Boys</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full overflow-hidden mr-3">
                                                <img src="https://via.placeholder.com/150?text=R" alt="Owner" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Rahul Patel</div>
                                                <div class="text-sm text-gray-500">Property Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Changes Requested
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>May 14, 2025</div>
                                        <div class="text-xs text-gray-400">4 days ago</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="review-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="approve-btn text-green-600 hover:text-green-800" data-id="2">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="reject-btn text-red-600 hover:text-red-800" data-id="2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Property 3 -->
                                <tr class="hover:bg-gray-50 cursor-pointer property-row" data-id="3">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-md mr-4">
                                                <img src="https://via.placeholder.com/150?text=Apt" alt="Property" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Urban Co-Living Spaces</div>
                                                <div class="text-sm text-gray-500">Indiranagar, Bangalore</div>
                                                <div class="flex items-center mt-1">
                                                    <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 text-xs mr-2">Apartment</span>
                                                    <span class="px-2 py-0.5 rounded bg-green-100 text-green-800 text-xs">Co-ed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full overflow-hidden mr-3">
                                                <img src="https://via.placeholder.com/150?text=P" alt="Owner" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Priya Mehta</div>
                                                <div class="text-sm text-gray-500">Property Agent</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending Review
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>May 17, 2025</div>
                                        <div class="text-xs text-gray-400">Yesterday</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="review-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="approve-btn text-green-600 hover:text-green-800" data-id="3">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="reject-btn text-red-600 hover:text-red-800" data-id="3">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty State (Hidden by default) -->
                    <div id="empty-state" class="hidden py-12 text-center">
                        <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                            <i class="fas fa-check-circle text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">All caught up!</h3>
                        <p class="text-gray-500 max-w-md mx-auto">There are no pending properties requiring your approval at this time.</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">3</span> properties
                    </div>
                    <div class="flex space-x-1">
                        <button class="border border-gray-300 rounded-md px-3 py-1 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Previous
                        </button>
                        <button class="border border-gray-300 rounded-md px-3 py-1 bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Property Review Modal -->
    <div id="property-review-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start mb-4">
                        <div class="mt-3 sm:mt-0 sm:ml-4 sm:text-left flex-grow">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-property-name">
                                Sunshine PG for Girls
                            </h3>
                            <p class="text-sm text-gray-500" id="modal-property-location">
                                HSR Layout, Bangalore
                            </p>
                        </div>
                        <div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800" id="modal-property-status">
                                Pending Review
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Main Image -->
                            <div class="md:col-span-1">
                                <div class="rounded-lg overflow-hidden border border-gray-200 h-48">
                                    <img id="modal-property-image" src="https://via.placeholder.com/500x300?text=Property" alt="Property" class="w-full h-full object-cover">
                                </div>
                                
                                <div class="mt-3">
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Property Details</h4>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <div class="flex justify-between">
                                            <span>Property Type:</span>
                                            <span class="font-medium" id="modal-property-type">PG</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Category:</span>
                                            <span class="font-medium" id="modal-property-category">Girls Only</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Base Price:</span>
                                            <span class="font-medium" id="modal-property-price">₹12,000/month</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Submission Date:</span>
                                            <span class="font-medium" id="modal-submission-date">May 16, 2025</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Property Information -->
                            <div class="md:col-span-2">
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Description</h4>
                                    <p class="text-sm text-gray-600" id="modal-property-description">
                                        Sunshine PG for Girls offers comfortable accommodation for female students and working professionals in the heart of HSR Layout. With fully furnished rooms, high-speed internet, and nutritious home-cooked meals, we provide a safe and supportive environment. Our facility includes 24/7 security, power backup, and regular housekeeping services.
                                    </p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Rooms & Pricing</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room Type</th>
                                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modal-rooms-container" class="bg-white divide-y divide-gray-200">
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Single Sharing</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">₹15,000/month</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">3</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Double Sharing</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">₹12,000/month</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">5</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Triple Sharing</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">₹9,000/month</td>
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">2</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Amenities</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-wifi text-[#1a4977] mr-2"></i>
                                            <span>WiFi</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-utensils text-[#1a4977] mr-2"></i>
                                            <span>Food</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-tv text-[#1a4977] mr-2"></i>
                                            <span>TV</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-wind text-[#1a4977] mr-2"></i>
                                            <span>AC</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-shield-alt text-[#1a4977] mr-2"></i>
                                            <span>24/7 Security</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-tshirt text-[#1a4977] mr-2"></i>
                                            <span>Laundry</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Owner Details</h4>
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full overflow-hidden mr-3">
                                            <img id="modal-owner-image" src="https://via.placeholder.com/150?text=A" alt="Owner" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" id="modal-owner-name">Ananya Sharma</div>
                                            <div class="text-sm text-gray-500" id="modal-owner-role">Property Owner</div>
                                            <div class="text-sm text-gray-500" id="modal-owner-phone">+91 9876543210</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="modal-approve-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Approve
                    </button>
                    <button type="button" id="modal-request-changes-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Request Changes
                    </button>
                    <button type="button" id="modal-reject-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject
                    </button>
                    <button type="button" id="modal-close-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedback-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="feedback-icon-container" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i id="feedback-icon" class="fas fa-comment-dots text-yellow-500"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="feedback-title">
                                Request Changes
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="feedback-description">
                                    Please provide feedback on what changes are required before approval.
                                </p>
                            </div>
                            <div class="mt-4">
                                <textarea id="feedback-text" rows="4" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Enter your feedback here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="feedback-submit-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#1a4977] text-base font-medium text-white hover:bg-[#0e2e4a] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Submit
                    </button>
                    <button type="button" id="feedback-cancel-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
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
            
            // Property Review Modal
            const propertyReviewModal = document.getElementById('property-review-modal');
            const reviewButtons = document.querySelectorAll('.review-btn');
            const approveButtons = document.querySelectorAll('.approve-btn');
            const rejectButtons = document.querySelectorAll('.reject-btn');
            const propertyRows = document.querySelectorAll('.property-row');
            
            // Open Property Modal when clicking on property row or review button
            reviewButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const propertyId = this.getAttribute('data-id');
                    openPropertyModal(propertyId);
                });
            });
            
            propertyRows.forEach(row => {
                row.addEventListener('click', function() {
                    const propertyId = this.getAttribute('data-id');
                    openPropertyModal(propertyId);
                });
            });
            
            // Close Property Modal
            document.getElementById('modal-close-btn').addEventListener('click', closePropertyModal);
            
            // Handle Approve directly from the table
            approveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const propertyId = this.getAttribute('data-id');
                    approveProperty(propertyId);
                });
            });
            
            // Handle Reject directly from the table
            rejectButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const propertyId = this.getAttribute('data-id');
                    openFeedbackModal('reject', propertyId);
                });
            });
            
            // Modal actions
            document.getElementById('modal-approve-btn').addEventListener('click', function() {
                const propertyId = propertyReviewModal.getAttribute('data-property-id');
                approveProperty(propertyId);
            });
            
            document.getElementById('modal-reject-btn').addEventListener('click', function() {
                const propertyId = propertyReviewModal.getAttribute('data-property-id');
                openFeedbackModal('reject', propertyId);
            });
            
            document.getElementById('modal-request-changes-btn').addEventListener('click', function() {
                const propertyId = propertyReviewModal.getAttribute('data-property-id');
                openFeedbackModal('request-changes', propertyId);
            });
            
            // Feedback Modal
            const feedbackModal = document.getElementById('feedback-modal');
            document.getElementById('feedback-cancel-btn').addEventListener('click', closeFeedbackModal);
            
            document.getElementById('feedback-submit-btn').addEventListener('click', function() {
                const actionType = feedbackModal.getAttribute('data-action');
                const propertyId = feedbackModal.getAttribute('data-property-id');
                const feedback = document.getElementById('feedback-text').value;
                
                if (!feedback.trim()) {
                    alert('Please provide feedback');
                    return;
                }
                
                if (actionType === 'reject') {
                    rejectProperty(propertyId, feedback);
                } else if (actionType === 'request-changes') {
                    requestChanges(propertyId, feedback);
                }
            });
            
            // Function to open property modal
            function openPropertyModal(propertyId) {
                // In a real app, you would fetch the property details via AJAX
                // For now, we'll simulate with different data based on propertyId
                
                // Set the property ID on the modal
                propertyReviewModal.setAttribute('data-property-id', propertyId);
                
                // Display the modal
                propertyReviewModal.classList.remove('hidden');
                
                // Simulate data loading for different properties
                updatePropertyModalData(propertyId);
            }
            
            // Function to close property modal
            function closePropertyModal() {
                propertyReviewModal.classList.add('hidden');
            }
            
            // Function to update modal data based on propertyId
            function updatePropertyModalData(propertyId) {
                const propertyData = {
                    '1': {
                        name: 'Sunshine PG for Girls',
                        location: 'HSR Layout, Bangalore',
                        status: 'Pending Review',
                        type: 'PG',
                        category: 'Girls Only',
                        price: '₹12,000/month',
                        date: 'May 16, 2025',
                        description: 'Sunshine PG for Girls offers comfortable accommodation for female students and working professionals in the heart of HSR Layout. With fully furnished rooms, high-speed internet, and nutritious home-cooked meals, we provide a safe and supportive environment. Our facility includes 24/7 security, power backup, and regular housekeeping services.',
                        ownerName: 'Ananya Sharma',
                        ownerRole: 'Property Owner',
                        ownerPhone: '+91 9876543210'
                    },
                    '2': {
                        name: 'Student Haven Hostel',
                        location: 'Koramangala, Bangalore',
                        status: 'Changes Requested',
                        type: 'Hostel',
                        category: 'Boys Only',
                        price: '₹10,000/month',
                        date: 'May 14, 2025',
                        description: 'Student Haven Hostel is designed for male students pursuing higher education in Bangalore. Located in the vibrant neighborhood of Koramangala, our hostel provides easy access to major educational institutions and tech parks. We offer comfortable accommodation with study areas, recreational facilities, and nutritious meals.',
                        ownerName: 'Rahul Patel',
                        ownerRole: 'Property Manager',
                        ownerPhone: '+91 9876543211'
                    },
                    '3': {
                        name: 'Urban Co-Living Spaces',
                        location: 'Indiranagar, Bangalore',
                        status: 'Pending Review',
                        type: 'Apartment',
                        category: 'Co-ed',
                        price: '₹15,000/month',
                        date: 'May 17, 2025',
                        description: 'Urban Co-Living Spaces offers modern, fully-furnished apartments for young professionals and students in the trendy locality of Indiranagar. Our co-ed living spaces combine private bedrooms with shared common areas, creating a balance between privacy and community. Enjoy high-speed WiFi, regular housekeeping, and community events.',
                        ownerName: 'Priya Mehta',
                        ownerRole: 'Property Agent',
                        ownerPhone: '+91 9876543212'
                    }
                };
                
                const data = propertyData[propertyId];
                
                // Update modal content
                document.getElementById('modal-property-name').textContent = data.name;
                document.getElementById('modal-property-location').textContent = data.location;
                document.getElementById('modal-property-status').textContent = data.status;
                document.getElementById('modal-property-type').textContent = data.type;
                document.getElementById('modal-property-category').textContent = data.category;
                document.getElementById('modal-property-price').textContent = data.price;
                document.getElementById('modal-submission-date').textContent = data.date;
                document.getElementById('modal-property-description').textContent = data.description;
                document.getElementById('modal-owner-name').textContent = data.ownerName;
                document.getElementById('modal-owner-role').textContent = data.ownerRole;
                document.getElementById('modal-owner-phone').textContent = data.ownerPhone;
                
                // Update status class
                const statusElement = document.getElementById('modal-property-status');
                statusElement.className = '';
                if (data.status === 'Pending Review') {
                    statusElement.classList.add('px-2', 'py-1', 'inline-flex', 'text-xs', 'leading-5', 'font-semibold', 'rounded-full', 'bg-yellow-100', 'text-yellow-800');
                } else if (data.status === 'Changes Requested') {
                    statusElement.classList.add('px-2', 'py-1', 'inline-flex', 'text-xs', 'leading-5', 'font-semibold', 'rounded-full', 'bg-blue-100', 'text-blue-800');
                }
                
                // For a real app, you would also update images, rooms, and amenities dynamically
            }
            
            // Function to open feedback modal
            function openFeedbackModal(action, propertyId) {
                feedbackModal.setAttribute('data-action', action);
                feedbackModal.setAttribute('data-property-id', propertyId);
                
                const feedbackTitle = document.getElementById('feedback-title');
                const feedbackDescription = document.getElementById('feedback-description');
                const feedbackIcon = document.getElementById('feedback-icon');
                const feedbackIconContainer = document.getElementById('feedback-icon-container');
                
                // Clear previous input
                document.getElementById('feedback-text').value = '';
                
                if (action === 'reject') {
                    feedbackTitle.textContent = 'Reject Property';
                    feedbackDescription.textContent = 'Please provide reason for rejection.';
                    feedbackIcon.className = 'fas fa-times text-red-500';
                    feedbackIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10';
                } else {
                    feedbackTitle.textContent = 'Request Changes';
                    feedbackDescription.textContent = 'Please provide feedback on what changes are required before approval.';
                    feedbackIcon.className = 'fas fa-comment-dots text-yellow-500';
                    feedbackIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10';
                }
                
                feedbackModal.classList.remove('hidden');
            }
            
            // Function to close feedback modal
            function closeFeedbackModal() {
                feedbackModal.classList.add('hidden');
            }
            
            // Function to approve property
            function approveProperty(propertyId) {
                // In a real app, you would send an AJAX request to approve the property
                
                // For demo purposes, show an alert and remove the property row
                alert(`Property #${propertyId} has been approved and published`);
                
                // Close modals
                closePropertyModal();
                
                // Remove the property row from the table
                const propertyRow = document.querySelector(`.property-row[data-id="${propertyId}"]`);
                propertyRow.remove();
                
                // Update counts
                updateCounts();
                
                // Check if there are any properties left
                checkEmptyState();
            }
            
            // Function to reject property
            function rejectProperty(propertyId, feedback) {
                // In a real app, you would send an AJAX request to reject the property
                
                // For demo purposes, show an alert and remove the property row
                alert(`Property #${propertyId} has been rejected. Feedback: ${feedback}`);
                
                // Close modals
                closeFeedbackModal();
                closePropertyModal();
                
                // Remove the property row from the table
                const propertyRow = document.querySelector(`.property-row[data-id="${propertyId}"]`);
                propertyRow.remove();
                
                // Update counts
                updateCounts();
                
                // Check if there are any properties left
                checkEmptyState();
            }
            
            // Function to request changes
            function requestChanges(propertyId, feedback) {
                // In a real app, you would send an AJAX request to request changes
                
                // For demo purposes, show an alert and update the property status
                alert(`Requested changes for Property #${propertyId}. Feedback: ${feedback}`);
                
                // Close modals
                closeFeedbackModal();
                closePropertyModal();
                
                // Update property status in the table
                const statusCell = document.querySelector(`.property-row[data-id="${propertyId}"] td:nth-child(3) span`);
                statusCell.textContent = 'Changes Requested';
                statusCell.className = 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800';
                
                // Update counts
                updateCounts();
            }
            
            // Function to update counts
            function updateCounts() {
                const pendingCount = document.querySelectorAll('.property-row td:nth-child(3) span:contains("Pending Review")').length;
                const changesCount = document.querySelectorAll('.property-row td:nth-child(3) span:contains("Changes Requested")').length;
                
                // Update count in sidebar
                const sidebarBadge = document.querySelector('.group.flex.items-center.bg-blue-50 span');
                sidebarBadge.textContent = pendingCount + changesCount;
                
                // Update count in stats
                const pendingStats = document.querySelector('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4 > div:nth-child(1) p.text-2xl');
                const changesStats = document.querySelector('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-4 > div:nth-child(2) p.text-2xl');
                
                pendingStats.textContent = pendingCount;
                changesStats.textContent = changesCount;
            }
            
            // Function to check if there are any properties left
            function checkEmptyState() {
                const propertyRows = document.querySelectorAll('.property-row');
                const emptyState = document.getElementById('empty-state');
                const table = document.querySelector('table');
                const pagination = document.querySelector('.flex.items-center.justify-between');
                
                if (propertyRows.length === 0) {
                    table.classList.add('hidden');
                    pagination.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                } else {
                    table.classList.remove('hidden');
                    pagination.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                }
            }
            
            // Utility function to check if element contains text
            // This is needed because :contains is not standard
            jQuery.expr[':'].contains = function(a, i, m) {
                return jQuery(a).text().indexOf(m[3]) >= 0;
            };
        });
    </script>
</body>
</html>