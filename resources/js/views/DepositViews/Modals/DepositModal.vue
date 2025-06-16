<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1"
      style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Add Deposit</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Member*</label>
                <select v-model="form.member" class="form-select" style="border-color: #ffcc00; border-radius: 2px"
                  @blur="clearError('member')" required>
                  <option disabled value="">Please select a member</option>
                  <option v-for="member in memberOptions" :key="member" :value="member">
                    {{ member }}
                  </option>
                </select>
                <span v-if="errors.member" class="text-danger">{{ errors.member.join(', ') }}</span>
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
                <label class="form-label">Bank Account*</label>
                <select v-model="form.bankAccount" class="form-select" @blur="clearError('bankAccount')" required>
                  <option value="">Select a bank account</option>
                  <option>Bank ABC</option>
                  <option>Bank XYZ</option>
                </select>
                <span v-if="errors.bankAccount" class="text-danger">{{ errors.bankAccount.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Amount*</label>
                <input type="number" v-model="form.amount" class="form-control" @blur="clearError('amount')" required />
                <span v-if="errors.amount" class="text-danger">{{ errors.amount.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Date*</label>
                <input class="form-control" type="date" v-model="form.date" @blur="clearError('date')" required />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Please be reminded that this date input are GMT+8 standard
                </p>
                <span v-if="errors.date" class="text-danger">{{ errors.date.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Member Bank*</label>
                <select v-model="form.memberBank" class="form-select" @blur="clearError('memberBank')" required>
                  <option value="">Select a member bank</option>
                  <option>HBL</option>
                  <option>Alfalah</option>
                  <option>HBL</option>
                </select>
                <span v-if="errors.memberBank" class="text-danger">{{ errors.memberBank.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Reference Number*</label>
                <input type="text" v-model="form.referenceNumber" class="form-control" @blur="clearError('referenceNumber')"
                  required />
                <span v-if="errors.referenceNumber" class="text-danger">{{ errors.referenceNumber.join(', ') }}</span>
              </div>
              <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                <label class="form-label">Receipt*</label>
                <input type="file" class="form-control choose-file" @change="handleFileUpload"
                  style="border-color: #ffcc00; border-radius: 2px" accept="image/*" @blur="clearError('receipt')" required />
                <span v-if="errors.receipt" class="text-danger">{{ errors.receipt.join(', ') }}</span>
              </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status"
                  aria-hidden="true"></span>
                {{ isLoading ? 'Save' : 'Save' }}
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
  import 'toastr/build/toastr.min.css';

  defineProps({
    modelValue: Boolean
  });

  const emit = defineEmits(['update:modelValue', 'submit']);

  const initialForm = {
    member: '',
    currency: 'BDT',
    bankAccount: '',
    amount: null,
    date: '',
    memberBank: '',
    referenceNumber: '',
    receipt: null
  }

  const memberOptions = [
    'John Doe',
    'Jane Smith',
    'Alice Johnson',
    'Bob Lee'
  ];

  const form = ref({ ...initialForm });
  const errors = ref({});
  const isLoading = ref(false);

  const resetForm = () => {
    form.value = { ...initialForm };
    errors.value = {};
  };

  const handleFileUpload = (event) => {
    form.value.receipt = event.target.files[0];
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
    errors.value = {};

    const formData = new FormData();
    for (const key in form.value) {
      formData.append(key, form.value[key]);
    }

    // Basic validation (you can add more specific rules)
    if (!form.value.member) {
      errors.value.member = ['Please select a member.'];
    }
    if (!form.value.currency) {
      errors.value.currency = ['Please select a currency.'];
    }
    if (!form.value.bankAccount) {
      errors.value.bankAccount = ['Please select a bank account.'];
    }
    if (!form.value.amount) {
      errors.value.amount = ['Please enter an amount.'];
    } else if (form.value.amount <= 0) {
      errors.value.amount = ['Amount must be greater than zero.'];
    }
    if (!form.value.date) {
      errors.value.date = ['Please select a date.'];
    }
    if (!form.value.memberBank) {
      errors.value.memberBank = ['Please select a member bank.'];
    }
    if (!form.value.referenceNumber) {
      errors.value.referenceNumber = ['Please enter a reference number.'];
    }
    if (!form.value.receipt) {
      errors.value.receipt = ['Please upload a receipt.'];
    }

    if (Object.keys(errors.value).length > 0) {
      isLoading.value = false;
      for (const fieldName in errors.value) {
        toastr.error(errors.value[fieldName][0], `Error in ${fieldName}`);
      }
      return;
    }

    try {
      const response = await axios.post('/deposits', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      toastr.success('Deposit added successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      let errorMessage = 'Failed to add deposit. Please check your connection and try again.';
      if (error.response) {
        if (error.response.data?.errors) {
          errors.value = error.response.data.errors;
          for (const fieldName in error.response.data.errors) {
            toastr.error(error.response.data.errors[fieldName][0], `Error in ${fieldName}`);
          }
          errorMessage = 'There were validation errors.  Please correct them.';
        } else if (error.response.data?.message) {
          errorMessage = error.response.data.message;
        } else {
          errorMessage = `Server responded with status: ${error.response.status}`;
        }
      } else if (error.request) {
        errorMessage = 'No response received from the server.  Please check your network connection.';
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

  .text-danger {
    font-size: 10px;
  }

  .choose-file {
    padding: 3px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  </style>
