<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Adjust Wallet</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
              @click="closeModal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Username*</label>
                <select v-model="form.username" class="form-select" style="border-color: #ffcc00; border-radius: 2px"
                  @blur="clearError('username')" required>
                  <option disabled value="">Please select a username</option>
                  <option v-for="user in usernameOptions" :key="user" :value="user">
                    {{ user }}
                  </option>
                </select>
                <span v-if="errors.username" class="text-danger">{{ errors.username.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Currency*</label>
                <select v-model="form.currency" class="form-select" style="border-color: #ffcc00; border-radius: 2px"
                  @blur="clearError('currency')" required>
                  <option value="BDT">BDT</option>
                  <option value="NPR">NPR</option>
                </select>
                <span v-if="errors.currency" class="text-danger">{{ errors.currency.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Current Balance*</label>
                <input type="number" v-model="form.currentBalance" class="form-control"
                  style="border-color: #ffcc00; border-radius: 2px" @blur="clearError('currentBalance')" required />
                <span v-if="errors.currentBalance" class="text-danger">{{ errors.currentBalance.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Amount*</label>
                <input type="number" v-model="form.amount" class="form-control" @blur="clearError('amount')" required />
                <span v-if="errors.amount" class="text-danger">{{ errors.amount.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Bank*</label>
                <select v-model="form.bank" class="form-select" @blur="clearError('bank')" required>
                  <option disabled value="">Select a Bank</option>
                  <option>Bank ABC</option>
                  <option>Bank XYZ</option>
                </select>
                <span v-if="errors.bank" class="text-danger">{{ errors.bank.join(', ') }}</span>
              </div>
              <div class="mb-3">
                <label>Transaction Type*</label>
                <div class="radio-group gap-3 d-flex" @blur="clearError('transactionType')">
                  <div class="form-check gap-2 d-flex align-center">
                    <input class="form-check-input" type="radio" v-model="form.transactionType" id="normal"
                      value="normal" required>
                    <label class="form-check-label" for="normal">Normal</label>
                  </div>
                  <div class="form-check gap-2 d-flex align-center">
                    <input class="form-check-input" type="radio" v-model="form.transactionType" id="deposit"
                      value="deposit" required>
                    <label class="form-check-label" for="deposit">Deposit</label>
                  </div>
                  <div class="form-check gap-2 d-flex align-center">
                    <input class="form-check-input" type="radio" v-model="form.transactionType" id="withdrawal"
                      value="withdrawal" required>
                    <label class="form-check-label" for="withdrawal">Withdrawal</label>
                  </div>
                </div>
                <span v-if="errors.transactionType" class="text-danger">{{ errors.transactionType.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Turnover Multiplier</label>
                <input type="text" v-model="form.turnoverMultiplier" class="form-control"
                  @blur="clearError('turnoverMultiplier')" />
                <span v-if="errors.turnoverMultiplier" class="text-danger">{{ errors.turnoverMultiplier.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Remark</label>
                <input type="text" v-model="form.remark" class="form-control" @blur="clearError('remark')" />
                <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
              </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"
                  aria-hidden="true"></span>
                {{ isLoading ? 'Adjusting...' : 'Adjust' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import toastr from 'toastr';
  import 'toastr/build/toastr.min.css'; // Import Toaster CSS

  defineProps({
    modelValue: Boolean
  });

  const emit = defineEmits(['update:modelValue', 'submit']);

  const initialForm = {
    username: '',
    currency: '',
    currentBalance: null, // Changed to null for number input
    amount: null,         // Changed to null for number input
    bank: '',
    turnoverMultiplier: '',
    remark: '',
    transactionType: 'normal', // Default value
  }

  const usernameOptions = [
    'john.doe@gmail.com',
    'jane.smith@gmail.com',
    'alice.johnson@gmail.com',
    'bob.lee@gmail.com'
  ];

  const form = ref({ ...initialForm });
  const errors = ref({});
  const isLoading = ref(false);

  const resetForm = () => {
    form.value = { ...initialForm };
    errors.value = {};
  };

  const closeModal = () => {
    emit('update:modelValue', false)
    resetForm();
  };

  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

  onMounted(() => {
    toastr.options = {
      positionClass: 'toast-top-right',
      timeOut: 3000,
      closeButton: true,
      progressBar: true,
      preventDuplicates: true,
      newestOnTop: true,
    };
  });

  const clearError = (field) => {
    if (errors.value[field]) {
      errors.value[field] = [];
    }
  };

  const submitForm = async () => {
    isLoading.value = true;
    errors.value = {}; // Clear previous errors

    // Client-side validation
    if (!form.value.username) {
      errors.value.username = ['Please select a username.'];
    }
    if (!form.value.currency) {
      errors.value.currency = ['Please select a currency.'];
    }
    if (form.value.currentBalance === null || form.value.currentBalance < 0) {
      errors.value.currentBalance = ['Current Balance must be a non-negative number.'];
    }
    if (!form.value.amount || form.value.amount <= 0) {
      errors.value.amount = ['Amount must be a positive number.'];
    }
    if (!form.value.bank) {
      errors.value.bank = ['Please select a bank.'];
    }
    if (!form.value.transactionType) {
      errors.value.transactionType = ['Please select a transaction type.'];
    }

    // If client-side validation fails, display errors and stop
    if (Object.keys(errors.value).length > 0) {
      isLoading.value = false;
      for (const fieldName in errors.value) {
        toastr.error(errors.value[fieldName][0], `Validation Error: ${fieldName}`);
      }
      return;
    }

    try {
      // Adjust API endpoint as needed, e.g., '/wallet-adjustments'
      const response = await axios.post('/walletadjustments', form.value);
      toastr.success('Wallet adjusted successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      let errorMessage = 'Failed to adjust wallet. Please check your connection and try again.';
      if (error.response) {
        if (error.response.data?.errors) {
          errors.value = error.response.data.errors;
          for (const fieldName in error.response.data.errors) {
            toastr.error(error.response.data.errors[fieldName][0], `Server Error: ${fieldName}`);
          }
          errorMessage = 'There were server-side validation errors. Please correct them.';
        } else if (error.response.data?.message) {
          errorMessage = error.response.data.message;
        } else {
          errorMessage = `Server responded with status: ${error.response.status}`;
        }
      } else if (error.request) {
        errorMessage = 'No response received from the server. Please check your network connection.';
      }
      toastr.error(errorMessage);
      console.error("Error submitting form:", error);
    } finally {
      isLoading.value = false;
    }
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

  .text-danger {
    font-size: 10px;
  }
  </style>
