<script setup>
import ActionMessage from '@/Components/ActionMessage.vue';
import { computed, ref, watch, watchEffect } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';


const page = usePage()

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    basketItemCount: Number
})

const flashedData = computed(() => {
    return page.props.flash
})

const messageDisplayed = ref(false);

const displayMessage = () => {
    if (flashedData.value.message) {
        messageDisplayed.value = true;
    }
}

const hideMessage = (duration = 2000) => {
    setTimeout(() => (messageDisplayed.value = false), duration)
}

watch(flashedData, () => {
    displayMessage()
    hideMessage()
}, { immediate: false })

</script>

<template >
    <div class="h-screen flex flex-col justify-between">
        <div v-if="canLogin" class="flex justify-between w-full max-w-7xl p-6 self-center">
            <Link :href="route('products.index')">
                <ApplicationLogo class="overflow-visible"></ApplicationLogo>
            </Link>
            
            <ActionMessage :on="messageDisplayed" class="fixed w-max inset-x-1/2 -translate-x-2/4">
                <h1>{{ flashedData.message }}</h1>
            </ActionMessage>
            <div class="flex items-center ">
                <Link :href="route('basket.index')"class="flex items-center mr-4 cursor-pointer text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                        <path d="M1 1.75A.75.75 0 0 1 1.75 1h1.628a1.75 1.75 0 0 1 1.734 1.51L5.18 3a65.25 65.25 0 0 1 13.36 1.412.75.75 0 0 1 .58.875 48.645 48.645 0 0 1-1.618 6.2.75.75 0 0 1-.712.513H6a2.503 2.503 0 0 0-2.292 1.5H17.25a.75.75 0 0 1 0 1.5H2.76a.75.75 0 0 1-.748-.807 4.002 4.002 0 0 1 2.716-3.486L3.626 2.716a.25.25 0 0 0-.248-.216H1.75A.75.75 0 0 1 1 1.75ZM6 17.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM15.5 19a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>
                    <h2 class="pl-1">({{ basketItemCount }})</h2>
                </Link >


                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

                <template v-else>
                    <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
                </template>
            </div>
        </div>
        <div class="flex-grow" >
            <slot />
        </div>
        <Footer />
    </div>
</template>

<style>

</style>