<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-12 col-md-12 col-sm-6">
      <h2 class="form-title">Rebate</h2>
      <p class="breadcrumb">Rebate > <strong>Rebate Release</strong></p>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row gx-3 gy-3">

      <div class="col-md-6 col-lg-3">
        <label>Date From</label>
        <input type="date" v-model="form1.createdAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Date To</label>
        <input type="date" v-model="form1.completedAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <select v-model="form1.currency" class="form-select">
          <option value="" disabled selected>Please Select Currency</option>
          <option value="All">All</option>
          <option>BDT</option>
          <option>NPR</option>
        </select>
      </div>

      <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        Please be reminded that this date input are GMT+8 standard. <br/>
        Generate Rebate is only available after 1am (GMT+8)
      </p>

      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button class="search-btn btn btn-primary text-dark">Generate Rebate</button>
      </div>

    </div>
  </div>


  <div class="form-container mt-3">
    <div class="row gx-3 gy-3">

      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form2.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
          <option>Unlocked</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Date From</label>
        <input type="date" v-model="form2.createdAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Date To</label>
        <input type="date" v-model="form2.completedAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Affiliate</label>
        <input type="text" v-model="form2.affiliate" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form2.username" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Rebate</label>
        <span style="font-size: 9px; padding-left: 4px;">>=</span>
        <input type="text" v-model="form2.rebate" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Provider</label>
        <select v-model="form2.provider" class="form-select">
          <option value="All">All</option>
          <option>Merchant</option>
          <option>Bank</option>
          <option>Agent</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <Multiselect
            v-model="form2.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Pick currencies"
        />
      </div>

      <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        Please be reminded that this report is generated based on GMT+8 standard.
      </p>

      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
        <button class="search-btn btn btn-primary text-dark">Search</button>
      </div>
    </div>
  </div>

</template>


<script setup>
import { ref } from "vue";
import Multiselect from "vue-multiselect";

const getDefaultDates = () => {
  const today = new Date();
  const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  };

  return {
    firstDay: formatDate(firstDay),
    today: formatDate(today),
  };
};

const { firstDay, today } = getDefaultDates();

const currencies = ref(["BDT", "NPR"]);

const form1 = ref({
  currency: "",
  createdAt: firstDay,
  completedAt: today,
});

const form2 = ref({
  status: "All",
  createdAt: firstDay,
  completedAt: today,
  affiliate: "",
  username: "",
  rebate: "",
  provider: "All",
  currency: ["BDT", "NPR"],
});

const clearForm = () => {
  const { firstDay, today } = getDefaultDates();

  form2.value.currency = ["BDT", "NPR"];
  form2.value.status = "All";
  form2.value.affiliate = "";
  form2.value.activityName = "";
  form2.value.username = "";
  form2.value.rebate = "";
  form2.value.provider = "All";
  form2.value.createdAt = firstDay;
  form2.value.completedAt = today;

  form1.value.currency = "";
  form1.value.createdAt = firstDay;
  form1.value.completedAt = today;
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