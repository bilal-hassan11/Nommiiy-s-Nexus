<template>
  <div class="d-flex justify-content-between form-header">
    <div class="col-lg-8">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Member Fund</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <!-- Row 1 -->
      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input class="form-control" type="text" v-model="form.username"/>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Start Date</label>
        <input class="form-control" type="date" v-model="form.startDate"/>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input class="form-control" type="date" v-model="form.endDate"/>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <Multiselect
            v-model="form.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Pick currencies"
        />
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Source</label>
        <select v-model="form.source" class="form-select">
          <option value="All">All</option>
          <option value="Admin">Admin</option>
          <option value="System">System</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>
    </div>
    <div class="row" style="font-size: 12px; font-weight: 500; margin: 10px 1px 10px 4px;">
      Date Range
    </div>
    <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('Today')">Today</button>
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('Yesterday')">Yesterday
      </button>
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('This Week')">This Week
      </button>
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('Last Week')">Last Week
      </button>
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('This Month')">This Month
      </button>
      <button class="col-lg-2 recent btn btn-light text-center" @click="filterByDateRange('Last Month')">Last Month
      </button>
    </div>
    <div class="button-group">
      <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
      <button class="btn search-btn">Search</button>
    </div>

  </div>
</template>

<script setup>
import {ref} from "vue";
import Multiselect from "vue-multiselect";

const currencies = ref(["BDT", "NPR"]);
const selectedDateFilter = ref("All");

const form = ref({
  username: "",
  startDate: "2025-03-1",
  endDate: "2025-03-14",
  currency: ["BDT", "NPR"],
  source: "All",
  merchant: "MJB",
  timeZone: "GMT+0500",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.username = "";
  form.value.source = "All";
  form.value.timeZone = "GMT+0500";
  form.value.currency= ["BDT", "NPR"];
  form.value.startDate= "2025-03-1";
  form.value.endDate= "2025-03-14";
};

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
};
</script>

<style scoped>
.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select {
  font-size: 13px;
  padding: 3px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #d6b402;
}

.recent {
  width: 105px;
  height: 25px;
  font-size: 11px;
  font-weight: normal;
  background: white;
  padding: 3px;
  color: #807d7d;
  border: 1px solid #b1adad;
}

.recent:hover {
  border: #f4c938 1px solid;
  color: #f4c938;
  background: #faeecd;
}

</style>
