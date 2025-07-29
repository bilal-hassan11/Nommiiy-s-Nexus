<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">General Info Modal</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label fw-bold">Currency</label>
                <select class="form-select" v-model="form.currency" @change="fetchSettings" :disabled="isLoading">
                  <option>BDT</option>
                  <option>NPR</option>
                </select>
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Editing this setting will turn On/Off general info
                </p>
              </div>
            </div>
            <div class="table-responsive mb-4">
              <div v-if="isLoading" class="text-center py-5">
                  <div class="spinner-border text-warning" role="status">
                      <span class="visually-hidden">Loading settings...</span>
                  </div>
                  <p class="mt-2 text-muted">Loading settings for selected currency...</p>
              </div>
              <table v-else class="table table-striped align-middle text-center">
                <thead class="table-light">
                <tr>
                  <th class="text-start px-3">General Info</th>
                  <th class="text-start" style="width: 120px;">Turn On/Off</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="text-start px-3">About Us</td>
                  <td class="text-start">
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.aboutUsEnabled"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">FAQ</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.faqEnabled"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Terms & Conditions</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.termsEnabled"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Privacy Policy</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.privacyPolicyEnabled"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Responsible Gaming</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.responsibleGamingEnabled"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Disconnect Policy</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.disconnectPolicyEnabled"/>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isSaving">Cancel</button>
            <button type="submit" class="btn submit-btn" :disabled="isSaving">
              <span v-if="isSaving" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              {{ isSaving ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, watch} from 'vue'
import axios from 'axios';
import toastr from 'toastr';

// Props and Emits
const props = defineProps({
  modelValue: Boolean
})
const emit = defineEmits(['update:modelValue', 'submit'])

// Form data and loading states
const form = ref({
  currency: 'BDT',
  aboutUsEnabled: true,
  faqEnabled: true,
  termsEnabled: false,
  privacyPolicyEnabled: false,
  responsibleGamingEnabled: false,
  disconnectPolicyEnabled: false,
})

const isLoading = ref(false); // For fetching settings
const isSaving = ref(false); // For saving settings

// Configure Axios base URL
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Function to fetch settings from the backend
const fetchSettings = async () => {
  isLoading.value = true;
  try {
    const response = await axios.get('/general-info-settings', {
      params: {
        currency: form.value.currency,
      }
    });
    const data = response.data; // Expecting a single object or null

    if (data) {
      // Map backend snake_case to frontend camelCase
      form.value.aboutUsEnabled = data.about_us_enabled;
      form.value.faqEnabled = data.faq_enabled;
      form.value.termsEnabled = data.terms_enabled;
      form.value.privacyPolicyEnabled = data.privacy_policy_enabled;
      form.value.responsibleGamingEnabled = data.responsible_gaming_enabled;
      form.value.disconnectPolicyEnabled = data.disconnect_policy_enabled;
      // toastr.success('Settings loaded successfully!'); // Optional: success toast
    } else {
      // If no settings found for currency, reset to defaults or all true
      // and allow saving to create a new entry.
      resetFormToDefaults(); // Reset to default form values
      toastr.info('No settings found for this currency. Default values are shown.');
    }
  } catch (error) {
    console.error('Error fetching general info settings:', error);
    toastr.error('Failed to fetch general info settings. Please try again.');
    resetFormToDefaults(); // Even on error, set sensible defaults
  } finally {
    isLoading.value = false;
  }
};

// Function to reset form values to initial defaults
const resetFormToDefaults = () => {
  form.value = {
    currency: form.value.currency, // Keep selected currency
    aboutUsEnabled: true,
    faqEnabled: true,
    termsEnabled: false,
    privacyPolicyEnabled: false,
    responsibleGamingEnabled: false,
    disconnectPolicyEnabled: false,
  };
};

// Function to submit (save) the settings to the backend
const submit = async () => {
  isSaving.value = true;
  try {
    // Map frontend camelCase to backend snake_case
    const payload = {
      currency: form.value.currency,
      about_us_enabled: form.value.aboutUsEnabled,
      faq_enabled: form.value.faqEnabled,
      terms_enabled: form.value.termsEnabled,
      privacy_policy_enabled: form.value.privacyPolicyEnabled,
      responsible_gaming_enabled: form.value.responsibleGamingEnabled,
      disconnect_policy_enabled: form.value.disconnectPolicyEnabled,
    };

    await axios.put('/general-info-settings', payload); // Use PUT for upserting
    toastr.success('General info settings saved successfully!');
    emit('submit', payload); // Emit the saved data to parent
    closeModal();
  } catch (error) {
    console.error('Error saving general info settings:', error);
    toastr.error('Failed to save general info settings. Please try again.');
  } finally {
    isSaving.value = false;
  }
}

// Close modal and reset currency to BDT for next open
const closeModal = () => {
  emit('update:modelValue', false)
  // When closing, reset the form to its initial state for next opening
  form.value.currency = 'BDT';
  resetFormToDefaults();
}

// Watch for modelValue prop changes to fetch settings when modal opens
watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    fetchSettings(); // Fetch settings when the modal is opened
  }
});
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

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
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

.form-check-input:checked {
  background-color: #d6b402;
  border-color: #d6b402;
}
</style>