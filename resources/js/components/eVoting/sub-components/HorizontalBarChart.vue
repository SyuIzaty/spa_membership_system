<script>
import { HorizontalBar } from "vue-chartjs";

export default {
    extends: HorizontalBar,

    props: { options: { type: Object, default: () => {}, required: false } },
    // watch: {
    //     chartData() {
    //         this.$data._chart.update();
    //     }
    // },
    mounted() {
        this.renderChart(
            {
                labels: [
                    "Nur Arif Husaini Bin Norwaza",
                    "Syahirah Azlina Binti Shamsuddin",
                    "Zulkifli Bin Hamzah"
                ],
                datasets: [
                    {
                        label: "Vote",
                        backgroundColor: "#f87979",
                        data: [40, 121, 20]
                    }
                ]
            },
            { responsive: true, maintainAspectRatio: false }
        );
    }
};
</script>
