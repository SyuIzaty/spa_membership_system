<template>
    <div
        style="
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        "
    >
        <button
            class="btn btn-primary"
            style="position: absolute"
            @click="$router.push({ name: 'vote-platform' })"
        >
            <i class="ni ni-chevron-left"></i>
        </button>
        <div
            class="text-center"
            style="
            display:fle
                margin-top: 1rem;
                width: 100%;
                align-self: center;
            "
        >
            <h3>Congratulation! You already vote.</h3>
        </div>
    </div>
</template>

<script>
export default {
    name: "PlatformSuccess",
    beforeRouteEnter(to, from, next) {
        axios.get("/vote-status").then((response) => {
            if (response.data.data) {
                next();
            } else {
                next({
                    name: "vote-platform-station",
                });
            }
        });
    },
};
</script>

<style></style>
