<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const props = defineProps({
    user: Object,
    current_orders: Number,
    completed_orders: Number,
    customer: Object
})

</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <ApplicationLogo class="block h-12 w-auto" />

            <div v-if="customer">
                <h1 class="mt-8 text-2xl font-medium text-gray-900">
                    Welcome back, {{ customer.contactFirstName }}
                </h1>
                <h1 class="text-1xl">
                    ( {{  customer.customerName }} )
                </h1>
                <p class="mt-6 text-gray-500 leading-relaxed">
                    Outstanding Orders: {{ current_orders }}
                </p>
                <p class="mt-2 text-gray-500 leading-relaxed">
                    Completed Orders: {{ completed_orders }}
                </p>
            </div>
            
            <h1 v-else class="mt-8 text-2xl font-medium text-gray-900">
                Welcome back, {{user.name}}
            </h1>

            <p v-if="user.created_at" class="mt-2 text-gray-500 leading-relaxed">
                Member Since: {{ user.created_at }}
            </p>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
  
        </div>
    </div>
</template>
