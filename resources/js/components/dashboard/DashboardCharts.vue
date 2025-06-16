<script setup>
import DynamicChart from "@/components/dashboard/DynamicCharts.vue";

const charts = [
  {
    chartTitle: "Statistics",
    xAxisLabel: "",
    yAxisLabel: "Count",
    chartType: "bar",
    chartData: {
      labels: ["Signup", "Deposit", "Withdrawal", "Bet", "First Deposit"],
      datasets: [
        {
          label: "Statistics",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [58, 145, 50, 148, 20],
        },
      ],
    },
  },
  {
    chartTitle: "Financial",
    xAxisLabel: "",
    yAxisLabel: "Amount",
    chartType: "bar",
    chartData: {
      labels: ["Deposit", "Withdrawal", "Differential"],
      datasets: [
        {
          label: "Financial",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [90000, 149000, -60000],
        },
      ],
    },
  },
  {
    chartTitle: "Devices",
    xAxisLabel: "",
    yAxisLabel: "Count",
    chartType: "bar",
    chartData: {
      labels: ["IOS", "Android", "Desktop", "Others"],
      datasets: [
        {
          label: "Devices",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [20.00, 698.21, 20.00, 0.00],
        },
      ],
    },
  },
  {
    chartTitle: "Platform",
    xAxisLabel: "",
    yAxisLabel: "Amount",
    chartType: "bar",
    chartData: {
      labels: ["Total Valid Bets", "Win/Loss"],
      datasets: [
        {
          label: "Platform",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [800000, -6.091000],
        },
      ],
    },
  },
  {
    chartTitle: "Top 5 (Based on Players)",
    xAxisLabel: "Provider",
    yAxisLabel: "Statistics",
    chartType: "bar",
    chartData: {
      labels: ["JDBSLOT", "DREAMEXCH", "JILI", "EVO", "KM"],
      datasets: [
        {
          label: "Top 5",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [44654, 42500, 39602, 33660, 27622],
        },
      ],
    },
  },
  {
    chartTitle: "Top 10 (Based on Games)",
    xAxisLabel: "Game",
    yAxisLabel: "Amount",
    chartType: "bar",
    chartData: {
      labels: ["Super Ace", "Aviator", "Money Coming", "Fortune Gems", "Boxing King", "Fortune Gems2",
        "7 Up 7 Down", "Crazy Balls", "Money Coming Expand Bets", "Bac Bo"],
      datasets: [
        {
          label: "Top 10",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [91602, 63845, 44688, 40914, 36184, 35743, 33203, 25810, 20234, 18000],
        },
      ],
    },
  },
  {
    chartTitle: "Deposit Ranking",
    xAxisLabel: "Amount",
    yAxisLabel: "Statistics",
    chartType: "bar",
    chartData: {
      labels: [0.00, 0.10, 0.20, 0.30, 0.40, 0.50, 0.60, 0.70, 0.80, 0.90],
      datasets: [
        {
          label: "",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00],
        },
      ],
    },
  },
  {
    chartTitle: "Withdrawal Ranking",
    xAxisLabel: "Amount",
    yAxisLabel: "Statistics",
    chartType: "horizontal-bar",
    chartData: {
      labels: ["Arip1234", "Aviator", "Money Coming", "Fortune Gems", "Boxing King", "Fortune Gems2",
        "7 Up 7 Down", "Crazy Balls", "Money Coming Expand Bets", "Bac Bo"],
      datasets: [
        {
          label: "Top 10",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [91602, 63845, 44688, 40914, 36184, 35743, 33203, 25810, 20234, 18000],
        },
      ],
    },
  },
  {
    chartTitle: "",
    xAxisLabel: "Amount",
    yAxisLabel: "Statistics",
    chartType: "line",
    chartData: {
      labels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23],
      datasets: [
        {
          label: "Top 10",
          backgroundColor: "rgba(75, 0, 130, 0.3)",
          borderColor: "rgba(75, 0, 130, 1)",
          borderWidth: 1,
          data: [11602, 13845, 14688, 10914, 16184, 15743, 13203, 15810, 10234, 18001, 11602, 13845, 14688,
            10914, 16184, 15743, 13203, 15810, 10234, 18001, 14688, 10914, 16184],
        },
      ],
    },
  },
];
</script>

<template>
  <div class="charts-container">
    <DynamicChart
      v-for="(chart, index) in charts"
      :key="index"
      :chartTitle="chart.chartTitle"
      :xAxisLabel="chart.xAxisLabel"
      :yAxisLabel="chart.yAxisLabel"
      :chartData="chart.chartData"
      :chartType="chart.chartType"
      :rotateXLabels="index === 5"
    />
  </div>
</template>

<style scoped>
.charts-container {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  padding: 10px;
}

/* Mobile Responsiveness */
@media (max-width: 767.98px) {
  .charts-container {
    flex-direction: column;
    gap: 10px;
    padding: 5px;
  }

  .chart-container {
    width: 100% !important;
    height: auto !important;
  }

  .chart-title {
    font-size: 14px !important;
  }

  .axis-label {
    font-size: 12px !important;
  }

  .chart-legend {
    font-size: 10px !important;
  }
}
</style>

