<template>
  <DepositModal v-model="showModal" @submit="handleFormSubmit" />

  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Deposit/Withdraw</h2>
      <p class="breadcrumb">Deposit/Withdraw > <strong>Deposit</strong></p>
    </div>
    <div class="col-lg-2 col-md-2 col-4 col-sm-12 d-flex justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center" @click="showModal = true">
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
        <label>Payment Channel</label>
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
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Payment Method</label>
        <select v-model="form.paymentMethod" class="form-select" placeholder="Please Select a Bank">
          <option value="" disabled selected>Please Select a Bank</option>
          <option>All</option>
          <option>bank_transfer</option>
          <option>credit_card</option>
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
        <label>Order ID</label>
        <input type="text" v-model="form.orderId" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate Username</label>
        <input type="text" v-model="form.affiliateUsername" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Transaction ID</label>
        <input type="text" v-model="form.transactionID" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Reference Number</label>
        <input type="text" v-model="form.referenceNumber" class="form-control">
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
  <div class="row g-3 mt-3 form-container">
    <div class="row mt-3">
      <div class="col-lg-2 col-md-4 col-6 col-sm-6">
        <button class="export-btn btn btn-outline-secondary w-100" @click="exportToExcel">
          <Download size="16" stroke-width="2" class="me-2"/>
          Export
        </button>
      </div>
    </div>

    <!-- Table Section -->

    <div class="table-responsive mt-3">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('orderId')">Order ID <span
              v-if="sortColumn === 'orderId'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('paymentMethod')">Payment Method <span
              v-if="sortColumn === 'paymentMethod'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('handler')">Handler <span
              v-if="sortColumn === 'handler'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('username')">Username <span
              v-if="sortColumn === 'username'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('playerID')">Player ID <span
              v-if="sortColumn === 'playerID'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('phoneNumber')">Phone Number <span
              v-if="sortColumn === 'phoneNumber'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('transactionID')">Transaction ID <span
              v-if="sortColumn === 'transactionID'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('referenceNumber')">Reference Number <span
              v-if="sortColumn === 'referenceNumber'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('amount')">Amount <span
              v-if="sortColumn === 'amount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('processingFee')">Processing Fee <span
              v-if="sortColumn === 'processingFee'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('receivedAmount')">Received Amount <span
              v-if="sortColumn === 'receivedAmount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('depositFee')">Deposit Fee <span
              v-if="sortColumn === 'depositFee'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('memberName')">Member Name <span
              v-if="sortColumn === 'memberName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('vipLevel')">VIP Level <span
              v-if="sortColumn === 'vipLevel'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('memberGroup')">Member Group <span
              v-if="sortColumn === 'memberGroup'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('affiliateUsername')">Affiliate Username <span
              v-if="sortColumn === 'affiliateUsername'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdAt')">Created At <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('processingAt')">Processing At <span
              v-if="sortColumn === 'processingAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('completedAt')">Completed At <span
              v-if="sortColumn === 'completedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('merchantBankHolder')">Merchant Bank Holder <span
              v-if="sortColumn === 'merchantBankHolder'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('merchantBankName')">Merchant Bank Name <span
              v-if="sortColumn === 'merchantBankName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('merchantBankAccount')">Merchant Bank Account <span
              v-if="sortColumn === 'merchantBankAccount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Admin Remark</th>
          <th @click="sortTable('applyBy')">Apply By<span
              v-if="sortColumn === 'applyBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('risk')">Risk <span
              v-if="sortColumn === 'risk'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.orderId }}</td>
          <td>{{ member.paymentMethod }}</td>
          <td>{{ member.handler }}</td>
          <td>
      <span
          :class="{
          'badge border border-success text-success': member.status === 'Active',
          'badge border border-danger text-danger': member.status === 'Inactive',
          'badge border border-warning text-warning': member.status === 'Pending'
        }">
        {{ member.status }}
      </span>
          </td>
          <td><a href="#" style="color: #787445">{{ member.username }}</a></td>
          <td>{{ member.playerID }}</td>
          <td>{{ member.phoneNumber }}</td>
          <td>{{ member.transactionID }}</td>
          <td>{{ member.referenceNumber }}</td>
          <td>{{ member.currency }}</td>
          <td>{{ member.amount }}</td>
          <td>{{ member.processingFee }}</td>
          <td>{{ member.receivedAmount }}</td>
          <td>{{ member.depositFee }}</td>
          <td>{{ member.memberName }}</td>
          <td>{{ member.vipLevel }}</td>
          <td>{{ member.memberGroup }}</td>
          <td>{{ member.affiliateUsername }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.processingAt }}</td>
          <td>{{ member.completedAt }}</td>
          <td>{{ member.merchantBankHolder }}</td>
          <td>{{ member.merchantBankName }}</td>
          <td>{{ member.merchantBankAccount }}</td>
          <td>{{ member.adminRemark }}</td>
          <td>{{ member.applyBy }}</td>
          <td>{{ member.risk }}</td>
        </tr>

        <!-- Page Summary Row -->
        <tr class="page-summary">
          <td class="fw-bold text-start" colspan="10">Page Summary</td>
          <td class="text-end">{{ formattedPageSummary.amount }}</td>
          <td class="text-end">{{ formattedPageSummary.processingFee }}</td>
          <td class="text-end">{{ formattedPageSummary.receivedAmount }}</td>
          <td class="text-end">{{ formattedPageSummary.depositFee }}</td>
          <td colspan="13"></td>
        </tr>

        <tr class="total-summary">
          <td class="fw-bold text-start" colspan="10">Total Summary</td>
          <td class="text-end">{{ formattedTotalSummary.amount }}</td>
          <td class="text-end">{{ formattedTotalSummary.processingFee }}</td>
          <td class="text-end">{{ formattedTotalSummary.receivedAmount }}</td>
          <td class="text-end">{{ formattedTotalSummary.depositFee }}</td>
          <td colspan="13"></td>
        </tr>

        </tbody>
      </table>
    </div>
    <div class="mt-2 text-right" style="font-size: 12px; font-weight: 500;">
      Showing {{ startEntry }}-{{ endEntry }} of {{ totalEntries }} entries
    </div>
  </div>
