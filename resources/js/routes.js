// import VoteDashboard from "./components/vote-management-system/VoteDashboard.vue";
let eVotingDashboard = require("./components/eVoting/eVotingDashboard").default;
let index = require("./components/eVoting/index").default;
export const routes = [
    { path: "/vote", component: index, name: "vote" },
    { path: "/vote/dashboard", component: eVotingDashboard, name: "dashboard" }
];
