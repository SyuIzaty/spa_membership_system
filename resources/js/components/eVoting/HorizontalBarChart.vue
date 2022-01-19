<script>
import { HorizontalBar } from "vue-chartjs";

export default {
    extends: HorizontalBar,

    props: {
        options: { type: Object, default: () => {}, required: false },
        data: { type: Object, default: () => {}, required: true },
    },
    // watch: {
    //     chartData() {
    //         this.$data._chart.update();
    //     }
    // },
    mounted() {
        this.renderChart(this.data, {
            responsive: true,
            maintainAspectRatio: false,
        });
    },
};
</script>
