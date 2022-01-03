<template>
    <div style="height:100%">
        <div class="text-center text-lg-left">
            <h3>Vote Station</h3>
            <p>Please make your vote. (min: 1, max: 3)</p>
        </div>

        <div class="grid">
            <CandidateDetailsCard name="@arifhusaini97" />
            <CandidateDetailsCard name="@arifhusaini97" />
            <CandidateDetailsCard name="@arifhusaini97" />
        </div>
    </div>
</template>

<script>
import CandidateDetailsCard from "./sub-components/CandidateDetailsCard.vue";
export default {
    name: "eVotingStation",
    components: { CandidateDetailsCard },
    mounted() {
        window.scrollTo({ top: 100, left: 0, behavior: "smooth" });
    }
};
</script>

<style lang="scss" scoped>
.grid {
    display: grid;
    height: 100%;

    grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
    grid-auto-rows: calc(95% / 3);
    grid-gap: 1.5rem;

    overflow: auto;
    justify-content: center;
    justify-items: center;
    align-items: center;
    padding: 2rem 0 3.5rem 0;
}
</style>
