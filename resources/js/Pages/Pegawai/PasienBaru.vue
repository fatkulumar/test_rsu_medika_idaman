<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    users: {
        type: Object,
        require: true
    },

    polis: {
        type: Object,
        require: true
    }
})

const form = useForm({
    // janji temu
    user_id: "",
    poli_id: "",
    tanggal_kunjungan: "",
    status_penanganan: "menunggu",
    // rekam medis
    janji_temu_id: "",
    keluhan: "",
    diagnosa: "",
    tindakan: "",
    obat: "",
    keterangan: "",
    nomor_antrian: "",
});

function resetForm() {
    form.user_id = ""
    form.poli_id = ""
    form.tanggal_kunjungan = ""
    form.status_penanganan = "menunggu"
    form.janji_temu_id = ""
    form.diagnosa = ""
    form.tindakan = ""
    form.obat = ""
    form.keterangan = ""
    form.nomor_antrian = ""
}
function submit() {
    form.post('/pegawai/daftar-pasien-baru', {
        preserveScroll: true,
        // onSuccess: () => closeModal(),
        // onError: () => alert('Error'),
    })
}

const today = reactive(new Date().toISOString().split('T')[0],)

</script>


<template>
    <Head title="Pasien Baru" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Pasien Baru
            </h2>
        </template>

        <div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-900"
                >
                    <div class="text-gray-900 dark:text-gray-100 flex items-center justify-center gap-2">
                        <section class="bg-white dark:bg-gray-900">
                            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Pendaftaran</h2>
                                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                        <div>
                                            <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pasien</label>
                                            <select v-model="form.user_id" id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option :selected="form.user_id == null" value="">Pilih User</option>
                                                <option v-for="item, index in props.users" :key="index" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="tanggal_kunjungan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kunjungan</label>
                                            <input v-model="form.tanggal_kunjungan" type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="" :min="today">
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="poli_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poli</label>
                                            <select v-model="form.poli_id" id="poli_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option :selected="form.poli_id == null" value="">Pilih Poli</option>
                                                <option v-for="item, index in props.polis" :key="index" :value="item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>


                                        <!-- <div>
                                            <label for="status_rawat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Rawat</label>
                                            <select v-model="form.status_rawat" id="status_rawat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option :selected="form.status_rawat == 'rawat jalan'" value="rawat jalan">Rawat Jalan</option>
                                                <option value="menginap">Menginap</option>
                                                <option value="pulang">pulang</option>
                                                <option value="boleh pulang">Boleh Pulang</option>
                                            </select>
                                        </div> -->

                                        <!-- <div class="sm:col-span-2">
                                            <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keluhan</label>
                                            <textarea id="keluhan" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Boleh kosong"></textarea>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="keluhan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosa</label>
                                            <textarea id="keluhan" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Boleh kosong"></textarea>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="tindakan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindakan</label>
                                            <textarea id="tindakan" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Boleh kosong"></textarea>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                                            <textarea id="keterangan" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Boleh kosong"></textarea>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="obat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Obat</label>
                                            <textarea id="obat" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Boleh kosong"></textarea>
                                        </div> -->
                                    </div>
                                    <button @click="submit" type="button" class="bg-blue-600 inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                        Submit
                                    </button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
