<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Promotion</h2>
      <p class="breadcrumb">Promotion > <strong>Member Promotions</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <!-- Row 1 -->
      <div class="col-md-6 col-lg-3">
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Provider</label>
        <select v-model="form.provider" class="form-select">
          <option>All</option>
          <option>Bank</option>
          <option>Cash</option>
        </select>
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
        <label>Promotion Code</label>
        <input type="text" v-model="form.promotionCode" class="form-control">
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
    </div>
    <div class="row mt-3">
      <div class="col-auto d-flex align-items-center">
        <input type="radio" name="sound" id="createdDate" checked class="me-2"/>
        <label for="createdDate" class="sound-options mb-0">Created Date</label>
      </div>
    </div>
    <div class="row">
      <div class="col-auto d-flex align-items-center">
        <input type="radio" name="sound" id="modifiedDate" class="me-2"/>
        <label for="modifiedDate" class="sound-options mb-0">Last Modified Date</label>
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
          <th @click="sortTable('Id')">ID <span
              v-if="sortColumn === 'Id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('affiliate')">Affiliate <span
              v-if="sortColumn === 'affiliate'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('username')">Username <span
              v-if="sortColumn === 'username'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('balance')">Balance <span
              v-if="sortColumn === 'balance'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('provider')" style="min-width: 180px;">Provider <span
              v-if="sortColumn === 'provider'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('promotionCode')">Promotion Code <span
              v-if="sortColumn === 'promotionCOde'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('createdAt')">Start Time <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('completedAt')">End Time <span
              v-if="sortColumn === 'completedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('lastDeposit')">Last Deposit <span
              v-if="sortColumn === 'lastDeposit'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('transferAmount')">Transfer Amount <span
              v-if="sortColumn === 'transferAmount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('target')">Target <span
              v-if="sortColumn === 'target'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('minimumDeposit')">Minimum Deposit <span
              v-if="sortColumn === 'minimumDeposit'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('currentWinLoss')">Current Win Loss <span
              v-if="sortColumn === 'currentWinLoss'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('source')">Source <span
              v-if="sortColumn === 'source'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th>Remark</th>

          <th @click="sortTable('IP')">IP <span
              v-if="sortColumn === 'IP'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('lastModifiedBy')">Last Modified By <span
              v-if="sortColumn === 'lastModifiedBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th @click="sortTable('lastModifiedDate')">Last Modified Date <span
              v-if="sortColumn === 'lastModifiedDate'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>

          <th class="sticky-end" style="right: 0; z-index: 2;">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.Id }}</td>
          <td>{{ member.affiliate }}</td>
          <td><a href="#" style="color: #787445">{{ member.username }}</a></td>
          <td>{{ member.currency }}</td>
          <td>{{ member.balance }}</td>
          <td style="min-width: 180px;">{{ member.provider }}</td>
          <td>{{ member.promotionCode }}</td>
          <td>
            <span
                :class="{
                'badge border border-success text-success': member.status === 'Active',
                'badge border border-danger text-danger': member.status === 'Inactive',
                'badge border border-warning text-warning': member.status === 'Pending',
                'badge border border-primary text-primary': member.status === 'Unlocked'
              }">
              {{ member.status }}
            </span>
          </td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.completedAt }}</td>
          <td>{{ member.lastDeposit }}</td>
          <td>{{ member.transferAmount }}</td>
          <td>{{ member.target }}</td>
          <td>{{ member.minimumDeposit }}</td>
          <td>
            <span :class="{
              'text-success': parseFloat(member.currentWinLoss.replace(/,/g, '')) > 0,
              'text-danger': parseFloat(member.currentWinLoss.replace(/,/g, '')) < 0
            }">
              {{ member.currentWinLoss }}
            </span>
          </td>
          <td>{{ member.source }}</td>
          <td>{{ member.remark }}</td>
          <td>{{ member.IP }}</td>
          <td>{{ member.lastModifiedBy }}</td>
          <td>{{ member.lastModifiedDate }}</td>
          <td class="sticky-end bg-white" style="right: 0;">
            <div class="d-flex gap-2">
              <button class="btn btn-sm bg-white p-1">
                <Key size="16" stroke-width="2" style="color: #5a5858"/>
              </button>
              <button class="btn btn-sm bg-white p-1">
                <CircleX size="16" stroke-width="2" style="color: #e8e8e8; background: #d33c3c; border-radius: 50px"/>
              </button>
              <button class="btn btn-sm bg-white p-1">
                <Stamp size="16" stroke-width="2" style="color: #5a5858"/>
              </button>
            </div>
          </td>
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
import {Key, Download, CircleX, Stamp} from "lucide-vue-next";
import * as XLSX from "xlsx";
import Multiselect from "vue-multiselect";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";

dayjs.extend(utc);
dayjs.extend(isBetween);

