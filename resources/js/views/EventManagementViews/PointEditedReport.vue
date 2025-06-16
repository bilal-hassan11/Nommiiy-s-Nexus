<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Event Management</h2>
      <p class="breadcrumb">Event Management > <strong>Point Edited Report</strong></p>
    </div>

    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Adjust Activity Points
      </button>
    </div>
  </div>

  <div class="form-container">
    <h3 class="col-lg-12 col-md-12 form-sub-title">Remaining activity points</h3>
    <div class="row col-lg-12 col-md-12"
         style="font-size: 11px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d84f4f">
      Available daily from 07:00 ~ 23:00 GMT+0800, once every 24 hours.
    </div>

    <div class="row mb-4 align-items-stretch">
      <div class="col-lg-2 col-md-4 col-12 mb-2">
        <input class="form-control text-center text-dark" type="text" :value="randomValue" disabled/>
      </div>
      <div class="col-auto col-lg-1 col-12 col-md-4 mb-2">
        <button class="btn btn-secondary custom-btn">Refresh</button>
      </div>
      <div class="col-auto col-12 col-md-4 mb-2">
        <button class="btn btn-danger custom-btn">Eliminate</button>
      </div>
    </div>


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
        <label>Tag</label>
        <select v-model="form.tag" class="form-select">
          <option value="All">All</option>
          <option>Tag 1</option>
          <option>Tag 2</option>
          <option>Tag 3</option>
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
        <label>Source</label>
        <select v-model="form.source" class="form-select">
          <option value="All">All</option>
          <option>Type 1</option>
          <option>Type 2</option>
          <option>Type 3</option>
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
    </div>

    <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Today')">Today
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Yesterday')">
        Yesterday
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Week')">This
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Week')">Last
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Month')">This
        Month
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Month')">Last
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
import {ref, onMounted} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import Multiselect from "vue-multiselect";
import {CirclePlus} from "lucide-vue-next";

const form = ref({
  username: "",
  currency: "",
  createdAt: "",
  completedAt: "",
  source: "All",
  merchant: "MJB",
  memberGroup: "All",
  tag: "All",
});

const currencies = ref(["BDT", "NPR"]);
const selectedDateFilter = ref("All");
const randomValue = ref('');

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
};

onMounted(() => {
  randomValue.value = Math.floor(100000 + Math.random() * 900000).toString();
});

const clearForm = () => {
  form.value.username = "";
  form.value.currency = "";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.source = "All";
  form.value.merchant = "MJB";
  form.value.memberGroup = "All";
  form.value.tag = "All";

  selectedDateFilter.value = "All";
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

.form-sub-title {
  font-size: 15px;
  font-weight: 650;
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

.custom-btn {
  padding: 5px 20px;
  font-size: 13px;
  font-weight: 600;
}
</style>