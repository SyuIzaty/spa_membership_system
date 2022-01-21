<template>
    <div class="position-relative">
        <Toast
            position="top-right"
            :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
        />

        <button
            v-if="
                !is_loading.overall &&
                !is_loading.detail &&
                categories.length > 0 &&
                !is_generating_pdf
            "
            :disabled="is_generating_pdf"
            class="btn btn-primary position-absolute"
            style="top: 0; right: 0"
            rel="noopener"
            aria-label="Receipt"
            @click="printReport()"
        >
            Print
        </button>
        <ProgressSpinner
            v-else-if="is_generating_pdf"
            class="position-absolute"
            style="top: 0; right: 0; width: 1rem; height: 1rem"
            strokeWidth="8"
            animationDuration=".5s"
        />
        <center class="mb-5">
            <img src="../../assets/logo_primary_2.png" style="height: 100px" />
        </center>
        <h4 class="mb-5" style="text-align: center">
            <b>Campus General Election Report</b>
        </h4>

        <VueHtml2pdf
            ref="html2Pdf"
            :showLayout="false"
            :floatLayout="true"
            :enableDownload="true"
            :previewModal="false"
            :manualPagination="false"
            :paginateElementsByHeight="800"
            :filename="filename"
            :pdfQuality="1"
            pdfFormat="a4"
            pdfOrientation="portrait"
            pdfContentWidth="100%"
            @beforeDownload="hasStartedGeneration()"
            @hasDownloaded="hasGenerated($event)"
        >
            <section slot="pdf-content">
                <!-- PDF Content Here -->

                <center class="mb-5">
                    <img
                        src="../../assets/logo_primary_2.png"
                        style="height: 100px"
                    />
                </center>
                <h4 class="mb-5" style="text-align: center">
                    <b>Campus General Election Report</b>
                </h4>
                <Divider align="left">
                    <b>Overall</b>
                </Divider>
                <div
                    class="p-fieldset-content"
                    style="font-size: 1.25rem; padding: 0rem 0rem 2rem 2rem"
                >
                    Total Students:
                    {{ overall_report.total_students }} persons<br />
                    Total Turnouts: {{ overall_report.total_turnouts }} persons
                    ({{
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
                    :programme_categories_name="
                        category.programme_categories_name
                    "
                    :total_students="category.total_students"
                    :total_turnouts="category.total_turnouts"
                    :total_not_turnouts="category.total_not_turnouts"
                    :candidates="category.candidates"
                />
            </section>
        </VueHtml2pdf>
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
            <ReportContent
                :overall_report="overall_report"
                :categories="categories"
            />
        </div>

        <div v-else class="text-center h1">No report for you.</div>
    </div>
</template>

<script>
import CategoricalReport from "../../components/eVoting/CategoricalReport.vue";
import Divider from "primevue/divider";
import ReportContent from "../../components/eVoting/ReportContent.vue";
import ProgressSpinner from "primevue/progressspinner";
import VueHtml2pdf from "vue-html2pdf";
export default {
    name: "ReportIndex",
    components: {
        ProgressSpinner,
        VueHtml2pdf,
        ReportContent,
        CategoricalReport,
        Divider,
    },
    data() {
        return {
            categories: [],
            overall_report: {
                total_students: 0,
                total_turnouts: 0,
                total_not_turnouts: 0,
            },
            is_loading: { overall: true, detail: true },
            is_generating_pdf: false,
        };
    },

    methods: {
        hasStartedGeneration() {
            this.is_generating_pdf = true;
            console.log("Start generating pdf");
        },

        hasGenerated(event) {
            this.is_generating_pdf = false;
            console.log("End generating pdf");
        },

        printReport() {
            this.is_generating_pdf = true;
            console.log("Print button clicked");
            this.$refs.html2Pdf.generatePdf();
        },
    },

    computed: {
        filename() {
            return "report";
        },
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
