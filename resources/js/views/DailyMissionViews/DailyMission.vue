<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Mission Daily Setting</h2>
      <p class="breadcrumb">Mission Daily Setting > <strong>Daily Mission</strong></p>
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
      <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        *Daily 00:00-23:59 GMT +8, the mission is reset daily
      </p>
      <div class="d-flex align-items-center gap-2">
        <label for="flexSwitchCheck" class="form-label mb-0">
          Daily task foreground display
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
          1. Daily login: Members can get it when they login for the first time each day, only one can be set.<br/>
          2. Daily deposit: daily accumulated deposit, recalculated daily at 00:00 GMT+8.<br/>
          3. Effective yesterday bet: the effective yesterday accumulated bet amount, bets are re-settled, will not be
          recalculated, and recalculated at 00:00 GMT+8 every day.<br/>
          4. Reward daily: From 00:00 to 23:59 GMT+8, time cannot be duplicated, members required to click the Mission
          Daily page for the reward.<br/>
          5. Yesterday loss: Settle the total loss of yesterday's 00:00 ~ 23:59 GMT+8 daily.<br/>
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
import {Files} from "lucide-vue-next";
import {ref} from "vue";
import { useNotificationStore } from '@/stores/notification'

const notification = useNotificationStore()

function handleClick() {
  notification.triggerSuccess()
}

const form = ref({
  merchant: "MJB",
  currency: "BDT",
});
const isActive = ref(false);

const clearForm = () => {
  form.value.currency = "BDT";
  form.value.merchant = "MJB";
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