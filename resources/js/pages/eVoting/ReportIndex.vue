<template>
    <div>
        <center class="mb-5">
            <img src="../../assets/logo_primary_2.png" style="height: 100px" />
        </center>
        <h4 class="mb-5" style="text-align: center">
            <b>Campus General Election Report</b>
        </h4>
        <div v-if="categories.length > 0">
            <CategoricalReport
                v-for="category in categories"
                :key="category.id"
                :name="category.name"
                :description="category.description"
                :programme_categories_name="category.programme_categories_name"
                :total_students="category.total_students"
                :total_turnouts="category.total_turnouts"
                :total_not_turnouts="category.total_not_turnouts"
                :candidates="category.candidates"
            />
        </div>
    </div>
</template>

<script>
import CategoricalReport from "../../components/eVoting/CategoricalReport.vue";
export default {
    name: "ReportIndex",
    components: { CategoricalReport },
    data() {
        return {
            categories: [],
        };
    },

    mounted() {
        axios.get("/categorical-report").then((response) => {
            const categories = response.data.data;
            console.log(categories);
            this.categories = categories;
        });
    },
};
</script>
<style></style>
