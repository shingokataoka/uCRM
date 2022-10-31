<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/inertia-vue3';

import InputError from '@/Components/InputError.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import MicroModal from '@/Components/MicroModal.vue';

import {onMounted, reactive, ref, computed} from 'vue';
import {getToday} from '@/common';
import {Inertia} from '@inertiajs/inertia';

const props = defineProps({
    errors: Object,
    items: Array,
});

const form = reactive({
    date: null,
    customer_id: null,
    status: true,
    items: [],
});
const itemList = ref([]);
const quantity = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

onMounted(() => {
    form.date = getToday();
    props.items.forEach(item => {
        itemList.value.push({
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: 0,
        });
    });
});

const totalPrice = computed(() => {
    let total = 0;
    itemList.value.forEach(item => {
        total += item.price * item.quantity;
    });
    return total;
});

const storePurchase = () => {
    form.items = [];
    itemList.value.forEach(item => {
        if (item.quantity > 0) {
            form.items.push({
                id: item.id,
                quantity: item.quantity,
            });
        }
    });
    Inertia.post(route('purchases.store'), form);
}

const setCustomerId = id => {
    form.customer_id = id;
}

</script>

<template>
    <Head title="購入画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form @submit.prevent="storePurchase">
                        <section class="text-gray-600 body-font relative" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                        <div class="container px-5 py-8 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="flex flex-wrap -m-2" style="border-color: rgb(106, 117, 138) !important;">
                                <!-- 日付 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="date" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">日付</label>
                                    <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.date" />
                                </div>
                                </div>
                                <!-- 会員名 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="customer" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">会員名</label>
                                    <MicroModal @update:customerId="setCustomerId" />
                                    <InputError class="mt-4" :message="errors.customer" />
                                </div>
                                </div>



                                <!-- 商品と数量の一覧 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="items" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">商品価格</label>
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
                                            <tr v-for="item in itemList" :key="item.id" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.id }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.name }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ item.price }}</td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                                    <select name="quantity" v-model="item.quantity">
                                                        <option v-for="q in quantity" :key="q" :value="q">{{ q }}</option>
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ (item.price * item.quantity).toLocaleString() }} 円</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                </div>

                                <!-- 合計 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    合計金額
                                    <div class="w-32 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                        {{ totalPrice.toLocaleString() }}円
                                    </div>
                                    <InputError class="mt-4" :message="errors.date" />
                                </div>
                                </div>

                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg" style="background-color: rgb(7, 7, 44) !important; color: rgb(232, 229, 227) !important; border-color: rgb(84, 93, 109) !important;">登録する</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </section>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
