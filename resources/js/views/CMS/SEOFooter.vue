<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>SEO Footer</strong></p>
    </div>
  </div>
  <div class="form-container pb-4">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Language</label>
        <select v-model="form.language" class="form-select">
          <option>All</option>
          <option>EN-BD</option>
          <option>EN-UK</option>
          <option>EN-US</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Category</label>
        <select v-model="form.category" class="form-select">
          <option>All</option>
          <option>FAQ</option>
          <option>Terms</option>
          <option>Conditions</option>
        </select>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      SEO Footer
    </div>
    <TipTapEditor/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import TipTapEditor from '@/components/editor/TipTapEditor.vue';

const form = ref({
  language: 'EN-BD',
  category: 'FAQ',
});

const clearForm = () => {
  form.value.category = "FAQ";
  form.value.language = "EN-BD";
}
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}
</style>
