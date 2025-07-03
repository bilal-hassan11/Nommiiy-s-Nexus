<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">System Settings</h2>
      <p class="breadcrumb">System Settings > <strong>Provider Settings</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-4">
        <label>Category</label>
        <select v-model="form.category" class="form-select">
          <option value="All">All</option>
          <option>Category 1</option>
          <option>Category 2</option>
          <option>Category 2</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-4">
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
    </div>
    <div class="mt-3 d-flex justify-content-end">
      <button class="search-btn btn btn-primary text-dark" @click="handleClick">Update</button>
    </div>
  </div>

  <div class="form-container mt-5">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th class="px-3 py-2 text-center">ID</th>
          <th class="px-3 py-2 text-center">Currency</th>
          <th class="px-3 py-2 text-end">Provider Name</th>
          <th class="px-3 py-2 text-end">Icon</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(provider, index) in providers" :key="index">
          <td class="px-3 py-2 text-center">{{ provider.id }}</td>
          <td class="px-3 py-2 text-center">{{ provider.currency }}</td>
          <td class="px-3 py-2 text-end">{{ provider.providerName }}</td>
          <td class="px-3 py-2 text-end">
            <select v-model="provider.icon" class="form-select">
              <option value="New">New</option>
              <option value="None">None</option>
              <option value="Hot">Hot</option>
            </select>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>


<script setup>
import {ref} from "vue";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import {useNotificationStore} from "@/stores/notification.js";

const notification = useNotificationStore();
const currencies = ref(["BDT", "NPR"]);

const form = ref({
  category: "All",
  currency: ["BDT"]
});

function handleClick() {
  notification.triggerSuccess();
}

const providers = ref([
  {id: 161, currency: "BDT", providerName: "Rich Gaming", icon: "New"},
  {id: 162, currency: "BDT", providerName: "JILI", icon: "None"},
  {id: 163, currency: "BDT", providerName: "SVENUS Gaming", icon: "Hot"},
]);

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

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
  cursor: pointer;
  user-select: none;
}

td {
  font-size: 12px;
  font-weight: 500;
  color: #2c2c2c;
}

tr:hover td {
  background: #fde2c1;
}
</style>