<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-12 col-md-12 col-sm-6">
      <h2 class="form-title">System Message</h2>
      <p class="breadcrumb">System Message > <strong>System Notification</strong></p>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row top-container m-3 p-4">
      <h4 class="container-title">Security Enforcement for IP Whitelisting</h4>

      <div style="margin: 3px; font-size: 12px; font-weight: 500;">
        <p class="container-sub-title text-muted">Date:</p>
        <div style="background: #fff5f4">
          <p class="p-2" style="font-size: 11px; font-weight: 500;">
            Dear merchants, for security concern, we have enforced the security checking for IP Whitelisting.
            From now on, you can only access the BackOffice using Whitelisted Fixed IP.
            Please contact support should you have any problem. Thank you.</p>
        </div>
      </div>
    </div>
  </div>


  <div class="form-container mt-3">
    <div class="row gx-3 gy-3">

      <div class="col-md-6 col-lg-3">
        <label>Provider</label>
        <select v-model="form.provider" class="form-select">
          <option value="All">All</option>
          <option>Provider 1</option>
          <option>Provider 2</option>
          <option>Provider 3</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
          <option>Unlocked</option>
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
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>

      <div class="row" style="font-size: 12px; font-weight: 500; margin: 10px 0 10px 0;">
        Date Range
      </div>
      <div class="row gap-2" style="margin: 10px 0 10px 0;">
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'all'}"
                @click="filterByDateRange('all')">All
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'Today'}"
                @click="filterByDateRange('Today')">Today
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'Yesterday'}"
                @click="filterByDateRange('Yesterday')">
          Yesterday
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'This Week'}"
                @click="filterByDateRange('This Week')">This
          Week
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'Last Week'}"
                @click="filterByDateRange('Last Week')">Last
          Week
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'This Month'}"
                @click="filterByDateRange('This Month')">This
          Month
        </button>
        <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                :class="{'btn-active': activeRange === 'Last Month'}"
                @click="filterByDateRange('Last Month')">Last
          Month
        </button>
      </div>

      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
        <button class="search-btn btn btn-primary text-dark">Search</button>
      </div>
    </div>
  </div>

</template>


<script setup>
import {ref} from "vue";


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

const {firstDay, today} = getDefaultDates();
const selectedDateFilter = ref("All");

const form = ref({
  provider: "All",
  status: "Active",
  createdAt: firstDay,
  timeZone: "GMT+0700",
  completedAt: today,
});

const clearForm = () => {
  form.value.provider = "All";
  form.value.status = "Active";
  form.value.timeZone = "GMT+0700";
  form.value.createdAt = firstDay;
  form.value.completedAt = today;
  selectedDateFilter.value = "All";
  activeRange.value = 'This Month';
};

const activeRange = ref('This Month');

const filterByDateRange = (range) => {
  activeRange.value = range;
  const today = new Date();

  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  };

  if (range === 'Today') {
    form.value.createdAt = formatDate(today);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Yesterday') {
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);
    form.value.createdAt = formatDate(yesterday);
    form.value.completedAt = formatDate(yesterday);
  } else if (range === 'This Week') {
    const firstDayOfWeek = new Date(today);
    firstDayOfWeek.setDate(today.getDate() - today.getDay() + 1);
    form.value.createdAt = formatDate(firstDayOfWeek);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Last Week') {
    const lastWeekEnd = new Date(today);
    lastWeekEnd.setDate(today.getDate() - today.getDay());
    const lastWeekStart = new Date(lastWeekEnd);
    lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
    form.value.createdAt = formatDate(lastWeekStart);
    form.value.completedAt = formatDate(lastWeekEnd);
  } else if (range === 'This Month') {
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    form.value.createdAt = formatDate(firstDayOfMonth);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Last Month') {
    const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
    const lastDayLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
    form.value.createdAt = formatDate(firstDayLastMonth);
    form.value.completedAt = formatDate(lastDayLastMonth);
  }
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

.top-container {
  background: #f8f8f8;
}

.container-title {
  font-size: 14px;
  font-weight: bold;
}

.container-sub-title {
  font-size: 13px;
  font-weight: 500;
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

.btn-active {
  border: 1px solid #f4c938 !important;
  color: #f4c938 !important;
  background: #faeecd !important;
}


</style>