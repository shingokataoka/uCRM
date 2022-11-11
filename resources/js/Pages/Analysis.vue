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
            data.type = res.data.type;
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
                            </label><br>

                            開始日<input type="date" name="startDate" v-model="form.startDate">
                            終了日<input type="date" name="endDate" v-model="form.endDate"><br>
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
