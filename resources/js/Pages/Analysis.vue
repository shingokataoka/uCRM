<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

import Chart from '@/Components/Chart.vue';

import {onMounted, reactive} from 'vue';
import {dayjs} from '@/dayjs-set';
import axios from 'axios';

onMounted(() => {
    form.startDate = dayjs().format('YYYY-MM-DD');
    form.endDate = dayjs().format('YYYY-MM-DD');
});

const props = defineProps({
    period: Object,
});

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay',
});

const data = reactive({});

const getDate = async () => {
    try {
        await axios.get(route('api.analysis'), {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
            },
        }).then(res => {
            data.data = res.data.data;
            data.labels = res.data.labels;
            data.totals = res.data.totals;
            console.log(data.data);
        });
    } catch (e) {
        console.log(e.message);
    }
};
</script>



<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                データ分析
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form @submit.prevent="getDate">
                            開始日<input type="date" name="startDate" v-model="form.startDate">
                            終了日<input type="date" name="endDate" v-model="form.endDate"><br>
                            <button class="mt-4 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                        </form>

                        <Chart :data="data" />

                        <div v-show="data.data" class="lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
                            <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">年月日</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">金額</th>
                                </tr>
                                </thead>
                                <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                <tr v-for="row in data.data" :key="row.date" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ dayjs(row.date).format('YYYY-MM-DD') }}</td>
                                    <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ Number(row.total).toLocaleString() }}円</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
