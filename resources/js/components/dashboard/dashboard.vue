<script setup>
import Header from '@/components/dashboard/header.vue';
import Statistics from '@/components/dashboard/statistics.vue';
import Graphs from '@/components/dashboard/graphs.vue';
</script>

<template>
  <div class="dashboard-wrapper">
    <div class="row">
      <Header/>
    </div>
    <div class="row">
      <Statistics/>
    </div>
    <div class="row">
      <Graphs/>
    </div>
  </div>
</template>

<style scoped>
.dashboard-wrapper {
  min-height: 100%;
}
</style>
