<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | HomeDhek Admin</title>
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
                        <a href="users.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-blue-50 text-[#1a4977]">
                            <i class="fas fa-users mr-3 text-[#1a4977]"></i>
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
                <!-- Breadcrumb -->
                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="./" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-medium">User Management</span>
                </div>

                <!-- Page Header -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
                        <p class="text-sm text-gray-500 mt-1">View and manage registered users</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <button id="add-user-btn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#1a4977] hover:bg-[#0e2e4a] focus:outline-none">
                            <i class="fas fa-user-plus mr-2"></i>
                            Add New User
                        </button>
                        
                        <button id="export-users-btn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            <i class="fas fa-download mr-2"></i>
                            Export Users
                        </button>
                    </div>
                </div>

                <!-- Search & Filters -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                        <div class="relative flex-grow">
                            <input type="text" placeholder="Search by name, email, or phone..." class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                                <option value="all">All Users</option>
                                <option value="owner">Property Owner</option>
                                <option value="tenant">Tenant</option>
                                <option value="agent">Agent</option>
                                <option value="admin">Admin</option>
                            </select>
                            
                            <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="new">New (Last 30 days)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Details</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- User 1 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 mr-3">
                                                <img src="https://via.placeholder.com/150?text=A" alt="User avatar" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Ananya Sharma</div>
                                                <div class="text-xs text-gray-500">Joined: Mar 15, 2025</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">ananya.sharma@gmail.com</div>
                                        <div class="text-sm text-gray-500">+91 9876543210</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">#42, Palm Grove Apartments</div>
                                        <div class="text-sm text-gray-500">Bangalore, Karnataka</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Property Owner</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-sm text-gray-900">Active</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="view-user-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="1">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="edit-user-btn text-gray-600 hover:text-gray-900" data-id="1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="reset-password-btn text-amber-600 hover:text-amber-800" data-id="1">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User 2 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 mr-3">
                                                <img src="https://via.placeholder.com/150?text=R" alt="User avatar" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Rahul Patel</div>
                                                <div class="text-xs text-gray-500">Joined: Apr 28, 2025</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">rahul.patel@yahoo.com</div>
                                        <div class="text-sm text-gray-500">+91 9876543211</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">203, Royal Heights</div>
                                        <div class="text-sm text-gray-500">Bangalore, Karnataka</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">Tenant</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-sm text-gray-900">Active</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="view-user-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="edit-user-btn text-gray-600 hover:text-gray-900" data-id="2">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="reset-password-btn text-amber-600 hover:text-amber-800" data-id="2">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User 3 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 mr-3">
                                                <img src="https://via.placeholder.com/150?text=P" alt="User avatar" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Priya Mehta</div>
                                                <div class="text-xs text-gray-500">Joined: Feb 10, 2025</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">priya.mehta@outlook.com</div>
                                        <div class="text-sm text-gray-500">+91 9876543212</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">87, Green View Layout</div>
                                        <div class="text-sm text-gray-500">Bangalore, Karnataka</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Agent</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-sm text-gray-900">Active</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="view-user-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="edit-user-btn text-gray-600 hover:text-gray-900" data-id="3">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="reset-password-btn text-amber-600 hover:text-amber-800" data-id="3">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User 4 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 mr-3">
                                                <img src="https://via.placeholder.com/150?text=V" alt="User avatar" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Vijay Kumar</div>
                                                <div class="text-xs text-gray-500">Joined: Jan 5, 2025</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">vijayk@hotmail.com</div>
                                        <div class="text-sm text-gray-500">+91 9876543213</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">D-15, Sea View Apartments</div>
                                        <div class="text-sm text-gray-500">Mumbai, Maharashtra</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800">Tenant</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                                            <span class="text-sm text-gray-900">Inactive</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="view-user-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="4">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="edit-user-btn text-gray-600 hover:text-gray-900" data-id="4">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="reset-password-btn text-amber-600 hover:text-amber-800" data-id="4">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User 5 -->
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full overflow-hidden flex-shrink-0 mr-3">
                                                <img src="https://via.placeholder.com/150?text=S" alt="User avatar" class="h-full w-full object-cover">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Sanjay Gupta</div>
                                                <div class="text-xs text-gray-500">Joined: May 12, 2025</div>
                                                <div class="mt-1 inline-flex">
                                                    <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">New</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">sanjay.gupta@gmail.com</div>
                                        <div class="text-sm text-gray-500">+91 9876543214</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">B-201, Skyline Towers</div>
                                        <div class="text-sm text-gray-500">Delhi, NCR</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Property Owner</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                                            <span class="text-sm text-gray-900">Active</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <button class="view-user-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="5">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="edit-user-btn text-gray-600 hover:text-gray-900" data-id="5">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="reset-password-btn text-amber-600 hover:text-amber-800" data-id="5">
                                                <i class="fas fa-key"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <span class="text-sm text-gray-700">Show</span>
                        <select class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="text-sm text-gray-700">entries</span>
                    </div>
                    
                    <div class="flex justify-between md:justify-end space-x-2">
                        <span class="text-sm text-gray-700 self-center mr-2">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">25</span> users
                        </span>
                        <nav class="flex space-x-1">
                            <a href="#" class="px-3 py-1 text-sm text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" aria-disabled="true">
                                Previous
                            </a>
                            <a href="#" class="px-3 py-1 text-sm text-white bg-[#1a4977] border border-[#1a4977] rounded-md hover:bg-[#0e2e4a]">
                                1
                            </a>
                            <a href="#" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                2
                            </a>
                            <a href="#" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                3
                            </a>
                            <a href="#" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                Next
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- User Detail Modal -->
    <div id="user-detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                <div class="bg-white">
                    <!-- Header -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900" id="modal-user-name">
                            User Details
                        </h3>
                        <button id="modal-close-btn" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column: User Profile -->
                            <div class="md:col-span-1">
                                <div class="flex flex-col items-center">
                                    <div class="h-32 w-32 rounded-full overflow-hidden mb-4">
                                        <img id="modal-user-image" src="https://via.placeholder.com/150?text=A" alt="User avatar" class="h-full w-full object-cover">
                                    </div>
                                    
                                    <div class="text-center mb-6">
                                        <div class="text-xl font-semibold text-gray-900" id="modal-user-fullname">Ananya Sharma</div>
                                        <div class="text-sm text-gray-500" id="modal-user-role">Property Owner</div>
                                        <div class="mt-1">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800" id="modal-user-status">
                                                Active
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="w-full space-y-3 mb-6">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-envelope text-gray-400 w-5"></i>
                                            <span class="text-gray-700" id="modal-user-email">ananya.sharma@gmail.com</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-phone text-gray-400 w-5"></i>
                                            <span class="text-gray-700" id="modal-user-phone">+91 9876543210</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                                            <span class="text-gray-700" id="modal-user-location">Bangalore, Karnataka</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-calendar-alt text-gray-400 w-5"></i>
                                            <span class="text-gray-700" id="modal-user-joined">Joined: March 15, 2025</span>
                                        </div>
                                    </div>
                                    
                                    <div class="w-full">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">User Actions</h4>
                                        <div class="space-y-2">
                                            <button id="modal-reset-password-btn" class="w-full bg-amber-500 text-white px-3 py-2 rounded text-sm flex items-center justify-center">
                                                <i class="fas fa-key mr-2"></i>
                                                Reset Password
                                            </button>
                                            <button id="modal-deactivate-btn" class="w-full border border-red-600 text-red-600 px-3 py-2 rounded text-sm flex items-center justify-center">
                                                <i class="fas fa-ban mr-2"></i>
                                                Deactivate User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column: User Details -->
                            <div class="md:col-span-2">
                                <!-- Full Details -->
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Complete Information</h4>
                                    
                                    <div class="space-y-6">
                                        <!-- Personal Information -->
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-700 mb-3">Personal Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <span class="text-xs text-gray-500">First Name</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-firstname">Ananya</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Last Name</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-lastname">Sharma</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Email Address</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-email-detail">ananya.sharma@gmail.com</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Phone Number</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-phone-detail">+91 9876543210</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Date of Birth</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-dob">June 15, 1990</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Gender</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-gender">Female</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Address Information -->
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-700 mb-3">Address</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="md:col-span-2">
                                                    <span class="text-xs text-gray-500">Street Address</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-street">#42, Palm Grove Apartments, 5th Cross</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">City</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-city">Bangalore</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">State</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-state">Karnataka</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Postal Code</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-postal">560001</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Country</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-country">India</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Account Information -->
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-700 mb-3">Account Information</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <span class="text-xs text-gray-500">User ID</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-id">USR12345</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Role</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-role-detail">Property Owner</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Account Status</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-status-detail">Active</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Registration Date</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-regdate">March 15, 2025</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Last Login</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-lastlogin">Today, 10:23 AM</p>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500">Email Verified</span>
                                                    <p class="text-sm text-gray-900" id="modal-user-emailverified">Yes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="modal-edit-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#1a4977] text-base font-medium text-white hover:bg-[#0e2e4a] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Edit User
                    </button>
                    <button type="button" id="modal-close-btn-bottom" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="reset-password-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-key text-amber-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="reset-pwd-user-name">
                                Reset Password for Ananya Sharma
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Choose a password reset method below. The new password will be sent to the user via the selected method.
                                </p>
                            </div>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="reset-method-email" name="reset-method" type="radio" checked class="h-4 w-4 text-[#1a4977] focus:ring-[#1a4977] border-gray-300">
                                    <label for="reset-method-email" class="ml-3 block text-sm text-gray-700">
                                        Send reset link via email 
                                        <span class="text-gray-500 text-xs">(<span id="reset-email">ananya.sharma@gmail.com</span>)</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="reset-method-sms" name="reset-method" type="radio" class="h-4 w-4 text-[#1a4977] focus:ring-[#1a4977] border-gray-300">
                                    <label for="reset-method-sms" class="ml-3 block text-sm text-gray-700">
                                        Send new password via SMS 
                                        <span class="text-gray-500 text-xs">(<span id="reset-phone">+91 9876543210</span>)</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="reset-method-manual" name="reset-method" type="radio" class="h-4 w-4 text-[#1a4977] focus:ring-[#1a4977] border-gray-300">
                                    <label for="reset-method-manual" class="ml-3 block text-sm text-gray-700">
                                        Generate manual password
                                    </label>
                                </div>
                                
                                <div id="manual-password-section" class="hidden pt-3">
                                    <div>
                                        <label for="new-password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                        <div class="relative">
                                            <input type="text" id="new-password" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md" value="Auto-123456">
                                            <button type="button" id="generate-password-btn" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#1a4977]">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="send-reset-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-medium text-white hover:bg-amber-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Reset Password
                    </button>
                    <button type="button" id="cancel-reset-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="add-user-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-user-plus text-blue-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Add New User
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">First Name*</label>
                                        <input type="text" id="first-name" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Last Name*</label>
                                        <input type="text" id="last-name" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address*</label>
                                    <input type="email" id="email" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number*</label>
                                    <input type="tel" id="phone" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address*</label>
                                    <textarea id="address" rows="2" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City*</label>
                                        <input type="text" id="city" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State*</label>
                                        <input type="text" id="state" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="user-role" class="block text-sm font-medium text-gray-700 mb-1">User Role*</label>
                                    <select id="user-role" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="">Select Role</option>
                                        <option value="tenant">Tenant</option>
                                        <option value="owner">Property Owner</option>
                                        <option value="agent">Agent</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                                        <button type="button" id="password-generate-btn" class="text-xs text-[#1a4977]">Generate Random</button>
                                    </div>
                                    <div class="relative">
                                        <input type="password" id="password" class="shadow-sm focus:ring-[#1a4977] focus:border-[#1a4977] block w-full sm:text-sm border-gray-300 rounded-md">
                                        <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="send-welcome-email" type="checkbox" class="h-4 w-4 text-[#1a4977] focus:ring-[#1a4977] border-gray-300 rounded">
                                    <label for="send-welcome-email" class="ml-2 block text-sm text-gray-700">
                                        Send welcome email with login credentials
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="add-user-submit-btn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#1a4977] text-base font-medium text-white hover:bg-[#0e2e4a] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Add User
                    </button>
                    <button type="button" id="add-user-cancel-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
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
            
            // User Detail Modal
            const userDetailModal = document.getElementById('user-detail-modal');
            const viewUserButtons = document.querySelectorAll('.view-user-btn');
            
            // Reset Password Modal
            const resetPasswordModal = document.getElementById('reset-password-modal');
            const resetPasswordButtons = document.querySelectorAll('.reset-password-btn');
            const modalResetPasswordBtn = document.getElementById('modal-reset-password-btn');
            
            // Open User Detail Modal
            viewUserButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const userId = this.getAttribute('data-id');
                    openUserDetailModal(userId);
                });
            });
            
            // Close User Detail Modal
            document.getElementById('modal-close-btn').addEventListener('click', closeUserDetailModal);
            document.getElementById('modal-close-btn-bottom').addEventListener('click', closeUserDetailModal);
            
            // Open Reset Password Modal
            resetPasswordButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const userId = this.getAttribute('data-id');
                    openResetPasswordModal(userId);
                });
            });
            
            // Modal Reset Password Button
            modalResetPasswordBtn.addEventListener('click', function() {
                const userId = userDetailModal.getAttribute('data-user-id');
                closeUserDetailModal();
                openResetPasswordModal(userId);
            });
            
            // Close Reset Password Modal
            document.getElementById('cancel-reset-btn').addEventListener('click', closeResetPasswordModal);
            
            // Reset Password Submit
            document.getElementById('send-reset-btn').addEventListener('click', function() {
                const userId = resetPasswordModal.getAttribute('data-user-id');
                const resetMethod = document.querySelector('input[name="reset-method"]:checked').id;
                
                let message = '';
                if (resetMethod === 'reset-method-email') {
                    message = 'Password reset link has been sent to the user\'s email address.';
                } else if (resetMethod === 'reset-method-sms') {
                    message = 'New password has been sent to the user\'s phone via SMS.';
                } else {
                    const newPassword = document.getElementById('new-password').value;
                    message = `Password has been reset to "${newPassword}". Remember to share it with the user securely.`;
                }
                
                alert(message);
                closeResetPasswordModal();
            });
            
            // Toggle Manual Password Section
            document.querySelectorAll('input[name="reset-method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const manualSection = document.getElementById('manual-password-section');
                    if (this.id === 'reset-method-manual') {
                        manualSection.classList.remove('hidden');
                    } else {
                        manualSection.classList.add('hidden');
                    }
                });
            });
            
            // Generate Random Password
            document.getElementById('generate-password-btn').addEventListener('click', function() {
                const passwordField = document.getElementById('new-password');
                const randomPassword = generateRandomPassword();
                passwordField.value = randomPassword;
            });
            
            // Add User Modal
            const addUserModal = document.getElementById('add-user-modal');
            
            // Open Add User Modal
            document.getElementById('add-user-btn').addEventListener('click', function() {
                addUserModal.classList.remove('hidden');
            });
            
            // Close Add User Modal
            document.getElementById('add-user-cancel-btn').addEventListener('click', function() {
                addUserModal.classList.add('hidden');
            });
            
            // Submit Add User Form
            document.getElementById('add-user-submit-btn').addEventListener('click', function() {
                // In a real app, you would validate and submit the form data via AJAX
                
                // For demo purposes, show an alert and close the modal
                alert('User added successfully!');
                addUserModal.classList.add('hidden');
            });
            
            // Generate Random Password for Add User
            document.getElementById('password-generate-btn').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                const randomPassword = generateRandomPassword();
                passwordField.value = randomPassword;
                passwordField.type = 'text'; // Show the password
                
                // Update the eye icon
                document.getElementById('toggle-password').innerHTML = '<i class="fas fa-eye-slash"></i>';
            });
            
            // Toggle Password Visibility
            document.getElementById('toggle-password').addEventListener('click', function() {
                const passwordField = document.getElementById('password');
                
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordField.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
            
            // Edit User Functionality
            const editUserButtons = document.querySelectorAll('.edit-user-btn');
            
            editUserButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const userId = this.getAttribute('data-id');
                    
                    // In a real app, you would redirect to an edit page or open an edit modal
                    alert(`Edit user #${userId}`);
                });
            });
            
            // Modal Edit Button
            document.getElementById('modal-edit-btn').addEventListener('click', function() {
                const userId = userDetailModal.getAttribute('data-user-id');
                alert(`Edit user #${userId}`);
            });
            
            // Modal Deactivate Button
            document.getElementById('modal-deactivate-btn').addEventListener('click', function() {
                const userId = userDetailModal.getAttribute('data-user-id');
                const userName = document.getElementById('modal-user-fullname').textContent;
                
                if (confirm(`Are you sure you want to deactivate user "${userName}"?`)) {
                    alert(`User "${userName}" has been deactivated.`);
                    closeUserDetailModal();
                }
            });
            
            // Function to open user detail modal
            function openUserDetailModal(userId) {
                // Set the user ID on the modal
                userDetailModal.setAttribute('data-user-id', userId);
                
                // Display the modal
                userDetailModal.classList.remove('hidden');
                
                // Update modal content based on userId (simulation)
                updateUserModalData(userId);
            }
            
            // Function to close user detail modal
            function closeUserDetailModal() {
                userDetailModal.classList.add('hidden');
            }
            
            // Function to open reset password modal
            function openResetPasswordModal(userId) {
                // Set the user ID on the modal
                resetPasswordModal.setAttribute('data-user-id', userId);
                
                // Update modal content based on userId (simulation)
                updateResetPasswordModalData(userId);
                
                // Display the modal
                resetPasswordModal.classList.remove('hidden');
            }
            
            // Function to close reset password modal
            function closeResetPasswordModal() {
                resetPasswordModal.classList.add('hidden');
            }
            
            // Function to update modal data based on userId
            function updateUserModalData(userId) {
                // Simulate different user data
                const userData = {
                    '1': {
                        name: 'Ananya Sharma',
                        firstname: 'Ananya',
                        lastname: 'Sharma',
                        role: 'Property Owner',
                        status: 'Active',
                        email: 'ananya.sharma@gmail.com',
                        phone: '+91 9876543210',
                        location: 'Bangalore, Karnataka',
                        joined: 'March 15, 2025',
                        dob: 'June 15, 1990',
                        gender: 'Female',
                        street: '#42, Palm Grove Apartments, 5th Cross',
                        city: 'Bangalore',
                        state: 'Karnataka',
                        postal: '560001',
                        country: 'India',
                        lastlogin: 'Today, 10:23 AM',
                        id: 'USR12345',
                        emailverified: 'Yes',
                        image: 'https://via.placeholder.com/150?text=A'
                    },
                    '2': {
                        name: 'Rahul Patel',
                        firstname: 'Rahul',
                        lastname: 'Patel',
                        role: 'Tenant',
                        status: 'Active',
                        email: 'rahul.patel@yahoo.com',
                        phone: '+91 9876543211',
                        location: 'Bangalore, Karnataka',
                        joined: 'April 28, 2025',
                        dob: 'August 22, 1988',
                        gender: 'Male',
                        street: '203, Royal Heights',
                        city: 'Bangalore',
                        state: 'Karnataka',
                        postal: '560034',
                        country: 'India',
                        lastlogin: 'Yesterday, 6:45 PM',
                        id: 'USR12346',
                        emailverified: 'Yes',
                        image: 'https://via.placeholder.com/150?text=R'
                    },
                    '3': {
                        name: 'Priya Mehta',
                        firstname: 'Priya',
                        lastname: 'Mehta',
                        role: 'Agent',
                        status: 'Active',
                        email: 'priya.mehta@outlook.com',
                        phone: '+91 9876543212',
                        location: 'Bangalore, Karnataka',
                        joined: 'February 10, 2025',
                        dob: 'December 3, 1992',
                        gender: 'Female',
                        street: '87, Green View Layout',
                        city: 'Bangalore',
                        state: 'Karnataka',
                        postal: '560102',
                        country: 'India',
                        lastlogin: 'Today, 9:10 AM',
                        id: 'USR12347',
                        emailverified: 'Yes',
                        image: 'https://via.placeholder.com/150?text=P'
                    },
                    '4': {
                        name: 'Vijay Kumar',
                        firstname: 'Vijay',
                        lastname: 'Kumar',
                        role: 'Tenant',
                        status: 'Inactive',
                        email: 'vijayk@hotmail.com',
                        phone: '+91 9876543213',
                        location: 'Mumbai, Maharashtra',
                        joined: 'January 5, 2025',
                        dob: 'March 18, 1991',
                        gender: 'Male',
                        street: 'D-15, Sea View Apartments',
                        city: 'Mumbai',
                        state: 'Maharashtra',
                        postal: '400050',
                        country: 'India',
                        lastlogin: '1 month ago',
                        id: 'USR12348',
                        emailverified: 'No',
                        image: 'https://via.placeholder.com/150?text=V'
                    },
                    '5': {
                        name: 'Sanjay Gupta',
                        firstname: 'Sanjay',
                        lastname: 'Gupta',
                        role: 'Property Owner',
                        status: 'Active',
                        email: 'sanjay.gupta@gmail.com',
                        phone: '+91 9876543214',
                        location: 'Delhi, NCR',
                        joined: 'May 12, 2025',
                        dob: 'October 5, 1985',
                        gender: 'Male',
                        street: 'B-201, Skyline Towers',
                        city: 'Delhi',
                        state: 'NCR',
                        postal: '110001',
                        country: 'India',
                        lastlogin: 'Today, 11:05 AM',
                        id: 'USR12349',
                        emailverified: 'Yes',
                        image: 'https://via.placeholder.com/150?text=S'
                    }
                };
                
                const data = userData[userId];
                
                // Update modal content
                document.getElementById('modal-user-name').textContent = data.name;
                document.getElementById('modal-user-fullname').textContent = data.name;
                document.getElementById('modal-user-role').textContent = data.role;
                document.getElementById('modal-user-email').textContent = data.email;
                document.getElementById('modal-user-phone').textContent = data.phone;
                document.getElementById('modal-user-location').textContent = data.location;
                document.getElementById('modal-user-joined').textContent = `Joined: ${data.joined}`;
                document.getElementById('modal-user-image').src = data.image;
                
                // Detail fields
                document.getElementById('modal-user-firstname').textContent = data.firstname;
                document.getElementById('modal-user-lastname').textContent = data.lastname;
                document.getElementById('modal-user-email-detail').textContent = data.email;
                document.getElementById('modal-user-phone-detail').textContent = data.phone;
                document.getElementById('modal-user-dob').textContent = data.dob;
                document.getElementById('modal-user-gender').textContent = data.gender;
                document.getElementById('modal-user-street').textContent = data.street;
                document.getElementById('modal-user-city').textContent = data.city;
                document.getElementById('modal-user-state').textContent = data.state;
                document.getElementById('modal-user-postal').textContent = data.postal;
                document.getElementById('modal-user-country').textContent = data.country;
                document.getElementById('modal-user-id').textContent = data.id;
                document.getElementById('modal-user-role-detail').textContent = data.role;
                document.getElementById('modal-user-status-detail').textContent = data.status;
                document.getElementById('modal-user-regdate').textContent = data.joined;
                document.getElementById('modal-user-lastlogin').textContent = data.lastlogin;
                document.getElementById('modal-user-emailverified').textContent = data.emailverified;
                
                // Update status class
                const statusElement = document.getElementById('modal-user-status');
                statusElement.textContent = data.status;
                statusElement.className = '';
                
                if (data.status === 'Active') {
                    statusElement.classList.add('px-2', 'py-1', 'inline-flex', 'text-xs', 'leading-5', 'font-semibold', 'rounded-full', 'bg-green-100', 'text-green-800');
                    document.getElementById('modal-deactivate-btn').innerHTML = '<i class="fas fa-ban mr-2"></i>Deactivate User';
                    document.getElementById('modal-deactivate-btn').classList.remove('border-green-600', 'text-green-600');
                    document.getElementById('modal-deactivate-btn').classList.add('border-red-600', 'text-red-600');
                } else {
                    statusElement.classList.add('px-2', 'py-1', 'inline-flex', 'text-xs', 'leading-5', 'font-semibold', 'rounded-full', 'bg-red-100', 'text-red-800');
                    document.getElementById('modal-deactivate-btn').innerHTML = '<i class="fas fa-check-circle mr-2"></i>Activate User';
                    document.getElementById('modal-deactivate-btn').classList.remove('border-red-600', 'text-red-600');
                    document.getElementById('modal-deactivate-btn').classList.add('border-green-600', 'text-green-600');
                }
            }
            
            // Function to update reset password modal data
            function updateResetPasswordModalData(userId) {
                // Simulate different user data
                const userData = {
                    '1': {
                        name: 'Ananya Sharma',
                        email: 'ananya.sharma@gmail.com',
                        phone: '+91 9876543210'
                    },
                    '2': {
                        name: 'Rahul Patel',
                        email: 'rahul.patel@yahoo.com',
                        phone: '+91 9876543211'
                    },
                    '3': {
                        name: 'Priya Mehta',
                        email: 'priya.mehta@outlook.com',
                        phone: '+91 9876543212'
                    },
                    '4': {
                        name: 'Vijay Kumar',
                        email: 'vijayk@hotmail.com',
                        phone: '+91 9876543213'
                    },
                    '5': {
                        name: 'Sanjay Gupta',
                        email: 'sanjay.gupta@gmail.com',
                        phone: '+91 9876543214'
                    }
                };
                
                const data = userData[userId];
                
                // Update modal content
                document.getElementById('reset-pwd-user-name').textContent = `Reset Password for ${data.name}`;
                document.getElementById('reset-email').textContent = data.email;
                document.getElementById('reset-phone').textContent = data.phone;
                
                // Generate a random password
                document.getElementById('new-password').value = generateRandomPassword();
                
                // Reset radio buttons
                document.getElementById('reset-method-email').checked = true;
                document.getElementById('manual-password-section').classList.add('hidden');
            }
            
            // Function to generate a random password
            function generateRandomPassword() {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const passwordLength = 8;
                let password = 'HD-';
                
                for (let i = 0; i < passwordLength; i++) {
                    password += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                
                return password;
            }
        });
    </script>
</body>
</html>