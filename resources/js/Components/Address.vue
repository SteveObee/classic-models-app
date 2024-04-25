<script setup>
import { computed } from 'vue';

const props = defineProps({
    customer: Object
})

const customerFullName = computed(() => {
    return props.customer.contactFirstName + ' ' + props.customer.contactLastName
})

</script>

<template>
    <div>
        <p class="mt-1">{{ customerFullName }}</p>
        <p class="mt-1">{{ customer.addressLine1 }}</p>
        <p class="mt-1">{{ customer.addressLine2 }}</p>
        <p class="mt-1">{{ customer.city }}</p>
        <p class="mt-1">{{ customer.state }}</p>
        <p class="mt-1">{{ customer.postalCode }}</p>
        <p class="mt-1">{{ customer.country }}</p>
    </div>
</template>
