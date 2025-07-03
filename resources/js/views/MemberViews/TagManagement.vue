<template>
    <div class="row align-items-center form-header">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 class="form-title">Member</h2>
        <p class="breadcrumb">Member > <strong>Tag Management</strong></p>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
        <button class="btn tag-btn me-2">Tags Adjustment History</button>
        <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
                @click="this.$router.push('/new-tag-page');">
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
          </select>
        </div>
        <div class="col-md-6 col-lg-3">
          <label>Tag Name</label>
          <input type="text" v-model="form.tagName" class="form-control">
        </div>
        <div class="col-md-6 col-lg-3">
          <label>Updated By</label>
          <select v-model="form.updatedBy" class="form-select">
            <option value="All">All</option>
            <option value="Admin">Admin</option>
            <option value="System">System</option>
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
      <div class="button-group">
        <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
        <button class="btn search-btn">Search</button>
      </div>
    </div>

    <div class="table-responsive col-lg-12 col-md-12 col-sm-12 table-container mt-3">
      <table class="table table-striped mt-3">
        <thead>
        <tr>
          <th class="text-left" @click="sortTable('tagName')">
            Tag Name <span v-if="sortColumn === 'tagName'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
          </th>
          <th v-for="column in ['description', 'totalPlayers', 'domainName', 'updatedBy', 'updatedAt', 'remark', 'action']"
              :key="column"
              class="text-right"
              style="text-align: right !important"
              @click="!['remark', 'action'].includes(column) ? sortTable(column) : null">
            {{ column.charAt(0).toUpperCase() + column.slice(1).replace(/([A-Z])/g, ' $1').trim() }}
            <span v-if="sortColumn === column">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
          </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(member, index) in filteredMembers" :key="index">
          <td class="text-left">{{ member.tagName }}</td>
          <td v-for="column in ['description', 'totalPlayers', 'domainName', 'updatedBy', 'updatedAt', 'remark']"
              :key="column"
              class="text-right"
              style="text-align: right !important">
            {{ member[column] }}
          </td>
          <td class="text-right" style="text-align: right !important; position: relative;">
            <button class="player btn btn-sm bg-white">
              <CirclePlus size="16" stroke-width="2" style="color: #317731"/>
            </button>
          </td>
        </tr>
        </tbody>
      </table>

      <!-- Showing Entries Text -->
      <div class="mt-2 text-right" style="font-size: 12px; font-weight: 500;">
        Showing {{ startEntry }}-{{ endEntry }} of {{ totalEntries }} entries
      </div>
    </div>
  </template>

  <script setup>
  import {computed, ref} from "vue";
  import {CirclePlus} from "lucide-vue-next";
  import dayjs from "dayjs";
  import utc from "dayjs/plugin/utc";
  import isBetween from "dayjs/plugin/isBetween";
  import {onMounted} from 'vue';

  const handleFormSubmit = (formData) => {
    console.log("Received Form Data:", formData);
    // Optional: push into members list or send API request
  };

  onMounted(() => {
    const newTag = history.state?.newTag;
    if (newTag) {
      handleFormSubmit(newTag);
    }
  });

  dayjs.extend(utc);
  dayjs.extend(isBetween);

  const startEntry = computed(() => (filteredMembers.value.length > 0 ? 1 : 0));
  const endEntry = computed(() => filteredMembers.value.length);
  const totalEntries = computed(() => filteredMembers.value.length);

  const form = ref({
    merchant: "All",
    tagName: "",
    updatedBy: "All",
  });

  const sortColumn = ref(null);
  const sortOrder = ref("asc");

  const selectedDateFilter = ref("All");

  const members = ref([
    {
      tagName: "Same Password",
      description: "Same Password",
      totalPlayers: 2502,
      domainName: "-",
      updatedBy: "System",
      updatedAt: "2025-03-10 12:00",
      remark: "-",
      merchant: "MJB"
    },
    {
      tagName: "Same Mobile Number",
      description: "Same Mobile Number",
      totalPlayers: 0,
      domainName: "-",
      updatedBy: "System",
      updatedAt: "2025-03-09 12:05",
      remark: "-",
      merchant: "MJB2"
    },
    {
      tagName: "Same Email",
      description: "Same Email",
      totalPlayers: 0,
      domainName: "-",
      updatedBy: "Admin",
      updatedAt: "2025-03-08 12:10",
      remark: "-",
      merchant: "MJB"
    },
    {
      tagName: "Same Real Name",
      description: "Same Real Name",
      totalPlayers: 0,
      domainName: "-",
      updatedBy: "Admin",
      updatedAt: "2025-03-06 12:15",
      remark: "-",
      merchant: "MJB2"
    },
    {
      tagName: "Same IP",
      description: "Same IP",
      totalPlayers: 3820,
      domainName: "-",
      updatedBy: "System",
      updatedAt: "2025-03-02 12:20",
      remark: "-",
      merchant: "MJB"
    },
    {
      tagName: "Same Fingerprint",
      description: "Same Fingerprint",
      totalPlayers: 2157,
      domainName: "-",
      updatedBy: "Admin",
      updatedAt: "2025-02-28 12:25",
      remark: "-",
      merchant: "MJB2"
    },
  ]);

  const filteredMembers = computed(() => {
    return members.value.filter(member => {
      const updatedAt = dayjs.utc(member.updatedAt, "YYYY-MM-DD HH:mm").local();

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
          (form.value.merchant === "All" || member.merchant.toLowerCase() === form.value.merchant.toLowerCase()) &&
          (form.value.updatedBy === "All" || member.updatedBy.toLowerCase() === form.value.updatedBy.toLowerCase()) &&
          (!form.value.tagName || member.tagName.toLowerCase().includes(form.value.tagName.toLowerCase()))
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
    form.value.tagName = "";
    form.value.updatedBy = "All";
    selectedDateFilter.value = "All";
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

  .tag-btn {
    font-size: 12px;
    font-weight: 600;
    background: #e8c015;
    padding: 8px 26px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .tag-btn:hover {
    background: #d6b402;
  }

  .add-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 8px 25px;
    cursor: pointer;
    align-items: center;
  }

  .table-container {
    width: 99%;
    background: #fff;
    padding: 10px 25px 10px 25px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

  .player:hover::after {
    content: "Add Player";
    position: absolute;
    background-color: #d6b402;
    color: black;
    padding: 5px 10px;
    font-size: 10px;
    font-weight: 500;
    border-radius: 4px;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
  }
  </style>
