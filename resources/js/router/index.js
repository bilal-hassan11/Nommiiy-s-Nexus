import {createRouter, createWebHistory} from "vue-router";
import MemberInfo from "@/views/MemberViews/MemberInfo.vue";
import Dashboard from "@/components/dashboard/dashboard.vue";
import MemberEdit from "@/views/MemberViews/MemberEdit.vue";
import MemberGroup from "@/views/MemberViews/MemberGroup.vue";
import TagManagement from "@/views/MemberViews/TagManagement.vue";
import MemberTagSubPage from "@/views/MemberViews/modals/MemberTagSubPage.vue";
import EditVipRanking from "@/views/VipModeViews/modals/EditVipRanking.vue";
import MemberFund from "@/views/MemberViews/MemberFund.vue";
import MemberOnline from "@/views/MemberViews/MemberOnline.vue";
import MemberTrace from "@/views/MemberViews/MemberTrace.vue";
import MemberVerification from "@/views/MemberViews/MemberVerification.vue";
import TacList from "@/views/MemberViews/TacList.vue";
import MemberBankUncertainList from "@/views/MemberViews/MemberBankUncertainList.vue";
import Deposit from "@/views/DepositViews/Deposit.vue";
import Withdraw from "@/views/DepositViews/Withdraw.vue";
import DepositGatewayPendingList from "@/views/DepositViews/DepositGatewayPendingList.vue";
import WithdrawConditionList from "@/views/DepositViews/WithdrawConditionList.vue";
import ExpressDeposit from "@/views/DepositViews/ExpressDeposit.vue";
import Adjustment from "@/views/DepositViews/Adjustment.vue";
import WalletTransfer from "@/views/DepositViews/WalletTransfer.vue";
import WithdrawBurnList from "@/views/DepositViews/WithdrawBurnList.vue";
import MemberPromotions from "@/views/PromotionViews/MemberPromotions.vue";
import PromotionApply from "@/views/PromotionViews/PromotionApply.vue";
import PromotionStatistic from "@/views/PromotionViews/PromotionStatistic.vue";
import PromotionCode from "@/views/PromotionViews/PromotionCode.vue";
import PromotionContent from "@/views/PromotionViews/PromotionContent.vue";
import PromotionChecking from "@/views/PromotionViews/PromotionChecking.vue";
import VipSettings from "@/views/VipModeViews/VipSettings.vue";
import VipLevelPointRecord from "@/views/VipModeViews/VipLevelPointRecord.vue";
import BonusReceivedRecord from "@/views/VipModeViews/BonusReceivedRecord.vue";
import VipSettingsHistory from "@/views/VipModeViews/VipSettingsHistory.vue";
import VipBannerSettings from "@/views/VipModeViews/VipBannerSettings.vue";
import VipDisplaySettings from "@/views/VipModeViews/VipDisplaySettings.vue";
import ActivitySetting from "@/views/EventManagementViews/ActivitySetting.vue";
import LuckyWheelReport from "@/views/EventManagementViews/LuckyWheelReport.vue";
import LuckyWheelsTermsAndConditions from "@/views/EventManagementViews/LuckyWheelsTermsAndConditions.vue";
import PointEditedReport from "@/views/EventManagementViews/PointEditedReport.vue";
import DailyMission from "@/views/DailyMissionViews/DailyMission.vue";
import AccumulativeMission from "@/views/DailyMissionViews/AccumulativeMission.vue";
import PeriodMission from "@/views/DailyMissionViews/PeriodMission.vue";
import MissionRewardsHistory from "@/views/DailyMissionViews/MissionRewardsHistory.vue";
import MissionAdjustmentRecord from "@/views/DailyMissionViews/MissionAdjustmentRecord.vue";
import MissionDailySettings from "@/views/DailyMissionViews/MissionDailySettings.vue";
import Referral from "@/views/ReferralViews/Referral.vue";
import ReferralBonus from "@/views/ReferralViews/ReferralBonus.vue";
import ReferralTermsAndConditions from "@/views/ReferralViews/ReferralTermsAndConditions.vue";
import ReferralSetting from "@/views/ReferralViews/ReferralSetting.vue";
import ReferralCommissionSetting from "@/views/ReferralViews/ReferralCommissionSetting.vue";
import ReferralCommissionList from "@/views/ReferralViews/ReferralCommissionList.vue";
import ReferralSummary from "@/views/ReferralViews/ReferralSummary.vue";
import TournamentSettingList from "@/views/TournamentViews/TournamentSettingList.vue";
import TournamentReward from "@/views/TournamentViews/TournamentReward.vue";
import VerifyRewardSettings from "@/views/VerifyRewardViews/VerifyRewardSettings.vue";
import VerifyRewardList from "@/views/VerifyRewardViews/VerifyRewardList.vue";
import SoccerMatchPredictSettings from "@/views/SoccerViews/SoccerMatchPredictSettings.vue";
import SoccerMatchPredictList from "@/views/SoccerViews/SoccerMatchPredictList.vue";
import SoccerMatchPredictRewardHistory from "@/views/SoccerViews/SoccerMatchPredictRewardHistory.vue";
import SoccerMatchPredictTermAndCondition from "@/views/SoccerViews/SoccerMatchPredictTermAndCondition.vue";
import SoccerMatchPredictMatchList from "@/views/SoccerViews/SoccerMatchPredictMatchList.vue";
import AngpowSetting from "@/views/AngpowViews/AngpowSetting.vue";
import AngpowRewardHistory from "@/views/AngpowViews/AngpowRewardHistory.vue";
import AngpowTermAndCondition from "@/views/AngpowViews/AngpowTermAndCondition.vue";
import RebateRelease from "@/views/RebateViews/RebateRelease.vue";
import ProviderRebateHistory from "@/views/RebateViews/ProviderRebateHistory.vue";
import MemberRebateHistory from "@/views/RebateViews/MemberRebateHistory.vue";
import RebateSetting from "@/views/RebateViews/RebateSetting.vue";
import RebateDisclaimer from "@/views/RebateViews/RebateDisclaimer.vue";
import MemberReport from "@/views/ReportViews/MemberReport.vue";
import AllMemberReport from "@/views/ReportViews/AllMemberReport.vue";
import ProviderReport from "@/views/ReportViews/ProviderReport.vue";
import CompanyReport from "@/views/ReportViews/CompanyReport.vue";
import OutstandingReport from "@/views/ReportViews/OutstandingReport.vue";
import DailyNewDeposit from "@/views/ReportViews/DailyNewDeposit.vue";
import MemberStatistic from "@/views/ReportViews/MemberStatistic.vue";
import GameStatisticReport from "@/views/ReportViews/GameStatisticReport.vue";
import AllAffiliateReport from "@/views/ReportViews/AllAffiliateReport.vue";
import AllSubAffiliateReport from "@/views/ReportViews/AllSubAffiliateReport.vue";
import FTDSTDReport from "@/views/ReportViews/FTDSTDReport.vue";
import PremiumGameReport from "@/views/ReportViews/PremiumGameReport.vue";
import Announcement from "@/views/SystemMessageViews/Announcement.vue";
import MemberMessage from "@/views/SystemMessageViews/MemberMessage.vue";
import SystemNotification from "@/views/SystemMessageViews/SystemNotification.vue";
import BankSetting from "@/views/BankPaymentViews/BankSetting.vue";
import BankDetails from "@/views/BankPaymentViews/BankDetails.vue";
import DepositDetails from "@/views/BankPaymentViews/DepositDetails.vue";
import TransactionRecord from "@/views/BankPaymentViews/TransactionRecord.vue";
import MemberBankSetting from "@/views/BankPaymentViews/MemberBankSetting.vue";
import ThirdPartyPaymentPlatform from "@/views/BankPaymentViews/ThirdPartyPaymentPlatform.vue";
import AffiliateApproval from "@/views/AffiliateViews/AffiliateApproval.vue";
import AffiliateList from "@/views/AffiliateViews/AffiliateList.vue";
import AffiliateApprovalHistory from "@/views/AffiliateViews/AffiliateApprovalHistory.vue";
import AffiliateDomain from "@/views/AffiliateViews/AffiliateDomain.vue";
import AffiliateGroup from "@/views/AffiliateViews/AffiliateGroup.vue";
import AffiliatePageSetting from "@/views/AffiliateViews/AffiliatePageSetting.vue";
import AffiliateContactSetting from "@/views/AffiliateViews/AffiliateContactSetting.vue";
import AffiliatePostbackUrl from "@/views/AffiliateViews/AffiliatePostbackUrl.vue";
import ActivitySettingSubPage from "@/views/EventManagementViews/modals/ActivitySettingSubPage.vue";
import AffiliateGenerateCommission from "@/views/AffiliateCommissionViews/AffiliateGenerateCommission.vue";
import AffiliateCommissionHistory from "@/views/AffiliateCommissionViews/AffiliateCommissionHistory.vue";
import AffiliateWithdrawal from "@/views/AffiliateCommissionViews/AffiliateWithdrawal.vue";
import AffiliateWithdrawalHistory from "@/views/AffiliateCommissionViews/AffiliateWithdrawalHistory.vue";
import AffiliateDeposit from "@/views/AffiliateCommissionViews/AffiliateDeposit.vue";
import AffiliateTransferHistory from "@/views/AffiliateCommissionViews/AffiliateTransferHistory.vue";
import AffiliateAdjustment from "@/views/AffiliateCommissionViews/AffiliateAdjustment.vue";
import AffiliateCurrencyRateSetting from "@/views/AffiliateCommissionViews/AffiliateCurrencyRateSetting.vue";
import GameProvider from "@/views/SystemSettingsViews/GameProvider.vue";
import Department from "@/views/SystemSettingsViews/Department.vue";
import Agent from "@/views/SystemSettingsViews/Agent.vue";
import Advertisement from "@/views/SystemSettingsViews/Advertisement.vue";
import IPWhitelist from "@/views/SystemSettingsViews/IPWhitelist.vue";
import WebFeaturedGame from "@/views/SystemSettingsViews/WebFeaturedGame.vue";
import ProviderSetting from "@/views/SystemSettingsViews/ProviderSetting.vue";
import ExportList from "@/views/SystemSettingsViews/ExportList.vue";
import LogoAndFavicon from "@/views/CMS/LogoAndFavicon.vue";
import BannerSettings from "@/views/CMS/BannerSettings.vue";
import AffiliateBanner from "@/views/CMS/AffiliateBanner.vue";
import SEOMetadata from "@/views/CMS/SEOMetadata.vue";
import SEOScriptsSettings from "@/views/CMS/SEOScriptsSettings.vue";
import SEOFooter from "@/views/CMS/SEOFooter.vue";
import GeneralInfo from "@/views/CMS/GeneralInfo.vue";
import EventTrackingCode from "@/views/CMS/EventTrackingCode.vue";
import BlogSetting from "@/views/CMS/BlogSetting.vue";
import Roadblock from "@/views/ComplianceViews/Roadblock.vue";
import MemberBetLimit from "@/views/ComplianceViews/MemberBetLimit.vue";
import GroupBetLimit from "@/views/ComplianceViews/GroupBetLimit.vue";
import VIP from "@/views/LeaderboardDataViews/VIP.vue";
import LuckySpin from "@/views/LeaderboardDataViews/LuckySpin.vue";
import TopReferral from "@/views/LeaderboardDataViews/TopReferral.vue";
import AddTournamentSubPage from "@/views/TournamentViews/modals/AddTournamentSubPage.vue";
import AddVerifyRewardSettingSubPage from "@/views/VerifyRewardViews/SubPages/AddVerifyRewardSettingSubPage.vue";
import AddSoccerMatchPredictSettingsSubPage from "@/views/SoccerViews/modals/AddSoccerMatchPredictSettingsSubPage.vue";
import AddAngpowSettingSubPage from "@/views/AngpowViews/modals/AddAngpowSettingSubPage.vue";
import AddRebateSettingSubPage from "@/views/RebateViews/SubPages/AddRebateSettingSubPage.vue";
import AccountLogSubPage from "@/views/BankPaymentViews/modals/AccountLogSubPage.vue";


