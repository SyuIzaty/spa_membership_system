<template>
    <div class="card" style="width:100%; height:100%;">
        <div
            class="card-candidate"
            style="display:flex; flex-direction:row;
    position: absolute;"
        >
            <figure
                style="    height: 100%;
    width: 40%;
    min-width: 35%;
    position: relative;"
            >
                <img
                    style="width:100%; height:100%; object-fit: cover;backface-visibility: hidden;"
                    src="../../../assets/profile_1.jpg"
                />
            </figure>
            <div>
                {{ name }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CandidateDetailsCard",
    props: { name: { type: String, required: true, default: "" } }
};
</script>

<style lang="scss" scoped>
figure {
    margin: 0;
}
.card-candidate {
    cursor: pointer;
    position: absolute;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid rgba(255, 255, 255, 0.18);
    top: 50%;
    transform: translateY(-50%);
    overflow: hidden;
}
</style>
