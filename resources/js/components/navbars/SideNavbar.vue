<script setup>
import {ref, computed} from "vue";
import {useRoute} from "vue-router";
import {
  BadgeCheck, Banknote, Boxes, CalendarClock, ChevronRight, Clock, Crown, Dot, Gift,
  Goal, Home, Mail, Megaphone, Network, Star, Tag, Trophy, UsersRound, Wallet, Box, Settings, BriefcaseBusiness,
  FileQuestion
} from "lucide-vue-next";
import {useNotificationStore} from '@/stores/notification';
import {storeToRefs} from 'pinia';

const store = useNotificationStore();
const {showSuccess} = storeToRefs(store);
const route = useRoute();
const openSubmenus = ref({});
const isSidebarOpen = ref(false);

defineProps({isSidebarOpen: Boolean});
const emit = defineEmits(["close-sidebar"]);

const closeSidebar = () => {
  emit("close-sidebar");
};

const toggleSubmenu = (key) => {
  console.log("openSubmenus:", openSubmenus);
  openSubmenus.value[key] = !openSubmenus.value[key];
};

const isActive = (path) => computed(() => route.path === path);
</script>


<template>
  <div class="sidebar-container" :class="['sidebar', { 'hidden-sidebar': !isSidebarOpen }]">

    <p class="close-btn d-flex justify-content-end m-2 font-600" @click="closeSidebar">x</p>
    <li @click="$router.push('/');">
      <Home size="18" stroke-width="2" class="icon"/>
      Dashboard
    </li>

    <li class="display-flex align-items-center" @click="toggleSubmenu('member')">
      <UsersRound size="18" stroke-width="2" class="icon"/>
      1. Member
      <ChevronRight
          size="14"
          stroke-width="2"
          class="chevron-icon ml-1 mt-1 mb-1 mr-1"
          :class="{ open: openSubmenus['member'] }"
      />
    </li>
    <ul v-if="openSubmenus['member']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-info').value, 'text-secondary': !isActive('/member-info').value }"
            to="/member-info" class="text-decoration-none">
          <span v-if="isActive('/member-info').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.1 Member Info
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-edit').value, 'text-secondary': !isActive('/member-edit').value }"
            to="/member-edit" class="text-decoration-none">
          <span v-if="isActive('/member-edit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.2 Member Edit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-group').value, 'text-secondary': !isActive('/member-group').value }"
            to="/member-group" class="text-decoration-none">
          <span v-if="isActive('/member-group').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.3 Member Group
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/tag-management').value, 'text-secondary': !isActive('/tag-management').value }"
            to="/tag-management" class="text-decoration-none">
          <span v-if="isActive('/tag-management').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.4 Tag Management
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-fund').value, 'text-secondary': !isActive('/member-fund').value }"
            to="/member-fund" class="text-decoration-none">
          <span v-if="isActive('/member-fund').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.5 Member Fund
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-online').value, 'text-secondary': !isActive('/member-online').value }"
            to="/member-online" class="text-decoration-none">
          <span v-if="isActive('/member-online').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.6 Member Online
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-trace').value, 'text-secondary': !isActive('/member-trace').value }"
            to="/member-trace" class="text-decoration-none">
          <span v-if="isActive('/member-trace').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.7 Member Trace
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-verification').value, 'text-secondary': !isActive('/member-verification').value }"
            to="/member-verification" class="text-decoration-none">
          <span v-if="isActive('/member-verification').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.8 Member Verification
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/tac-list').value, 'text-secondary': !isActive('/tac-list').value }"
            to="/tac-list" class="text-decoration-none">
          <span v-if="isActive('/tac-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.9 Tac List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-bank-uncertain-list').value,
             'text-secondary': !isActive('/member-bank-uncertain-list').value }"
            to="/member-bank-uncertain-list" class="text-decoration-none">
          <span v-if="isActive('/member-bank-uncertain-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 1.10 Member Bank Uncertain List
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('deposit')">
      <Wallet size="18" stroke-width="2" class="icon"/>
      2. Deposit/Withdraw
      <ChevronRight
          size="14"
          stroke-width="2"
          class="chevron-icon ml-1 mt-1 mb-1 mr-1"
          :class="{ open: openSubmenus['deposit'] }"
      />
    </li>
    <ul v-if="openSubmenus['deposit']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/deposit').value,
             'text-secondary': !isActive('/deposit').value }"
            to="/deposit" class="text-decoration-none">
          <span v-if="isActive('/deposit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.1 Deposit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/withdraw').value,
             'text-secondary': !isActive('/withdraw').value }"
            to="/withdraw" class="text-decoration-none">
          <span v-if="isActive('/withdraw').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.2 Withdraw
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/deposit-gateway-pending-list').value,
             'text-secondary': !isActive('/deposit-gateway-pending-list').value }"
            to="/deposit-gateway-pending-list" class="text-decoration-none">
          <span v-if="isActive('/deposit-gateway-pending-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.3 Deposit Gateway Pending List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/withdraw-condition-list').value,
             'text-secondary': !isActive('/withdraw-condition-list').value }"
            to="/withdraw-condition-list" class="text-decoration-none">
          <span v-if="isActive('/withdraw-condition-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.4 Withdraw Condition List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/express-deposit').value,
             'text-secondary': !isActive('/express-deposit').value }"
            to="/express-deposit" class="text-decoration-none">
          <span v-if="isActive('/express-deposit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.5 Express Deposit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/adjustment').value,
             'text-secondary': !isActive('/adjustment').value }"
            to="/adjustment" class="text-decoration-none">
          <span v-if="isActive('/adjustment').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.6 Adjustment
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/wallet-transfer').value,
             'text-secondary': !isActive('/wallet-transfer').value }"
            to="/wallet-transfer" class="text-decoration-none">
          <span v-if="isActive('/wallet-transfer').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.7 Wallet Transfer
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/withdraw-burn-list').value,
             'text-secondary': !isActive('/withdraw-burn-list').value }"
            to="/withdraw-burn-list" class="text-decoration-none">
          <span v-if="isActive('/withdraw-burn-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 2.8 Withdraw Burn List
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('promotion')">
      <Gift size="18" stroke-width="2" class="icon"/>
      3. Promotion
      <ChevronRight
          size="14"
          stroke-width="2"
          class="chevron-icon ml-1 mt-1 mb-1 mr-1"
          :class="{ open: openSubmenus['promotion'] }"
      />
    </li>
    <ul v-if="openSubmenus['promotion']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-promotions').value,
             'text-secondary': !isActive('/member-promotions').value }"
            to="/member-promotions" class="text-decoration-none">
          <span v-if="isActive('/member-promotions').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.1 Member Promotions
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/promotion-apply').value,
             'text-secondary': !isActive('/promotion-apply').value }"
            to="/promotion-apply" class="text-decoration-none">
          <span v-if="isActive('/promotion-apply').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.2 Promotion Apply
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/promotion-statistic').value,
             'text-secondary': !isActive('/promotion-statistic').value }"
            to="/promotion-statistic" class="text-decoration-none">
          <span v-if="isActive('/promotion-statistic').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.3 Promotion Statistic
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/promotion-code').value,
             'text-secondary': !isActive('/promotion-code').value }"
            to="/promotion-code" class="text-decoration-none">
          <span v-if="isActive('/promotion-code').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.4 Promotion Code
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/promotion-content').value,
             'text-secondary': !isActive('/promotion-content').value }"
            to="/promotion-content" class="text-decoration-none">
          <span v-if="isActive('/promotion-content').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.5 Promotion Content
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/promotion-checking').value,
             'text-secondary': !isActive('/promotion-checking').value }"
            to="/promotion-checking" class="text-decoration-none">
          <span v-if="isActive('/promotion-checking').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 3.6 Promotion Checking
        </router-link>
      </li>
    </ul>
    <li class="display-flex align-items-center" @click="toggleSubmenu('vipmode')">
      <Crown size="18" stroke-width="2" class="icon"/>
      4. VIP Mode
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['vipmode'] }"/>
    </li>
    <ul v-if="openSubmenus['vipmode']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip-settings').value,
             'text-secondary': !isActive('/vip-settings').value }"
            to="/vip-settings" class="text-decoration-none">
          <span v-if="isActive('/vip-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.1 VIP Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip-level-point-record').value,
             'text-secondary': !isActive('/vip-level-point-record').value }"
            to="/vip-level-point-record" class="text-decoration-none">
          <span v-if="isActive('/vip-level-point-record').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.2 VIP Level Point Record
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/bonus-received-record').value,
             'text-secondary': !isActive('/bonus-received-record').value }"
            to="/bonus-received-record" class="text-decoration-none">
          <span v-if="isActive('/bonus-received-record').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.3 Bonus Received Record
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip-display-settings').value,
             'text-secondary': !isActive('/vip-display-settings').value }"
            to="/vip-display-settings" class="text-decoration-none">
          <span v-if="isActive('/vip-display-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.4 VIP Display Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip-settings-history').value,
             'text-secondary': !isActive('/vip-settings-history').value }"
            to="/vip-settings-history" class="text-decoration-none">
          <span v-if="isActive('/vip-settings-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.5 VIP Settings History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip-banner-settings').value,
             'text-secondary': !isActive('/vip-banner-settings').value }"
            to="/vip-banner-settings" class="text-decoration-none">
          <span v-if="isActive('/vip-banner-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 4.6 VIP Banner Settings
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('eventmanagement')">
      <CalendarClock size="18" stroke-width="2" class="icon"/>
      5. Event Management
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['eventmanagement'] }"/>
    </li>
    <ul v-if="openSubmenus['eventmanagement']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/activity-setting').value,
             'text-secondary': !isActive('/activity-setting').value }"
            to="/activity-setting" class="text-decoration-none">
          <span v-if="isActive('/activity-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 5.1 Activity Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/lucky-wheel-report').value,
             'text-secondary': !isActive('/lucky-wheel-report').value }"
            to="/lucky-wheel-report" class="text-decoration-none">
          <span v-if="isActive('/lucky-wheel-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 5.2 Lucky Wheel Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/point-edited-report').value,
             'text-secondary': !isActive('/point-edited-report').value }"
            to="/point-edited-report" class="text-decoration-none">
          <span v-if="isActive('/point-edited-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 5.3 Point Edited Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/lucky-wheel-terms-and-conditions').value,
             'text-secondary': !isActive('/lucky-wheel-terms-and-conditions').value }"
            to="/lucky-wheel-terms-and-conditions" class="text-decoration-none">
          <span v-if="isActive('/lucky-wheel-terms-and-conditions').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 5.4 Lucky Wheels Terms and Conditions
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('daily-mission')">
      <Goal size="18" stroke-width="2" class="icon"/>
      6. Mission Daily Setting
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['daily-mission'] }"/>
    </li>
    <ul v-if="openSubmenus['daily-mission']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/daily-mission').value,
             'text-secondary': !isActive('/daily-mission').value }"
            to="/daily-mission" class="text-decoration-none">
          <span v-if="isActive('/daily-mission').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.1 Daily Mission
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/accumulative-mission').value,
             'text-secondary': !isActive('/lucky-wheel-report').value }"
            to="/accumulative-mission" class="text-decoration-none">
          <span v-if="isActive('/accumulative-mission').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.2 Accumulative Mission
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/period-mission').value,
             'text-secondary': !isActive('/period-mission').value }"
            to="/period-mission" class="text-decoration-none">
          <span v-if="isActive('/period-mission').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.3 Period Mission
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/mission-rewards-history').value,
             'text-secondary': !isActive('/mission-rewards-history').value }"
            to="/mission-rewards-history" class="text-decoration-none">
          <span v-if="isActive('/mission-rewards-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.4 Mission Rewards History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/mission-adjustment-record').value,
             'text-secondary': !isActive('/mission-adjustment-record').value }"
            to="/mission-adjustment-record" class="text-decoration-none">
          <span v-if="isActive('/mission-adjustment-record').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.5 Mission Adjustment Record
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/mission-daily-settings').value,
             'text-secondary': !isActive('/mission-daily-settings').value }"
            to="/mission-daily-settings" class="text-decoration-none">
          <span v-if="isActive('/mission-daily-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 6.6 Mission Daily Settings
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('referral')">
      <Boxes size="18" stroke-width="2" class="icon"/>
      7. Referral
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['referral'] }"/>
    </li>
    <ul v-if="openSubmenus['referral']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral').value,
             'text-secondary': !isActive('/referral').value }"
            to="/referral" class="text-decoration-none">
          <span v-if="isActive('/referral').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.1 Referral
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-bonus').value,
             'text-secondary': !isActive('/referral-bonus').value }"
            to="/referral-bonus" class="text-decoration-none">
          <span v-if="isActive('/referral-bonus').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.2 Referral Bonus
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-terms-and-conditions').value,
             'text-secondary': !isActive('/referral-terms-and-conditions').value }"
            to="/referral-terms-and-conditions" class="text-decoration-none">
          <span v-if="isActive('/referral-terms-and-conditions').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.3 Referral Terms and Conditions
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-setting').value,
             'text-secondary': !isActive('/referral-setting').value }"
            to="/referral-setting" class="text-decoration-none">
          <span v-if="isActive('/referral-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.4 Referral Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-commission-setting').value,
             'text-secondary': !isActive('/referral-commission-setting').value }"
            to="/referral-commission-setting" class="text-decoration-none">
          <span v-if="isActive('/referral-commission-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.5 Referral Commission Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-commission-list').value,
             'text-secondary': !isActive('/referral-commission-list').value }"
            to="/referral-commission-list" class="text-decoration-none">
          <span v-if="isActive('/referral-commission-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.6 Referral Commission List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/referral-summary').value,
             'text-secondary': !isActive('/referral-summary').value }"
            to="/referral-summary" class="text-decoration-none">
          <span v-if="isActive('/referral-summary').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 7.7 Referral Summary
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('tournament')">
      <Trophy size="18" stroke-width="2" class="icon"/>
      8. Tournament
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['tournament'] }"/>
    </li>
    <ul v-if="openSubmenus['tournament']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/tournament-setting-list').value,
             'text-secondary': !isActive('/tournament-setting-list').value }"
            to="/tournament-setting-list" class="text-decoration-none">
          <span v-if="isActive('/tournament-setting-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 8.1 Tournament Setting List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/tournament-reward').value,
             'text-secondary': !isActive('/tournament-reward').value }"
            to="/tournament-reward" class="text-decoration-none">
          <span v-if="isActive('/tournament-reward').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 8.2 Tournament Reward
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('verifyReward')">
      <BadgeCheck size="18" stroke-width="2" class="icon"/>
      9. Verify Reward
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['verifyReward'] }"/>
    </li>
    <ul v-if="openSubmenus['verifyReward']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/verify-reward-settings').value,
             'text-secondary': !isActive('/verify-reward-settings').value }"
            to="/verify-reward-settings" class="text-decoration-none">
          <span v-if="isActive('/verify-reward-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 9.1 Verify Reward Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/verify-reward-list').value,
             'text-secondary': !isActive('/verify-reward-list').value }"
            to="/verify-reward-list" class="text-decoration-none">
          <span v-if="isActive('/verify-reward-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 9.2 Verify Reward List
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('soccer')">
      <Star size="18" stroke-width="2" class="icon"/>
      10. Soccer
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['soccer'] }"/>
    </li>
    <ul v-if="openSubmenus['soccer']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/soccer-match-predict-settings').value,
             'text-secondary': !isActive('/soccer-match-predict-settings').value }"
            to="/soccer-match-predict-settings" class="text-decoration-none">
          <span v-if="isActive('/soccer-match-predict-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 10.1 Soccer Match Predict Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/soccer-match-predict-list').value,
             'text-secondary': !isActive('/soccer-match-predict-list').value }"
            to="/soccer-match-predict-list" class="text-decoration-none">
          <span v-if="isActive('/soccer-match-predict-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 10.2 Soccer Match Predict List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/soccer-match-predict-reward-history').value,
             'text-secondary': !isActive('/soccer-match-predict-reward-history').value }"
            to="/soccer-match-predict-reward-history" class="text-decoration-none">
          <span v-if="isActive('/soccer-match-predict-reward-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 10.3 Soccer Match Predict Reward History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/soccer-match-predict-term-and-condition').value,
             'text-secondary': !isActive('/soccer-match-predict-term-and-condition').value }"
            to="/soccer-match-predict-term-and-condition" class="text-decoration-none">
          <span v-if="isActive('/soccer-match-predict-term-and-condition').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 10.4 Soccer Match Predict Term And Condition
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/soccer-match-predict-match-list').value,
             'text-secondary': !isActive('/soccer-match-predict-match-list').value }"
            to="/soccer-match-predict-match-list" class="text-decoration-none">
          <span v-if="isActive('/soccer-match-predict-match-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 10.5 Soccer Match Predict Match List
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('angpow')">
      <Mail size="18" stroke-width="2" class="icon"/>
      11. Angpow
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['angpow'] }"/>
    </li>
    <ul v-if="openSubmenus['angpow']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/angpow-setting').value,
             'text-secondary': !isActive('/angpow-setting').value }"
            to="/angpow-setting" class="text-decoration-none">
          <span v-if="isActive('/angpow-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 11.1 Angpow Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/angpow-reward-history').value,
             'text-secondary': !isActive('/angpow-reward-history').value }"
            to="/angpow-reward-history" class="text-decoration-none">
          <span v-if="isActive('/angpow-reward-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 11.2 Angpow Reward History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/angpow-term-and-condition').value,
             'text-secondary': !isActive('/angpow-term-and-condition').value }"
            to="/angpow-term-and-condition" class="text-decoration-none">
          <span v-if="isActive('/angpow-term-and-condition').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 11.3 Angpow Term and Condition
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('rebate')">
      <Tag size="18" stroke-width="2" class="icon"/>
      12. Rebate
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['rebate'] }"/>
    </li>
    <ul v-if="openSubmenus['rebate']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/rebate-release').value,
             'text-secondary': !isActive('/rebate-release').value }"
            to="/rebate-release" class="text-decoration-none">
          <span v-if="isActive('/rebate-release').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 12.1 Rebate Release
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/provider-rebate-history').value,
             'text-secondary': !isActive('/provider-rebate-history').value }"
            to="/provider-rebate-history" class="text-decoration-none">
          <span v-if="isActive('/provider-rebate-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 12.2 Provider Rebate History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-rebate-history').value,
             'text-secondary': !isActive('/member-rebate-history').value }"
            to="/member-rebate-history" class="text-decoration-none">
          <span v-if="isActive('/member-rebate-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 12.3 Member Rebate History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/rebate-setting').value,
             'text-secondary': !isActive('/rebate-setting').value }"
            to="/rebate-setting" class="text-decoration-none">
          <span v-if="isActive('/rebate-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 12.4 Rebate Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/rebate-disclaimer').value,
             'text-secondary': !isActive('/rebate-disclaimer').value }"
            to="/rebate-disclaimer" class="text-decoration-none">
          <span v-if="isActive('/rebate-disclaimer').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 12.5 Rebate Disclaimer
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('report')">
      <Clock size="18" stroke-width="2" class="icon"/>
      13. Report
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['report'] }"/>
    </li>
    <ul v-if="openSubmenus['report']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-report').value,
             'text-secondary': !isActive('/member-report').value }"
            to="/member-report" class="text-decoration-none">
          <span v-if="isActive('/member-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.1 Member Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/all-member-report').value,
             'text-secondary': !isActive('/all-member-report').value }"
            to="/all-member-report" class="text-decoration-none">
          <span v-if="isActive('/all-member-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.2 All Member Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/provider-report').value,
             'text-secondary': !isActive('/provider-report').value }"
            to="/provider-report" class="text-decoration-none">
          <span v-if="isActive('/provider-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.3 Provider Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/company-report').value,
             'text-secondary': !isActive('/company-report').value }"
            to="/company-report" class="text-decoration-none">
          <span v-if="isActive('/company-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.4 Company Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/outstanding-report').value,
             'text-secondary': !isActive('/outstanding-report').value }"
            to="/outstanding-report" class="text-decoration-none">
          <span v-if="isActive('/outstanding-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.5 Outstanding Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/daily-new-deposit').value,
             'text-secondary': !isActive('/daily-new-deposit').value }"
            to="/daily-new-deposit" class="text-decoration-none">
          <span v-if="isActive('/daily-new-deposit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.6 Daily New Deposit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-statistic').value,
             'text-secondary': !isActive('/member-statistic').value }"
            to="/member-statistic" class="text-decoration-none">
          <span v-if="isActive('/member-statistic').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.7 Member Statistic
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/game-statistic-report').value,
             'text-secondary': !isActive('/game-statistic-report').value }"
            to="/game-statistic-report" class="text-decoration-none">
          <span v-if="isActive('/game-statistic-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.8 Game Statistic Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/all-affiliate-report').value,
             'text-secondary': !isActive('/all-affiliate-report').value }"
            to="/all-affiliate-report" class="text-decoration-none">
          <span v-if="isActive('/all-affiliate-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.9 All Affiliate Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/all-sub-affiliate-report').value,
             'text-secondary': !isActive('/all-sub-affiliate-report').value }"
            to="/all-sub-affiliate-report" class="text-decoration-none">
          <span v-if="isActive('/all-sub-affiliate-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.10 All Sub Affiliate Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/ftd-std-report').value,
             'text-secondary': !isActive('/ftd-std-report').value }"
            to="/ftd-std-report" class="text-decoration-none">
          <span v-if="isActive('/ftd-std-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.11 FTD/STD Report
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/premium-game-report').value,
             'text-secondary': !isActive('/premium-game-report').value }"
            to="/premium-game-report" class="text-decoration-none">
          <span v-if="isActive('/premium-game-report').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 13.12 Premium Game Report
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('systemMessage')">
      <Megaphone size="18" stroke-width="2" class="icon"/>
      14. System Message
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['systemMessage'] }"/>
    </li>
    <ul v-if="openSubmenus['systemMessage']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/announcement').value,
             'text-secondary': !isActive('/announcement').value }"
            to="/announcement" class="text-decoration-none">
          <span v-if="isActive('/announcement').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 14.1 Announcement
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-message').value,
             'text-secondary': !isActive('/member-message').value }"
            to="/member-message" class="text-decoration-none">
          <span v-if="isActive('/member-message').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 14.2 Member Message
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/system-notification').value,
             'text-secondary': !isActive('/system-notification').value }"
            to="/system-notification" class="text-decoration-none">
          <span v-if="isActive('/system-notification').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 14.3 System Notification
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('bankPayment')">
      <Banknote size="18" stroke-width="2" class="icon"/>
      15. Bank/Payment
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['bankPayment'] }"/>
    </li>
    <ul v-if="openSubmenus['bankPayment']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/bank-setting').value,
             'text-secondary': !isActive('/bank-setting').value }"
            to="/bank-setting" class="text-decoration-none">
          <span v-if="isActive('/bank-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.1 Bank Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/bank-details').value,
             'text-secondary': !isActive('/bank-details').value }"
            to="/bank-details" class="text-decoration-none">
          <span v-if="isActive('/bank-details').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.2 Bank Details
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/deposit-details').value,
             'text-secondary': !isActive('/deposit-details').value }"
            to="/deposit-details" class="text-decoration-none">
          <span v-if="isActive('/deposit-details').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.3 Deposit Details
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/transaction-record').value,
             'text-secondary': !isActive('/transaction-record').value }"
            to="/transaction-record" class="text-decoration-none">
          <span v-if="isActive('/transaction-record').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.4 Transaction Record
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-bank-setting').value,
             'text-secondary': !isActive('/member-bank-setting').value }"
            to="/member-bank-setting" class="text-decoration-none">
          <span v-if="isActive('/member-bank-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.5 Member Bank Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/third-party-payment-platform').value,
             'text-secondary': !isActive('/third-party-payment-platform').value }"
            to="/third-party-payment-platform" class="text-decoration-none">
          <span v-if="isActive('/third-party-payment-platform').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 15.6 Third Party Payment Platform
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('affiliate')">
      <Network size="18" stroke-width="2" class="icon"/>
      16. Affiliate
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['affiliate'] }"/>
    </li>
    <ul v-if="openSubmenus['affiliate']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-approval').value,
             'text-secondary': !isActive('/affiliate-approval').value }"
            to="/affiliate-approval" class="text-decoration-none">
          <span v-if="isActive('/affiliate-approval').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.1 Affiliate Approval
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-list').value,
             'text-secondary': !isActive('/affiliate-list').value }"
            to="/affiliate-list" class="text-decoration-none">
          <span v-if="isActive('/affiliate-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.2 Affiliate List
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-approval-history').value,
             'text-secondary': !isActive('/affiliate-approval-history').value }"
            to="/affiliate-approval-history" class="text-decoration-none">
          <span v-if="isActive('/affiliate-approval-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.3 Affiliate Approval History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-domain').value,
             'text-secondary': !isActive('/affiliate-domain').value }"
            to="/affiliate-domain" class="text-decoration-none">
          <span v-if="isActive('/affiliate-domain').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.4 Affiliate Domain
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-group').value,
             'text-secondary': !isActive('/affiliate-group').value }"
            to="/affiliate-group" class="text-decoration-none">
          <span v-if="isActive('/affiliate-group').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.5 Affiliate Group
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-page-setting').value,
             'text-secondary': !isActive('/affiliate-page-setting').value }"
            to="/affiliate-page-setting" class="text-decoration-none">
          <span v-if="isActive('/affiliate-page-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.6 Affiliate Page Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-contact-setting').value,
             'text-secondary': !isActive('/affiliate-contact-setting').value }"
            to="/affiliate-contact-setting" class="text-decoration-none">
          <span v-if="isActive('/affiliate-contact-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.7 Affiliate Contact Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-postback-url').value,
             'text-secondary': !isActive('/affiliate-postback-url').value }"
            to="/affiliate-postback-url" class="text-decoration-none">
          <span v-if="isActive('/affiliate-postback-url').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 16.8 Affiliate Postback URL
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('affiliate-commission')">
      <Box size="18" stroke-width="2" class="icon"/>
      17. Affiliate Comm
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['affiliate-commission'] }"/>
    </li>
    <ul v-if="openSubmenus['affiliate-commission']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-generate-commission').value,
             'text-secondary': !isActive('/affiliate-generate-commission').value }"
            to="/affiliate-generate-commission" class="text-decoration-none">
          <span v-if="isActive('/affiliate-generate-commission').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.1 Affiliate Generate Comm
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-commission-history').value,
             'text-secondary': !isActive('/affiliate-commission-history').value }"
            to="/affiliate-commission-history" class="text-decoration-none">
          <span v-if="isActive('/affiliate-commission-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.2 Affiliate Commission History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-withdrawal').value,
             'text-secondary': !isActive('/affiliate-withdrawal').value }"
            to="/affiliate-withdrawal" class="text-decoration-none">
          <span v-if="isActive('/affiliate-withdrawal').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.3 Affiliate Withdrawal
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-withdrawal-history').value,
             'text-secondary': !isActive('/affiliate-withdrawal-history').value }"
            to="/affiliate-withdrawal-history" class="text-decoration-none">
          <span v-if="isActive('/affiliate-withdrawal-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.4 Affiliate Withdrawal History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-deposit').value,
             'text-secondary': !isActive('/affiliate-deposit').value }"
            to="/affiliate-deposit" class="text-decoration-none">
          <span v-if="isActive('/affiliate-deposit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.5 Affiliate Deposit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-transfer-history').value,
             'text-secondary': !isActive('/affiliate-transfer-history').value }"
            to="/affiliate-transfer-history" class="text-decoration-none">
          <span v-if="isActive('/affiliate-transfer-history').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.6 Affiliate Transfer History
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-adjustment').value,
             'text-secondary': !isActive('/affiliate-adjustment').value }"
            to="/affiliate-adjustment" class="text-decoration-none">
          <span v-if="isActive('/affiliate-adjustment').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.7 Affiliate Adjustment
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-currency-rate-setting').value,
             'text-secondary': !isActive('/affiliate-currency-rate-setting').value }"
            to="/affiliate-currency-rate-setting" class="text-decoration-none">
          <span v-if="isActive('/affiliate-currency-rate-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 17.8 Affiliate Currency Rate Setting
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('system-settings')">
      <Settings size="18" stroke-width="2" class="icon"/>
      18. System Settings
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['system-settings'] }"/>
    </li>
    <ul v-if="openSubmenus['system-settings']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/game-provider').value,
             'text-secondary': !isActive('/game-provider').value }"
            to="/game-provider" class="text-decoration-none">
          <span v-if="isActive('/game-provider').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.1 Game Provider
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/department').value,
             'text-secondary': !isActive('/department').value }"
            to="/department" class="text-decoration-none">
          <span v-if="isActive('/department').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.2 Department
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/agent').value,
             'text-secondary': !isActive('/agent').value }"
            to="/agent" class="text-decoration-none">
          <span v-if="isActive('/agent').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.3 Agent
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/advertisement').value,
             'text-secondary': !isActive('/advertisement').value }"
            to="/advertisement" class="text-decoration-none">
          <span v-if="isActive('/advertisement').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.4 Advertisement
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/ip-whitelist').value,
             'text-secondary': !isActive('/ip-whitelist').value }"
            to="/ip-whitelist" class="text-decoration-none">
          <span v-if="isActive('/ip-whitelist').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.5 IP Whitelist
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/web-featured-game').value,
             'text-secondary': !isActive('/web-featured-game').value }"
            to="/web-featured-game" class="text-decoration-none">
          <span v-if="isActive('/web-featured-game').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.6 Web Featured Game
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/provider-setting').value,
             'text-secondary': !isActive('/provider-setting').value }"
            to="/provider-setting" class="text-decoration-none">
          <span v-if="isActive('/provider-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.7 Provider Setting
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/export-list').value,
             'text-secondary': !isActive('/export-list').value }"
            to="/export-list" class="text-decoration-none">
          <span v-if="isActive('/export-list').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 18.8 Export List
        </router-link>
      </li>
    </ul>


    <li class="display-flex align-items-center" @click="toggleSubmenu('cms')">
      <BriefcaseBusiness size="18" stroke-width="2" class="icon"/>
      19. CMS
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['cms'] }"/>
    </li>
    <ul v-if="openSubmenus['cms']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/logo-favicon').value,
             'text-secondary': !isActive('/logo-favicon').value }"
            to="/logo-favicon" class="text-decoration-none">
          <span v-if="isActive('/logo-favicon').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.1 Logo & Favicon
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/banner-settings').value,
             'text-secondary': !isActive('/banner-settings').value }"
            to="/banner-settings" class="text-decoration-none">
          <span v-if="isActive('/banner-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.2 Banner Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/affiliate-banner').value,
             'text-secondary': !isActive('/affiliate-banner').value }"
            to="/affiliate-banner" class="text-decoration-none">
          <span v-if="isActive('/affiliate-banner').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.3 Affiliate Banner
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/seo-metadata').value,
             'text-secondary': !isActive('/seo-metadata').value }"
            to="/seo-metadata" class="text-decoration-none">
          <span v-if="isActive('/seo-metadata').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.4 SEO Metadata
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/seo-scripts-settings').value,
             'text-secondary': !isActive('/seo-scripts-settings').value }"
            to="/seo-scripts-settings" class="text-decoration-none">
          <span v-if="isActive('/seo-scripts-settings').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.5 SEO Scripts Settings
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/seo-footer').value,
             'text-secondary': !isActive('/seo-footer').value }"
            to="/seo-footer" class="text-decoration-none">
          <span v-if="isActive('/seo-footer').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.6 SEO Footer
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/general-info').value,
             'text-secondary': !isActive('/general-info').value }"
            to="/general-info" class="text-decoration-none">
          <span v-if="isActive('/general-info').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.7 General Info
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/event-tracking-code').value,
             'text-secondary': !isActive('/event-tracking-code').value }"
            to="/event-tracking-code" class="text-decoration-none">
          <span v-if="isActive('/event-tracking-code').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.8 Event Tracking Code
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/blog-setting').value,
             'text-secondary': !isActive('/blog-setting').value }"
            to="/blog-setting" class="text-decoration-none">
          <span v-if="isActive('/blog-setting').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 19.9 Blog Setting
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('compliance')">
      <FileQuestion size="18" stroke-width="2" class="icon"/>
      20. Compliance
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['compliance'] }"/>
    </li>
    <ul v-if="openSubmenus['compliance']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/roadblock').value,
             'text-secondary': !isActive('/roadblock').value }"
            to="/roadblock" class="text-decoration-none">
          <span v-if="isActive('/roadblock').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 20.1 Roadblock
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/member-bet-limit').value,
             'text-secondary': !isActive('/member-bet-limit').value }"
            to="/member-bet-limit" class="text-decoration-none">
          <span v-if="isActive('/member-bet-limit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 20.2 Member Bet Limit
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/group-bet-limit').value,
             'text-secondary': !isActive('/group-bet-limit').value }"
            to="/group-bet-limit" class="text-decoration-none">
          <span v-if="isActive('/group-bet-limit').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 20.3 Group Bet Limit
        </router-link>
      </li>
    </ul>

    <li class="display-flex align-items-center" @click="toggleSubmenu('leaderboardData')">
      <BriefcaseBusiness size="18" stroke-width="2" class="icon"/>
      21. Leaderboard Data
      <ChevronRight size="14" stroke-width="2" class="chevron-icon ml-1 mt-1 mb-1 mr-1"
                    :class="{ open: openSubmenus['leaderboardData'] }"/>
    </li>
    <ul v-if="openSubmenus['leaderboardData']" class="submenu">
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/vip').value,
             'text-secondary': !isActive('/vip').value }"
            to="/vip" class="text-decoration-none">
          <span v-if="isActive('/vip').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 21.1 VIP
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/lucky-spin').value,
             'text-secondary': !isActive('/lucky-spin').value }"
            to="/lucky-spin" class="text-decoration-none">
          <span v-if="isActive('/lucky-spin').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 21.2 Lucky Spin
        </router-link>
      </li>
      <li>
        <router-link
            :class="{ 'text-dark': isActive('/top-referral').value,
             'text-secondary': !isActive('/top-referral').value }"
            to="/top-referral" class="text-decoration-none">
          <span v-if="isActive('/top-referral').value">
            <Dot stroke-width="2" size="30" style="color:#ffcc00"/></span> 21.3 Top Referral
        </router-link>
      </li>
    </ul>

  </div>

  <div v-if="showSuccess" class="save-animation-container" id="saveBar">
    <div class="save-bar"></div>
    <div class="save-text">Update Successful</div>
  </div>

  <div v-if="isSidebarOpen" class="overlay" @click="closeSidebar"></div>