const form = ref({
  username: "",
  provider: "All",
  status: "All",
  currency: "",
  createdAt: "",
  completedAt: "",
  promotionCode: "",
  merchant: "All",
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
    Id: 2723,
    affiliate: "-",
    username: "robin4321",
    currency: "BDT",
    balance: "501.25",
    provider: "Lorem Ipsum is simply cash text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Active",
    createdAt: "2025-03-18",
    completedAt: "2025-03-18 16:00",
    lastDeposit: "500.00",
    transferAmount: "0.00 +500.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +500.00",
    currentWinLoss: "-441.25",
    source: "member",
    remark: "-",
    IP: "253.163.157.73",
    lastModifiedBy: "-",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
  },
  {
    Id: 2724,
    affiliate: "-",
    username: "masum7masum",
    currency: "BDT",
    balance: "500.21",
    provider: "Lorem Ipsum is simply bank text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Active",
    createdAt: "2025-03-31",
    completedAt: "2025-03-31 16:00",
    lastDeposit: "500.00",
    transferAmount: "0.00 +500.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +500.00",
    currentWinLoss: "+1,450.25",
    source: "member",
    remark: "-",
    IP: "253.163.157.73",
    lastModifiedBy: "-",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
  },
  {
    Id: 2725,
    affiliate: "-",
    username: "01978456321",
    currency: "BDT",
    balance: "500.20",
    provider: "Lorem Ipsum is simply cash text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Unlocked",
    createdAt: "2025-04-02",
    completedAt: "2025-04-02 16:00",
    lastDeposit: "500.00",
    transferAmount: "0.00 +500.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +500.00",
    currentWinLoss: "+450.25",
    source: "member",
    remark: "system",
    IP: "253.163.157.73",
    lastModifiedBy: "-",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
  },
  {
    Id: 2726,
    affiliate: "-",
    username: "Justice4502",
    currency: "BDT",
    balance: "500.00",
    provider: "Lorem Ipsum is simply cash text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Active",
    createdAt: "2025-04-06",
    completedAt: "2025-04-06 16:00",
    lastDeposit: "0.00",
    transferAmount: "0.00 +167.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +167.00",
    currentWinLoss: "-470.25",
    source: "member",
    remark: "system",
    IP: "253.163.157.73",
    lastModifiedBy: "-",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
  },
  {
    Id: 2728,
    affiliate: "affiliateads1",
    username: "adnansharif13",
    currency: "BDT",
    balance: "300.00",
    provider: "Lorem Ipsum is simply bank text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Unlocked",
    createdAt: "2025-04-06",
    completedAt: "2025-04-06 16:00",
    lastDeposit: "0.00",
    transferAmount: "0.00 +259.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +259.00",
    currentWinLoss: "-1,000.25",
    source: "member",
    remark: "system",
    IP: "253.163.157.73",
    lastModifiedBy: "-",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
  },
  {
    Id: 2729,
    affiliate: "-",
    username: "hafizur50",
    currency: "BDT",
    balance: "1,851.90",
    provider: "Lorem Ipsum is simply bank text of the printing and typesetting industry. It is a long established fact that a reader will be distracted by the layout.",
    promotionCode: "100% SLOTS WELCOME BONUS",
    status: "Active",
    createdAt: "2025-04-03",
    completedAt: "2025-04-03 16:00",
    lastDeposit: "1,850.00",
    transferAmount: "0.00 +1,450.00",
    target: "2,840.10 / 25,000.00",
    minimumDeposit: "0.00 +1,450.00",
    currentWinLoss: "+90.25",
    source: "member",
    remark: "system",
    IP: "253.163.157.73",
    lastModifiedBy: "MAJUBAJIJennie",
    lastModifiedDate: "2025-02-18 16:00",
    merchant: "MJB"
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
        (form.value.provider === "All" || member.provider === form.value.provider) &&
        (form.value.username === "" || member.username.toLowerCase().includes(form.value.username.toLowerCase())) &&
        (form.value.promotionCode === "" || (member.promotionCode &&
            member.promotionCode.toLowerCase().includes(form.value.promotionCode.toLowerCase()))) &&
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
  form.value.username = "";
  form.value.provider = "All";
  form.value.status = "All";
  form.value.currency = "";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.promotionCode = "";
  form.value.merchant = "All";

  selectedDateFilter.value = "All";
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({
                                            Id,
                                            affiliate,
                                            username,
                                            currency,
                                            balance,
                                            provider,
                                            promotionCode,
                                            status,
                                            createdAt,
                                            completedAt,
                                            lastDeposit,
                                            transferAmount,
                                            target,
                                            minimumDeposit,
                                            currentWinLoss,
                                            source,
                                            remark,
                                            IP,
                                            lastModifiedBy,
                                            lastModifiedDate
                                          }) => ({
    "ID": Id,
    "Affiliate": affiliate,
    "Username": username,
    "Currency": currency,
    "Balance": balance,
    "Provider": provider,
    "Promotion Code": promotionCode,
    "Status": status,
    "Start Time": createdAt,
    "End Time": completedAt,
    "Last Deposit": lastDeposit,
    "Transfer Amount": transferAmount,
    "Target": target,
    "Minimum Deposit": minimumDeposit,
    "Current Win/Loss": currentWinLoss,
    "Source": source,
    "Remark": remark,
    "IP Address": IP,
    "Last Modified By": lastModifiedBy,
    "Last Modified Date": lastModifiedDate
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Members");
  XLSX.writeFile(workbook, "members.xlsx");
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
  padding: 10px 0 10px 10px;
  border: none;
  text-align: right;
}

.table-responsive {
  padding-right: 2px;
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

.sound-options {
  margin-top: 5px;
  font-size: 11px;
}

.sound-options label {
  display: block;
  margin-top: 5px;
}

input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ccc;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  outline: none;
  transition: 0.3s;
}

input[type="radio"]:checked {
  border-color: #ffcc00;
  background-color: #ffcc00;
}

input[type="radio"]:checked::before {
  content: "";
  width: 4px;
  height: 4px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.sticky-end {
  position: sticky;
  right: 0;
}
</style>