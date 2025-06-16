<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Member</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Email</label>
              <input type="email" v-model="form.email" class="form-control"/>
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                eg: test@test.com</p>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select">
                <option>BDT</option>
                <option>NPR</option>
              </select>
            </div>
            <div class="row mb-3 col-lg-12 col-md-6 col-sm-6">
              <div class="col-md-4">
                <label class="form-label">Country Code</label>
                <select v-model="form.countryCode" class="form-select">
                  <option v-for="item in countryCodes" :key="item.code" :value="item.code">
                    {{ item.code }}
                  </option>
                </select>
              </div>
              <div class="col-md-8">
                <label class="form-label">Mobile Number</label>
                <input v-model="form.mobileNumber" class="form-control"/>
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  (Begin with country code: eg: 601234567890)
                </p>
              </div>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Full Name*</label>
              <input v-model="form.fullName" class="form-control" required/>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Username*</label>
              <input v-model="form.username" class="form-control" required/>
            </div>

            <!-- New Password Field with Strength Meter -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">New Password*</label>
              <input type="password" v-model="form.newPassword" class="form-control" @input="evaluatePasswordStrength"
                     required/>
            </div>

            <!-- Password Strength + Checkbox -->
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
                <input type="checkbox" v-model="form.forcePasswordChange" class="custom-checkbox"/>
                <span class="checkmark"></span>
                Force Password Change After First Login
              </label>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Confirm Password*</label>
              <input type="password" v-model="form.confirmPassword" class="form-control" required/>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Bank</label>
              <select v-model="form.bank" class="form-select" placeholder="--Select a Bank--">
                <option value="" disabled selected>--Select a Bank--</option>
                <option>Bank ABC</option>
                <option>Bank XYZ</option>
              </select>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Account Number</label>
              <input v-model="form.accountNumber" class="form-control"/>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Account Name</label>
              <input v-model="form.accountName" class="form-control"/>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Bank Branch</label>
              <input v-model="form.bankBranch" class="form-control"/>
            </div>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Referral Code</label>
              <input v-model="form.referralCode" class="form-control"/>
            </div>

            <label class="form-label row" style="margin-left: 4px">Affiliate Login</label>

            <div class="mb-3 col-lg-12 col-md-6 col-sm-6 d-flex align-items-center justify-between">
              <input v-model="form.affiliateLogin" class="form-control" disabled style="border-color: #ffcc00"/>

              <div class="form-check gap-1 d-flex align-center">
                <button type="button" class="btn btn-outline-success affiliate-btn" @click="doSomething"> Select
                  Affiliate
                </button>
              </div>
              <div class="form-check gap-1 d-flex align-center">
                <button type="button" class="btn btn-outline-danger affiliate-btn" @click="doSomething"> Unlink
                  Affiliate
                </button>
              </div>
            </div>

          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const initialForm = {
  email: '',
  currency: 'BDT',
  countryCode: '+880',
  mobileNumber: '',
  fullName: '',
  username: '',
  newPassword: '',
  forcePasswordChange: false,  // Corrected type
  confirmPassword: '',
  bank: '',
  accountNumber: '',
  accountName: '',
  bankBranch: '',
  referralCode: '',
  affiliateLogin: '',
}

const countryCodes = [
  {code: '+1', country: 'USA/Canada'},
  {code: '+44', country: 'UK'},
  {code: '+91', country: 'India'},
  {code: '+92', country: 'Pakistan'},
  {code: '+880', country: 'Bangladesh'},
  {code: '+977', country: 'Nepal'},
  {code: '+60', country: 'Malaysia'},
  {code: '+971', country: 'UAE'},
];

const form = ref({...initialForm});

const resetForm = () => {
  form.value = {...initialForm}
}

// TODO: Implement this functionality
const doSomething = (e) => {
  console.log("Functionality yet to be built", e);
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm();
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm();
}

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

</script>


<style scoped>
label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select {
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
