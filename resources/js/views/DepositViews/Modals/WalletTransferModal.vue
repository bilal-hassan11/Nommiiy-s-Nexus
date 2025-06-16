<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1"
      style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">New Wallet Transfer</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"></button>
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
                <label class="form-label">Main Wallet*</label>
                <input type="text" v-model="form.mainWallet" class="form-control"
                  style="border-color: #ffcc00; border-radius: 2px" @blur="clearError('mainWallet')" required />
                <span v-if="errors.mainWallet" class="text-danger">{{ errors.mainWallet.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Provider*</label>
                <select v-model="form.provider" class="form-select" @blur="clearError('provider')" required>
                  <option disabled value="">Select a provider</option>
                  <option>provider ABC</option>
                  <option>provider XYZ</option>
                </select>
                <span v-if="errors.provider" class="text-danger">{{ errors.provider.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Provider Wallet*</label>
                <input type="text" v-model="form.providerWallet" class="form-control"
                  style="border-color: #ffcc00; border-radius: 2px" @blur="clearError('providerWallet')" required />
                <span v-if="errors.providerWallet" class="text-danger">{{ errors.providerWallet.join(', ') }}</span>
              </div>
              <div class="mb-3">
                <label>Type*</label>
                <div class="radio-group gap-3 d-flex" @blur="clearError('transferType')">
                  <div class="form-check gap-2 d-flex align-center">
                    <input class="form-check-input" type="radio" v-model="form.transferType" id="transferToProvider"
                      value="provider" required>
                    <label class="form-check-label" for="transferToProvider">Transfer to provider</label>
                  </div>
                  <div class="form-check gap-2 d-flex align-center">
                    <input class="form-check-input" type="radio" v-model="form.transferType" id="transferToMainWallet"
                      value="main-wallet" required>
                    <label class="form-check-label" for="transferToMainWallet">Transfer to Main Wallet</label>
                  </div>
                </div>
                <span v-if="errors.transferType" class="text-danger">{{ errors.transferType.join(', ') }}</span>
              </div>

            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"
                  aria-hidden="true"></span>
                {{ isLoading ? 'Saving...' : 'Save' }}
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
    mainWallet: '',
    providerWallet: '',
    provider: '',
    transferType: 'provider', // Default value
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
    if (!form.value.mainWallet) {
      errors.value.mainWallet = ['Main Wallet is required.'];
    }
    if (!form.value.provider) {
      errors.value.provider = ['Please select a provider.'];
    }
    if (!form.value.providerWallet) {
      errors.value.providerWallet = ['Provider Wallet is required.'];
    }
    if (!form.value.transferType) {
      errors.value.transferType = ['Please select a transfer type.'];
    }

    if (Object.keys(errors.value).length > 0) {
      isLoading.value = false;
      for (const fieldName in errors.value) {
        toastr.error(errors.value[fieldName][0], `Validation Error: ${fieldName}`);
      }
      return; // Stop submission if client-side validation fails
    }

    try {
      const response = await axios.post('/wallet-transfers', form.value); // Adjust API endpoint as needed
      toastr.success('Wallet transfer initiated successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      let errorMessage = 'Failed to initiate wallet transfer. Please check your connection and try again.';
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
