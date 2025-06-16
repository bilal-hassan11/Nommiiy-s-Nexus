<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h2 class="form-title">Verify Reward</h2>
      <p class="breadcrumb">Verify Reward > <strong>Verify Reward List</strong></p>
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
          <option>MJB3</option>
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
        <label>Username</label>
        <input type="text" v-model="form.username" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Claim Status</label>
        <select v-model="form.claimStatus" class="form-select">
          <option>All</option>
          <option>Yes</option>
          <option>No</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Claim Bonus Start Date</label>
        <input type="date" v-model="form.claimBonusCreatedAt" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Claim Bonus End Date</label>
        <input type="date" v-model="form.claimBonusCompletedAt" class="form-control">
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

    <!-- Table Section -->
    <div class="table-responsive mt-3">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('id')">ID <span
              v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('username')">Username <span
              v-if="sortColumn === 'username'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('phoneNumber')">Phone Number <span
              v-if="sortColumn === 'phoneNumber'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('reward')">Reward <span
              v-if="sortColumn === 'reward'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Deposit Status</th>
          <th>Withdraw Status</th>
          <th @click="sortTable('verifyStatus')">Verify Status <span
              v-if="sortColumn === 'verifyStatus'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('claimStatus')">Claim Status <span
              v-if="sortColumn === 'claimStatus'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('remark')">Remark <span
              v-if="sortColumn === 'remark'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('updatedBy')">Updated By <span
              v-if="sortColumn === 'updatedBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('createdAt')">Created At <span
              v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('updatedAt')">Updated At <span
              v-if="sortColumn === 'updatedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in paginatedMembers" :key="index">
          <td>{{ member.id }}</td>
          <td>{{ member.currency }}</td>
          <td><a href="#" style="color: #787445">{{ member.username }}</a></td>
          <td>{{ member.phoneNumber }}</td>
          <td>{{ member.reward }}</td>
          <td>
            <span class="icon-wrapper">
              <CircleX stroke-width="2" size="18" class="text-danger"/>
            </span>
          </td>
          <td>
            <span class="icon-wrapper">
              <CircleX stroke-width="2" size="18" class="text-danger"/>
            </span>
          </td>
          <td>
            <span
                :class="{
                'badge border border-warning text-warning': member.verifyStatus === 'Pending',
                'badge border border-success text-success': member.verifyStatus === 'Verified',
                'badge border border-danger text-danger': member.verifyStatus === 'Rejected'
              }">
              {{ member.verifyStatus }}
            </span>
          </td>
          <td>
            <span
                :class="{
                'badge border border-danger text-danger': member.claimStatus === 'Not Verified',
                'badge border border-success text-success': member.claimStatus === 'Verified',
                'badge border border-warning text-warning': member.claimStatus === 'Pending'
              }">
              {{ member.claimStatus }}
            </span>
          </td>
          <td>{{ member.remark }}</td>
          <td>{{ member.updatedBy }}</td>
          <td>{{ member.createdAt }}</td>
          <td>{{ member.updatedAt }}</td>
        </tr>

        <!-- Page Summary Row -->
        <tr class="page-summary">
          <td class="fw-bold text-start" colspan="4">Page Summary</td>
          <td class="text-end">{{ pageSummary }}</td>
          <td colspan="13"></td>
        </tr>

        <tr class="total-summary">
          <td class="fw-bold text-start" colspan="4">Total Summary</td>
          <td class="text-end">{{ totalSummary }}</td>
          <td colspan="13"></td>
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
import "vue-multiselect/dist/vue-multiselect.css";
import {Download, CircleX} from "lucide-vue-next";
import * as XLSX from "xlsx";
import Multiselect from "vue-multiselect";

const pageSummary = '0.00';
const totalSummary = '0.00';

const form = ref({
  merchant: "MJB",
  username: "",
  claimStatus: "All",
  currency: ["BDT", "NPR"],
  claimBonusCreatedAt: "",
  claimBonusCompletedAt: "",
});

const currencies = ref(["BDT", "NPR"]);
const sortColumn = ref(null);
const sortOrder = ref("asc");

const members = ref([
  {
    id: "18406",
    currency: "BDT",
    username: "dinesh05",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  },
  {
    id: "18407",
    currency: "BDT",
    username: "sakil280",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  },
  {
    id: "18408",
    currency: "BDT",
    username: "liya56",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  },
  {
    id: "18409",
    currency: "BDT",
    username: "Shakib208",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  },
  {
    id: "18410",
    currency: "BDT",
    username: "Ahsan439",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  },
  {
    id: "18411",
    currency: "BDT",
    username: "Shakib208",
    phoneNumber: "89546361631",
    reward: "-",
    verifyStatus: "Pending",
    claimStatus: "Not Verified",
    remark: "-",
    updatedBy: "-",
    createdAt: "2025-03-25 12:00",
    updatedAt: "-",
    merchant: "MJB",
  }
]);

const filteredMembers = computed(() => {
  return members.value
      .filter(member => {
        return (
            (form.value.merchant === "All" || member.merchant === form.value.merchant) &&
            (form.value.username === "" || member.username.toLowerCase().includes(form.value.username.toLowerCase()))
        );
      })
      .sort((a, b) => {
        if (!sortColumn.value) return 0;

        let valA = a[sortColumn.value];
        let valB = b[sortColumn.value];

        if (typeof valA === "string") valA = valA.toLowerCase();
        if (typeof valB === "string") valB = valB.toLowerCase();

        return sortOrder.value === "asc"
            ? valA > valB ? 1 : -1
            : valA < valB ? -1 : 1;
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
  form.value.merchant = "MJB";
  form.value.claimStatus = "All";
  form.value.username = "";
  form.value.currency = ["BDT", "NPR"];
  form.value.claimBonusCreatedAt = "";
  form.value.claimBonusCompletedAt = "";
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
                                            id,
                                            currency,
                                            username,
                                            phoneNumber,
                                            reward,
                                            verifyStatus,
                                            claimStatus,
                                            remark,
                                            updatedBy,
                                            createdAt,
                                            updatedAt
                                          }) => ({
    ID: id,
    Currency: currency,
    Username: username,
    "Phone Number": phoneNumber,
    Reward: reward,
    "Verify Status": verifyStatus,
    "Claim Status": claimStatus,
    Remark: remark,
    "Updated By": updatedBy,
    "Created At": createdAt,
    "Updated At": updatedAt
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Verify Reward List");
  XLSX.writeFile(workbook, "verifyRewardList.xlsx");
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
  background-color: #f8f8f8;
  font-weight: 600;
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

.page-summary td {
  background-color: #c4ffc4 !important;
}

.total-summary td {
  background-color: #fae09f !important;
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