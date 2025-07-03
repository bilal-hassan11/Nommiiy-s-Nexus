<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Rebate</h2>
      <p class="breadcrumb">Rebate > Rebate Setting <strong>> Add</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2"
              @click="this.$router.push('/rebate-setting');">
        Back To List
      </button>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="row gx-3 gy-3">
      <div class="col-md-2 col-lg-2">
        <label>Rebate Title*</label>
        <input type="text" v-model="form.rebateTitle" class="form-control" required>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Description</label>
        <input type="text" v-model="form.description" class="form-control">
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Start Date</label>
        <input type="date" v-model="form.startDate" class="form-control"/>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>End Date</label>
        <input type="date" v-model="form.endDate" class="form-control"/>
      </div>
      <div class="col-md-3 col-lg-3">
        <label>Date Range</label>
        <div class="row gap-2" style="margin: 10px 1px 10px 4px;">
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                  :class="{'btn-active': activeRange === 'Daily'}"
                  @click="filterByDateRange('Daily')">Daily
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                  :class="{'btn-active': activeRange === 'Weekly'}"
                  @click="filterByDateRange('Weekly')">Weekly
          </button>
          <button class="col-lg-2 col-md-1 recent btn btn-light text-center"
                  :class="{'btn-active': activeRange === 'Monthly'}"
                  @click="filterByDateRange('Monthly')">Monthly
          </button>
        </div>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Rebate Type</label>
        <input type="text" v-model="form.rebateType" class="form-control border-warning" disabled>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Release Method*</label>
        <select v-model="form.releaseMethod" class="form-select" placeholder="Please Select Method" required>
          <option value="" selected disabled>Please Select Method</option>
          <option>Method 1</option>
          <option>Method 2</option>
          <option>Method 3</option>
        </select>
      </div>
      <div class="col-lg-2 col-md-2 mb-3">
        <label class="form-label d-block mb-1">Status</label>
        <div class="form-check form-check-inline" v-for="row in ['Active', 'Inactive']" :key="row">
          <input class="form-check-input" type="radio" :id="'row-' + row" :value="row.toString()"
                 v-model="form.status"/>
          <label class="form-check-label me-2" :for="'row-' + row">{{ row }}</label>
        </div>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Member Group*</label>
        <select v-model="form.memberGroup" class="form-select" placeholder="Please Select Member Group" required>
          <option value="" selected disabled>Please Select Member Group</option>
          <option>Regular</option>
          <option>Risk</option>
          <option>DIAMOND</option>
        </select>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Member Tag</label>
        <select v-model="form.memberTag" class="form-select" placeholder="Please Select Member Tag">
          <option value="" selected disabled>Please Select Member Tag</option>
          <option>Same IP</option>
          <option>Same Fingerprint</option>
          <option>Same Email</option>
        </select>
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Currency</label>
        <Multiselect
            v-model="form.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Please Select Currency"
        />
      </div>
      <div class="col-md-2 col-lg-2">
        <label>Product Type*</label>
        <select v-model="form.productType" class="form-select" placeholder="Please Select Type" required>
          <option value="" selected disabled>Please Select Type</option>
          <option>Type 1</option>
          <option>Type 2</option>
          <option>Type 3</option>
        </select>
      </div>
      <div class="col-md-3 col-lg-3">
        <label>Game Exclude List</label>
        <Multiselect
            v-model="form.game"
            :options="games"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Please Select Game"
        />
      </div>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="row align-items-center">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 style="font-size: 22px; color: #5a5858; font-weight: 500">Rebate Condition</h2>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
        <button class="btn tag-btn me-2"
                title="Apply the setting values of the first game vendor's game group to all settings">
          One Click Setup
        </button>
      </div>
    </div>

    <div class="row gx-3 gy-3 mt-2">
      <div class="col-md-4 col-lg-4">
        <label class="form-label d-block">Max Group Rebate*</label>
        <div class="form-check form-check-inline d-block mb-2">
          <input class="form-check-input custom-checkbox border-warning" type="checkbox" id="autoRelease"
                 v-model="form.setUnlimited">
          <label class="form-check-label checkbox-label" for="autoRelease">Tick to Set Unlimited</label>
        </div>
        <input v-model="form.maxGroupRebate" type="text" class="form-control" placeholder="Type in number"/>
      </div>
    </div>

    <div class="table-responsive mt-4">
      <table class="table">
        <thead>
        <tr>
          <th>Game Provider</th>
          <th>Game Group</th>
          <th>Turnover (>=1)</th>
          <th>Rebate% (Recommend <=1)</th>
          <th>Max Rebate (0 is Unlimited)</th>
          <th>Game To Exclude</th>
          <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-if="rankingRows.length === 0">
          <td colspan="7" class="text-start">No Records</td>
        </tr>

        <!-- Dynamic rows if data exists -->
        <tr v-else v-for="(row, index) in rankingRows" :key="index">
          <td>{{ row.gameProvider }}</td>
          <td>{{ row.gameGroup }}</td>
          <td>{{ row.turnover }}</td>
          <td>{{ row.rebatePercent }}</td>
          <td>{{ row.maxRebate }}</td>
          <td>{{ row.gamesToExclude }}</td>
          <td><!-- Action buttons or controls here --></td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="row align-items-center">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 style="font-size: 22px; color: #5a5858; font-weight: 500">Withdrawal Condition</h2>
      </div>
    </div>

    <div class="row gx-3 gy-3 mt-2">
      <div class="col-md-4 col-lg-4">
        <label class="form-label d-block">Rebate Condition Multiplier*</label>
        <input v-model="form.rebateConditionMultiplier" type="text" class="form-control" placeholder="Type in number"/>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center mt-3">
    <button class="btn tag-btn" @click="submit">Submit</button>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import {onMounted, ref} from "vue";
