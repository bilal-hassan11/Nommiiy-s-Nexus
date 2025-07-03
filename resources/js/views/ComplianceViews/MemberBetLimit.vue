<template>
  <EventLogModal v-model="showEventLogModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Compliance</h2>
      <p class="breadcrumb">Compliance > <strong>Member Bet Limit</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-4 col-sm-12 d-flex justify-content-end gap-2">
      <button class="btn tag-btn d-flex align-items-center justify-content-center"
              @click="showEventLogModal = true">
        Event Log
      </button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label class="form-label">Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label class="form-label">Currency</label>
        <select v-model="form.currency" class="form-select">
          <option value="All">All</option>
          <option>BDT</option>
          <option>NPR</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label class="form-label">Provider</label>
        <select v-model="form.provider" class="form-select">
          <option value="All">All</option>
          <option>3SING</option>
          <option>4SING</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" v-model="form.username"/>
      </div>
    </div>

    <div class="col-lg-12 d-flex justify-content-end gap-2 mt-4">
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
</template>


<script setup>
import {ref} from "vue";
import EventLogModal from "@/views/ComplianceViews/modals/EventLogModal.vue";

const showEventLogModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  merchant: "MJB",
  currency: "BDT",
  provider: "3SING",
  username: "",
});
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

</style>