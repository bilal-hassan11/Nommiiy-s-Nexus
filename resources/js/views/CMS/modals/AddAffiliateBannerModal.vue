<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Banner</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Merchant ID*</label>
                <select v-model="form.merchantId" class="form-select" :class="{'is-invalid': errors.merchantId}" @change="clearError('merchantId')">
                  <option value="">Select Merchant</option>
                  <option value="MJB">MJB</option>
                  </select>
                <span v-if="errors.merchantId" class="text-danger">{{ errors.merchantId.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Status*</label>
                <select v-model="form.status" class="form-select" :class="{'is-invalid': errors.status}" @change="clearError('status')">
                  <option value="">Select Status</option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
                <span v-if="errors.status" class="text-danger">{{ errors.status.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Title*</label>
                <input v-model="form.title" type="text" class="form-control" :class="{'is-invalid': errors.title}" @blur="clearError('title')"/>
                <span v-if="errors.title" class="text-danger">{{ errors.title.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Description</label>
                <input v-model="form.description" type="text" class="form-control" :class="{'is-invalid': errors.description}" @blur="clearError('description')"/>
                <span v-if="errors.description" class="text-danger">{{ errors.description.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Language*</label>
                <select v-model="form.language" class="form-select" :class="{'is-invalid': errors.language}" @change="clearError('language')">
                  <option value="">Select Language</option>
                  <option value="EN-BD">EN-BD</option>
                  </select>
                <span v-if="errors.language" class="text-danger">{{ errors.language.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Index*</label>
                <input v-model="form.index" type="number" class="form-control" :class="{'is-invalid': errors.index}" @blur="clearError('index')"/>
                <span v-if="errors.index" class="text-danger">{{ errors.index.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Start Date*</label>
                <input v-model="form.startDate" type="date" class="form-control" :class="{'is-invalid': errors.startDate}" @blur="clearError('startDate')"/>
                <span v-if="errors.startDate" class="text-danger">{{ errors.startDate.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">End Date*</label>
                <input v-model="form.endDate" type="date" class="form-control" :class="{'is-invalid': errors.endDate}" @blur="clearError('endDate')"/>
                <span v-if="errors.endDate" class="text-danger">{{ errors.endDate.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Mobile Image*</label>
                <input type="file" @change="onFileChange($event, 'mobileImage')" class="form-control" :class="{'is-invalid': errors.mobileImage}" accept="image/*"/>
                <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 4px 4px; color: #d87a00">
                  Mobile image size: 1920 x 600</small>
                <span v-if="errors.mobileImage" class="text-danger">{{ errors.mobileImage.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Web Image*</label>
                <input type="file" @change="onFileChange($event, 'webImage')" class="form-control" :class="{'is-invalid': errors.webImage}" accept="image/*"/>
                <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Web image size: 1920 x 600</small>
                <span v-if="errors.webImage" class="text-danger">{{ errors.webImage.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Href</label>
                <input v-model="form.href" type="text" class="form-control" :class="{'is-invalid': errors.href}" @blur="clearError('href')"/>
                <span v-if="errors.href" class="text-danger">{{ errors.href.join(', ') }}</span>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isLoading">Cancel</button>
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
import {onMounted, ref} from 'vue';
import axios from 'axios';
import toastr from 'toastr'; // Ensure toastr is installed and configured in your main.js/app.js

const props = defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

// Initial form state, with values that align with validation rules (e.g., empty string for required selects, null for required numbers)
const initialForm = {
  merchantId: '',
  href: '',
  status: '',
  title: '',
  description: '',
  language: '',
  index: null,
  startDate: '',
  endDate: '',
  mobileImage: null,
  webImage: null
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors from backend
const isLoading = ref(false); // Controls loading state of the submit button

// Sets default start and end dates to the current month's first day and today's date
const setDefaultDates = () => {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');

  form.value.startDate = `${yyyy}-${mm}-01`;
  form.value.endDate = `${yyyy}-${mm}-${dd}`;
};

// Call setDefaultDates when the component is mounted
onMounted(() => {
  setDefaultDates();
});

// Handles file input changes, storing the selected file and clearing its error
const onFileChange = (event, key) => {
  const file = event.target.files[0];
  if (file) {
    form.value[key] = file;
    clearError(key); // Clear any existing validation error for this file input
  } else {
    form.value[key] = null; // If no file is selected (e.g., user cancels), set to null
  }
};

// Resets the form to its initial state, clears errors, and re-sets default dates
const resetForm = () => {
  form.value = { ...initialForm };
  setDefaultDates();
  errors.value = {};
  // Clear file input values directly by resetting them if needed, otherwise form.value[key] = null is sufficient
  // For file inputs to visually clear, you might need a ref to the input or re-render the component.
};

// Clears specific error messages for a given field
const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = []; // Reset the error array for the field
  }
};

// Configure Axios base URL to point to your Laravel API
// This should match the VITE_API_BASE_URL in your .env file
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Handles form submission
const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear all previous errors before a new submission

  const formData = new FormData();
  // Append all form fields to FormData
  for (const key in form.value) {
    const value = form.value[key];
    // Special handling for files: append the File object directly
    if (value instanceof File) {
      formData.append(key, value);
    } else if (value !== null && value !== undefined) {
      // Append other non-null/undefined values (strings, numbers, dates)
      formData.append(key, value);
    }
  }

  try {
    const response = await axios.post('/banners', formData, {
      headers: {
        'Content-Type': 'multipart/form-data', // Crucial for sending files
      },
    });
    toastr.success('Banner added successfully!');
    emit('submit', response.data); // Emit event to parent component with new data
    closeModal(); // Close the modal and reset form
  } catch (error) {
    // Check if the error is a validation error (HTTP 422) from Laravel
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else {
      // Handle other types of errors (network issues, server errors, etc.)
      console.error('Error submitting form:', error);
      toastr.error('Failed to add banner. Please try again.');
    }
  } finally {
    isLoading.value = false; // Always reset loading state
  }
};

// Closes the modal and resets the form
const closeModal = () => {
  emit('update:modelValue', false); // Notify parent to close modal
  resetForm(); // Reset form state
};
</script>

<style scoped>
/* Standard label and input styling */
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

/* Submit button styling */
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

/* Cancel button styling */
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

/* Styles for displaying validation errors */
.is-invalid {
  border-color: #dc3545; /* Red border for invalid inputs */
}

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Red text for error messages */
  margin-top: 0.25rem;
  display: block; /* Ensures error message appears on its own line */
}
</style>