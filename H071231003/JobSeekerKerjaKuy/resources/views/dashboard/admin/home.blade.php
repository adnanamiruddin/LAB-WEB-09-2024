<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <i class="fas fa-users text-blue-500 text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Total Users</div>
                            <div class="text-2xl font-bold">2,451</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <i class="fas fa-briefcase text-green-500 text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Active Jobs</div>
                            <div class="text-2xl font-bold">185</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <i class="fas fa-building text-yellow-500 text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Companies</div>
                            <div class="text-2xl font-bold">84</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 mr-4">
                            <i class="fas fa-file-alt text-purple-500 text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-sm text-gray-500">Applications</div>
                            <div class="text-2xl font-bold">948</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-plus-circle text-blue-500 mb-2"></i>
                            <span class="block text-sm">Add New Job</span>
                        </button>
                        <button class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-user-plus text-green-500 mb-2"></i>
                            <span class="block text-sm">Add User</span>
                        </button>
                        <button class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-cog text-purple-500 mb-2"></i>
                            <span class="block text-sm">Settings</span>
                        </button>
                        <button class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-chart-bar text-red-500 mb-2"></i>
                            <span class="block text-sm">Reports</span>
                        </button>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                        Recent Activity
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm">New job posted by <span class="font-medium">Tech Corp</span></p>
                                <span class="text-xs text-gray-500">2 minutes ago</span>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm">New application from <span class="font-medium">John Doe</span></p>
                                <span class="text-xs text-gray-500">1 hour ago</span>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <p class="text-sm">Company profile updated: <span class="font-medium">DataSoft Inc</span></p>
                                <span class="text-xs text-gray-500">3 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
