<script setup>
import { currencyFormatter } from '@/Helpers/currencyFormatter';


const props = defineProps({
    payment: Object
})

const {checkNumber, paymentDate, amount} = props.payment;

</script>

<template>
    <div class="mt-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div @click="toggle = !toggle"  class="flex justify-between items-center p-6 lg:p-8 bg-white border-b border-gray-200 cursor-pointer">
            <h1 class="text-xl font-medium text-gray-900">
                #{{ checkNumber }}
            </h1>

            <h2 class="font-semibold text-xl leading-tight">
                {{ paymentDate }}
            </h2>

            <h2 class="font-semibold text-xl leading-tight">
                {{ currencyFormatter(amount) }}
            </h2>
        </div>
    </div>
            
</template>
