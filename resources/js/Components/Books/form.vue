<script>
export default {
    props: ['form', 'isOpen', 'isEdit']
}
</script>

<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:block sm:p-0">
            
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" 
                 role="dialog" 
                 aria-modal="true" 
                 aria-labelledby="modal-headline">

                <form>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="formBookTitle" 
                                       class="block text-gray-700 text-sm font-bold mb-2">Title: </label>
                                <input type="text" id="formBookTitle" v-model="form.title"  
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       placeholder="Enter Title"/>
                            </div>

                            <!-- Author -->
                            <div class="mb-4">
                                <label for="formBookAuthor" 
                                       class="block text-gray-700 text-sm font-bold mb-2">Author: </label>
                                <input type="text" id="formBookAuthor" v-model="form.author" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       placeholder="Enter Author"/>
                            </div>

                            <!-- Image -->
                            <div class="mb-4">
                                <label for="formBookImage" 
                                       class="block text-gray-700 text-sm font-bold mb-2">Author: </label>
                                <input type="text" id="formBookImage" 
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                       placeholder="Enter Image"/>
                            </div>

                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        
                        <!-- Save Button -->
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" v-show="!isEdit" @click="$emit('formsave', form)" 
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Save
                            </button>
                        </span>

                        <!-- Update Button -->
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" v-show="isEdit" @click="$emit('formsave', form)" 
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Update
                            </button>
                        </span>

                        <!-- Cancel Button -->
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" @click="$emit('formclose')"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </span>

                    </div>
                </form>>

            </div>

        </div>
    </div>
</template>