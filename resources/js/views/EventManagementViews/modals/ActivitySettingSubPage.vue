<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Event Management</h2>
      <p class="breadcrumb">Event Management > <strong>Activity Setting</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <div class="dropdown">
        <button class="btn btn-primary settings-btn dropdown-toggle me-2" type="button" id="settingsDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
          Settings
        </button>
        <ul class="dropdown-menu" style="border-color: #ffcc00; font-size: 14px;" aria-labelledby="settingsDropdown">
          <li><a class="dropdown-item" href="#">Currency Rate</a></li>
          <li><a class="dropdown-item" href="#">Spin Display</a></li>
          <li><a class="dropdown-item" href="#">Activity Point Expired Time</a></li>
        </ul>
      </div>

      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/activity-setting');">
        Table List
      </button>
    </div>
  </div>

  <div class="row">
    <div class="container mb-3 pb-5 col-lg-6">
      <div class="p-2 mb-3" style="background: #fff8e1">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Basic Setting</h2>
      </div>

      <div class="row gx-3 gy-3">
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Activity Name*</label>
          <input v-model="form.activityName" type="text" class="form-control" placeholder="Enter Activity Name"/>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Activity Type</label>
          <select v-model="form.activityType" class="form-select">
            <option value="Lucky Wheel">Lucky Wheel</option>
            <!-- Add more types as needed -->
          </select>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Currency</label>
          <select v-model="form.currency" class="form-select">
            <option value="BDT">BDT</option>
            <option value="NPR">NPR</option>
            <!-- Add more types as needed -->
          </select>
        </div>

        <div class="col-md-12 col-lg-12">
          <label class="form-label">Activity Period*</label>
          <span style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #ae0404">(Both Start and End Time are GMT +8)</span>
          <div>
            <button class="btn add-btn btn-outline-secondary me-2" @click="form.periodType = 'indefinite'">Indefinite
            </button>
            <button class="btn add-btn btn-outline-secondary" @click="form.periodType = 'date'">Date Period</button>
          </div>
        </div>

        <div class="col-md-6 col-lg-6">
          <label>Start Date</label>
          <input type="date" v-model="form.startDate" class="form-control"/>
        </div>
      </div>
    </div>

    <div class="container mb-3 pb-5 col-lg-5">
      <div class="p-2 mb-3" style="background: #fff8e1">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Verification Setting</h2>
      </div>

      <div class="row gx-3 gy-3">
        <div class="col-md-12 col-lg-12">
          <label class="col-md-5 col-lg-5 form-label">Verification Type</label>
          <button class="col-md-3 col-lg-2 settings-btn btn btn-outline-warning"
                  @click="form.verificationType = 'auto'">Auto
          </button>
        </div>

        <div class="col-md-12 col-lg-12">
          <label class="form-label">Member Group that can draw all reward (The rest can only draw the risk control
            prize)</label>
          <select v-model="form.fullRewardGroup" class="form-select">
            <option value="groupA">Group A</option>
          </select>
        </div>

        <div class="col-md-12 col-lg-12">
          <label class="form-label">Member Tag that can only draw the risk control prize (The rest can draw all
            reward)</label>
          <select v-model="form.riskControlTag" class="form-select">
            <option value="tagX">Tag X</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="form-container mb-3 pb-5">
    <!-- Risk Setting Header -->
    <div class="p-2 mb-3" style="background: #fff8e1">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Setting</h2>
    </div>

    <!-- Risk Options -->
    <div class="px-3 py-2">
      <label class="form-label">Risk Options</label>
      <div class="mb-3 d-flex flex-wrap gap-2">
        <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same IP address</button>
        <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same finger print ID</button>
        <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same real name</button>
        <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same mobile number</button>
        <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same email address</button>
      </div>

      <!-- Violation Count Setting -->
      <div class="mb-2" style="font-size: 12px;">
        <label class="form-label">Violation Count Setting</label>
        <span class="text-danger mx-3">
          * If the number of violations is over, only the preset rewards will be got
        </span>
      </div>
      <div style="font-size: 12px;">
        If violated count is above or equal
        <input type="number" disabled class="form-control d-inline-block mx-2" style="width: 80px;"
               v-model="form.violationCount"/>
        conditions, <span class="text-danger">the player will automatically get the risk control prize</span>
      </div>
    </div>
  </div>

  <div class="form-container mb-3 pb-5">
    <!-- Risk Setting Header -->
    <div class="p-2 mb-3" style="background: #fff8e1">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Lucky Wheel Prize Setting</h2>
    </div>
    <div class="px-3 py-2">
      <label class="form-label">Spin the Lucky Wheel</label>
      <!-- Activity Points Input -->
      <div class="row align-items-start">
        <!-- Left side: form controls -->
        <div class="col-lg-8">
          <div class="form-group row align-items-center mb-2" style="font-size: 12px;">
            <label class="col-auto col-form-label">Activity Points</label>
            <div class="col-auto">
              <input type="number" class="form-control form-control-sm" v-model="form.activityPoints"/>
            </div>
            <label class="col-auto col-form-label">Point(s)/Times</label>
          </div>

          <div class="mb-2 col-lg-3" style="font-size: 12px;">
            <label class="form-label">Amount of Prizes</label>
            <select v-model="form.amountOfPrizes" class="form-select">
              <option value="6">6</option>
            </select>
          </div>
        </div>

        <!-- Right side: image -->
        <div class="col-lg-4 text-center">
          <img :src="wheelImage" alt="Wheel Preview" style="max-width: 150px;"/>
        </div>
      </div>

      <div class="mb-2 mt-4 col-lg-6" style="font-size: 12px;">
        <label class="row form-label">Prize Types</label>
        <label class="row form-label">Prize Spot: It will be arranged clockwise from the middle according to the
          number</label>
        <label class="row form-label">Prize: Can be duplicate</label>
        <label class="row form-label">Amount / Quantity: The minimum value is 0.1, the minimum amount is 1.</label>
        <label class="row form-label">Condition Multiplier: can be set to 0 without an audit.</label>
        <label class="row form-label">Prize Name: Display on the roulette wheel, you can fill in up to 40
          characters.</label>
        <label class="row form-label">Probability: The probability of all rewards is added upto 100% and the minimum
          probability is 0%.</label>
        <label class="row form-label">Total Amount: For each of the rewards; the total number is set to a minimum of 0,
          and every 1 draw will be
          reduced until the number is 0, there will be no more draws.</label>
        <label class="row form-label">The supplementary setting of the total quantity: Three kinds of additional items
          can be choosen.</label>
      </div>

      <div class="table-responsive mt-5 overflow-auto">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Prize Spot</th>
            <th>Prize</th>
            <th>Amount</th>
            <th>Turnover Multiplier</th>
            <th>Prize Name</th>
            <th>Probability</th>
            <th>Restock Option</th>
            <th>Total Quantity</th>
            <th>Wheel Image</th>
            <th>Wheel Image Display</th>
            <th>Prize Image</th>
            <th>Prize Sequence</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(prize, index) in prizeList" :key="index">
            <td>{{ prize.prizeSpot }}</td>
            <td style="min-width: 120px">
              <select v-model="prize.prize" class="form-select">
                <option>Fixed Prize</option>
              </select>
            </td>
            <td>
              <input type="text" class="form-control" v-model="prize.amount"/>BDT
            </td>
            <td>
              <input type="text" class="form-control" v-model="prize.turnoverMultiplier"/>
            </td>
            <td>
              <input type="text" class="form-control" v-model="prize.prizeName"/>
            </td>
            <td>
              <input type="text" class="form-control" v-model="prize.probability"/>%
            </td>
            <td style="min-width: 120px">
              <select v-model="prize.restockOption" class="form-select">
                <option>No Restock</option>
              </select>
            </td>
            <td>
              <input type="text" class="form-control" v-model="prize.totalQuantity"/>
            </td>
            <td>
              <input type="file" class="form-control" @change="e => handleImageUpload(e, index, 'wheelImage')"/>
              <label class="form-label">Image size limit 200px * 200px</label>
            </td>
            <td>
              <div class="d-flex flex-column">
                <div class="d-flex align-items-center mb-2">
                  <input
                      type="radio"
                      :name="'wheelDisplay_' + index"
                      :id="'displayName_' + index"
                      value="displayName"
                      class="me-2"
                      v-model="prize.wheelImageDisplay"
                  />
                  <label :for="'displayName_' + index">Display Name</label>
                </div>
                <div class="d-flex align-items-center">
                  <input
                      type="radio"
                      :name="'wheelDisplay_' + index"
                      :id="'displayNameAndImage_' + index"
                      value="displayNameAndImage"
                      class="me-2"
                      v-model="prize.wheelImageDisplay"
                  />
                  <label :for="'displayNameAndImage_' + index">Display Name and Image</label>
                </div>
              </div>
            </td>
            <td>
              <input type="file" class="form-control" @change="e => handleImageUpload(e, index, 'prizeImage')"/>
              <label class="form-label">Image size limit 200px * 200px</label>
            </td>
            <td style="min-width: 80px">
              <select v-model="prize.prizeSequence" class="form-select">
                <option>1</option>
                <option>2</option>
                <option>3</option>
              </select>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="form-container mb-3 pb-5">
    <!-- Risk Setting Header -->
    <div class="p-2 mb-3" style="background: #fff8e1">
      <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Control Prize</h2>
    </div>
    <div class="px-3 py-2">
      <div class="mb-2 col-lg-6" style="font-size: 12px;">
        <label class="row form-label">1. Numbers of violated risk controls.</label>
        <label class="row form-label">2. The level of the member is not eligible for all the prizes.</label>
        <label class="row form-label">3. Designated tag</label>
        <label class="row form-label">4. All the prize amount is 0, no prize has been replenished.</label>
        <label class="row form-label">5. The player will win the risk control prize if any above 4 condition is met.
          Otherwise
          the drawing condition follows the set probabilities.</label>
      </div>
      <div class="row align-items-start">
        <div class="col-lg-8">
          <div class="mb-2 col-lg-3" style="font-size: 12px;">
            <select v-model="form.riskControl" class="form-select">
              <option value="" selected> Click to select</option>
            </select>
          </div>
        </div>
      </div>

      <div class="table-responsive mt-5 overflow-auto">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Prize</th>
            <th>Amount</th>
            <th>Turnover Multiplier</th>
            <th>Prize Name</th>
            <th>Probability</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(prize, index) in riskControlPrizeList" :key="index">
            <td>{{ prize.prize }}</td>
            <td>{{ prize.amount }}</td>
            <td>{{ prize.turnoverMultiplier }}</td>
            <td>{{ prize.prizeName }}</td>
            <td>{{ prize.probability }}</td>
          </tr>
          </tbody>
        </table>
      </div>

    </div>
    <div class="col-12 d-flex justify-content-end gap-2">
      <button class="search-btn btn btn-primary text-dark" @click="handleFormSubmit">Add</button>
    </div>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import {onMounted, ref} from "vue";
