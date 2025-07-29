<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>Global SEO Settings</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearFormAndReloadDefaults" class="clear-btn btn btn-outline-dark" :disabled="isSearching || isSaving">Reset to Defaults</button>
      <button @click="fetchGlobalSeoSettings" class="search-btn btn btn-primary text-dark" :disabled="isSearching || isSaving">
        <span v-if="isSearching" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
        {{ isSearching ? 'Loading...' : 'Load Global Settings' }}
      </button>
    </div>
  </div>

  <div class="form-container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <label class="form-label mb-0">Global SEO Header</label>
      <span v-if="isSaving" class="text-muted small">
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        Autosaving...
      </span>
    </div>
    <textarea
        class="form-control seo-textarea mb-3"
        rows="3"
        v-model="form.seoHeader"
        :class="{'is-invalid': errors.seo_header}"
        @input="clearError('seo_header')"
    ></textarea>
    <span v-if="errors.seo_header" class="text-danger">{{ errors.seo_header.join(', ') }}</span>
  </div>

  <div class="form-container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <label class="form-label mb-0">Global SEO HomePage</label>
      <span v-if="isSaving" class="text-muted small">
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        Autosaving...
      </span>
    </div>
    <textarea
        class="form-control seo-textarea mb-3"
        rows="3"
        v-model="form.seoHomePage"
        :class="{'is-invalid': errors.seo_homepage}"
        @input="clearError('seo_homepage')"
    ></textarea>
    <span v-if="errors.seo_homepage" class="text-danger">{{ errors.seo_homepage.join(', ') }}</span>
  </div>
</template>

<script setup>
import {ref, onMounted, watch} from "vue";
import axios from 'axios';
import toastr from 'toastr';

// Form state - NO LANGUAGE OR MERCHANT HERE
const form = ref({
  seoHeader: "",
  seoHomePage: "",
});

const errors = ref({});
const isSearching = ref(false);
const isSaving = ref(false);
let saveTimer = null; // To hold our debounce timer

// Configure Axios base URL (ensure this matches your .env)
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Default texts (used if no data has ever been saved in DB)
const defaultSeoHeader = "Default Global Header: Experience the premier online platform, offering top-tier services.";
const defaultSeoHomePage = "Default Global Homepage: Explore the thrilling world of online, featuring a wide selection of games and exclusive bonuses.";


// Clears specific error messages
const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = [];
  }
};

// Resets form to default texts and triggers a save (optional, can be just visual reset)
const clearFormAndReloadDefaults = () => {
  form.value.seoHeader = defaultSeoHeader;
  form.value.seoHomePage = defaultSeoHomePage;
  errors.value = {}; // Clear any displayed errors
  // Optionally, trigger an autosave here if you want defaults to be saved instantly
  // saveSeoScripts();
  toastr.info('Form fields reset to default values.');
};


// Fetches the single global SEO settings record
const fetchGlobalSeoSettings = async () => {
  isSearching.value = true;
  errors.value = {}; // Clear errors before search

  // Clear any pending autosave when loading new content
  if (saveTimer) {
    clearTimeout(saveTimer);
    saveTimer = null;
  }
  isSaving.value = false; // Reset saving state

  try {
    // No params needed as it's a single global record
    const response = await axios.get('/global-seo-settings');

    if (response.data) {
      form.value.seoHeader = response.data.seo_header !== null ? response.data.seo_header : defaultSeoHeader;
      form.value.seoHomePage = response.data.seo_homepage !== null ? response.data.seo_homepage : defaultSeoHomePage;
      toastr.success('Global SEO settings loaded successfully!');
    } else {
      // This case should ideally not happen with firstOrCreate on backend
      form.value.seoHeader = defaultSeoHeader;
      form.value.seoHomePage = defaultSeoHomePage;
      toastr.info('No custom global SEO settings found, using default values.');
    }
  } catch (error) {
    console.error('Error fetching global SEO settings:', error);
    toastr.error('Failed to load global SEO settings. Please try again.');
    form.value.seoHeader = defaultSeoHeader;
    form.value.seoHomePage = defaultSeoHomePage;
  } finally {
    isSearching.value = false;
  }
};

// Saves BOTH SEO Header and SEO HomePage (Autosave triggered by watchers)
const saveSeoScripts = async () => {
  if (isSaving.value || isSearching.value) {
    return; // Prevent multiple saves or saving while loading
  }

  isSaving.value = true;
  errors.value = {}; // Clear errors before saving

  const payload = {
    seo_header: form.value.seoHeader,     // Send both fields
    seo_homepage: form.value.seoHomePage, // Send both fields
  };

  try {
    const response = await axios.post('/global-seo-settings', payload);
    toastr.success('Global SEO settings autosaved!');
    // Update form with returned data (useful if backend performs sanitation/reformatting)
    form.value.seoHeader = response.data.seo_header;
    form.value.seoHomePage = response.data.seo_homepage;

  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
      toastr.error('Autosave failed: Please correct the highlighted errors.');
    } else {
      console.error('Error saving global SEO settings:', error);
      toastr.error('Autosave failed. Please try again.');
    }
  } finally {
    isSaving.value = false;
  }
};

// Watchers for autosave on header and homepage textareas
watch(
  () => form.value.seoHeader,
  (newVal, oldVal) => {
    if (newVal !== oldVal) { // Only trigger if value actually changed
      if (saveTimer) clearTimeout(saveTimer);
      saveTimer = setTimeout(() => {
        saveSeoScripts();
      }, 500); // Debounce for 500ms
    }
  }
);

watch(
  () => form.value.seoHomePage,
  (newVal, oldVal) => {
    if (newVal !== oldVal) { // Only trigger if value actually changed
      if (saveTimer) clearTimeout(saveTimer);
      saveTimer = setTimeout(() => {
        saveSeoScripts();
      }, 500); // Debounce for 500ms
    }
  }
);

// Initial load when the component mounts
onMounted(() => {
  fetchGlobalSeoSettings();
});
</script>

<style scoped>
.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

input, select {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
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

.seo-textarea {
  background-color: #e9e9e9;
  border: none;
  font-weight: 500;
  font-size: 13px;
  color: #202020;
  resize: none;
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