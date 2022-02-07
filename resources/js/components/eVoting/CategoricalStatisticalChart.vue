<template>
    <div
        class="row align-items-center"
        style="height: 100%; border-style: solid; padding: 1rem; margin: 1rem"
    >
        <div
            class="col-12 col-lg-2 mb-3 mb-lg-1"
            style="
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: #a240ff;
                min-height: 20rem;
                justify-content: center;
            "
        >
            <h5 class="text-white m-0 text-center">
                {{ title }}
            </h5>
        </div>
        <div
            class="col-12 col-lg-4 mb-3 mb-lg-1"
            style="
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            "
        >
            <h5>Participation Chart</h5>
            <PieChart
                :data="data_pie"
                :styles="{ height: '10rem' }"
                :options="{
                    responsive: true,
                    maintainAspectRatio: false,
                }"
            />
            <table style="width: 100%; max-width: 10rem; margin-top: 1rem">
                <tr v-for="(label, index) in data_pie.labels" :key="index">
                    <th>{{ label }}</th>
                    <td>
                        {{ data_pie.datasets[0].data[index] }}
                        ({{
                            Math.round(
                                ((data_pie.datasets[0].data[index] /
                                    data_pie_total) *
                                    100 +
                                    Number.EPSILON) *
                                    100
                            ) / 100
                        }}%)
                    </td>
                </tr>
            </table>
        </div>

        <div class="col-12 col-lg-6 mb-3 mb-lg-1">
            <h5 class="text-center">Candidate Chart</h5>
            <HorizontalBarChart
                :data="data_bar"
                :styles="{ height: '10rem', width: '100%' }"
                :options="{
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                }"
            />
        </div>
    </div>
</template>

<script>
import PieChart from "../../components/eVoting/PieChart.vue";
import HorizontalBarChart from "../../components/eVoting/HorizontalBarChart.vue";
export default {
    name: "CategoricalStatisticalChart",
    components: { PieChart, HorizontalBarChart },
    props: {
        title: {
            type: String,
            default: "",
            required: true,
        },
        data_pie: {
            type: Object,
            default: () => {},
            required: true,
        },
        data_bar: {
            type: Object,
            default: () => {},
            required: true,
        },
    },
    computed: {
        data_pie_total() {
            return this.data_pie.datasets[0].data.reduce(this.add, 0);
        },
    },
    methods: {
        add(accumulator, a) {
            return accumulator + a;
        },
    },
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
