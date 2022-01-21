<template>
    <div>
        <div
            class="row"
            style="
                padding: 2rem 5rem 2rem 5rem;
                justify-content: space-between;
                gap: 1rem;
            "
        >
            <div
                class="card p-3 col-12 col-lg-3"
                v-for="session in sessions"
                :key="session.id"
                style="
                    min-height: 12.5rem;
                    display: flex;
                    justify-content: center;
                "
            >
                <h1 style="margin-bottom: 0px">
                    MPP Voting {{ session.id
                    }}<small>(session: {{ session.id }})</small>
                </h1>

                <span>Date Start: {{ session.vote_datetime_start }}</span>
                <span>Date End: {{ session.vote_datetime_end }}</span>

                <span>Active: {{ session.active }}</span>
            </div>

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
            sessions: [
                {
                    id: 1,
                    session: "2021",
                    vote_datetime_start: "21/02/2021 (08:00am)",
                    vote_datetime_end: "23/02/2021 (05:00am)",
                    active: false,
                },
                {
                    id: 2,
                    session: "2022",
                    vote_datetime_start: "21/02/2022 (08:00am)",
                    vote_datetime_end: "23/02/2022 (05:00am)",
                    active: true,
                },
            ],
        };
    },
};
</script>
