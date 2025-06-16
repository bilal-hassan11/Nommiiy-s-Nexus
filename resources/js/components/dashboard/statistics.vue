<script setup>
import {ref} from "vue";

const statistics = ref({
  companyWinloss: -505666.85,
  todayTotalRegistrants: 58,
  todaysTotalDepositCount: 143,
  todaysTotalWithdrawalCount: 50,
  todaysUniqueMembersDepositCount: 94,
  todaysUniqueMembersWithdrawalCount: 33,
  todayTotalValidBets: 813681.78,
  todayPlayerWinloss: 45820.30,
  todayTotalRebates: 0,
  todayTotalPromotions: 5700.00,
  todayAffiliateCommission: 0.00,
  totalPlayers: 8265,
  todayTotalDeposit: 87865.00,
  todayTotalWithdrawal: 148089.30,
  todayDepositMinusWithdrawal: -60224.30,
  todayTotalRewards: 2722.10,
  todayReferralCommission: 0.00,
  totalOnlineUsers: 671,
});

function formatKey(key) {
  return key
      .replace(/([A-Z])/g, " $1")
      .replace(/_/g, " ")
      .replace(/^./, (str) => str.toUpperCase())
      .replace(/\bTodays\b/gi, "Today's");
}
</script>

<template>
  <div class="container-fluid">
    <div class="row g-3">
      <!-- Company Winloss Card (Handled Separately) -->
      <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
        <div
            class="card text-center company-winloss-card d-flex flex-column justify-content-center align-items-center p-3 w-100">
          <h6 class="company-winloss-label">This Month Company Winloss</h6>
          <p
              :class="{
        'text-danger': statistics.companyWinloss < 0,
        'text-success': statistics.companyWinloss > 0,
      }"
              class="company-winloss"
          >
            {{ statistics.companyWinloss.toLocaleString() }}
          </p>
        </div>
      </div>

      <!-- Other Statistics Cards -->
      <div class="col-lg-9 col-md-8 col-sm-6">
        <div class="row g-2">
          <div
              v-for="[key, value] in Object.entries(statistics).filter(([key]) => key !== 'companyWinloss')"
              :key="key"
              class="col-xl-3 col-lg-4 col-md-6 col-sm-6"
          >
            <div class="card statistic-card text-center p-3">
              <h6 class="stat-title">{{ formatKey(key) }}</h6>
              <p
                  :class="{
                  'text-success': key === 'todayPlayerWinloss',
                  'text-danger': value < 0 && key !== 'todayPlayerWinloss',
                  'default-color': value >= 0 && key !== 'todayPlayerWinloss'
                }"
                  class="stat-value"
              >
                {{ value.toLocaleString() }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>
.company-winloss-card {
  background: white;
  border-radius: 5px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

.company-winloss {
  font-size: 15px;
  font-weight: bold;
}

.company-winloss-label {
  font-weight: 500;
  font-size: 12px;
}

.statistic-card {
  border-radius: 3px;
  background: white;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-width: 150px;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
}

.stat-title {
  font-size: 10px;
  font-weight: 700;
}

.stat-value {
  font-size: 14px;
  font-weight: 700;
  margin-bottom: 7px;
}

.default-color {
  color: #e8b81f;
}

.text-danger {
  color: #e40303 !important;
}

.text-success {
  color: #44ae44 !important;
}
</style>