</template>

<style scoped>
.save-animation-container {
  position: fixed;
  bottom: 20px;
  left: 20px;
  z-index: 9999;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
  width: 250px;
  padding: 10px 15px;
  overflow: hidden;
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 500;
  font-family: sans-serif;
  border-left: 4px solid #28a745;
  animation: fadeOut 4s forwards;
}

.save-bar {
  position: absolute;
  left: 0;
  bottom: 0;
  height: 6px;
  width: 100%;
  background: linear-gradient(to right, #00e676, #00c853);
  animation: slideBack 3s linear forwards;
}

.save-text {
  z-index: 2;
  color: #333;
}

@keyframes slideBack {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
}

@keyframes fadeOut {
  0% {
    opacity: 1;
  }
  90% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    visibility: hidden;
  }
}

.sidebar {
  list-style: none;
  padding: 12px 2px;
}

.sidebar li {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
  padding: 12px 2px;
  display: flex;
  align-items: center;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  color: #5a5858;
}

.sidebar li:hover {
  background: #f5f5f5;
  border-radius: 5px;
}

.chevron-icon {
  margin-left: auto;
  transition: transform 0.2s;
}

.chevron-icon.open {
  transform: rotate(90deg);
}

.icon {
  margin-right: 10px;
}

.submenu {
  list-style: none;
  padding-left: 25px;
  background: #f9f9f9;
}

.submenu li {
  padding: 8px 0;
  font-size: 13px;
  color: #787878;
  cursor: pointer;
}

@media (min-width: 768px) {
  .close-btn {
    display: none !important;
  }
}

.submenu li:hover,
.submenu li.selected {
  color: black;
  font-weight: bold;
}

@media (max-width: 430px) {
  .sidebar-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 200px;
    padding: 12px 2px;
    height: 100vh;
    background: white;
    z-index: 1001;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
  }

  .sidebar-container.hidden-sidebar {
    transform: translateX(0);
  }

  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    transition: opacity 0.3s ease-in-out;
  }
}

.active-item span {
  color: black;
  font-weight: bold;
  margin-right: 3px;
}
</style>
