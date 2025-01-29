<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onBeforeMount } from 'vue';
import { onMounted } from 'vue';
import { toast } from 'vue3-toastify'

const props = defineProps({
    flash: {
        type: Object,
        require: false
    }
})

onBeforeMount(() => {
    if (props.flash?.success != null) {
        console.log(props.flash.success)
        showToast(props.flash?.success)
      }
})

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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
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
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-center gap-2">
                        <Link :href="route('pegawai.lama')" class="bg-red-600 rounded-md px-4 py-2">
                            Pasien Lama
                        </Link>

                        <Link :href="route('pegawai.baru')" class="bg-green-600 rounded-md px-4 py-2">
                            Pasien Baru
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
