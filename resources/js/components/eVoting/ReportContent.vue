<template>
    <div>
        <Divider align="left">
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
</template>

<script>
import CategoricalReport from "../../components/eVoting/CategoricalReport.vue";
import Divider from "primevue/divider";
export default {
    name: "ReportContent",
    props: {
        overall_report: { type: Object, default: () => {}, required: true },
        categories: { type: Array, default: () => {}, required: true },
    },
    components: { CategoricalReport, Divider },
};
</script>

<style></style>
