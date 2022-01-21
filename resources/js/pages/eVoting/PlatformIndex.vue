<template>
    <div
        class="d-flex flex-column justify-content-center main align-items-center"
    >
        <!-- <div
            style="
                display: flex;
                height: 20%;
                width: 100%;
                align-items: center;
                justify-content: center;
            "
        >
            <h3>e-Voting</h3>
        </div> -->
        <div
            class="menu d-flex flex-column flex-sm-row justify-content-center align-items-center"
            style="height: 100%; width: 100%"
        >
            <router-link :to="{ name: 'vote-platform-dashboard' }">
                <div class="card card__option">
                    <i
                        class="card-img-top ni ni-bar-chart py-3"
                        style="
                            font-size: 4rem;
                            margin-top: 1rem;
                            text-align: center;
                        "
                    ></i>
                    <div class="card-body" style="text-align: center">
                        Dashboard
                    </div>
                </div>
            </router-link>
            <div class="gap" v-if="is_open"></div>
            <router-link :to="{ name: 'vote-platform-station' }" v-if="is_open">
                <div class="card card__option">
                    <i
                        class="card-img-top ni ni-envelope-letter py-3"
                        style="
                            font-size: 4rem;
                            margin-top: 1rem;
                            text-align: center;
                        "
                    ></i>
                    <div class="card-body" style="text-align: center">
                        Vote Station
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "PlatformIndex",
    data() {
        return {
            is_open: false,
        };
    },
    mounted() {
        axios.get("/vote-is-open").then((response) => {
            console.log(response);
            this.is_open = response.data.data;
        });
    },
};
</script>

<style lang="scss" scoped>
.main {
    position: relative;
    // transform: translate(-50%, -50%);
    // left: 50%;
    // top: 50%;
    height: 100%;
    width: 100%;
}
.gap {
    width: 2.5rem;
    height: 2.5rem;
}
.card-body {
    padding: 0.5rem;
}
.card__option {
    height: 10rem;
    width: 10rem;
    cursor: pointer;
}
</style>
