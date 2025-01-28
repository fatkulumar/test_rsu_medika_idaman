<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavbarDokter from '@/Components/Partials/Admin/NavbarDokter.vue';
import AuthenticatedLayoutDokter from '@/Layouts/AuthenticatedLayoutDokter.vue';

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
        <AuthenticatedLayoutDokter>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarDokter title="Dashboard">
                                <div class="flex flex-wrap justify-center gap-24">
                                    <div class="bg-green-400 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.menginap }}</p>
                                        <p>Menginap</p>
                                    </div>

                                    <div class="bg-green-600 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.pulang }}</p>
                                        <p>Pulang</p>
                                    </div>

                                    <div class="bg-purple-600 w-48 h-32 flex flex-col items-center justify-center">
                                        <p>{{ dashboard.bolehPulang }}</p>
                                        <p>Boleh Pulang</p>
                                    </div>
                                </div>

                            </NavbarDokter>
                        </div>
                    </div>
                </div>
        </AuthenticatedLayoutDokter>

    </div>
</template>
