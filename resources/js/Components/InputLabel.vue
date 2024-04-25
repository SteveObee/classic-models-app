<script setup>
defineProps({
    value: String,
    required: Boolean
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value" class="flex justify-between">
            {{ value }}
            <p v-if="required" class="pl-2 text-red-600 italic"> * required field</p>
        </span>
        <span v-else><slot /></span>
    </label>
</template>