</template>


<script setup>
import {computed, onMounted, ref} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import {CirclePlus, Download} from "lucide-vue-next";
import * as XLSX from "xlsx";
import Multiselect from "vue-multiselect";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";
import DepositModal from "@/views/DepositViews/Modals/DepositModal.vue";

dayjs.extend(utc);
dayjs.extend(isBetween);
const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}
const pageSummary = computed(() => {
  return filteredMembers.value.reduce(
      (acc, member) => {
        acc.amount += parseFloat(member.amount) || 0;
        acc.processingFee += parseFloat(member.processingFee) || 0;
        acc.receivedAmount += parseFloat(member.receivedAmount) || 0;
        acc.depositFee += parseFloat(member.depositFee) || 0;
        return acc;
      },
      { amount: 0, processingFee: 0, receivedAmount: 0, depositFee: 0 }
  );
});

const totalSummary = computed(() => {
  return members.value.reduce(
      (acc, member) => {
        acc.amount += parseFloat(member.amount) || 0;
        acc.processingFee += parseFloat(member.processingFee) || 0;
        acc.receivedAmount += parseFloat(member.receivedAmount) || 0;
        acc.depositFee += parseFloat(member.depositFee) || 0;
        return acc;
      },
      { amount: 0, processingFee: 0, receivedAmount: 0, depositFee: 0 }
  );
});

const formattedPageSummary = computed(() => ({
  amount: pageSummary.value.amount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  processingFee: pageSummary.value.processingFee.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  receivedAmount: pageSummary.value.receivedAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  depositFee: pageSummary.value.depositFee.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
}));

const formattedTotalSummary = computed(() => ({
  amount: totalSummary.value.amount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  processingFee: totalSummary.value.processingFee.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  receivedAmount: totalSummary.value.receivedAmount.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
  depositFee: totalSummary.value.depositFee.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }),
}));

const form = ref({
  merchant: "All",
  username: "",
  currency: "",
  paymentChannel: "All",
  createdAt: "",
  memberGroup: "All",
  status: "All",
  paymentMethod: "All",
  completedAt: "",
  risk: "All",
  orderId: "",
  affiliateUsername: "",
  timeZone: "GMT+0700",
  transactionID: "",
  referenceNumber: "",
  playerID: ""
});

