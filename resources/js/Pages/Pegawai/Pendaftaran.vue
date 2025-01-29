<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify'

const props = defineProps({
    polis: {
        type: Object,
        require: true
    },
    users: {
        type: Object,
        require: true
    },
    data: {
        type: Object,
        require: true
    },
    flash: {
        type: Object,
        require: false
    },
})
const page = usePage()
const form = useForm({
    user_id: props.data.user_id,
    nomor_rm: props.data.nomor_rm,
    poli_id: props.data.poli_id,
    status_pasien: "lama",
    status_penanganan: "menunggu",
    nomor_antrian: props.data.nomor_antrian,
    tanggal_kunjungan: props.data.tanggal_kunjungan,
})

function resetForm() {
    form.status_pasien = "lama"
    form.status_penanganan = "menunggu"
    form.poli_id = props.data.poli_id
    form.nomor_rm = props.data.nomor_rm
    form.user_id = props.data.user_id
    form.nomor_antrian = props.data.nomor_antrian
    form.tanggal_kunjungan = props.data.tanggal_kunjungan
}
function submit() {
    form.post('/pegawai/daftar', {
        preserveScroll: true,
        onSuccess: () => {
            showToast(page.props.flash.success)
        },
        onError: () => {
            showToastError(page.props.flash.success)
        },
    })
}

const showToast = (message = 'Berhasil') => {
  toast.success(message, {
    position: 'top-right',
  })
}

const showToastError = (message = 'Gagal') => {
  toast.error(message, {
    position: 'top-right',
  })
}

</script>

<template>
    <Head title="Pendaftaran" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Pendaftaran
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-900"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-center gap-2">
                        <section class="bg-white dark:bg-gray-900">
                            <div class="py-8 px-4 mx-auto max-w-2xl">
                                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Pendaftaran</h2>
                                <form @submit.prevent="submit">
                                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                        <div class="w-full">
                                            <label for="bonor_antrian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. Antrian</label>
                                            <input v-model="form.nomor_antrian" type="text" name="bonor_antrian" id="bonor_antrian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1" readonly required="">
                                        </div>
                                        <div class="w-full">
                                            <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pasien</label>
                                            <select required readonly v-model="form.user_id" id="user_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option :selected="form.user_id == null" value="">Pilih Pasien</option>
                                                <option v-for="item, index in users" :key="index" :value="item.id" :selected="form.user_id == item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="w-full">
                                            <label for="tanggal_kunjungan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kunjungan</label>
                                            <input v-model="form.tanggal_kunjungan" type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="" :min="today">
                                        </div>
                                        <div class="w-full">
                                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Poli</label>
                                            <select style="pointer-events: none;" disabled="true" required v-model="form.poli_id" id="poli_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option :selected="form.poli_id == null" value="">Pilih Poli</option>
                                                <option v-for="item, index in props.polis" :key="index" :value="item.id" :selected="form.poli_id == item.id">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="bg-blue-600 inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                        Daftar
                                    </button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
