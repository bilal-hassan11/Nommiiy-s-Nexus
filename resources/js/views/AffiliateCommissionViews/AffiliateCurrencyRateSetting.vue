<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Affiliate Comm</h2>
      <p class="breadcrumb">Affiliate Comm > <strong>Affiliate Currency Rate Setting</strong></p>
    </div>
  </div>

  <div class="form-container mt-3">
    <h2 class="form-title">Currency Rate Setting</h2>

    <div class="row gx-3 gy-3">

      <div class="col-md-6 col-lg-3">
        <label class="form-label">Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label class="form-label">Year*</label>
        <select v-model="form.year" class="form-select">
          <option>2025</option>
          <option>2024</option>
          <option>2023</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label class="form-label">Month*</label>
        <select v-model="form.month" class="form-select">
          <option>2025</option>
          <option>2024</option>
          <option>2023</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label class="form-check-label checkbox-label" for="allYearMonth">All Year & Month*</label>
        <input type="checkbox" v-model="form.allYearMonth" class="custom-checkbox form-check-input me-2"
               id="allYearMonth"/>
      </div>

      <div class="col-md-6 col-lg-3">
        <label class="form-label">1 BDT =</label>
        <div class="input-group align-items-center">
          <input type="number" v-model="form.BDT" class="form-control currency-input"/>
          <span class="input-group-text">USD</span>
        </div>
        <p class="conversion-hint">
          The conversion rate from BDT to USD. Ex: BDT * rate = USD, USD / rate = BDT.
        </p>
      </div>

      <div class="col-md-6 col-lg-3">
        <label class="form-label">1 NPR =</label>
        <div class="input-group align-items-center">
          <input type="number" v-model="form.NPR" class="form-control currency-input"/>
          <span class="input-group-text">USD</span>
        </div>
        <p class="conversion-hint">
          The conversion rate from NPR to USD. Ex: NPR * rate = USD, USD / rate = NPR.
        </p>
      </div>


      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
        <button class="search-btn btn btn-primary text-dark">Save</button>
      </div>
    </div>
  </div>
</template>


<script setup>
import {ref} from "vue";

const form = ref({
  merchant: "MJB",
  year: "2025",
  month: "",
  BDT: "",
  NPR: "",
  allYearMonth: true,
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.month = "";
  form.value.BDT = "";
  form.value.NPR = "";
  form.value.allYearMonth = true;
  form.value.year = "2025";
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

.input-group {
  display: flex;
  align-items: center;
}

.currency-input {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.input-group-text {
  background: #f0f0f0;
  font-size: 13px;
  font-weight: 600;
  padding: 6px 12px;
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}

.conversion-hint {
  font-size: 10px;
  font-weight: 500;
  margin: 8px 0 0 2px;
  color: #d87a00;
}

input[type="checkbox"] {
  transform: scale(0.85);
  margin-right: 6px;
}

.checkbox-label {
  font-size: 11px;
  font-weight: 500;
  color: #2c2c2c;
  display: flex;
  align-items: center;
  gap: 4px;
}

.checkbox-label {
  margin-bottom: 6px;
}

.custom-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.custom-checkbox:checked {
  background-color: #f1c40f;
  border-color: #f1c40f;
}

.custom-checkbox:checked::after {
  content: '✓';
  color: #fff !important;
  font-size: 11px;
  position: absolute;
  left: 2px;
  top: -1px;
}

.custom-checkbox:hover {
  border-color: #d4ac0d;
}
</style>