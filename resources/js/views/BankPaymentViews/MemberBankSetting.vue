<template>
  <ShowMemberBankSettingModal v-model="showMemberBankDetailModal" @submit="handleFormSubmit"/>
  <BankLimitSetting v-model="showMemberBankLimitModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Bank/Payment</h2>
      <p class="breadcrumb">Bank/Payment > <strong>Member's Bank Setting</strong></p>
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap gap-2">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center" @click="showMemberBankDetailModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
      <button class="btn btn-outline-dark add-btn d-flex align-items-center justify-content-center" @click="showMemberBankLimitModal = true">
        Bank Limit Setting
      </button>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
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
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
          <option>Unlocked</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Bank Name</label>
        <input type="text" v-model="form.bankName" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>

</template>


<script setup>
import {ref} from "vue";
import {CirclePlus} from "lucide-vue-next";
import "vue-multiselect/dist/vue-multiselect.css";
import Multiselect from "vue-multiselect";
import ShowMemberBankSettingModal from "@/views/BankPaymentViews/modals/ShowMemberBankSettingModal.vue";
import BankLimitSetting from "@/views/BankPaymentViews/modals/BankLimitSetting.vue";


const showMemberBankDetailModal = ref(false);
const showMemberBankLimitModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const currencies = ref(["BDT", "NPR"]);
const form = ref({
  currency: ["BDT", "NPR"],
  bankName: "",
  status: "All",
  timeZone: "GMT+0700",
});

const clearForm = () => {
  form.value.currency = ["BDT", "NPR"];
  form.value.timeZone = "GMT+0700";
  form.value.bankName = "";
  form.value.status = "All";
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