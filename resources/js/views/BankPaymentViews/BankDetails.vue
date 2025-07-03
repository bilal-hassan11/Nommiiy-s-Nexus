<template>
  <BankDetailModal v-model="showBankDetailModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">Bank/Payment</h2>
      <p class="breadcrumb">Bank/Payment > <strong>Bank Details</strong></p>
    </div>
    <div class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
      @click="showBankDetailModal = true">
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
        <label>Start Date</label>
        <input type="date" v-model="form.createdAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Transaction Type</label>
        <select v-model="form.transactionType" class="form-select">
          <option value="All">All</option>
          <option>Deposit</option>
          <option>Withdrawal</option>
          <option>Transfer</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Payment Method</label>
        <select v-model="form.paymentMethod" class="form-select" placeholder="Please Select Payment Method">
          <option value="" disabled selected>Please Select Payment Method</option>
          <option>All</option>
          <option>Bank Transfer</option>
          <option>Online Transfer</option>
          <option>Cheque</option>
          <option>Mobile Banking</option>
        </select>
      </div>

      <div class="col-md-6 col-lg-3">
        <label>Account Number</label>
        <input type="text" v-model="form.accountNumber" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>
      <!-- Date Range Column -->
      <div class="col-lg-12 col-md-8 col-sm-12 d-flex flex-column mt-3">
        <label style="font-size: 12px; font-weight: 500; margin-bottom: 5px;">Date Range</label>
        <div class="d-flex flex-wrap align-items-center gap-2">
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Today'}"
                  @click="filterByDateRange('Today')">Today
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Yesterday'}"
                  @click="filterByDateRange('Yesterday')">Yesterday
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'This Week'}"
                  @click="filterByDateRange('This Week')">This Week
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Last Week'}"
                  @click="filterByDateRange('Last Week')">Last Week
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'This Month'}"
                  @click="filterByDateRange('This Month')">This Month
          </button>
          <button class="recent btn btn-light" :class="{'btn-active': activeRange === 'Last Month'}"
                  @click="filterByDateRange('Last Month')">Last Month
          </button>
        </div>
      </div>
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
    <!-- Summary Totals -->
    <div class="d-flex align-items-center gap-2" style="font-size: 14px">
      <strong>Current Page Total:</strong>
      <span>Income</span>
      <span class="badge rounded-pill border border-success bg-success-subtle text-success px-3 py-2">0.00</span>
      <strong>Expenses:</strong>
      <span class="badge rounded-pill border border-danger bg-danger-subtle text-danger px-3 py-2">0.00</span>
    </div>

    <!-- Current Search Total -->
    <div class="d-flex align-items-center gap-2" style="font-size: 14px">
      <strong>Current Search Total:</strong>
      <span>Income</span>
      <span class="badge rounded-pill border border-success bg-success-subtle text-success px-3 py-2">0.00</span>
      <strong>Expenses:</strong>
      <span class="badge rounded-pill border border-danger bg-danger-subtle text-danger px-3 py-2">0.00</span>
    </div>

    <!-- Table Section -->
    <div class="table-responsive mt-3">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('transactionId')">Transaction ID <span
              v-if="sortColumn === 'transactionId'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('bankId')">Bank ID <span
              v-if="sortColumn === 'bankId'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('bankName')">Bank Name <span
              v-if="sortColumn === 'bankName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('bankCode')">Bank Code <span
              v-if="sortColumn === 'bankCode'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('paymentMethod')">Payment Method <span
              v-if="sortColumn === 'paymentMethod'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('bankBranch')">Bank Branch <span
              v-if="sortColumn === 'bankBranch'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('accountNumber')">Account Number <span
              v-if="sortColumn === 'accountNumber'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('accountName')">Account Name <span
              v-if="sortColumn === 'accountName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('transactionType')">Transaction Type <span
              v-if="sortColumn === 'transactionType'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('amountCredit')">Amount Credit <span
              v-if="sortColumn === 'amountCredit'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('amountDebit')">Amount Debit <span
              v-if="sortColumn === 'amountDebit'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('balance')">Balance <span
              v-if="sortColumn === 'balance'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('processingFee')">Processing Fee <span
              v-if="sortColumn === 'processingFee'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('depositFeeAmount')">Deposit Fee Amount <span
              v-if="sortColumn === 'depositFeeAmount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('withdrawFeeAmount')">Withdraw Fee Amount <span
              v-if="sortColumn === 'withdrawFeeAmount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Remark</th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('tradeTime')">Trade Time <span
              v-if="sortColumn === 'tradeTime'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdAt')">Created At <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdBy')">Created By <span
              v-if="sortColumn === 'createdBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in paginatedMembers" :key="index">
          <td>{{ member.transactionId }}</td>
          <td>{{ member.bankId }}</td>
          <td>{{ member.bankName }}</td>
          <td>{{ member.bankCode }}</td>
          <td>{{ member.paymentMethod }}</td>
          <td>{{ member.bankBranch }}</td>
          <td>{{ member.accountNumber }}</td>
          <td>{{ member.accountName }}</td>
          <td>{{ member.transactionType }}</td>
          <td>{{ member.currency }}</td>
          <td>{{ member.amountCredit }}</td>
          <td>{{ member.amountDebit }}</td>
          <td>{{ member.balance }}</td>
          <td>{{ member.processingFee }}</td>
          <td>{{ member.depositFeeAmount }}</td>
          <td>{{ member.withdrawFeeAmount }}</td>
          <td>{{ member.remark }}</td>
          <td>
            <span
                :class="{
                'badge border border-success text-success': member.status === 'Active',
                'badge border border-danger text-danger': member.status === 'Inactive',
                'badge border border-warning text-warning': member.status === 'Pending',
                'badge border border-primary text-primary': member.status === 'Completed'
              }">
              {{ member.status }}
            </span>
          </td>
          <td>{{ member.tradeTime }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.createdBy }}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div class="row d-flex align-items-center" style="font-size: 12px; font-weight: 500;">
      <div class="col-lg-8 col-md-12 mt-2 text-left">
        Showing {{ startEntry }}-{{ endEntry }} of {{ totalEntries }} entries
      </div>
      <div class="col-lg-4 col-md-12 mt-2 text-left ml-auto d-flex justify-content-end">
        <button
            class="btn btn-outline-warning page-btn"
            :disabled="currentPage === 1"
            @click="changePage(currentPage - 1)"
        >
          «
        </button>

        <button
            v-for="page in totalPages"
            :key="page"
            class="btn btn-outline-warning page-btn mx-1"
            :class="{ active: currentPage === page }"
            @click="changePage(page)"
        >
          {{ page }}
        </button>

        <button
            class="btn btn-outline-warning page-btn"
            :disabled="currentPage === totalPages"
            @click="changePage(currentPage + 1)"
        >
          »
        </button>
      </div>
    </div>
  </div>
