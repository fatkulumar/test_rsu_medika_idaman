<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/Partials/Admin/NavbarAdmin.vue';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import Pagination from '@/Components/Partials/Pagination.vue';
import { watch, ref } from 'vue'

const props = defineProps({
    dokters: {
        type: Object,
        require: true,
    },

    polis: {
        type: Object,
        require: true,
    }
});

let search = ref();

watch(search, (value) => {
  router.get(
    "/admin/dokters",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

const form = useForm({
    poli_id: '',
    user_id: '',
});

function resetForm() {
    form.poli_id = ""
    form.user_id = ""
}

const submit = () => {

    form.post('/admin/dokter-to-poli', {
        preserveScroll: true,
        // onSuccess: () => closeModal(),
        // onError: () => alert('Error'),
        onFinish: () => {
            closeModal()
        },
    })
};

const modalTambah = ref(false)
function showModalTambah(id: String) {
    form.user_id = id
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
            router.delete(`/admin/dokter/${id}`)
        }
    } catch (error)  {
        console.log(error)
    }
}

</script>

<template>
    <Head title="Dokter" />
    <div>
        <AuthenticatedLayoutAdmin>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarAdmin title="Dokter">
                                <div class="mb-2">
                                    <input v-model="search" type="text" placeholder="Search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
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
                                                    Email
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Role
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Poli
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item, index in props.dokters.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ index + props.dokters.from }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ item.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.email }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.roles[0]?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.dokter?.poli.name }}
                                                </td>
                                                <td>
                                                    <div class="flex">
                                                        <svg @click="showModalTambah(item.id)" class="w-8 h-8 cursor-pointer" fill="#4b98d2" height="200px" width="200px" version="1.2" baseProfile="tiny" id="earth" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-63 65 128 128" xml:space="preserve" stroke="#4b98d2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M46.8,154L18,160.6c-0.2,1.4-0.8,2.9-1.7,4.1c-1.7,2.6-4.3,4.5-7.3,5.3c-3,0.7-6.2,0.2-8.8-1.6l-24.8-15.8 c-1.2-0.7-1.4-2.1-0.7-3.2s2.1-1.4,3.1-0.7l24.9,15.8c3.3,2,7.6,1.1,9.7-2.1s1.1-7.6-2.1-9.7l-31-19.6c-5.1-3.2-11-5.7-16.6-2.9 L-63,144.8v29.4l18.4-13.7c2.9-0.7,6.1-0.1,8.8,1.6l21.6,13.6c5.3,3.3,11.8,4.1,17.4,2.6L50,167.6c3.7-0.8,6.2-4.5,5.3-8.5 C54.3,155.5,50.6,153.2,46.8,154z M26.4,81.3C8.2,81.3-6.5,96-6.5,114.2c0,18.2,14.7,32.9,32.9,32.9c18.2,0,32.9-14.7,32.9-32.9 C59.3,96,44.5,81.3,26.4,81.3z M45.1,102l-22.6,31.2L8,117.5c-1.6-1.8-1.5-4.5,0.2-6.2c1.8-1.6,4.5-1.5,6.2,0.2l7.3,7.9L38,96.9 c1.4-1.9,4.1-2.4,6.1-1C46,97.3,46.5,100.1,45.1,102z"></path> </g></svg>

                                                        <svg @click="handleDelete(item.id, item.name)" class="w-8 h-8 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 12L14 16M14 12L10 16M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6" stroke="#eb2424" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination
                                        class="py-3 flex justify-center container mx-auto"
                                        :links="props.dokters.links"
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
                                Dokter
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
                                        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Dokter Poli</h2>
                                            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                                                <div class="sm:col-span-2">
                                                    <label for="poli_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poli</label>
                                                    <select required v-model="form.poli_id" name="poli_id" id="poli_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                        <option :selected="form.poli_id == null" value="">Pilih Poli</option>
                                                        <option v-for="item, index in props.polis" :key="index" :value="item.id">
                                                            {{ item.name }}
                                                        </option>
                                                    </select>
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
