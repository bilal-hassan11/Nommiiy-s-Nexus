<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>SEO Script Settings</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>language</label>
        <select v-model="form.language" class="form-select">
          <option value="All">All</option>
          <option>EN-BD</option>
          <option>EN-US</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
  <div class="form-container mt-4">
    <div class="mb-2">
      <label class="form-label">SEO Header EN-BD</label>
    </div>
    <textarea
        class="form-control seo-textarea mb-3"
        rows="3"
        v-model="form.seoHeader"
    ></textarea>
    <div class="d-flex justify-content-end">
      <button class="search-btn btn btn-primary text-dark">Save</button>
    </div>
  </div>

  <div class="form-container mt-4">
    <div class="mb-2">
      <label class="form-label">SEO HomePage EN-BD</label>
    </div>
    <textarea
        class="form-control seo-textarea mb-3"
        rows="3"
        v-model="form.seoHomePage"
    ></textarea>
    <div class="d-flex justify-content-end">
      <button class="search-btn btn btn-primary text-dark">Save</button>
    </div>
  </div>
</template>


<script setup>
import {ref} from "vue";

const form = ref({
  merchant: "MJB",
  language: "EN-BD",
  seoHeader: `MajuBaji: Experience the premier online casino platform in Bangladesh, offering luxury gaming, top-tier services, and exceptional win rates.`,
  seoHomePage: "",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.language = "EN-BD";
  form.value.seoHeader = `MajuBaji: Experience the premier online casino platform in Bangladesh, offering luxury gaming, top-tier services, and exceptional win rates.`;
  form.value.seoHomePage = "";
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

.seo-textarea {
  background-color: #e9e9e9;
  border: none;
  font-weight: 500;
  font-size: 13px;
  color: #202020;
  resize: none;
}
</style>