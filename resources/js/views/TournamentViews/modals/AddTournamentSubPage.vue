<template>
  <TournamentSettingListDisplaySettingModal v-model="showDisplaySettingModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Tournament</h2>
      <p class="breadcrumb">Tournament > <strong>Tournament Setting List</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2" @click="showDisplaySettingModal = true">
        Display Setting
      </button>
      <button class="btn btn-outline-dark add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/tournament-setting-list');">
        Table List
      </button>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Add Tournament</h2>
    </div>

    <div class="row gx-3 gy-3">
      <div class="col-md-12 col-lg-12">
        <label class="form-label">Member Group</label>
        <Multiselect
            v-model="form.memberGroup"
            :options="memberGroups"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            placeholder="Please Select Member Group"
        />
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Merchant</label>
        <select v-model="form.merchant" type="text" class="form-select">
          <option>MJB</option>
          <option>MJB2</option>
        </select>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Currency</label>
        <select v-model="form.currency" class="form-select">
          <option value="BDT">BDT</option>
          <option value="NPR">NPR</option>
        </select>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Activity Name</label>
        <input v-model="form.activityName" type="text" class="form-control" placeholder="Enter Activity Name"/>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Period Type</label>
        <select v-model="form.periodType" class="form-select">
          <option value="" selected disabled>Please Select Type</option>
          <option>Type 1</option>
          <option>Type 2</option>
        </select>
      </div>

      <div class="col-md-4 col-lg-4">
        <label>Start Date</label>
        <input type="date" v-model="form.startDate" class="form-control"/>
      </div>

      <div class="col-md-4 col-lg-4">
        <label>End Date</label>
        <input type="date" v-model="form.endDate" class="form-control"/>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Method</label>
        <select v-model="form.method" class="form-select">
          <option value="" selected disabled>Please Select Method Type</option>
          <option>Method 1</option>
          <option>Method 2</option>
        </select>
      </div>
      <div class="row">
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Release</label>
          <div class="d-flex gap-3">
            <div class="form-check form-check-inline">
              <input class="form-check-input custom-checkbox" type="checkbox" id="autoRelease"
                     v-model="form.autoRelease">
              <label class="form-check-label checkbox-label" for="autoRelease">Auto</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input custom-checkbox" type="checkbox" id="manualRelease"
                     v-model="form.manualRelease">
              <label class="form-check-label checkbox-label" for="manualRelease">Manual</label>
            </div>
          </div>
        </div>

        <!-- Display Reward Checkbox -->
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Display</label>
          <div class="form-check">
            <label class="form-check-label checkbox-label" for="displayReward">Reward</label>
            <input class="form-check-input custom-checkbox" type="checkbox" id="displayReward"
                   v-model="form.displayReward">
          </div>
        </div>
      </div>

      <!-- GMT+8 Reminder -->
      <div class="col-12">
          <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
            *Please be reminded that this date input are GMT+8 standard.
          </span>
      </div>
    </div>
  </div>

  <div class="form-container mb-3">
    <!-- Risk Setting Header -->
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Setting</h2>
    </div>

    <div class="col-md-12 col-lg-12">
      <label class="form-label">
        Member Tag Setting
        <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
            *If the player is under these member tag, the player is not allowed to apply to this tournament reward.
          </span>
      </label>
      <Multiselect
          v-model="form.memberTag"
          :options="memberTags"
          :multiple="true"
          :searchable="true"
          :close-on-select="false"
          :clear-on-select="false"
          placeholder="Please Select Member Tag"
      />
    </div>

    <!-- Risk Options -->
    <label class="form-label">Risk Options</label>
    <div class="mb-3 d-flex flex-wrap gap-2">
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same fingerprint ID</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same IP address</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same real name</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same email address</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same mobile number</button>
    </div>

    <!-- Violation Count Setting -->
    <div class="mb-2" style="font-size: 12px;">
      <label class="form-label">Violation Count Setting</label>
      <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
          * If the number of violations is over, the player is not allowed to apply to this tournament reward.
        </span>
    </div>
    <div style="font-size: 12px;">
      If violated count is above or equal
      <input type="number" disabled class="form-control d-inline-block mx-2" style="width: 80px;"
             v-model="form.violationCount"/>
      conditions, <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
        * The player will automatically to be declined from this tournament reward.</span>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Ranking Setting</h2>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
      <!-- Label on top -->
      <label class="form-label">Table Row</label>

      <!-- Input and Button on the same row -->
      <div class="d-flex align-items-center gap-2">
        <input
            type="number"
            v-model.number="form.tableRow"
            min="1"
            max="25"
            class="form-control w-50"
        />
        <button class="btn tag-btn" @click="addMultipleRows">Add Multiple Row</button>
      </div>

      <!-- Span below input -->
      <span class="text-danger mt-1 d-block" style="font-size: 12px;">
    * Maximum: 25 Row
  </span>
    </div>


    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Reward</th>
          <th>Rank From</th>
          <th>Rank To</th>
          <th>Get Bonus/Point</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(row, index) in rankingRows" :key="index">
          <td class="align-middle" style="font-weight: 500; font-size: 13px;">{{ index + 1 }}.</td>
          <td class="align-middle">
            <select v-model="row.rewardType" class="form-select">
              <option value="">Please Select Type</option>
              <option value="cash">Cash</option>
              <option value="voucher">Voucher</option>
              <option value="gift">Gift</option>
            </select>
          </td>
          <td class="align-middle">
            <input type="number" v-model="row.rankFrom" disabled class="form-control border-warning"/>
          </td>
          <td class="align-middle">
            <input type="number" v-model="row.rankTo" class="form-control" placeholder="Optional"/>
          </td>
          <td class="align-middle">
            <input type="number" v-model="row.bonusPoint" class="form-control"/>
          </td>
          <td class="align-middle text-center" v-if="index > 0">
            <X size="18" @click="removeRow(index)" style="cursor: pointer"/>
          </td>
          <td v-else></td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
              @click="addRow">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
    </div>
    <div class="d-flex justify-content-center mt-3">
      <button class="btn tag-btn" @click="submit">Save</button>
    </div>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import Multiselect from "vue-multiselect";
