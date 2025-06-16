<template>
  <WithdrawModal v-model="showModal" @submit="handleFormSubmit" />

  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Deposit/Withdraw</h2>
      <p class="breadcrumb">Deposit/Withdraw > <strong>Withdraw</strong></p>
    </div>
    <div class="col-lg-2 col-md-2 col-4 col-sm-12 d-flex justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"  @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <!-- Row 1 -->
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
        <input type="text" v-model="form.username" class="form-control">
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
        <label>Payment Type</label>
        <select v-model="form.paymentChannel" class="form-select" placeholder="Please Select Payment Method">
          <option value="" disabled selected>Please Select Payment Method</option>
          <option>All</option>
          <option>Bank</option>
          <option>Cash</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Start Date</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Member Group</label>
        <select v-model="form.memberGroup" class="form-select" placeholder="Please Select Member Group">
          <option value="" disabled selected>Please Select Member Group</option>
          <option>All</option>
          <option>Regular</option>
          <option>New</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Withdraw ID</label>
        <input type="number" v-model="form.withdrawId" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Risk</label>
        <select v-model="form.risk" class="form-select">
          <option>All</option>
          <option>Yes</option>
          <option>No</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Merchant Bank</label>
        <select v-model="form.merchantBank" class="form-select" placeholder="Please Select a Bank">
          <option value="" disabled selected>Please Select a Bank</option>
          <option>All</option>
          <option>bank_transfer</option>
          <option>credit_card</option>
        </select>
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
  <!-- Export Button -->
  <div class="row g-3 mt-3 form-container d-flex justify-content-center align-items-center">
    <p class="col-lg-12 text-center">no records to show</p>
  </div>
</template>


<script setup>
import {ref} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import {CirclePlus} from "lucide-vue-next";
import Multiselect from "vue-multiselect";
import WithdrawModal from "@/views/DepositViews/Modals/WithdrawModal.vue";

const selectedDateFilter = ref("All");
const currencies = ref(["BDT", "NPR"]);
const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const form = ref({
  merchant: "All",
  username: "",
  currency: "",
  paymentChannel: "All",
  createdAt: "",
  memberGroup: "All",
  status: "All",
  merchantBank: "All",
  completedAt: "",
  risk: "All",
  withdrawId: "",
  timeZone: "GMT+0700",
  playerID: ""
});

const clearForm = () => {
  form.value.merchant = "All";
  form.value.username = "";
  form.value.currency = "";
  form.value.paymentChannel = "All";
  form.value.memberGroup = "All";
  form.value.status = "All";
  form.value.merchantBank = "All";
  form.value.withdrawId = "";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.risk = "All";
  form.value.playerID = "";
  form.value.timeZone = "GMT+0700";
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
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