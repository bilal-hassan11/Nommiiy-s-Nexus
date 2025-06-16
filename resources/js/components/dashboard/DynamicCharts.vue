<script setup>
import { defineProps, computed } from "vue";
import { Bar, Line } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale
);

const props = defineProps({
  chartData: Object, // Data for the chart
  chartTitle: String, // Top heading/title
  yAxisLabel: String, // Y-Axis label
  xAxisLabel: String, // X-Axis label
  chartType: String, // "bar" (default), "horizontal-bar", or "line"
  rotateXLabels: Boolean,
});

const chartOptions = computed(() => ({
  responsive: true,
  maintainAspectRatio: false,
  indexAxis: props.chartType === "horizontal-bar" ? "y" : "x",
  plugins: {
    title: {
      display: true,
      text: props.chartTitle || "Default Title",
      font: {size: 11, weight: "bold"},
      color: "black",
      align: "start",
      padding: {top: 10, bottom: 10},
    },
  },
  scales: {
    y: {
      title: {display: true, text: props.yAxisLabel || "Y-Axis"},
      ticks: {
        callback: (value) => (value >= 1000 ? (value / 1000).toFixed(1) + "K" : value),
      },
    },
    x: {
      title: {display: true, text: props.xAxisLabel || ""},
      ticks: {
        maxRotation: props.rotateXLabels ? 45 : 0,
        minRotation: props.rotateXLabels ? 45 : 0,
        autoSkip: false,
        font: {size: 9},
        callback: function (value) {
          return this.getLabelForValue(value);
        },
      },
    },
  },
}));
</script>

<template>
  <div class="chart-container">
    <Bar v-if="chartType === 'bar' || chartType === 'horizontal-bar'" :data="chartData" :options="chartOptions"/>
    <Line v-else-if="chartType === 'line'" :data="chartData" :options="chartOptions"/>
  </div>
</template>

<style scoped>
.chart-container {
  width: 32%;
  height: 250px;
  background: white;
  padding: 8px;
  display: flex;
  justify-content: flex-start;
  align-content: start;
  border-radius: 3px;
}
</style>