const startEntry = computed(() => (filteredMembers.value.length > 0 ? 1 : 0));
const endEntry = computed(() => filteredMembers.value.length);
const totalEntries = computed(() => filteredMembers.value.length);

const currencies = ref(["BDT", "NPR"]);
const formattedDate = ref("");
const formattedTime = ref("");
const formattedDateAndTime = ref("");
const sortColumn = ref(null);
const sortOrder = ref("asc");
const selectedDateFilter = ref("All");

const updateDateTime = () => {
  const now = new Date();
  formattedDate.value = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, "0")}-${String(now.getDate()).padStart(2, "0")}`;
  formattedTime.value = `${String(now.getHours()).padStart(2, "0")}:${String(now.getMinutes()).padStart(2, "0")}`;
  formattedDateAndTime.value = `${formattedDate.value} ${formattedTime.value}`;
};

onMounted(() => {
  updateDateTime();
  setInterval(updateDateTime, 1000);
});

const members = ref([
  {
    orderId: 15600,
    paymentMethod: "bank_transfer",
    handler: "-",
    status: "Pending",
    username: "sakil280",
    playerID: "MAJUB56L7",
    phoneNumber: "0123456789",
    transactionID: "A1S5G8J6",
    referenceNumber: "-",
    currency: "BDT",
    amount: "600.00",
    processingFee: "0.00",
    receivedAmount: "600.00",
    depositFee: "0.00",
    memberName: "Sakil Islam",
    vipLevel: "VIP1",
    memberGroup: "Regular",
    affiliateUsername: "-",
    createdAt: "2025-03-25 12:00",
    processingAt: "-",
    completedAt: "-",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "Yes",
    merchant: "MJB",
    paymentChannel: "",
    timeZone: "GMT+0700",
  },
  {
    orderId: 15601,
    paymentMethod: "bank_transfer",
    handler: "-",
    status: "Active",
    username: "Shakib208",
    playerID: "MAJUO6321",
    phoneNumber: "0123456789",
    transactionID: "L2O5P6J3",
    referenceNumber: "-",
    currency: "BDT",
    amount: "1,000.00",
    processingFee: "0.00",
    receivedAmount: "1,000.00",
    depositFee: "0.00",
    memberName: "Shakib Razzaq",
    vipLevel: "VIP5",
    memberGroup: "Regular",
    affiliateUsername: "Ashk10789",
    createdAt: "2025-03-18 12:00",
    processingAt: "-",
    completedAt: "-",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "No",
    merchant: "MJB",
    paymentChannel: "",
    timeZone: "GMT+0700",
  },
  {
    orderId: 15602,
    paymentMethod: "bank_transfer",
    handler: "-",
    status: "Inactive",
    username: "Ahsan439",
    playerID: "MAJU3F5EG",
    phoneNumber: "0123456789",
    transactionID: "F5B2H6D6",
    referenceNumber: "-",
    currency: "BDT",
    amount: "1,000.00",
    processingFee: "0.00",
    receivedAmount: "1,000.00",
    depositFee: "0.00",
    memberName: "Ahsan Khan",
    vipLevel: "VIP3",
    memberGroup: "Regular",
    affiliateUsername: "-",
    createdAt: "2025-03-24 12:00",
    processingAt: "-",
    completedAt: "-",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "No",
    merchant: "MJB2",
    paymentChannel: "",
    timeZone: "GMT+0700",
  },
  {
    orderId: 15603,
    paymentMethod: "bank_transfer",
    handler: "-",
    status: "Pending",
    username: "Marwi23",
    playerID: "MAJU7K3C2",
    phoneNumber: "0123456789",
    transactionID: "X1R6F9H3",
    referenceNumber: "-",
    currency: "BDT",
    amount: "300.00",
    processingFee: "0.00",
    receivedAmount: "300.00",
    depositFee: "0.00",
    memberName: "Marwi Tahseen",
    vipLevel: "VIP2",
    memberGroup: "Regular",
    affiliateUsername: "Ashk10789",
    createdAt: "2025-03-26 12:00",
    processingAt: "-",
    completedAt: "-",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "No",
    merchant: "MJB3",
    paymentChannel: "Cash",
    timeZone: "GMT+0700",
  },
  {
    orderId: 15604,
    paymentMethod: "bank_transfer",
    handler: "-",
    status: "Pending",
    username: "Raj789",
    playerID: "MAJU6LP89",
    phoneNumber: "0123456789",
    transactionID: "A4T6N9M3",
    referenceNumber: "-",
    currency: "BDT",
    amount: "500.00",
    processingFee: "0.00",
    receivedAmount: "500.00",
    depositFee: "0.00",
    memberName: "Raj Sharma",
    vipLevel: "VIP4",
    memberGroup: "Regular",
    affiliateUsername: "aff123",
    createdAt: "2025-03-13 12:00",
    processingAt: "2025-03-13 13:00",
    completedAt: "-",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "No",
    merchant: "MJB2",
    paymentChannel: "Bank",
    timeZone: "GMT+0700",
  },
  {
    orderId: 15605,
    paymentMethod: "credit_card",
    handler: "-",
    status: "Active",
    username: "leila568",
    playerID: "MAJU1E2G5",
    phoneNumber: "9876543210",
    transactionID: "F5J6C3U6",
    referenceNumber: "-",
    currency: "BDT",
    amount: "1,000.00",
    processingFee: "0.00",
    receivedAmount: "1,000.00",
    depositFee: "0.00",
    memberName: "Leila Wasti",
    vipLevel: "VIP1",
    memberGroup: "Regular",
    affiliateUsername: "Ashk10789",
    createdAt: "2025-02-18 14:30",
    processingAt: "2025-02-18 15:00",
    completedAt: "2025-02-18 16:00",
    merchantBankHolder: "M/s Tawrat Enterprise",
    merchantBankName: "Nagad",
    merchantBankAccount: "012345678925",
    adminRemark: "-",
    applyBy: "-",
    risk: "No",
    merchant: "MJB",
    paymentChannel: "Bank",
    timeZone: "GMT+0700",
  }
]);

const filteredMembers = computed(() => {
  return members.value.filter(member => {
    const updatedAt = dayjs.utc(member.createdAt, "YYYY-MM-DD HH:mm").local();

    let today = dayjs().startOf("day");
    let startDate, endDate;

    switch (selectedDateFilter.value) {
      case "Today":
        startDate = today.startOf("day");
        endDate = today.endOf("day");
        break;
      case "Yesterday":
        startDate = today.subtract(1, "day").startOf("day");
        endDate = today.subtract(1, "day").endOf("day");
        break;
      case "This Week":
        startDate = today.startOf("week");
        endDate = today.endOf("week");
        break;
      case "Last Week":
        startDate = today.startOf("week").subtract(1, "week");
        endDate = today.startOf("week").subtract(1, "day").endOf("day");
        break;
      case "This Month":
        startDate = today.startOf("month");
        endDate = today.endOf("month");
        break;
      case "Last Month":
        startDate = today.startOf("month").subtract(1, "month");
        endDate = today.startOf("month").subtract(1, "day").endOf("day");
        break;
      default:
        startDate = null;
        endDate = null;
    }

    const isDateInRange = startDate && endDate
        ? updatedAt.isBetween(startDate, endDate, null, "[]")
        : true;

    return (
        isDateInRange &&
        (form.value.merchant === "All" || member.merchant === form.value.merchant) &&
        (form.value.status === "All" || member.status === form.value.status) &&
        (form.value.username === "" || member.username.toLowerCase().includes(form.value.username.toLowerCase())) &&
        (form.value.paymentChannel === "All" || member.paymentChannel === form.value.paymentChannel) &&
        (form.value.paymentMethod === "All" || member.paymentMethod === form.value.paymentMethod) &&
        (form.value.memberGroup === "All" || member.memberGroup === form.value.memberGroup) &&
        (form.value.risk === "All" || member.risk === form.value.risk) &&
        (form.value.orderId === "" || member.orderId.toString().includes(form.value.orderId.toString())) &&
        (form.value.affiliateUsername === "" || (member.affiliateUsername &&
            member.affiliateUsername.toLowerCase().includes(form.value.affiliateUsername.toLowerCase()))) &&
        (form.value.timeZone === "" || member.timeZone === form.value.timeZone) &&
        (form.value.transactionID === "" || (member.transactionID &&
            member.transactionID.toLowerCase().includes(form.value.transactionID.toLowerCase()))) &&
        (form.value.referenceNumber === "" || (member.referenceNumber &&
            member.referenceNumber.toLowerCase().includes(form.value.referenceNumber.toLowerCase()))) &&
        (form.value.playerID === "" || (member.playerID &&
            member.playerID.toLowerCase().includes(form.value.playerID.toLowerCase()))) &&
        (form.value.createdAt === "" ||
            dayjs(member.createdAt).isAfter(dayjs(form.value.createdAt).subtract(1, "day"))) &&
        (form.value.completedAt === "" || dayjs(member.completedAt).isBefore(dayjs(form.value.completedAt).add(1, "day")))
        );
  }).sort((a, b) => {
    if (!sortColumn.value) return 0;
    let valA = a[sortColumn.value];
    let valB = b[sortColumn.value];

    if (typeof valA === "string") valA = valA.toLowerCase();
    if (typeof valB === "string") valB = valB.toLowerCase();

    return sortOrder.value === "asc" ? (valA > valB ? 1 : -1) : (valA < valB ? 1 : -1);
  });
});

const filterByDateRange = (filter) => {
  selectedDateFilter.value = filter;
};

const sortTable = (column) => {
  if (sortColumn.value === column) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortColumn.value = column;
    sortOrder.value = "asc";
  }
};

const clearForm = () => {
  form.value.merchant = "All";
  form.value.username = "";
  form.value.currency = "";
  form.value.paymentChannel = "All";
  form.value.memberGroup = "All";
  form.value.status = "All";
  form.value.paymentMethod = "All";
  form.value.orderID = "";
  form.value.affiliateUsername = "";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.risk = "All";
  form.value.transactionID = "";
  form.value.referenceNumber = "";
  form.value.playerID = "";
  form.value.timeZone = "GMT+0700";
  selectedDateFilter.value = "All";
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({ orderId, paymentMethod, handler, status, username, playerID, phoneNumber,
                                            transactionID, referenceNumber, currency, amount, processingFee,
                                            receivedAmount, depositFee, memberName, vipLevel, memberGroup,
                                            affiliateUsername, createdAt, processingAt, completedAt, merchantBankHolder,
                                            merchantBankName, merchantBankAccount, adminRemark, applyBy, risk
                                          }) => ({
    "Order ID": orderId,
    "Payment Method": paymentMethod,
    "Handler": handler,
    "Status": status,
    "Username": username,
    "Player ID": playerID,
    "Phone Number": phoneNumber,
    "Transaction ID": transactionID,
    "Reference Number": referenceNumber,
    "Currency": currency,
    "Amount": amount,
    "Processing Fee": processingFee,
    "Received Amount": receivedAmount,
    "Deposit Fee": depositFee,
    "Member Name": memberName,
    "VIP Level": vipLevel,
    "Member Group": memberGroup,
    "Affiliate Username": affiliateUsername,
    "Created At": createdAt,
    "Processing At": processingAt,
    "Completed At": completedAt,
    "Merchant Bank Holder": merchantBankHolder,
    "Merchant Bank Name": merchantBankName,
    "Merchant Bank Account": merchantBankAccount,
    "Admin Remark": adminRemark,
    "Apply By": applyBy,
    "Risk": risk
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Deposit");
  XLSX.writeFile(workbook, "deposit.xlsx");
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

.table {
  width: 100%;
  margin-top: 10px;
}

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #fff8f8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
  cursor: pointer;
  user-select: none;
}

td {
  font-size: 12px;
  font-weight: 500;
  color: #2c2c2c;
}

tr:hover td {
  background: #fde2c1;
}

.badge {
  padding: 5px 8px;
  border-radius: 10px;
}

.export-btn {
  padding: 8px 23px;
  font-size: 13px;
  font-weight: 600;
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

.page-summary td {
  background-color: #c4ffc4 !important;
}

.total-summary td {
  background-color: #fae09f !important;
}
</style>