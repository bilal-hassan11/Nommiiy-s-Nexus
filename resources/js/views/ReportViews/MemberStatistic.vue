<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Report</h2>
      <p class="breadcrumb">Report > <strong>Member Statistic</strong></p>
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
    </div>

    <div class="row mt-3">
      <div class="col-auto d-flex align-items-center">
        <input type="radio" name="activeDuration" id="minActiveDuration" checked class="me-2"/>
        <label for="minActiveDuration" class="sound-options mb-0">Minimum Active Duration</label>
      </div>
    </div>

    <div class="row gx-3 gy-3 mt-3 justify-content-start">
      <div class="col-md-6 col-lg-3">
      <input class="form-control" type="text" v-model="form.minValue">
      </div>
      <span class="col-md-2 col-lg-1 text-center">-</span>
      <div class="col-md-6 col-lg-3">
      <input class="form-control" type="text" v-model="form.maxValue">
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-auto d-flex align-items-center">
        <input type="radio" name="balance" id="walletBalance" checked class="me-2"/>
        <label for="walletBalance" class="sound-options mb-0">Wallet Balance</label>
      </div>
    </div>

    <div class="row">
      <div class="col-auto d-flex align-items-center">
        <input type="radio" name="balance" id="registerBetween" class="me-2"/>
        <label for="registerBetween" class="sound-options mb-0">Register Between</label>
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
import "vue-multiselect/dist/vue-multiselect.css";
import Multiselect from "vue-multiselect";

const form = ref({
  minValue: "1",
  maxValue: "100",
  currency: ["BDT", "NPR"],
  merchant: "MJB",
});

const currencies = ref(["BDT", "NPR"]);

const clearForm = () => {
  form.value.minValue = "1";
  form.value.maxValue = "100";
  form.value.currency = ["BDT", "NPR"];
  form.value.merchant = "MJB";
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

.sound-options {
  margin-top: 5px;
  font-size: 11px;
}

.sound-options label {
  display: block;
  margin-top: 5px;
}

input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ccc;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  outline: none;
  transition: 0.3s;
}

input[type="radio"]:checked {
  border-color: #ffcc00;
  background-color: #ffcc00;
}

input[type="radio"]:checked::before {
  content: "";
  width: 4px;
  height: 4px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>