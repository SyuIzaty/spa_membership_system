<template>
    <div>
        <Toast
            position="top-right"
            :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
        />
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
                <span>From: {{ format(session.vote_datetime_start) }}</span>
                <span>To: {{ format(session.vote_datetime_end) }}</span>

                <span
                    >Active: {{ session.is_active === 1 ? "Yes" : "No" }}</span
                >
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
                @click="openAddSession()"
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
        <Dialog
            header="Create New Session"
            :visible.sync="displayAddSession"
            :maximizable="true"
            :modal="true"
            ><div style="display: flex; flex-direction: column" class="mb-4">
                <label for="name"><h3>Session Name</h3></label>
                <InputText
                    :class="{ 'mb-4': !error.session.name }"
                    id="name"
                    v-model="session.name"
                />
                <label for="vote_datetime_start"
                    ><h3>Vote Start Date</h3></label
                >
                <input
                    class="col-12 p-0 mb-4"
                    id="vote_datetime_start"
                    v-model="session.vote_datetime_start"
                    type="datetime-local"
                    name="vote_datetime_start"
                />
                <label for="vote_datetime_end"><h3>Vote End Date</h3></label>
                <input
                    class="col-12 p-0"
                    id="vote_datetime_end"
                    v-model="session.vote_datetime_end"
                    type="datetime-local"
                    name="vote_datetime_end"
                />
            </div>
            <template #footer>
                <Button
                    label="Close"
                    icon="pi pi-times"
                    @click="closeAddSession"
                    class="p-button-text"
                />
                <Button
                    label="Add"
                    icon="pi pi-check"
                    @click="addSession"
                    autofocus
                />
            </template>
        </Dialog>
    </div>
</template>

<script>
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import moment from "moment";
export default {
    name: "ManagementIndex",
    components: { Dialog, Button, InputText },
    data() {
        return {
            error: { session: { name: false } },
            session: {
                name: "",
                vote_datetime_start: null,
                vote_datetime_end: null,
            },
            sessions: [],
            displayAddSession: false,
            is_loading: false,
        };
    },
    mounted() {
        axios.get("/vote-sessions").then((response) => {
            this.sessions = response.data.data;
        });
    },
    methods: {
        format(date) {
            return moment(String(date)).format("ddd, MMM Do YYYY, HH:mm");
        },
        openAddSession() {
            this.displayAddSession = true;
        },
        closeAddSession() {
            this.displayAddSession = false;
        },
        addSession() {
            console.log("addSession");
            this.is_loading = true;
            axios
                .post("/e-voting/session", {
                    payload: this.session,
                })
                .then((response) => {
                    this.sessions.push(response.data.data);
                    this.$toast.add({
                        severity: "success",
                        summary: "Submitted",
                        detail: "New session created successfully",
                        life: 3000,
                    });
                    this.displayAddSession = false;
                    this.is_loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: "Fail to create new session.",
                        life: 3000,
                    });
                    this.is_loading = false;
                });
        },
    },
};
</script>
