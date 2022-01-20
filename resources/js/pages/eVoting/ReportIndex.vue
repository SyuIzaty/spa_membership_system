<template>
    <div>
        <Toast
            position="top-right"
            :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
        />
        <center class="mb-5">
            <img src="../../assets/logo_primary_2.png" style="height: 100px" />
        </center>
        <h4 class="mb-5" style="text-align: center">
            <b>Campus General Election Report</b>
        </h4>
        <div
            style="
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            "
            v-if="is_loading.overall || is_loading.detail"
        >
            <ProgressSpinner
                style="width: 100px; height: 100px"
                strokeWidth="8"
                fill="#EEEEEE"
                animationDuration=".5s"
            />
        </div>
        <div
            v-else-if="
                !is_loading.overall &&
                !is_loading.detail &&
                categories.length > 0
            "
        >
            <Divider align="left" type="dashed">
                <b>Overall</b>
            </Divider>
            <div
                class="p-fieldset-content"
                style="font-size: 1.25rem; padding: 0rem 0rem 2rem 2rem"
            >
                Total Students:
                {{ overall_report.total_students }} persons<br />
                Total Turnouts: {{ overall_report.total_turnouts }} persons ({{
                    overall_report.total_students
                        ? Math.round(
                              ((overall_report.total_turnouts /
                                  overall_report.total_students) *
                                  100 +
                                  Number.EPSILON) *
                                  100
                          ) / 100
                        : 0
                }}%)<br />
                Total Not Turnouts:
                {{ overall_report.total_not_turnouts }} persons ({{
                    overall_report.total_students
                        ? Math.round(
                              ((overall_report.total_not_turnouts /
                                  overall_report.total_students) *
                                  100 +
                                  Number.EPSILON) *
                                  100
                          ) / 100
                        : 0
                }}%)
            </div>
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
        <div v-else class="text-center h1">No report for you.</div>
    </div>
</template>

<script>
import CategoricalReport from "../../components/eVoting/CategoricalReport.vue";
import ProgressSpinner from "primevue/progressspinner";
import Divider from "primevue/divider";
export default {
    name: "ReportIndex",
    components: { CategoricalReport, ProgressSpinner, Divider },
    data() {
        return {
            categories: [],
            overall_report: {
                total_students: 0,
                total_turnouts: 0,
                total_not_turnouts: 0,
            },
            is_loading: { overall: true, detail: true },
        };
    },

    async mounted() {
        this.is_loading.overall = true;
        this.is_loading.detail = true;
        await axios
            .get("/overall-report")
            .then((response) => {
                const overall_report = response.data.data;
                this.overall_report = overall_report;
                this.is_loading.overall = false;
            })
            .catch((error) => {
                console.log(error);
                this.is_loading.overall = false;
                this.$toast.add({
                    severity: "error",
                    summary: "Error Message",
                    detail: "No report detail to be loaded",
                    life: 3000,
                });
            });
        await axios
            .get("/categorical-report")
            .then((response) => {
                const categories = response.data.data;
                this.categories = categories;
                this.is_loading.detail = false;
            })
            .catch((error) => {
                console.log(error);
                this.is_loading.detail = false;
                this.$toast.add({
                    severity: "error",
                    summary: "Error Message",
                    detail: "No report detail to be loaded",
                    life: 3000,
                });
            });
    },
};
</script>
<style></style>
