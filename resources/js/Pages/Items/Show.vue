<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/inertia-vue3';

import FlashMessage from '@/Components/FlashMessage.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
defineProps({
    item: Object,
});

const deleteItem = id => {
    Inertia.delete(route('items.destroy', {id: id}), {
        onBefore: () => confirm('本当に削除しますか？'),
    });
}
</script>

<template>
    <Head title="商品詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <FlashMessage />

                        <section class="text-gray-600 body-font relative" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                        <div class="container px-5 py-8 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="flex flex-wrap -m-2" style="border-color: rgb(106, 117, 138) !important;">
                                <!-- 商品名 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="name" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">商品名</label>
                                    <div id="name" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ item.name }}
                                    </div>
                                </div>
                                </div>
                                <!-- メモ -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="memo" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">メモ</label>
                                    <div id="memo" class="whitespace-pre-wrap w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 min-h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">{{ item.memo }}</div>
                               </div>
                                </div>
                                <!-- 価格 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="price" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">商品価格</label>
                                    <div id="price" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ item.price }}
                                    </div>
                                </div>
                                </div>
                                <!-- 販売中・停止中 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="is_selling" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">ステータス</label>
                                    <div id="is_selling" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        <template v-if="item.is_selling === 1">販売中</template>
                                        <template v-if="item.is_selling === 0">停止中</template>
                                    </div>
                                </div>
                                </div>
                                <!-- 編集するボタン -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                  <Link as="button" :href="route('items.edit', item.id)" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" style="background-color: rgb(7, 7, 44) !important; color: rgb(232, 229, 227) !important; border-color: rgb(84, 93, 109) !important;">編集する</Link>
                                </div>
                                <!-- 削除するボタン -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                  <button @click="deleteItem(item.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg;">削除する</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </section>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
