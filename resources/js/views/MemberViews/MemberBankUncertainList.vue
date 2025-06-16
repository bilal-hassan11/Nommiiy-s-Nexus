<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Member Bank Uncertain List</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <!-- Row 1 -->
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option>MJB</option>
          <option>MJB2</option>
          <option>All</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Full Name</label>
        <input type="text" v-model="form.fullName" class="form-control">
      </div>


      <div class="col-md-6 col-lg-3">
        <label>Actual Bank Name</label>
        <input type="text" v-model="form.actualBankName" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Action Required</label>
        <select v-model="form.actionRequired" class="form-select">
          <option>All</option>
          <option>Some</option>
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
  username: "",
  fullName:"",
  actualBankName: "",
  actionRequired: "All"
});

const clearForm = () => {
  form.value.username = "";
  form.value.merchant = "MJB";
  form.value.fullName = "";
  form.value.actualBankName = "";
  form.value.actionRequired = "All";
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
</style>
