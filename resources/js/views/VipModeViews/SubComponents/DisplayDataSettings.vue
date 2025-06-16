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
  <div class="button-group">
    <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
    <button class="btn search-btn">Search</button>
  </div>
</template>

<script setup>
import {ref} from "vue";
import Multiselect from "vue-multiselect";

const currencies = ref(["BDT", "NPR"]);
const form = ref({
  currency: [],
  merchant: "MJB",
});

const clearForm = () => {
  form.value = {
    currency: [],
    merchant: "MJB",
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
</style>
