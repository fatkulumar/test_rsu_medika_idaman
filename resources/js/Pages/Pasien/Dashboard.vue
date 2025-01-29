<script setup lang="ts">
import AuthenticatedLayoutPasien from '@/Layouts/AuthenticatedLayoutPasien.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
      data: {
          type: Object,
          require: true
      }
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayoutPasien>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-900"
                >
                    <div class="flex justify-center text-black dark:text-white">

                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $page.props.auth.user.name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $page.props.auth.user.email }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-center gap-2">
                        <div v-for="item, index in props.data" :key="index">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg flex gap-3">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">No</th>
                                            <th scope="col" class="px-6 py-3">Nomor RM</th>
                                            <th scope="col" class="px-6 py-3">Nomor Antrian</th>
                                            <th scope="col" class="px-6 py-3">Poli</th>
                                            <th scope="col" class="px-6 py-3">Dokter</th>
                                            <th scope="col" class="px-6 py-3">Status Pasien</th>
                                            <th scope="col" class="px-6 py-3">Tanggal Kunjungan</th>
                                            <th scope="col" class="px-6 py-3">Tanggal Kunjungan</th>
                                            <th scope="col" class="px-6 py-3">Status Penanganan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ index + 1 }}
                                            </th>
                                            <td class="px-6 py-4">{{ item.rekam_medis?.nomor_rekam_medis }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.nomor_antrian }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.poli?.name }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.dokter?.name }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.status_pasien }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.poli?.name }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.tanggal_kunjungan }}</td>
                                            <td class="px-6 py-4">{{ item.janji_temu?.status_penanganan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutPasien>
</template>
