<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Pagination from '@/Components/Pagination.vue';
    import BookForm from '@/Components/Books/form.vue';

    const defaultFormObject = {
        title: null, author: null, image: null
    };

    export default{
        props: ['data'],
        components: {
            AppLayout, Pagination, BookForm
        },
        data() {
            return {
                isFormOpen: false,
                isFormEdit: false,
                formObject: defaultFormObject
            }
        },
        methods: {
            image_path(image){
                //
                return '/' + image;
            },
            saveItem(item) {
                let url = '/books';

                if( item.id ) {
                    url = '/books/' + item.id;
                    item._method = 'PUT';
                }

                this.$inertia.post(url, item, {
                    onError: (e) => {},
                    onSuccess: (e) => {
                        this.closeModal();
                    }
                });
            },
            
            // close modal
            closeModal() {
                this.isFormOpen = false;
            },
            // open modal
            openForm(item) {
                this.isFormOpen = true;
                this.isFormEdit = !!item;
                this.formObject = item ? Object.assign( {}, item ) : defaultFormObject;
                this.$page.props.errors = {};
            },
            // delete item
            deleteItem(item) {
                if( window.confirm('Are you sure?') ) {
                    this.$inertia.post('/books/' + item.id, {
                        _method: 'DELETE'
                    })
                }
            }
        }
    }
</script>

<template>
    <app-layout title="Books">
        
        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- flash message-->
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" 
                         role="alert" 
                         v-if="$page.props.flash.message">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ $page.props.flash.message }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- new button -->
                    <button @click="openForm()" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create</button>

                    <!-- table -->
                    <table class="table-fixed w-full posts-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Image</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in data.data">
                                <td class="px-4 py-2 border">{{ item.id }}</td>
                                <td class="px-4 py-2 border">{{ item.title }}</td>
                                <td class="px-4 py-2 border">{{ item.author }}</td>
                                <td class="px-4 py-2 border">
                                    <img v-if="item.image" :src="image_path(item.image)" />
                                </td>
                                <td class="px-4 py-2 border">
                                    <!-- edit button -->
                                    <button @click="openForm(item)" 
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                            
                                    <!-- delete button -->
                                    <button @click="deleteItem(item)"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- pagination -->
                    <pagination :links="data.links" />

                    <!-- edit modal -->
                    <book-form :isOpen="isFormOpen" 
                               :isEdit="isFormEdit" 
                               :form="formObject" 
                               @formsave="saveItem" 
                               @formclose="closeModal"></book-form>

                </div>
            </div>
        </div>
    </app-layout>
</template>