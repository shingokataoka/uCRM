<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

import FlashMessage from '@/Components/FlashMessage.vue';

defineProps({
    items: Array,
});

</script>

<template>
    <Head title="商品管理" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品管理
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
                            <Link as="button" :href="route('items.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">商品登録</Link>
                            </div>

                            <div class="lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">ID</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">商品名</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">価格</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">ステータス</th>
                                </tr>
                                </thead>
                                <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr v-for="item in items" :key="item.id" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                        <Link :href="route('items.show', item)" class="text-blue-300">{{ item.id }}</Link>
                                    </td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.name }}</td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.price }}</td>
                                    <td v-if="item.is_selling === 1" class="px-4 py-3 text-lg text-gray-900" style="color: rgb(184, 197, 224) !important; border-color: rgb(106, 117, 138) !important;">販売中</td>
                                    <td v-else class="px-4 py-3 text-lg text-gray-900" style="color: rgb(184, 197, 224) !important; border-color: rgb(106, 117, 138) !important;">停止中</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </section>



                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
