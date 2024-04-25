<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import { computed, ref } from 'vue';
import ActionMessage from './ActionMessage.vue';

const props = defineProps({
    editing: Boolean,
    item: Object,
    isCustomer: Boolean
})

const page = usePage();

const errors = computed(() => {
    return page.props.errors;
})

const itemSum = computed(() => {
    return props.item.item_sum && currencyFormatter(props.item.item_sum);
})

const basketItem = ref({
    quantity: props.item.quantity
});

const changeQuantity = () => {
    const data = props.item
    data.quantity = basketItem.value.quantity
    delete data.item_sum
    
    router.put('/basket-items', data)
    edit.value = !edit.value
    emit('editDisable')
}

const updateGuestBasket = () => {
    const data = props.item
    data.quantity = basketItem.value.quantity
    delete data.item_sum

    router.put('/basket-items/guest', data)
    edit.value = !edit.value
    emit('editDisable')
}

const edit = ref(false)

const emit = defineEmits(['editEnable', 'editDisable', 'removeItem']);

const toggleEdit = () => {
    edit.value = !edit.value
    emit('editEnable')
}

const cancel = () => {
    edit.value = !edit.value
    emit('editDisable')
    basketItem.value.quantity = props.item.quantity
}

const removeItemFromBasket = () => {
    router.delete(`/basket-items/${props.item.id}`, { preserveScroll: true })
    emit('removeItem')
}

const removeItemFromGuestBasket = () => {
    router.delete(`/basket-items/guest/${props.item.id}`, { preserveScroll: true })
    emit('removeItem')
}

</script>

<template>
    <div class="flex items-center">
        <div v-if="edit">
            <svg v-if="isCustomer" @click="changeQuantity" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 cursor-pointer m-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <svg v-else @click="updateGuestBasket" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 cursor-pointer m-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <svg @click="cancel" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500 cursor-pointer m-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>   
        <div v-else class="cursor-pointer mr-4" >
            <svg v-if="editing" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 opacity-30 cursor-default">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
            </svg>
            <svg v-else @click="toggleEdit" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
            </svg>
        </div>
        <Link :href="'/product/' + item.product.productCode">
            <img :src="'/storage/images/tiny/' + item.product.image_id + '.jpg'" :alt="item.product.productName" class="w-28">
        </Link>
        <div class="ml-4 flex-grow">
            <Link :href="'/product/' + item.product.productCode">
                <h2>{{ props.item.product.productName }}</h2>
            </Link>
            <div class="flex justify-between">
                <div v-if="edit" >
                    <div class="flex">
                    <input name="" id="quantity" v-model="basketItem.quantity" class="w-12 h-6">
                    <h2>{{ '&nbsp @ ' + item.product.MSRP }}</h2>
                </div>
                    <h2 class="text-red-500 italic">{{ errors.quantity }}</h2>
                </div>
                <div v-else>
                    <h2>{{ basketItem.quantity }} @ {{ currencyFormatter(item.product.MSRP) }}</h2>
                </div>
                <div class="text-right">
                    <h2 class="mb-2 h-8">{{ itemSum }}</h2>
                    <div v-if="isCustomer" @click="removeItemFromBasket" class="my-2 flex items-center bg-red-400 px-2 rounded text-sm text-white cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="px-1">Remove</h3>
                    </div>
                    <div v-else @click="removeItemFromGuestBasket" class="my-2 flex items-center bg-red-400 px-2 rounded text-sm text-white cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="px-1">Remove</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>