import {onMounted, ref} from "vue";
import TournamentSettingListDisplaySettingModal
  from "@/views/TournamentViews/modals/TournamentSettingListDisplaySettingModal.vue";
import {CirclePlus, X} from "lucide-vue-next";

const memberGroups = ['All', 'Regular', 'Regular 2', 'Risk', 'PLATINUM', 'DIAMOND', 'PAYMENT GATEWAY TEST'];
const memberTags = ['All', 'Same IP', 'Same Fingerprint', 'Same Real Name', 'Same Email', 'Same Mobile Number', 'Same Password'];

const form = ref({
  memberGroup: [],
  merchant: "MJB",
  activityName: "",
  currency: "BDT",
  periodType: "",
  startDate: new Date().toISOString().slice(0, 10),
  endDate: new Date().toISOString().slice(0, 10),
  method: "",
  autoRelease: false,
  manualRelease: false,
  displayReward: false,

  memberTag: "",
  violationCount: "",

  tableRow: 1,

});

const rankingRows = ref([
  {
    rewardType: '',
    rankFrom: 1,
    rankTo: '',
    bonusPoint: ''
  }
]);

const addRow = () => {
  if (rankingRows.value.length < 25) {
    rankingRows.value.push({
      rewardType: '',
      rankFrom: rankingRows.value.length + 1,
      rankTo: '',
      bonusPoint: ''
    });
  }
};

const addMultipleRows = () => {
  const rowsToAdd = Math.min(25 - rankingRows.value.length, form.value.tableRow || 0);
  for (let i = 0; i < rowsToAdd; i++) {
    addRow();
  }
  form.value.tableRow = 1;
};

const removeRow = (index) => {
  rankingRows.value.splice(index, 1);
  rankingRows.value.forEach((row, i) => {
    row.rankFrom = i + 1;
  });
};

const showDisplaySettingModal = ref(false);

const handleFormSubmit = () => {
  console.log("Form Submitted", form.value);
  submit();
  // Likely an API POST or Vuex store dispatch goes here
};

const getSystemGMT = () => {
  const timeZoneOffset = new Date().getTimezoneOffset();
  const offsetHours = -timeZoneOffset / 60;
  return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
};

onMounted(() => {
  form.value.timeZone = getSystemGMT();
});

const router = useRouter();

const mode = ref('single');

const submit = () => {
  const payload = {
    ...form.value,
    mode: mode.value
  };

  router.push({
    name: 'tournament-setting-list',
    state: {newTournamentSetting: payload}
  });
};

</script>

<style scoped>

.form-container {
  width: 99%;
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-header {
  padding-right: 10px;
  padding-left: 7px;
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

input, select, textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

.btn-text-sm {
  font-size: 12px;
}

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #595959;
  font-weight: 500;
  font-size: 13px;
  color: white;
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

.checkbox-label {
  margin-bottom: 6px;
}

.custom-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.custom-checkbox:checked {
  background-color: #f1c40f;
  border-color: #f1c40f;
}

.custom-checkbox:checked::after {
  content: '✓';
  color: #fff !important;
  font-size: 11px;
  position: absolute;
  left: 2px;
  top: -1px;
}

.custom-checkbox:hover {
  border-color: #d4ac0d;
}
</style>