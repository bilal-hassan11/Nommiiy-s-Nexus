<template>

  <div class="col-md-6 col-lg-3">
    <label>Full Name</label>
    <input v-model="form.fullName" class="form-control"/>
  </div>
  <div class="col-md-6 col-lg-3">
    <label>Remark</label>
    <input v-model="form.remark" class="form-control"/>
  </div>


  <div class="button-group">
    <button class="clear-btn btn btn-outline-dark">Clear</button>
    <button class="btn search-btn">Search</button>
  </div>
</template>

<script setup>
import {ref} from "vue";

const form = ref({
  fullName: '',
  remark: '',
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
