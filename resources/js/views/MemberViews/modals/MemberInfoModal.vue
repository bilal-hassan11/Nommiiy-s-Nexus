<!-- Modal Component: AddMemberModal.vue -->
<!-- This modal component provides a form to add a new member. -->
<template>
  <!-- Modal container that only shows when `modelValue` is true -->
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Member</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <!-- Email Input -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Email*</label>
              <input type="email" v-model="form.email" class="form-control" required />
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                eg: test@test.com
              </p>
            </div>

            <!-- Currency Select -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Currency*</label>
              <select v-model="form.currency" class="form-select" required>
                <option value="BDT">BDT</option>
                <option value="NPR">NPR</option>
              </select>
            </div>

            <!-- Country Code & Mobile Number -->
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label">Country Code*</label>
                <select v-model="form.countryCode" class="form-select" required>
                  <option v-for="item in countryCodes" :key="item.code" :value="item.code">
                    {{ item.code }}
                  </option>
                </select>
              </div>
              <div class="col-md-8">
                <label class="form-label">Mobile Number*</label>
                <input type="tel" v-model="form.mobileNumber" class="form-control" required />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  (Begin with country code: eg: 601234567890)
                </p>
              </div>
            </div>

            <!-- Full Name Input -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Full Name*</label>
              <input v-model="form.fullName" class="form-control" required />
            </div>

            <!-- Username Input -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Username*</label>
              <input v-model="form.username" class="form-control" required />
            </div>

            <!-- New Password Input -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">New Password*</label>
              <input type="password" v-model="form.newPassword" class="form-control" @input="evaluatePasswordStrength"
                     required />
            </div>

            <!-- Password Strength Indicator -->
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

            <!-- Force Password Change Checkbox -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="custom-checkbox-wrapper">
                <input type="checkbox" v-model="form.forcePasswordChange" class="custom-checkbox" />
                <span class="checkmark"></span>
                Force Password Change After First Login
              </label>
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Confirm Password*</label>
              <input type="password" v-model="form.confirmPassword" class="form-control" required />
            </div>

            <!-- Bank Information -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Bank</label>
              <select v-model="form.bank" class="form-select">
                <option value="" disabled selected>--Select a Bank--</option>
                <option value="Bank ABC">Bank ABC</option>
                <option value="Bank XYZ">Bank XYZ</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Account Number</label>
              <input v-model="form.accountNumber" class="form-control" />
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Account Name</label>
              <input v-model="form.accountName" class="form-control" />
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Bank Branch</label>
              <input v-model="form.bankBranch" class="form-control" />
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Referral Code</label>
              <input v-model="form.referralCode" class="form-control" />
            </div>

            <!-- Affiliate Login Section -->
            <label class="form-label row" style="margin-left: 4px">Affiliate Login</label>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6 d-flex align-items-center justify-between">
              <input v-model="form.affiliateLogin" class="form-control" disabled style="border-color: #ffcc00" />
              <div class="form-check gap-1 d-flex align-center">
                <button type="button" class="btn btn-outline-success affiliate-btn" @click="selectAffiliate">
                  Select Affiliate
                </button>
              </div>
              <div class="form-check gap-1 d-flex align-center">
                <button type="button" class="btn btn-outline-danger affiliate-btn" @click="unlinkAffiliate">
                  Unlink Affiliate
                </button>
              </div>
            </div>
          </div>

          <!-- Modal Footer Buttons -->
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
import axios from 'axios';
import toastr from 'toastr';

// Props: 'modelValue' is used to control the modal's visibility via v-model
const props = defineProps({
  modelValue: Boolean
});

// Events: 'update:modelValue' to close the modal, 'submit' to emit form data
const emit = defineEmits(['update:modelValue', 'submit']);

// Initial state for the form data
const initialForm = {
  email: '',
  currency: 'BDT',
  countryCode: '+880',
  mobileNumber: '',
  fullName: '',
  username: '',
  newPassword: '',
  forcePasswordChange: false,
  confirmPassword: '',
  bank: '',
  accountNumber: '',
  accountName: '',
  bankBranch: '',
  referralCode: '',
  affiliateLogin: '',
};

const form = ref({ ...initialForm });
const isLoading = ref(false);

const countryCodes = [
  { code: '+1', country: 'USA/Canada' },
  { code: '+44', country: 'UK' },
  { code: '+91', country: 'India' },
  { code: '+92', country: 'Pakistan' },
  { code: '+880', country: 'Bangladesh' },
  { code: '+977', country: 'Nepal' },
  { code: '+60', country: 'Malaysia' },
  { code: '+971', country: 'UAE' },
];

