<template>
  <AddLogoModal v-model="showModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>Logo & Favicon</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Status</label>
        <select v-model="form.status" class="form-select">
          <option value="All">All</option>
          <option>Active</option>
          <option>Inactive</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Content Type</label>
        <select v-model="form.contentType" class="form-select">
          <option>Logo</option>
          <option>Favicon</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Type</label>
        <select v-model="form.type" class="form-select">
          <option>Back Office</option>
        </select>
      </div>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>

  <div class="form-container mt-4">
    <div class="col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
    </div>
    <div
        class="row p-2"
        style="cursor:pointer; font-size: 13px; font-weight: 600; margin: 10px 1px 10px 1px; background: #faf1e8"
        @click="toggleTable"
    >
      Logo List
    </div>

    <div v-if="showTable" class="table-responsive mt-3">
      <table class="table table-bordered table-sm align-middle text-center" style="font-size: 12px;">
        <thead class="table-light">
        <tr>
          <th class="text-start">Merchant Code</th>
          <th class="text-end">Content Type</th>
          <th class="text-center">Name</th>
          <th>Status</th>
          <th>Content Source</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in logoList" :key="index">
          <td class="text-start">{{ item.merchantCode }}</td>
          <td class="text-end">{{ item.contentType }}</td>
          <td class="text-center">{{ item.name }}</td>
          <td>
            <span class="badge bg-success">{{ item.status }}</span>
          </td>
          <td>
            <Eye size="14" style="cursor:pointer;"/>
          </td>
          <td>
            <Pencil size="14" style="cursor:pointer; margin-right: 18px"/>
            <Trash size="14" style="cursor:pointer;"/>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="form-container mt-4">
    <div
        class="row p-2"
        style="cursor:pointer; font-size: 13px; font-weight: 600; margin: 10px 1px 10px 1px; background: #faf1e8"
        @click="toggleFaviconUpload"
    >Favicon
    </div>

    <!-- Favicon Upload UI -->
    <div v-if="showFaviconUpload">
      <div class="row gx-3 gy-3 mt-2 align-items-center">
        <div class="col-md-6 col-lg-3">
          <label>Merchant</label>
        </div>
        <div class="col-md-6 col-lg-3">
          <select v-model="form.merchant" class="form-select">
            <option>MJB</option>
            <option>MJB2</option>
            <option>MJB3</option>
          </select>
        </div>
      </div>

      <div class="row gx-3 gy-3 mt-2 align-items-center">
        <div class="col-md-6 col-lg-3">
          <label>Favicon*</label>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="d-flex align-items-center">
            <input type="file" @change="handleFileChange" class="form-control" style="max-width: 250px;"/>
            <img
                v-if="previewUrl"
                :src="previewUrl"
                alt="Preview"
                style="height: 40px; width: auto; margin-left: 10px;"
            />
          </div>
          <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
            Maximum file size: 1MB.<br/>Recommended website for file compress: tinypng.com
          </small>
          <button class="btn btn-warning tag-btn text-dark">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import {computed, ref} from "vue";
import {CirclePlus, Trash, Pencil, Eye} from "lucide-vue-next";
import AddLogoModal from "@/views/CMS/modals/AddLogoModal.vue";

const showModal = ref(false)

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  merchant: "MJB",
  status: "All",
  contentType: "Logo",
  type: "Back Office",
});

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.status = "All";
  form.value.contentType = "Logo";
  form.value.type = "Back Office";
};

const showTable = ref(false);

const logoList = ref([
  {
    merchantCode: "MJB",
    contentType: "web",
    name: "logo",
    status: "Active",
    contentSource: "eye",
    actions: ["edit", "delete"],
  },
]);

const toggleTable = () => {
  showTable.value = !showTable.value;
};

const showFaviconUpload = ref(false);

const toggleFaviconUpload = () => {
  showFaviconUpload.value = !showFaviconUpload.value;
};

const selectedFile = ref(null);

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;
  }
};

const previewUrl = computed(() => {
  if (typeof window !== "undefined" && selectedFile.value) {
    return URL.createObjectURL(selectedFile.value);
  }
  return null;
});
</script>


<style scoped>
.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

input, select {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.tag-btn:hover {
  background: #d6b402;
}
</style>