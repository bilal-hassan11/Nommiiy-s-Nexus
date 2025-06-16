<template>
  <div class="row align-items-center form-header">
    <!-- Left Side: Title and Breadcrumb -->
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">VIP Mode</h2>
      <p class="breadcrumb">VIP Mode > <strong>Vip Banner Settings</strong></p>
    </div>

    <!-- Right Side: All buttons in one line -->
    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
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
        <label>Language</label>
        <select v-model="form.language" class="form-select">
          <option>All</option>
          <option>EN-UK</option>
          <option>EN-US</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option>All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
          <option>Locked</option>
          <option>Unlocked</option>
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
import {CirclePlus} from "lucide-vue-next";

const form = ref({
  merchant: "MJB",
  language: "All",
  status: "All",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.language = "All";
  form.value.status = "All";
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>