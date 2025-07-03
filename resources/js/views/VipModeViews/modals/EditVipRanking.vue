<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <h2 class="form-title">Vip Mode</h2>
      <p class="breadcrumb">Vip Mode > <strong>Edit VIP Ranking</strong></p>
    </div>
  </div>
    <div class="form-container mb-3 pb-5">
      <div class="row gx-3 gy-3">
        <div class="col-md-6 col-lg-3">
          <label>Merchant*</label>
            <select v-model="form.merchant" class="form-select">
              <option :value="'MJB'">MJB</option>
            </select>
        </div>
        <div class="col-md-6 col-lg-3">
          <label>Currency</label>
          <select v-model="form.currency" class="form-select">
            <option :value="'BDT'">BDT</option>
            <option :value="'NPR'">NPR</option>
          </select>
        </div>
      </div>
    </div>

  <div class="form-container py-4">
    <form @submit.prevent="submit">
      <div class="mb-3 gap-3 d-flex justify-content-end" role="group">
        <button type="button"
                class="btn btn-batch-upload"
                @click="mode = 'single'">Batch Upload
        </button>

        <button type="button"
                class="btn btn-add"
                @click="mode = 'batch'">
          <CirclePlus class="me-2" size="16" stroke-width="2" />Add
        </button>

        <button type="button"
                class="btn btn-clear"
                @click="clearForm">Clear
        </button>
      </div>

      <!-- User Table -->
      <div class="mb-3 p-2">
        <table class="custom-table">
          <thead>
          <tr>
            <th>Username</th>
            <th>Original VIP Level</th>
            <th>Original VIP Points</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><input class="form-control" placeholder="Please Type User" /></td>
            <td>—</td>
            <td>—</td>
            <td>
              <button class="btn btn-sm btn-outline-danger">
                <Trash size="18"/>
              </button>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- VIP Level Adjustment -->
      <div class="row align-items-center mb-3 p-2">
        <div class="col-md-4">
          <label class="small fw-semibold text-muted">
            New VIP Level <span class="text-danger ms-1">(Manual adjust for upgrade level won’t provide bonus)</span>
          </label>
          <select class="form-select">
            <option value="">Select Level</option>
            <option value="vip1">VIP 1</option>
            <option value="vip2">VIP 2</option>
          </select>
        </div>
      </div>

      <!-- Summary Table -->
        <table class="custom-table">
          <thead>
          <tr>
            <th>Total Players</th>
            <th>New VIP Level</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>Total 0 Member(S) Above</td>
            <td>—</td>
          </tr>
          </tbody>
        </table>

      <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn cancel-btn me-2" @click="cancel">Cancel</button>
        <button type="submit" class="btn submit-btn" @click="handleFormSubmit">Save</button>
      </div>
    </form>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import {onMounted, ref} from "vue";
import {CirclePlus, Trash} from "lucide-vue-next";

const showModal = ref(false)
console.log(showModal, "SHOW MODAL")

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  merchant: "MJB",
  currency: "BDT",
});

const clearForm = () => {
  Object.keys(form.value).forEach((key) => {
    form.value[key] = Array.isArray(form.value[key]) ? [] : "";
  });
};

const getSystemGMT = () => {
  const timeZoneOffset = new Date().getTimezoneOffset();
  const offsetHours = -timeZoneOffset / 60;
  return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
};

onMounted(() => {
  form.value.timeZone = getSystemGMT();
});

const router = useRouter();

const mode = ref('single');

const submit = () => {
  const payload = {
    ...form.value,
    mode: mode.value
  };

  router.push({
    name: 'vip-level-point-record',
    state: {newVipRanking: payload}
  });
};

const cancel = () => {
  router.push({name: 'vip-level-point-record'});
};
</script>

<style scoped>
.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-header {
  padding-right: 10px;
  padding-left: 7px;
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select, textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
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

.btn-batch-upload {
  font-size: 13px;
  font-weight: 600;
  padding: 8px 22px;
  background-color: #f1c40f;
  color: black;
  border: 1px solid #f1c40f;
  border-radius: 4px;
}

.btn-batch-upload:hover {
  background-color: #d4ac0d;
  border-color: #d4ac0d;
  color: #fff;
}

.btn-add {
  font-size: 13px;
  font-weight: 600;
  padding: 8px 22px;
  background-color: #fff;
  color: #28a745;
  border: 1px solid #28a745;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn-add:hover {
  background-color: #28a745;
  color: white;
}

.btn-clear {
  font-size: 13px;
  font-weight: 600;
  padding: 8px 22px;
  background-color: #fff;
  color: #333;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-clear:hover {
  background-color: #333;
  color: white;
  border-color: #333;
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

.custom-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.custom-table th,
.custom-table td {
  padding: 10px 12px;
  border: 1px solid #f0e3a3;
  text-align: left;
}

.custom-table th {
  background-color: #fff8e1;
  font-weight: 600;
  color: #333;
}

.custom-table td {
  background-color: #fff;
  color: #333;
}

.custom-table input.form-control {
  font-size: 13px;
  padding: 5px 10px;
  border-radius: 4px;
  border: 1px solid #ccc;
}

.btn-outline-danger {
  font-size: 13px;
  padding: 4px 8px;
  border-radius: 4px;
}
</style>