<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Affiliate Comm</h2>
      <p class="breadcrumb">Affiliate Comm > <strong>Affiliate Deposit</strong></p>
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
        <label>Affiliate Username</label>
        <input type="text" v-model="form.affiliateUsername" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate Name</label>
        <input type="text" v-model="form.affiliateName" class="form-control">
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
        <select v-model="form.paymentType" class="form-select" placeholder="Please Select Payment Method">
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
        <label>End Date</label>
        <input type="date" v-model="form.completedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Merchant Bank Name</label>
        <select v-model="form.merchantBankName" class="form-select" placeholder="Please Select Member Group">
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
    </div>

    <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'Today'}"
              @click="filterByDateRange('Today')">Today
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'Yesterday'}"
              @click="filterByDateRange('Yesterday')">
        Yesterday
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'This Week'}"
              @click="filterByDateRange('This Week')">This
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'Last Week'}"
              @click="filterByDateRange('Last Week')">Last
        Week
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'This Month'}"
              @click="filterByDateRange('This Month')">This
        Month
      </button>
      <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
              :class="{'btn-active': activeRange === 'Last Month'}"
              @click="filterByDateRange('Last Month')">Last
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
          <th @click="sortTable('id')">ID <span
              v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('paymentMethod')">Payment Method <span
              v-if="sortColumn === 'paymentMethod'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('affiliateUsername')">Affiliate Username <span
              v-if="sortColumn === 'affiliateUsername'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('amount')">Amount <span
              v-if="sortColumn === 'amount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('affiliateGroup')">AffiliateGroup <span
              v-if="sortColumn === 'affiliateGroup'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('processingFee')">Processing Fee <span
              v-if="sortColumn === 'processingFee'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('confirmedAmount')">Confirmed Amount <span
              v-if="sortColumn === 'confirmedAmount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('merchantBankAccount')">Merchant Bank Account <span
              v-if="sortColumn === 'merchantBankAccount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Remark</th>
          <th @click="sortTable('approvalRejectedRemark')">Approval/Rejected Remark <span
              v-if="sortColumn === 'approvalRejectedRemark'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdAt')">Apply Time<span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('completedAt')">Process Time <span
              v-if="sortColumn === 'completedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('handler')">Handler <span
              v-if="sortColumn === 'handler'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.id }}</td>
          <td>{{ member.paymentMethod }}</td>
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
          <td><a href="#" style="color: #787445">{{ member.affiliateUsername }}</a></td>
          <td>{{ member.currency }}</td>
          <td>{{ member.amount }}</td>
          <td>{{ member.affiliateGroup }}</td>
          <td>{{ member.processingFee }}</td>
          <td>{{ member.confirmedAmount }}</td>
          <td>{{ member.merchantBankAccount }}</td>
          <td>{{ member.remark }}</td>
          <td>{{ member.approvalRejectedRemark }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.completedAt }}</td>
          <td>{{ member.handler }}</td>
        </tr>
        <tr v-if="filteredMembers.length === 0">
          <td colspan="15" class="text-center">No results found for the applied filters.</td>
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
import {Download} from "lucide-vue-next";
import * as XLSX from "xlsx";
import Multiselect from "vue-multiselect";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";

dayjs.extend(utc);
dayjs.extend(isBetween);

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

const selectedDateFilter = ref("All");

const form = ref({
  merchant: "All",
  affiliateUsername: "",
  affiliateName: "",
  currency: ["BDT", "NPR"],
  paymentType: "All",
  createdAt: firstDay,
  completedAt: today,
  merchantBankName: "All",
  status: "All",
});

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

const startEntry = computed(() => (filteredMembers.value.length > 0 ? 1 : 0));
const endEntry = computed(() => filteredMembers.value.length);
const totalEntries = computed(() => filteredMembers.value.length);

