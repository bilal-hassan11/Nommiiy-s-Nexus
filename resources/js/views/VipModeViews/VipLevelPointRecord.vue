<template>

   <div class="row align-items-center form-header">
  <!-- Left Side: Title and Breadcrumb -->
  <div class="col-lg-3 col-md-12 col-sm-12">
    <h2 class="form-title">VIP Mode</h2>
    <p class="breadcrumb">VIP Mode > <strong>VIP Level Point Record</strong></p>
  </div>

  <!-- Right Side: All buttons in one line -->
  <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
    <button class="btn header-btn border-success text-success me-2 mb-2">Edit VIP Ranking</button>
    <button class="btn header-btn border-secondary-subtle text-black font-600 me-2 mb-2">Edit
      VIP Points</button>

  </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <!-- Row 1 -->
<div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <select v-model="form.currency" class="form-select">
          <option>BDT</option>
          <option>EN-US</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Start Date</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Transaction Reason</label>
        <select v-model="form.transactionReason" class="form-select">
          <option value="All">All</option>
          <option>Loan</option>
          <option>Monthly Renewal</option>
          <option>Credit</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>
      <div class="col-md-6 col-lg-9">
        <div class="row" style="font-size: 12px; font-weight: 500; margin: 10px 1px 10px 4px;">
          Date Range
        </div>
        <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Today')">Today
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Yesterday')">
            Yesterday
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Week')">This
            Week
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Week')">Last
            Week
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Month')">This
            Month
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Month')">Last
            Month
          </button>
        </div>
      </div>

    </div>


    <div class="col-12 d-flex justify-content-end gap-2">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
</template>


<script setup>
import {ref} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";

const form = ref({
  transactionReason: "All",
  currency: "BDT",
  createdAt: "",
  completedAt: "",
  username: "",
  merchant: "MJB",
});

const selectedDateFilter = ref("All");

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
};

const clearForm = () => {
  form.value.transactionReason = "All";
  form.value.currency = "BDT";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.username = "";
  form.value.merchant = "MJB";

  selectedDateFilter.value = "All";
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
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
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
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #a18923;
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

.header-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 26px;
  cursor: pointer;
}
</style>