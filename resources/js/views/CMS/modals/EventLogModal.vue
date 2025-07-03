<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Event Log</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-12">
                <label class="form-label">Search</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Search"
                    v-model="searchTerm"
                />
              </div>
            </div>

            <div class="col-lg-12 d-flex justify-content-end gap-2 mt-3 mb-3 mt-lg-0">
              <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
              <button @click="search" class="search-btn btn btn-primary text-dark">Search</button>
            </div>

            <!-- Table -->
            <div class="table-wrapper mt-3">
              <table class="table table-striped table-hover mb-0">
                <thead class="table-light sticky-header">
                <tr>
                  <th style="width: 160px;">Created At</th>
                  <th>Send</th>
                  <th>Receive</th>
                </tr>
                </thead>
              </table>

              <div class="table-scroll">
                <table class="table table-striped table-hover mb-0">
                  <tbody>
                  <tr v-for="(log, index) in filteredLogs" :key="index">
                    <td class="text-nowrap" style="width: 160px;">{{ log.createdAt }}</td>
                    <td>
                      <pre class="mb-0 small text-break">{{ log.send }}</pre>
                    </td>
                    <td>
                      <pre class="mb-0 small text-break text-danger">{{ log.receive }}</pre>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
        <div class="col-lg-12 d-flex justify-content-center gap-2 mt-3 mb-3 mt-lg-0 p-2">
          <button @click="closeModal" class="clear-btn btn btn-outline-dark">Close</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, computed} from 'vue'

defineProps({
  modelValue: Boolean
})
const emit = defineEmits(['update:modelValue', 'submit'])
const searchTerm = ref('')

const logs = ref([
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "metapixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "metapixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
  {
    createdAt: '2025-06-04 21:42:03',
    send: `{ "platform": "tiktok pixel", "url": "https://graph.facebook.com/v18.0/...", "method": "POST", ... }`,
    receive: `{ "error": { "message": "Unsupported post request...", "code": 100, ... } }`,
  },
])

const filteredLogs = computed(() => {
  if (!searchTerm.value.trim()) return logs.value
  return logs.value.filter((log) =>
      log.createdAt.includes(searchTerm.value) ||
      log.send.includes(searchTerm.value) ||
      log.receive.includes(searchTerm.value)
  )
})
const search = () => {
  // Search is reactive via computed
}

const clearForm = () => {
  searchTerm.value = "";
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  clearForm()
}

const closeModal = () => {
  emit('update:modelValue', false)
  clearForm()
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
