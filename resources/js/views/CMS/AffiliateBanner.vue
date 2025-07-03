<template>
  <AddAffiliateBanner v-model="showModal" @submit="handleFormSubmit"/>
  <AddAffiliatePopUpModal v-model="showAffiliatePopUpModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>Affiliate Banner</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-4 col-sm-12 d-flex justify-content-end gap-2">
      <button class="btn btn-outline-dark add-btn d-flex align-items-center justify-content-center"
              @click="showAffiliatePopUpModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add Pop Up Banner
      </button>
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
              @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
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
        <label>language</label>
        <select v-model="form.language" class="form-select">
          <option value="All">All</option>
          <option>EN-BD</option>
          <option>EN-US</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
</template>


<script setup>
import {ref} from "vue";
import {CirclePlus} from "lucide-vue-next";
import AddAffiliateBanner from "@/views/CMS/modals/AddAffiliateBannerModal.vue";
import AddAffiliatePopUpModal from "@/views/CMS/modals/AddAffiliatePopUpModal.vue";

const showModal = ref(false)
const showAffiliatePopUpModal = ref(false)

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  merchant: "MJB",
  status: "All",
  language: "All",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.status = "All";
  form.value.language = "All";
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
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