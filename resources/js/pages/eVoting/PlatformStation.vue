<template>
    <div
        style="
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        "
    >
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
        <div
            class="text-center"
            style="margin-top: 1rem; width: 100%; align-self: center"
        >
            <h3>Vote Station</h3>
            <p>Please make your vote. (min: 1, max: 2)</p>
            <p v-if="below_min" class="text-danger">
                Please vote at least <b>1</b> candidate
            </p>
            <p v-if="above_max" class="text-danger">
                Please vote not more than <b>2</b> candidates
            </p>
        </div>

        <div
            style="
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            "
            v-if="this.is_loading"
        >
            <ProgressSpinner
                style="width: 100px; height: 100px"
                strokeWidth="8"
                fill="#EEEEEE"
                animationDuration=".5s"
            />
        </div>
        <div class="grid" v-else-if="!this.is_loading && candidates.length > 0">
            <CandidateDetailsCard
                v-for="candidate in candidates"
                :key="candidate.id"
                :id="candidate.id.toString()"
                :name="candidate.student.students_name"
                :is_selected="candidate.is_selected"
                :img="candidate.image !== null ? candidate.image : ''"
                :category="
                    candidate.student.programme.programme_category.short_name
                        ? `${candidate.student.programme.programme_category.name} (${candidate.student.programme.programme_category.short_name})`
                        : candidate.student.programme.programme_category.name
                "
                :tagline="candidate.tagline"
                @voted-candidate="voted_candidate"
            />
        </div>
        <div v-else class="text-center h1">No candidate for you to vote.</div>
        <ConfirmPopup></ConfirmPopup>
        <button
            type="submit"
            class="btn btn-primary mt-3"
            style="width: 80%; align-self: center"
            @click="confirm($event)"
        >
            Submit
        </button>
    </div>
</template>

<script>
import CandidateDetailsCard from "../../components/eVoting/CandidateDetailsCard.vue";
import ConfirmPopup from "primevue/confirmpopup";
import ProgressSpinner from "primevue/progressspinner";
export default {
    name: "eVotingStation",
    components: { CandidateDetailsCard, ConfirmPopup, ProgressSpinner },
    data() {
        return {
            candidates: [],
            below_min: false,
            above_max: false,
            is_loading: true,
        };
    },

    beforeRouteEnter(to, from, next) {
        axios.get("/vote-status").then((response) => {
            if (response.data.data) {
                next({
                    name: "vote-platform-station-success",
                });
            } else {
                next();
            }
        });
    },

    async mounted() {
        window.scrollTo({ top: 100, left: 0, behavior: "smooth" });

        this.is_loading = true;
        await axios
            .get("/candidate-relevant")
            .then((response) => {
                if (typeof response.data.data === "object") {
                    this.candidates = response.data.data;
                    this.candidates.forEach(async (x, index) => {
                        if (x.image !== null) {
                            this.candidates[index].image = await this.getImage(
                                x.image
                            );
                        }
                    });
                } else {
                    this.$router.push({
                        name: "vote-platform-station-success",
                    });
                }

                this.is_loading = false;
            })
            .catch((error) => {
                console.error(error);
                this.$toast.add({
                    severity: "error",
                    summary: "Error Message",
                    detail: "No content to be loaded",
                    life: 3000,
                });
                this.is_loading = false;
            });
    },
    methods: {
        async getImage(path) {
            return await axios
                .get("/get-candidate-image", {
                    params: { image_path: path },
                    responseType: "arraybuffer",
                })
                .then((response) => {
                    const data = response.data;
                    if (data) {
                        const binary = this.arrayBufferToBinary(data);
                        let btoaBinary = "";
                        if (btoa(binary) === "") {
                            return "";
                        } else {
                            btoaBinary = btoa(binary);
                            return "data:image/jpeg;base64," + btoaBinary;
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                    return "";
                });
        },
        arrayBufferToBinary(arrayBuffer) {
            const bytes = new Uint8Array(arrayBuffer);
            const binary = bytes.reduce(
                (data, b) => (data += String.fromCharCode(b)),
                ""
            );

            return binary;
        },
        confirm(event) {
            var count_vote = 0;
            this.candidates.forEach((x) => {
                if (x.is_selected) {
                    count_vote += 1;
                }
            });
            if (count_vote < 1) {
                this.below_min = true;
                this.above_max = false;
            } else if (count_vote > 2) {
                this.below_min = false;
                this.above_max = true;
            } else {
                this.below_min = false;
                this.above_max = false;
                this.$confirm.require({
                    target: event.currentTarget,
                    message: "Are you sure you want to proceed?",
                    icon: "pi pi-exclamation-triangle",
                    accept: () => {
                        this.submit();
                        this.$toast.add({
                            severity: "info",
                            summary: "Submitted",
                            detail: "You have submitted the vote",
                            life: 3000,
                        });
                    },
                    reject: () => {
                        this.$toast.add({
                            severity: "warn",
                            summary: "Cancel",
                            detail: "You choose to reconsider your vote again.",
                            life: 3000,
                        });
                    },
                });
            }
        },
        voted_candidate(value) {
            console.log(value);
            this.candidates.find((x) => {
                return x.id === parseInt(value.id);
            }).is_selected = value.is_selected;
        },
        submit() {
            var count_vote = 0;
            this.candidates.forEach((x) => {
                if (x.is_selected) {
                    count_vote += 1;
                }
            });
            if (count_vote < 1) {
                this.below_min = true;
                this.above_max = false;
            } else if (count_vote > 2) {
                this.below_min = false;
                this.above_max = true;
            } else {
                this.below_min = false;
                this.above_max = false;

                this.is_loading = true;
                axios
                    .post("/candidate-relevant/vote", {
                        payload: this.candidates,
                    })
                    .then((response) => {
                        this.$router.push({
                            name: "vote-platform-station-success",
                        });

                        // this.is_loading = false;
                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toast.add({
                            severity: "error",
                            summary: "Error Message",
                            detail: "Fail to submit vote.",
                            life: 3000,
                        });
                        this.is_loading = false;
                    });
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.grid {
    display: grid;
    height: 80%;

    grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
    grid-auto-rows: calc(100% / 2);
    grid-gap: 0.8rem;

    overflow: auto;
    justify-content: center;
    justify-items: center;
    align-items: center;
    padding: 1rem 2rem 1rem 2rem;
    min-height: 25rem;
}
</style>
