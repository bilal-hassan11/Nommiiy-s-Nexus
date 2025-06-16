<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Member Verification</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <div class="dropdown">
        <button class="btn btn-primary settings-btn dropdown-toggle me-2" type="button" id="settingsDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
          Settings
        </button>
        <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="#">Account</a></li>
          <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
      </div>

      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
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
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Pending</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>ID Name</label>
        <input type="text" v-model="form.idName" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>ID No</label>
        <input type="text" v-model="form.idNo" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Date From</label>
        <input type="date" v-model="form.dateFrom" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Date To</label>
        <input type="date" v-model="form.dateTo" class="form-control">
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
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
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
          <th @click="sortTable('id')">ID <span v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
          </th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('username')">Username <span
              v-if="sortColumn === 'username'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('idName')">ID Name <span
              v-if="sortColumn === 'idName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('idNo')">ID No <span v-if="sortColumn === 'idNo'">{{
              sortOrder === 'asc' ? '↑' : '↓'
            }}</span></th>
          <th @click="sortTable('createdAt')">Created At <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('lastUpdated')">Last Updated <span
              v-if="sortColumn === 'lastUpdated'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Admin Remark</th>
          <th @click="sortTable('handleBy')">Handle By<span
              v-if="sortColumn === 'handleBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.id }}</td>
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
          <td><a href="#" style="color: #787445"> {{ member.username }}</a></td>
          <td>{{ member.currency }}</td>
          <td>{{ member.idName }}</td>
          <td>{{ member.idNo }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.lastUpdated }}</td>
          <td>{{ member.adminRemark }}</td>
          <td>{{ member.handleBy }}</td>
          <td>
            <button class="btn btn-sm bg-white">
              <SquarePen size="16" stroke-width="2" style="color: #5a5858"/>
            </button>
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
import {CirclePlus, Download, SquarePen} from "lucide-vue-next";
import * as XLSX from "xlsx";
import Multiselect from "vue-multiselect";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";

dayjs.extend(utc);
dayjs.extend(isBetween);

const form = ref({
  username: "",
  status: "All",
  idName: "",
  idNo: "",
  dateFrom: "",
  dateTo: "",
  currency: "",
  timeZone: "GMT+0700"
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
    id: 3192,
    status: "Pending",
    username: "sakil280",
    currency: "BDT",
    idName: "Sakil Islam",
    idNo: "3216549",
    createdAt: "2025-03-17 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
    handleBy: "Fahim"
  },
  {
    id: 3180,
    status: "Active",
    username: "Tauhid6669",
    currency: "BDT",
    idName: "MD. Tauhidul Islam",
    idNo: "1234896",
    createdAt: "2025-03-18 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    handleBy: "Fahim"
  },
  {
    id: 3181,
    status: "Inactive",
    username: "Kasim837",
    currency: "BDT",
    idName: "Kasim Khakhaan",
    idNo: "4563217",
    createdAt: "2025-03-15 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    handleBy: "Fahim"
  },
  {
    id: 3182,
    status: "Pending",
    username: "ismail45",
    currency: "NPR",
    idName: "MD. Ismail",
    idNo: "8974632",
    createdAt: "2025-03-12 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "-",
    handleBy: "Fahim"
  },
  {
    id: 3183,
    status: "Active",
    username: "liza18",
    currency: "NPR",
    idName: "Liza Akhter",
    idNo: "7845123",
    createdAt: "2025-03-03 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "-",
    handleBy: "Fahim"
  },
  {
    id: 3184,
    status: "Inactive",
    username: "dipok56",
    currency: "BDT",
    idName: "Dipak Roy",
    idNo: "9856321",
    createdAt: "2025-02-18 12:00",
    lastUpdated: formattedDateAndTime,
    adminRemark: "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
    handleBy: "Fahim"
  },
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
        (form.value.username === "" || member.username.toLowerCase().includes(form.value.username.toLowerCase())) &&
        (form.value.status === "All" || member.status === form.value.status) &&
        (form.value.idName === "" || member.idName.toLowerCase().includes(form.value.idName.toLowerCase())) &&
        (form.value.idNo === "" || member.idNo.includes(form.value.idNo)) &&
        // (!form.value.currency || member.currency.some((c) => c.toLowerCase() === form.value.currency.toLowerCase())) &&
        (form.value.dateFrom === "" || dayjs(member.createdAt).isAfter(dayjs(form.value.dateFrom).subtract(1, "day"))) &&
        (form.value.dateTo === "" || dayjs(member.createdAt).isBefore(dayjs(form.value.dateTo).add(1, "day")))
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
  form.value.status = "All";
  form.value.idName = "";
  form.value.idNo = "";
  form.value.dateFrom = "";
  form.value.dateTo = "";
  form.value.currency = "";
  form.value.timeZone = "GMT+0700";
  selectedDateFilter.value = "All";
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({
                                            id,
                                            status,
                                            username,
                                            currency,
                                            idName,
                                            idNo,
                                            createdAt,
                                            lastUpdated,
                                            adminRemark,
                                            handleBy
                                          }) => ({
    ID: id,
    Status: status,
    Username: username,
    Currency: currency,
    "ID Name": idName,
    "ID No": idNo,
    "Created At": createdAt,
    "Last Updated": lastUpdated,
    "Admin Remark": adminRemark,
    "Handle By": handleBy,
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Member Verification");
  XLSX.writeFile(workbook, "memberVerification.xlsx");
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

.settings-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 8px 23px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.settings-btn:hover {
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

</style>
