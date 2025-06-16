<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1"
      style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Create Affiliate Info</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Merchant</label>
                <input type="text" v-model="form.merchant" class="form-control" disabled
                  style="cursor: not-allowed; border-color: #ffcc00" />
                <span v-if="errors.merchant" class="text-danger">{{ errors.merchant.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Username*</label>
                <input type="text" v-model="form.username" class="form-control" @blur="clearError('username')" required />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  4-16 length characters
                </p>
                <span v-if="errors.username" class="text-danger">{{ errors.username.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Name*</label>
                <input type="text" v-model="form.name" class="form-control" @blur="clearError('name')" required />
                <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Currency*</label>
                <select v-model="form.currency" class="form-select" @blur="clearError('currency')" required>
                  <option value="BDT">BDT</option>
                  <option value="NPR">NPR</option>
                </select>
                <span v-if="errors.currency" class="text-danger">{{ errors.currency.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">New Password</label>
                <input type="password" v-model="form.newPassword" class="form-control" @input="evaluatePasswordStrength"
                  @blur="clearError('newPassword')" />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  8-16 length characters
                </p>
                <span v-if="errors.newPassword" class="text-danger">{{ errors.newPassword.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 d-flex align-items-center justify-content-between gap-3">
                <div class="flex-grow-1">
                  <label class="form-label mb-1">Password Strength</label>
                  <div class="strength-bars d-flex gap-1">
                    <div :class="['bar', strengthLevelClass(1)]"></div>
                    <div :class="['bar', strengthLevelClass(2)]"></div>
                    <div :class="['bar', strengthLevelClass(3)]"></div>
                    <div :class="['bar', strengthLevelClass(4)]"></div>
                  </div>
                </div>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Confirm Password*</label>
                <input type="password" v-model="form.confirmPassword" class="form-control"
                  @blur="clearError('confirmPassword')" required />
                <span v-if="errors.confirmPassword" class="text-danger">{{ errors.confirmPassword.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Domain*</label>
                <input v-model="form.domain" class="form-control" @blur="clearError('domain')" required />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  e.g: aff.com (without www)
                </p>
                <span v-if="errors.domain" class="text-danger">{{ errors.domain.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
                <label class="form-label">Remark</label>
                <input v-model="form.remark" class="form-control" />
              </div>

              <label class="form-label row" style="margin-left: 4px">Affiliate Parent</label>

              <div class="mb-3 col-lg-12 col-md-6 col-sm-6 d-flex align-items-center justify-between">
                <input v-model="form.affiliateParent" class="form-control" disabled style="border-color: #ffcc00;
                  cursor: not-allowed" />

                <div class="form-check gap-1 d-flex align-center">
                  <button type="button" class="btn btn-outline-success affiliate-btn" @click="doSomething">
                    Select Affiliate
                  </button>
                </div>
                <div class="form-check gap-1 d-flex align-center">
                  <button type="button" class="btn btn-outline-danger affiliate-btn" @click="doSomething">
                    Unlink Affiliate
                  </button>
                </div>
              </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
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
    merchant: 'MJB',
    username: '',
    name: '',
    currency: 'NPR',
    newPassword: '',
    confirmPassword: '',
    domain: '',
    remark: '',
    affiliateParent: ''
  }

  const form = ref({ ...initialForm });
  const errors = ref({});
  const isLoading = ref(false);


  const resetForm = () => {
    form.value = { ...initialForm };
    errors.value = {};
  };

  // TODO: Implement this functionality
  const doSomething = (e) => {
    console.log("Functionality yet to be built", e);
  }

  const closeModal = () => {
    emit('update:modelValue', false)
    resetForm();
  };

  const strengthScore = ref(0);

  const evaluatePasswordStrength = () => {
    const pwd = form.value.newPassword || ''
    let score = 0
    if (pwd.length >= 8) score++
    if (/[A-Z]/.test(pwd)) score++
    if (/[a-z]/.test(pwd)) score++
    if (/\d/.test(pwd)) score++
    if (/[\W_]/.test(pwd)) score++
    strengthScore.value = score
  }

  const strengthLevelClass = (level) => {
    if (strengthScore.value >= level) {
      if (strengthScore.value >= 4) return 'strong'
      if (strengthScore.value === 3) return 'medium'
      return 'weak'
    }
    return 'inactive'
  }

  const clearError = (field) => {
    if (errors.value[field]) {
      errors.value[field] = [];
    }
  };

  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

  onMounted(() => {
    // Initialize Toaster settings (optional, but recommended)
    toastr.options = {
      positionClass: 'toast-top-right',
      timeOut: 3000,
      closeButton: true,
      progressBar: true,
      preventDuplicates: true, // Add this line
      newestOnTop: true,
    };
  });

  const submitForm = async () => {
    isLoading.value = true;
    errors.value = {}; // Clear previous errors

    // Password confirmation check
    if (form.value.newPassword !== form.value.confirmPassword) {
      errors.value.confirmPassword = ['Passwords do not match.'];
      isLoading.value = false;
      toastr.error('Passwords do not match!');
      return; // Stop submission
    }

    try {
      const response = await axios.post('/affiliateslist', form.value);
      toastr.success('Affiliate created successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      let errorMessage = 'Failed to submit form. Please check your connection and try again.';
      if (error.response) {
        if (error.response.data?.errors) {
          errors.value = error.response.data.errors;
          for (const fieldName in error.response.data.errors) {
            toastr.error(error.response.data.errors[fieldName][0], `Error in ${fieldName}`);
          }
          errorMessage = 'There were validation errors.  Please correct them.';
        } else if (error.response.data?.message) {
          errorMessage = error.response.data.message; // Use the server's error message
        } else {
          errorMessage = `Server responded with status: ${error.response.status}`;
        }
      } else if (error.request) {
        errorMessage = 'No response received from the server.  Please check your network connection.';
      }

      toastr.error(errorMessage);
      console.error("Error submitting form:", error); // Log the error for debugging
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

  .affiliate-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 2px 6px;
    min-width: 80px;
    height: 30px;
    border-radius: 3px;
    cursor: pointer;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f1f1;
  }

  .affiliate-btn:hover {
    color: black;
  }

  .strength-bars .bar {
    height: 6px;
    width: 30px;
    border-radius: 3px;
    background-color: #e0e0e0;
  }

  .bar.weak {
    background-color: #ff4d4f;
  }

  .bar.medium {
    background-color: #faad14;
  }

  .bar.strong {
    background-color: #52c41a;
  }

  .bar.inactive {
    background-color: #e0e0e0;
  }

  .text-danger {
    font-size: 10px;
  }
  </style>
