<template>
    <div>Congratulation! You already vote.</div>
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
