<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

import Chart from '@/Components/Chart.vue';
import ResultTable from '@/Components/ResultTable.vue';

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
    rParams: [14, 28, 60, 90],
    fParams: [7, 5, 3, 2],
    mParams: [300000, 200000, 100000, 30000],
});

const data = reactive({});

const getDate = async () => {
    try {
        await axios.get(route('api.analysis'), {
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
                rParams: form.rParams,
                fParams: form.fParams,
                mParams: form.mParams,
            },
        }).then(res => {
            data.data = res.data.data;
            if(res.data.labels) { data.labels = res.data.labels; }
            if(res.data.eachCount) { data.eachCount = res.data.eachCount; }
            data.totals = res.data.totals;
            data.type = res.data.type;
            console.log(data);
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
                            <div>
                                <label>
                                    <input type="radio" name="type" v-model="form.type" value="perDay">
                                    日別
                                </label>
                                <label>
                                    <input type="radio" name="type" v-model="form.type" value="perMonth">
                                    月別
                                </label>
                                <label>
                                    <input type="radio" name="type" v-model="form.type" value="perYear">
                                    年別
                                </label>
                                <label>
                                    <input type="radio" name="type" v-model="form.type" value="decile">
                                    デシル分析
                                </label>
                                <label>
                                    <input type="radio" name="type" v-model="form.type" value="rfm">
                                    RFM分析
                                </label>
                            </div>

                            開始日<input type="date" name="startDate" v-model="form.startDate">
                            終了日<input type="date" name="endDate" v-model="form.endDate"><br>

                            <div v-if="form.type === 'rfm'" class="my-8">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ランク</th>
                                            <th>R（○日以内 最終購入日）</th>
                                            <th>F（○回以上 購入回数）</th>
                                            <th>M（○円以上 合計購入金額）</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>5</td>
                                            <td><input type="number" min="0" v-model="form.rParams[0]" ></td>
                                            <td><input type="number" min="0" v-model="form.fParams[0]" ></td>
                                            <td><input type="number" min="0" v-model="form.mParams[0]" ></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td><input type="number" min="0" v-model="form.rParams[1]" ></td>
                                            <td><input type="number" min="0" v-model="form.fParams[1]" ></td>
                                            <td><input type="number" min="0" v-model="form.mParams[1]" ></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><input type="number" min="0" v-model="form.rParams[2]" ></td>
                                            <td><input type="number" min="0" v-model="form.fParams[2]" ></td>
                                            <td><input type="number" min="0" v-model="form.mParams[2]" ></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><input type="number" min="0" v-model="form.rParams[3]" ></td>
                                            <td><input type="number" min="0" v-model="form.fParams[3]" ></td>
                                            <td><input type="number" min="0" v-model="form.mParams[3]" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button class="mt-4 flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                        </form>

                        <Chart :data="data" />
                        <ResultTable :data="data" />

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
