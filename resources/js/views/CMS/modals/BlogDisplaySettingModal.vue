<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Blog Display: ON / OFF</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submitForm">
          <div class="modal-body p-5">
            <div class="row">
              <div class="mb-3 col-md-5">
                <label class="form-label">Merchant</label>
                <select
                    v-model="form.merchant"
                    class="form-select"
                    :class="{'is-invalid': errors.merchant}"
                    @change="clearError('merchant')"
                >
                  <option value="MJB">MJB</option>
                  </select>
                <span v-if="errors.merchant" class="text-danger">{{ errors.merchant.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-5">
                <label class="form-label fw-bold">Currency</label>
                <select
                    class="form-select"
                    v-model="form.currency"
                    :class="{'is-invalid': errors.currency}"
                    @change="clearError('currency')"
                >
                  <option value="BDT">BDT</option>
                  <option value="NPR">NPR</option>
                </select>
                <span v-if="errors.currency" class="text-danger">{{ errors.currency.join(', ') }}</span>
              </div>
            </div>

            <div class="row" style="font-size: 12px; font-weight: 600; margin: 10px 1px 10px 1px;">
              Display Field Settings
            </div>

            <div class="col-md-11">
              <label class="form-label">Display Blog Page in Member Site Top Menu</label>
              <div :class="{'is-invalid-group': errors.display_on_top}">
                <div class="form-check form-check-inline mx-3">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="displayOnTopYes"
                      value="yes"
                      v-model="form.displayOnTop"
                      @change="clearError('display_on_top')"
                  />
                  <label class="form-check-label" for="displayOnTopYes">Yes</label>
                </div>

                <div class="form-check form-check-inline">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="displayOnTopNo"
                      value="no"
                      v-model="form.displayOnTop"
                      @change="clearError('display_on_top')"
                  />
                  <label class="form-check-label" for="displayOnTopNo">No</label>
                </div>
              </div>
              <span v-if="errors.display_on_top" class="text-danger">{{ errors.display_on_top.join(', ') }}</span>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
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
import {ref, watch, onMounted} from 'vue';
import axios from 'axios';
import toastr from 'toastr';

// Props and Emits
const props = defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'settingsUpdated']);

// Initial form state
const initialForm = {
  merchant: 'MJB', // Default value
  currency: 'BDT', // Default value
  displayOnTop: 'yes', // Default value
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors from backend
const isLoading = ref(false); // Controls loading state of the submit button

// Configure Axios base URL
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Clears specific error messages for a given field
const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = [];
  }
};

// Fetches current settings from the backend
const fetchSettings = async () => {
  isLoading.value = true;
  try {
    // Adjusted endpoint: we'll hit the 'show' method without an ID parameter
    const response = await axios.get('/blog-display-settings'); // Fetch the single settings record
    if (response.data) {
      form.value.merchant = response.data.merchant || initialForm.merchant;
      form.value.currency = response.data.currency || initialForm.currency;
      form.value.displayOnTop = response.data.display_on_top || initialForm.displayOnTop;
    }
  } catch (error) {
      console.error('Error fetching blog display settings:', error);
      toastr.error('Failed to load blog display settings.');
  } finally {
    isLoading.value = false;
  }
};

// Handles form submission (create or update)
const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear all previous errors

  try {
    // Always use POST to the base endpoint, which the backend will handle as upsert (create or update)
    const response = await axios.post('/blog-display-settings', {
      merchant: form.value.merchant,
      currency: form.value.currency,
      display_on_top: form.value.displayOnTop, // Match Laravel's snake_case
    });

    toastr.success('Blog display settings saved successfully!');
    emit('settingsUpdated', response.data); // Emit event to parent
    closeModal();
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else {
      console.error('Error saving blog display settings:', error);
      toastr.error('Failed to save settings. Please try again.');
    }
  } finally {
    isLoading.value = false;
  }
};

// Resets the form to its initial state
const resetForm = () => {
  form.value = { ...initialForm };
  errors.value = {};
};

// Closes the modal and resets the form
const closeModal = () => {
  emit('update:modelValue', false);
  resetForm();
};

// Watch for modelValue prop changes to fetch data when modal opens
watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    fetchSettings(); // Fetch settings when modal becomes visible
  }
});

// Initial fetch when component is mounted (useful if modal is always visible initially)
onMounted(() => {
  if (props.modelValue) {
    fetchSettings();
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

/* Custom radio button styles */
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

/* Styles for displaying validation errors */
.is-invalid {
  border-color: #dc3545; /* Red border for invalid inputs */
}

/* Apply red border to the container of radio buttons if the validation fails for the group */
.is-invalid-group {
    border: 1px solid #dc3545;
    padding: 5px;
    border-radius: 5px;
}

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Red text for error messages */
  margin-top: 0.25rem;
  display: block; /* Ensures error message appears on its own line */
}
</style>