<script setup>

const props = defineProps({
    data: Object,
});

</script>
<template>

<div v-if="data.type === 'perDay' || data.type === 'perMonth' || data.type === 'perYear'" class="lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
    <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
        <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">年月日</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">金額</th>
            </tr>
        </thead>
        <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr v-for="row in data.data" :key="row.date" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ row.date }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ Number(row.total).toLocaleString() }}円</td>
            </tr>
        </tbody>
    </table>
</div>

<div v-if="data.type === 'decile'" class="lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">
    <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
        <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">デシル</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">平均</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">合計金額</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">構成比</th>
            </tr>
        </thead>
        <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr v-for="row in data.data" :key="row.date" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ row.decile }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ Number(row.average).toLocaleString() }} 円</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ Number(row.totalPerGroup).toLocaleString() }} 円</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ row.totalRatio }} %</td>
            </tr>
        </tbody>
    </table>
</div>

<div v-if="data.type === 'rfm'" class="text-center lg:w-2/3 w-full mx-auto overflow-auto" style="border-color: rgb(106, 117, 138) !important;">

    <h2 class="my-8">RFM分析結果</h2>

    <div>合計人数：{{ data.totals }}</div>

    <h3 class="my-8">RFMランク毎の人数</h3>
    <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
        <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">ランク</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">R</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">F</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">M</th>
            </tr>
        </thead>
        <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr v-for="rfm in data.eachCount" :key="rfm.rank" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rfm.rank }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rfm.r }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rfm.f }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rfm.m }}</td>
            </tr>
        </tbody>
    </table>

    <h3 class="my-8">RとFの集計表</h3>
    <table class="table-auto w-full text-left whitespace-no-wrap" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
        <thead style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, rRan139) !important;">rRank</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">f_5</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">f_4</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">f_3</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">f_2</th>
                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100" style="background-color: rgb(25, 27, 33) !important; color: rgb(174, 189, 220) !important; border-color: rgb(107, 118, 139) !important;">f_1</th>
            </tr>
        </thead>
        <tbody style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
            <tr v-for="rf in data.data" :key="rf.rRank" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.rRank }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.f_5 }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.f_4 }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.f_3 }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.f_2 }}</td>
                <td class="px-4 py-3" style="color: rgb(197, 203, 211) !important; border-color: rgb(106, 117, 138) !important;">{{ rf.f_1 }}</td>
            </tr>
        </tbody>
    </table>

</div>




</template>

