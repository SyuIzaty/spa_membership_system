// import VoteDashboard from "./components/vote-management-system/VoteDashboard.vue";
let PlatformDashboard = require("./pages/eVoting/PlatformDashboard").default;
let PlatformStation = require("./pages/eVoting/PlatformStation").default;
let PlatformSuccess = require("./pages/eVoting/PlatformSuccess").default;
let PlatformIndex = require("./pages/eVoting/PlatformIndex").default;
let ReportIndex = require("./pages/eVoting/ReportIndex").default;
let ManagementIndex = require("./pages/eVoting/ManagementIndex").default;

export const routes = [
    { path: "/vote-platform", component: PlatformIndex, name: "vote-platform" },
    {
        path: "/vote-platform/dashboard",
        component: PlatformDashboard,
        name: "vote-platform-dashboard",
    },
    {
        path: "/vote-platform/station",
        component: PlatformStation,
        name: "vote-platform-station",
    },
    {
        path: "/vote-platform/station/success",
        component: PlatformSuccess,
        name: "vote-platform-station-success",
    },
    { path: "/vote-report", component: ReportIndex, name: "vote-report" },
    {
        path: "/vote-management",
        component: ManagementIndex,
        name: "vote-management",
    },
];
