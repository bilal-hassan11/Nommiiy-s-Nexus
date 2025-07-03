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
    <label>Username</label>
    <input v-model="form.username" class="form-control"/>
  </div>
  <div class="col-md-6 col-lg-3">
    <label>Status</label>
    <select v-model="form.status" class="form-select">
      <option>All</option>
      <option>None</option>
    </select>
  </div>

  <div class="button-group">
    <button class="clear-btn btn btn-outline-dark">Clear</button>
    <button class="btn search-btn">Search</button>
  </div>
</template>

<script setup>
import {ref} from "vue";

const form = ref({
  username: '',
  status: 'All',
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


.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

</style>