import Multiselect from "vue-multiselect";

const router = useRouter();

const currencies = ref(["BDT", "NPR"]);
const games = ref(["MineCraft", "GTA"]);
const mode = ref('single');
const rankingRows = ref([]);
const activeRange = ref('Daily'); // Set default to Daily


const formatDate = (date) => {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
};

const getDefaultDates = () => {
  const today = new Date();
  const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
  return {
    firstDay: formatDate(firstDay),
    today: formatDate(today),
  };
};

const {firstDay, today} = getDefaultDates();

const form = ref({
  rebateTitle: "",
  description: "",
  startDate: firstDay,
  endDate: today,
  rebateType: "Turnover",
  releaseMethod: "",
  status: "Active",
  memberGroup: "",
  memberTag: "",
  currency: "BDT",
  productType: "",
  game: "",
  setUnlimited: false,
  maxGroupRebate: "",
  rebateConditionMultiplier: "",
  createdAt: "",
  completedAt: "",
});

const filterByDateRange = (range) => {
  activeRange.value = range;
  const today = new Date();

  if (range === 'Daily') {
    form.value.createdAt = formatDate(today);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Weekly') {
    const lastWeek = new Date(today);
    lastWeek.setDate(today.getDate() - 6); // Last 7 days including today
    form.value.createdAt = formatDate(lastWeek);
    form.value.completedAt = formatDate(today);
  } else if (range === 'Monthly') {
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    form.value.createdAt = formatDate(firstDayOfMonth);
    form.value.completedAt = formatDate(today);
  }
};

// Apply default date range on mount
onMounted(() => {
  filterByDateRange('Daily');
});

const submit = () => {
  const payload = {
    ...form.value,
    mode: mode.value
  };

  router.push({
    name: 'rebate-setting',
    state: {newRebateSetting: payload}
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

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #fdead3;
  font-weight: 500;
  font-size: 13px;
  color: #4e4e4e;
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

.recent {
  width: 85px;
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

</style>