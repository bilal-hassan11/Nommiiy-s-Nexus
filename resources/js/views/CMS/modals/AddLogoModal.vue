<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Web Setting</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Merchant</label>
              <select v-model="form.merchant" class="form-select">
                <option value="All">All</option>
                <option>MJB</option>
                <option>MJB2</option>
                <option>MJB3</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Type</label>
              <select v-model="form.type" class="form-select">
                <option>Back Office</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Name</label>
              <select v-model="form.name" class="form-select">
                <option>Logo</option>
                <option>Favicon</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="All">All</option>
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <div class="d-flex align-items-center">
                <input type="file" @change="handleFileChange" class="form-control" style="max-width: 250px;"/>
                <img
                    v-if="previewUrl"
                    :src="previewUrl"
                    alt="Preview"
                    style="height: 40px; width: auto; margin-left: 10px;"
                />
              </div>
              <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Maximum file size: 1MB. Max Height: 80px<br/>Recommended website for file compress: tinypng.com
              </small>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" class="form-control" v-model="form.remark"/>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="submit" class="btn submit-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);
const selectedFile = ref(null);

const initialForm = {
  merchant: 'MJB',
  type: 'Back Office',
  name: 'Logo',
  status: 'Active',
  image: selectedFile,
  remark: ''
}

const form = ref({...initialForm});

const resetForm = () => {
  form.value = {...initialForm}
}


const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;
  }
};

const previewUrl = computed(() => {
  if (typeof window !== "undefined" && selectedFile.value) {
    return URL.createObjectURL(selectedFile.value);
  }
  return null;
});

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm();
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm();
}
</script>

<style scoped>
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
</style>