<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/Partials/Admin/NavbarAdmin.vue';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import Pagination from '@/Components/Partials/Pagination.vue';
import { watch, ref } from 'vue'

const props = defineProps({
    polis: {
        type: Object,
        require: true,
    }
});

let search = ref();

watch(search, (value) => {
  router.get(
    "/admin/polis",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

const form = useForm({
    name: '',
});

function resetForm() {
    form.name = ""
}

const submit = () => {

    form.post('/admin/polis', {
        preserveScroll: true,
        onFinish: () => {
            closeModal()
        },
    })
};

const modalTambah = ref(false)
function showModalTambah() {
    modalTambah.value = true
}

function closeModal() {
    resetForm()
    modalTambah.value = false
}

function handleDelete(id: String, name: String) {
    try {
        const konfirm = confirm(`Hapus ${name}`)
        if (konfirm) {
            router.delete(`/admin/poli/${id}`)
        }
    } catch (error)  {
        console.log(error)
    }
}

</script>

<template>
    <Head title="Poli" />
    <div>
        <AuthenticatedLayoutAdmin>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarAdmin title="Poli">
                                <div class="flex justify-between mb-2">
                                    <div @click="showModalTambah" class="border border-black dark:border-white flex items-center">
                                        <svg class="w-8 h-8 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 12H20M12 4V20" stroke="#70be3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                    </div>
                                    <div>
                                            <input v-model="search" type="text" placeholder="Search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                    </div>
                                </div>
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    No
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nama
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item, index in props.polis.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ index + props.polis.from }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ item.name }}
                                                </td>
                                                <td>
                                                    <div class="flex">
                                                        <svg @click="handleDelete(item.id, item.name)" class="w-8 h-8 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12L14 16M14 12L10 16M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6" stroke="#eb2424" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination
                                        class="py-3 flex justify-center container mx-auto"
                                        :links="props.polis.links"
                                    />
                                </div>
                            </NavbarAdmin>
                        </div>
                    </div>
                </div>

                <!-- Main modal form -->
            <div tabindex="-1" aria-hidden="true" :class="modalTambah ? 'flex' : 'hidden'" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Poli
                            </h3>
                            <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <section class="bg-white dark:bg-gray-900">
                                <form @submit.prevent="submit">
                                    <div class="py-8 px-4 mx-auto max-w-2xl">
                                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                                                <div class="sm:col-span-2">
                                                    <label for="poli_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poli</label>
                                                    <input v-model="form.name" type="text" placeholder="Nama Poli" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                                </div>
                                            </div>
                                            <button type="submit" class="bg-blue-600 inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                                Daftar
                                            </button>
                                    </div>
                                </form>
                            </section>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button @click="closeModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayoutAdmin>

    </div>
</template>
