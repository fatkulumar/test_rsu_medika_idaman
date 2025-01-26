<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import NavbarAdmin from '@/Components/Partials/Admin/NavbarAdmin.vue';
import AuthenticatedLayoutAdmin from '@/Layouts/AuthenticatedLayoutAdmin.vue';

const props = defineProps({
    users: {
        type: Object,
        require: true,
    }
});

</script>

<template>
    <Head title="Users" />
    <div>
        <AuthenticatedLayoutAdmin>

                <div class="max-w-full">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                    >
                        <div class="text-gray-900 dark:text-gray-100">
                            <NavbarAdmin title="Users">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item, index in props.users.data" :key="index" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ index + props.users.from }}
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
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </NavbarAdmin>
                        </div>
                    </div>
                </div>
        </AuthenticatedLayoutAdmin>

    </div>
</template>
