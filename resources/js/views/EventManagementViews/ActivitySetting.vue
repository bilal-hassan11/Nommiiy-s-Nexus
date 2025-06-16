<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Event Management</h2>
      <p class="breadcrumb">Event Management > <strong>Activity Setting</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <div class="dropdown">
        <button class="btn btn-primary settings-btn dropdown-toggle me-2" type="button" id="settingsDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
          Settings
        </button>
        <ul class="dropdown-menu" style="border-color: #ffcc00; font-size: 14px;" aria-labelledby="settingsDropdown">
          <li><a class="dropdown-item" href="#">Currency Rate</a></li>
          <li><a class="dropdown-item" href="#">Spin Display</a></li>
          <li><a class="dropdown-item" href="#">Activity Point Expired Time</a></li>
        </ul>
      </div>

      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
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
        <label>Activity Name</label>
        <input type="text" v-model="form.activityName" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Activity Type</label>
        <select v-model="form.activityType" class="form-select">
          <option value="All">All</option>
          <option>Type 1</option>
          <option>Type 2</option>
          <option>Type 3</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
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
import {CirclePlus} from "lucide-vue-next";
import Multiselect from "vue-multiselect";

const form = ref({
  status: "All",
  merchant: "MJB",
  activityName: "",
  activityType: "All",
  currency: "",
});

const currencies = ref(["BDT", "NPR"]);

const clearForm = () => {
  form.value.status = "All";
  form.value.merchant = "MJB";
  form.value.activityName = "";
  form.value.activityType = "All";
  form.value.currency = "";
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

::v-deep(.multiselect) {
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 13px;
}

input {
  padding: 10px;
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

select {
  padding: 10px;
  font-size: 13px;
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

.settings-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  color: #2c2c2c;
  padding: 8px 23px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.settings-btn:hover {
  background: #a18923;
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

.dropdown-menu {
  border-color: #ffcc00;
  font-size: 14px;
}

.dropdown-item:hover {
  background: #fde2c1;
}
</style>
