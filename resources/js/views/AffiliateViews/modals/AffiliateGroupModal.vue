<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1"
      style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Create</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
              @click="closeModal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Merchant ID</label>
                  <input type="text" v-model="form.merchant" class="form-control" disabled
                    style="cursor: not-allowed; border-color: #ffcc00" />
                  <span v-if="errors.merchant" class="text-danger">{{ errors.merchant.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Name*</label>
                  <input type="text" v-model="form.name" class="form-control" @blur="clearError('name')" />
                  <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Currency*</label>
                  <select v-model="form.currency" class="form-select" @blur="clearError('currency')">
                    <option value="" disabled>Please select a currency</option>
                    <option v-for="c in currencies" :key="c" :value="c">{{ c }}</option>
                  </select>
                  <span v-if="errors.currency" class="text-danger">{{ errors.currency.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Member Group*</label>
                  <select v-model="form.memberGroup" class="form-select" @blur="clearError('memberGroup')">
                    <option value="" disabled>Please select a member group</option>
                    <option v-for="group in memberGroups" :key="group" :value="group">{{ group }}</option>
                  </select>
                  <span v-if="errors.memberGroup" class="text-danger">{{ errors.memberGroup.join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Remark</label>
                  <input type="text" v-model="form.remark" class="form-control" />
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Default*</label>
                  <select v-model="form.defaultStatus" class="form-select"
                    @blur="clearError('defaultStatus')">
                    <option value="" disabled>Please Select a Default Status</option>
                    <option>Status 1</option>
                    <option>Status 2</option>
                  </select>
                  <span v-if="errors.defaultStatus" class="text-danger">{{ errors.defaultStatus.join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Active*</label>
                  <select v-model="form.active" class="form-select" @blur="clearError('active')">
                    <option value="" disabled>Please select active status</option>
                    <option>Yes</option>
                    <option>No</option>
                  </select>
                  <span v-if="errors.active" class="text-danger">{{ errors.active.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Sequence*</label>
                  <input type="number" v-model="form.sequence" class="form-control"
                    @blur="clearError('sequence')" />
                  <span v-if="errors.sequence" class="text-danger">{{ errors.sequence.join(', ') }}</span>
                </div>
              </div>

              <div class="row" style="margin: 10px 3px 2px 1px; max-height: 50px">
                <p class="col-lg-11 col-md-10 col-sm-10" style="font-size: 16px; font-weight: 600;">
                  Withdrawal Limitation
                </p>
                <button type="button" class="btn btn-outline-secondary unset-btn col-lg-1 col-md-2 col-sm-2"
                  @click="resetWithdrawalLimitation">
                  Unset
                </button>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Minimum</label>
                  <input type="text" v-model="form.minimum" class="form-control" :disabled="form.noMinimum"
                    @blur="clearError('minimum')" />
                  <span v-if="errors.minimum" class="text-danger">{{ errors.minimum.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Maximum</label>
                  <input type="text" v-model="form.maximum" class="form-control" :disabled="form.noMaximum"
                    @blur="clearError('maximum')" />
                  <span v-if="errors.maximum" class="text-danger">{{ errors.maximum.join(', ') }}</span>
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                  <label class="custom-checkbox-wrapper">
                    <input type="checkbox" v-model="form.noMinimum" class="custom-checkbox" />
                    <span class="checkmark"></span>
                    No Min
                  </label>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                  <label class="custom-checkbox-wrapper">
                    <input type="checkbox" v-model="form.noMaximum" class="custom-checkbox" />
                    <span class="checkmark"></span>
                    No Max
                  </label>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Daily Count</label>
                  <input type="text" v-model="form.dailyCount" class="form-control"
                    @blur="clearError('dailyCount')" />
                  <span v-if="errors.dailyCount" class="text-danger">{{ errors.dailyCount.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Daily Maximum Count</label>
                  <input :disabled="form.noDailyMaximum" type="text" v-model="form.dailyMaximumCount"
                    class="form-control" @blur="clearError('dailyMaximumCount')" />
                  <span v-if="errors.dailyMaximumCount" class="text-danger">{{ errors.dailyMaximumCount.join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                  <label class="custom-checkbox-wrapper">
                    <input type="checkbox" v-model="form.noDailyMaximum" class="custom-checkbox" />
                    <span class="checkmark"></span>
                    No Max
                  </label>
                </div>
              </div>

              <div class="row" style="margin: 10px 3px 2px 1px; max-height: 50px">
                <p class="col-lg-11 col-md-10 col-sm-10" style="font-size: 16px; font-weight: 600;">
                  Deposit Limitation
                </p>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Minimum Deposit</label>
                  <input :disabled="form.noMinimumDeposit" type="number" v-model="form.minimumDeposit"
                    class="form-control" @blur="clearError('minimumDeposit')" />
                  <span v-if="errors.minimumDeposit" class="text-danger">{{ errors.minimumDeposit.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Maximum Deposit</label>
                  <input :disabled="form.noMaximumDeposit" type="text" v-model="form.maximumDeposit"
                    class="form-control" @blur="clearError('maximumDeposit')" />
                  <span v-if="errors.maximumDeposit" class="text-danger">{{ errors.maximumDeposit.join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                  <label class="custom-checkbox-wrapper">
                    <input type="checkbox" v-model="form.noMinimumDeposit" class="custom-checkbox" />
                    <span class="checkmark"></span>
                    No Min
                  </label>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6 gap-2 d-flex align-items-center">
                  <label class="custom-checkbox-wrapper">
                    <input type="checkbox" v-model="form.noMaximumDeposit" class="custom-checkbox" />
                    <span class="checkmark"></span>
                    No Max
                  </label>
                </div>
              </div>

              <div class="row" style="margin: 10px 3px 2px 1px; max-height: 50px">
                <p class="col-lg-11 col-md-10 col-sm-10" style="font-size: 16px; font-weight: 600;">
                  Transfer Limitation
                </p>
              </div>

              <div class="sound-toggle">
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 d-flex align-items-center justify-content-start">
                    <div class="gap-4 w-100">
                      <label class="switch">
                        <input type="checkbox" v-model="form.depositWallet" />
                        <span class="slider"></span>
                      </label>
                      <span class="toggle-label">Deposit Wallet</span>
                    </div>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6 d-flex align-items-center justify-content-end">
                    <div class="gap-4 w-100">
                      <label class="switch">
                        <input type="checkbox" v-model="form.commissionWallet" />
                        <span class="slider"></span>
                      </label>
                      <span class="toggle-label">Commission Wallet</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Minimum Transfer Limit</label>
                  <input type="number" v-model="form.minimumTransferLimit" class="form-control"
                    @blur="clearError('minimumTransferLimit')" />
                  <span v-if="errors.minimumTransferLimit" class="text-danger">{{ errors.minimumTransferLimit.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Maximum Transfer Limit</label>
                  <input type="text" v-model="form.maximumTransferLimit" class="form-control"
                    @blur="clearError('maximumTransferLimit')" />
                  <span v-if="errors.maximumTransferLimit" class="text-danger">{{ errors.maximumTransferLimit.join(', ') }}</span>
                </div>
              </div>
              <div class="row">
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Daily Maximum Transfer Limit</label>
                  <input type="number" v-model="form.dailyMaximumTransferLimit" class="form-control"
                    @blur="clearError('dailyMaximumTransferLimit')" />
                  <span v-if="errors.dailyMaximumTransferLimit" class="text-danger">{{ errors.dailyMaximumTransferLimit.join(', ') }}</span>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-6">
                  <label class="form-label">Target Multiplier</label>
                  <input type="text" v-model="form.targetMultiplier" class="form-control"
                    @blur="clearError('targetMultiplier')" />
                  <span v-if="errors.targetMultiplier" class="text-danger">{{ errors.targetMultiplier.join(', ') }}</span>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"
                  aria-hidden="true"></span>
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { watch } from 'vue';
  import axios from 'axios';
  import toastr from 'toastr';

  defineProps({
    modelValue: Boolean
  });
  const currencies = ['BDT', 'NPR'];
  const memberGroups = ['Regular', 'Platinum'];
  const emit = defineEmits(['update:modelValue', 'submit']);

  const initialForm = {
    merchant: 'MJB',
    name: '',
    currency: 'BDT',
    memberGroup: 'Regular',
    remark: '',
    defaultStatus: '',
    active: 'Yes',
    sequence: '',
    minimum: '',
    maximum: '',
    noMinimum: false,
    noMaximum: false,
    dailyCount: '',
    dailyMaximumCount: '',
    noDailyMaximum: false,
    minimumDeposit: 0,
    maximumDeposit: '',
    noMinimumDeposit: false,
    noMaximumDeposit: false,
    minimumTransferLimit: '',
    maximumTransferLimit: '',
    dailyMaximumTransferLimit: '',
    targetMultiplier: '',
    depositWallet: false,
    commissionWallet: false
  }

  const form = ref({ ...initialForm })
  const errors = ref({});
  const isLoading = ref(false);

  const resetForm = () => {
    form.value = { ...initialForm };
    errors.value = {};
  };

  const clearError = (field) => {
    if (errors.value[field]) {
      errors.value[field] = [];
    }
  };

  const resetWithdrawalLimitation = () => {
    form.value.minimum = ''
    form.value.maximum = ''
    form.value.noMinimum = false
    form.value.noMaximum = false
    form.value.dailyCount = ''
    form.value.dailyMaximumCount = ''
    form.value.noDailyMaximum = false
  }

  watch(() => form.value.noMinimum, (val) => {
    if (val) form.value.minimum = ''
  });

  watch(() => form.value.noMaximum, (val) => {
    if (val) form.value.maximum = ''
  });

  watch(() => form.value.noMinimumDeposit, (val) => {
    if (val) form.value.minimumDeposit = 0
  });

  watch(() => form.value.noMaximumDeposit, (val) => {
    if (val) form.value.maximumDeposit = ''
  });

  watch(() => form.value.noDailyMaximum, (val) => {
    if (val) form.value.dailyMaximumCount = ''
  });

  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

  const submitForm = async () => {
    isLoading.value = true;
    errors.value = {};

    // Basic client-side validation
    if (!form.value.name) {
      errors.value.name = ['Name is required'];
    }
    if (!form.value.currency) {
      errors.value.currency = ['Currency is required'];
    }
    if (!form.value.memberGroup) {
      errors.value.memberGroup = ['Member Group is required'];
    }
    if (!form.value.defaultStatus) {
      errors.value.defaultStatus = ['Default Status is required'];
    }
    if (!form.value.active) {
      errors.value.active = ['Active status is required'];
    }
    if (!form.value.sequence) {
      errors.value.sequence = ['Sequence is required'];
    }
    if (form.value.minimum && isNaN(Number(form.value.minimum))) {
      errors.value.minimum = ['Minimum must be a number'];
    }
    if (form.value.maximum && isNaN(Number(form.value.maximum))) {
      errors.value.maximum = ['Maximum must be a number'];
    }
    if (form.value.dailyCount && isNaN(Number(form.value.dailyCount))) {
      errors.value.dailyCount = ['Daily Count must be a number'];
    }
    if (form.value.dailyMaximumCount && isNaN(Number(form.value.dailyMaximumCount))) {
      errors.value.dailyMaximumCount = ['Daily Maximum Count must be a number'];
    }
    if (form.value.minimumDeposit && isNaN(Number(form.value.minimumDeposit))) {
      errors.value.minimumDeposit = ['Minimum Deposit must be a number'];
    }
    if (form.value.maximumDeposit && isNaN(Number(form.value.maximumDeposit))) {
      errors.value.maximumDeposit = ['Maximum Deposit must be a number'];
    }
    if (form.value.minimumTransferLimit && isNaN(Number(form.value.minimumTransferLimit))) {
      errors.value.minimumTransferLimit = ['Minimum Transfer Limit must be a number'];
    }
    if (form.value.maximumTransferLimit && isNaN(Number(form.value.maximumTransferLimit))) {
      errors.value.maximumTransferLimit = ['Maximum Transfer Limit  must be a number'];
    }
    if (form.value.dailyMaximumTransferLimit && isNaN(Number(form.value.dailyMaximumTransferLimit))) {
      errors.value.dailyMaximumTransferLimit = ['Daily Maximum Transfer Limit must be a number'];
    }
    if (form.value.targetMultiplier && isNaN(Number(form.value.targetMultiplier))) {
      errors.value.targetMultiplier = ['Target Multiplier must be a number'];
    }

    if (Object.keys(errors.value).length > 0) {
      isLoading.value = false;
      toastr.error('Please fix the errors in the form.');
      return;
    }

    try {
      // Simulate API call
      const response = await axios.post('/affiliate-groups', form.value);  // Replace with your actual endpoint
      toastr.success('Affiliate Group added successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      if (error.response?.data?.errors) {
        errors.value = error.response.data.errors; // Set backend validation errors
        toastr.error('Failed to submit form. Please check the errors.');
      } else {
        toastr.error('An unexpected error occurred. Please try again.');
        console.error(error); // Log the error for debugging
      }
    } finally {
      isLoading.value = false;
    }
  };

  const closeModal = () => {
    emit('update:modelValue', false)
    resetForm();
  };
  </script>

  <style scoped>
  label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 5px;
  }

  input,
  select {
    font-size: 13px;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .submit-btn {
    font-size: 12px;
    font-weight: 600;
    background: #d6b402;
    padding: 5px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  .submit-btn:hover {
    background: #a18923;
  }

  .cancel-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 5px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  .cancel-btn:hover {
    background: #a5a5a1;
  }

  .unset-btn {
    font-size: 12px;
    color: black;
    font-weight: 400;
    background: #f4f4f4;
    border-color: #5a5858;
    border-radius: 2px;
    cursor: pointer;
    max-height: 30px;
  }

  .unset-btn:hover {
    background: #8c8c8c;
    color: white;
  }


  .custom-checkbox-wrapper {
    display: flex;
    align-items: center;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    user-select: none;
    gap: 8px;
  }

  .custom-checkbox-wrapper input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .checkmark {
    height: 16px;
    width: 16px;
    background-color: white;
    border: 2px solid #f4c938;
    border-radius: 3px;
    display: inline-block;
    position: relative;
  }

  .custom-checkbox-wrapper input:checked+.checkmark {
    background-color: #f4c938;
    border-color: #f4c938;
  }

  .custom-checkbox-wrapper input:checked+.checkmark::after {
    content: "";
    position: absolute;
    left: 5px;
    top: 1px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
  }

  .toggle-label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 0;
    margin-left: 8px;
  }

  .switch {
    display: inline-block;
    position: relative;
    width: 40px;
    height: 20px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
  }

  input:checked + .slider {
    background-color: #f4c938;
  }

  input:checked + .slider:before {
    transform: translateX(20px);
  }
  </style>
