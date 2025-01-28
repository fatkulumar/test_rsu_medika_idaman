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
                            <div class="flex gap-3">
                                <p>{{ index + 1 }}.</p>
                                <table>
                                    <tr>
                                        <td>Nomor RM</td>
                                        <td>:</td>
                                        <td>{{ item.rekam_medis?.nomor_rekam_medis }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Antrian</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.nomor_antrian }}</td>
                                    </tr>
                                    <tr>
                                        <td>Poli</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.poli?.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dokter</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.dokter?.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Pasien</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.status_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Penanganan</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.status_penanganan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Kunjungan</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.poli?.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Kunjungan</td>
                                        <td>:</td>
                                        <td>{{ item.janji_temu?.tanggal_kunjungan }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayoutPasien>
</template>
