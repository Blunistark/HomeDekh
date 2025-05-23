
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | HomeDhek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .card-stats {
            transition: all 0.3s ease;
        }
        
        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
        
        /* Chart canvas */
        .chart-container {
            height: 240px;
            position: relative;
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
                        <a href="./" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-[#1a4977] text-white">
                            <i class="fas fa-home mr-3"></i>
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
                <!-- Welcome Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Welcome back, Admin!</h1>
                    <p class="text-gray-600">Here's what's happening with your properties today.</p>
                </div>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Total Properties Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm card-stats">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Properties</p>
                                <p class="text-2xl font-bold text-gray-800 mt-2">27</p>
                            </div>
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-4 flex items-center">
                            <span class="font-medium">↑ 8%</span>
                            <span class="ml-1">from last month</span>
                        </p>
                    </div>

                    <!-- Active Listings Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm card-stats">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Active Listings</p>
                                <p class="text-2xl font-bold text-gray-800 mt-2">22</p>
                            </div>
                            <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-4 flex items-center">
                            <span class="font-medium">↑ 5%</span>
                            <span class="ml-1">from last month</span>
                        </p>
                    </div>

                    <!-- Total Users Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm card-stats">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Registered Users</p>
                                <p class="text-2xl font-bold text-gray-800 mt-2">124</p>
                            </div>
                            <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-4 flex items-center">
                            <span class="font-medium">↑ 12%</span>
                            <span class="ml-1">from last month</span>
                        </p>
                    </div>

                    <!-- Inquiries Card -->
                    <div class="bg-white rounded-lg p-6 shadow-sm card-stats">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Inquiries (May)</p>
                                <p class="text-2xl font-bold text-gray-800 mt-2">78</p>
                            </div>
                            <div class="h-12 w-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-600">
                                <i class="fas fa-comment-dots"></i>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-4 flex items-center">
                            <span class="font-medium">↑ 18%</span>
                            <span class="ml-1">from last month</span>
                        </p>
                    </div>
                </div>

                <!-- Analytics Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Property Inquiries Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Property Inquiries</h2>
                            <select class="text-sm border rounded-md px-2 py-1">
                                <option>Last 7 days</option>
                                <option>Last 30 days</option>
                                <option>Last 3 months</option>
                            </select>
                        </div>
                        <div class="chart-container">
                            <!-- Chart would be rendered here by JavaScript -->
                            <div class="h-full flex flex-col">
                                <div class="flex justify-between items-end h-full pb-6 px-2 mb-2">
                                    <div class="h-1/3 w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-2/3 w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-1/2 w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-5/6 w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-2/3 w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-full w-8 bg-blue-500 rounded-t-sm"></div>
                                    <div class="h-4/5 w-8 bg-blue-500 rounded-t-sm"></div>
                                </div>
                                <div class="grid grid-cols-7 text-xs text-gray-500">
                                    <div class="text-center">Mon</div>
                                    <div class="text-center">Tue</div>
                                    <div class="text-center">Wed</div>
                                    <div class="text-center">Thu</div>
                                    <div class="text-center">Fri</div>
                                    <div class="text-center">Sat</div>
                                    <div class="text-center">Sun</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Types Chart -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Properties by Type</h2>
                        </div>
                        <div class="chart-container">
                            <!-- Chart would be rendered here by JavaScript -->
                            <div class="h-full flex justify-center items-center">
                                <div class="w-48 h-48 rounded-full border-8 border-blue-500 flex items-center justify-center relative">
                                    <div class="w-48 h-48 absolute" style="clip-path: polygon(50% 50%, 100% 0%, 100% 100%, 50% 100%); background-color: #10B981;"></div>
                                    <div class="w-48 h-48 absolute" style="clip-path: polygon(50% 50%, 0% 0%, 100% 0%, 50% 50%); background-color: #F59E0B;"></div>
                                    <div class="w-36 h-36 rounded-full bg-white"></div>
                                </div>
                                <div class="ml-8 space-y-3">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-500 rounded-sm mr-2"></div>
                                        <span class="text-sm">PGs (55%)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-500 rounded-sm mr-2"></div>
                                        <span class="text-sm">Hostels (25%)</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-amber-500 rounded-sm mr-2"></div>
                                        <span class="text-sm">Apartments (20%)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Recent Properties -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm">
                        <div class="flex justify-between items-center px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Recent Properties</h2>
                            <a href="properties.php" class="text-sm text-[#1a4977]">View all</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Added</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Property 1 -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-md overflow-hidden">
                                                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Sunshine PG for Girls</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">PG</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 15, 2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="edit-property.php?id=1" class="text-[#1a4977] hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                    
                                    <!-- Property 2 -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-md overflow-hidden">
                                                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Campus View Residency</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Hostel</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 14, 2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="edit-property.php?id=2" class="text-[#1a4977] hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                    
                                    <!-- Property 3 -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-md overflow-hidden">
                                                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Green Valley Boys Hostel</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Hostel</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 13, 2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="edit-property.php?id=3" class="text-[#1a4977] hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                    
                                    <!-- Property 4 -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-md overflow-hidden">
                                                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Property" class="h-full w-full object-cover">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Bliss Ladies Hostel</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">PG</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">May 12, 2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="edit-property.php?id=4" class="text-[#1a4977] hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Inquiries -->
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="flex justify-between items-center px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold text-gray-900">Recent Inquiries</h2>
                            <a href="inquiries.php" class="text-sm text-[#1a4977]">View all</a>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <!-- Inquiry 1 -->
                            <div class="px-6 py-4">
                                <div class="flex justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-900">Raj Sharma</p>
                                    <p class="text-xs text-gray-500">2 hours ago</p>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Inquiry about Sunshine PG for Girls</p>
                                <div class="flex">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-phone-alt mr-1"></i>
                                        Via Call
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Responded
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Inquiry 2 -->
                            <div class="px-6 py-4">
                                <div class="flex justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-900">Priya Patel</p>
                                    <p class="text-xs text-gray-500">5 hours ago</p>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Inquiry about Campus View Residency</p>
                                <div class="flex">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fab fa-whatsapp mr-1"></i>
                                        Via WhatsApp
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Inquiry 3 -->
                            <div class="px-6 py-4">
                                <div class="flex justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-900">Amit Singh</p>
                                    <p class="text-xs text-gray-500">1 day ago</p>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Inquiry about Green Valley Boys Hostel</p>
                                <div class="flex">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-envelope mr-1"></i>
                                        Via Email
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Responded
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Inquiry 4 -->
                            <div class="px-6 py-4">
                                <div class="flex justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-900">Sanjay Kumar</p>
                                    <p class="text-xs text-gray-500">2 days ago</p>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Inquiry about Bliss Ladies Hostel</p>
                                <div class="flex">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fab fa-whatsapp mr-1"></i>
                                        Via WhatsApp
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-user-slash mr-1"></i>
                                        Not Interested
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions and System Information -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                        <div class="space-y-3">
                            <a href="add-property.php" class="flex items-center p-3 bg-blue-50 text-[#1a4977] rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-plus-circle mr-3"></i>
                                <span>Add New Property</span>
                            </a>
                            <a href="pending-approvals.php" class="flex items-center p-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors">
                                <i class="fas fa-clipboard-check mr-3"></i>
                                <span>Pending Approvals</span>
                                <span class="ml-auto bg-yellow-200 text-yellow-800 text-xs px-2 py-0.5 rounded-full">3</span>
                            </a>
                            <a href="export-data.php" class="flex items-center p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">
                                <i class="fas fa-download mr-3"></i>
                                <span>Download Reports</span>
                            </a>
                            <a href="user-management.php" class="flex items-center p-3 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors">
                                <i class="fas fa-user-plus mr-3"></i>
                                <span>Add New Admin User</span>
                            </a>
                        </div>
                    </div>

                    <!-- Popular Features -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Most Popular Amenities</h2>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-wifi text-[#1a4977] mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">WiFi</span>
                                    </div>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#1a4977] h-2 rounded-full" style="width: 94%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-2">94%</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-utensils text-[#1a4977] mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Food</span>
                                    </div>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#1a4977] h-2 rounded-full" style="width: 86%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-2">86%</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-bath text-[#1a4977] mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Attached Bathroom</span>
                                    </div>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#1a4977] h-2 rounded-full" style="width: 78%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-2">78%</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-wind text-[#1a4977] mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">AC</span>
                                    </div>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#1a4977] h-2 rounded-full" style="width: 65%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-2">65%</span>
                            </div>
                            
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-tv text-[#1a4977] mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">TV</span>
                                    </div>
                                </div>
                                <div class="w-1/2 bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#1a4977] h-2 rounded-full" style="width: 52%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 ml-2">52%</span>
                            </div>
                        </div>
                    </div>

                    <!-- System Status -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">System Information</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">System Status</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Operational
                                </span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Last Backup</span>
                                <span class="text-sm text-gray-900">May 16, 2025 (23:00)</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">PHP Version</span>
                                <span class="text-sm text-gray-900">8.2.5</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Database</span>
                                <span class="text-sm text-gray-900">MySQL 8.0.29</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Server Load</span>
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">25%</span>
                                </div>
                            </div>
                            
                            <div class="pt-3">
                                <a href="maintenance.php" class="text-sm text-[#1a4977] hover:underline">System Maintenance</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            });
            
            // Charts would be initialized here with a library like Chart.js
            // This is a placeholder for where chart initialization would go
            function initCharts() {
                console.log('Charts would be initialized here');
                // In a real implementation, we'd use a library like Chart.js
                // For example:
                // const inquiriesCtx = document.getElementById('inquiries-chart').getContext('2d');
                // new Chart(inquiriesCtx, { type: 'bar', data: {...}, options: {...} });
            }
            
            // Call function to initialize charts
            // initCharts();
            
            // Check for notifications
            checkNotifications();
            
            // Periodically check for new notifications
            setInterval(checkNotifications, 60000); // Check every minute
        });
        
        // Function to check for notifications
        function checkNotifications() {
            // This would make an AJAX request to the server to check for new notifications
            console.log('Checking for notifications...');
            // In a real implementation, we'd make an AJAX request to the server
        }
    </script>
</body>
</html>