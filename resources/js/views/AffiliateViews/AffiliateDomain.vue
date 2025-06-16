<template>
  <AffiliateDomainModal v-model="showModal" @submit="handleFormSubmit" />
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Affiliate</h2>
      <p class="breadcrumb">Affiliate > <strong>Affiliate Domain</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
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
        <label>Affiliate Username</label>
        <input type="text" v-model="form.affiliateUsername" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Domain Name</label>
        <input type="text" v-model="form.domainName" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
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
import AffiliateDomainModal from "./modals/AffiliateDomainModal.vue"
import AffiliateListModal from "@/views/AffiliateViews/modals/AffiliateListModal.vue";

const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const form = ref({
  affiliateUsername: "",
  domainName: "",
  merchant: "MJB",
  timeZone: "GMT+0700",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.affiliateUsername = "";
  form.value.domainName = "";
  form.value.timeZone = "GMT+0700";
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
  border-radius: 2px;
}

</style>