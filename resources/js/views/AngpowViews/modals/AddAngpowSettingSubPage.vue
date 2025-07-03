<template>
  <AddDisplaySettingsModal v-model="showDisplaySettingModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Angpow</h2>
      <p class="breadcrumb">Angpow > <strong>Angpow Setting</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2" @click="showDisplaySettingModal = true">
        Display Setting
      </button>
      <button class="btn btn-outline-dark add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/angpow-setting');">
        Table List
      </button>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Period Setting</h2>
    </div>

    <div class="row gx-3 gy-3">
      <div class="col-md-4 col-lg-4">
        <label>Start Date</label>
        <input type="date" v-model="form.startDate" class="form-control"/>
      </div>

      <div class="col-md-4 col-lg-4">
        <label>End Date</label>
        <input type="date" v-model="form.endDate" class="form-control"/>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Exclude Day (Optional)</label>
        <Multiselect
            v-model="form.excludeDay"
            :options="excludeDays"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            placeholder=""
        />
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Time Type</label>
        <select v-model="form.timeType" type="text" class="form-select">
          <option>Full Day</option>
          <option>Half Day</option>
        </select>
      </div>

      <span style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
        Please be reminded that this date input are GMT+8 standard.
      </span>

    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Edit Angpow</h2>
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

      <div class="col-md-12 col-lg-12">
        <label>Member Tag that can only draw the risk control prize (The rest can draw all rewards).</label>
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
        <label class="form-label">Method</label>
        <select v-model="form.method" type="text" class="form-select">
          <option>Deposit</option>
          <option>Withdrawal</option>
        </select>
      </div>

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

    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Claim Setting</h2>
    </div>

    <div class="row gx-3 gy-3">
      <div class="col-md-4 col-lg-4">
        <label class="form-label">Total bonus reward amount capital</label>
        <input v-model="form.totalBonusRewardAmountCapital" type="text" class="form-control"/>
        <div class="form-check form-check-inline">
          <input class="form-check-input custom-checkbox" type="checkbox" id="autoRelease"
                 v-model="form.noMaxTotalBonus">
          <label class="form-check-label checkbox-label" for="autoRelease">No Max</label>
        </div>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Total claim quantity limit</label>
        <input v-model="form.totalClaimQuantityLimit" type="text" class="form-control"/>
        <div class="form-check form-check-inline">
          <input class="form-check-input custom-checkbox" type="checkbox" id="noMax"
                 v-model="form.noMaxTotalClaim">
          <label class="form-check-label checkbox-label" for="noMax">No Max</label>
        </div>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Daily claim quantity limit</label>
        <input v-model="form.dailyClaimQuantityLimit" type="text" class="form-control"/>
        <div class="form-check form-check-inline">
          <input class="form-check-input custom-checkbox" type="checkbox" id="noMax"
                 v-model="form.noMaxDailyClaim">
          <label class="form-check-label checkbox-label" for="noMax">No Max</label>
        </div>
      </div>

      <div class="col-md-4 col-lg-4">
        <label class="form-label">Daily player claim quantity limit</label>
        <input v-model="form.dailyPlayerClaimQuantityLimit" type="text" class="form-control"/>
        <div class="form-check form-check-inline">
          <input class="form-check-input custom-checkbox" type="checkbox" id="noMax"
                 v-model="form.noMaxDailyPlayerClaim">
          <label class="form-check-label checkbox-label" for="noMax">No Max</label>
        </div>
      </div>

      <div class="col-md-2 col-lg-2">
        <label class="form-label">Time Gap</label>
        <input v-model="form.timeGap" type="text" class="form-control border-warning" disabled/>
      </div>

      <div class="col-md-2 col-lg-2">
        <label class="form-label">Time</label>
        <select v-model="form.time" type="text" class="form-select">
          <option>No Limit</option>
        </select>
      </div>

    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Deposit Criteria</h2>
    </div>

    <div class="col-lg-4 col-md-4 mb-3">
      <label class="form-label">Valid Period Limit</label>
      <div class="d-flex align-items-center gap-2">
        <input
            type="text"
            v-model.number="form.validPeriodLimit"
            class="form-control"
        />
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead class="table-dark">
        <tr>
          <th class="text-center">No</th>
          <th class="text-center">Reward</th>
          <th class="text-center">Deposit Amount</th>
          <th class="text-center">Get Bonus/Point</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(row, index) in rankingRows" :key="index">
          <td class="align-middle" style="font-weight: 500; font-size: 13px;">{{ index + 1 }}.</td>

          <td class="align-middle">
            <select v-model="row.reward" class="form-select py-1" style="font-size: 13px;">
              <option>Activity Point</option>
            </select>
          </td>

          <td class="align-middle">
            <div class="d-flex align-items-center gap-2">
              <label style="white-space: nowrap; font-size: 13px;">Deposit Amount ≥</label>
              <input type="number" v-model="row.depositAmount" disabled
                     class="form-control form-control-sm border border-warning" style="width: 100px; font-size: 13px;"/>
              <span style="font-size: 13px;">BDT</span>
            </div>
          </td>

          <td class="align-middle">
            <div class="d-flex align-items-center gap-2">
              <label style="white-space: nowrap; font-size: 13px;">Nized Amount Range ≥</label>
              <input type="number" v-model="row.getBonusPointMin" class="form-control form-control-sm"
                     style="width: 80px; font-size: 13px;" placeholder="Min"/>
              <span>~</span>
              <input type="number" v-model="row.getBonusPointMax" class="form-control form-control-sm"
                     style="width: 80px; font-size: 13px;" placeholder="Max"/>
            </div>
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

    <span class="mt-1 d-block d-flex justify-content-end" style="font-size: 12px; color: #ae0404">
        * Maximum: 10 Row
    </span>

  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">KYC Setting</h2>
    </div>

    <label class="form-label">KYC Option</label>
    <div class="mb-3 d-flex flex-wrap gap-2">
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Verified Mobile</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Verified Profile</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Verified Email</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Verified Bank</button>
    </div>

    <div style="font-size: 12px;">
      Need to verify at least
      <input type="number" disabled class="form-control d-inline-block mx-2 border-warning" style="width: 80px;"
             v-model="form.violationCount"/>
      conditions, <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
        * else request will be auto declined.</span>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Setting</h2>
    </div>

    <label class="form-label">Risk Options</label>
    <div class="mb-3 d-flex flex-wrap gap-2">
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Unique fingerprint</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Unique IP</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Unique Name</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Unique Email</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Unique Mobile</button>
    </div>

    <div class="mb-2" style="font-size: 12px;">
      <label class="form-label">Violation Count Setting</label>
      <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
          * If the number of violations is over, the player is not allowed to apply to this angpow reward.
        </span>
    </div>

    <div style="font-size: 12px;">
      If violation count is above
      <input type="number" disabled class="form-control d-inline-block mx-2 border-warning" style="width: 80px;"
             v-model="form.violationCountRisk"/>
      conditions, <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
        * The player will automatically get the risk control prize.</span>
    </div>

  </div>

  <div class="form-container mb-3">
    <div class="mb-3">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Control Prize</h2>
    </div>

    <label class="form-label">
      1. Numbers of violated risk controls.
    </label>
    <br/>
    <label class="form-label">
      2. The level of the member is not eligible for all prizes.
    </label>
    <br/>
    <label class="form-label">
      3. Designated tag
    </label>
    <br/>
    <label class="form-label">
      4. The player will win the risk control prize if any above 3 condition is met, otherwise, the drawing condition
      follows the set probabilities.
    </label>

    <div class="row gx-3 gy-3">
      <div class="col-md-3 col-lg-3">
        <select v-model="form.controlPrize" class="form-select">
          <option>Activity Point</option>
        </select>
      </div>

      <div class="col-md-3 col-lg-3">
        <input v-model="form.amountFrom" type="number" class="form-control" placeholder="Amount From"/>
      </div>

      <div class="col-md-1 col-lg-1">
        <span>~</span>
      </div>

      <div class="col-md-3 col-lg-3">
        <input v-model="form.amountTo" type="number" class="form-control" placeholder="Amount To"/>
      </div>

      <div class="col-lg-2 col-md-2">
        <div class="form-check">
          <label class="form-check-label checkbox-label" for="freeToBet">Do not win</label>
          <input class="form-check-input custom-checkbox" type="checkbox" id="doNotWin" v-model="form.doNotWin"/>
        </div>
      </div>

    </div>

    <div class="d-flex justify-content-center mt-3">
      <button class="btn tag-btn" @click="submit">Save</button>
    </div>

  </div>
