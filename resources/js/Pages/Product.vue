<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import SiteLayout from "@/Layouts/SiteLayout.vue";
import { checkDigit } from '@/Helpers/checkDigit';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import { computed, ref } from 'vue';

const props = defineProps({
    model: Object
})
const { 
    quantityInStock, 
    productVendor, 
    productDescription, 
    created_at,
    image_id,
    productName
} = props.model.product;

const MSRP = currencyFormatter(props.model.product.MSRP);

const page = usePage();

const productExistsInBasket = computed(() => {
    return props.model.basket_item ? true : false
})


const stockClass = computed(() => {
    return props.model.product.quantityInStock > 0 ? 'text-green-400' : 'text-red-400'
})

const customerId = computed(() => {
    return page.props.auth.user ? page.props.auth.user.customer_id : null;
})

const errors = ref({})

const clearErrors = () => {
    errors.value = {}
}

const selectedQuantity = ref('1')
const existingBasketItem = ref(props.model.basket_item)
const basketItemQuantity = ref(props.model.basket_item && props.model.basket_item.quantity)

const quantityHasChanged = computed(() => {
    return existingBasketItem.value.quantity != basketItemQuantity.value
})

const validate = (value) => {
    if (value > quantityInStock) {
        errors.value.quantity = 'Quantity exceeds available stock.';
    }

    if (value == 0) {
        errors.value.quantity = 'Valid Quantity Required.';
    }
};

const addToBasket = () => {
    clearErrors();
    validate(selectedQuantity.value);
    
    if (!errors.value.quantity) {
        
        const data = {
            basket_id: page.props.auth.user.basket_id,
            product_code: props.model.product.productCode,
            price_each: props.model.product.MSRP,
            quantity: selectedQuantity.value
        };
        
        router.post('/basket-items', data) 
        
        existingBasketItem.value = data;
        
        basketItemCount.value ++;
        
        basketItemQuantity.value = data.quantity
    }
}

const addToGuestBasket = () => {
    clearErrors();
    validate(selectedQuantity.value);

    if (!errors.value.quantity) {
        const data = {
            quantity: selectedQuantity.value,
            product: {
                productCode: props.model.product.productCode,
                productName: props.model.product.productName,
                MSRP: props.model.product.MSRP,
                image_id: props.model.product.image_id
            }
        };

        router.post('/basket-items/guest', data)

        existingBasketItem.value = data;

        basketItemCount.value ++;

        basketItemQuantity.value = data.quantity
    }
}

const updateBasket = () => {
    clearErrors()
    validate(existingBasketItem.value.quantity);

    if (!errors.value.quantity && quantityHasChanged.value) {
        const data = props.model.basket_item

        data.quantity = existingBasketItem.value.quantity

        router.put('/basket-items', data)

        basketItemQuantity.value = data.quantity
    }
}

const updateGuestBasket = () => {
    clearErrors()
    validate(existingBasketItem.value.quantity)

    if (!errors.value.quantity && quantityHasChanged.value) {
        const data = props.model.basket_item

        data.quantity = existingBasketItem.value.quantity

        router.put('/basket-items/guest', data)

        basketItemQuantity.value = data.quantity
    }
}

const back = () =>
{
    window.history.back();
}

const basketItemCount = ref(props.model.basket_item_count);

</script>

<template>
    <Head :title="productName" />
    <div class="overflow-y-scroll">
        <SiteLayout 
        :canLogin="true"
        :canRegister="true"
        :basketItemCount="basketItemCount">
            <div class="max-w-7xl mt-16 mx-auto p-6 lg:p-8 flex">
                <div class="mb-8 w-full">
                    <div class="mb-4">
                        <div @click="back" class="flex w-min rounded-md py-1 px-2 text-white bg-green-300 items-center cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6 w-100 bg-white rounded-lg shadow-2xl shadow-gray-800/20">

                        <div class="sm:flex mb-8">
                            <div class="grow">
                                <img :src="'/storage/images/medium/' + image_id + '.jpg'" :alt="productName">
                            </div>
                            <div class="flex-none">
                                <div class="mt-6 sm:mt-0 mb-12">
                                    <h2 class="text-xl text-right mb-4">
                                        {{ MSRP }}
                                    </h2>
                                    <h2 :class="stockClass" class="text-base text-right">
                                        {{ quantityInStock }} remaining
                                    </h2>
                                </div >
                                
                                <div v-if="productExistsInBasket" class="flex flex-col items-end">
                                    <h3 class="mb-2  text-green-400 italic">In basket</h3>
                                    <h3 v-if="model.basket_item.updated_at" class="mb-2 italic text-sm text-gray-400">Updated:</h3>
                                    <h3 v-if="model.basket_item.updated_at" class="mb-4 italic text-sm text-gray-400">{{  model.basket_item.updated_at }}</h3>
                                    <div class="mb-4 flex flex-col items-end">
                                        <h2 class="">Quantity:</h2>
                                        <input @keydown="checkDigit" type="text" v-model="existingBasketItem.quantity" class="ml-2 text-right w-20 border">
                                    </div>
                                    <div class="h-2 mb-6">
                                        <h2 class="text-red-400 italic">{{ errors.quantity }}</h2>
                                    </div>
                                    <div v-if="customerId" @click="updateBasket" :class="quantityHasChanged ? 'bg-blue-500 cursor-pointer' : 'bg-gray-400 cursor-default'" class="w-max mb-4 flex justify-center p-2 rounded text-sm text-white">        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="px-1">Update</h3>
                                    </div>
                                    <div v-else @click="updateGuestBasket" :class="quantityHasChanged ? 'bg-blue-500 cursor-pointer' : 'bg-gray-400 cursor-default'" class="w-max mb-4 flex justify-center p-2 rounded text-sm text-white">        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="px-1">Update</h3>
                                    </div>
                                </div>
                                
                                <div v-else class="flex flex-col items-end">
                                    <div class="mb-2 flex justify-end items-center">
                                        <h2 class="">Quantity</h2>
                                        <input @keydown="checkDigit" type="text" v-model="selectedQuantity" class="ml-2 text-right w-20 border">
                                    </div>
                                    <div class="h-2 mb-6">
                                        <h2 class="text-red-400 italic">{{ errors.quantity }}</h2>
                                    </div>
                                    <div v-if="customerId" @click="addToBasket" class="w-max mb-4 flex justify-center bg-blue-400 p-2 rounded text-sm text-white cursor-pointer">        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="px-1">Add to Basket</h3>
                                    </div>
                                    <div v-else @click="addToGuestBasket" class="w-max mb-4 flex justify-center bg-blue-400 p-2 rounded text-sm text-white cursor-pointer">        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="px-1">Add to Basket</h3>
                                    </div>
                                </div>
                            </div>
                        </div>  

                        <h2 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">{{ productName }}</h2>
                        <h3 class="mb-6">by {{ productVendor }}</h3>

                                
                        <p class="mb-6 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            {{ productDescription }}
                        </p>

                        <h3>Introduced {{ created_at }}</h3>
                    </div>
                </div>
            </div>  
        
        </SiteLayout>
    </div>
</template>