<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head} from '@inertiajs/inertia-vue3';

import InputError from '@/Components/InputError.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import {reactive} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Core as YubinBangoCore} from 'yubinbango-core2';

const props = defineProps({
    errors: Object,
});

const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    memo: null,
});

const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
        form.address = value.region + value.locality + value.street;
    });
};

const storeCustomer = () => {
    Inertia.post(route('customers.store'), form);
};


</script>

<template>
    <Head title="顧客登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                顧客登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form @submit.prevent="storeCustomer">
                        <section class="text-gray-600 body-font relative" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                        <div class="container px-5 py-8 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <div class="flex flex-wrap -m-2" style="border-color: rgb(106, 117, 138) !important;">
                                <!-- 顧客名 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="name" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">顧客名</label>
                                    <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.name" />
                                </div>
                                </div>
                                <!-- カナ -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="kana" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">顧客名カナ</label>
                                    <input type="text" id="kana" name="kana" v-model="form.kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.kana" />
                                </div>
                                </div>
                                <!-- 電話番号 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="tel" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">電話番号</label>
                                    <input type="number" id="tel" name="tel" v-model="form.tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.tel" />
                                </div>
                                </div>
                                <!-- メールアドレス -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="email" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">メールアドレス</label>
                                    <input type="email" id="email" name="email" v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.email" />
                                </div>
                                </div>
                                <!-- 郵便番号 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="postcode" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">郵便番号</label>
                                    <input type="number" id="postcode" name="postcode" @change="fetchAddress" v-model="form.postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.postcode" />
                                </div>
                                </div>
                                <!-- 住所 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="address" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">住所</label>
                                    <input type="text" id="address" name="address" v-model="form.address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.address" />
                                </div>
                                </div>
                                <!-- 誕生日 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="birthday" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">誕生日</label>
                                    <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;">
                                    <InputError class="mt-4" :message="errors.birthday" />
                                </div>
                                </div>
                                <!-- 性別 -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                    <label class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">ステータス</label>
                                    <div class="w-full flex justify-around">
                                        <label><input type="radio" name="gender" v-model="form.gender" value="0">男性</label>
                                        <label><input type="radio" name="gender" v-model="form.gender" value="1">女性</label>
                                        <label><input type="radio" name="gender" v-model="form.gender" value="2">その他</label>
                                    </div>
                                    <InputError class="mt-4" :message="errors.gender" />
                                </div>
                                <!-- メモ -->
                                <div class="p-2 w-full" style="border-color: rgb(106, 117, 138) !important;">
                                <div class="relative" style="border-color: rgb(106, 117, 138) !important;">
                                    <label for="memo" class="leading-7 text-sm text-gray-600" style="border-color: rgb(106, 117, 138) !important; color: rgb(197, 203, 211) !important;">メモ</label>
                                    <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" style="transition-property: -background-color, -border-color, -color, fill, stroke !important; background-color: rgba(24, 27, 32, 0.5) !important; --placeholder-color:rgba(232, 229, 227, 0.6) !important; color: rgb(186, 194, 208) !important; border-color: rgb(103, 115, 132) !important;"></textarea>
                                    <InputError class="mt-4" :message="errors.memo" />
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
