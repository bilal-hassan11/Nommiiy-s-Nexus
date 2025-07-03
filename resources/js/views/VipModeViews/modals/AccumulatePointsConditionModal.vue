<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center justify-content-start">
          <h5 class="modal-title me-3">Point Conditions Setting</h5>
          <label class="switch">
            <input type="checkbox" v-model="pointsEnabled">
            <span class="slider"></span>
          </label>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </div>

        <div class="modal-body">
          <!-- Global Toggle -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <p style="font-size: 10px; font-weight: 500; color: #d87a00">
              Turn the Points mode to OFF for not calculating.
            </p>
          </div>

          <!-- Top Form Controls -->
          <div class="row g-3 mb-3 d-flex align-items-end">
            <div class="col-md-4">
              <label>Valid Bet</label>
              <input type="text" v-model="globalForm.validBet" class="form-control" placeholder="Valid Bet">
            </div>
            <div class="col-md-3">
              <label>Points</label>
              <input type="text" v-model="globalForm.points" class="form-control" placeholder="Points">
            </div>
            <div class="col-md-3">
              <label>Game to Exclude</label>
              <input type="text" v-model="globalForm.exclude" class="form-control" placeholder="Game To Exclude">
            </div>
            <div class="col-md-2 d-flex justify-content-end">
              <button class="btn btn-warning w-75" style="background: #d6b402;"
                      @click="applyToAll">Apply to All
              </button>
            </div>
          </div>

          <!-- Data Table -->
          <div class="table-responsive">
            <table class="table table-striped mb-0">
              <thead>
              <tr>
                <th>Status</th>
                <th>Provider</th>
                <th>Game Group</th>
                <th>Valid Bet (BDT)</th>
                <th>Points</th>
                <th>Game To Exclude</th>
              </tr>
              </thead>
            </table>

            <div class="table-scroll-wrapper">
              <table class="table table-striped table-bordered">
                <tbody>
                <tr v-for="(row, index) in pointRows" :key="index">
                  <td>
                    <label class="switch">
                      <input type="checkbox" v-model="row.status">
                      <span class="slider"></span>
                    </label>
                  </td>
                  <td>{{ row.provider }}</td>
                  <td>{{ row.gameGroup }}</td>
                  <td>
                    <input type="text" class="form-control form-control-sm" v-model="row.validBet"/>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm" v-model="row.points"/>
                  </td>
                  <td class="align-middle text-center">
                    <button class="btn btn-light border p-1
               d-flex align-items-center justify-content-center mx-auto shadow-sm"
                            title="Edit">
                      <Pencil size="16" color="grey"/>
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import {Pencil} from 'lucide-vue-next';

defineProps({modelValue: Boolean});
const emit = defineEmits(['update:modelValue']);

const closeModal = () => emit('update:modelValue', false);

const pointsEnabled = ref(true);

const globalForm = ref({
  validBet: '',
  points: '',
  exclude: ''
});

const pointRows = ref([
  {status: true, provider: '3SING', gameGroup: 'SPORT', validBet: '1.00', points: '1.00'},
  {status: false, provider: '9WICKETS', gameGroup: 'CRICKET', validBet: '0.00', points: '0.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  {status: true, provider: 'AE-ESPORT', gameGroup: 'ESPORT', validBet: '1.00', points: '1.00'},
  // Add more as needed...
]);

const applyToAll = () => {
  pointRows.value.forEach(row => {
    if (globalForm.value.validBet) row.validBet = globalForm.value.validBet;
    if (globalForm.value.points) row.points = globalForm.value.points;
  });
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

.modal-title {
  font-size: 18px;
}

.table th, .table td {
  vertical-align: middle;
  font-size: 13px;
}

.btn-warning {
  font-size: 12px;
  font-weight: 600;
}

input.form-control-sm {
  font-size: 13px;
  padding: 4px;
}

.switch {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 20px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 20px;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 14px;
  width: 14px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked + .slider {
  background-color: #ffcc00;
}

input:checked + .slider:before {
  transform: translateX(24px);
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

button[title="Edit"]:hover {
  background-color: #fff3e0;
  border-color: #ffcc00;
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

.table-scroll-wrapper {
  max-height: 300px;
  overflow-y: auto;
  overflow-x: hidden;
}

.table-scroll-wrapper table {
  margin: 0;
}
</style>