const routes = [
    {path: "/", name: "dashboard", component: Dashboard},
    {path: "/member-info", name: "member-info", component: MemberInfo},
    {path: "/member-edit", name: "member-edit", component: MemberEdit},
    {path: "/member-group", name: "member-group", component: MemberGroup},
    {path: "/tag-management", name: "tag-management", component: TagManagement},
    {path: "/new-tag-page", name: "new-tag-page", component: MemberTagSubPage},
    {path: "/member-fund", name: "member-fund", component: MemberFund},
    {path: "/member-online", name: "member-online", component: MemberOnline},
    {path: "/member-trace", name: "member-trace", component: MemberTrace},
    {path: "/member-verification", name: "member-verification", component: MemberVerification},
    {path: "/tac-list", name: "tac-list", component: TacList},
    {path: "/member-bank-uncertain-list", name: "member-bank-uncertain-list", component: MemberBankUncertainList},

    {path: "/deposit", name: "deposit", component: Deposit},
    {path: "/withdraw", name: "withdraw", component: Withdraw},
    {path: "/deposit-gateway-pending-list", name: "deposit-gateway-pending-list", component: DepositGatewayPendingList},
    {path: "/withdraw-condition-list", name: "withdraw-condition-list", component: WithdrawConditionList},
    {path: "/express-deposit", name: "express-deposit", component: ExpressDeposit},
    {path: "/adjustment", name: "adjustment", component: Adjustment},
    {path: "/wallet-transfer", name: "wallet-transfer", component: WalletTransfer},
    {path: "/withdraw-burn-list", name: "withdraw-burn-list", component: WithdrawBurnList},

    {path: "/member-promotions", name: "member-promotions", component: MemberPromotions},
    {path: "/promotion-apply", name: "promotion-apply", component: PromotionApply},
    {path: "/promotion-statistic", name: "promotion-statistic", component: PromotionStatistic},
    {path: "/promotion-code", name: "promotion-code", component: PromotionCode},
    {path: "/promotion-content", name: "promotion-content", component: PromotionContent},
    {path: "/promotion-checking", name: "promotion-checking", component: PromotionChecking},

    {path: "/vip-settings", name: "vip-settings", component: VipSettings},
    {path: "/vip-level-point-record", name: "vip-level-point-record", component: VipLevelPointRecord},
    {path: "/edit-vip-ranking", name: "edit-vip-ranking", component: EditVipRanking},
    {path: "/bonus-received-record", name: "bonus-received-record", component: BonusReceivedRecord},
    {path: "/vip-display-settings", name: "vip-display-settings", component: VipDisplaySettings},
    {path: "/vip-settings-history", name: "vip-settings-history", component: VipSettingsHistory},
    {path: "/vip-banner-settings", name: "vip-banner-settings", component: VipBannerSettings},

    {path: "/activity-setting", name: "activity-setting", component: ActivitySetting},
    {path: "/activity-setting-sub-page", name: "activity-setting-sub-page", component: ActivitySettingSubPage},
    {path: "/lucky-wheel-report", name: "lucky-wheel-report", component: LuckyWheelReport},
    {path: "/point-edited-report", name: "point-edited-report", component: PointEditedReport},
    {path: "/lucky-wheel-terms-and-conditions", name: "lucky-wheel-terms-and-conditions", component: LuckyWheelsTermsAndConditions},

    {path: "/daily-mission", name: "daily-mission", component: DailyMission},
    {path: "/accumulative-mission", name: "accumulative-mission", component: AccumulativeMission},
    {path: "/period-mission", name: "period-mission", component: PeriodMission},
    {path: "/mission-rewards-history", name: "mission-rewards-history", component: MissionRewardsHistory},
    {path: "/mission-adjustment-record", name: "mission-adjustment-record", component: MissionAdjustmentRecord},
    {path: "/mission-daily-settings", name: "mission-daily-settings", component: MissionDailySettings},

    {path: "/referral", name: "referral", component: Referral},
    {path: "/referral-bonus", name: "referral-bonus", component: ReferralBonus},
    {path: "/referral-terms-and-conditions", name: "referral-terms-and-conditions", component: ReferralTermsAndConditions},
    {path: "/referral-setting", name: "referral-setting", component: ReferralSetting},
    {path: "/referral-commission-setting", name: "referral-commission-setting", component: ReferralCommissionSetting},
    {path: "/referral-commission-list", name: "referral-commission-list", component: ReferralCommissionList},
    {path: "/referral-summary", name: "referral-summary", component: ReferralSummary},

    {path: "/tournament-setting-list", name: "tournament-setting-list", component: TournamentSettingList},
    {path: "/add-tournament-setting-list", name: "add-tournament-setting-list", component: AddTournamentSubPage},
    {path: "/tournament-reward", name: "tournament-reward", component: TournamentReward},

    {path: "/verify-reward-settings", name: "verify-reward-settings", component: VerifyRewardSettings},
    {path: "/add-verify-reward-settings", name: "add-verify-reward-settings", component: AddVerifyRewardSettingSubPage},
    {path: "/verify-reward-list", name: "verify-reward-list", component: VerifyRewardList},

    {path: "/soccer-match-predict-settings", name: "soccer-match-predict-settings", component: SoccerMatchPredictSettings},
    {path: "/add-soccer-match-predict-settings", name: "add-soccer-match-predict-settings", component: AddSoccerMatchPredictSettingsSubPage},
    {path: "/soccer-match-predict-list", name: "soccer-match-predict-list", component: SoccerMatchPredictList},
    {path: "/soccer-match-predict-reward-history", name: "soccer-match-predict-reward-history", component: SoccerMatchPredictRewardHistory},
    {path: "/soccer-match-predict-term-and-condition", name: "soccer-match-predict-term-and-condition", component: SoccerMatchPredictTermAndCondition},
    {path: "/soccer-match-predict-match-list", name: "soccer-match-predict-match-list", component: SoccerMatchPredictMatchList},

    {path: "/angpow-setting", name: "angpow-setting", component: AngpowSetting},
    {path: "/add-angpow-setting", name: "add-angpow-setting", component: AddAngpowSettingSubPage},
    {path: "/angpow-reward-history", name: "angpow-reward-history", component: AngpowRewardHistory},
    {path: "/angpow-term-and-condition", name: "angpow-term-and-condition", component: AngpowTermAndCondition},

    {path: "/rebate-release", name: "rebate-release", component: RebateRelease},
    {path: "/provider-rebate-history", name: "provider-rebate-history", component: ProviderRebateHistory},
    {path: "/member-rebate-history", name: "member-rebate-history", component: MemberRebateHistory},
    {path: "/rebate-setting", name: "rebate-setting", component: RebateSetting},
    {path: "/add-rebate-setting", name: "add-rebate-setting", component: AddRebateSettingSubPage},
    {path: "/rebate-disclaimer", name: "rebate-disclaimer", component: RebateDisclaimer},

    {path: "/member-report", name: "member-report", component: MemberReport},
    {path: "/all-member-report", name: "all-member-report", component: AllMemberReport},
    {path: "/provider-report", name: "provider-report", component: ProviderReport},
    {path: "/company-report", name: "company-report", component: CompanyReport},
    {path: "/outstanding-report", name: "outstanding-report", component: OutstandingReport},
    {path: "/daily-new-deposit", name: "daily-new-deposit", component: DailyNewDeposit},
    {path: "/member-statistic", name: "member-statistic", component: MemberStatistic},
    {path: "/game-statistic-report", name: "game-statistic-report", component: GameStatisticReport},
    {path: "/all-affiliate-report", name: "all-affiliate-report", component: AllAffiliateReport},
    {path: "/all-sub-affiliate-report", name: "all-sub-affiliate-report", component: AllSubAffiliateReport},
    {path: "/ftd-std-report", name: "ftd-std-report", component: FTDSTDReport},
    {path: "/premium-game-report", name: "premium-game-report", component: PremiumGameReport},

    {path: "/announcement", name: "announcement", component: Announcement},
    {path: "/member-message", name: "member-message", component: MemberMessage},
    {path: "/system-notification", name: "system-notification", component: SystemNotification},

    {path: "/bank-setting", name: "bank-setting", component: BankSetting},
    {path: "/bank-details", name: "bank-details", component: BankDetails},
    {path: "/deposit-details", name: "deposit-details", component: DepositDetails},
    {path: "/transaction-record", name: "transaction-record", component: TransactionRecord},
    {path: "/member-bank-setting", name: "member-bank-setting", component: MemberBankSetting},
    {path: "/third-party-payment-platform", name: "third-party-payment-platform", component: ThirdPartyPaymentPlatform},
    {path: "/account-log", name: "account-log", component: AccountLogSubPage},

    {path: "/affiliate-approval", name: "affiliate-approval", component: AffiliateApproval},
    {path: "/affiliate-list", name: "affiliate-list", component: AffiliateList},
    {path: "/affiliate-approval-history", name: "affiliate-approval-history", component: AffiliateApprovalHistory},
    {path: "/affiliate-domain", name: "affiliate-domain", component: AffiliateDomain},
    {path: "/affiliate-group", name: "affiliate-group", component: AffiliateGroup},
    {path: "/affiliate-page-setting", name: "affiliate-page-setting", component: AffiliatePageSetting},
    {path: "/affiliate-contact-setting", name: "affiliate-contact-setting", component: AffiliateContactSetting},
    {path: "/affiliate-postback-url", name: "affiliate-postback-url", component: AffiliatePostbackUrl},

    {path: "/affiliate-generate-commission", name: "affiliate-generate-commission", component: AffiliateGenerateCommission},
    {path: "/affiliate-commission-history", name: "affiliate-commission-history", component: AffiliateCommissionHistory},
    {path: "/affiliate-withdrawal", name: "affiliate-withdrawal", component: AffiliateWithdrawal},
    {path: "/affiliate-withdrawal-history", name: "affiliate-withdrawal-history", component: AffiliateWithdrawalHistory},
    {path: "/affiliate-deposit", name: "affiliate-deposit", component: AffiliateDeposit},
    {path: "/affiliate-transfer-history", name: "affiliate-transfer-history", component: AffiliateTransferHistory},
    {path: "/affiliate-adjustment", name: "affiliate-adjustment", component: AffiliateAdjustment},
    {path: "/affiliate-currency-rate-setting", name: "affiliate-currency-rate-setting", component: AffiliateCurrencyRateSetting},

    {path: "/game-provider", name: "game-provider", component: GameProvider},
    {path: "/department", name: "department", component: Department},
    {path: "/agent", name: "agent", component: Agent},
    {path: "/advertisement", name: "advertisement", component: Advertisement},
    {path: "/ip-whitelist", name: "ip-whitelist", component: IPWhitelist},
    {path: "/web-featured-game", name: "web-featured-game", component: WebFeaturedGame},
    {path: "/provider-setting", name: "provider-setting", component: ProviderSetting},
    {path: "/export-list", name: "export-list", component: ExportList},

    {path: "/logo-favicon", name: "logo-favicon", component: LogoAndFavicon},
    {path: "/banner-settings", name: "banner-settings", component: BannerSettings},
    {path: "/affiliate-banner", name: "affiliate-banner", component: AffiliateBanner},
    {path: "/seo-metadata", name: "seo-metadata", component: SEOMetadata},
    {path: "/seo-scripts-settings", name: "seo-scripts-settings", component: SEOScriptsSettings},
    {path: "/seo-footer", name: "seo-footer", component: SEOFooter},
    {path: "/general-info", name: "general-info", component: GeneralInfo},
    {path: "/event-tracking-code", name: "event-tracking-code", component: EventTrackingCode},
    {path: "/blog-setting", name: "blog-setting", component: BlogSetting},

    {path: "/roadblock", name: "roadblock", component: Roadblock},
    {path: "/member-bet-limit", name: "member-bet-limit", component: MemberBetLimit},
    {path: "/group-bet-limit", name: "group-bet-limit", component: GroupBetLimit},

    {path: "/vip", name: "vip", component: VIP},
    {path: "/lucky-spin", name: "lucky-spin", component: LuckySpin},
    {path: "/top-referral", name: "top-referral", component: TopReferral},
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
