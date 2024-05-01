<script setup>

const currentDate = new Date();

</script>

<template>
    <div class="flex justify-between items-center h-12 p-4 mt-20 bg-slate-300 ">
        <p class="text-sm text-slate-500">copyright &copy {{  currentDate.getFullYear() }}</p>
        <p class="text-sm text-slate-500">Images courtesy of <a href="https://www.pexels.com/" class="hover:underline">Pexels.com</a></p>
    </div>
</template>
