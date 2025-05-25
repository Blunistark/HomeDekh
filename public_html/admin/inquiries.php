<?php
require_once '../config/db.php';
// Fetch all inquiries with property name
$sql = "SELECT i.*, p.name AS property_name FROM inquiries i LEFT JOIN properties p ON i.property_id = p.id ORDER BY i.created_at DESC";
$result = $conn->query($sql);
$inquiries = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries | HomeDhek Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
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
                        <div class="h-8 w-8 rounded-full bg-[#1a4977] flex items-center justify-center text-white">A</div>
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
                            <i class="fas fa-home mr-3 text-gray-500"></i> Dashboard
                        </a>
                        <a href="properties.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-building mr-3 text-gray-500"></i> Properties
                        </a>
                        <a href="users.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-users mr-3 text-gray-500"></i> Users
                        </a>
                        <a href="inquiries.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full bg-blue-50 text-[#1a4977]">
                            <i class="fas fa-comment-dots mr-3 text-[#1a4977]"></i> Inquiries
                        </a>
                        <a href="settings.php" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-500"></i> Settings
                        </a>
                    </div>
                </nav>
            </div>
        </aside>
        <!-- Main Content -->
        <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 lg:ml-64 ml-0">
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <div class="mb-6 flex items-center space-x-2 text-sm">
                    <a href="./" class="text-gray-500 hover:text-gray-700">Dashboard</a>
                    <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                    <span class="text-gray-900 font-medium">Inquiries</span>
                </div>
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Inquiries</h1>
                        <p class="text-sm text-gray-500 mt-1">View and manage property inquiries</p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <input type="text" id="inquiry-search" placeholder="Search by name, property, or channel..." class="w-full sm:w-64 border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                        <select id="inquiry-channel-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                            <option value="all">All Channels</option>
                            <option value="Call">Call</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Email">Email</option>
                        </select>
                        <select id="inquiry-status-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1a4977] focus:border-[#1a4977]">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="responded">Responded</option>
                            <option value="not_interested">Not Interested</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm mb-6 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Channel</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="inquiries-tbody" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Inquiry Detail Modal -->
    <div id="inquiry-detail-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-inquiry-name">Inquiry Details</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="modal-inquiry-property"></p>
                                <p class="text-sm text-gray-500" id="modal-inquiry-channel"></p>
                                <p class="text-sm text-gray-500" id="modal-inquiry-status"></p>
                                <p class="text-sm text-gray-500" id="modal-inquiry-date"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="modal-close-btn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const inquiries = <?= json_encode($inquiries) ?>;
        let filteredInquiries = [...inquiries];
        function renderInquiryRow(inquiry) {
            return `<tr>
                <td class="px-6 py-4 whitespace-nowrap">${inquiry.name}</td>
                <td class="px-6 py-4 whitespace-nowrap">${inquiry.property_name || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap">${inquiry.channel}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${inquiry.status === 'responded' ? 'bg-blue-100 text-blue-800' : (inquiry.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')}">
                        ${inquiry.status.charAt(0).toUpperCase() + inquiry.status.slice(1).replace('_', ' ')}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${inquiry.created_at ? new Date(inquiry.created_at).toLocaleString() : '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button class="view-inquiry-btn text-[#1a4977] hover:text-[#0e2e4a]" data-id="${inquiry.id}"><i class="fas fa-eye"></i></button>
                </td>
            </tr>`;
        }
        function updateInquiryTable() {
            const tbody = document.getElementById('inquiries-tbody');
            tbody.innerHTML = filteredInquiries.map(renderInquiryRow).join('');
            document.querySelectorAll('.view-inquiry-btn').forEach(btn => {
                btn.onclick = function() {
                    const id = this.getAttribute('data-id');
                    const inquiry = inquiries.find(i => i.id == id);
                    if (!inquiry) return;
                    document.getElementById('modal-inquiry-name').textContent = inquiry.name;
                    document.getElementById('modal-inquiry-property').textContent = 'Property: ' + (inquiry.property_name || '-');
                    document.getElementById('modal-inquiry-channel').textContent = 'Channel: ' + inquiry.channel;
                    document.getElementById('modal-inquiry-status').textContent = 'Status: ' + inquiry.status.charAt(0).toUpperCase() + inquiry.status.slice(1).replace('_', ' ');
                    document.getElementById('modal-inquiry-date').textContent = 'Date: ' + (inquiry.created_at ? new Date(inquiry.created_at).toLocaleString() : '-');
                    document.getElementById('inquiry-detail-modal').classList.remove('hidden');
                };
            });
        }
        function filterInquiries() {
            const searchVal = document.getElementById('inquiry-search').value.toLowerCase();
            const channelVal = document.getElementById('inquiry-channel-filter').value;
            const statusVal = document.getElementById('inquiry-status-filter').value;
            filteredInquiries = inquiries.filter(inquiry => {
                const matchesSearch =
                    inquiry.name.toLowerCase().includes(searchVal) ||
                    (inquiry.property_name && inquiry.property_name.toLowerCase().includes(searchVal)) ||
                    inquiry.channel.toLowerCase().includes(searchVal);
                const matchesChannel = (channelVal === 'all') || (inquiry.channel === channelVal);
                const matchesStatus = (statusVal === 'all') || (inquiry.status === statusVal);
                return matchesSearch && matchesChannel && matchesStatus;
            });
            updateInquiryTable();
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('inquiry-search').addEventListener('input', filterInquiries);
            document.getElementById('inquiry-channel-filter').addEventListener('change', filterInquiries);
            document.getElementById('inquiry-status-filter').addEventListener('change', filterInquiries);
            document.getElementById('modal-close-btn').onclick = function() {
                document.getElementById('inquiry-detail-modal').classList.add('hidden');
            };
            filterInquiries();
            // Sidebar toggle for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</body>
</html> 