const strengthScore = ref(0);

/**
 * Evaluates the strength of the password based on various criteria.
 */
const evaluatePasswordStrength = () => {
  const pwd = form.value.newPassword || '';
  let score = 0;
  if (pwd.length >= 8) score++;
  if (/[A-Z]/.test(pwd)) score++;
  if (/[a-z]/.test(pwd)) score++;
  if (/\d/.test(pwd)) score++;
  if (/[\W_]/.test(pwd)) score++;
  strengthScore.value = score;
};

/**
 * Determines the CSS class for a password strength bar.
 * @param {number} level - The bar level (1-4)
 * @returns {string} The CSS class for the bar.
 */
const strengthLevelClass = (level) => {
  if (strengthScore.value >= level) {
    if (strengthScore.value >= 4) return 'strong';
    if (strengthScore.value === 3) return 'medium';
    return 'weak';
  }
  return 'inactive';
};

/**
 * Resets the form to its initial state.
 */
const resetForm = () => {
  form.value = { ...initialForm };
  strengthScore.value = 0;
};

/**
 * Performs client-side form validation before submission.
 * @returns {boolean} - True if the form is valid, false otherwise.
 */
const validateForm = () => {
  let isValid = true;
  // Validation checks for all required fields
  if (!form.value.email) { isValid = false; toastr.error('Email is required', 'Validation Error'); }
  else if (!/^\S+@\S+\.\S+$/.test(form.value.email)) { isValid = false; toastr.error('Invalid email format', 'Validation Error'); }
  if (!form.value.mobileNumber) { isValid = false; toastr.error('Mobile number is required', 'Validation Error'); }
  if (!form.value.fullName) { isValid = false; toastr.error('Full name is required', 'Validation Error'); }
  if (!form.value.username) { isValid = false; toastr.error('Username is required', 'Validation Error'); }
  if (!form.value.newPassword) { isValid = false; toastr.error('Password is required', 'Validation Error'); }
  else if (form.value.newPassword.length < 8) { isValid = false; toastr.error('Password must be at least 8 characters', 'Validation Error'); }
  if (!form.value.confirmPassword) { isValid = false; toastr.error('Confirm password is required', 'Validation Error'); }
  else if (form.value.confirmPassword !== form.value.newPassword) { isValid = false; toastr.error('Passwords do not match', 'Validation Error'); }
  if (!form.value.currency) { isValid = false; toastr.error('Currency is required', 'Validation Error'); }
  if (!form.value.countryCode) { isValid = false; toastr.error('Country Code is required', 'Validation Error'); }
  return isValid;
};

// Set base URL for axios requests, using an environment variable
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

/**
 * Submits the form data to the backend API.
 */
const submitForm = async () => {
  if (validateForm()) {
    isLoading.value = true;
    const formData = new FormData();
    Object.entries(form.value).forEach(([key, value]) => {
      formData.append(key, value);
    });

    try {
      // API endpoint for adding a new member
      const response = await axios.post('/add-member', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });

      // Show a success message
      toastr.success('Member added successfully!', 'Success', {
        positionClass: 'toast-top-right',
        timeOut: 5000,
      });

      // Emit events to the parent component
      emit('submit', response.data);
      emit('update:modelValue', false);
      resetForm();
    } catch (error) {
      console.error('Error submitting form:', error);
      // Show an error message
      if (error.response) {
        toastr.error('Something went wrong! Please try again later.', 'Error', {
          positionClass: 'toast-top-right',
          timeOut: 5000,
        });
      } else {
        toastr.error('Network error. Please check your internet connection.', 'Error', {
          positionClass: 'toast-top-right',
          timeOut: 5000,
        });
      }
    } finally {
      isLoading.value = false;
    }
  }
};

/**
 * Closes the modal and resets the form.
 */
const closeModal = () => {
  emit('update:modelValue', false);
  resetForm();
};

const selectAffiliate = () => {
  console.log('Select affiliate clicked');
  // Logic for selecting an affiliate would go here
};

const unlinkAffiliate = () => {
  form.value.affiliateLogin = '';
};

</script>

<style scoped>
/* Scoped styles from your original component for consistent UI */
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

.custom-checkbox-wrapper input:checked + .checkmark {
  background-color: #f4c938;
  border-color: #f4c938;
}

.custom-checkbox-wrapper input:checked + .checkmark::after {
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
</style>
