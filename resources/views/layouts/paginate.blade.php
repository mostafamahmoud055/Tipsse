                <!-- Pagination -->
                <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Showing <span x-text="(currentPage-1)*itemsPerPage + 1"></span> to
                        <span x-text="Math.min(currentPage*itemsPerPage, filteredApplications.length)"></span> of
                        <span x-text="filteredApplications.length"></span> entries
                    </p>

                    <div class="flex flex-wrap gap-1">
                        <template x-for="page in totalPages" :key="page">
                            <button @click="goToPage(page)" x-text="page"
                                :class="currentPage === page ?
                                    'menu-item-active text-white dark:menu-item-active' :
                                    'border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                class="rounded px-3 py-2 text-sm font-medium"></button>
                        </template>

                        <button @click="goToPage(currentPage-1)" :disabled="currentPage === 1"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Prev</button>

                        <button @click="goToPage(currentPage+1)" :disabled="currentPage === totalPages"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Next</button>
                    </div>
                </div>