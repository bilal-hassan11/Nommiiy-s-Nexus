<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Holiday List</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3 row col-lg-12 col-md-12 col-sm-12 d-flex justify-content-start">
            <div class="col-lg-2">
              <label class="form-label">Name of Holiday</label>
            </div>

            <div class="col-lg-4">
              <input type="text" v-model="form.holidayName" class="form-control"/>
            </div>

            <div class="col-lg-1">
              <label class="form-label">Year</label>
            </div>

            <div class="col-lg-2">
              <select v-model="form.year" class="form-control">
                <option v-for="year in yearOptions" :key="year" :value="year">{{ year }}</option>
              </select>
            </div>

            <div class="col-lg-3 d-flex flex-column justify-content-end align-items-end">
              <button class="btn submit-btn mb-4">Search</button>
              <button class="btn btn-outline-success add-btn d-flex align-items-center"
                      @click="handleAddClick">
                <CirclePlus class="me-2" size="16" stroke-width="2"/>
                Add
              </button>
            </div>
          </div>
          <div v-if="showTable" class="mb-3 row col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive mt-3">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Name of Holiday(EN)</th>
                  <th>Name of Holiday(BN)</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, index) in holidayRows" :key="index">
                  <td><input v-model="row.nameEn" type="text"/></td>
                  <td><input v-model="row.nameBn" type="text"/></td>
                  <td><input v-model="row.date" type="date"/></td>
                  <td></td>
                  <td>
                    <button class="btn btn-outline-secondary" style="padding: 4px 4px" @click="deleteRow(index)">
                      <Trash size="18"/>
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex align-items-center justify-content-center">
          <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
          <button
              v-if="isFormTouched"
              type="button"
              class="btn submit-btn me-2"
              @click="saveChanges"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, watch} from "vue";
import {CirclePlus, Trash} from "lucide-vue-next";

defineProps({modelValue: Boolean});
const emit = defineEmits(["update:modelValue"]);

const showTable = ref(false);
const today = new Date().toISOString().split("T")[0];
const holidayRows = ref([]);

const form = ref({holidayName: "", year: "2025"});
const currentYear = new Date().getFullYear();
const yearOptions = Array.from({length: 11}, (_, i) => currentYear - 5 + i);

const isFormTouched = ref(false);

const handleAddClick = () => {
  showTable.value = true;
  holidayRows.value.push({nameEn: "", nameBn: "", date: today});
};

const deleteRow = (index) => {
  holidayRows.value.splice(index, 1);
  if (holidayRows.value.length === 0) {
    showTable.value = false;
  }
};

const resetForm = () => {
  form.value = {holidayName: "", year: "2025"};
  holidayRows.value = [{nameEn: "", nameBn: "", date: today}];
  showTable.value = false;
  isFormTouched.value = false;
};

const closeModal = () => {
  emit("update:modelValue", false);
  resetForm();
};

const saveChanges = () => {
  const dataToSave = holidayRows.value.map(row => ({
    nameEn: row.nameEn,
    nameBn: row.nameBn,
    date: row.date
  }));

  console.log('Saved:', dataToSave);
  isFormTouched.value = false;
};

watch(holidayRows, () => {
  isFormTouched.value = true;
}, {deep: true});

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

.submit-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 8px 30px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.submit-btn:hover {
  background: #a18923;
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>