import wheelImage from '@/assets/lucky_wheel.jpg';

const form = ref({
  activityName: "",
  activityType: "Lucky Wheel",
  merchant: "MJB",
  currency: "BDT",
  startDate: new Date().toISOString().slice(0, 10),
  fullRewardGroup: "",
  riskControlTag: "",
  violationCount: "",
  activityPoints: "",
  amountOfPrizes: "6",
  riskControl: "",
});

const handleFormSubmit = () => {
  console.log("Form Submitted", form.value, prizeList.value, riskControlPrizeList.value);
  submit();
  // Likely an API POST or Vuex store dispatch goes here
};

const handleImageUpload = (event, index, type) => {
  const file = event.target.files[0];
  if (file) {
    prizeList.value[index][type] = file;
  }
};

const getSystemGMT = () => {
  const timeZoneOffset = new Date().getTimezoneOffset();
  const offsetHours = -timeZoneOffset / 60;
  return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
};

onMounted(() => {
  form.value.timeZone = getSystemGMT();
});

const riskControlPrizeList = ref([
  {
    prize: "Fixed Prize",
    amount: "100",
    turnoverMultiplier: "1",
    prizeName: "Risk Control Reward",
    probability: "100"
  }
]);
const prizeList = ref([
  {
    prizeSpot: '1',
    prize: "Fixed Prize",
    amount: '',
    turnoverMultiplier: '',
    prizeName: '',
    probability: '',
    restockOption: "No Restock",
    totalQuantity: '',
    wheelImage: '',
    wheelImageDisplay: "displayName",
    prizeImage: '',
    prizeSequence: '1',
  },
  {
    prizeSpot: '2',
    prize: "Fixed Prize",
    amount: '',
    turnoverMultiplier: '',
    prizeName: '',
    probability: '',
    restockOption: "No Restock",
    totalQuantity: '',
    wheelImage: '',
    wheelImageDisplay: "displayName",
    prizeImage: '',
    prizeSequence: '2',
  },
  {
    prizeSpot: '3',
    prize: "Fixed Prize",
    amount: '',
    turnoverMultiplier: '',
    prizeName: '',
    probability: '',
    restockOption: "No Restock",
    totalQuantity: '',
    wheelImage: '',
    wheelImageDisplay: "displayName",
    prizeImage: '',
    prizeSequence: '3',
  },
]);

const router = useRouter();

const mode = ref('single');

const submit = () => {
  const payload = {
    ...form.value,
    mode: mode.value
  };

  router.push({
    name: 'activity-setting',
    state: {newActivitySetting: payload}
  });
};

const cancel = () => {
  router.push({name: 'activity-setting'});
};
</script>

<style scoped>
.container {
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
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

.settings-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  color: #2c2c2c;
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

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 8px 35px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #a18923;
}
</style>