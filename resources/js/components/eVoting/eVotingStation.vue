<template>
    <div style="height: 100%; display: flex; flex-direction: column">
        <div
            class="text-center"
            style="margin-top: 1rem; width: 100%; align-self: center"
        >
            <h3>Vote Station</h3>
            <p>Please make your vote. (min: 1, max: 3)</p>
        </div>

        <div class="grid">
            <CandidateDetailsCard id="1" name="NUR ARIF HUSAINI BIN NORWAZA" />
            <CandidateDetailsCard id="2" name="NUR ARIF HUSAINI BIN NORWAZA" />
            <CandidateDetailsCard id="3" name="NUR ARIF HUSAINI BIN NORWAZA" />
        </div>
        <button
            type="submit"
            class="btn btn-primary"
            style="margin-top: 1rem; width: 80%; align-self: center"
        >
            Submit
        </button>
    </div>
</template>

<script>
import CandidateDetailsCard from "./sub-components/CandidateDetailsCard.vue";
export default {
    name: "eVotingStation",
    components: { CandidateDetailsCard },
    mounted() {
        window.scrollTo({ top: 100, left: 0, behavior: "smooth" });
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
    padding: 0 0 2rem 0;
    min-height: 25rem;
}
</style>
