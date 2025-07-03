<template>
  <AddStyleModal v-model="showAddStyleModal" @submit="handleFormSubmit"/>
  <AddAnnouncementModal v-model="showAnnouncementModal" @submit="handleFormSubmit"/>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-12">
      <h2 class="form-title">System Message</h2>
      <p class="breadcrumb">System Message > <strong>Announcement</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="showAnnouncementModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
      <button class="btn btn-outline-dark add-btn" @click="showAddStyleModal = true">
        Add Style
      </button>
    </div>
  </div>

  <div class="form-container">
    <div class="row">
      <div class="col-md-6 col-lg-3">
        <label>Type</label>
        <select v-model="form.type" class="form-select">
          <option value="All">All</option>
          <option>Type 1</option>
          <option>Type 2</option>
          <option>Type 3</option>
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

    <div>
      <label class="text-dark font-600">Desktop:</label>
      <div class="announcement-banner">
        <div class="announcement-text">This is Example of Announcement will be shown in the member page.</div>
      </div>

      <label class="text-dark font-600">Mobile:</label>
      <div class="announcement-banner">
        <div class="announcement-text">This is Example of Announcement will be shown in the mobile member page.</div>
      </div>
    </div>

    <!-- Table Section -->
    <div class="table-responsive mt-3">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('id')">ID <span
              v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('announcementType')">Announcement Type <span
              v-if="sortColumn === 'announcementType'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th></th>
          <th @click="sortTable('preview')">Preview <span
              v-if="sortColumn === 'preview'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdAt')">Start Date <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('completedAt')">Expire Date <span
              v-if="sortColumn === 'completedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('popUp')">Pop Up <span
              v-if="sortColumn === 'popUp'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('sequence')">Sequence <span
              v-if="sortColumn === 'sequence'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.id }}</td>
          <td>{{ member.announcementType }}</td>
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
          <td>{{ member.language }}</td>
          <td>{{ member.preview }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.completedAt }}</td>
          <td>{{ member.popUp }}</td>
          <td>{{ member.sequence }}</td>
          <td>
            <button class="btn btn-sm bg-white">
              <SquarePen size="16" stroke-width="2" style="color: #5a5858"/>
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script setup>
import {computed, ref} from "vue";
import {CirclePlus, Download, SquarePen} from "lucide-vue-next";
import * as XLSX from "xlsx";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";
import AddStyleModal from "@/views/SystemMessageViews/modals/AddStyleModal.vue";
import AddAnnouncementModal from "@/views/SystemMessageViews/modals/AddAnnouncementModal.vue";

dayjs.extend(utc);
dayjs.extend(isBetween);

const selectedDateFilter = ref("All");
const showAddStyleModal = ref(false);
const showAnnouncementModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  type: "All",
  status: "Active",
  createdAt: "",
  completedAt: "",
  timeZone: "GMT+0700",
});

const clearForm = () => {
  form.value.type = "All";
  form.value.status = "Active";
  form.value.createdAt = "";
  form.value.completedAt = "";
  form.value.timeZone = "GMT+0700";
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
    id: 1,
    announcementType: "normal",
    status: "Active",
    language: "EN-BD",
    preview: "Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document " +
        "or design.",
    popUp: "-",
    sequence: "1",
    createdAt: "2025-04-25 12:00",
    completedAt: "2025-05-25 12:00",
    timeZone: "GMT+0700",
    type: "Type 1"
  }
]);

const filteredMembers = computed(() => {
  return members.value.filter((member) => {
    const matchesType = form.value.type === "All" || member.type === form.value.type;
    const matchesStatus = form.value.status === "All" || member.status === form.value.status;
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

    return matchesType && matchesStatus && matchesDate && matchesTimeZone;
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

const exportToExcel = () => {
  const data = filteredMembers.value.map(({
                                            id, announcementType, status, preview, createdAt, completedAt,
                                            popUp, sequence
                                          }) => ({
    "ID": id,
    "Announcement Type": announcementType,
    "Status": status,
    "Preview": preview,
    "Start Date": createdAt,
    "Expire Date": completedAt,
    "Pop Up": popUp,
    "Sequence": sequence
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "announcement");
  XLSX.writeFile(workbook, "announcement.xlsx");
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

.announcement-banner {
  background-color: #d4f8d4;
  overflow: hidden;
  white-space: nowrap;
  width: 100%;
  height: 30px;
  position: relative;
}

.announcement-text {
  display: inline-block;
  padding-left: 100%;
  animation: scroll-left 20s linear infinite;
}

@keyframes scroll-left {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-100%);
  }
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>