<template>
    <div>
        <div
            v-if="sessions.length > 0"
            class="row"
            style="padding: 2rem 4rem 2rem 4rem; justify-content: space-between"
        >
            <router-link
                :to="{
                    name: 'vote-management-session_id',
                    params: { session_id: session.id },
                }"
                class="card p-2 col-12 col-lg-3"
                v-for="session in sessions"
                :key="session.id"
                style="
                    min-height: 12.5rem;
                    display: flex;
                    justify-content: center;
                    cursor: pointer;
                "
            >
                <h1 style="margin-bottom: 0px">
                    MPP Voting {{ session.session
                    }}<small>(session: {{ session.session }})</small>
                </h1>

                <!-- <div class="row">
                    <div class="col-4">From:</div>
                    <div class="col-8">{{ session.vote_datetime_start }}</div>
                </div>
                <div class="row">
                    <div class="col-4">To:</div>
                    <div class="col-8">{{ session.vote_datetime_end }}</div>
                </div>
                <div class="row">
                    <div class="col-4">Active:</div>
                    <div class="col-8">{{ session.is_active }}</div>
                </div> -->
                <span>From: {{ session.vote_datetime_start }}</span>
                <span>To: {{ session.vote_datetime_end }}</span>

                <span>Active: {{ session.is_active }}</span>
            </router-link>

            <div
                class="card p-3 col-12 col-lg-3"
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    cursor: pointer;
                    min-height: 12.5rem;
                "
            >
                <i
                    class="ni ni-big-plus"
                    style="font-size: 5rem; color: purple"
                ></i>
            </div>
            <div
                v-if="(sessions.length - 1) % 3 === 0"
                class="p-3 col-12 col-lg-3"
                style="width: 100%; height: 100%"
            ></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ManagementIndex",
    data() {
        return {
            sessions: [],
        };
    },
    mounted() {
        axios.get("/vote-sessions").then((response) => {
            this.sessions = response.data.data;
        });
    },
};
</script>
