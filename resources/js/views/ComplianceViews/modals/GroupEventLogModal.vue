<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Event Log</h5>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </div>

        <div class="modal-body">
          <div class="row align-items-end">
            <div class="mb-3 col-lg-3">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select">
                <option value="All">All</option>
                <option>BDT</option>
                <option>NPR</option>
              </select>
            </div>
            <div class="mb-3 col-lg-3">
              <label class="form-label">Member Group</label>
              <select v-model="form.memberGroup" class="form-select">
                <option value="All">All</option>
                <option>Regular</option>
              </select>
            </div>

            <div class="mb-3 col-lg-6 d-flex justify-content-start gap-2">
              <button type="button" class="btn cancel-btn" @click="clearForm">Clear</button>
              <button type="button" class="btn search-btn" @click="searchModal">Search</button>
            </div>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th @click="sortTable('updatedAt')">
                  Updated At <span v-if="sortColumn === 'updatedAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('currency')">
                  Currency <span v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('memberGroup')">
                  Member Group <span v-if="sortColumn === 'memberGroup'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('provider')">
                  Provider <span v-if="sortColumn === 'provider'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('before')">
                  Before <span v-if="sortColumn === 'before'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('after')">
                  After <span v-if="sortColumn === 'after'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
                <th @click="sortTable('handleBy')">
                  Handle By <span v-if="sortColumn === 'handleBy'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span>
                </th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td colspan="7" class="text-center text-muted">No records found</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="button" class="btn cancel-btn" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue']);

const form = ref({
  currency: 'All',
  memberGroup: 'All'
});

const closeModal = () => {
  emit('update:modelValue', false);
};

const clearForm = () => {
  form.value.currency = 'All';
  form.value.memberGroup = 'All';
};

const searchModal = () => {
  console.log('Searching for:', form.value.memberGroup);
  // trigger API or emit search event here
};

const sortColumn = ref(null);
const sortOrder = ref('asc');

const sortTable = (column) => {
  if (sortColumn.value === column) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortColumn.value = column;
    sortOrder.value = 'asc';
  }
};
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
}

label {
  font-size: 13px;
  font-weight: 600;
}

input,
select {
  font-size: 14px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.search-btn {
  font-size: 13px;
  font-weight: 600;
  background: #d6b402;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  color: black;
}

.search-btn:hover {
  background: #a18923;
}

.cancel-btn {
  font-size: 13px;
  font-weight: 600;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  background: #e0e0e0;
}

.cancel-btn:hover {
  background: #bdbdbd;
}

.table {
  width: 100%;
  margin-top: 10px;
}

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #fff8f8;
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
</style>
