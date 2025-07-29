<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Blog Content</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Blog Type*</label>
                <select
                    v-model="form.blogTypeId"
                    class="form-select"
                    :class="{'is-invalid': errors.blog_type_id}"
                    @change="clearError('blog_type_id')"
                >
                  <option value="" disabled selected>Please Select Blog Type</option>
                  <option v-for="type in blogTypes" :key="type.id" :value="type.id">
                    {{ type.blog_type }}
                  </option>
                </select>
                <span v-if="errors.blog_type_id" class="text-danger">{{ errors.blog_type_id.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label>Content Type*</label>
                <select
                    v-model="form.contentType"
                    class="form-select"
                    :class="{'is-invalid': errors.content_type}"
                    @change="clearError('content_type')"
                >
                  <option value="" disabled>Please Select</option>
                  <option value="Home">Home</option>
                  <option value="Slot">Slot</option>
                  <option value="Card">Card</option>
                  <option value="Fish">Fish</option>
                  <option value="Instant Win">Instant Win</option>
                  <option value="Bango">Bango</option>
                  <option value="Login">Login</option>
                  <option value="Signup">Signup</option>
                </select>
                <span v-if="errors.content_type" class="text-danger">{{ errors.content_type.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Status</label>
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
                <label class="form-label">Publish Date</label>
                <input
                    v-model="form.publishDate"
                    type="date"
                    class="form-control"
                    :class="{'is-invalid': errors.publish_date}"
                    @blur="clearError('publish_date')"
                />
                <span v-if="errors.publish_date" class="text-danger">{{ errors.publish_date.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Author</label>
                <input
                    v-model="form.author"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.author}"
                    @blur="clearError('author')"
                />
                <span v-if="errors.author" class="text-danger">{{ errors.author.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Index</label>
                <input
                    v-model="form.index"
                    type="number" class="form-control"
                    :class="{'is-invalid': errors.index}"
                    @blur="clearError('index')"
                />
                <span v-if="errors.index" class="text-danger">{{ errors.index.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-11">
                <label class="form-label">URL Title</label>
                <input
                    v-model="form.urlTitle"
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.url_title}"
                    @blur="clearError('url_title')"
                />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Example: blog title
                </p>
                <span v-if="errors.url_title" class="text-danger">{{ errors.url_title.join(', ') }}</span>
              </div>
              <div class="mb-3 col-md-11">
                <label class="form-label checkbox-label">Popular</label>
                <input
                    v-model="form.popular"
                    type="checkbox"
                    class="form-control custom-checkbox"
                    :class="{'is-invalid': errors.popular}"
                    @change="clearError('popular')"
                />
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Please be reminded that this date input are GMT +8 standard.
                </p>
                <span v-if="errors.popular" class="text-danger">{{ errors.popular.join(', ') }}</span>
              </div>
            </div>
            <div class="mb-3">
              <div class="tab-buttons d-flex gap-3">
                <a
                    v-for="tab in tabs"
                    :key="tab"
                    href="#"
                    @click.prevent="activeTab = tab"
                    :class="['tab-link', { 'active-tab': activeTab === tab }]"
                >
                  {{ tab }}
                </a>
              </div>
            </div>

            <div v-if="activeTab">
              <div class="row">
                <div class="mb-3 col-md-11">
                  <label class="form-label">Title</label>
                  <input
                      v-model="form.localizedContent[activeTab].title"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors[`localized_content.${activeTab}.title`]}"
                      @blur="clearError(`localized_content.${activeTab}.title`)"
                  />
                  <span v-if="errors[`localized_content.${activeTab}.title`]" class="text-danger">{{ errors[`localized_content.${activeTab}.title`].join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-11">
                  <label class="form-label">Description</label>
                  <input
                      v-model="form.localizedContent[activeTab].description"
                      type="text"
                      class="form-control"
                      :class="{'is-invalid': errors[`localized_content.${activeTab}.description`]}"
                      @blur="clearError(`localized_content.${activeTab}.description`)"
                  />
                  <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Maximum 300 characters
                  </p>
                  <span v-if="errors[`localized_content.${activeTab}.description`]" class="text-danger">{{ errors[`localized_content.${activeTab}.description`].join(', ') }}</span>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-11">
                  <label class="form-label">Small Image Path</label>
                  <input
                      type="file"
                      @change="onLocalizedFileChange($event, activeTab, 'mobileImage')"
                      class="form-control"
                      :class="{'is-invalid': errors[`localized_content.${activeTab}.mobile_image`]}"
                      accept="image/*"
                  />
                  <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Image Size: 500 x 300
                  </small>
                  <span v-if="errors[`localized_content.${activeTab}.mobile_image`]" class="text-danger">{{ errors[`localized_content.${activeTab}.mobile_image`].join(', ') }}</span>
                </div>
                <div class="mb-3 col-md-11">
                  <label class="form-label">Content Image</label>
                  <input
                      type="file"
                      @change="onLocalizedFileChange($event, activeTab, 'webImage')"
                      class="form-control"
                      :class="{'is-invalid': errors[`localized_content.${activeTab}.web_image`]}"
                      accept="image/*"
                  />
                  <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Image Size: 500 x 300
                  </small>
                  <span v-if="errors[`localized_content.${activeTab}.web_image`]" class="text-danger">{{ errors[`localized_content.${activeTab}.web_image`].join(', ') }}</span>
                </div>
                <div class="mb-3 col-md-11">
                  <label class="form-label">Content</label>
                  <TipTapEditor
                      v-model="form.localizedContent[activeTab].content"
                      :class="{'is-invalid': errors[`localized_content.${activeTab}.content`]}"
                      @blur="clearError(`localized_content.${activeTab}.content`)"
                  />
                  <span v-if="errors[`localized_content.${activeTab}.content`]" class="text-danger">{{ errors[`localized_content.${activeTab}.content`].join(', ') }}</span>
                </div>
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
import TipTapEditor from "@/components/editor/TipTapEditor.vue"; // Ensure this path is correct
import axios from 'axios'; // Import Axios
import toastr from 'toastr'; // Import Toastr

// Props and Emits
defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

// Tabs for localized content
const tabs = ['en-bd', 'bn-bd', 'en-np', 'ne-np'];
const activeTab = ref('en-bd');

// Blog types for the dropdown
const blogTypes = ref([]);

// Initial form state
const initialForm = {
  blogTypeId: "", // Changed from blogType to blogTypeId to align with backend foreign key
  contentType: "",
  status: 'Active',
  publishDate: '', // Renamed from startDate for clarity and backend alignment
  author: '',
  index: null, // Changed to null for number input
  urlTitle: '',
  popular: false,
  localizedContent: {
    'en-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'bn-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'en-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'ne-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''}
  }
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors from backend
const isLoading = ref(false); // Controls loading state of the submit button

// Handles file input changes for localized images
const onLocalizedFileChange = (event, tab, key) => {
  const file = event.target.files[0];
  if (file) {
    form.value.localizedContent[tab][key] = file;
    // Clear the specific error for this file input, adjusting for backend naming (e.g., mobile_image)
    const backendKey = key === 'mobileImage' ? 'mobile_image' : 'web_image';
    clearError(`localized_content.${tab}.${backendKey}`);
  } else {
    form.value.localizedContent[tab][key] = null;
  }
};

// Sets default publish date to current month's first day
const setDefaultDates = () => {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');

  form.value.publishDate = `${yyyy}-${mm}-${dd}`; // Set to today's date, or first day of month if that's preferred.
};

// Fetches blog types from the backend to populate the dropdown
const fetchBlogTypes = async () => {
  try {
    const response = await axios.get('/blog-types'); // Assuming you have a /api/blog-types endpoint
    blogTypes.value = response.data;
  } catch (error) {
    console.error('Error fetching blog types:', error);
    toastr.error('Failed to load blog types.');
  }
};

// Call fetchBlogTypes and setDefaultDates when the component is mounted
onMounted(() => {
  fetchBlogTypes();
  setDefaultDates();
});

// Resets the form to its initial state, clears errors, and re-sets default dates
const resetForm = () => {
  form.value = { ...initialForm };
  setDefaultDates();
  errors.value = {};
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

  // Append top-level form fields, matching backend expected names
  formData.append('blog_type_id', form.value.blogTypeId);
  formData.append('content_type', form.value.contentType);
  formData.append('status', form.value.status);
  formData.append('publish_date', form.value.publishDate);
  formData.append('author', form.value.author || ''); // Send empty string if null
  formData.append('index', form.value.index || ''); // Send empty string if null
  formData.append('url_title', form.value.urlTitle || ''); // Send empty string if null
  formData.append('popular', form.value.popular ? 1 : 0); // Convert boolean to 0 or 1 for backend

  // Append localized content fields, including files
  for (const lang in form.value.localizedContent) {
    const localizedData = form.value.localizedContent[lang];

    formData.append(`localized_content[${lang}][title]`, localizedData.title || '');
    formData.append(`localized_content[${lang}][description]`, localizedData.description || '');
    formData.append(`localized_content[${lang}][content]`, localizedData.content || '');

    // Append file objects, mapping frontend names (mobileImage, webImage) to backend (mobile_image, web_image)
    if (localizedData.mobileImage instanceof File) {
      formData.append(`localized_content[${lang}][mobile_image]`, localizedData.mobileImage);
    }
    if (localizedData.webImage instanceof File) {
      formData.append(`localized_content[${lang}][web_image]`, localizedData.webImage);
    }
  }

  try {
    const response = await axios.post('/blog-contents', formData, {
      headers: {
        'Content-Type': 'multipart/form-data', // Crucial for sending files
      },
    });
    toastr.success('Blog Content added successfully!');
    emit('submit', response.data); // Emit event to parent component with new data
    closeModal(); // Close the modal and reset form
  } catch (error) {
    if (error.response && error.response.status === 422) {
      // Laravel validation errors
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else {
      console.error('Error submitting form:', error);
      toastr.error('Failed to add blog content. Please try again.');
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

input[type="checkbox"] {
  transform: scale(0.85);
  margin-right: 6px;
}

.checkbox-label {
  font-size: 11px;
  font-weight: 500;
  color: #2c2c2c;
  display: flex;
  align-items: center;
  gap: 4px;
}

.checkbox-label {
  margin-bottom: 6px;
}

.custom-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.custom-checkbox:checked {
  background-color: #f1c40f;
  border-color: #f1c40f;
}

.custom-checkbox:checked::after {
  content: '✓';
  color: #fff !important;
  font-size: 11px;
  position: absolute;
  left: 2px;
  top: -1px;
}

.custom-checkbox:hover {
  border-color: #d4ac0d;
}

.tab-link {
  font-size: 12px;
  font-weight: 600;
  color: #6c757d;
  text-decoration: none;
  padding: 4px 6px;
  border-bottom: 2px solid transparent;
  transition: border-color 0.2s, color 0.2s;
}

.tab-link:hover {
  color: #000;
}

.active-tab {
  color: #000;
  border-bottom: 3px solid #f4c400;
}

/* Styles for displaying validation errors (added for missing cases from original template) */
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