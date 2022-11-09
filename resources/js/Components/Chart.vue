<script setup>
import { Chart, registerables } from "chart.js";
import { reactive, computed } from "vue";
import { BarChart } from "vue-chart-3";
Chart.register(...registerables);

const props = defineProps({
    data: Object,
});

const labels = computed( () => props.data.labels );
const totals = computed( () => props.data.totals );

const barData = reactive({
      labels: labels,
      datasets: [
        {
          label: "売上",
          data: totals,
          fill: false,
          backgroundColor: "rgb(75, 192, 192)",
          tension: 0.1,
        },
      ],
    });

</script>
<template>
    <div v-show="labels">
      <barChart :chartData="barData"  class="h-60" />
    </div>
  </template>
