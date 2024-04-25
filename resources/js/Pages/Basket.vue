<script setup>
import { Head, router, usePage, Link } from '@inertiajs/vue3';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import BasketItem from '@/Components/BasketItem.vue';
import { computed, ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';

const props = defineProps({
    model: Object,
    canLogin: Boolean,
    canRegister: Boolean
})

const page = usePage();

const basketItems = computed(() => {
    return props.model.basket.basket_items.length > 0;
})

const editing = ref(false);

const enableEditing = () => {
    editing.value = true
}

const disableEditing = () => {
    editing.value = false
}

const emptyBasket = () => {
    router.delete(`basket/empty/${props.model.basket.id}`, { onSuccess: () => closeModal() })
    basketItemCount.value = 0;
}

const emptyGuestBasket = () => {
    router.delete('/basket/guest/empty', { onSuccess: () => closeModal() })
    basketItemCount.value = 0;
}

const confirmingEmptyBasket = ref(false);

const confirmEmptyBasket = () => {
    confirmingEmptyBasket.value = true
}

const closeModal = () => {
    confirmingEmptyBasket.value = false;
};

const back = () =>
{
    window.history.back();
}

const basketItemCount = ref(props.model.basket_item_count);

const decrementBasketItemCount = () => {
    basketItemCount.value --;
}

</script>

<template>
    <Head title="Basket" />
    <div class="overflow-y-scroll">
    <DialogModal :show="confirmingEmptyBasket" @close="closeModal">
        <template v-slot:title>Empty Basket</template>
        <template v-slot:content>
            <p class="mb-6">Really empty basket?. To remove all items, please click the confirmation button below</p>
        </template>
        <template v-slot:footer>
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>
            <DangerButton v-if="model.is_customer" @click="emptyBasket" class="ms-3">Empty Basket</DangerButton>
            <DangerButton v-else @click="emptyGuestBasket" class="ms-3">Empty Basket</DangerButton>
        </template>
    </DialogModal>
    <SiteLayout 
        :canLogin="props.canLogin" 
        :canRegister="props.canRegister"
        :basketItemCount="basketItemCount">
        <div class="max-w-2xl mx-auto p-8">
            <div class="mb-4">
                <div @click="back" class="flex w-min rounded-md py-1 px-2 text-white bg-green-300 items-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </div>
            </div>
            <h1 v-if="basketItems" class="text-lg text-center mb-4">Shopping Basket</h1>
            <div :class="basketItems && 'border'"  class="p-8">
                <div v-if="basketItems">
                    <div class="mb-8">
                        <BasketItem 
                            v-for="item in model.basket.basket_items"
                            :editing="editing"
                            @edit-enable="enableEditing"
                            @edit-disable="disableEditing"
                            @remove-item="decrementBasketItemCount"
                            :item="item" class="mb-8"
                            :isCustomer="model.is_customer" />
                    </div>
                    <div class="border-t"></div>
                    <h3 class="text-xl text-right py-4">{{ currencyFormatter(model.basket.basket_total) }}</h3>
                    <div class="flex justify-between">
                        <div @click="confirmEmptyBasket" class="my-2 flex items-center bg-orange-400 p-2 rounded text-md text-white cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                            <h3 class="px-1">Empty Basket</h3>
                        </div>
                        <Link v-if="$page.props.auth.user" href="checkout" class="my-2 flex items-center bg-blue-400 p-2 rounded text-md text-white cursor-pointer">        
                            <h3 class="px-1">Checkout</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </Link>
                        <Link v-else href="login" class="my-2 flex items-center bg-blue-400 p-2 rounded text-md text-white cursor-pointer">        
                            <h3 class="px-1">Login to Checkout</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </Link>
                    </div>
                </div>
                <div v-else class="text-center">
                    <h3 class="mb-6 text-xl">Empty Basket detected!</h3>
                    <h3 class="mb-6 text-xl">Lets go Shoppping &#129297</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 w-16 h-16 mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            </div>
        </div>
        </SiteLayout>
    </div>
</template>