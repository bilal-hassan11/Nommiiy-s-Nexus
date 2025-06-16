<template>

  <div class="col-md-6 col-lg-3">
    <label>Username</label>
    <input type="text" v-model="form.username" class="form-control">
  </div>

  <div class="col-md-6 col-lg-3">
    <label>Group</label>
    <select v-model="form.group" class="form-select">
      <option value="All">All</option>
      <option>Group 1</option>
      <option>Group 2</option>
    </select>
  </div>

  <div class="col-md-6 col-lg-3">
    <label>Group Msg Id</label>
    <input type="text" v-model="form.groupMsgId" class="form-control">
  </div>

  <div class="col-md-6 col-lg-3">
    <label>Title</label>
    <input type="text" v-model="form.title" class="form-control">
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
    <label>Status</label>
    <select v-model="form.status" class="form-select">
      <option>Active</option>
      <option>Inactive</option>
      <option>Pending</option>
    </select>
  </div>

  <div class="col-md-6 col-lg-3">
    <label>Time Zone</label>
    <select v-model="form.timeZone" class="form-select">
      <option>GMT+0700</option>
      <option>GMT+0500</option>
    </select>
  </div>

  <div class="row" style="font-size: 12px; font-weight: 500; margin: 10px 1px 10px 4px;">
    Date Range
  </div>
  <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
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
  <div class="col-12 d-flex justify-content-end gap-2">
    <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
    <button class="search-btn btn btn-primary text-dark">Search</button>
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
  username: "",
  groupMsgId: "",
  group: "All",
  title: "",
  status: "Active",
  createdAt: firstDay,
  timeZone: "GMT+0700",
  completedAt: today,
});

const clearForm = () => {
  form.value.username = "";
  form.value.groupMsgId = "";
  form.value.group = "All";
  form.value.title = "";
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
label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

select {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}


.btn-active {
  border: 1px solid #f4c938 !important;
  color: #f4c938 !important;
  background: #faeecd !important;
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

</style>
