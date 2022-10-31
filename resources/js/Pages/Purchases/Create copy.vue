<script setup>
import {onMounted, reactive, ref, computed} from 'vue';
import {getToday} from '@/common';
import {Inertia} from '@inertiajs/inertia';

const props = defineProps({
    customers: Array,
    items: Array,
});

const form = reactive({
    date: null,
    customer_id: (props.customers[0])? props.customers[0].id : null,
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

</script>
<template>
    <form @submit.prevent="storePurchase">
        日付<br>
        <input type="date" name="date" v-model="form.date"><br>

        会員名<br>
        <select name="customer" v-model="form.customer_id">
            <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.id }}：{{ customer.name }}</option>
        </select><br>

        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>商品名</th>
                    <th>金額</th>
                    <th>数量</th>
                    <th>小計</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in itemList" :key="item.id">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.price.toLocaleString() }} 円</td>
                    <td>
                        <select name="quantity" v-model="item.quantity">
                            <option v-for="q in quantity" :key="q" :value="q">{{ q }}</option>
                        </select>
                    </td>
                    <td>{{ (item.price * item.quantity).toLocaleString() }} 円</td>
                </tr>
            </tbody>
        </table>
        合計 {{ totalPrice.toLocaleString() }} 円<br><br>

        <button class="bg-blue-500 text-white rounded-md p-2 hover:bg-blue-800">登録する</button>
    </form>
</template>
