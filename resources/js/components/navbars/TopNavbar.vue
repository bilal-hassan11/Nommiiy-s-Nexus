<script setup>
import {
  Network,
  UserCircle,
  UsersRound,
  Wallet,
  SkipBack,
  ChevronDown,
  CircleDollarSign,
  CircleHelp,
  AlignJustify
} from "lucide-vue-next";
import {onMounted, ref} from "vue";

const userName = ref("Vans123");
const userFlag = ref("");
const formattedDate = ref("");
const formattedTime = ref("");
const isSidebarOpen = ref(false);

defineProps({
  isMobile: Boolean
});

const getUserCountry = async () => {
  try {
    const response = await fetch("https://ipwho.is/");
    if (!response.ok) throw new Error("Failed to fetch country data");

    const data = await response.json();
    if (!data.success) throw new Error("API error");
    console.log(data)
    userFlag.value = `https://flagcdn.com/16x12/${data.country_code.toLowerCase()}.png`;
  } catch (error) {
    console.error("Error fetching country:", error);
    userFlag.value = "https://flagcdn.com/w20/gb.png";
  }
};

const updateDateTime = () => {
  const now = new Date();
  formattedDate.value = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, "0")}-${String(now.getDate()).padStart(2, "0")}`;
  formattedTime.value = `${String(now.getHours()).padStart(2, "0")}:${String(now.getMinutes()).padStart(2, "0")} ${now.getTimezoneOffset() > 0 ? "-" : "+"}${String(Math.abs(now.getTimezoneOffset() / 60)).padStart(2, "0")}00`;
};

onMounted(() => {
  getUserCountry();
  updateDateTime();
  setInterval(updateDateTime, 1000);
});

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

</script>

<template>
  <div class="nav-left">
    <img src="../../assets/logo.svg" alt="Logo" class="logo" />
  </div>

  <div class="nav-right">
    <button class="menu-toggle btn btn-outline-light d-flex align-items-center" v-if="isMobile" @click="$emit('toggle-sidebar')">
      <AlignJustify stroke-width="2" size="18"/>
    </button>
    <SkipBack size="18" stroke-width="2" class="version-icon" id="version-icon"></SkipBack>
    <span class="version-switch" id="version-text">Switch to new version</span>

    <!-- Merchant Credit Dropdown -->
    <div class="dropdown" id="merchant-wallet">
      <button class="nav-btn" style="white-space: nowrap;">
        <Wallet size="18" stroke-width="2"/>
        Merchant Credit
        <ChevronDown size="12" stroke-width="2"/>
      </button>

      <div class="dropdown-menu" style="border-color: #ffcc00">
        <div class="merchant-title">Credit Balance</div>

        <div class="merchant-item">
          <CircleDollarSign size="12" stroke-width="2"/>
          <span class="currency">BDT</span>
          <span class="amount">761,270.67</span>
        </div>

        <div class="merchant-item">
          <CircleDollarSign size="12" stroke-width="2"/>
          <span class="currency">NPR</span>
          <span class="amount">Unlimited</span>
        </div>
      </div>
    </div>

    <!-- Member Dropdown -->
    <div class="dropdown" id="member">
      <button class="nav-btn">
        <UsersRound size="18" stroke-width="3"/>
        Member
        <span class="badge">739</span>
        <ChevronDown size="12" stroke-width="2"/>
      </button>

      <div class="dropdown-menu">
        <div class="dropdown-item">
          New Member <span class="notif-badge">737</span>
        </div>
        <div class="dropdown-item">Pending Deposit</div>
        <div class="dropdown-item">In Progress Deposit</div>
        <div class="dropdown-item">Pending Withdraw</div>
        <div class="dropdown-item">
          In Progress Withdraw <span class="notif-dot">1</span>
        </div>
        <div class="dropdown-item">
          New ID Verification <span class="notif-dot">1</span>
        </div>
        <div class="dropdown-item">Promotion</div>

        <!-- Sound Notification Toggle -->
        <div class="sound-toggle">
          <div class="row align-items-center">
            <!-- Left Side: Toggle Switch -->
            <div class="col-4">
              <label class="switch">
                <input type="checkbox"/>
                <span class="slider"></span>
              </label>
            </div>

            <!-- Right Side: Sound Notification & Options -->
            <div class="col-8">
              <div class="d-flex align-items-center justify-content-between">
                <span class="sound-options text-secondary">Sound Notification</span>
                <CircleHelp size="10" stroke-width="1"/>
              </div>

              <!-- Sound Options -->
              <div>
                <label class="sound-options"><input type="radio" name="sound" checked/> Default</label>
              </div>
              <div>
                <label class="sound-options"><input type="radio" name="sound"/> Human Voice</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Affiliate Dropdown -->
    <div class="dropdown" id="affiliate-dropdown">
      <button class="nav-text btn btn-outline-light d-flex align-items-center gap-2">
        <Network size="18" stroke-width="2"/>
        Affiliate
        <ChevronDown size="12" stroke-width="3"/>
      </button>
      <div class="dropdown-menu">
        <div class="dropdown-item">Affiliate Programs</div>
        <div class="dropdown-item">Referral Earnings</div>
      </div>
    </div>

    <!-- User Profile Section -->
    <div class="user-profile">
      <UserCircle size="24" stroke-width="2" class="user-icon"/>
      <span>{{ userName }}</span>
      <img :src="userFlag" alt="Country Flag" class="country-flag"/>
      <div class="datetime-container align-items-start" id="date">
        <span class="date">{{ formattedDate }}</span>
        <span class="time">{{ formattedTime }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>

.nav-left {
  display: flex;
  align-items: center;
}

.logo {
  width: 50px;
  height: 35px;
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.nav-btn {
  background: #ffcc00;
  border: none;
  padding: 6px 15px;
  cursor: pointer;
  border-radius: 5px;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 5px;
  position: relative;
}

.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  background: white;
  border-radius: 5px;
  display: none;
  min-width: 140px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown-item {
  padding: 8px 10px;
  cursor: pointer;
}

.dropdown-item:hover {
  background: #eee;
}

.badge {
  background: red;
  color: white;
  padding: 3px 8px;
  border-radius: 50%;
  font-size: 11px;
  margin-left: 5px;
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-icon {
  width: 30px;
  border-radius: 50%;
  color: #ffcc00;
}

.country-flag {
  width: 35px;
  height: 30px;
  border-radius: 50%;
}

.datetime-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.date {
  font-size: 13px;
}

.time {
  font-size: 13px;
}

.version-switch {
  font-size: 14px;
  font-weight: 550;
  color: white;
}

.version-icon {
  cursor: pointer;
}

.version-icon:hover {
  color: #ffcc00;
}

.badge {
  background: red;
  color: white;
  padding: 3px 8px;
  border-radius: 50%;
  font-size: 11px;
  margin-left: 5px;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  background: white;
  border-radius: 8px;
  min-width: 200px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 8px 0;
  display: none;
  z-index: 1000;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown-item {
  padding: 10px 15px;
  font-size: 12px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dropdown-item:hover {
  background: #f0f0f0;
}

.notif-badge {
  background: red;
  color: white;
  padding: 2px 6px;
  font-size: 10px;
  border-radius: 12px;
}

.notif-dot {
  background: red;
  color: white;
  font-size: 12px;
  width: 16px;
  height: 16px;
  text-align: center;
  display: inline-block;
  border-radius: 50%;
}

.sound-toggle {
  padding: 10px 15px;
  border-top: 1px solid #ddd;
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

.sound-options {
  margin-top: 5px;
  font-size: 11px;
}

.sound-options label {
  display: block;
  margin-top: 5px;
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

.merchant-title {
  text-align: right;
  font-weight: bold;
  font-size: 13px;
  margin-bottom: 5px;
  padding-right: 7px;
  padding-left: 7px;
}

.merchant-item {
  color: gray;
  font-size: 12px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 7px 7px;
}

.currency {
  margin-left: 5px;
}

.amount {
  margin-left: auto;
}

@media (max-width: 768px) {

  #merchant-wallet {
    display: none;
  }

  #member {
    display: none;
  }

  #version-text {
    display: none;
  }

  #version-icon {
    display: none;
  }

  #affiliate-dropdown {
    display: none;
  }

  #date {
    display: none;
  }

  .menu-toggle {
    padding: 3px;
    margin-right: 5px;
  }
}
</style>