</template>


<script setup>
import {computed, ref} from "vue";
import {CirclePlus, Download} from "lucide-vue-next";
import * as XLSX from "xlsx";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import BankDetailModal from "@/views/BankPaymentViews/modals/BankDetailModal.vue";


const showBankDetailModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

dayjs.extend(utc);
dayjs.extend(isBetween);

const selectedDateFilter = ref("All");
const getDefaultDates = () => {
  const today = new Date();
  const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  };

  return {
    firstDay: formatDate(firstDay),
    today: formatDate(today),
  };
};

const {firstDay, today} = getDefaultDates();
const currencies = ref(["BDT", "NPR"]);
const form = ref({
  merchant: "MJB",
  currency: ["BDT", "NPR"],
  transactionType: "All",
  paymentMethod: "",
  createdAt: firstDay,
  completedAt: today,
  accountNumber: "",
  timeZone: "GMT+0700",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.currency = ["BDT", "NPR"];
  form.value.transactionType = "All";
  form.value.paymentMethod = "";
  form.value.createdAt = firstDay;
  form.value.completedAt = today;
  form.value.timeZone = "GMT+0700";
  form.value.accountNumber = "";
  selectedDateFilter.value = "All";
  activeRange.value = 'This Month';
};

const activeRange = ref('This Month');

const filterByDateRange = (range) => {
  activeRange.value = range;
  const today = new Date();

  const formatDate = (date) => {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  };

  if (range === 'Today') {
    form.value.createdAt = formatDate(today);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Yesterday') {
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);
    form.value.createdAt = formatDate(yesterday);
    form.value.completedAt = formatDate(yesterday);
  } else if (range === 'This Week') {
    const firstDayOfWeek = new Date(today);
    firstDayOfWeek.setDate(today.getDate() - today.getDay() + 1);
    form.value.createdAt = formatDate(firstDayOfWeek);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Last Week') {
    const lastWeekEnd = new Date(today);
    lastWeekEnd.setDate(today.getDate() - today.getDay());
    const lastWeekStart = new Date(lastWeekEnd);
    lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
    form.value.createdAt = formatDate(lastWeekStart);
    form.value.completedAt = formatDate(lastWeekEnd);
  } else if (range === 'This Month') {
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    form.value.createdAt = formatDate(firstDayOfMonth);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Last Month') {
    const firstDayLastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
    const lastDayLastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
    form.value.createdAt = formatDate(firstDayLastMonth);
    form.value.completedAt = formatDate(lastDayLastMonth);
  }
};

