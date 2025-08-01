<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Group</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Code*</label>
              <input v-model="form.code"
                     class="form-control"
                     :class="{'is-invalid': errors.code}"
                     @input="clearError('code')"
                     required />
              <span v-if="errors.code" class="text-danger">{{ errors.code.join(', ') }}</span>
            </div>

            <div class="mb-3">
              <label class="form-label">Group Name*</label>
              <input v-model="form.name"
                     class="form-control"
                     :class="{'is-invalid': errors.name}"
                     @input="clearError('name')"
                     required />
              <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
            </div>

            <div class="mb-3">
              <label class="form-label">Level*</label>
              <input type="number"
                     v-model="form.level"
                     class="form-control"
                     :class="{'is-invalid': errors.level}"
                     @input="clearError('level')"
                     required />
              <span v-if="errors.level" class="text-danger">{{ errors.level.join(', ') }}</span>
            </div>

            <label class="form-label">Group Logo</label>
            <div class="mb-3 d-flex align-items-center gap-2">
              <input type="file"
                     ref="logoInput"
                     class="form-control choose-file"
                     :class="{'is-invalid': errors.logo}"
                     @change="handleFileChange"
                     accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp" />
              <span v-if="errors.logo" class="text-danger">{{ errors.logo.join(', ') }}</span>
            </div>

            <div class="mb-3 d-flex gap-3">
              <div class="form-check">
                <input class="form-check-input" type="radio" id="status-default" value="Default" v-model="form.status" />
                <label class="form-check-label" for="status-default">Default</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="status-active" value="Active" v-model="form.status" />
                <label class="form-check-label" for="status-active">Active</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" id="status-inactive" value="Inactive" v-model="form.status" />
                <label class="form-check-label" for="status-inactive">Inactive</label>
              </div>
               <span v-if="errors.status" class="text-danger">{{ errors.status.join(', ') }}</span>
            </div>


            <div class="mb-3">
              <label class="form-label">Sequence*</label>
              <input type="number"
                     v-model="form.sequence"
                     class="form-control"
                     :class="{'is-invalid': errors.sequence}"
                     @input="clearError('sequence')"
                     required />
              <span v-if="errors.sequence" class="text-danger">{{ errors.sequence.join(', ') }}</span>
            </div>

            <div class="mb-3">
              <label class="form-label">Remark</label>
              <input v-model="form.remark"
                     class="form-control"
                     :class="{'is-invalid': errors.remark}"
                     @input="clearError('remark')" />
              <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isLoading">Clear</button>
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
import { ref } from 'vue';
import axios from 'axios';
import toastr from 'toastr';

const props = defineProps({ modelValue: Boolean });
const emit = defineEmits(['update:modelValue', 'groupCreated']); // Changed 'submit' to 'groupCreated' for clarity

const initialForm = {
  code: '',
  name: '',
  level: null,
  status: 'Active', // Default status
  sequence: null,
  remark: '',
  logo: null,
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors
const isLoading = ref(false); // Controls loading state of the submit button

const logoInput = ref(null); // Ref for the file input to clear it

// Resets the form to its initial state and clears errors
const resetForm = () => {
  form.value = { ...initialForm };
  errors.value = {}; // Clear all validation errors
  // Clear the file input manually
  if (logoInput.value) {
    logoInput.value.value = '';
  }
};

// Handles file input change and assigns the file to the form data
const handleFileChange = (e) => {
  form.value.logo = e.target.files[0];
  clearError('logo'); // Clear logo error when a file is selected
};

// Clears specific error messages for a given field or multiple fields
const clearError = (...fields) => {
  fields.forEach(field => {
    if (errors.value[field]) {
      errors.value[field] = []; // Reset the error array for the field
    }
  });
};

// Configure Axios base URL (ensure this matches your .env)
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';


// Handles form submission with Axios
const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear all previous errors before a new submission

  const formData = new FormData();
  // Append all form fields to FormData object
  // Ensure level and sequence are numbers if required by backend, though FormData converts to string
  for (const key in form.value) {
    formData.append(key, form.value[key]);
  }

  try {
    const response = await axios.post('/membergroups', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }, // Important for file uploads
    });

    toastr.success(response.data.message || 'Group created successfully!');
    emit('groupCreated', response.data.group); // Emit event to parent with new data
    closeModal(); // Close the modal and reset form

  } catch (error) {
    console.error('Error submitting form:', error); // Log the error for debugging

    if (error.response) {
      if (error.response.status === 422 && error.response.data.errors) {
        // Handle Laravel validation errors (HTTP 422)
        errors.value = error.response.data.errors;
        toastr.error('Please correct the highlighted errors.');
      } else if (error.response.status === 409 && error.response.data.message) {
        // Handle specific conflict errors (e.g., duplicate unique fields)
        toastr.error(error.response.data.message);
      } else if (error.response.data && error.response.data.message) {
        // Handle other specific error messages from the backend
        toastr.error(error.response.data.message);
      } else {
        // Generic error for other HTTP error statuses
        toastr.error(`Server Error: ${error.response.status}. Please try again.`);
      }
    } else if (error.request) {
      // The request was made but no response was received (e.g., network error, CORS issue)
      toastr.error('Network Error: No response from server. Please check your connection.');
    } else {
      // Something happened in setting up the request that triggered an Error
      toastr.error('An unexpected error occurred. Please try again.');
    }
  } finally {
    isLoading.value = false; // Always reset loading state
  }
};

// Closes the modal and resets the form
const closeModal = () => {
  emit('update:modelValue', false); // Notify parent to hide modal
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

.choose-file {
  border-radius: 8px;
  border-color: #d6b402;
}

/* Custom radio button appearance */
input[type='radio'] {
  appearance: none;
  -webkit-appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ccc;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  outline: none;
  transition: 0.3s;
}

input[type='radio']:checked {
  border-color: #ffcc00;
  background-color: #ffcc00;
}

input[type='radio']:checked::before {
  content: '';
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

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Red text for error messages */
  margin-top: 0.25rem;
  display: block; /* Ensures error message appears on its own line */
}
</style>