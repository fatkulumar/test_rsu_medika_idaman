<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/Partials/Admin/NavbarAdmin.vue';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';
import { ref } from 'vue';
import Pagination from '@/Components/Partials/Pagination.vue';

const props = defineProps({
    diperiksa: {
        type: Object,
        require: true,
    }
});

const form = useForm({
    status: "",
    janji_temu_id: "",
});


const modal = ref(false)

function showModal(diperiksaId: String) {
    form.janji_temu_id = diperiksaId
    modal.value = true
}

function resetForm() {
    form.janji_temu_id = ""
    form.status = ""
}

function closeModal() {
    modal.value = false
    modalDetail.value = false
    resetForm()
}

function submit() {
    form.post('/admin/janji-temu', {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => alert('Error'),
    })
}

const formDetail = useForm({
    nama_pasien: "",
    dokter: "",
    poli: "",
    tanggal_kunjungan: "",
    status_pasien: "",
    status_penanganan: "",
    nomor_antrian: "",
})
const modalDetail = ref(false)
function showDetail(item: any) {
    formDetail.nama_pasien = item.user?.name
    formDetail.dokter = item.dokter?.name
    formDetail.poli = item.poli?.name
    formDetail.tanggal_kunjungan = item.tanggal_kunjungan
    formDetail.status_pasien = item.status_pasien
    formDetail.status_penanganan = item.status_penanganan
    formDetail.nomor_antrian = item.nomor_antrian
    modalDetail.value = true
}

</script>

<template>
    <Head title="List Diperiksa" />
    <div>
        <AuthenticatedLayoutAdmin>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarAdmin title="List Diperiksa">
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    No
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Pasien
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Dokter
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Poli
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Tanggal Kunjungan
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Status Pasien
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Status Penanganan
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item, index in diperiksa.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ index + props.diperiksa.from }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ item.user.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.dokter?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.poli?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.tanggal_kunjungan }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.status_pasien }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.status_penanganan }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex">
                                                        <svg @click="showModal(item.id)" class="w-8 h-8 cursor-pointer" fill="#4b98d2" height="200px" width="200px" version="1.2" baseProfile="tiny" id="earth" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-63 65 128 128" xml:space="preserve" stroke="#4b98d2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M46.8,154L18,160.6c-0.2,1.4-0.8,2.9-1.7,4.1c-1.7,2.6-4.3,4.5-7.3,5.3c-3,0.7-6.2,0.2-8.8-1.6l-24.8-15.8 c-1.2-0.7-1.4-2.1-0.7-3.2s2.1-1.4,3.1-0.7l24.9,15.8c3.3,2,7.6,1.1,9.7-2.1s1.1-7.6-2.1-9.7l-31-19.6c-5.1-3.2-11-5.7-16.6-2.9 L-63,144.8v29.4l18.4-13.7c2.9-0.7,6.1-0.1,8.8,1.6l21.6,13.6c5.3,3.3,11.8,4.1,17.4,2.6L50,167.6c3.7-0.8,6.2-4.5,5.3-8.5 C54.3,155.5,50.6,153.2,46.8,154z M26.4,81.3C8.2,81.3-6.5,96-6.5,114.2c0,18.2,14.7,32.9,32.9,32.9c18.2,0,32.9-14.7,32.9-32.9 C59.3,96,44.5,81.3,26.4,81.3z M45.1,102l-22.6,31.2L8,117.5c-1.6-1.8-1.5-4.5,0.2-6.2c1.8-1.6,4.5-1.5,6.2,0.2l7.3,7.9L38,96.9 c1.4-1.9,4.1-2.4,6.1-1C46,97.3,46.5,100.1,45.1,102z"></path> </g></svg>

                                                        <svg @click="showDetail(item)" class="w-8 h-8 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#27bfdd"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#18d8b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#18d8b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination
                                        class="py-3 flex justify-center container mx-auto"
                                        :links="props.diperiksa.links"
                                    />
                                </div>
                            </NavbarAdmin>
                        </div>
                    </div>
                </div>

            <!-- Main modal -->
            <div id="default-modal" tabindex="-1" aria-hidden="true" :class="modal ? 'flex' : 'hidden'" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Status Penanganan
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
                            <div class="flex">
                                <select v-model="form.status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option :selected="form.status == null" value="">Pilih Status</option>
                                <option value="menunggu">Menunggu</option>
                                <option value="diperiksa">Diperiksa</option>
                                </select>
                                <button @click="submit" v-show="form.status" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md" type="button">Submit</button>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button @click="closeModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main detail -->
            <div tabindex="-1" aria-hidden="true" :class="modalDetail ? 'flex' : 'hidden'" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Detail
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
                            <table border="2" class="dark:text-white text-black">
                                <tr >
                                    <td class="font-bold">Nama</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.nama_pasien }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Dokter</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.dokter }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Poli</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.poli }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Status Penanganan</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.status_penanganan }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Status Pasien</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.status_pasien }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Nomor Antrian</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.nomor_antrian }}</td>
                                </tr>
                            </table>
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
