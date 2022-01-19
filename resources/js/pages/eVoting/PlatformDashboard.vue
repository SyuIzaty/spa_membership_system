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
        <CategoricalStatisticalChart
            v-for="(category, index) in categories"
            :key="index"
            :title="category.category_name"
            :data_pie="category.participation_data"
            :data_bar="category.candidates_data"
        />
    </div>
</template>

<script>
import CategoricalStatisticalChart from "../../components/eVoting/CategoricalStatisticalChart.vue";
export default {
    name: "eVotingDashboard",
    components: { CategoricalStatisticalChart },
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        axios.get("/categorical-statistics").then((response) => {
            const categories = response.data.data;
            categories.forEach((x) => {
                let temp = {
                    category_name: "",
                    candidates_data: {
                        labels: [],
                        datasets: [
                            {
                                label: "Vote",
                                backgroundColor: "#f87979",
                                data: [],
                            },
                        ],
                    },
                    participation_data: {
                        labels: ["Turnout", "Not Turnout"],
                        datasets: [
                            {
                                backgroundColor: [
                                    "rgba(63, 245, 39, 0.9)",
                                    "rgba(255, 0,0, 0.5)",
                                ],
                                data: [],
                            },
                        ],
                    },
                };
                temp.category_name = x.candidate_category + " (";
                const count_category = x.programme_categories.length;
                x.programme_categories.forEach((y, index) => {
                    temp.category_name += y;
                    if (index < count_category - 1) {
                        temp.category_name += " & ";
                    }
                });
                temp.category_name += ")";
                x.candidate_names.forEach((y) =>
                    temp.candidates_data.labels.push(this.truncateString(y, 15))
                );
                // temp.candidates_data.labels = x.candidate_names
                temp.candidates_data.datasets[0].data = x.total_voted;
                // x.participation_data.labels = [];
                temp.participation_data.datasets[0].data.push(x.total_turnouts);
                temp.participation_data.datasets[0].data.push(
                    x.total_not_turnouts
                );
                this.categories.push(temp);
            });
        });
    },
    methods: {
        truncateString(input, maxCharacters) {
            if (input.length > maxCharacters) {
                return input.substring(0, maxCharacters) + "...";
            }
            return input;
        },
    },
};
</script>
<style></style>
