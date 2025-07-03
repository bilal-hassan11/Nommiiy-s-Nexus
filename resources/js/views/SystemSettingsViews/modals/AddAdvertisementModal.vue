<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Advertisement</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <div class="modal-body">
          <div class="row gx-3 gy-3">
            <div class="col-md-4 col-lg-4">
              <label>Merchant</label>
              <select v-model="form.merchant" class="form-select">
                <option value="All">All</option>
                <option>MJB</option>
                <option>MJB2</option>
                <option>MJB3</option>
              </select>
            </div>
            <div class="col-md-4 col-lg-4">
              <label>Index</label>
              <input v-model="form.index" class="form-control"/>
            </div>
            <div class="col-md-4 col-lg-4">
              <label>Content Type*</label>
              <Multiselect
                  v-model="form.contentType"
                  :options="contentTypes"
                  :multiple="true"
                  :searchable="true"
                  :close-on-select="false"
                  :clear-on-select="false"
                  :limit="2"
              />
            </div>
            <div class="col-md-4 col-lg-4">
              <label class="form-label">Display</label>
              <select v-model="form.display" class="form-select">
                <option value="Home">Home</option>
              </select>
            </div>
            <div class="col-md-4 col-lg-4">
              <label>Start Date</label>
              <input type="date" v-model="form.startDate" class="form-control">
            </div>
            <div class="col-md-4 col-lg-4">
              <label>End Date</label>
              <input type="date" v-model="form.endDate" class="form-control">
            </div>
            <div class="col-md-4 col-lg-4">
              <label>Member List</label>
              <textarea v-model="form.memberList" class="form-control" placeholder="member1, member2, member3">
              </textarea>
            </div>
          </div>


          <ul class="nav nav-tabs mb-3 mt-2">
            <li class="nav-item" v-for="tab in tabs" :key="tab">
              <button class="nav-link" :class="{ active: activeTab === tab }" @click="activeTab = tab">{{
                  tab
                }}
              </button>
            </li>
          </ul>
          <div class="row gx-3 gy-3">

            <div class="col-md-4 col-lg-4">
              <label class="form-label">Title</label>
              <input v-model="form.contents[activeTab].title" type="text" class="form-control"/>
            </div>

            <div class="col-md-4 col-lg-4">
              <label class="form-label">Image</label>
              <input type="file" class="form-control border-warning" @change="handleFileUpload"/>
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Only allow JPG, JPEG, PNG, GIF, and maximum file size 1MB. 1920 x 600
              </p>
            </div>

            <div class="col-md-4 col-lg-4">
              <label class="form-label">Link</label>
              <input type="text" class="form-control" v-model="form.contents[activeTab].link"/>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Content</label>
              <TipTapEditor v-model="form.contents[activeTab].content"/>
            </div>
          </div>

          <div class="modal-footer border-top-0 d-flex justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="button" class="btn btn-warning submit-btn" @click="submit">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import TipTapEditor from "@/components/editor/TipTapEditor.vue";
import Multiselect from "vue-multiselect";

const emit = defineEmits(['update:modelValue', 'submit']);
defineProps({
  modelValue: Boolean
});

const today = new Date()
const currentDate = today.toISOString().split('T')[0]
const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0]

const contentTypes = ref(['Mobile', 'Web']);
const tabs = ['EN-BD', 'BN-BD', 'EN-NP', 'NE-NP'];
const activeTab = ref('EN-BD');

const form = ref({
  merchant: 'MJB',
  index: '',
  contentType: ['Mobile', 'Web'],
  display: 'Home',
  startDate: firstDayOfMonth,
  endDate: currentDate,
  memberList: '',

  contents: {
    'EN-BD': {title: '', content: '', image: '', link: ''},
    'BN-BD': {title: '', content: '', image: '', link: ''},
    'EN-NP': {title: '', content: '', image: '', link: ''},
    'NE-NP': {title: '', content: '', image: '', link: ''},
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

.cancel-btn {
  font-size: 13px;
  font-weight: 600;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  background: #e0e0e0;
}
</style>
