<script setup>
import { usePage } from '@inertiajs/vue3';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import { computed, ref } from 'vue';

const props = defineProps({
    Order: Object
})

const orderDetails = props.Order.order_details;

const { orderNumber,
    orderDate,
    status,
    shippedDate,
    requiredDate,
    comments} = props.Order;

const orderTotal = currencyFormatter(props.Order.orderTotal);

const toggle = ref(false);

const statusClass = computed(() => {
    const status = props.Order.status
    let classToApply

    switch (status) {
        case "Shipped":
            classToApply = "text-green-400"
            break;
        case "In Process":
            classToApply = "text-blue-400"
            break;
        case "Resolved":
            classToApply = "text-purple-400"
            break;
        case "Cancelled":
            classToApply = "text-red-400"
            break;
        case "Disputed":
            classToApply = "text-orange-400"
            break;
        default:
            break;
    }

    return classToApply
})



</script>

<template>
    <div class="mt-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div @click="toggle = !toggle"  class="flex justify-between items-center p-6 lg:p-8 bg-white border-b border-gray-200 cursor-pointer">
            <div class="text-center">
                <h1 class="text-2xl font-medium text-gray-900">
                    #{{ orderNumber }}
                </h1>

                <p class="leading-tight">
                    ( {{ orderDate }} )
                </p>
            </div>

            <div class="text-center">
                <h2 :class="statusClass" class="font-semibold text-xl leading-tight">
                    {{ status }}           
                </h2>
                <div v-if="Order.shippedDate" class="flex">
                    <p class="text-sm pr-1">(</p>
                    <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                        <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                        <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                    </svg>
                    <p class="text-sm pl-1">{{ shippedDate }} )</p>
                </div>
                <div v-else class="flex">
                    <p class="text-sm pr-1">(</p>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm pl-1">{{ requiredDate }} )</p>
                </div>
            </div>
            <button v-if="toggle" type="button" class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                </svg>
            </button>
            <button v-else type="button" class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Order Details -->
        <div v-if="toggle" class="p-4 overflow-scroll">
            
                <table class="table-auto text-left text-md font-light">
                    <thead class="border-b font-medium dark:border-neutral-500 dark:bg-neutral-600">
                        <tr>
                            <th scope="col" class="px-6 py-4">#</th>
                            <th scope="col" class="px-6 py-4">Product Code</th>
                            <th scope="col" class="px-6 py-4">Unit Price</th>
                            <th scope="col" class="px-6 py-4">Quantity</th>
                            <th scope="col" class="px-6 py-4">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="detail in orderDetails" class="border-b">
                            <td :class="[detail.orderLineNumber % 2 == 0 ? 'bg-gray-200' : 'bg-white']" class="whitespace-nowrap px-6 py-4">{{ detail.orderLineNumber }}</td>
                            <td :class="[detail.orderLineNumber % 2 == 0 ? 'bg-gray-200' : 'bg-white']" class="whitespace-nowrap px-6 py-4">{{ detail.productCode }}</td>
                            <td :class="[detail.orderLineNumber % 2 == 0 ? 'bg-gray-200' : 'bg-white']" class="whitespace-nowrap px-6 py-4">{{ currencyFormatter(detail.priceEach) }}</td>
                            <td :class="[detail.orderLineNumber % 2 == 0 ? 'bg-gray-200' : 'bg-white']" class="whitespace-nowrap px-6 py-4">{{ detail.quantityOrdered }}</td>
                            <td :class="[detail.orderLineNumber % 2 == 0 ? 'bg-gray-200' : 'bg-white']" class="whitespace-nowrap px-6 py-4">{{ currencyFormatter(detail.totalCost) }}</td>
                        </tr>
                        <tr class="">
                            <td></td>
                            <td></td>
                            <td></td> 
                            <td></td> 
                            <td class="whitespace-nowrap px-6 py-4 font-extrabold border-y">{{ orderTotal }}</td> 
                        </tr>
                    </tbody>
                </table>              
            <div v-if="Order.comments" class="">
                <p class="mt-4">Comments:</p>
                <p class="mt-2">{{ comments }}</p>
            </div>
        </div>
    </div>
</template>
