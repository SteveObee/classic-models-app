<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Order from '@/Components/Order.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useUrlBuilder } from '@/Composables/urlBuilder.js';
import SplitLayout from '@/Layouts/SplitLayout.vue';
import Sidebar from '@/Components/Sidebar.vue';
import MainPage from '@/Components/MainPage.vue';

const props = defineProps({
    orders: Object,
    sort_by: String,
    query_status: Array,
    status_options: Array
})

const { 
    prev_page_url,
    next_page_url,
    last_page_url,
    first_page_url,
    per_page,
    from,
    last_page,
    current_page,
    path,
    to,
    total
} = props.orders

const statusOptions = ref(props.status_options)
const selectedOrdersPerPage = ref(per_page)
const selectedSort = ref(props.sort_by)
const selectedStatus = ref(props.query_status)

const pageCountOptions = ref([
  { text: '5', value: 5 },
  { text: '10', value: 10 },
  { text: '15', value: 15 }
])

const sortOptions = ref([
    { text: 'Newest', value: 'desc'},
    { text: 'Oldest', value: 'asc'}
])

const url = (page) => {
    const builtUrl = useUrlBuilder(page, {
        per_page: selectedOrdersPerPage.value,
        sort: selectedSort.value,
        status: selectedStatus.value
        }
    )

    return builtUrl
}

const changePageOptions = () => {
    router.get(url(first_page_url));
}

const resetStatusSelection = () => {
    selectedStatus.value = statusOptions.value

    router.get(url(first_page_url))
}

const selectSingleStatus = (status) => {
    selectedStatus.value = [status];

    router.get(url(first_page_url))
}

</script>

<template>
    <AppLayout title="Orders">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>
        </template>

        <SplitLayout>                    
            <Sidebar class="sm:pt-14">
                <div class="pb-4">
                    <div v-for="statusOption in statusOptions" :key="statusOption.id" class="w-max">
                        <div class="flex items-center">
                            <input type="checkbox" :id=statusOption :value=statusOption v-model="selectedStatus" :onChange="changePageOptions">
                            <h2 @click="selectSingleStatus(statusOption)" class="pl-2 cursor-pointer hover:underline">{{' '}} {{ statusOption }}</h2>
                        </div>                             
                    </div>
                </div>
                <div class="pb-4">
                    <div :onClick="resetStatusSelection" class="w-full text-center border hover:bg-blue-400 cursor-pointer rounded-md hover:text-white">
                        Select All
                    </div>
                </div>
                <div class="pb-4">
                    <label for="order_count_select" class="block mb-2 text-sm font-medium text-gray-900">Per Page:</label>
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="order_count_select" :onChange="changePageOptions" v-model="selectedOrdersPerPage">
                        <option v-for="option in pageCountOptions" :value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>           
                <div class="pb-4">
                    <label for="sort_select" class="block mb-2 text-sm font-medium text-gray-900">Sort by:</label>
                    <select id="sort_select" v-model="selectedSort" :onChange="changePageOptions" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option v-for="option in sortOptions" :value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>  
            </Sidebar>
            <MainPage class="px-9">
                <Pagination
                    v-if="orders.data.length > 0"
                    :firstPageUrl=url(first_page_url)
                    :from=from
                    :lastPage=last_page
                    :lastPageUrl=url(last_page_url)
                    :currentPage=current_page
                    :nextPageUrl=url(next_page_url)
                    :path=path
                    :perPage=per_page
                    :prevPageUrl=url(prev_page_url)
                    :to=to
                    :total=total
                    class="pt-4">
                </Pagination>
                <Order v-if="orders.data.length > 0" v-for="order in orders.data" :Order="order" />
                <h2 v-else class="p-4 text-center text-gray-400">
                    No Orders with selected status
                </h2>
                <Pagination
                    v-if="orders.data.length > 0"
                    :firstPageUrl=url(first_page_url)
                    :from=from
                    :lastPage=last_page
                    :lastPageUrl=url(last_page_url)
                    :currentPage=current_page
                    :nextPageUrl=url(next_page_url)
                    :path=path
                    :perPage=per_page
                    :prevPageUrl=url(prev_page_url)
                    :to=to
                    :total=total
                    class="pt-4">
                </Pagination>
            </MainPage>          
        </SplitLayout> 

    </AppLayout>
</template>
