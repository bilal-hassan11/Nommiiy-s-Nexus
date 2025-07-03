<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Blog Content</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Blog Type*</label>
                <select v-model="form.blogType" class="form-select" placeholder="Please Select Blog Type">
                  <option value="" disabled selected>Please Select Blog Type</option>
                  <option>Type1</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label>Content Type*</label>
                <select v-model="form.contentType" class="form-select" placeholder="Please Select">
                  <option value="" disabled>Please Select</option>
                  <option>Home</option>
                  <option>Slot</option>
                  <option>Card</option>
                  <option>Fish</option>
                  <option>Instant Win</option>
                  <option>Bango</option>
                  <option>Login</option>
                  <option>Signup</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Status</label>
                <select v-model="form.status" class="form-select">
                  <option>Active</option>
                  <option>Inactive</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Publish Date</label>
                <input v-model="form.startDate" type="date" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Author</label>
                <input v-model="form.author" type="text" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Index</label>
                <input v-model="form.index" type="text" class="form-control"/>
              </div>
              <div class="mb-3 col-md-11">
                <label class="form-label">URL Title</label>
                <input v-model="form.urlTitle" type="text" class="form-control"/>
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Example: blog title
                </p>
              </div>
              <div class="mb-3 col-md-11">
                <label class="form-label checkbox-label">Popular</label>
                <input v-model="form.popular" type="checkbox" class="form-control custom-checkbox"/>
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Please be reminded that this date input are GMT +8 standard.
                </p>
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
                  <input v-model="form.localizedContent[activeTab].title" type="text" class="form-control"/>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-11">
                  <label class="form-label">Description</label>
                  <input v-model="form.localizedContent[activeTab].description" type="text" class="form-control"/>
                  <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Maximum 300 characters
                  </p>
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-11">
                  <label class="form-label">Small Image Path</label>
                  <input
                      type="file"
                      @change="onLocalizedFileChange($event, activeTab, 'mobileImage')"
                      class="form-control"
                  />
                  <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Image Size: 500 x 300
                  </small>
                </div>
                <div class="mb-3 col-md-11">
                  <label class="form-label">Content Image</label>
                  <input
                      type="file"
                      @change="onLocalizedFileChange($event, activeTab, 'webImage')"
                      class="form-control"
                  />
                  <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                    Image Size: 500 x 300
                  </small>
                </div>
                <div class="mb-3 col-md-11">
                  <label class="form-label">Content</label>
                  <TipTapEditor v-model="form.localizedContent[activeTab].content"/>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import TipTapEditor from "@/components/editor/TipTapEditor.vue";

defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'submit'])

const tabs = ['en-bd', 'bn-bd', 'en-np', 'ne-np']
const activeTab = ref('en-bd')

const form = ref({
  blogType: "",
  contentType: "",
  status: 'Active',
  startDate: '',
  author: '',
  index: '',
  urlTitle: '',
  popular: false,
  localizedContent: {
    'en-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'bn-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'en-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
    'ne-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''}
  }
})

const onLocalizedFileChange = (event, tab, key) => {
  const file = event.target.files[0]
  if (file) {
    form.value.localizedContent[tab][key] = file
  }
}

const setDefaultDates = () => {
  const today = new Date()
  const yyyy = today.getFullYear()
  const mm = String(today.getMonth() + 1).padStart(2, '0')
  const dd = String(today.getDate()).padStart(2, '0')

  form.value.startDate = `${yyyy}-${mm}-01`

  form.value.endDate = `${yyyy}-${mm}-${dd}`
}

onMounted(() => {
  setDefaultDates()
})

const resetForm = () => {
  form.value = {
    blogType: "",
    contentType: "",
    status: 'Active',
    startDate: '',
    author: '',
    index: '',
    urlTitle: '',
    popular: false,
    localizedContent: {
      'en-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
      'bn-bd': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
      'en-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''},
      'ne-np': {title: '', description: '', mobileImage: null, webImage: null, content: ''}
    }
  }
  setDefaultDates()
}


const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm()
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm()
}
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
</style>
