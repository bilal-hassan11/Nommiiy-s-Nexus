<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Mission Daily Setting</h2>
      <p class="breadcrumb">Mission Daily Setting > <strong>Mission Rewards History</strong></p>
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
          <option>NPR</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Start Time</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>End Time</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Member Group</label>
        <select v-model="form.memberGroup" class="form-select">
          <option>All</option>
          <option>Member Group 1</option>
          <option>Member Group 2</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Mission Status</label>
        <select v-model="form.missionStatus" class="form-select">
          <option value="All">All</option>
          <option>Mission Complete</option>
          <option>Mission Incomplete</option>
          <option>Mission Pending</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Diary Category</label>
        <select v-model="form.dairyCategory" class="form-select">
          <option value="All">All</option>
          <option>Category 1</option>
          <option>Category 2</option>
          <option>Category 3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Mission Name</label>
        <select v-model="form.missionName" class="form-select">
          <option value="All">All</option>
          <option>XHJ</option>
          <option>NARX</option>
          <option>REV</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Reward Type</label>
        <select v-model="form.rewardType" class="form-select">
          <option value="All">All</option>
          <option>Type 1</option>
          <option>Type 2</option>
          <option>Type 3</option>
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
  username: "",
  currency: "BDT",
  createdAt: "",
  completedAt: "",
  missionStatus: "Mission Complete",
  merchant: "MJB",
  memberGroup: "All",
  dairyCategory: "All",
  missionName: "All",
  rewardType: "All",
});

const clearForm = () => {
  form.value.username = "";
  form.value.currency = "BDT";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.missionStatus = "Mission Complete";
  form.value.merchant = "MJB";
  form.value.memberGroup = "All";
  form.value.dairyCategory = "All";
  form.value.missionName = "All";
  form.value.rewardType = "All";
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