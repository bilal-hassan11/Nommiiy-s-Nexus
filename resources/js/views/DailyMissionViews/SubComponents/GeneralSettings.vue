<template>

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
    <select v-model="form.currency" class="form-select">
      <option>BDT</option>
      <option>NPR</option>
    </select>
  </div>

  <div class="row" style="font-size: 18px; font-weight: 600; margin: 10px 1px 10px 4px;">
    Display Field Settings
  </div>
  <div class="container mt-3">
    <!-- Line 1 -->
    <div class="row align-items-center mb-2">
      <div class="col-lg-3 col-md-3">
        <label class="mb-0">Diary Mission Menu Setting</label>
      </div>
      <div class="col-lg-9 col-md-9">
        <input type="radio" name="vipInfo" id="vipYes" class="me-1" checked>
        <label for="vipYes" class="mb-0 me-3">On</label>

        <input type="radio" name="vipInfo" id="vipNo" class="me-1">
        <label for="vipNo" class="mb-0">Off</label>
      </div>
    </div>

    <!-- Line 2 -->
    <div class="row align-items-center mb-2">
      <div class="col-lg-3 col-md-3">
        <label class="mb-0">Diary Mission Popup After Login</label>
      </div>
      <div class="col-lg-9 col-md-9">
        <input type="radio" name="sideBar" id="sideBarYes" class="me-1" checked>
        <label for="sideBarYes" class="mb-0 me-3">On</label>

        <input type="radio" name="sideBar" id="sideBarNo" class="me-1">
        <label for="sideBarNo" class="mb-0">Off</label>
      </div>
    </div>
  </div>
  <div class="button-group">
    <button class="btn search-btn">Save</button>
  </div>
</template>

<script setup>
import {ref} from "vue";

const form = ref({
  currency: 'BDT',
  merchant: "MJB",
});
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

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #d6b402;
}

input[type="radio"] {
  appearance: none;
  width: 15px;
  height: 15px;
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
