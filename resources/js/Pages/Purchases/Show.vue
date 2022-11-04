<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, Head} from '@inertiajs/inertia-vue3';

import {onMounted, reactive, ref, computed} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {dayjs} from '@/dayjs-set';

const props = defineProps({
    items: Array,
    order: Object,
});


</script>

<template>
    <Head title="購買履歴 詳細画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購買履歴 詳細画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <section class="text-gray-600 body-font relative" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                        <div class="container px-5 py-8 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="flex flex-wrap -m-2" style="border-color: rgb(106, 117, 138) !important;">
                                <!-- 日付 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="date" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">日付</label>
                                    <div id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ dayjs(props.order.created_at).format('YYYY/MM/DD') }}
                                    </div>
                                </div>
                                </div>
                                <!-- 会員名 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="customer" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">会員名</label>
                                    <div id="date" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ props.order.customer_name }}
                                    </div>
                               </div>
                                </div>



                                <!-- 商品と数量の一覧 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="items" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">購入商品</label>
                                    <div class=" w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
                                        <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                            <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                            <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">商品名</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">金額</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">数量</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">小計</th>
                                            </tr>
                                            </thead>
                                            <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                            <tr v-for="item in items" :key="item.id" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.item_id }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.item_name }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.item_price.toLocaleString() }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.quantity }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.subtotal.toLocaleString() }} 円</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                </div>

                                <!-- 合計 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="" style="border-color: rgb(106, 117, 138) !important;">
                                    合計金額
                                    <div class="w-32 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ Number(props.order.total).toLocaleString() }}円
                                    </div>
                                </div>
                                </div>

                                <!-- ステータス -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="" style="border-color: rgb(106, 117, 138) !important;">
                                    ステータス
                                    <div class="w-32 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ (props.order.status)? '未キャンセル' : 'キャンセル済' }}
                                    </div>
                                </div>
                                </div>
                                <!-- キャンセル日 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="" style="border-color: rgb(106, 117, 138) !important;">
                                    キャンセル日
                                    <div class="w-32 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ (props.order.status)? '　' : dayjs(props.order.updated_at).format('YYYY/MM/DD') }}
                                    </div>
                                </div>
                                </div>

                                <!-- 編集するボタン -->
                                <div v-if="props.order.status" class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <Link as="button" :href="route('purchases.edit', {id: props.order.id})" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" style="background-color: rgb(7, 7, 44) !important; color: rgb(232, 229, 227) !important; border-color: rgb(84, 93, 109) !important;">編集する</Link>
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
