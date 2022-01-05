<template>
    <div style="position: relative">
        <button
            class="btn btn-primary"
            style="position: absolute"
            @click="$router.push({ name: 'vote-platform' })"
        >
            <i class="ni ni-chevron-left"></i>
        </button>
        <h1 class="text-center">Dashboard</h1>
        <div
            class="row align-items-center"
            style="
                height: 100%;
                border-style: solid;
                padding: 1rem;
                margin: 1rem;
            "
        >
            <div class="col-12 col-lg-2 bg-secondary mb-3">
                <h5 class="text-white m-0 text-center">
                    Faculty of Computer and Mathematical Sciences
                </h5>
            </div>
            <div
                class="col-12 col-lg-4 mb-3"
                style="
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                "
            >
                <h5>Participation Chart</h5>
                <PieChart
                    :styles="{ height: '10rem' }"
                    :options="{
                        responsive: true,
                        maintainAspectRatio: false,
                    }"
                />
                <table style="width: 100%; max-width: 10rem; margin-top: 1rem">
                    <tr>
                        <th>Turnout</th>
                        <td>40 (80%)</td>
                    </tr>
                    <tr>
                        <th>Not Turnout</th>
                        <td>10 (20%)</td>
                    </tr>
                </table>
            </div>

            <div class="col-12 col-lg-6 mb-3">
                <h5 class="text-center">Candidate Chart</h5>
                <HorizontalBarChart
                    :styles="{ height: '10rem', width: '100%' }"
                    :options="{
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                    }"
                />
            </div>
        </div>
    </div>
</template>

<script>
import PieChart from "../../components/eVoting/PieChart.vue";
import HorizontalBarChart from "../../components/eVoting/HorizontalBarChart.vue";
export default {
    name: "eVotingDashboard",
    components: { PieChart, HorizontalBarChart },
};
</script>

<style lang="scss" scoped>
.grid {
    display: grid;

    grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
    grid-gap: 2rem;

    overflow: visible;
    justify-content: center;
    justify-items: center;
    align-items: center;
    padding: 2rem 0 2rem 0;
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