const sortColumn = ref(null);
const sortOrder = ref("asc");

const members = ref([
  {
    transactionId: 1,
    bankId: 101,
    bankName: "XYZ Bank",
    bankCode: "XYZ001",
    paymentMethod: "Bank Transfer",
    bankBranch: "Gulshan Branch",
    accountNumber: "1234567890123456",
    accountName: "John Doe",
    transactionType: "Deposit",
    currency: "BDT",
    amountCredit: 5000.00,
    amountDebit: 0.00,
    balance: 15000.00,
    processingFee: 50.00,
    depositFeeAmount: 20.00,
    withdrawFeeAmount: 0.00,
    remark: "Deposit made via mobile banking - verified successfully.",
    status: "Active",
    tradeTime: "2025-05-01 11:45:00",
    createdBy: "admin_user_001",
    createdAt: "2025-05-01 12:00:00",
    completedAt: "2025-05-01 12:05:00",
    timeZone: "GMT+0700"
  },
  {
    transactionId: 2,
    bankId: 102,
    bankName: "ABC Bank",
    bankCode: "ABC045",
    paymentMethod: "Online Transfer",
    bankBranch: "Dhanmondi Branch",
    accountNumber: "9876543210987654",
    accountName: "Sarah Ahmed",
    transactionType: "Withdrawal",
    currency: "BDT",
    amountCredit: 0.00,
    amountDebit: 2000.00,
    balance: 8000.00,
    processingFee: 30.00,
    depositFeeAmount: 0.00,
    withdrawFeeAmount: 25.00,
    remark: "Withdrawal via web portal - under review.",
    status: "Pending",
    tradeTime: "2025-05-02 09:30:00",
    createdBy: "admin_user_002",
    createdAt: "2025-05-02 09:35:00",
    completedAt: null,
    timeZone: "GMT+0700"
  },
  {
    transactionId: 3,
    bankId: 103,
    bankName: "Delta Financial",
    bankCode: "DF999",
    paymentMethod: "Cheque",
    bankBranch: "Karwan Bazar",
    accountNumber: "1122334455667788",
    accountName: "Mizanur Rahman",
    transactionType: "Deposit",
    currency: "BDT",
    amountCredit: 10000.00,
    amountDebit: 0.00,
    balance: 21000.00,
    processingFee: 75.00,
    depositFeeAmount: 50.00,
    withdrawFeeAmount: 0.00,
    remark: "Cheque cleared successfully.",
    status: "Inactive",
    tradeTime: "2025-05-03 15:10:00",
    createdBy: "admin_user_003",
    createdAt: "2025-05-03 15:15:00",
    completedAt: "2025-05-03 15:25:00",
    timeZone: "GMT+0700"
  },
  {
    transactionId: 4,
    bankId: 104,
    bankName: "First National Bank",
    bankCode: "FNB101",
    paymentMethod: "Mobile Banking",
    bankBranch: "Mirpur",
    accountNumber: "5566778899001122",
    accountName: "Nusrat Jahan",
    transactionType: "Transfer",
    currency: "BDT",
    amountCredit: 0.00,
    amountDebit: 1500.00,
    balance: 6500.00,
    processingFee: 20.00,
    depositFeeAmount: 0.00,
    withdrawFeeAmount: 10.00,
    remark: "Transferred to savings account.",
    status: "Completed",
    tradeTime: "2025-05-04 10:00:00",
    createdBy: "admin_user_004",
    createdAt: "2025-05-04 10:05:00",
    completedAt: "2025-05-04 10:06:00",
    timeZone: "GMT+0700"
  },
  {
    transactionId: 5,
    bankId: 105,
    bankName: "Unity Bank",
    bankCode: "UB700",
    paymentMethod: "ATM",
    bankBranch: "Banani",
    accountNumber: "3344556677889900",
    accountName: "Rehan Khan",
    transactionType: "Withdrawal",
    currency: "BDT",
    amountCredit: 0.00,
    amountDebit: 3000.00,
    balance: 10000.00,
    processingFee: 40.00,
    depositFeeAmount: 0.00,
    withdrawFeeAmount: 30.00,
    remark: "ATM cash out - verified.",
    status: "Active",
    tradeTime: "2025-05-05 17:45:00",
    createdBy: "admin_user_005",
    createdAt: "2025-05-05 17:50:00",
    completedAt: "2025-05-05 17:55:00",
    timeZone: "GMT+0700"
  },
  {
    transactionId: 6,
    bankId: 106,
    bankName: "Greenline Bank",
    bankCode: "GL123",
    paymentMethod: "Bank Transfer",
    bankBranch: "Motijheel",
    accountNumber: "9988776655443322",
    accountName: "Tania Islam",
    transactionType: "Deposit",
    currency: "BDT",
    amountCredit: 7500.00,
    amountDebit: 0.00,
    balance: 13500.00,
    processingFee: 60.00,
    depositFeeAmount: 35.00,
    withdrawFeeAmount: 0.00,
    remark: "Transfer from external account - processing.",
    status: "Active",
    tradeTime: "2025-05-05 08:15:00",
    createdBy: "admin_user_006",
    createdAt: "2025-05-05 08:20:00",
    completedAt: null,
    timeZone: "GMT+0700"
  }
]);

