Here's the updated "VIP Gift Dispatch" Vue component, now equipped with client-side validation for required inputs, comprehensive error handling using Axios for form submission, and a custom toaster-like message system for both success and error notifications.

I've ensured that:

  * Required fields are visually marked with an asterisk (`*`).
  * The `validateForm` function performs client-side checks for all mandatory inputs.
  * The `submit` function uses Axios to send data to your Laravel backend.
  * The `try-catch-finally` block handles successful submissions, network errors, and specific backend validation errors (assuming Laravel's common 422 response with an `errors` object).
  * A `showMessage` function creates and displays the toaster messages for immediate user feedback.
  * The "Save" button shows a loading state (`Saving...`) and is disabled during submission.

<!-- end list -->

```vue
<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">VIP Gift Dispatch</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Search Username <span class="text-red-500">*</span></label>
              <select v-model="form.searchUsername" class="form-select"
                      style="border-color: #ffcc00; border-radius: 2px" :disabled="isLoading">
                <option value="" disabled>Select a username</option>
                <option v-for="user in usernameOptions" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Username <span class="text-red-500">*</span></label>
              <select v-model="form.username" class="form-select" :disabled="isLoading">
                <option value="" disabled>Select a username</option>
                <option v-for="user in usernameOptions" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">
                New VIP Level <span class="text-red-500">*</span>
              </label>
              <select class="form-select" v-model="form.vipLevel" :disabled="isLoading">
                <option value="" disabled>Select VIP Level</option>
                <option value="vip1">VIP 1</option>
                <option value="vip2">VIP 2</option>
              </select>
            </div>

            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Real Deliver <span class="text-red-500">*</span></label>
              <input type="text" v-model="form.realDeliver" class="form-control" :disabled="isLoading"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Member's Address <span class="text-red-500">*</span></label>
              <input type="text" v-model="form.memberAddress" class="form-control" :disabled="isLoading"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" v-model="form.remark" class="form-control" :disabled="isLoading"/>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isLoading">Cancel</button>
            <button type="submit" class="btn submit-btn" :disabled="isLoading">
              {{ isLoading ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Message Box Container for toaster messages -->
  <div id="message-box-container"></div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import toastr from 'toastr';

// Props and emits
defineProps({
  modelValue: Boolean,
});
const emit = defineEmits(['update:modelValue', 'submit']);

// Initial form state
const initialForm = {
  username: '',
  searchUsername: '',
  vipLevel: '',
  realDeliver: '',
  memberAddress: '',
  remark: '',
};

// Reactive form state
const form = ref({ ...initialForm });

// Loading state for form submission
const isLoading = ref(false);

// Dummy data for username options
const usernameOptions = [
  'john.doe@example.com',
  'jane.smith@example.com',
  'alice.johnson@example.com',
  'bob.lee@example.com'
];

// Axios base URL setup
// IMPORTANT: Replace 'http://localhost/api' with your actual Laravel backend API URL
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

// Function to show custom message (simulating toastr)
const showMessage = (message, type = 'info') => {
  let container = document.getElementById('message-box-container');
  if (!container) {
    // If container doesn't exist, create it and append to body
    const newContainer = document.createElement('div');
    newContainer.id = 'message-box-container';
    document.body.appendChild(newContainer);
    container = newContainer;
  }

  const messageBox = document.createElement('div');
  messageBox.className = `fixed bottom-4 right-4 p-4 rounded-md shadow-lg text-white z-50 transition-all duration-300 ease-in-out transform opacity-0 translate-y-full`;

  let bgColor;
  if (type === 'success') {
    bgColor = 'bg-green-500';
  } else if (type === 'error') {
    bgColor = 'bg-red-500';
  } else {
    bgColor = 'bg-blue-500';
  }

  messageBox.classList.add(bgColor);
  messageBox.textContent = message;
  container.appendChild(messageBox);

  // Trigger the transition
  requestAnimationFrame(() => {
    messageBox.classList.remove('opacity-0', 'translate-y-full');
    messageBox.classList.add('opacity-100', 'translate-y-0');
  });

  setTimeout(() => {
    messageBox.classList.remove('opacity-100', 'translate-y-0');
    messageBox.classList.add('opacity-0', 'translate-y-full');
    messageBox.addEventListener('transitionend', () => messageBox.remove(), { once: true });
  }, 3000);
};

// Client-side form validation
const validateForm = () => {
  if (!form.value.searchUsername) {
    toastr.error('Search Username is Required!');
    return false;
  }
  if (!form.value.username) {
    toastr.error(' Username is Required!');
    return false;
  }
  if (!form.value.vipLevel) {
    toastr.error('New VIP Level is Required!');
    return false;
  }
  if (!form.value.realDeliver || form.value.realDeliver.trim() === '') {
    toastr.error('Real Driver is Required!');
    return false;
  }
  if (!form.value.memberAddress || form.value.memberAddress.trim() === '') {
    toastr.error('Member Address is Required!');
    return false;
  }
  return true;
};

// Form submission logic
const submitForm = async () => {
  if (!validateForm()) {
    return; // Stop if client-side validation fails
  }

  isLoading.value = true; // Set loading state

  // Prepare data for submission
  const payload = {
    search_username: form.value.searchUsername,
    username: form.value.username,
    vip_level: form.value.vipLevel,
    real_deliver: form.value.realDeliver,
    member_address: form.value.memberAddress,
    remark: form.value.remark,
  };

  try {
    // Make the Axios POST request to your Laravel backend
    // Replace '/api/vip-gift-dispatch' with your actual API endpoint
    const response = await axios.post('/add-member-tag', payload);

    // Show success message
    toastr.success('VIP Gift Dispatch Successfully!');

    emit('submit', response.data); // Emit success data to parent component
    closeModal(); // Close modal on successful submission
  } catch (error) {
    console.error('Error submitting VIP Gift Dispatch form:', error);

    if (error.response) {
      // Server responded with a status other than 2xx (e.g., 422 for validation errors)
      if (error.response.status === 422 && error.response.data.errors) {
        // Handle Laravel validation errors (assuming 'errors' object structure)
        for (const field in error.response.data.errors) {
          error.response.data.errors[field].forEach(msg => showMessage(msg, 'error'));
        }
      } else if (error.response.data && error.response.data.message) {
        // Handle other specific error messages from the backend
        showMessage(error.response.data.message, 'error');
      } else {
        // Generic error for other HTTP error statuses
        showMessage(`Server Error: ${error.response.status}. Please try again.`, 'error');
      }
    } else if (error.request) {
      // The request was made but no response was received (e.g., network error, CORS issue)
      showMessage('Network Error: No response from server. Please check your connection.', 'error');
    } else {
      // Something happened in setting up the request that triggered an Error
      showMessage('An unexpected error occurred. Please try again.', 'error');
    }
  } finally {
    isLoading.value = false; // Always reset loading state
  }
};

// Dummy search user function (no actual API call here)
const searchUser = () => {
  // This function is present in the original template but not connected to any API logic.
  // If you need to fetch user data based on searchUsername, you would implement Axios here.
  // For now, it remains a placeholder.
  console.log('Search User clicked for:', form.value.searchUsername);
  showMessage(`Searching for user: ${form.value.searchUsername}`, 'info');
  // You might want to populate other form fields based on search results here
  // For example: form.value.username = form.value.searchUsername;
};

// Reset form fields to their initial state
const resetForm = () => {
  form.value = { ...initialForm };
};

// Close modal and reset form
const closeModal = () => {
  emit('update:modelValue', false);
  resetForm();
  showMessage('VIP Gift Dispatch cancelled.', 'info');
};
</script>

<style scoped>
/* Tailwind CSS classes are used directly in the template for most styling */

/* Custom styles for elements not covered by Tailwind or for specific overrides */
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
  width: 100%;
}

.modal-content {
  border-radius: 8px;
  overflow: hidden; /* Ensures rounded corners apply to children */
}

.modal-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
  padding: 1rem 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title {
  color: #343a40;
  font-weight: 700;
}

.btn-close {
  background: none;
  border: none;
  font-size: 1.5rem; /* Larger 'X' for better clickability */
  color: #6c757d;
  cursor: pointer;
  padding: 0;
  line-height: 1;
  opacity: 0.7;
  transition: opacity 0.2s;
}

.btn-close:hover {
  opacity: 1;
  color: #000;
}

.modal-body {
  padding: 1.5rem;
}

.form-label {
  font-size: 13px;
  font-weight: 500;
  color: #495057;
}

.form-control, .form-select {
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  padding: 0.375rem 0.75rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus, .form-select:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right 0.75rem center;
  background-size: 16px 12px;
}

.modal-footer {
  background-color: #f8f9fa;
  border-top: 1px solid #e9ecef;
  padding: 1rem 1.5rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.submit-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402; /* Yellow color */
  padding: 8px 25px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  color: white;
  transition: background-color 0.2s ease-in-out;
}

.submit-btn:hover {
  background: #a18923; /* Darker yellow on hover */
}

.submit-btn:disabled {
  background: #fed7aa; /* Lighter yellow when disabled */
  cursor: not-allowed;
  opacity: 0.7;
}

.cancel-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  border: 1px solid #6c757d; /* Gray border */
  border-radius: 5px;
  cursor: pointer;
  background-color: #f8f9fa;
  color: #343a40;
  transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
}

.cancel-btn:hover {
  background: #e2e6ea;
  border-color: #5a6268;
}

.cancel-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* Toaster message container styles */
#message-box-container {
  position: fixed;
  top: 1rem;
  right: 1rem;
  z-index: 1000; /* Ensure it's on top */
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

/* Styles for the red asterisk */
.text-red-500 {
  color: #ef4444;
}
</style>

```
