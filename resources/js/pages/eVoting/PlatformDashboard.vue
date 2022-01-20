<template>
    <div style="position: relative">
        <Toast
            position="top-right"
            :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
        />
        <button
            class="btn btn-primary"
            style="position: absolute"
            @click="$router.push({ name: 'vote-platform' })"
        >
            <i class="ni ni-chevron-left"></i>
        </button>
        <h1 class="text-center">Dashboard</h1>

        <div
            style="
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            "
            v-if="is_loading"
        >
            <ProgressSpinner
                style="width: 100px; height: 100px"
                strokeWidth="8"
                fill="#EEEEEE"
                animationDuration=".5s"
            />
        </div>
        <div v-else-if="!is_loading && categories.length > 0">
            <CategoricalStatisticalChart
                v-for="(category, index) in categories"
                :key="index"
                :title="category.category_name"
                :data_pie="category.participation_data"
                :data_bar="category.candidates_data"
            />
        </div>
        <div v-else class="text-center h1">No dashboard for you.</div>
    </div>
</template>

<script>
import CategoricalStatisticalChart from "../../components/eVoting/CategoricalStatisticalChart.vue";
import ProgressSpinner from "primevue/progressspinner";
export default {
    name: "eVotingDashboard",
    components: { CategoricalStatisticalChart, ProgressSpinner },
    data() {
        return {
            categories: [],
            is_loading: true,
        };
    },
    mounted() {
        this.is_loading = true;
        axios
            .get("/categorical-statistics")
            .then((response) => {
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
                        temp.candidates_data.labels.push(
                            this.truncateString(y, 15)
                        )
                    );
                    // temp.candidates_data.labels = x.candidate_names
                    temp.candidates_data.datasets[0].data = x.total_voted;
                    // x.participation_data.labels = [];
                    temp.participation_data.datasets[0].data.push(
                        x.total_turnouts
                    );
                    temp.participation_data.datasets[0].data.push(
                        x.total_not_turnouts
                    );
                    this.categories.push(temp);
                });

                this.is_loading = false;
            })
            .catch((error) => {
                console.log(error);
                this.is_loading = false;
                this.$toast.add({
                    severity: "error",
                    summary: "Error Message",
                    detail: "No content to be loaded",
                    life: 3000,
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
