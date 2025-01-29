<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute top-0 left-0 w-screen h-screen object-cover"
            src="/hospital.jpg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white border-gray-400 border-2"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="flex justify-center"
                >
                    <ApplicationLogo />
                </header>

                <main class="md:mt-6">
                    <div class="grid gap-6">
                        <div class="mx-auto md:text-center text-justify">
                            <span class="text-xl font-semibold text-black bg-white w-auto">
                                Selamat Datang di RSU Sakina Idaman – Pelayanan Terbaik untuk Kesehatan Anda
                            </span>
                        </div>
                        <div class="md:w-9/12 mx-auto text-black md:text-center text-justify">
                            <span class="bg-white">
                            Di RSU Sakina Idaman, setiap pasien adalah bagian dari keluarga besar kami. Kami memahami bahwa setiap langkah menuju kesembuhan dimulai dari pelayanan yang ramah, fasilitas yang nyaman, serta tenaga medis yang kompeten dan berdedikasi tinggi. Oleh karena itu, kami selalu siap melayani dengan sepenuh hati, memastikan Anda mendapatkan perawatan terbaik yang sesuai dengan kebutuhan Anda.
                            </span>
                        </div>
                        <div class="mx-auto">
                            <div v-if="canLogin" class="flex gap-1">
                                <Link
                                    v-if="$page.props.auth?.role == 'admin'"
                                    :href="route('admin.dashboard')"
                                    class="bg-green-600 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </Link>

                                <Link
                                    v-else-if="$page.props.auth?.role == 'pegawai'"
                                    :href="route('dashboard')"
                                    class="bg-green-600 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </Link>

                                <Link
                                    v-else-if="$page.props.auth?.role == 'dokter'"
                                    :href="route('dokter.dashboard')"
                                    class="bg-green-600 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </Link>

                                <Link
                                    v-else-if="$page.props.auth?.role == 'pasien'"
                                    :href="route('pasien.dashboard')"
                                    class="bg-green-600 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Dashboard
                                </Link>

                                <template v-else>
                                    <Link
                                        :href="route('login')"
                                        class="bg-purple-600 hover:bg-purple-500 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </Link>

                                    <Link
                                        v-if="canRegister"
                                        :href="route('register')"
                                        class="bg-blue-600 hover:bg-blue-500 rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Register
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </main>

            </div>
        </div>
    </div>
</template>
