<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h2 class="form-title">Report</h2>
      <p class="breadcrumb">Report > <strong>Premium Game Report</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">

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
        <label>Provider ID</label>
        <select v-model="form.providerId" class="form-select">
          <option value="All">Evolution</option>
          <option>XYZ</option>
          <option>ABC</option>
          <option>LMN</option>
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
        <label>Start Date</label>
        <span style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #ae0404">
          *60 Valid Days
        </span>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
    </div>
    <!-- Date Range Column -->
    <div class="row gx-2 gy-3 align-items-start mt-2">
      <div class="col-lg-8 col-md-8 col-sm-12 d-flex flex-column">
        <label style="font-size: 12px; font-weight: 500; margin-bottom: 5px;">Date Range</label>
        <div class="d-flex flex-wrap align-items-center gap-2">
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Today'}"
                  @click="filterByDateRange('Today')">Today
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Yesterday'}"
                  @click="filterByDateRange('Yesterday')">Yesterday
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'This Week'}"
                  @click="filterByDateRange('This Week')">This Week
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Last Week'}"
                  @click="filterByDateRange('Last Week')">Last Week
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'This Month'}"
                  @click="filterByDateRange('This Month')">This Month
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Last Month'}"
                  @click="filterByDateRange('Last Month')">Last Month
          </button>
        </div>
      </div>

      <div class="col-lg-2 col-md-4 col-sm-12 d-flex flex-column">
        <label for="dailyCheckbox" style="font-size: 12px; font-weight: 500; margin-bottom: 5px;">Daily</label>
        <div class="daily-checkbox position-relative">
          <input type="checkbox" id="dailyCheckbox" v-model="form.daily"/>
          <label for="dailyCheckbox"></label>
        </div>
      </div>
    </div>

    <div class="row" style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
      **Please be reminded that this report is generated based on GMT+8 standard.
    </div>


    <div class="col-12 d-flex justify-content-end gap-2">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
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
  currency: "BDT",
  parentLogin: "",
  createdAt: firstDay,
  registerFrom: firstDay,
  merchant: "MJB",
  providerId: "All",
  completedAt: today,
  registerTo: today,
  daily: "",
});

const clearForm = () => {
  form.value.currency = "BDT";
  form.value.parentLogin = "";
  form.value.merchant = "MJB";
  form.value.providerId = "All";
  form.value.registerFrom = firstDay;
  form.value.createdAt = firstDay;
  form.value.completedAt = today;
  form.value.registerTo = today;
  form.value.daily = "";
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

.recent {
  width: 80px;
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


.daily-checkbox {
  display: flex;
  align-items: center;
  gap: 6px;
  border-color: #ffcc00;
  margin-top: 5px;
  font-size: 12px;
  font-weight: 500;
}

.daily-checkbox input[type="checkbox"] {
  accent-color: #f4c938;
  color: white;
  width: 16px;
  height: 16px;
  cursor: pointer;
}

</style>