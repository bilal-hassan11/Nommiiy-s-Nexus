<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New System Notification (Group)</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <div class="modal-body">
          <ul class="nav nav-tabs mb-3 mt-2">
            <li class="nav-item" v-for="tab in tabs" :key="tab">
              <button class="nav-link" :class="{ active: activeTab === tab }" @click="activeTab = tab">{{
                  tab
                }}
              </button>
            </li>
          </ul>
          <div class="row gx-3 gy-3">

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Title</label>
              <input v-model="form.contents[activeTab].title" type="text" class="form-control"/>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Content</label>
              <TipTapEditor v-model="form.contents[activeTab].content"/>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Image</label>
              <input type="file" class="form-control border-warning" @change="handleFileUpload"/>
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Recommended size: 560 x 450
              </p>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Status</label>
              <select type="file" v-model="form.contents[activeTab].status" class="form-select">
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Display Date</label>
              <input type="date" class="form-control" v-model="form.contents[activeTab].displayDate"/>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Group</label>
              <div class="d-flex flex-wrap gap-4">
                <div v-for="group in groupOptions" :key="group" class="d-flex align-items-start">
                  <input
                      class="custom-checkbox border-warning"
                      type="checkbox"
                      :id="group"
                      :value="group"
                      v-model="form.group"
                  />
                  <label class="checkbox-label ms-1" :for="group">{{ group }}</label>
                </div>
              </div>
            </div>

            <div class="col-md-12 col-lg-12">
              <label for="pushNotification" class="form-check-label checkbox-label">Push Notification</label>
              <input type="checkbox" v-model="form.pushNotification" class="custom-checkbox border-warning"
                     id="pushNotification" style="margin-left: 3px"/>
            </div>
          </div>

          <div class="modal-footer border-top-0 d-flex justify-content-center">
            <button type="button" class="btn btn-warning submit-btn" @click="submit">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import TipTapEditor from "@/components/editor/TipTapEditor.vue";

const emit = defineEmits(['update:modelValue', 'submit'])
defineProps({
  modelValue: Boolean
});

const groupOptions = ['Regular', 'Regular 2', 'Risk', 'PLATINUM', 'DIAMOND', 'PAYMENT GATEWAY TEST']
const tabs = ['EN-BD', 'BN-BD', 'EN-NP', 'NE-NP']
const activeTab = ref('EN-BD')

const form = ref({
  pushNotification: false,
  group: [],
  contents: {
    'EN-BD': {title: '', content: '', image: '', status: 'Active', displayDate: ''},
    'BN-BD': {title: '', content: '', image: '', status: 'Active', displayDate: ''},
    'EN-NP': {title: '', content: '', image: '', status: 'Active', displayDate: ''},
    'NE-NP': {title: '', content: '', image: '', status: 'Active', displayDate: ''},
  }
});

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.value.contents[activeTab.value].image = file
  }
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
}

const closeModal = () => {
  emit('update:modelValue', false)
}
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input,
select,
textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.nav-tabs {
  border-bottom: none !important;
}

.nav-link {
  border: none !important;
  color: #000;
  background-color: transparent;
  font-size: 15px;
}

.nav-link.active {
  border-bottom: 3px solid #f3c400 !important;
  font-weight: 600;
  font-size: 15px;
  color: #000 !important;
  cursor: default;
}

textarea {
  resize: vertical;
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


input[type="file"] {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 4px;
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

</style>
