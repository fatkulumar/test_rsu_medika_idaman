<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import NavbarDokter from '@/Components/Partials/Admin/NavbarDokter.vue';
import AuthenticatedLayoutDokter from '@/Layouts/AuthenticatedLayoutDokter.vue';
import { ref } from 'vue';
import Pagination from '@/Components/Partials/Pagination.vue';

const props = defineProps({
    rekamMedis: {
        type: Object,
        require: true,
    }
});

function submit() {
    form.post('/dokter/rekam-medis', {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => alert('Error'),
    })
}

const form = useForm({
    id: "",
    nama_pasien: "",
    dokter: "",
    poli: "",
    keluhan: "",
    diagnosa: "",
    keterangan: "",
    nomor_antrian: "",
    obat: "",
    status_rawat: "",
    tindakan: "",
    tanggal_kunjungan: "",
});

const modal = ref(false)
function showModal(data: Object) {
    form.id = data.id
    form.nama_pasien = data.janji_temu?.user?.name
    form.dokter = data.janji_temu?.poli?.name
    form.poli = data.janji_temu?.poli?.name
    form.keluhan = data.keluhan
    form.diagnosa = data.diagnosa
    form.keterangan = data.keterangan
    form.nomor_antrian = data.nomor_antrian
    form.obat = data.obat
    form.status_rawat = data.status_rawat
    form.tindakan = data.tindakan
    form.tanggal_kunjungan = data.janji_temu?.tanggal_kunjungan
    modal.value = true
}

function closeModal() {
    modal.value = false
    modalDetail.value = false
}

const formDetail = useForm({
    nama_pasien: "",
    dokter: "",
    poli: "",
    tanggal_kunjungan: "",
    status_rawat: "",
    nomor_antrian: "",
    diagnosa: "",
    keluhan: "",
    keterangan: "",
    tindakan: "",
    obat: "",
})
const modalDetail = ref(false)
function showDetail(item: any) {
    formDetail.nama_pasien = item.janji_temu?.user?.name
    formDetail.dokter = item.janji_temu?.dokter?.name
    formDetail.poli = item.janji_temu?.poli?.name
    formDetail.tanggal_kunjungan = item.janji_temu?.tanggal_kunjungan
    formDetail.status_rawat = item.status_rawat
    formDetail.nomor_antrian = item.nomor_antrian
    formDetail.diagnosa = item.diagnosa
    formDetail.keluhan = item.keluhan
    formDetail.obat = item.obat
    formDetail.tindakan = item.tindakan
    modalDetail.value = true
}

</script>

