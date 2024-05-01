<script setup>
import SiteLayout from "@/Layouts/SiteLayout.vue";
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";

const props = defineProps({
    order: Object,
    basket_item_count: Number
})

const basketItemCount = ref(props.basket_item_count);

</script>

<template>
    <Head :title="'Confirmation'"/>
    <SiteLayout 
        :canLogin="true" 
        :canRegister="true"
        :basketItemCount="basketItemCount">
        <div class="max-w-2xl mx-auto p-8">
            <div class="border p-8 text-center">         
                <h2 class="text-xl mb-4">Order {{ order.orderNumber }} Confirmed</h2>
                <p class="mb-4">Your order has been received and is being processed. We will be in contact when your items are ready for shipping and will aim to have delivery completed by {{ order.requiredDate }} as requested. </p>
                <p class="mb-4">Thank you for your custom. </p>
                <p class="mb-4">- The Classic Models Team </p>
            </div>
        </div>
    </SiteLayout>
</template>
