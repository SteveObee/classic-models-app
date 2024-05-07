<script setup>
import MainPage from '@/Components/MainPage.vue';
import Pagination from '@/Components/Pagination.vue';
import Sidebar from '@/Components/Sidebar.vue';
import { currencyFormatter } from '@/Helpers/currencyFormatter';
import { useUrlBuilder } from '@/Composables/urlBuilder';
import { useDebounce } from '@/Composables/debounce';
import SiteLayout from '@/Layouts/SiteLayout.vue';
import SplitLayout from '@/Layouts/SplitLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({ 
    request: Array,
    products: Object,
    productVendorOptions: Array,
    productLineOptions: Array,
    productScaleOptions: Array,
    productVendorIds: Array,
    queryProductLines: Array,
    queryVendorIds: Array,
    querySortMethod: Array,
    queryProductScaleIds: Array,
    searchTerm: String,
    canLogin: Boolean,
    canRegister: Boolean,
    guestBasketItemCount: Number
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
    total,
    data
} = props.products

const productLineOptions = ref(props.productLineOptions)
const productVendorOptions = ref(props.productVendorOptions)
const productScaleOptions = ref(props.productScaleOptions)

const selectedProductLines = ref(props.queryProductLines)
const selectedProductVendors = ref(props.queryVendorIds)
const selectedProductsPerPage = ref(per_page)
const selectedSortMethod = ref(props.querySortMethod)
const selectedProductScales = ref(props.queryProductScaleIds)

const pageCountOptions = ref([
  { text: '6', value: 6 },
  { text: '15', value: 15 },
  { text: '30', value: 30 }
])

const sortOptions = ref([
    { text: 'Date (Newest to Oldest)', value: ['created_at', 'desc'] },
    { text: 'Date (Oldest to Newest)', value: ['created_at', 'asc'] },
    { text: 'Price (Highest to Lowest)', value: ['MSRP', 'desc'] },
    { text: 'Price (Lowest to Highest)', value: ['MSRP', 'asc'] }
])

const url = (page) => {
    const builtUrl = useUrlBuilder(page, {
        per_page: selectedProductsPerPage.value,
        product_lines: selectedProductLines.value,
        vendor_ids: selectedProductVendors.value,
        sort_method: selectedSortMethod.value,
        product_scales: selectedProductScales.value,
        search_term: searchTerm.value
    })

    return builtUrl
}

const changePageOptions = () => {
    router.visit(url(first_page_url), { preserveScroll: true });
}

const resetVendors = () => {
    let vendorOptions = []

    productVendorOptions.value.forEach(vendorOption =>{
        vendorOptions.push(vendorOption.id)
    })

    selectedProductVendors.value = vendorOptions
}

const resetProductLines = () => {
    let productLines = [];

    productLineOptions.value.forEach(productLineOption => {
        productLines.push(productLineOption.productLine)
    })

    selectedProductLines.value = productLines
}

const resetProductScales = () => {
    let productScales = [];

    productScaleOptions.value.forEach(productScaleOption => {
        productScales.push(productScaleOption.id)
    })

    selectedProductScales.value = productScales
}

const resetProductLineSelection = () => {
    resetProductLines()
    resetVendors()
    router.visit(url(first_page_url), { preserveScroll: true })
}

const resetProductScaleSelection = () => {
    resetProductScales()
    resetVendors()

    router.visit(url(first_page_url), { preserveScroll: true })
}

const resetSearch = () => {
    searchTerm.value = '';
    runSearch();
}

const selectSingleProductLine = (ProductLine) => {
    selectedProductLines.value = [ProductLine];
    resetVendors()

    router.visit(url(first_page_url), { preserveScroll: true })
}

const selectSingleProductScale = (ProductScale) => {
    selectedProductScales.value = [ProductScale];
    resetVendors()

    router.visit(url(first_page_url), { preserveScroll: true })
}