const currencies = ref(["BDT", "NPR"]);
const formattedDate = ref("");
const formattedTime = ref("");
const formattedDateAndTime = ref("");
const sortColumn = ref(null);
const sortOrder = ref("asc");

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
    id: 15600,
    paymentMethod: "bank_transfer",
    status: "Pending",
    affiliateUsername: "sakil280",
    currency: "BDT",
    amount: "600.00",
    affiliateGroup: "MAJUB56L7",
    processingFee: "0.00",
    confirmedAmount: "600.00",
    merchantBankAccount: "012345678925",
    remark: "-",
    approvalRejectedRemark: "-",
    createdAt: "2025-05-25 12:00",
    completedAt: "2025-05-25 12:00",
    handler: "Sakil Islam",
  },
  {
    id: 15601,
    paymentMethod: "bank_transfer",
    status: "Active",
    affiliateUsername: "Ashk10789",
    affiliateGroup: "Ashk10789",
    currency: "BDT",
    amount: "1,000.00",
    processingFee: "0.00",
    confirmedAmount: "1,000.00",
    merchantBankAccount: "012345678925",
    remark: "-",
    approvalRejectedRemark: "-",
    createdAt: "2025-05-18 12:00",
    completedAt: "2025-05-18 12:00",
    handler: "Nagad",
  }
]);

const filteredMembers = computed(() => {
  return members.value.filter((member) => {
    const startDate = form.value.createdAt ? dayjs(form.value.createdAt) : null;
    const endDate = form.value.completedAt ? dayjs(form.value.completedAt) : null;
    const updatedAt = dayjs(member.createdAt);

    const isDateInRange =
        startDate && endDate
            ? updatedAt.isBetween(startDate, endDate, null, "[]")
            : true;

    return (
        isDateInRange &&
        (form.value.merchant === "All" || member.merchant === form.value.merchant) &&
        (form.value.status === "All" || member.status === form.value.status) &&
        (form.value.affiliateUsername === "" || member.affiliateUsername.toLowerCase().includes(form.value.affiliateUsername.toLowerCase())) &&
        (form.value.paymentType === "All" || member.paymentMethod === form.value.paymentType) &&
        (form.value.currency.length === 0 || form.value.currency.includes(member.currency)) &&
        (form.value.merchantBankName === "All" || member.affiliateGroup === form.value.merchantBankName)
    );
  }).sort((a, b) => {
    if (!sortColumn.value) return 0;
    let valA = a[sortColumn.value];
    let valB = b[sortColumn.value];

    if (typeof valA === "string") valA = valA.toLowerCase();
    if (typeof valB === "string") valB = valB.toLowerCase();

    if (valA < valB) return sortOrder.value === "asc" ? -1 : 1;
    if (valA > valB) return sortOrder.value === "asc" ? 1 : -1;
    return 0;
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

const clearForm = () => {
  form.value.merchant = "All";
  form.value.affiliateUsername = "";
  form.value.affiliateName = "";
  form.value.currency = ["BDT", "NPR"];
  form.value.paymentType = "All";
  form.value.merchantBankName = "All";
  form.value.status = "All";
  form.value.createdAt = firstDay;
  form.value.completedAt = today;
  selectedDateFilter.value = "All";
  activeRange.value = 'This Month';
};

const activeRange = ref('This Month');

const exportToExcel = () => {
  const data = filteredMembers.value.map(({ id, paymentMethod, handler, status, affiliateUsername, currency, amount, processingFee, confirmedAmount, merchantBankAccount, remark, approvalRejectedRemark, createdAt, completedAt }) => ({
    ID: id,
    "Payment Method": paymentMethod,
    Status: status,
    "Affiliate Username": affiliateUsername,
    Currency: currency,
    Amount: amount,
    "Processing Fee": processingFee,
    "Confirmed Amount": confirmedAmount,
    "Merchant Bank Account": merchantBankAccount,
    Remark: remark,
    "Approval/Rejected Remark": approvalRejectedRemark,
    "Apply Time": createdAt,
    "Process Time": completedAt,
    Handler: handler,
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Affiliate Deposits");
  XLSX.writeFile(workbook, `Affiliate_Deposits_${formattedDate.value}.xlsx`);
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

.btn-active {
  border: 1px solid #f4c938 !important;
  color: #f4c938 !important;
  background: #faeecd !important;
}
</style>