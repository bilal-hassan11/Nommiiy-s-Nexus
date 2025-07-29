<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Affiliate Pop Up Banner</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Merchant ID*</label>
                <select
                    v-model="form.merchantId"
                    class="form-select"
                    :class="{'is-invalid': errors.merchantId}"
                    @change="clearError('merchantId')"
                >
                  <option value="MJB">MJB</option>
                  </select>
                <span v-if="errors.merchantId" class="text-danger">{{ errors.merchantId.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Status*</label>
                <select
                    v-model="form.status"
                    class="form-select"
                    :class="{'is-invalid': errors.status}"
                    @change="clearError('status')"
                >
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
                <span v-if="errors.status" class="text-danger">{{ errors.status.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Language*</label>
                <select
                    v-model="form.language"
                    class="form-select"
                    :class="{'is-invalid': errors.language}"
                    @change="clearError('language')"
                >
                  <option value="EN-BD">EN-BD</option>
                  </select>
                <span v-if="errors.language" class="text-danger">{{ errors.language.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Title*</label>
                <input
                    v-model="form.title"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.title}"
                    @blur="clearError('title')"
                />
                <span v-if="errors.title" class="text-danger">{{ errors.title.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Description*</label>
                <input
                    v-model="form.description"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.description}"
                    @blur="clearError('description')"
                />
                <span v-if="errors.description" class="text-danger">{{ errors.description.join(', ') }}</span>
              </div>
              <div class="col-md-4">
                <label class="form-label">Link*</label>
                <input
                    v-model="form.link"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.link}"
                    @blur="clearError('link')"
                />
                <span v-if="errors.link" class="text-danger">{{ errors.link.join(', ') }}</span>
                <div class="mt-2">
                  <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="openCurrent"
                        value="current"
                        v-model="form.linkTarget"
                        :class="{'is-invalid': errors.linkTarget}"
                        @change="clearError('linkTarget')"
                    />
                    <label class="form-check-label" for="openCurrent">Open in Current Page</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="openNew"
                        value="new"
                        v-model="form.linkTarget"
                        :class="{'is-invalid': errors.linkTarget}"
                        @change="clearError('linkTarget')"
                    />
                    <label class="form-check-label" for="openNew">Open in New Page</label>
                  </div>
                  <span v-if="errors.linkTarget" class="text-danger d-block">{{ errors.linkTarget.join(', ') }}</span>
                </div>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Start Date*</label>
                <input
                    v-model="form.startDate"
                    type="date"
                    class="form-control"
                    :class="{'is-invalid': errors.startDate}"
                    @blur="clearError('startDate')"
                />
                <span v-if="errors.startDate" class="text-danger">{{ errors.startDate.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">End Date*</label>
                <input
                    v-model="form.endDate"
                    type="date"
                    class="form-control"
                    :class="{'is-invalid': errors.endDate}"
                    @blur="clearError('endDate')"
                />
                <span v-if="errors.endDate" class="text-danger">{{ errors.endDate.join(', ') }}</span>
              </div>
            </div>
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Image (Web & Mobile)*</label>
                <input
                    type="file"
                    @change="onFileChange($event, 'mobileImage')"
                    class="form-control"
                    :class="{'is-invalid': errors.mobileImage}"
                />
                <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 4px 4px; color: #d87a00">
                  Image size (Web & Mobile): 750 x 150</small>
                <span v-if="errors.mobileImage" class="text-danger">{{ errors.mobileImage.join(', ') }}</span>
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
import {onMounted, ref} from 'vue'
import axios from 'axios'; // Import Axios
import toastr from 'toastr'; // Import Toastr

// Props and Emits
defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'submit'])

// Initial form state
const initialForm = {
  merchantId: 'MJB',
  link: "",
  linkTarget: 'current',
  status: 'Active',
  title: '',
  description: '',
  language: 'EN-BD',
  startDate: '',
  endDate: '',
  mobileImage: null
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors from backend
const isLoading = ref(false); // Controls loading state of the submit button

// Sets default start and end dates
const setDefaultDates = () => {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');

  // First day of current month
  form.value.startDate = `${yyyy}-${mm}-01`;
  // Today's date
  form.value.endDate = `${yyyy}-${mm}-${dd}`;
};

// Call setDefaultDates when the component is mounted
onMounted(() => {
  setDefaultDates();
});

// Handles file input change
const onFileChange = (event, key) => {
  const file = event.target.files[0];
  if (file) {
    form.value[key] = file;
    clearError(key); // Clear error for this specific file input
  } else {
    form.value[key] = null;
  }
};

// Resets the form to its initial state, clears errors, and re-sets default dates
const resetForm = () => {
  form.value = { ...initialForm };
  setDefaultDates();
  errors.value = {}; // Clear all errors
};

// Clears specific error messages for a given field
const clearError = (field) => {
    if (errors.value[field]) {
        errors.value[field] = [];
    }
};

// Configure Axios base URL to point to your Laravel API
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Handles form submission
const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear all previous errors before a new submission

  const formData = new FormData();
  for (const key in form.value) {
    const value = form.value[key];
    // Append non-null/undefined values. For files, append File object directly.
    if (value instanceof File) {
      formData.append(key, value);
    } else if (value !== null && value !== undefined && value !== '') {
      formData.append(key, value);
    }
  }

  try {
    const response = await axios.post('/affiliate-pop-up-banners', formData, {
      headers: {
        'Content-Type': 'multipart/form-data', // Crucial for sending files
      },
    });
    toastr.success('Affiliate Pop Up Banner added successfully!');
    emit('submit', response.data); // Emit event to parent component with new data
    closeModal(); // Close the modal and reset form
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else {
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

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Red text for error messages */
  margin-top: 0.25rem;
  display: block; /* Ensures error message appears on its own line */
}
</style>