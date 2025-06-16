<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Mission Daily Setting</h2>
      <p class="breadcrumb">Mission Daily Setting > <strong>Period Mission</strong></p>
    </div>

    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
      <button class="btn header-btn btn-outline-success me-2 mb-2">Edit</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row gx-3 gy-3 align-items-end">
      <!-- Merchant Dropdown -->
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>

      <!-- Currency Dropdown -->
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <select v-model="form.currency" class="form-select">
          <option>BDT</option>
          <option>NPR</option>
        </select>
      </div>
    </div>

    <div class="row gx-3 gy-3 align-items-end">
      <div class="col-md-6 col-lg-4">
        <label>Start Date</label>
        <input type="datetime-local" v-model="form.createdAt" class="form-control border-warning" style="cursor: not-allowed">
      </div>
      <div class="col-md-6 col-lg-4">
        <label>End Date</label>
        <input type="datetime-local" v-model="form.completedAt" class="form-control border-warning" style="cursor: not-allowed">
      </div>
      <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        Please be reminded that this date input are GMT+8 standard.
      </p>
      <div class="d-flex align-items-center gap-2">
        <label for="flexSwitchCheck" class="form-label mb-0">
          Period task foreground display
        </label>
        <div class="form-check form-switch m-0">
          <input
              class="form-check-input custom-toggle"
              type="checkbox"
              id="customSwitch"
              v-model="isActive"
              @click="handleClick"
          />
        </div>
      </div>

      <!-- Instructional Text -->
      <div class="info-box mt-4">
        <p class="form-label">
          1. Missions that can be completed within a set period, Time limit, 100 days after the start date.<br/>
          2. After the mission starts, cannot add a new mission, edit the starting time, ending time.<br/>
          3. After deleting all the tasks, you can reset the task time.<br/>
          4. The mission will be automatically closed when the time is up.<br/>
          5. Continuous login, daily login is required, and the daily definition is 00:00 ~ 23:59 GMT+8.<br/>
          6. Up to 30 can be set.
        </p>
      </div>
      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
        <button class="search-btn btn btn-primary text-dark">Search</button>
      </div>
    </div>
  </div>

  <div v-if="isActive" class="form-container mt-2">
    <div class="no-records mt-5 text-center">
      <Files stroke-width="2" size="50"></Files>
      <p class="mt-2 text-muted">No Records</p>
    </div>
  </div>
</template>


<script setup>
import { Files } from "lucide-vue-next";
import { ref } from "vue";
import { useNotificationStore } from '@/stores/notification'

const notification = useNotificationStore()

function handleClick() {
  notification.triggerSuccess()
}

// Format for input[type="datetime-local"]
const toDatetimeLocalString = (date) => {
  const pad = (n) => n.toString().padStart(2, "0");
  return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
};

const getDefaultDates = () => {
  const now = new Date();
  const firstOfMonth = new Date(now.getFullYear(), now.getMonth(), 1, 0, 0, 0);
  const endOfToday = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 0);

  return {
    createdAt: toDatetimeLocalString(firstOfMonth),
    completedAt: toDatetimeLocalString(endOfToday),
  };
};

const form = ref({
  merchant: "MJB",
  currency: "BDT",
  ...getDefaultDates(),
});

const isActive = ref(false);

const clearForm = () => {
  form.value = {
    merchant: "MJB",
    currency: "BDT",
    ...getDefaultDates(),
  };
};
</script>


<style scoped>
.form-header {
  padding-right: 10px;
}

.custom-toggle {
  width: 40px;
  height: 20px;
  box-shadow: none;
}

.form-label {
  font-size: 13px;
  color: gray;
  font-weight: 500;
}

.custom-toggle:checked {
  background-color: #e4c673;
  border-color: #ffc107;

}

.custom-toggle:checked:before {
  background-color: yellow !important;
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

.header-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 26px;
  cursor: pointer;
}
</style>