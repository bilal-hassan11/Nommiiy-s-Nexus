<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-12">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Member Online</strong></p>
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
        <label>Name</label>
        <input type="text" v-model="form.name" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Affiliate</label>
        <input type="text" v-model="form.affiliate" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>IP</label>
        <input type="text" v-model="form.player_ip" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Time Zone</label>
        <select v-model="form.timeZone" class="form-select">
          <option>GMT+0700</option>
          <option>GMT+0500</option>
        </select>
      </div>
    </div>
    <div class="button-group">
      <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
      <button class="btn search-btn">Search</button>
    </div>
  </div>

  <!-- Export Button -->
  <div class="row g-2 mt-3 form-container">
    <div class="row mt-3">
      <div class="col-lg-2 col-md-4 col-6 col-sm-6">
        <button class="export-btn btn btn-outline-secondary w-100" @click="exportToExcel">
          <Download size="16" stroke-width="2" class="me-2"/>
          Export
        </button>
      </div>
    </div>
    <div class="row mt-2">
      <p class="text-secondary" style="font-size: 12px;">Member Online: 433</p>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th @click="sortTable('id')">ID <span v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
          </th>
          <th @click="sortTable('username')">Username <span v-if="sortColumn === 'username'">{{
              sortOrder === 'asc' ? '↑' : '↓'
            }}</span></th>
          <th @click="sortTable('name')">Name <span v-if="sortColumn === 'name'">{{
              sortOrder === 'asc' ? '↑' : '↓'
            }}</span></th>
          <th @click="sortTable('currency')">Currency <span v-if="sortColumn === 'currency'">{{
              sortOrder === 'asc' ? '↑' : '↓'
            }}</span></th>
          <th @click="sortTable('memberGroup')">Member Group <span
              v-if="sortColumn === 'memberGroup'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('mobileNo')">Mobile No. <span
              v-if="sortColumn === 'mobileNo'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th @click="sortTable('affiliate')">Affiliate <span
              v-if="sortColumn === 'afiiliate'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
          <th>Last Active</th>
          <th>Current Login Info</th>
          <th>Online Time</th>
          <th>Last Login Info</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td>{{ member.id }}</td>
          <td><a href="#" style="color: #e8c015">{{ member.username }}</a></td>
          <td>{{ member.name }}</td>
          <td>{{ member.currency }}</td>
          <td>{{ member.memberGroup }}</td>
          <td>{{ member.mobileNo }}</td>
          <td>{{ member.affiliate }}</td>
          <td>{{ member.lastActive }}</td>
          <td>{{ member.currentLoginInfo }}</td>
          <td>{{ member.onlineTime }}</td>
          <td>{{ member.lastLoginInfo }}</td>
          <td>
            <button class="btn btn-sm bg-white">
              <Ban size="16" stroke-width="2" style="color: #c51414"/>
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import {Ban, Download} from "lucide-vue-next";
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import isBetween from "dayjs/plugin/isBetween";
import * as XLSX from "xlsx";

dayjs.extend(utc);
dayjs.extend(isBetween);

const form = ref({
  username: "",
  name: "",
  affiliate: "",
  player_ip: "",
  timeZone: "GMT+0500",
});
const formattedDate = ref("");
const formattedTime = ref("");
const formattedDateAndTime = ref("");
const sortColumn = ref(null);
const ip = "192.168.1.1"; // Use a valid IP address
const currentLogin = ref("");
const sortOrder = ref("asc");

const updateDateTime = () => {
  const now = new Date();
  formattedDate.value = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, "0")}-${String(now.getDate()).padStart(2, "0")}`;
  formattedTime.value = `${String(now.getHours()).padStart(2, "0")}:${String(now.getMinutes()).padStart(2, "0")}`;
  formattedDateAndTime.value = `${formattedDate.value} ${formattedTime.value}`;
  currentLogin.value = `${formattedDateAndTime.value} ${ip} BD`;
};

onMounted(() => {
  updateDateTime();
  setInterval(updateDateTime, 1000);
});
const members = ref([
  {
    id: 8168,
    username: "DONASHORI",
    name: "SREE MOTADONASHORI RANE",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "Prodipbit4268",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
  {
    id: 8142,
    username: "Liza468",
    name: "liza akhter",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "-",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
  {
    id: 7946,
    username: "kashem72",
    name: "abdul kashem",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "koolstarzz",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
  {
    id: 8352,
    username: "roy8978",
    name: "Dipok Roy",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "-",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
  {
    id: 8128,
    username: "Shakariya",
    name: "shakariya hossain",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "Prodipbit4268",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
  {
    id: 7456,
    username: "tohiruddin",
    name: "MD Tohiruddin",
    currency: "BDT",
    memberGroup: "Regular",
    mobileNo: "03331234567",
    affiliate: "koolstarzz",
    lastActive: formattedDateAndTime,
    currentLoginInfo: currentLogin,
    onlineTime: formattedTime,
    lastLoginInfo: currentLogin,
    player_ip: ip
  },
]);

const filteredMembers = computed(() => {
  let filtered = members.value.filter(member => {
    return (
        (!form.value.username || member.username.toLowerCase().includes(form.value.username.toLowerCase())) &&
        (!form.value.name || member.name.toLowerCase().includes(form.value.name.toLowerCase())) &&
        (!form.value.affiliate || member.affiliate.toLowerCase().includes(form.value.affiliate.toLowerCase())) &&
        (!form.value.player_ip || member.player_ip.includes(form.value.player_ip))
    );
  });

  if (sortColumn.value) {
    filtered.sort((a, b) => {
      const valA = a[sortColumn.value];
      const valB = b[sortColumn.value];
      if (!isNaN(valA) && !isNaN(valB)) {
        return sortOrder.value === "asc" ? valA - valB : valB - valA;
      }
      return sortOrder.value === "asc" ? String(valA).localeCompare(String(valB)) : String(valB).localeCompare(String(valA));
    });
  }
  return filtered;
});

const sortTable = column => {
  if (sortColumn.value === column) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortColumn.value = column;
    sortOrder.value = "asc";
  }
};

const exportToExcel = () => {
  const data = filteredMembers.value.map(({ id, username, name, currency, memberGroup, mobileNo, affiliate, lastActive,
                                            currentLoginInfo, onlineTime, lastLoginInfo }) => ({
    ID: id,
    Username: username,
    Name: name,
    Currency: currency,
    "Member Group": memberGroup,
    "Mobile No": mobileNo,
    Affiliate: affiliate,
    "Last Active": lastActive,
    "Current Login Info": currentLoginInfo,
    "Online Time": onlineTime,
    "Last Login Info": lastLoginInfo,
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "MembersOnline");
  XLSX.writeFile(workbook, "membersOnline.xlsx");
};

const clearForm = () => {
  form.value.username = "";
  form.value.name = "";
  form.value.affiliate = "";
  form.value.player_ip = "";
  form.value.timeZone = "GMT+0500";
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
  padding: 3px;
  border: 1px solid #ccc;
  border-radius: 5px;
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

.table {
  width: 100%;
  margin-top: 10px;
}

th, td {
  padding: 10px;
  border: none;
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

</style>
