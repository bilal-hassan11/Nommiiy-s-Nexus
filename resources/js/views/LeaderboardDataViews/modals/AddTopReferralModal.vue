<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add/Edit Data</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <!-- Top radio buttons -->
            <div class="mb-3">
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="realNameList"
                         value="real-name-list">
                  <label class="form-check-label" for="realNameList">Real Name List</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="generateBySystem"
                         value="generate-by-system">
                  <label class="form-check-label" for="generateBySystem">Generate By System</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="uploadDocument"
                         value="upload-document">
                  <label class="form-check-label" for="uploadDocument">Upload Document</label>
                </div>
              </div>
            </div>

            <!-- Section: Real Name List -->
            <div v-if="form.resultOptions === 'real-name-list'">
              <div class="alert-player-info mb-3">
                <strong>Note:</strong><br/>
                <small>Real Player list generate by system default, and the account is partially covered.</small>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">Activity Type</label>
                  <select v-model="form.activityType" class="form-select">
                    <option>LeaderBoard</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">Currency</label>
                  <select v-model="form.currency" class="form-select">
                    <option>BDT</option>
                    <option>NPR</option>
                  </select>
                </div>
              </div>

              <div class="table-responsive mb-4">
                <table class="table table-striped align-middle text-center">
                  <thead class="table-light">
                  <tr>
                    <th class="text-start px-3">Prize</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(row, index) in prizeRows" :key="index">
                    <td class="text-start px-3">
                      <div class="d-flex align-items-center gap-2">
                        <input type="number" class="form-control" v-model.number="row.prize" placeholder="686"/>
                        <X size="16" class="text-danger cursor-pointer" @click="removeRow(index)" title="Remove Row"
                           style="flex-shrink: 0;"/>
                      </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Section: Generate by System -->
            <div v-if="form.resultOptions === 'generate-by-system'">
              <div class="alert-player-info mb-3">
                <strong>Note:</strong><br/>
                <small>The system will randomly generate a player list, and the account is partially covered.</small>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">Activity Type</label>
                  <select v-model="form.activityType" class="form-select">
                    <option>LeaderBoard</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">Currency</label>
                  <select v-model="form.currency" class="form-select">
                    <option>BDT</option>
                    <option>NPR</option>
                  </select>
                </div>
              </div>

              <div class="table-responsive mb-4">
                <table class="table table-striped align-middle text-center">
                  <thead class="table-light">
                  <tr>
                    <th class="text-start px-3">Prize</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="(row, index) in prizeRows" :key="index">
                    <td class="text-start px-3">
                      <div class="d-flex align-items-center gap-2">
                        <input type="number" class="form-control" v-model.number="row.prize" placeholder="686"/>
                        <X size="16" class="text-danger cursor-pointer" @click="removeRow(index)" title="Remove Row"
                           style="flex-shrink: 0;"/>
                      </div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Section: Upload Document -->
            <div v-if="form.resultOptions === 'upload-document'">
              <div class="alert-player-info mb-3">
                <strong>Note:</strong><br/>
                <small>1. Upload File suffix must be .csv format</small>
                <br/>
                <small>2. The larger the file will lead to a longer time to upload, please be patient</small>
                <br/>
                <small>3. The system will randomly generate a player list</small>
                <br/>
                <small>4. Example > Prize : Percentage</small>
                <br/>
                <small>5. Download the sample file and edit</small>
                <br/>
                <small>6. Percentage total up must be 100%</small>
              </div>
              <div v-if="successMessage" class="alert alert-success py-2 px-3 mb-3"
                   style="font-size: 12px; font-weight: 500;">
                {{ successMessage }}
              </div>
              <div class="row gap-2 d-flex align-items-center mx-1">
                <button class="col-md-4 btn submit-btn" @click="downloadCSV">
                  Download File
                </button>

                <label class="col-md-4 btn submit-btn mb-0" style="cursor: pointer;">
                  Upload File
                  <input
                      ref="fileInput"
                      type="file"
                      accept=".csv"
                      @change="handleFileUpload"
                      style="display: none;"
                  />
                </label>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">Activity Type</label>
                  <select v-model="form.activityType" class="form-select">
                    <option>LeaderBoard</option>
                  </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">Currency</label>
                  <select v-model="form.currency" class="form-select">
                    <option>BDT</option>
                    <option>NPR</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {X} from "lucide-vue-next";
