<template>
  <AdjustBonusRebateModal v-model="showBonusModal" @submit="handleFormSubmit" />
  <AdjustWalletModal v-model="showWalletModal" @submit="handleFormSubmit" />
  <BulkTransferWalletModal v-model="showBulkTransferModal" @submit="handleFormSubmit" />
  <LastBulkWalletTransferModal v-model="showLastBulkTransferModal" />
  <div class="row align-items-center form-header">
    <div class="col-lg-5 col-md-12 col-sm-12">
      <h2 class="form-title">Deposit/Withdraw</h2>
      <p class="breadcrumb">Deposit/Withdraw > <strong>Adjustment</strong></p>
    </div>
    <div class="col-lg-7 col-md-12 col-sm-12 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success header-btn me-2"
              @click="showBonusModal = true">Adjust Bonus/Rebate</button>
      <button class="btn btn-outline-secondary header-btn me-2"
              @click="showWalletModal = true">Adjust Wallet</button>
      <button class="btn tag-btn me-2"
              @click="showBulkTransferModal = true">Bulk Transfer Wallet</button>
      <button class="btn btn-dark header-btn me-2"
              @click="showLastBulkTransferModal = true">Last Bulk Wallet Transfer</button>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">

      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Name</label>
        <input type="text" v-model="form.name" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Affiliate</label>
        <input type="text" v-model="form.affiliate" class="form-control">
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
        <label>Transaction Type</label>
        <select v-model="form.transactionType" class="form-select" placeholder="Please Select A Transaction Type">
          <option value="" disabled selected>Please Select A Transaction Type</option>
          <option>All</option>
          <option>Cash</option>
          <option>Bank</option>
          <option>Merchant</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Start Date</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Player ID</label>
        <input type="text" v-model="form.playerID" class="form-control">
      </div>

    </div>

    <div class="row" style="font-size: 12px; font-weight: 500; margin: 10px 1px 10px 4px;">
      Date Range
    </div>

    <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Today')">Today
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Yesterday')">
        Yesterday
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Week')">This
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Week')">Last
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('This Month')">This
        Month
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center" @click="filterByDateRange('Last Month')">Last
        Month
      </button>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>

  </div>
</template>


<script setup>
import {ref} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import Multiselect from "vue-multiselect";
import AdjustBonusRebateModal from "@/views/DepositViews/Modals/AdjustBonusRebateModal.vue";
import AdjustWalletModal from "@/views/DepositViews/Modals/AdjustWalletModal.vue";
import BulkTransferWalletModal from "@/views/DepositViews/Modals/BulkTransferWalletModal.vue";
import LastBulkWalletTransferModal from "@/views/DepositViews/Modals/LastBulkWalletTransferModal.vue";

const showBonusModal = ref(false);
const showWalletModal = ref(false);
const showBulkTransferModal = ref(false);
const showLastBulkTransferModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const selectedDateFilter = ref("All");
const currencies = ref(["BDT", "NPR"]);

const form = ref({
  username: "",
  name: "",
  affiliate: "",
  currency: "",
  transactionType: "",
  createdAt: "",
  completedAt: "",
  playerID: "",
  timeZone: "GMT+0700",
});

const clearForm = () => {
  form.value.username = "";
  form.value.name = "";
  form.value.affiliate = "";
  form.value.currency = "";
  form.value.transactionType = "";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.timeZone = "GMT+0700";
  form.value.playerID = "";
  selectedDateFilter.value = "All";
};

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.tag-btn:hover {
  background: #d6b402;
}

.header-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 26px;
  cursor: pointer;
}

.recent {
  width: 105px;
  height: 25px;
  font-size: 11px;
  font-weight: normal;
  background: white;
  padding: 3px;
  color: #807d7d;
  border: 1px solid #b1adad;
}

.recent:hover {
  border: #f4c938 1px solid;
  color: #f4c938;
  background: #faeecd;
}

</style>