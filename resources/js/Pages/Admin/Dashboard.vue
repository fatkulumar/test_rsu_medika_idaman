<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/Partials/Admin/NavbarAdmin.vue';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';

defineProps({
    dashboard: {
        type: Object,
        require: true,
    }
})
</script>

<template>
    <Head title="Admin Dashboard" />
    <div>
        <AuthenticatedLayoutAdmin>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarAdmin title="Dashboard">
                                <div class="flex flex-wrap justify-center gap-24">
                                    <div class="bg-red-600 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.user }}</p>
                                        <p>Users</p>
                                    </div>

                                    <div class="bg-green-600 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.dokter }}</p>
                                        <p>Dokter</p>
                                    </div>

                                    <div class="bg-purple-600 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.poli }}</p>
                                        <p>Poli</p>
                                    </div>

                                    <div class="bg-red-400 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.daftar }}</p>
                                        <p>Pendaftaran</p>
                                    </div>

                                    <div class="bg-green-400 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.menginap }}</p>
                                        <p>Menginap</p>
                                    </div>

                                    <div class="bg-purple-400 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.pulang }}</p>
                                        <p>Pulang</p>
                                    </div>
                                </div>

                            </NavbarAdmin>
                        </div>
                    </div>
                </div>
        </AuthenticatedLayoutAdmin>

    </div>
</template>
