<script setup>
import axios from 'axios';
import {ref, reactive, onMounted} from 'vue';
import {MicroModal} from '@/micromodal.js';

const search = ref('');
const customers = reactive({});
const emits = defineEmits(['update:customerId']);

const searchCustomers = async () => {
    try{
        await axios.get(`/api/search-customers?search=${search.value}`)
        .then(res => {
            customers.data = res.data.data;
            customers.links = res.data.links;
            MicroModal.show('modal-1');
        });
    } catch(e) {
        console.log(e);
    }
};

const setCustomer = customer => {
    search.value = customer.kana;
    emits('update:customerId', customer.id);
    MicroModal.close('modal-1');
};

</script>
<template>
<div class="z-50 modal micromodal-slide" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="modal__title" id="modal-1-title">
            顧客検索
          </h2>
          <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="modal-1-content">
            <div class=" w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
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
                            <button type="button" @click="setCustomer(customer)" class="bg-blue-500">{{ customer.id }}</button>
                        </td>
                        <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.name }}</td>
                        <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.kana }}</td>
                        <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ customer.tel }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <footer class="modal__footer">
          <button type="button" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">閉じる</button>
        </footer>
      </div>
    </div>
  </div>

  <input type="text" name="customer" v-model="search" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
  <button type="button" @click="searchCustomers" class="mt-2 flex mx-auto text-white bg-teal-500 border-0 py-2 px-8 focus:outline-none hover:bg-teal-600 rounded text-lg">検索する</button>
</template>

