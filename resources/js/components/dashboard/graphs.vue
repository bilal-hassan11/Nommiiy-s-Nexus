<script setup>
import DashboardCharts from "@/components/dashboard/DashboardCharts.vue";
</script>

<template>
  <div class="container-fluid graphs-container">
    <!-- Buttons Row -->
    <div class="row justify-content-start gap-2 py-2">
      <div class="col-4 col-sm-auto">
        <button class="btn btn-warning text-white btn-sm w-100">Today</button>
      </div>
      <div class="col-4 col-sm-auto">
        <button class="btn btn-light text-secondary btn-sm w-100">Recent 7 days</button>
      </div>
      <div class="col-4 col-sm-auto">
        <button class="btn btn-light text-secondary btn-sm w-100">Recent 30 days</button>
      </div>
    </div>

    <!-- DashboardCharts Row -->
    <div class="row">
      <DashboardCharts class="col-12" />
    </div>
  </div>
</template>

<style scoped>
.graphs-container {
  padding: 15px;
}

.btn-sm {
  font-size: 12px;
  font-weight: normal;
  padding: 3px 18px;
}

.btn-warning {
  background: #f4c938;
}

.btn-warning:hover {
  background: #d8ac13;
}

.btn-light:hover {
  background: #e1d9d9;
}

.charts-container {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  padding-left: 1px;
  padding-bottom: 20px;
}

/* Mobile Responsiveness */
@media (max-width: 767.98px) {
  .graphs-container {
    padding: 10px;
  }

  .btn-sm {
    width: 100%;
    margin-bottom: 5px;
  }

  .row.justify-content-start {
    gap: 5px;
  }
}
</style>
