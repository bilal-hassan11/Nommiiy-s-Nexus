<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Last Bulk Wallet Transfer</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
          <div class="modal-body">
            <div class="mb-3 row col-lg-12 col-md-12 col-sm-12">
              <div class="table-responsive mt-3">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th @click="sortTable('id')">ID <span
                        v-if="sortColumn === 'id'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('username')">Username <span
                        v-if="sortColumn === 'username'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('currency')">Currency <span
                        v-if="sortColumn === 'currency'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('adjustIn')">Adjust In <span
                        v-if="sortColumn === 'adjustIn'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('adjustOut')">Adjust Out <span
                        v-if="sortColumn === 'adjustOut'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('remark')">Remark <span
                        v-if="sortColumn === 'remark'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('transactionType')">Transaction Type <span
                        v-if="sortColumn === 'transactionType'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('multiplier')">Multiplier <span
                        v-if="sortColumn === 'multiplier'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                    <th @click="sortTable('createdAt')">Created At <span
                        v-if="sortColumn === 'createdAt'">{{ sortOrder === 'asc' ? '↑' : '↓' }}</span></th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
          </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue']);

const closeModal = () => {
  emit('update:modelValue', false)
}

const sortColumn = ref(null);
const sortOrder = ref("asc");
const sortTable = (column) => {
  if (sortColumn.value === column) {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
  } else {
    sortColumn.value = column;
    sortOrder.value = "asc";
  }
};
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