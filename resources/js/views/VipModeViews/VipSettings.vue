<template>
  <div class="row align-items-center form-header">
  <!-- Left Side: Title and Breadcrumb -->
  <div class="col-lg-3 col-md-12 col-sm-12">
    <h2 class="form-title">VIP Mode</h2>
    <p class="breadcrumb">VIP Mode > <strong>Vip Settings</strong></p>
  </div>

  <!-- Right Side: All buttons in one line -->
  <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
    <button class="btn header-btn border-success text-success me-2 mb-2">Season Day</button>
    <button class="btn header-btn border-success text-success me-2 mb-2">Accumulate Points Condition</button>
    <button class="btn header-btn border-secondary-subtle text-black font-600 me-2 mb-2">Vip Setting History</button>
    <button class="btn header-btn bg-warning me-2 mb-2 font-600">Holiday Date Declaration Settings</button>
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
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <select v-model="form.currency" class="form-select">
          <option>BDT</option>
          <option>NPR</option>
        </select>
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
  merchant: "MJB",
  currency: "BDT",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.currency = "BDT";
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

.header-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 26px;
  cursor: pointer;
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

</style>