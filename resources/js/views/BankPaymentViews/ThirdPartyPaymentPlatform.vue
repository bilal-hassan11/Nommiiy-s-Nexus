<template>
  <BankMappingModal v-model="showBankMappingModal" @submit="handleFormSubmit"/>
  <AddThirdPartyPaymentPlatformModal v-model="showAddModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Bank/Payment</h2>
      <p class="breadcrumb">Bank/Payment > <strong>Third Party Payment Platform</strong></p>
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap gap-2">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
              @click="showAddModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
      <button class="btn tag-btn me-2 " @click="showBankMappingModal = true">Bank Mapping</button>
      <button class="btn tag-btn me-2 " @click="this.$router.push('/account-log');">Account Log</button>
      <button class="btn tag-btn me-2 " @click="handleClick">Update Sequence</button>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Third Party Platform</label>
        <select v-model="form.thirdPartyPlatform" class="form-select">
          <option value="All">All</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
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
      <div class="col-md-6 col-lg-3">
        <label>Payment Type</label>
        <select v-model="form.paymentType" class="form-select" placeholder="Please Select Payment Type">
          <option value="" disabled selected>Please Select Payment Type</option>
          <option value="All">All</option>
          <option>Deposit</option>
          <option>Withdrawal</option>
          <option>Transfer</option>
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
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
          <option>Unlocked</option>
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
import {onMounted, ref} from "vue";
import {CirclePlus} from "lucide-vue-next";
import "vue-multiselect/dist/vue-multiselect.css";
import Multiselect from "vue-multiselect";
import {useNotificationStore} from '@/stores/notification'
import BankMappingModal from "@/views/BankPaymentViews/modals/BankMappingModal.vue";
import AddThirdPartyPaymentPlatformModal from "@/views/BankPaymentViews/modals/AddThirdPartyPaymentPlatformModal.vue";

const notification = useNotificationStore();
const showBankMappingModal = ref(false);
const showAddModal = ref(false);

const currencies = ref(["BDT", "NPR"]);
const form = ref({
  currency: ["BDT", "NPR"],
  thirdPartyPlatform: "All",
  merchant: "MJB",
  status: "All",
  paymentType: "All",
});

const clearForm = () => {
  form.value.currency = ["BDT", "NPR"];
  form.value.thirdPartyPlatform = "All";
  form.value.status = "All";
  form.value.merchant = "MJB";
  form.value.paymentType = "All";
};

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData);
  // Optional: push into members list or send API request
};

onMounted(() => {
  const accountLog = history.state?.accountLog;
  if (accountLog) {
    handleFormSubmit(accountLog);
  }
});

function handleClick() {
  notification.triggerSuccess()
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>