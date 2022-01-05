<script>
import { Pie } from "vue-chartjs";

export default {
    extends: Pie,
    props: { options: { type: Object, default: () => {}, required: false } },
    mounted() {
        this.gradient2 = this.$refs.canvas
            .getContext("2d")
            .createLinearGradient(0, 0, 0, 450);
        this.gradient = this.$refs.canvas
            .getContext("2d")
            .createLinearGradient(0, 0, 0, 450);

        this.gradient2.addColorStop(0, "rgba(255, 0,0, 0.5)");
        this.gradient2.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
        this.gradient2.addColorStop(1, "rgba(255, 0, 0, 0)");

        this.gradient.addColorStop(0, "rgba(63, 245, 39, 0.9)");
        this.gradient.addColorStop(0.5, "rgba(63, 245, 39, 0.5)");
        this.gradient.addColorStop(1, "rgba(63, 245, 39, 0.25)");

        // this.addPlugin({
        //     id: "my-plugin",
        //     beforeInit: function(chart) {
        //         return {
        //             legend: {
        //                 position: "bottom"
        //             },
        //             title: {
        //                 display: true,
        //                 text: "Chart.js Pie Chart"
        //             }
        //         };
        //     }
        // });

        console.log(this.plugins);
        this.renderChart(
            {
                labels: ["Turnout", "Not Turnout"],
                datasets: [
                    {
                        label: "Faculty of Mathematics",
                        backgroundColor: [
                            this.gradient,
                            this.gradient2,
                            "#00D8FF"
                        ],
                        data: [40, 10]
                    }
                ]
            },
            this.options
        );
    }
};
</script>
