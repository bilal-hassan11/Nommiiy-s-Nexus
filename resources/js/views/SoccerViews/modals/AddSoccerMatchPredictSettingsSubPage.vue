<template>
    <AddDisplaySettingsModal v-model="showDisplaySettingModal" @submit="handleFormSubmit"/>

    <div class="row align-items-center form-header">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 class="form-title">Soccer Match List</h2>
        <p class="breadcrumb">Soccer Match List > <strong>Soccer Match Predict Settings</strong></p>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
        <button class="btn tag-btn me-2" @click="showDisplaySettingModal = true" :disabled="isLoading">
          Display Setting
        </button>
        <button class="btn btn-outline-dark add-btn d-flex align-items-center me-2"
                @click="handleTableListClick" :disabled="isLoading">
          Table List
        </button>
      </div>
    </div>

    <div class="form-container mb-3">
      <div class="mb-3">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Add Soccer</h2>
      </div>
      <div class="row gx-3 gy-3">
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Merchant <span class="text-red-500">*</span></label>
          <select v-model="form.merchant" class="form-select" :disabled="isLoading">
            <option value="" disabled>Select Merchant</option>
            <option>MJB</option>
            <option>MJB2</option>
          </select>
        </div>
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Currency <span class="text-red-500">*</span></label>
          <select v-model="form.currency" class="form-select" :disabled="isLoading">
            <option value="" disabled>Select Currency</option>
            <option value="BDT">BDT</option>
            <option value="NPR">NPR</option>
          </select>
        </div>
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Activity Name <span class="text-red-500">*</span></label>
          <input v-model="form.activityName" type="text" class="form-control" placeholder="Enter Activity Name" :disabled="isLoading"/>
        </div>
        <div class="col-md-4 col-lg-4">
          <label>Start Date <span class="text-red-500">*</span></label>
          <input type="date" v-model="form.startDate" class="form-control" :disabled="isLoading"/>
        </div>
        <div class="col-md-4 col-lg-4">
          <label>End Date <span class="text-red-500">*</span></label>
          <input type="date" v-model="form.endDate" class="form-control" :disabled="isLoading"/>
        </div>
      </div>
    </div>

    <div class="form-container mb-3">
      <div class="mb-3">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Score Setting</h2>
      </div>
      <label class="form-label">
        Only users who guess the CORRECT score will be rewarded.
      </label>
      <div class="row gx-3 gy-3">
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Score <span class="text-red-500">*</span></label>
          <input v-model="form.score" type="text" class="form-control" placeholder="Enter Score (e.g., 2-1)" :disabled="isLoading"/>
        </div>
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Prize Pool <span class="text-red-500">*</span></label>
          <input v-model.number="form.prizePool" type="number" class="form-control" placeholder="Enter Prize Pool Amount" :disabled="isLoading"/>
        </div>
        <div class="col-md-4 col-lg-4">
          <label class="form-label">Deposit Amount/Ticket <span class="text-red-500">*</span></label>
          <input v-model.number="form.deposit" type="number" class="form-control" :disabled="form.freeToBet || isLoading"/>
          <div class="form-check">
            <label class="form-check-label checkbox-label" for="freeToBet">Free to Bet</label>
            <input class="form-check-input custom-checkbox" type="checkbox" id="freeToBet"
                   v-model="form.freeToBet" :disabled="isLoading">
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
          <label class="form-label d-block mb-1">Fake Data Display Row: <span class="text-red-500">*</span></label>
          <div class="form-check form-check-inline" v-for="row in [10, 30, 50, 100]" :key="row">
            <input class="form-check-input" type="radio" :id="'row-' + row" :value="row.toString()"
                   v-model="form.displayRow" :disabled="isLoading"/>
            <label class="form-check-label me-2" :for="'row-' + row">{{ row }}</label>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
          <label class="form-label">Fake Winner List <span class="text-red-500">*</span></label>
          <div class="d-flex align-items-center gap-2">
            <input
                type="number"
                v-model.number="form.fakeWinnerList"
                min="1"
                max="25"
                class="form-control w-50"
                placeholder="1-25"
                :disabled="isLoading"
            />
            <span class="mt-1 d-block" style="font-size: 12px;">
              % of list
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-container mb-3">
      <div class="mb-3">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Risk Setting</h2>
      </div>

      <label class="form-label">Risk Options</label>
      <div class="mb-2" style="font-size: 12px;">
        <label class="form-label">Violation Count Setting <span class="text-red-500">*</span></label>
        <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
            * If the number of violations is over, the player is not allowed to apply to this prediction.
          </span>
      </div>
      <div style="font-size: 12px;">
        If violated count is above or equal
        <input type="number" class="form-control d-inline-block mx-2" style="width: 80px;"
               v-model.number="form.violationCount" :disabled="isLoading"/>
        conditions, <span style="font-size: 10px; font-weight: 500; margin-left: 4px; color: #ae0404;">
          * The player will automatically to be declined from this prediction.</span>
      </div>
    </div>

    <div class="form-container mb-3">
      <div class="mb-3">
        <h2 style="font-size: 16px; color: #5a5858; font-weight: 500">Ranking Setting</h2>
      </div>

      <div class="col-lg-4 col-md-6 mb-3">
        <label class="form-label">Table Row</label>
        <div class="d-flex align-items-center gap-2">
          <input
              type="number"
              v-model.number="form.tableRow"
              min="1"
              max="25"
              class="form-control w-50"
              :disabled="isLoading"
          />
          <button class="btn tag-btn" @click="addMultipleRows" :disabled="isLoading">Add Multiple Row</button>
        </div>
        <span class="text-danger mt-1 d-block" style="font-size: 12px;">
          * Maximum: 25 Row
        </span>
      </div>


      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Type <span class="text-red-500">*</span></th>
            <th>Rank From <span class="text-red-500">*</span></th>
            <th>Rank To</th>
            <th>Get Reward (% received per player) <span class="text-red-500">*</span></th>
            <th>Turnover Multiplier <span class="text-red-500">*</span></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(row, index) in rankingRows" :key="index">
            <td class="align-middle" style="font-weight: 500; font-size: 13px;">{{ index + 1 }}.</td>
            <td class="align-middle">
              <select v-model="row.type" class="form-select" :disabled="isLoading">
                <option value="" disabled>Please Select Type</option>
                <option value="percentage">Percentage</option>
              </select>
            </td>
            <td class="align-middle">
              <input type="number" v-model.number="row.rankFrom" disabled class="form-control border-warning"/>
            </td>
            <td class="align-middle">
              <input type="number" v-model.number="row.rankTo" class="form-control" placeholder="Optional" :disabled="isLoading"/>
            </td>
            <td class="align-middle">
              <input type="number" v-model.number="row.bonusPoint" class="form-control" placeholder="Enter Reward" :disabled="isLoading"/>
            </td>
            <td class="align-middle">
              <input type="number" v-model.number="row.turnoverMultiplier" class="form-control" placeholder="Enter Multiplier" :disabled="isLoading"/>
            </td>
            <td class="align-middle text-center" v-if="index > 0">
              <X size="18" @click="removeRow(index)" style="cursor: pointer" :disabled="isLoading"/>
            </td>
            <td v-else></td>
          </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
                @click="addRow" :disabled="isLoading || rankingRows.length >= 25">
          <CirclePlus class="me-2" size="16" stroke-width="2"/>
          Add
        </button>
      </div>
      <div class="d-flex justify-content-center mt-3">
        <button class="btn tag-btn" @click="submitForm" :disabled="isLoading">
          {{ isLoading ? 'Saving...' : 'Save' }}
        </button>
      </div>
    </div>

  </template>


  <script setup>
  import {useRouter} from 'vue-router';
  import {onMounted, ref, watch} from "vue";
  import {CirclePlus, X} from "lucide-vue-next";
  import AddDisplaySettingsModal from "@/views/SoccerViews/modals/AddDisplaySettingsModal.vue";
  import axios from 'axios';
  import toastr from 'toastr'; // Import toastr

  const router = useRouter();

  const initialFormState = {
    merchant: "",
    activityName: "",
    currency: "", // Changed to empty for validation
    startDate: new Date().toISOString().slice(0, 10),
    endDate: new Date().toISOString().slice(0, 10),
    score: "",
    prizePool: null, // Changed to null for number input validation
    deposit: null,   // Changed to null for number input validation
    freeToBet: false,
    displayRow: "",  // Changed to empty for validation
    violationCount: null, // Changed to null for number input validation
    fakeWinnerList: null, // Changed to null for number input validation
    tableRow: 1
  };

  const form = ref({...initialFormState});
  const isLoading = ref(false); // Loading state for form submission

  const rankingRows = ref([
    {
      type: '',
      rankFrom: 1,
      rankTo: null, // Changed to null for optional number input
      bonusPoint: null, // Changed to null for number input validation
      turnoverMultiplier: null // Changed to null for number input validation
    }
  ]);

  // Watcher for freeToBet to disable deposit input
  watch(() => form.value.freeToBet, (newVal) => {
    if (newVal) {
      form.value.deposit = 0; // Set to 0 or null when free to bet
    } else {
      form.value.deposit = null; // Reset when unchecked
    }
  });

  const addRow = () => {
    if (rankingRows.value.length < 25) {
      rankingRows.value.push({
        type: '',
        rankFrom: rankingRows.value.length + 1,
        rankTo: null,
        bonusPoint: null,
        turnoverMultiplier: null
      });
    } else {
      toastr.error('Maximum of 25 ranking rows reached.');
    }
  };

  const addMultipleRows = () => {
    if (form.value.tableRow === null || form.value.tableRow < 1 || form.value.tableRow > 25) {
      toastr.error('Please enter a valid number of rows to add (1-25).');
      return;
    }

    const rowsToAdd = Math.min(25 - rankingRows.value.length, form.value.tableRow);
    if (rowsToAdd === 0) {
      toastr.info('No more rows can be added (maximum 25 reached).');
      return;
    }

    for (let i = 0; i < rowsToAdd; i++) {
      addRow();
    }
    form.value.tableRow = 1; // Reset input after adding
  };

  const removeRow = (index) => {
    if (rankingRows.value.length > 1) { // Ensure at least one row remains
      rankingRows.value.splice(index, 1);
      rankingRows.value.forEach((row, i) => {
        row.rankFrom = i + 1; // Re-index rankFrom
      });
    } else {
      toastr.error('Cannot remove the last ranking row.');
    }
  };

  const showDisplaySettingModal = ref(false);

  const handleFormSubmit = (data) => {
    // This function is triggered by the modal.
    console.log("Display Settings Form Submitted:", data);
    toastr.success('Display settings saved successfully!');
  };

  const getSystemGMT = () => {
    const timeZoneOffset = new Date().getTimezoneOffset();
    const offsetHours = -timeZoneOffset / 60;
    return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
  };

  onMounted(() => {
    form.value.timeZone = getSystemGMT();
  });

  const handleTableListClick = () => {
    console.log('Navigating to /soccer-match-predict-settings (Table List)');
    // router.push('/soccer-match-predict-settings'); // Uncomment in a full Vue app
  };


  // Client-side form validation
  const validateForm = () => {
    // Add Soccer section
    if (!form.value.merchant) { toastr.error('Merchant is required.'); return false; }
    if (!form.value.currency) { toastr.error('Currency is required.'); return false; }
    if (!form.value.activityName || form.value.activityName.trim() === '') { toastr.error('Activity Name is required.'); return false; }
    if (!form.value.startDate) { toastr.error('Start Date is required.'); return false; }
    if (!form.value.endDate) { toastr.error('End Date is required.'); return false; }
    if (new Date(form.value.startDate) > new Date(form.value.endDate)) {
      toastr.error('Start Date cannot be after End Date.'); return false;
    }

    // Score Setting section
    if (!form.value.score || form.value.score.trim() === '') { toastr.error('Score is required.'); return false; }
    if (form.value.prizePool === null || form.value.prizePool <= 0) { toastr.error('Prize Pool is required and must be a positive number.'); return false; }
    if (!form.value.freeToBet && (form.value.deposit === null || form.value.deposit <= 0)) { toastr.error('Deposit Amount/Ticket is required and must be a positive number, unless "Free to Bet" is selected.'); return false; }
    if (!form.value.displayRow) { toastr.error('Fake Data Display Row is required.'); return false; }
    if (form.value.fakeWinnerList === null || form.value.fakeWinnerList < 1 || form.value.fakeWinnerList > 25) {
      toastr.error('Fake Winner List percentage must be between 1 and 25.'); return false;
    }

    // Risk Setting section
    if (form.value.violationCount === null || form.value.violationCount < 0) { toastr.error('Violation Count Setting is required and must be a non-negative number.'); return false; }

    // Ranking Setting section
    if (rankingRows.value.length === 0) { toastr.error('At least one Ranking Setting row is required.'); return false; }
    for (let i = 0; i < rankingRows.value.length; i++) {
      const row = rankingRows.value[i];
      if (!row.type) { toastr.error(`Ranking Row ${i + 1}: Type is required.`); return false; }
      if (row.rankFrom === null || row.rankFrom <= 0) { toastr.error(`Ranking Row ${i + 1}: Rank From is required and must be a positive number.`); return false; }
      if (row.bonusPoint === null || row.bonusPoint < 0) { toastr.error(`Ranking Row ${i + 1}: Get Reward (% received per player) is required and must be a non-negative number.`); return false; }
      if (row.turnoverMultiplier === null || row.turnoverMultiplier < 0) { toastr.error(`Ranking Row ${i + 1}: Turnover Multiplier is required and must be a non-negative number.`); return false; }
      // Optional: Add validation for rankTo if it's not null, e.g., rankTo >= rankFrom
      if (row.rankTo !== null && row.rankTo < row.rankFrom) {
        toastr.error(`Ranking Row ${i + 1}: Rank To cannot be less than Rank From.`); return false;
      }
    }

    return true;
  };


  const submitForm = async () => {
    if (!validateForm()) {
      return; // Stop if client-side validation fails
    }

    isLoading.value = true; // Set loading state

    const payload = {
      ...form.value,
      rankingRows: rankingRows.value, // Include the dynamic table data
    };

    try {
      // --- ACTUAL AXIOS POST REQUEST ---
      // This will now attempt to send data to your Laravel backend.
      const response = await axios.get('/soccer-settings', payload );

      // Show success message using toastr
      toastr.success(response.data.message || 'Soccer Match Predict Settings saved successfully!');

      // Reset form fields after successful submission
      resetForm();

      // Optionally, redirect or perform other actions after success
      console.log('Navigating to soccer-match-predict-settings with new data:', payload);
      // router.push({
      //   name: 'soccer-match-predict-settings',
      //   state: { newSoccerMatchPredictSetting: response.data }
      // });

    } catch (error) {
      console.error('Error submitting Soccer Match Predict Settings:', error);

      if (error.response) {
        // Server responded with a status other than 2xx
        if (error.response.status === 422 && error.response.data.errors) {
          // Handle Laravel validation errors (assuming 'errors' object structure)
          for (const field in error.response.data.errors) {
            toastr.error(Array.isArray(error.response.data.errors[field]) ? error.response.data.errors[field].join(', ') : error.response.data.errors[field]);
          }
        } else if (error.response.data && error.response.data.message) {
          // Handle other specific error messages from the backend
          toastr.error(error.response.data.message);
        } else {
          // Generic error for other HTTP error statuses
          toastr.error(`Server Error: ${error.response.status}. Please try again.`);
        }
      } else if (error.request) {
        // The request was made but no response was received (e.g., network error, CORS issue)
        toastr.error('Network Error: No response from server. Please check your connection.');
      } else {
        // Something happened in setting up the request that triggered an Error
        toastr.error('An unexpected error occurred. Please try again.');
      }
    } finally {
      isLoading.value = false; // Always reset loading state
    }
  };

  const resetForm = () => {
    form.value = { ...initialFormState };
    rankingRows.value = [{
      type: '',
      rankFrom: 1,
      rankTo: null,
      bonusPoint: null,
      turnoverMultiplier: null
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

  /* Styles for the red asterisk */
  .text-red-500 {
    color: #ef4444;
  }
  </style>
