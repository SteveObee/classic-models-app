<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SplitLayout from '@/Layouts/SplitLayout.vue';
import MainPage from '@/Components/MainPage.vue';
import Sidebar from '@/Components/Sidebar.vue';
import Payment from '@/Components/Payment.vue';
import Pagination from '@/Components/Pagination.vue';
import { useUrlBuilder } from '@/Composables/urlBuilder';
import { currencyFormatter } from '@/Helpers/currencyFormatter';


const props = defineProps({
    model: Object
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
} = props.model.payments

const url = (page) => {
    const builtUrl = useUrlBuilder(page, {
        // per_page: selectedPaymentsPerPage.value,
        // sort: selectedSort.value,
        // status: selectedStatus.value
        }
    )

    return builtUrl
}

</script>

<template>
    <AppLayout title="Payments">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payments
            </h2>
        </template>

        <SplitLayout>                    
            <!-- <Sidebar /> -->
            <MainPage class="px-9">
                <div class="my-4">
                    <h2 class="font-semibold text-xl">
                        Total paid to date: {{ currencyFormatter(model.total_paid) }}
                    </h2>
                    <h2 class="font-semibold text-xl">
                        Outstanding balance: {{ currencyFormatter(model.oustanding_balance) }}
                    </h2>
                </div>
                <Pagination
                    v-if="model.payments.data.length > 0"
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
                <Payment v-for="payment in model.payments.data" :payment="payment" />
            </MainPage>
        </SplitLayout>
    </AppLayout >
</template>
