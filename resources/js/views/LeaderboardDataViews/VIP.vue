<template>
  <AddVipModal v-model="showModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Leaderboard Data</h2>
      <p class="breadcrumb">Leaderboard Data > <strong>VIP</strong></p>
    </div>
    <div class="col-lg-2 col-md-2 col-4 col-sm-12 d-flex justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
              @click="showModal = true">
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
    </div>
    <div class="col-12 d-flex justify-content-end gap-2">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>

  <div class="row g-3 mt-3 form-container">
    <div class="table-responsive mt-3">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('no')">No <span
              v-if="sortColumn === 'no'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('currency')">Currency <span
              v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('type')">Type <span
              v-if="sortColumn === 'type'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('activityType')">Activity Type <span
              v-if="sortColumn === 'activityType'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('displayRow')">Display Row <span
              v-if="sortColumn === 'displayRow'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('lastUpdated')">Last Updated <span
              v-if="sortColumn === 'lastUpdated'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('status')">Status <span
              v-if="sortColumn === 'status'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.no }}</td>
          <td>{{ member.currency }}</td>
          <td>{{ member.type }}</td>
          <td>{{ member.activityType }}</td>
          <td>{{ member.displayRow }}</td>
          <td>{{ member.lastUpdated }}</td>
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
          <td>
            <Pencil size="14" style="cursor:pointer; margin-right: 18px"/>
            <RefreshCcw size="14" style="cursor:pointer; color: green"/>
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
import {computed, ref} from "vue";
import "vue-multiselect/dist/vue-multiselect.css";
import {CirclePlus, Pencil, RefreshCcw} from "lucide-vue-next";
import Multiselect from "vue-multiselect";
import AddVipModal from "@/views/LeaderboardDataViews/modals/AddVipModal.vue";

const showModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  merchant: "All",
  currency: ["BDT", "NPR"],
});

const startEntry = computed(() => (filteredMembers.value.length > 0 ? 1 : 0));
const endEntry = computed(() => filteredMembers.value.length);
const totalEntries = computed(() => filteredMembers.value.length);

const currencies = ref(["BDT", "NPR"]);
const sortColumn = ref(null);
const sortOrder = ref("asc");


const members = ref([
  {
    no: 1,
    currency: "BDT",
    type: "Generated by system",
    activityType: "Bonus Display",
    displayRow: 10,
    lastUpdated: "Majuluck",
    status: "Active",
    merchant: "MJB"
  },
  {
    no: 2,
    currency: "BDT",
    type: "Generated by system",
    activityType: "Explosive Prize Show",
    displayRow: 10,
    lastUpdated: "Boadmin",
    status: "Active",
    merchant: "MJB"
  }
]);

const filteredMembers = computed(() => {
  return members.value.filter(member => {

    return (
        (form.value.merchant === "All" || member.merchant === form.value.merchant)
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
  form.value.currency = ["BDT", "NPR"];
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

</style>