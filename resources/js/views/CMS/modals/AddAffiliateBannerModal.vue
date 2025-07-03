<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add Banner</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Merchant ID</label>
                <select v-model="form.merchantId" class="form-select">
                  <option>MJB</option>
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
                <label class="form-label">Title</label>
                <input v-model="form.title" type="text" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Description</label>
                <input v-model="form.description" type="text" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Language</label>
                <select v-model="form.language" class="form-select">
                  <option>EN-BD</option>
                </select>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Index</label>
                <input v-model="form.index" type="text" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Start Date</label>
                <input v-model="form.startDate" type="date" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">End Date</label>
                <input v-model="form.endDate" type="date" class="form-control"/>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Mobile Image</label>
                <input type="file" @change="onFileChange($event, 'mobileImage')" class="form-control"/>
                <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 4px 4px; color: #d87a00">
                  Mobile image size: 1920 x 600</small>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Web Image</label>
                <input type="file" @change="onFileChange($event, 'webImage')" class="form-control"/>
                <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Web image size: 1920 x 600</small>
              </div>
              <div class="mb-3 col-md-4">
                <label class="form-label">Href</label>
                <input v-model="form.href" type="text" class="form-control"/>
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

defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'submit'])

const form = ref({
  merchantId: 'MJB',
  href: "",
  status: 'Active',
  title: '',
  description: '',
  language: 'EN-BD',
  index: '',
  startDate: '',
  endDate: '',
  mobileImage: null,
  webImage: null
})

const setDefaultDates = () => {
  const today = new Date()
  const yyyy = today.getFullYear()
  const mm = String(today.getMonth() + 1).padStart(2, '0')
  const dd = String(today.getDate()).padStart(2, '0')

  // First day of current month
  form.value.startDate = `${yyyy}-${mm}-01`

  // Today's date
  form.value.endDate = `${yyyy}-${mm}-${dd}`
}

onMounted(() => {
  setDefaultDates()
})

const onFileChange = (event, key) => {
  const file = event.target.files[0]
  if (file) {
    form.value[key] = file
  }
}

const resetForm = () => {
  form.value = {
    merchantId: 'MJB',
    href: "",
    status: 'Active',
    title: '',
    description: '',
    language: 'EN-BD',
    index: '',
    startDate: '',
    endDate: '',
    mobileImage: null,
    webImage: null
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
</style>
