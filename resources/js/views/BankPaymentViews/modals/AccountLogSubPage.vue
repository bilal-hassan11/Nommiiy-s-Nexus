<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Bank/Payment</h2>
      <p class="breadcrumb">Bank/Payment > <strong>Third Party Payment Platform</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-warning add-btn d-flex align-items-center me-2"
              @click="this.$router.push('/third-party-payment-platform');">
        Back
      </button>
      <button class="btn tag-btn me-2 " disabled>Account Log</button>
    </div>
  </div>
  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Log Period From</label>
        <input type="date" v-model="form.startDate" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Log Period To</label>
        <input type="date" v-model="form.endDate" class="form-control">
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Third Party Platform</label>
        <select v-model="form.thirdPartyPlatform" class="form-select">
          <option value="All">All</option>
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <Multiselect
            v-model="form.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Pick currencies"
        />
      </div>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>

</template>


<script setup>
import {useRouter} from 'vue-router';
import {ref} from "vue";
import Multiselect from "vue-multiselect";


const currencies = ref(["BDT", "NPR"]);
const form = ref({
  startDate: "",
  endDate: "",
  currency: ["BDT", "NPR"],
  thirdPartyPlatform: "All",
});

const clearForm = () => {
  form.value.currency = ["BDT", "NPR"];
  form.value.thirdPartyPlatform = "All";
  form.value.startDate = "";
  form.value.endDate = "";
};

const router = useRouter();

const mode = ref('single');

const submit = () => {
  const payload = {
    ...form.value,
    mode: mode.value
  };

  router.push({
    name: 'third-party-payment-platform',
    state: {accountLog: payload}
  });
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #595959;
  font-weight: 500;
  font-size: 13px;
  color: white;
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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
</style>