import {ref, computed} from "vue";

defineProps({modelValue: Boolean});

const emit = defineEmits(["update:modelValue", "submit"]);
const successMessage = ref("");
const form = ref({
  currency: "BDT",
  activityType: "LeaderBoard",
  resultOptions: "real-name-list",
  displayRow: "10",
  dateWithIn: "within",
  orderDate: "date",
  frequency: "frequency",
});

const prizeRows = ref([
  {prize: 1000, rate: 50},
  {prize: 500, rate: 30},
  {prize: 200, rate: 20}
]);

const removeRow = (index) => {
  if (prizeRows.value.length > 1) prizeRows.value.splice(index, 1);
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  if (!file || !file.name.endsWith('.csv')) {
    alert('Invalid file. Please upload a .csv file.');
    return;
  }

  const reader = new FileReader();
  reader.onload = (e) => {
    const lines = e.target.result.split('\n').map(line => line.trim()).filter(Boolean);

    const header = lines.shift();
    const cleanHeader = header.replace(/^\uFEFF/, '').trim().toLowerCase();

    if (cleanHeader !== 'prize,rate') {
      alert('Invalid CSV format. Expected header: Prize,Rate');
      return;
    }

    const parsedRows = lines.map(line => {
      const [prize, rate] = line.split(',').map(s => s.trim());
      return {
        prize: Number(prize),
        rate: Number(rate)
      };
    });

    const isValid = parsedRows.every(row => !isNaN(row.prize) && !isNaN(row.rate));
    if (!isValid) {
      alert('Invalid row data. Ensure all values are numeric.');
      return;
    }

    prizeRows.value = parsedRows;
    successMessage.value = "CSV uploaded successfully!";
    setTimeout(() => successMessage.value = "", 3000);
  };

  reader.readAsText(file);
};
const downloadCSV = () => {
  if (!prizeRows.value.length) {
    alert("No data to download.");
    return;
  }

  const csvContent = "Prize,Rate\n" + prizeRows.value
      .map(row => `${row.prize ?? ""},${row.rate ?? ""}`)
      .join("\n");

  const blob = new Blob([csvContent], {type: "text/csv;charset=utf-8;"});
  const url = URL.createObjectURL(blob);

  const link = document.createElement("a");
  link.setAttribute("href", url);
  link.setAttribute("download", "sample-prize-distribution.csv");
  link.style.display = "none";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
};

const submit = () => {
  const isUploadMode = form.value.resultOptions === 'upload-document';

  emit("submit", {
    ...form.value,
    prizes: prizeRows.value,
  });

  emit("update:modelValue", false);
  resetForm();
};

const resetForm = () => {
  form.value = {
    currency: "BDT",
    activityType: "LeaderBoard",
    resultOptions: "real-name-list",
    displayRow: "10",
    date: "date",
    orderByDescending: "descending",
  };
  prizeRows.value = [
    {prize: null, rate: null},
    {prize: null, rate: null},
    {prize: null, rate: null},
  ];
};

const closeModal = () => {
  emit("update:modelValue", false);
  resetForm();
};
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

.form-check-input:checked {
  background-color: #d6b402;
  border-color: #d6b402;
}

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


input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ccc;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  outline: none;
  transition: 0.3s;
}

input[type="radio"]:checked {
  border-color: #ffcc00;
  background-color: #ffcc00;
}

input[type="radio"]:checked::before {
  content: "";
  width: 4px;
  height: 4px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.alert-player-info {
  background-color: #fff8dc;
  border: 1px solid #ffe58f;
  color: black;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 12px;
  font-weight: 500;
}

.table-responsive {
  overflow-x: auto;
  width: 100%;
}
</style>