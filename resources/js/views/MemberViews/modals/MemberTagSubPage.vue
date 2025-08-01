<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Tag Management</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2 disabled">Tags Adjustment History</button>
    </div>
  </div>

  <div class="form-container py-4">
    <h3 class="form-title mb-4">New Tag</h3>
    <form @submit.prevent="submit">
      <div class="mb-3 btn-group gap-3" role="group">
        <button type="button"
                class="btn mode-btn"
                :class="{ 'active-mode': form.mode === 'single' }"
                @click="form.mode = 'single'">Single
        </button>
        <button type="button"
                class="btn mode-btn"
                :class="{ 'active-mode': form.mode === 'batch' }"
                @click="form.mode = 'batch'">Batch
        </button>
      </div>

      <div class="mb-3 col-lg-6">
        <label class="form-label">*Tag Name</label>
        <input type="text"
               v-model="form.tag_name"
               class="form-control"
               placeholder="Please Enter Text"
               :class="{'is-invalid': errors.tag_name}"
               @input="clearError('tag_name')"
               required
        />
        <span v-if="errors.tag_name" class="text-danger">{{ errors.tag_name.join(', ') }}</span>
      </div>

      <div class="row mb-3">
        <div class="col-lg-6">
          <label class="form-label">Description</label>
          <textarea
            v-model="form.description"
            class="form-control"
            :class="{'is-invalid': errors.description}"
            @input="clearError('description')"
          ></textarea>
          <span v-if="errors.description" class="text-danger">{{ errors.description.join(', ') }}</span>
        </div>
        <div class="col-lg-6">
          <label class="form-label">Remark</label>
          <textarea
            v-model="form.remark"
            class="form-control"
            :class="{'is-invalid': errors.remark}"
            @input="clearError('remark')"
          ></textarea>
          <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
        </div>
      </div>

      <div class="mb-3">
        <h6>Domain Binding</h6>
        <div class="radio-group gap-3">
          <div class="form-check gap-2 d-flex align-center">
            <input class="form-check-input" type="radio" v-model="form.domain_binding" id="domainYes" :value="fasle">
            <label class="form-check-label" for="domainYes">Yes</label>
          </div>
          <div class="form-check gap-2 d-flex align-center">
            <input class="form-check-input" type="radio" v-model="form.domain_binding" id="domainNo" :value="true">
            <label class="form-check-label" for="domainNo">No</label>
          </div>
        </div>
        <span v-if="errors.domain_binding" class="text-danger">{{ errors.domain_binding.join(', ') }}</span>
      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn cancel-btn me-2" @click="resetForm" :disabled="isLoading">Clear</button>
        <button type="submit" class="btn submit-btn" :disabled="isLoading">
          <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          {{ isLoading ? 'Saving...' : 'Save' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import toastr from 'toastr'; // Make sure toastr is installed and accessible globally or imported correctly

// Initial form state, using 'domain_binding' to match backend name
const initialForm = {
  tag_name: '',
  description: '',
  remark: '',
  domain_binding: false, // Matches Laravel's boolean column
  mode: 'single', // Default mode for the new tag form
};

const form = ref({ ...initialForm });
const isLoading = ref(false); // For form submission loading indicator
const errors = ref({}); // To store validation error messages from backend


// Function to clear specific validation error messages
const clearError = (field) => {
  if (errors.value[field]) {
    delete errors.value[field]; // Removes the error for the given field
  }
};

// Reset form fields to their initial state and clear errors
const resetForm = () => {
  form.value = { ...initialForm }; // Reset form data
  errors.value = {}; // Clear all validation errors
  toastr.info('Form cleared.'); // Provide user feedback
};

// Form submission logic using Axios
const submit = async () => {
  isLoading.value = true; // Set loading state to true
  errors.value = {}; // Clear all previous errors before a new submission

  const formData = new FormData();
  // Append all form fields to FormData object
  // Convert boolean values to "true" or "false" strings for FormData,
  // as Laravel's boolean validation rule can handle them.
  formData.append('tag_name', form.value.tag_name);
  formData.append('description', form.value.description || ''); // Send empty string if null/undefined
  formData.append('remark', form.value.remark || ''); // Send empty string if null/undefined
  // Ensure 'domain_binding' in formData matches the Laravel backend column name
  formData.append('domain_binding', form.value.domain_binding ? 'true' : 'false');
  formData.append('mode', form.value.mode);

  // Configure Axios base URL (ensure this matches your .env)
  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';


  try {
    // Axios call to your Laravel backend API endpoint
    const response = await axios.post('/getmember-tags', formData, {
      headers: {
        'Content-Type': 'multipart/form-data', // Important for FormData
      },
    });

    toastr.success(response.data.message || 'Member Tag added successfully!');
    resetForm(); // Reset form on success
  } catch (error) {
    console.error('Error submitting tag:', error); // Log the error for debugging

    if (error.response) {
      if (error.response.status === 422 && error.response.data.errors) {
        // Handle Laravel validation errors (status 422 Unprocessable Entity)
        errors.value = error.response.data.errors;
        toastr.error('Please correct the highlighted errors.');
      } else if (error.response.data && error.response.data.message) {
        // Handle other specific backend error messages (e.g., 409 Conflict for unique constraint)
        toastr.error(error.response.data.message);
      } else {
        // Generic error for other HTTP error statuses (e.g., 500 Internal Server Error)
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

// The `cancel` function now simply clears the form. If you had routing, you'd use `router.push` here.
const cancel = () => {
  resetForm();
};
</script>

<style scoped>
/* Your existing CSS styles are perfectly fine and remain unchanged. */
.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-header {
  padding-right: 10px;
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select, textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.radio-group {
  display: flex;
}

.form-check {
  display: flex;
  align-items: flex-start;
  margin: 0 10px 0 0;
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
  background: #ccc;
}

.cancel-btn:hover {
  background: #a5a5a1;
}

.mode-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: 1px solid #ddd;
  background: white;
  color: #333;
}

.mode-btn.active-mode {
  background: #d6b402;
  color: white;
  border-color: #d6b402;
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.tag-btn:hover {
  background: #d6b402;
}

/* Validation error styles */
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