<template>
    <Head title="Rekam Medis" />
    <div>
        <AuthenticatedLayoutDokter>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarDokter title="Rekam Medis">
                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    No
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Nomor RM
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    email
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
                                                    Status Rawat
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item, index in props.rekamMedis.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ index + props.rekamMedis.from }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ item.nomor_rekam_medis }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.janji_temu?.user?.email }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.janji_temu?.user?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.janji_temu?.dokter?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.janji_temu?.poli?.name }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.janji_temu?.tanggal_kunjungan }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ item.status_rawat }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex gap-2">
                                                        <svg @click="showModal(item)" class="w-8 h-8 cursor-pointer" fill="#4b98d2" height="200px" width="200px" version="1.2" baseProfile="tiny" id="earth" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-63 65 128 128" xml:space="preserve" stroke="#4b98d2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M46.8,154L18,160.6c-0.2,1.4-0.8,2.9-1.7,4.1c-1.7,2.6-4.3,4.5-7.3,5.3c-3,0.7-6.2,0.2-8.8-1.6l-24.8-15.8 c-1.2-0.7-1.4-2.1-0.7-3.2s2.1-1.4,3.1-0.7l24.9,15.8c3.3,2,7.6,1.1,9.7-2.1s1.1-7.6-2.1-9.7l-31-19.6c-5.1-3.2-11-5.7-16.6-2.9 L-63,144.8v29.4l18.4-13.7c2.9-0.7,6.1-0.1,8.8,1.6l21.6,13.6c5.3,3.3,11.8,4.1,17.4,2.6L50,167.6c3.7-0.8,6.2-4.5,5.3-8.5 C54.3,155.5,50.6,153.2,46.8,154z M26.4,81.3C8.2,81.3-6.5,96-6.5,114.2c0,18.2,14.7,32.9,32.9,32.9c18.2,0,32.9-14.7,32.9-32.9 C59.3,96,44.5,81.3,26.4,81.3z M45.1,102l-22.6,31.2L8,117.5c-1.6-1.8-1.5-4.5,0.2-6.2c1.8-1.6,4.5-1.5,6.2,0.2l7.3,7.9L38,96.9 c1.4-1.9,4.1-2.4,6.1-1C46,97.3,46.5,100.1,45.1,102z"></path> </g></svg>

                                                        <svg @click="showDetail(item)" class="w-8 h-8 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#27bfdd"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#18d8b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#18d8b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <Pagination
                                        class="py-3 flex justify-center container mx-auto"
                                        :links="props.rekamMedis.links"
                                    />
                                </div>
                            </NavbarDokter>
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
                                Diagnosa
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


                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input v-model="form.nomor_antrian" type="text" name="nomor_antrian" id="nomor_antrian" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Nomor Antrian" required readonly />
                                    <label for="nomor_antrian" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nomor Antrian</label>
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input v-model="form.nama_pasien" type="text" name="nama_pasien" id="nama_pasien" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Nama Pasien" readonly required />
                                    <label for="nama_pasien" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama Pasien</label>
                                </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input v-model="form.dokter" type="text" name="dokter" id="dokter" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Dokter" readonly required />
                                <label for="dokter" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Dokter</label>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input v-model="form.poli" type="poli" name="poli" id="floating_poli" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Poli" readonly required />
                                <label for="floating_poli" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Poli</label>
                            </div>
                        </div>

                            <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-5 group">
                                <input v-model="form.tanggal_kunjungan" type="text" name="tanggal_kunjungan" id="tanggal_kunjungan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Tanggal Kunjungan" readonly required />
                                <label for="tanggal_kunjungan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tangal Kunjungan</label>
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <select v-model="form.status_rawat" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option :selected="form.status_rawat == null" value="">Pilih Status</option>
                                    <option value="menginap">Menginap</option>
                                    <option value="boleh pulang">Boleh Pulang</option>
                                    <option value="rawat jalan">Rawat Jalan</option>
                                </select>
                                <label for="status_rawat" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Status Rawat</label>
                            </div>
                            </div>

                            <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.diagnosa" name="diagnosa" id="diagnosa" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Diagnosa" required />
                                    <label for="diagnosa" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Diagnosa</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.keluhan" name="keluhan" id="keluhan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Keluhan" required />
                                    <label for="keluhan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keluhan</label>
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <textarea v-model="form.obat" name="obat" id="obat" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="obat" required />
                                    <label for="keluhan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Obat</label>
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <input v-model="form.tindakan" type="text" name="tindakan" id="tindakan" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Tindakan" required />
                                    <label for="tindakan" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tindakan</label>
                                </div>


                            <button @click="submit" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>

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
                                <tr>
                                    <td class="font-bold">Nomor Antrian</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.nomor_antrian }}</td>
                                </tr>
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
                                    <td class="font-bold">Tanggal Kunjunagn</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.tanggal_kunjungan }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Status Rawat</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.status_rawat }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Diagnosa</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.diagnosa }}</td>
                                </tr>

                                <tr>
                                    <td class="font-bold">Keluhan</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.keluhan }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Obat</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.obat }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Tindakan</td>
                                    <td class="font-bold">:</td>
                                    <td>{{ formDetail.tindakan }}</td>
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
        </AuthenticatedLayoutDokter>

    </div>
</template>