</template>


<script setup>
import {useRouter} from 'vue-router';
import {onMounted, ref} from "vue";
import {CirclePlus, X} from "lucide-vue-next";
import AddDisplaySettingsModal from "@/views/SoccerViews/modals/AddDisplaySettingsModal.vue";
import Multiselect from "vue-multiselect";

const memberGroups = ['All', 'Regular', 'Regular 2', 'Risk', 'PLATINUM', 'DIAMOND', 'PAYMENT GATEWAY TEST'];
const memberTags = ['All', 'Same IP', 'Same Fingerprint', 'Same Real Name', 'Same Email', 'Same Mobile Number', 'Same Password'];
const excludeDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

const form = ref({
  excludeDay: "",
  timeType: "Full Day",
  startDate: new Date().toISOString().slice(0, 10),
  endDate: new Date().toISOString().slice(0, 10),
  memberGroup: [],
  memberTag: [],
  merchant: 'MJB',
  currency: 'BDT',
  activityName: '',
  method: 'Deposit',
  autoRelease: true,
  manualRelease: false,
  totalBonusRewardAmountCapital: '',
  noMaxTotalBonus: false,
  totalClaimQuantityLimit: '',
  noMaxTotalClaim: false,
  dailyClaimQuantityLimit: '',
  noMaxDailyClaim: false,
  dailyPlayerClaimQuantityLimit: '',
  noMaxDailyPlayerClaim: false,
  timeGap: '',
  time: 'No Limit',
  validPeriodLimit: 'No Limit',
  violationCount: "",
  violationCountRisk: "",
  controlPrize: "Activity Point",
  amountFrom: "",
  amountTo: "",
  doNotWin: false,

  tableRow: 1,

});

const rankingRows = ref([
  {
    reward: 'Activity Point',
    depositAmount: '',
    rankTo: '',
    getBonusPointMin: '',
    getBonusPointMax: '',
  }
]);

const addRow = () => {
  if (rankingRows.value.length < 25) {
    rankingRows.value.push({
      reward: 'Activity Point',
      depositAmount: '',
      rankTo: '',
      getBonusPointMin: '',
      getBonusPointMax: '',
    });
  }
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
    name: 'angpow-setting',
    state: {newAngpowSetting: payload}
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

.btn-text-sm {
  font-size: 12px;
}
</style>