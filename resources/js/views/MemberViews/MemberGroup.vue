<template>
  <GroupModal v-model="showModal" @submit="handleFormSubmit" />
  <div class="container">
    <!-- Header Section -->
    <div class="row align-items-center form-header mb-3">
      <div class="col-lg-10 col-md-9 col-8 col-sm-12">
        <h2 class="form-title">Member</h2>
        <p class="breadcrumb">Member > <strong>Member Group</strong></p>
      </div>
      <div class="col-lg-2 col-md-2 col-4 col-sm-12 d-flex justify-content-end">
        <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
                @click="showModal = true">
          <CirclePlus class="me-2" size="16" stroke-width="2"/>
          Add
        </button>
      </div>
    </div>

    <!-- Form Section -->
    <div class="row g-3 form-container mb-3">
      <div class="col-lg-3 col-md-6">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
      </div>
      <div class="col-lg-3 col-md-6">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
        </select>
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
            <Download size="16" stroke-width="2" class="me-2"/> Export
          </button>
        </div>
      </div>

      <!-- Table Section -->
      <div class="table-responsive mt-3">
        <table class="table table-striped">
          <thead>
          <tr>
            <th @click="sortTable('id')">ID <span v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('code')">Code <span v-if="sortColumn === 'code'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('level')">Level <span v-if="sortColumn === 'level'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('name')">Name <span v-if="sortColumn === 'name'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('memberCount')">Member Count <span v-if="sortColumn === 'memberCount'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('status')">Status <span v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('default')">Default <span v-if="sortColumn === 'default'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th @click="sortTable('sequence')">Sequence <span v-if="sortColumn === 'sequence'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
            <th>Remark</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(member, index) in filteredMembers" :key="index">
            <td>{{ member.id }}</td>
            <td>{{ member.code }}</td>
            <td>{{ member.level }}</td>
            <td>{{ member.name }}</td>
            <td>{{ member.memberCount }}</td>
            <td>
              <span :class="{'badge border border-success text-success': member.status === 'Active', 'badge border border-danger text-danger': member.status === 'Inactive'}">
                {{ member.status }}
              </span>
            </td>
            <td>{{ member.default }}</td>
            <td>{{ member.sequence }}</td>
            <td>{{ member.remark }}</td>
            <td>
              <button class="btn btn-sm bg-white">
                <SquarePen size="16" stroke-width="2" style="color: #5a5858"/>
              </button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- Showing Entries Text -->
      <div class="mt-2 text-right" style="font-size: 12px; font-weight: 500;">
        Showing {{ startEntry }}-{{ endEntry }} of {{ totalEntries }} entries
      </div>
    </div>
  </div>
</template>


<script setup>
import { computed, ref } from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import { CirclePlus, Download, SquarePen } from "lucide-vue-next";
import * as XLSX from "xlsx";
import GroupModal from './modals/MemberGroupModal.vue';

const form = ref({
  merchant: "All",
  status: "All",
});


const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const sortColumn = ref(null);
const sortOrder = ref("asc");
const startEntry = computed(() => (filteredMembers.value.length > 0 ? 1 : 0));
const endEntry = computed(() => filteredMembers.value.length);
const totalEntries = computed(() => filteredMembers.value.length);
const members = ref([
  { id: 1, code: "Regular", level: 1, name: "Regular", memberCount: 8264, status: "Active", default: "Yes", sequence: 1, remark: "-", merchant: "MJB" },
  { id: 2, code: "Regular 2", level: 2, name: "Regular 2", memberCount: 0, status: "Active", default: "No", sequence: 2, remark: "-", merchant: "MJB2" },
  { id: 3, code: "Risk", level: 3, name: "Risk", memberCount: 2, status: "Inactive", default: "No", sequence: 3, remark: "-", merchant: "MJB" },
  { id: 4, code: "PLATINUM", level: 4, name: "PLATINUM", memberCount: 0, status: "Active", default: "No", sequence: 4, remark: "-", merchant: "MJB2" },
  { id: 5, code: "DIAMOND", level: 5, name: "DIAMOND", memberCount: 0, status: "Inactive", default: "No", sequence: 5, remark: "-", merchant: "MJB" },
  { id: 6, code: "TEST", level: 1, name: "PAYMENT GATEWAY TEST", memberCount: 1, status: "Active", default: "No", sequence: 6, remark: "-", merchant: "MJB2" },
]);

const filteredMembers = computed(() => {
  let filtered = members.value.filter(member => {
    const matchesStatus = form.value.status === "All" || member.status.toLowerCase() === form.value.status.toLowerCase();
    const matchesMerchant = form.value.merchant === "All" || member.merchant.toLowerCase() === form.value.merchant.toLowerCase();
    return matchesStatus && matchesMerchant;
  });

  if (sortColumn.value) {
    return [...filtered].sort((a, b) => {
      let valA = a[sortColumn.value];
      let valB = b[sortColumn.value];

      if (typeof valA === "string") valA = valA.toLowerCase();
      if (typeof valB === "string") valB = valB.toLowerCase();

      return sortOrder.value === "asc" ? (valA > valB ? 1 : -1) : (valA < valB ? 1 : -1);
    });
  }

  return filtered;
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
  form.value.status = "All";
  form.value.merchant = "All";
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({ id, code, level, name, memberCount, status, default: def, sequence, remark }) => ({
    ID: id,
    Code: code,
    Level: level,
    Name: name,
    "Member Count": memberCount,
    Status: status,
    Default: def,
    Sequence: sequence,
    Remark: remark,
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

td{
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

.export-btn{
  padding: -1px;
  font-size: 13px;
  font-weight: 600;
}
</style>
