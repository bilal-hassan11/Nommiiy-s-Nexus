<template>
    <MemberInfoModal v-model="showModal" @submit="handleFormSubmit" />

    <div class="container-fluid">
      <!-- Header -->
      <div class="row align-items-center form-header mb-3">
        <div class="col-lg-10 ">
          <h2 class="form-title">Member</h2>
          <p class="breadcrumb">Member > <strong>Member Info</strong></p>
        </div>
        <div class="col-lg-2 d-flex justify-content-end ">
          <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
                  @click="showModal = true">
            <CirclePlus class="me-2" size="16" stroke-width="2"/>
            Add
          </button>
        </div>
      </div>

      <!-- Form Container -->
      <div class="form-container">
        <div class="row gx-3 gy-3">
          <!-- Row 1 -->
          <div class="col-md-6 col-lg-3">
            <label>Merchant*</label>
            <select v-model="form.merchant" class="form-select">
              <option>MJB</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Player ID</label>
            <input class="form-control" type="text" v-model="form.playerID"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Username</label>
            <input class="form-control" type="text" v-model="form.username"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Bank Account Number</label>
            <input class="form-control" type="text" v-model="form.bankAccountNumber"/>
          </div>

          <!-- Row 2 -->
          <div class="col-md-6 col-lg-3">
            <label>Member Name</label>
            <input class="form-control" type="text" v-model="form.memberName"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Member Group</label>
            <select v-model="form.memberGroup" class="form-select">
              <option value="" disabled selected hidden>Please Select Member Group</option>
              <option>Group 1</option>
              <option>Group 2</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Contact Number</label>
            <input class="form-control" type="text" v-model="form.contactNumber"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Referral</label>
            <input class="form-control" type="text" v-model="form.referral"/>
          </div>

          <!-- Row 3 -->
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
          <div class="col-md-6 col-lg-3">
            <label>KYC Verified Status</label>
            <select v-model="form.kycStatus" class="form-select">
              <option>All</option>
              <option>Few</option>
              <option>Some</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Status</label>
            <select v-model="form.status" class="form-select">
              <option>All</option>
              <option>Active</option>
              <option>Inactive</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Register From</label>
            <input class="form-control" type="date" v-model="form.registerFrom"/>
          </div>

          <!-- Row 4 -->
          <div class="col-md-6 col-lg-3">
            <label>Register To</label>
            <input class="form-control" type="date" v-model="form.registerTo"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Affiliate Code</label>
            <input class="form-control" type="text" v-model="form.affiliateCode"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Affiliate Username</label>
            <input class="form-control" type="text" v-model="form.affiliateUsername"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Risk</label>
            <select v-model="form.risk" class="form-select">
              <option>All</option>
              <option>Multiple</option>
              <option>Crucial</option>
            </select>
          </div>

          <!-- Row 5 -->
          <div class="col-md-6 col-lg-3">
            <label>VIP Level</label>
            <Multiselect
              v-model="form.vipLevel"
              :options="VIPLevels"
              :multiple="true"
              :searchable="true"
              :close-on-select="false"
              :clear-on-select="false"
              :limit="2"
              placeholder="Pick VIP Levels"
            />
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Last Login Date From</label>
            <input class="form-control" type="date" v-model="form.lastLoginFrom"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Last Login Date To</label>
            <input class="form-control" type="date" v-model="form.lastLoginTo"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Time Zone</label>
            <select v-model="form.timeZone" class="form-select">
              <option>GMT+0700</option>
              <option>GMT+0500</option>
            </select>
          </div>

          <!-- Row 6 -->
          <div class="col-md-6 col-lg-3">
            <label>Referral Site (Social Media)</label>
            <select v-model="form.referralSite" class="form-select">
              <option>All</option>
              <option>Facebook</option>
              <option>Instagram</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Email</label>
            <input class="form-control" type="email" v-model="form.email"/>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Member Tag</label>
            <select v-model="form.memberTag" class="form-select">
              <option>Tag1</option>
              <option>Tag2</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-3">
            <label>Referral Link</label>
            <input class="form-control" type="text" v-model="form.referralLink"/>
          </div>
        </div>

        <!-- Button Group -->
          <div class="button-group">
        <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
        <button @click="search" class="btn search-btn">Search</button>
      </div>
      </div>
    </div>
  </template>

  <script setup>
  import "vue-multiselect/dist/vue-multiselect.css";
  import {onMounted, ref} from "vue";
  import {CirclePlus} from "lucide-vue-next";
  import Multiselect from "vue-multiselect";
  import MemberInfoModal from "./modals/MemberInfoModal.vue"

  const showModal = ref(false)
  console.log(showModal, "SHOW MODAL")

  const handleFormSubmit = (formData) => {
    console.log("Received Form Data:", formData)
    // Process submission (API call etc.)
  }

  const form = ref({
    merchant: "MJB",
    playerID: "",
    username: "",
    bankAccountNumber: "",
    memberName: "",
    memberGroup: "",
    contactNumber: "",
    referral: "",
    currency: [],
    kycStatus: "All",
    status: "All",
    registerFrom: "",
    registerTo: "",
    affiliateCode: "",
    affiliateUsername: "",
    risk: "All",
    vipLevel: "",
    lastLoginFrom: "",
    lastLoginTo: "",
    timeZone: "GMT+0500",
    referralSite: "All",
    email: "",
    memberTag: "",
    referralLink: "",
    lastDepositFrom: "",
    lastDepositTo: ""
  });

  const clearForm = () => {
    Object.keys(form.value).forEach((key) => {
      form.value[key] = Array.isArray(form.value[key]) ? [] : "";
    });
  };

  const currencies = ref(["BDT", "NPR"]);
  const VIPLevels = ref(["All", "Level 1", "Level 2", "Level 3"]);

  const search = () => {
    console.log("Searching with filters:", form.value);
  };

  const getSystemGMT = () => {
    const timeZoneOffset = new Date().getTimezoneOffset();
    const offsetHours = -timeZoneOffset / 60;
    return `GMT${offsetHours >= 0 ? "+" : ""}${offsetHours}00`;
  };

  onMounted(() => {
    form.value.timeZone = getSystemGMT();
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

  .button-group {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 20px;
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

  .add-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 8px 25px;
    cursor: pointer;
    align-items: center;
  }
  </style>

