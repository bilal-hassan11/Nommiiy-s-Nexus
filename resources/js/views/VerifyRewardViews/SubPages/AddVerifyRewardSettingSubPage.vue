<template>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Verify Reward</h2>
      <p class="breadcrumb">Verify Reward > <strong>Verify Reward Settings</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-dark add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/verify-reward-settings');">
        Table List
      </button>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3 p-2" style="background: #fdf3e5">
      <h2 style="font-size: 16px; color: #424242; font-weight: 500">Basic Setting</h2>
    </div>

    <div class="row gx-3 gy-3">
      <div class="col-md-12 col-lg-12">
        <label class="form-label">Merchant</label>
        <select v-model="form.merchant" type="text" class="form-select">
          <option>MJB</option>
          <option>MJB2</option>
        </select>
      </div>

      <div class="col-md-12 col-lg-12">
        <label class="form-label">Currency</label>
        <select v-model="form.currency" class="form-select">
          <option value="BDT">BDT</option>
          <option value="NPR">NPR</option>
        </select>
      </div>

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
      </div>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3 p-2" style="background: #fdf3e5;">
      <h2 style="font-size: 16px; color: #424242; font-weight: 500">Risk Setting</h2>
    </div>

    <div class="col-md-12 col-lg-12">
      <label class="form-label">
        Member Tag Setting
        <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
            *If the player is under these member tag, the player is not allowed to apply to this verify reward.
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

    <label class="form-label">Risk Options</label>
    <div class="mb-3 d-flex flex-wrap gap-2">
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same fingerprint ID</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same IP address</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same real name</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same email address</button>
      <button class="btn btn-outline-secondary btn-sm btn-text-sm">Do not allow same mobile number</button>
    </div>

    <div class="mb-2" style="font-size: 12px;">
      <label class="form-label">Violation Count Setting</label>
      <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
          * If the number of violations is over, the player is not allowed to apply to this verify reward.
        </span>
    </div>
    <div style="font-size: 12px;">
      If violated count is above or equal
      <input type="number" disabled class="form-control d-inline-block mx-2" style="width: 80px;"
             v-model="form.violationCount"/>
      conditions, <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
        * The player will automatically to be declined from this verify reward.</span>
    </div>
  </div>

  <div class="form-container mb-3">
    <div class="mb-3 p-2" style="background: #fdf3e5;">
      <h2 style="font-size: 16px; color: #424242; font-weight: 500">Reward Setting</h2>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark text-center">
        <tr>
          <th class="text-center">Display</th>
          <th class="text-center">Type</th>
          <th class="text-center">Fixed Reward</th>
          <th class="text-center">Turnover Multiplier</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(reward, index) in rewardSettings" :key="index" :class="index % 2 === 1 ? 'bg-light' : ''">
          <td class="text-center align-middle">
            <input type="checkbox" class="custom-checkbox" v-model="reward.display"/>
          </td>
          <td class="align-middle text-center">{{ reward.type }}</td>
          <td>
            <input type="number" v-model="reward.fixedReward" class="form-control text-center"/>
          </td>
          <td>
            <input type="number" v-model="reward.turnoverMultiplier" class="form-control text-center"/>
          </td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="row mt-3">
      <div class="col-md-6">
        <label class="form-label">Min Deposit (Accumulate)</label>
        <input type="number" v-model="minDeposit" class="form-control"/>
      </div>
      <div class="col-md-6">
        <label class="form-label">Min Withdraw (Accumulate)</label>
        <input type="number" v-model="minWithdraw" class="form-control"/>
      </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <button class="btn tag-btn" @click="submit">
        Add
      </button>
    </div>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import Multiselect from "vue-multiselect";
import {ref} from "vue";

const memberGroups = ['All', 'Regular', 'Regular 2', 'Risk', 'PLATINUM', 'DIAMOND', 'PAYMENT GATEWAY TEST'];
const memberTags = ['All', 'Same IP', 'Same Fingerprint', 'Same Real Name', 'Same Email', 'Same Mobile Number', 'Same Password'];

const form = ref({
  memberGroup: [],
  merchant: "MJB",
  currency: "BDT",
  autoRelease: false,
  manualRelease: false,
  memberTag: [],
  violationCount: "",
});

const rewardSettings = ref([
  {type: 'Profile Verified', display: false, fixedReward: null, turnoverMultiplier: null},
  {type: 'Bank Verified', display: false, fixedReward: null, turnoverMultiplier: null},
  {type: 'Mobile Verified', display: false, fixedReward: null, turnoverMultiplier: null},
  {type: 'Email Verified', display: false, fixedReward: null, turnoverMultiplier: null},
]);

const minDeposit = ref(null);
const minWithdraw = ref(null);

const router = useRouter();

const mode = ref('single');

const submit = () => {
  const payload = {
    merchant: form.value.merchant,
    currency: form.value.currency,
    memberGroup: form.value.memberGroup,
    autoRelease: form.value.autoRelease,
    manualRelease: form.value.manualRelease,
    memberTag: form.value.memberTag,
    violationCount: form.value.violationCount,
    rewardSettings: rewardSettings.value,
    minDeposit: minDeposit.value,
    minWithdraw: minWithdraw.value,
    mode: mode.value
  };

  console.log("Submitting full form payload:", payload);

  router.push({
    name: 'verify-reward-settings',
    state: {newVerifyRewardSetting: payload}
  });

  // Optionally: POST to API endpoint here instead of router.push
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