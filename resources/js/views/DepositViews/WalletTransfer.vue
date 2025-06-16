<template>
  <WalletTransferModal v-model="showModal" @submit="handleFormSubmit" />

  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Deposit/Withdraw</h2>
      <p class="breadcrumb">Deposit/Withdraw > <strong>Wallet Transfer</strong></p>
    </div>
    <div class="col-lg-2 col-md-2 col-4 col-sm-12 d-flex justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
              @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Make A Transfer
      </button>
    </div>
  </div>

  <div class="form-container">
    <!-- Tabs -->
    <div class="tabs-container">
      <a
          v-for="tab in tabs"
          :key="tab.value"
          @click="changeTab(tab.value)"
          :class="['tab-button', { active: selectedTab === tab.value }]"
      >
        {{ tab.label }}
      </a>
    </div>

    <div class="row gx-3 gy-3">
      <template v-for="(field, index) in activeFields" :key="index">
        <div class="col-md-6 col-lg-4">
          <label>{{ field.label }}</label>
          <input
              v-if="field.type === 'input'"
              v-model="form[field.model]"
              class="form-control"
              type="text"
          />
          <!-- Input without Radio -->
          <input
              v-else-if="field.type === 'input'"
              v-model="form[field.model]"
              class="form-control"
              type="text"
          />

          <!-- Select Dropdown -->
          <select
              v-else-if="field.type === 'select'"
              v-model="form[field.model]"
              class="form-select"
          >
            <option v-for="option in field.props.options" :key="option" :value="option">
              {{ option }}
            </option>
          </select>

          <!-- Multiselect -->
          <Multiselect
              v-else-if="field.type === 'Multiselect'"
              v-model="form[field.model]"
              :options="field.props.options"
              :multiple="field.props.multiple"
              :searchable="field.props.searchable"
              :close-on-select="false"
              :clear-on-select="false"
              :limit="2"
              placeholder="Pick currencies"
          />
          <!-- Date Field -->
          <input
              v-else-if="field.type === 'date'"
              v-model="form[field.model]"
              class="form-control"
              type="date"
          />
        </div>
      </template>
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

    <div class="button-group">
      <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
      <button class="btn search-btn">Search</button>
    </div>
  </div>
</template>

<script setup>
import {ref, computed} from "vue";
import Multiselect from "vue-multiselect";
import {CirclePlus} from "lucide-vue-next";
import WalletTransferModal from "@/views/DepositViews/Modals/WalletTransferModal.vue";

const selectedTab = ref("transferTransactions");
const selectedRadio = ref(null);
const selectedDateFilter = ref("All");

const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const tabs = ref([
  {label: "Transfer Transactions", value: "transferTransactions"},
  {label: "Uncertain Transfer", value: "uncertainTransfer"},
]);

const form = ref({
  username: "",
  playerID: "",
  startDate: "",
  endDate: "",
  currency: [],
  merchant: "MJB",
  timeZone: "GMT+0500",
  providerID: "All",
  status: "All"
});

const fieldsMap = {
  transferTransactions: [
    {label: "Merchant", model: "merchant", type: "select", props: {options: ["MJB", "All"]}},
    {label: "Provider ID", model: "providerID", type: "select", props: {options: ["All", "ProviderXHJ1"]}},
    {label: "Username", model: "username", type: "input"},
    {label: "Currency", model: "currency", type: "Multiselect", props: {options: ["BDT", "NPR"], multiple: true, searchable: true}},
    {label: "Start Date", model: "startDate", type: "date"},
    {label: "End Date", model: "endDate", type: "date"},
    {label: "Status", model: "status", type: "select", props: {options: ["All", "Active", "Inactive"]}},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {label: "Player ID", model: "playerID", type: "input"},
  ],
  uncertainTransfer: [
    {label: "Merchant", model: "merchant", type: "select", props: {options: ["MJB", "All"]}},
    {label: "Username", model: "username", type: "input"},
    {label: "Status", model: "status", type: "select", props: {options: ["All", "Active", "Inactive"]}},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {label: "Player ID", model: "playerID", type: "input"},
  ],
};

const activeFields = computed(() => fieldsMap[selectedTab.value]);

const changeTab = (tab) => {
  selectedTab.value = tab;
  selectedRadio.value = null;
  clearForm();
};

const clearForm = () => {
  form.value = {
    playerID: "",
    username: "",
    status: "All",
    startDate: "",
    endDate: "",
    currency: [],
    providerID: "All",
    merchant: "MJB",
    timeZone: "GMT+0500",
  };
  selectedDateFilter.value = "All";
};

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
};
</script>


<style scoped>
.tabs-container {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.tab-button {
  text-decoration: none;
  color: #6c757d;
  padding: 7px 7px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  font-size: 13px;
  font-weight: 600;
}

.tab-button.active {
  color: black;
  border-bottom: 2px solid #f4c938;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

::v-deep(.multiselect) {
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 13px;
}

input, select {
  font-size: 13px;
  padding: 3px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
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
  background: #e8c015;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #d6b402;
}

input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ffcc00;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
}

input[type="radio"]:checked {
  background-color: #ffcc00;
}

input[type="radio"]:checked::after {
  content: "";
  width: 6px;
  height: 6px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>
