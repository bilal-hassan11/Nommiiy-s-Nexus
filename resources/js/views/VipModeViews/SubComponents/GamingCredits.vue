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

  <div class="row" style="font-size: 18px; font-weight: 600; margin: 10px 1px 10px 4px;">
    Display Gaming Credits Setting
  </div>
  <div class="container mt-3">
    <!-- Line 1 -->
    <div class="row align-items-center mb-2">
      <div class="col-lg-3 col-md-3">
        <label class="mb-0">Display Gaming Credits in VIP Page</label>
      </div>
      <div class="col-lg-9 col-md-9">
        <input type="radio" name="vipInfo" id="vipYes" class="me-1" checked>
        <label for="vipYes" class="mb-0 me-3">Yes</label>

        <input type="radio" name="vipInfo" id="vipNo" class="me-1">
        <label for="vipNo" class="mb-0">No</label>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <label>Language</label>
    <select v-model="form.language" class="form-select">
      <option>All</option>
      <option>EN-BD</option>
      <option>EN-UK</option>
      <option>EN-US</option>
    </select>
  </div>
  <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
    Gaming Credits Terms and Conditions {{form.language}}
  </div>
  <TipTapEditor />
  <div class="button-group">
    <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
    <button class="btn search-btn">Search</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Multiselect from "vue-multiselect";
import TipTapEditor from '@/components/editor/TipTapEditor.vue';

const currencies = ref(['BDT', 'NPR']);
const form = ref({
  currency: [],
  merchant: 'MJB',
  language: 'EN-BD',
});

const clearForm = () => {
  form.value = {
    currency: [],
    merchant: 'MJB',
    language: 'EN-BD',
  };
};
</script>

<style scoped>
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

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
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
