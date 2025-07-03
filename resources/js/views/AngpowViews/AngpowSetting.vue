<template>
  <AddDisplaySettingsModal v-model="showDisplaySettingModal" @submit="handleFormSubmit"/>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Angpow</h2>
      <p class="breadcrumb">Angpow > <strong>Angpow Setting</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2" @click="showDisplaySettingModal = true">
        Display Setting
      </button>
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/add-angpow-setting');">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
    </div>
  </div>

  <div class="form-container mt-3">
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

      <div class="col-md-6 col-lg-3">
        <label>Activity Name</label>
        <input type="text" v-model="form.activityName" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Member Group</label>
        <select v-model="form.memberGroup" class="form-select">
          <option value="" disabled selected>Please Select Member Group</option>
          <option>All</option>
          <option>Member Group 1</option>
          <option>Member Group 2</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Method</label>
        <select v-model="form.method" class="form-select">
          <option value="All">All</option>
          <option>Deposit</option>
          <option>Withdraw</option>
          <option>Bank Transfer</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Start Date</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>

      <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        Please be reminded that this date input are GMT+8 standard.
      </p>

      <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mt-lg-0">
        <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
        <button class="search-btn btn btn-primary text-dark">Search</button>
      </div>
    </div>
  </div>

</template>


<script setup>
import {CirclePlus} from "lucide-vue-next";
import {onMounted, ref} from "vue";
import Multiselect from "vue-multiselect";
import AddDisplaySettingsModal from "@/views/AngpowViews/modals/AddDisplaySettingsModal.vue";

const showDisplaySettingModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

onMounted(() => {
  const newAngpowSetting = history.state?.newAngpowSetting;
  if (newAngpowSetting) {
    handleFormSubmit(newAngpowSetting);
  }
});

const currencies = ref(["BDT", "NPR"]);

const form = ref({
  currency: ["BDT", "NPR"],
  merchant: "MJB",
  memberGroup: "",
  activityName: "",
  method: "Deposit",
  createdAt: "",
});

const clearForm = () => {
  form.value.currency = ["BDT", "NPR"];
  form.value.merchant = "MJB";
  form.value.memberGroup = "";
  form.value.activityName = "";
  form.value.method = "Deposit";
  form.value.createdAt = "";
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
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

</style>