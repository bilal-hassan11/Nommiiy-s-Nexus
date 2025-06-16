<template>
  <AffiliateListModal v-model="showModal" @submit="handleFormSubmit" />

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Affiliate</h2>
      <p class="breadcrumb">Affiliate > <strong>Affiliate List</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
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
        <label>Currency</label>
        <Multiselect
            v-model="form.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Pick currencies"
        />
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate Username</label>
        <input type="text" v-model="form.affiliateUsername" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate Name</label>
        <input type="text" v-model="form.affiliateName" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate Code</label>
        <input type="text" v-model="form.affiliateCode" class="form-control">
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
        <label>Affiliate Group</label>
        <select v-model="form.affiliateGroup" class="form-select">
          <option value="All">All</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Contact</label>
        <input type="text" v-model="form.contact" class="form-control">
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
      <div class="col-md-6 col-lg-3">
        <label>Email</label>
        <input type="text" v-model="form.email" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Parent Login</label>
        <input type="text" v-model="form.parentLogin" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Line ID</label>
        <input type="text" v-model="form.lineId" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Telegram ID</label>
        <input type="text" v-model="form.telegramId" class="form-control">
      </div>

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
  </div>
</template>


<script setup>
import {ref} from "vue";
import {CirclePlus} from "lucide-vue-next";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import AffiliateListModal from "./modals/AffiliateListModal.vue"

const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const currencies = ref(["BDT", "NPR"]);

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
  currency: ["BDT", "NPR"],
  createdAt: firstDay,
  affiliateUsername: "",
  affiliateName: "",
  affiliateCode: "",
  contact: "",
  email: "",
  parentLogin: "",
  lineId: "",
  telegramId: "",
  merchant: "MJB",
  status: "All",
  affiliateGroup: "All",
  timeZone: "GMT+0700",
  completedAt: today,
});

const clearForm = () => {
  form.value.currency = ["BDT", "NPR"];
  form.value.merchant = "MJB";
  form.value.status = "All";
  form.value.affiliateGroup = "All";
  form.value.affiliateUsername = "";
  form.value.affiliateName = "";
  form.value.affiliateCode = "";
  form.value.contact = "";
  form.value.email = "";
  form.value.parentLogin = "";
  form.value.lineId = "";
  form.value.telegramId = "";
  form.value.createdAt = firstDay;
  form.value.completedAt = today;
  form.value.timeZone = "GMT+0700";
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
  border-radius: 2px;
}
</style>