<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Master Tracker</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label">Currency</label>
                <select v-model="form.currency" class="form-select">
                  <option value="All">All</option>
                  <option>BDT</option>
                  <option>NPR</option>
                </select>
              </div>
            </div>

            <!-- Table -->
            <div class="table-wrapper mt-3">
              <table class="table table-striped table-hover mb-0">
                <thead class="table-light sticky-header">
                <tr>
                  <th>Tracker</th>
                  <th>Tracker ID</th>
                  <th>Tracker Token</th>
                  <th>Click ID</th>
                </tr>
                </thead>
              </table>

              <div class="table-scroll">
                <table class="table table-striped table-hover mb-0">
                  <tbody>
                  <tr>
                    <td>Meta Pixel</td>
                    <td><input class="form-control" type="text" v-model="form.metaPixelTrackerId"></td>
                    <td><input class="form-control" type="text" v-model="form.metaPixelTrackerToken"></td>
                    <td><input class="form-control" type="text" v-model="form.metaPixelClickId"></td>
                  </tr>
                  <tr>
                    <td>Google Analytics</td>
                    <td><input class="form-control" type="text" v-model="form.googleAnalyticsTrackerId"></td>
                    <td><input class="form-control" type="text" v-model="form.googleAnalyticsTrackerToken"></td>
                    <td><input class="form-control" type="text" v-model="form.googleAnalyticsClickId"></td>
                  </tr>
                  <tr>
                    <td>Kwai Pixel</td>
                    <td><input class="form-control" type="text" v-model="form.kwaiPixelTrackerId"></td>
                    <td><input class="form-control" type="text" v-model="form.kwaiPixelTrackerToken"></td>
                    <td><input class="form-control" type="text" v-model="form.kwaiPixelClickId"></td>
                  </tr>
                  <tr>
                    <td>TikTok Pixel</td>
                    <td><input class="form-control" type="text" v-model="form.tiktokPixelTrackerId"></td>
                    <td><input class="form-control" type="text" v-model="form.tiktokPixelTrackerToken"></td>
                    <td><input class="form-control" type="text" v-model="form.tiktokPixelClickId"></td>
                  </tr>
                  <tr>
                    <td>Appsfiyer</td>
                    <td><input class="form-control" type="text" v-model="form.appsfiyerTrackerId"></td>
                    <td><input class="form-control" type="text" v-model="form.appsfiyerTrackerToken"></td>
                    <td><input class="form-control" type="text" v-model="form.appsfiyerClickId"></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
        <div class="col-lg-12 d-flex justify-content-center gap-2 mt-3 mb-3 mt-lg-0 p-2">
          <button @click="closeModal" class="clear-btn btn btn-outline-dark">Cancel</button>
          <button @click="submit" class="search-btn btn btn-primary text-dark">Save</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit'])

const form = ref({
  currency: 'BDT',
  metaPixelTrackerId: '',
  metaPixelTrackerToken: '',
  metaPixelClickId: '',
  googleAnalyticsTrackerId: '',
  googleAnalyticsTrackerToken: '',
  googleAnalyticsClickId: '',
  kwaiPixelTrackerId: '',
  kwaiPixelTrackerToken: '',
  kwaiPixelClickId: '',
  tiktokPixelTrackerId: '',
  tiktokPixelTrackerToken: '',
  tiktokPixelClickId: '',
  appsfiyerTrackerId: '',
  appsfiyerTrackerToken: '',
  appsfiyerClickId: '',
});

// Reset form and search field
const clearForm = () => {
  for (const key in form.value) {
    form.value[key] = '';
  }
  form.value.currency = "BDT";
}

const submit = () => {
  emit('submit', {...form.value});
  emit('update:modelValue', false);
  clearForm();
}

const closeModal = () => {
  emit('update:modelValue', false);
  clearForm();
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

pre {
  white-space: pre-wrap;
  word-break: break-word;
}

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
  cursor: pointer;
  user-select: none;
}

td {
  font-size: 12px;
  font-weight: 500;
  color: #2c2c2c;
}

tr:hover td {
  background: #fde2c1;
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

.table-wrapper {
  border: 1px solid #dee2e6;
  border-radius: 5px;
  overflow: hidden;
}

.table-scroll {
  max-height: 300px;
  overflow-y: auto;
}

.table-scroll table {
  table-layout: fixed;
  width: 100%;
}

.sticky-header {
  position: sticky;
  top: 0;
  z-index: 2;
}
</style>