const filteredMembers = computed(() => {
  return members.value.filter((member) => {
    const matchesTransactionType = form.value.transactionType === "All" || member.transactionType === form.value.transactionType;
    const matchesPaymentMethod = form.value.paymentMethod === "" || member.paymentMethod === form.value.paymentMethod;
    const matchesAccountNumber = !form.value.accountNumber || member.accountNumber.includes(form.value.accountNumber.trim());
    const matchesTimeZone = form.value.timeZone === "GMT+0700" || member.timeZone === form.value.timeZone;

    let matchesDate = true;
    if (form.value.createdAt && form.value.completedAt) {
      const createdAt = new Date(member.createdAt);
      const filterStart = new Date(form.value.createdAt);
      const filterEnd = new Date(form.value.completedAt);

      // Normalize time to ignore time part for accurate filtering
      createdAt.setHours(0, 0, 0, 0);
      filterStart.setHours(0, 0, 0, 0);
      filterEnd.setHours(23, 59, 59, 999);
      matchesDate = createdAt >= filterStart && createdAt <= filterEnd;
    }
    return matchesTransactionType && matchesPaymentMethod && matchesAccountNumber && matchesDate && matchesTimeZone;
  });
});


const sortTable = (column) => {
  if (sortColumn.value === column) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortColumn.value = column;
    sortOrder.value = "asc";
  }
};

const currentPage = ref(1);
const itemsPerPage = 4;

const totalPages = computed(() =>
    Math.ceil(filteredMembers.value.length / itemsPerPage)
);

const paginatedMembers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredMembers.value.slice(start, end);
});

const startEntry = computed(() => {
  if (filteredMembers.value.length === 0) return 0;
  return (currentPage.value - 1) * itemsPerPage + 1;
});

const endEntry = computed(() => {
  const end = currentPage.value * itemsPerPage;
  return end > filteredMembers.value.length
      ? filteredMembers.value.length
      : end;
});

const totalEntries = computed(() => filteredMembers.value.length);

const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({
                                            transactionId,
                                            bankId,
                                            bankName,
                                            bankCode,
                                            paymentMethod,
                                            bankBranch,
                                            accountNumber,
                                            accountName,
                                            transactionType,
                                            currency,
                                            amountCredit,
                                            amountDebit,
                                            balance,
                                            processingFee,
                                            depositFeeAmount,
                                            withdrawFeeAmount,
                                            remark,
                                            status,
                                            tradeTime,
                                            createdBy,
                                            createdAt,
                                            completedAt,
                                            timeZone
                                          }) => ({
    "Transaction ID": transactionId,
    "Bank ID": bankId,
    "Bank Name": bankName,
    "Bank Code": bankCode,
    "Payment Method": paymentMethod,
    "Bank Branch": bankBranch,
    "Account Number": accountNumber,
    "Account Name": accountName,
    "Transaction Type": transactionType,
    "Currency": currency,
    "Amount Credit": amountCredit,
    "Amount Debit": amountDebit,
    "Balance": balance,
    "Processing Fee": processingFee,
    "Deposit Fee": depositFeeAmount,
    "Withdraw Fee": withdrawFeeAmount,
    "Remark": remark,
    "Status": status,
    "Trade Time": tradeTime,
    "Created By": createdBy,
    "Created At": createdAt,
    "Completed At": completedAt,
    "Time Zone": timeZone
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Transactions");
  XLSX.writeFile(workbook, "transactions.xlsx");
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

.btn-active {
  border: 1px solid #f4c938 !important;
  color: #f4c938 !important;
  background: #faeecd !important;
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
  background-color: #faf1e8;
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


.page-btn {
  font-size: 10px;
  background: #fae09f;
  color: #2c2c2c;
  padding: 10px 10px;
  border: none;
  border-radius: 2px;
  margin-left: 3px;
  margin-right: 3px;
}

.page-btn:hover {
  background: #ffd15b;
}

.page-btn.active {
  background-color: #ffc107;
  color: black;
  font-weight: bold;
  border-color: #ffc107;
}

</style>