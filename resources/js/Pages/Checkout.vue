<script setup>
import SiteLayout from "@/Layouts/SiteLayout.vue";
import { Head, router, usePage } from '@inertiajs/vue3';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import { ref } from "vue";
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Address from "@/Components/Address.vue";
import NewCustomerForm from "@/Components/NewCustomerForm.vue";


const props = defineProps({
    model: Object
})

const { basket } = props.model;

const page = usePage();

const selectedDate = ref(props.model.date_options[0].value);

const confirmingOrderPlacement = ref(false);

const confirmOrderPlacement = () => {
    confirmingOrderPlacement.value = true;
}

const closeModal = () => {
    confirmingOrderPlacement.value = false;
};

const placeOrder = () => {
    const data = {
        requiredDate: selectedDate.value,
        status: 'In Process',
        customerNumber: page.props.auth.user.customer_id,
        orderDetails: []
    }

    props.model.basket.basket_items.forEach((basketItem, index) => {
        let orderDetail = {}

        orderDetail.orderLineNumber = index + 1
        orderDetail.productCode = basketItem.product.productCode
        orderDetail.quantityOrdered = basketItem.quantity
        orderDetail.priceEach = basketItem.price_each

        data.orderDetails.push(orderDetail)
    });

    router.post('/order', data)
};

const back = () =>
{
    window.history.back();
}

const basketItemCount = ref(props.model.basket_item_count);

</script>

<template>
    <Head :title="'Checkout'"/>
    <DialogModal :show="confirmingOrderPlacement" @close="closeModal">
        <template v-slot:title>Place Order</template>
        <template v-slot:content>
            <p class="mb-6">Please confirm order placement by clicking the button provided</p>
        </template>
        <template v-slot:footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>
            <PrimaryButton @click="placeOrder" class="ms-3">Place Order</PrimaryButton>
        </template>
    </DialogModal>
    <SiteLayout 
        :canLogin="true" 
        :canRegister="true"
        :basketItemCount="basketItemCount">
        <div class="max-w-2xl mx-auto p-8">
            <div class="mb-4">
                <div @click="back" class="flex w-min rounded-md py-1 px-2 text-white bg-green-300 items-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </div>
            </div>
            <h1 class="text-lg text-center mb-4">Checkout</h1>
            <div class="border p-8">
                <div class="mb-4">
                    <div v-for="basket_item in basket.basket_items" :key="basket_item.id"
                        class="sm:grid grid-cols-6 justify-items-stretch py-4">
                        <h2 class="col-span-4">{{ basket_item.quantity }} x {{ basket_item.product.productName }}</h2>
                        <h2> @ {{ currencyFormatter(basket_item.product.MSRP) }}</h2>
                        <h2 class="justify-self-end">{{ currencyFormatter(basket_item.item_sum) }}</h2>
                    </div>
                </div>
                <div class="border-t mb-4"></div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl">Order Total</h3>
                    <h3 class="text-xl py-4">{{ currencyFormatter(basket.basket_total) }}</h3>
                </div>
                <div class="border-t mb-8"></div>
                <div v-if="model.customer">
                    <h3 class="mb-4">Delivery Address:</h3>
                    <Address :customer="model.customer"></Address>
                </div>
                <div v-else>
                    <NewCustomerForm></NewCustomerForm>
                </div>
                <div class="border-t my-8"></div>
                <div class="flex flex-col items-end">
                    <label for="selected_date" class="mb-4">Please select required delivery date</label>
                    <select v-model="selectedDate" id="selected_date" class="mb-4">
                        <option v-for="date in model.date_options" :value="date.value">
                            {{ date.text }}
                        </option>
                    </select>
                    <div v-if="model.customer" @click="confirmOrderPlacement" href="checkout" class="flex items-center w-max my-2 bg-blue-400 p-2 rounded text-md text-white cursor-pointer">        
                        <h3 class="px-1">Place Order</h3>
                    </div>
                    <div v-else href="checkout" class="flex items-center w-max my-2 bg-gray-400 p-2 rounded text-md text-white cursor-default">        
                        <h3 class="px-1">Place Order</h3>
                    </div>
                </div>
            </div>

        </div>
    </SiteLayout>
</template>