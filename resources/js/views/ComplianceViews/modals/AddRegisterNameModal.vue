<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Register Name Blacklist</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                    @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Full Name*</label>
              <input
                v-model="form.fullName"
                class="form-control"
                type="text"
                :class="{'is-invalid': errors.fullName}"
                @input="clearError('fullName')"
              />
              <span v-if="errors.fullName" class="text-danger">{{ errors.fullName.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input
                type="text"
                class="form-control"
                v-model="form.remark"
                :class="{'is-invalid': errors.remark}"
                @input="clearError('remark')"
              />
              <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button @click="resetForm" type="button" class="clear-btn btn btn-outline-dark" :disabled="isSaving">Clear</button>
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
import {ref} from 'vue';
import axios from 'axios';
import toastr from 'toastr'; // Ensure toastr is installed and configured

defineProps({
  modelValue: Boolean
});

// Emits for modal visibility and successful submission
const emit = defineEmits(['update:modelValue', 'blacklistEntryCreated']); // Changed 'submit' to 'blacklistEntryCreated' for clarity

const isSaving = ref(false); // Controls loading state of the submit button
const errors = ref({}); // Stores validation errors from backend

const initialForm = {
  fullName: '',
  remark: ''
}

const form = ref({...initialForm});

// Resets the form to its initial state and clears errors
const resetForm = () => {
  form.value = {...initialForm};
  errors.value = {}; // Clear all validation errors
};

// Clears specific error messages for a given field
const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = []; // Reset the error array for the field
  }
};

// Configure Axios base URL (ensure this matches your .env)
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Handles form submission with Axios
const submitForm = async () => {
  isSaving.value = true;
  errors.value = {}; // Clear all previous errors before a new submission

  try {
    const response = await axios.post('/register-name-blacklists', form.value);

    toastr.success(response.data.message || 'Blacklist entry created successfully!');
    emit('blacklistEntryCreated', response.data.blacklist); // Emit event to parent with new data
    closeModal(); // Close the modal and reset form

  } catch (error) {
    // Check if the error is a validation error (HTTP 422) from Laravel
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else if (error.response && error.response.status === 409) {
      // Specific handling for duplicate entry (from unique constraint)
      toastr.error(error.response.data.message);
    }
    else {
      // Handle other types of errors (network issues, server errors, etc.)
      console.error('Error submitting form:', error);
      toastr.error('Failed to create blacklist entry. Please try again.');
    }
  } finally {
    isSaving.value = false; // Always reset loading state
  }
};

// Closes the modal and resets the form
const closeModal = () => {
  emit('update:modelValue', false); // Notify parent to close modal
  resetForm(); // Reset form state
};
</script>

<style scoped>
/* Modal overlay styling */
.modal {
  background-color: rgba(0, 0, 0, 0.5);
}

/* Original styles from your component + validation styles */
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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