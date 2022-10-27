<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

import FlashMessage from '@/Components/FlashMessage.vue';
import Pagination from '@/Components/Pagination.vue';
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';

defineProps({
    customers: Object,
});

const search = ref('');

const searchCustomers = () => {
    Inertia.get(route('customers.index'), {
        search: search.value,
    })
}

</script>

<template>
    <Head title="顧客一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客一覧
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <FlashMessage />

                        <section class="text-gray-600 body-font" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                        <div class="container px-5 py-24 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="flex pl-4 mb-4 lg:w-2/3 w-full mx-auto">
                               <div>
                                    <input type="text" name="search" placeholder="カナ か 電話番号で前方" v-model="search">
                                    <button @click="searchCustomers" class="bg-blue-500 rext-white">検索</button>
                                </div>
                                <Link as="button" :href="route('customers.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">顧客登録</Link>
                            </div>

                            <div class="lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">ID</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">名前</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">カナ</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">電話番号</th>
                                </tr>
                                </thead>
                                <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr v-for="customer in customers.data" :key="customer.id" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                        <Link :href="route('customers.show', customer)" class="text-blue-300">{{ customer.id }}</Link>
                                    </td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.name }}</td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.kana }}</td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.tel }}</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </section>

                        <Pagination :links="customers.links" class="mt-6 text-center"></Pagination>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
