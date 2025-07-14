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
          <label>Start Date <span class="text-red-500">*</span></label>
          <input type="date" v-model="form.startDate" class="form-control"/>
        </div>

        <div class="col-md-4 col-lg-4">
          <label>End Date <span class="text-red-500">*</span></label>
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
          <label class="form-label">Time Type <span class="text-red-500">*</span></label>
          <select v-model="form.timeType" class="form-select">
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
          <label class="form-label">Member Group <span class="text-red-500">*</span></label>
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
          <label>Member Tag that can only draw the risk control prize (The rest can draw all rewards). <span class="text-red-500">*</span></label>
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
          <label class="form-label">Merchant <span class="text-red-500">*</span></label>
          <select v-model="form.merchant" class="form-select">
            <option>MJB</option>
            <option>MJB2</option>
          </select>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Currency <span class="text-red-500">*</span></label>
          <select v-model="form.currency" class="form-select">
            <option value="BDT">BDT</option>
            <option value="NPR">NPR</option>
          </select>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Activity Name <span class="text-red-500">*</span></label>
          <input v-model="form.activityName" type="text" class="form-control" placeholder="Enter Activity Name"/>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Method <span class="text-red-500">*</span></label>
          <select v-model="form.method" class="form-select">
            <option>Deposit</option>
            <option>Withdrawal</option>
          </select>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Release <span class="text-red-500">*</span></label>
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
          <label class="form-label">Total bonus reward amount capital <span v-if="!form.noMaxTotalBonus" class="text-red-500">*</span></label>
          <input v-model="form.totalBonusRewardAmountCapital" type="number" class="form-control" :disabled="form.noMaxTotalBonus"/>
          <div class="form-check form-check-inline">
            <input class="form-check-input custom-checkbox" type="checkbox" id="noMaxTotalBonus"
                   v-model="form.noMaxTotalBonus">
            <label class="form-check-label checkbox-label" for="noMaxTotalBonus">No Max</label>
          </div>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Total claim quantity limit <span v-if="!form.noMaxTotalClaim" class="text-red-500">*</span></label>
          <input v-model="form.totalClaimQuantityLimit" type="number" class="form-control" :disabled="form.noMaxTotalClaim"/>
          <div class="form-check form-check-inline">
            <input class="form-check-input custom-checkbox" type="checkbox" id="noMaxTotalClaim"
                   v-model="form.noMaxTotalClaim">
            <label class="form-check-label checkbox-label" for="noMaxTotalClaim">No Max</label>
          </div>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Daily claim quantity limit <span v-if="!form.noMaxDailyClaim" class="text-red-500">*</span></label>
          <input v-model="form.dailyClaimQuantityLimit" type="number" class="form-control" :disabled="form.noMaxDailyClaim"/>
          <div class="form-check form-check-inline">
            <input class="form-check-input custom-checkbox" type="checkbox" id="noMaxDailyClaim"
                   v-model="form.noMaxDailyClaim">
            <label class="form-check-label checkbox-label" for="noMaxDailyClaim">No Max</label>
          </div>
        </div>

        <div class="col-md-4 col-lg-4">
          <label class="form-label">Daily player claim quantity limit <span v-if="!form.noMaxDailyPlayerClaim" class="text-red-500">*</span></label>
          <input v-model="form.dailyPlayerClaimQuantityLimit" type="number" class="form-control" :disabled="form.noMaxDailyPlayerClaim"/>
          <div class="form-check form-check-inline">
            <input class="form-check-input custom-checkbox" type="checkbox" id="noMaxDailyPlayerClaim"
                   v-model="form.noMaxDailyPlayerClaim">
            <label class="form-check-label checkbox-label" for="noMaxDailyPlayerClaim">No Max</label>
          </div>
        </div>

        <div class="col-md-2 col-lg-2">
          <label class="form-label">Time Gap</label>
          <input v-model="form.timeGap" type="text" class="form-control border-warning" disabled/>
        </div>

        <div class="col-md-2 col-lg-2">
          <label class="form-label">Time <span class="text-red-500">*</span></label>
          <select v-model="form.time" class="form-select">
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
        <label class="form-label">Valid Period Limit <span class="text-red-500">*</span></label>
        <div class="d-flex align-items-center gap-2">
          <input
              type="number"
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
            <th class="text-center">Reward <span class="text-red-500">*</span></th>
            <th class="text-center">Deposit Amount <span class="text-red-500">*</span></th>
            <th class="text-center">Get Bonus/Point <span class="text-red-500">*</span></th>
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
                <input type="number" v-model.number="row.depositAmount"
                       class="form-control form-control-sm border border-warning" style="width: 100px; font-size: 13px;"/>
                <span style="font-size: 13px;">BDT</span>
              </div>
            </td>

            <td class="align-middle">
              <div class="d-flex align-items-center gap-2">
                <label style="white-space: nowrap; font-size: 13px;">Nized Amount Range ≥</label>
                <input type="number" v-model.number="row.getBonusPointMin" class="form-control form-control-sm"
                       style="width: 80px; font-size: 13px;" placeholder="Min"/>
                <span>~</span>
                <input type="number" v-model.number="row.getBonusPointMax" class="form-control form-control-sm"
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
        <input type="number" class="form-control d-inline-block mx-2 border-warning" style="width: 80px;"
               v-model.number="form.kycViolationCount"/>
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
        <input type="number" class="form-control d-inline-block mx-2 border-warning" style="width: 80px;"
               v-model.number="form.riskViolationCount"/>
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
          <input v-model.number="form.amountFrom" type="number" class="form-control" placeholder="Amount From"/>
        </div>

        <div class="col-md-1 col-lg-1 d-flex align-items-center justify-content-center">
          <span>~</span>
        </div>

        <div class="col-md-3 col-lg-3">
          <input v-model.number="form.amountTo" type="number" class="form-control" placeholder="Amount To"/>
        </div>

        <div class="col-lg-2 col-md-2">
          <div class="form-check">
            <label class="form-check-label checkbox-label" for="doNotWin">Do not win</label>
            <input class="form-check-input custom-checkbox" type="checkbox" id="doNotWin" v-model="form.doNotWin"/>
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-center mt-3">
        <button class="btn tag-btn" @click="submit" :disabled="isLoading">
          {{ isLoading ? 'Saving...' : 'Save' }}
        </button>
      </div>

    </div>
    <!-- Message Box Container (for toastr simulation) -->
    <div id="message-box-container"></div>
  </template>

  <script setup>
  import {useRouter} from 'vue-router';
  import {onMounted, ref, watch} from "vue";
  import {CirclePlus, X} from "lucide-vue-next";
  // Assuming AddDisplaySettingsModal is a separate component you have
  import AddDisplaySettingsModal from "@/views/SoccerViews/modals/AddDisplaySettingsModal.vue";
  import Multiselect from "vue-multiselect";
  import axios from 'axios'; // Import axios

  // Import Multiselect CSS - IMPORTANT for proper rendering
  import 'vue-multiselect/dist/vue-multiselect.css';

  // Set base URL for axios requests
  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:3000/api'; // Example base URL

  const router = useRouter();

  const memberGroups = ['All', 'Regular', 'Regular 2', 'Risk', 'PLATINUM', 'DIAMOND', 'PAYMENT GATEWAY TEST'];
  const memberTags = ['All', 'Same IP', 'Same Fingerprint', 'Same Real Name', 'Same Email', 'Same Mobile Number', 'Same Password'];
  const excludeDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

  const initialFormState = {
    excludeDay: [], // Changed to array for Multiselect
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
    totalBonusRewardAmountCapital: null, // Changed to null for number input
    noMaxTotalBonus: false,
    totalClaimQuantityLimit: null,
    noMaxTotalClaim: false,
    dailyClaimQuantityLimit: null,
    noMaxDailyClaim: false,
    dailyPlayerClaimQuantityLimit: null,
    noMaxDailyPlayerClaim: false,
    timeGap: '',
    time: 'No Limit',
    validPeriodLimit: null, // Changed to null for number input
    kycViolationCount: null, // Added based on template
    riskViolationCount: null, // Added based on template
    controlPrize: "Activity Point",
    amountFrom: null,
    amountTo: null,
    doNotWin: false,
  };

  const form = ref({ ...initialFormState });
  const isLoading = ref(false); // Loading state for form submission

  const rankingRows = ref([
    {
      reward: 'Activity Point',
      depositAmount: null,
      getBonusPointMin: null,
      getBonusPointMax: null,
    }
  ]);

  // Watchers to disable/enable inputs based on "No Max" checkboxes
  watch(() => form.value.noMaxTotalBonus, (newVal) => {
    if (newVal) form.value.totalBonusRewardAmountCapital = null;
  });
  watch(() => form.value.noMaxTotalClaim, (newVal) => {
    if (newVal) form.value.totalClaimQuantityLimit = null;
  });
  watch(() => form.value.noMaxDailyClaim, (newVal) => {
    if (newVal) form.value.dailyClaimQuantityLimit = null;
  });
  watch(() => form.value.noMaxDailyPlayerClaim, (newVal) => {
    if (newVal) form.value.dailyPlayerClaimQuantityLimit = null;
  });

  // Watchers for Release checkboxes (ensure at least one is selected)
  watch([() => form.value.autoRelease, () => form.value.manualRelease], ([auto, manual]) => {
    if (!auto && !manual) {
      // If both are unchecked, default to autoRelease
      form.value.autoRelease = true;
    }
  });


  const addRow = () => {
    if (rankingRows.value.length < 10) { // Max 10 rows as per comment
      rankingRows.value.push({
        reward: 'Activity Point',
        depositAmount: null,
        getBonusPointMin: null,
        getBonusPointMax: null,
      });
    } else {
      showMessage('Maximum of 10 rows reached for Deposit Criteria.', 'error');
    }
  };

  const removeRow = (index) => {
    if (rankingRows.value.length > 1) { // Ensure at least one row remains
      rankingRows.value.splice(index, 1);
    } else {
      showMessage('Cannot remove the last row.', 'error');
    }
  };

  const showDisplaySettingModal = ref(false);

  const handleFormSubmit = (data) => {
    console.log("Display Settings Form Submitted:", data);
    // This function is triggered by the modal.
    // You might want to save these settings or use them in the main form.
    showMessage('Display settings saved successfully!', 'success');
  };

  const getSystemGMT = () => {
    const timeZoneOffset = new Date().getTimezoneOffset();
    const offsetHours = -timeZoneOffset / 60;
    return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
  };

  onMounted(() => {
    form.value.timeZone = getSystemGMT();
  });

  // Function to show custom message (simulating toastr)
  const showMessage = (message, type = 'info') => {
    const container = document.getElementById('message-box-container');
    if (!container) {
      // If container doesn't exist, create it and append to body
      const newContainer = document.createElement('div');
      newContainer.id = 'message-box-container';
      document.body.appendChild(newContainer);
      container = newContainer;
    }

    const messageBox = document.createElement('div');
    messageBox.className = `fixed bottom-4 right-4 p-4 rounded-md shadow-lg text-white z-50 transition-all duration-300 ease-in-out transform opacity-0 translate-y-full`;

    let bgColor;
    if (type === 'success') {
      bgColor = 'bg-green-500';
    } else if (type === 'error') {
      bgColor = 'bg-red-500';
    } else {
      bgColor = 'bg-blue-500';
    }

    messageBox.classList.add(bgColor);
    messageBox.textContent = message;
    container.appendChild(messageBox);

    // Trigger the transition
    requestAnimationFrame(() => {
      messageBox.classList.remove('opacity-0', 'translate-y-full');
      messageBox.classList.add('opacity-100', 'translate-y-0');
    });

    setTimeout(() => {
      messageBox.classList.remove('opacity-100', 'translate-y-0');
      messageBox.classList.add('opacity-0', 'translate-y-full');
      messageBox.addEventListener('transitionend', () => messageBox.remove(), { once: true });
    }, 3000);
  };

  // Client-side form validation
  const validateForm = () => {
    // Period Setting
    if (!form.value.startDate) { showMessage('Start Date is required.', 'error'); return false; }
    if (!form.value.endDate) { showMessage('End Date is required.', 'error'); return false; }
    if (new Date(form.value.startDate) > new Date(form.value.endDate)) {
      showMessage('Start Date cannot be after End Date.', 'error'); return false;
    }
    if (!form.value.timeType) { showMessage('Time Type is required.', 'error'); return false; }

    // Edit Angpow
    if (!form.value.memberGroup || form.value.memberGroup.length === 0) { showMessage('Member Group is required.', 'error'); return false; }
    if (!form.value.memberTag || form.value.memberTag.length === 0) { showMessage('Member Tag is required.', 'error'); return false; }
    if (!form.value.merchant) { showMessage('Merchant is required.', 'error'); return false; }
    if (!form.value.currency) { showMessage('Currency is required.', 'error'); return false; }
    if (!form.value.activityName || form.value.activityName.trim() === '') { showMessage('Activity Name is required.', 'error'); return false; }
    if (!form.value.method) { showMessage('Method is required.', 'error'); return false; }
    if (!form.value.autoRelease && !form.value.manualRelease) { showMessage('At least one Release option (Auto or Manual) must be selected.', 'error'); return false; }

    // Claim Setting
    if (!form.value.noMaxTotalBonus && (form.value.totalBonusRewardAmountCapital === null || form.value.totalBonusRewardAmountCapital < 0)) {
      showMessage('Total bonus reward amount capital is required and must be a non-negative number.', 'error'); return false;
    }
    if (!form.value.noMaxTotalClaim && (form.value.totalClaimQuantityLimit === null || form.value.totalClaimQuantityLimit < 0)) {
      showMessage('Total claim quantity limit is required and must be a non-negative number.', 'error'); return false;
    }
    if (!form.value.noMaxDailyClaim && (form.value.dailyClaimQuantityLimit === null || form.value.dailyClaimQuantityLimit < 0)) {
      showMessage('Daily claim quantity limit is required and must be a non-negative number.', 'error'); return false;
    }
    if (!form.value.noMaxDailyPlayerClaim && (form.value.dailyPlayerClaimQuantityLimit === null || form.value.dailyPlayerQuantityLimit < 0)) {
      showMessage('Daily player claim quantity limit is required and must be a non-negative number.', 'error'); return false;
    }
    if (!form.value.time) { showMessage('Time (Claim Setting) is required.', 'error'); return false; }

    // Deposit Criteria
    if (form.value.validPeriodLimit === null || form.value.validPeriodLimit < 0) {
      showMessage('Valid Period Limit is required and must be a non-negative number.', 'error'); return false;
    }

    if (rankingRows.value.length === 0) {
      showMessage('At least one Deposit Criteria row is required.', 'error'); return false;
    }
    for (let i = 0; i < rankingRows.value.length; i++) {
      const row = rankingRows.value[i];
      if (!row.reward) { showMessage(`Deposit Criteria Row ${i + 1}: Reward is required.`, 'error'); return false; }
      if (row.depositAmount === null || row.depositAmount < 0) { showMessage(`Deposit Criteria Row ${i + 1}: Deposit Amount is required and must be non-negative.`, 'error'); return false; }
      if (row.getBonusPointMin === null || row.getBonusPointMin < 0) { showMessage(`Deposit Criteria Row ${i + 1}: Get Bonus/Point Min is required and must be non-negative.`, 'error'); return false; }
      if (row.getBonusPointMax === null || row.getBonusPointMax < 0) { showMessage(`Deposit Criteria Row ${i + 1}: Get Bonus/Point Max is required and must be non-negative.`, 'error'); return false; }
      if (row.getBonusPointMin > row.getBonusPointMax) { showMessage(`Deposit Criteria Row ${i + 1}: Get Bonus/Point Min cannot be greater than Max.`, 'error'); return false; }
    }

    // KYC Setting
    if (form.value.kycViolationCount === null || form.value.kycViolationCount < 0) {
      showMessage('KYC Violation Count is required and must be a non-negative number.', 'error'); return false;
    }

    // Risk Setting
    if (form.value.riskViolationCount === null || form.value.riskViolationCount < 0) {
      showMessage('Risk Violation Count is required and must be a non-negative number.', 'error'); return false;
    }

    // Risk Control Prize
    if (!form.value.controlPrize) { showMessage('Risk Control Prize type is required.', 'error'); return false; }
    if (form.value.amountFrom === null || form.value.amountFrom < 0) { showMessage('Risk Control Prize Amount From is required and must be non-negative.', 'error'); return false; }
    if (form.value.amountTo === null || form.value.amountTo < 0) { showMessage('Risk Control Prize Amount To is required and must be non-negative.', 'error'); return false; }
    if (form.value.amountFrom > form.value.amountTo) { showMessage('Risk Control Prize Amount From cannot be greater than Amount To.', 'error'); return false; }

    return true;
  };


  const submit = async () => {
    if (!validateForm()) {
      return; // Stop if validation fails
    }

    isLoading.value = true;
    const payload = {
      ...form.value,
      rankingRows: rankingRows.value, // Include the dynamic table data
    };

    try {
      // Replace with your actual API endpoint for Angpow Setting
      const response = await axios.post('/add-member-tag', payload);

      showMessage(response.data.message || 'Angpow Setting saved successfully!', 'success');
      resetForm(); // Reset form fields after successful submission
      // Optionally, redirect or perform other actions after success
      router.push({
        name: 'angpow-setting', // Assuming this is the route for the table list
        state: { newAngpowSetting: response.data }
      });

    } catch (error) {
      console.error('Error submitting Angpow Setting:', error);

      if (error.response) {
        if (error.response.status === 422 && error.response.data.errors) {
          // Handle Laravel validation errors (if backend sends 'errors' object)
          for (const field in error.response.data.errors) {
            error.response.data.errors[field].forEach(msg => showMessage(msg, 'error'));
          }
        } else if (error.response.data && error.response.data.message) {
          // Handle other specific error messages from the backend
          showMessage(error.response.data.message, 'error');
        } else {
          // Generic error for other HTTP error statuses
          showMessage(`Server Error: ${error.response.status}. Please try again.`, 'error');
        }
      } else if (error.request) {
        // The request was made but no response was received (e.g., network error, CORS issue)
        showMessage('Network Error: No response from server. Please check your connection.', 'error');
      } else {
        // Something happened in setting up the request that triggered an Error
        showMessage('An unexpected error occurred. Please try again.', 'error');
      }
    } finally {
      isLoading.value = false; // Always reset loading state
    }
  };

  const resetForm = () => {
    form.value = { ...initialFormState };
    rankingRows.value = [{
      reward: 'Activity Point',
      depositAmount: null,
      getBonusPointMin: null,
      getBonusPointMax: null,
    }];
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