const selectSingleVendor = (vendor) => {
    selectedProductVendors.value = [vendor]

    router.visit(url(first_page_url), { preserveScroll: true })
}

const currentProductScale = computed(() => {
    return productScaleOptions.value[selectedProductScales.value[0] - 1].productScale
})

const searchTerm = ref(props.searchTerm);
const searching = ref(false);

watch(searchTerm, useDebounce(() => runSearch(), 1000))

const runSearch = () => {
    searching.value = false;
    resetVendors()

    router.visit(url(first_page_url))

    router.on('navigate', () => {
        document.getElementById("search").focus();
    });
};

window.addEventListener('popstate', function (event) {
    location.reload()
});

const guestBasketItemCount = ref(props.guestBasketItemCount);

</script>

<template>
    <Head title="Products" />
    <SiteLayout 
        :canLogin="props.canLogin" 
        :canRegister="props.canRegister"
        :basketItemCount="guestBasketItemCount">
        <SplitLayout>
            <Sidebar class="sm:w-min">
                <!-- Search -->
                <div class="p-4 mb-4 border flex items-center">
                    <div class="px-2">
                    <div v-if="searching">
                        <svg class="animate-spin h-5 w-6 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div v-else>
                        <svg v-if="!searchTerm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <svg v-else @click="resetSearch()" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    </div>
                    <input id="search" @input="searching = true" v-model="searchTerm" placeholder="Search..." class="border border-gray-300 p-1">

                </div>

                <!-- Product lines -->
                <div class="p-4 border">
                    <div class="flex items-center">
                        <div class="w-4 h-4">
                            <svg v-show="selectedProductLines.length > 1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                        <h2 @click="resetProductLineSelection" class="cursor-pointer hover:underline">All Products</h2>
                    </div>

                    <div v-for="productLine in productLineOptions" :key="productLine.id" class="w-max">
                        <div class="flex items-center pl-4">
                            <div class="w-4 h-4">
                                <svg v-show="selectedProductLines.length == 1 && productLine.productLine == selectedProductLines" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                            <h2 @click="selectSingleProductLine(productLine.productLine)" class="cursor-pointer hover:underline">{{' '}} {{ productLine.productLine }}</h2>
                            <h2 v-if="productLine.productCount" class="pl-2">({{ productLine.productCount }})</h2>
                        </div>                             
                    </div>
                </div>

                <!-- Product Scales -->
                
                <div class="p-4 mt-4 border">
                    <div class="flex items-center">
                        <div class="w-4 h-4">
                            <svg v-show="selectedProductScales.length > 1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                        <h2 @click="resetProductScaleSelection" class="cursor-pointer hover:underline">All Model Scales</h2>
                    </div>

                    <div v-for="productScale in productScaleOptions" :key="productScale.id" class="w-max">
                        <div class="flex items-center pl-4">
                            <div class="w-4 h-4">
                                <svg v-show="selectedProductScales.length == 1 && productScale.id == selectedProductScales" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                            <h2 v-if="productScale.productCount" @click="selectSingleProductScale(productScale.id)" class="cursor-pointer hover:underline">{{' '}} {{ productScale.productScale }}</h2>
                            <h2 v-else >{{' '}} {{ productScale.productScale }}</h2>
                            <h2 v-if="productScale.productCount" class="pl-2">({{ productScale.productCount }})</h2>
                        </div>
                    </div>
                </div>
                
                <!-- Vendors -->
                <div v-once class="p-4 border mt-4">
                    <h2 class="pb-2">Vendors:</h2>
                    <div v-for="productVendor in productVendorOptions" class="w-max">
                        <div class="flex items-center">
                            <input type="checkbox" :disabled="!productVendor.productCount" :value="productVendor.id" :id="productVendor.id" v-model="selectedProductVendors" :onChange="changePageOptions">
                            <h2 v-if="productVendor.productCount"  @click="selectSingleVendor(productVendor.id)" class="pl-2 cursor-pointer hover:underline">{{' '}} {{ productVendor.vendorName }} </h2>
                            <h2 v-else class="pl-2">{{' '}} {{ productVendor.vendorName }} </h2>
                            <h2 v-if="productVendor.productCount" class="pl-2">({{ productVendor.productCount ? productVendor.productCount : 0 }})</h2>
                        </div>                            
                    </div>
                </div>

                <!-- Filters -->
                <div class="p-4 border w-200 mt-4 flex flex-col justify-around">
                    <h2 class="">Filters:</h2>
                    
                    <!-- Sort Method -->
                    <div class="pt-4">
                        <label for="sort_by" class="block mb-2 text-sm font-medium text-gray-900">Sort By:</label>
                        <select class="w-52 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" id="sort_by" :onChange="changePageOptions" v-model="selectedSortMethod">
                            <option v-for="option in sortOptions" :value="option.value">
                                <h2>{{ option.text }}</h2> 
                            </option>
                        </select>
                    </div>
    
                    <!-- Page Count -->
                    <div class="pt-4">
                        <label for="page_select" class="block mb-2 text-sm font-medium text-gray-900 ">Per Page:</label>
                        <select class="w-16 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" id="page_select" :onChange="changePageOptions" v-model="selectedProductsPerPage">
                            <option v-for="option in pageCountOptions" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Reset -->
                <div class="pb-4 mt-4">
                    <div :onClick="resetProductLineSelection" class="w-full text-center border hover:bg-blue-400 cursor-pointer rounded-md hover:text-white">
                        Reset
                    </div>
                </div>
            </Sidebar>
            <MainPage class="px-6">
                <div v-once v-if="data.length > 0" class="pb-4">
                    {{ total }} {{ total == 1 ? 'result' : 'results' }} {{ selectedProductLines.length > 1 ? 'for all Products' : 'for ' + '\'' + selectedProductLines + '\''}}{{ selectedProductScales.length > 1 ? ', at all Model Scales' : ', at ' + currentProductScale + ' scale'}}
                    <div v-if="props.searchTerm">Searching For "{{ props.searchTerm }}"</div>
                </div>
                <div v-else class="pt-4 text-center text-gray-400">
                    No results {{ selectedProductLines.length > 1 ? 'for all Products' : 'for ' + '\'' + selectedProductLines + '\','}}{{ selectedProductScales.length > 1 ? ' and Model Scales' : ' at ' + currentProductScale + ' scale'}}
                    <div v-if="props.searchTerm">Searching For "{{ props.searchTerm }}"</div>
                </div>
                <Pagination 
                    v-if="data.length > 0 && last_page > 1"
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
                    class="py-4">
                </Pagination>

                <!-- Product list -->
                <div v-if="data.length > 0" :class="searching && 'opacity-40'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <Link :href="route('product', product.productCode)" v-for="product in data" class="flex scale-100 p-6 bg-white rounded-lg shadow-2xl shadow-gray-500/20">
                        <div class="min-h-80 flex flex-col justify-between">
                            <div>
                                <img :src="'storage/images/tiny/' + product.image_id + '.jpg'"  :alt="product.productName">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">{{ product.productName }}</h2>
                            </div>

                            <div>
                                <p class="mt-4 item text-gray-500 text-sm leading-relaxed">
                                    {{ product.productVendor }}
                                </p>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    {{ product.productLine }}
                                </p>
                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    {{ product.productScale }}
                                </p>
                                <p class="mt-4">{{ product.created_at }}</p>
                                <p class="mt-4">{{ currencyFormatter(product.MSRP) }}</p>
                            </div>
                        </div>
                    </Link>
                </div>

                <Pagination
                    v-if="data.length > 0 && last_page > 1"
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
                    class="py-4">
                </Pagination>
            </MainPage>
        </SplitLayout>
    </SiteLayout>
</template>