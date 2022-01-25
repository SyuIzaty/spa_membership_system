<template>
    <div>
        <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3 text-center">Session</div>
            <InputText v-model="session" class="col-12 col-lg-10" />
        </div>
        <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3 text-center">From</div>
            <Calendar
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_start"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_start"
            />
            <div class="col-12 col-lg-2 h3 text-center">To</div>
            <Calendar
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_end"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_end"
            />
        </div>
        <div class="row p-5">
            <DataTable
                v-if="candidate_categories.length > 0"
                class="col-12 p-datatable-striped"
                :value="candidate_categories"
                :expandedRows.sync="expandedRows"
                dataKey="id"
                responsiveLayout="scroll"
                @row-expand="onRowExpand"
                @row-collapse="onRowCollapse"
            >
                <template #header>
                    <div class="table-header-container">
                        <h1>Candidate Categories</h1>
                    </div>
                </template>
                <Column :expander="true" :headerStyle="{ width: '3rem' }" />
                <Column field="name" header="Name" sortable></Column>
                <template #expansion="slotProps">
                    <div class="orders-subtable">
                        <h5 class="pt-2">
                            Programme Categories for {{ slotProps.data.name }}
                        </h5>
                        <DataTable
                            :value="slotProps.data.programme_categories"
                            class="p-datatable-striped"
                        >
                            <Column field="id" header="Id" sortable></Column>
                            <Column
                                field="name"
                                header="Name"
                                sortable
                            ></Column>
                            <Column header="programmes">
                                <template #body="slotProps">
                                    <span
                                        v-for="(programme, index) in slotProps
                                            .data.programmes"
                                        :key="programme.id"
                                        >{{ programme.code
                                        }}{{
                                            slotProps.data.programmes.length >
                                                1 &&
                                            index !==
                                                slotProps.data.programmes
                                                    .length -
                                                    1
                                                ? ", "
                                                : null
                                        }}</span
                                    >
                                </template>
                            </Column>
                        </DataTable>
                        <h5 class="pt-5">
                            Candidates for {{ slotProps.data.name }}
                        </h5>
                        <DataTable
                            :value="slotProps.data.candidates"
                            class="p-datatable-striped"
                        >
                            <Column
                                field="students_id"
                                header="Id"
                                sortable
                                :headerStyle="{ width: '10%' }"
                            >
                                <template #body="slotProps"
                                    ><div class="text-center">
                                        {{ slotProps.data.students_id }}
                                    </div></template
                                ></Column
                            >
                            <Column
                                header="Image"
                                :headerStyle="{ width: '20%' }"
                            >
                                <template #body="slotProps">
                                    <img
                                        v-if="
                                            slotProps.data.image !== '' &&
                                            slotProps.data.image !== null
                                        "
                                        style="
                                            width: 7.5rem;
                                            object-fit: cover;
                                            backface-visibility: hidden;
                                        "
                                        :src="slotProps.data.image"
                                    />
                                    <img
                                        v-else
                                        style="
                                            width: 7.5rem;
                                            object-fit: cover;
                                            backface-visibility: hidden;
                                        "
                                        :src="
                                            require(`../../assets/profile_default.jpg`)
                                        "
                                    />
                                </template>
                            </Column>
                            <Column
                                field="students_name"
                                header="Name"
                                :headerStyle="{ width: '30%' }"
                                sortable
                            ></Column>
                            <Column
                                field="tagline"
                                header="Tagline"
                                :headerStyle="{ width: '40%' }"
                                sortable
                            ></Column>
                        </DataTable>
                    </div>
                </template>
            </DataTable>
        </div>
        <!-- <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3">From</div>
            <Calendar
                id="vote_datetime_start"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_start"
            />
        </div>
        <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3">To</div>
            <Calendar
                id="vote_datetime_end"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_end"
            />
        </div> -->
    </div>
</template>

<script>
import InputText from "primevue/inputtext";
import Calendar from "primevue/calendar";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
export default {
    name: "ManagementPlatform",
    components: {
        Calendar,
        InputText,
        DataTable,
        Column,
    },
    data() {
        return {
            session: "",
            vote_datetime_start: null,
            vote_datetime_end: null,
            candidate_categories: [],
            expandedRows: [],
        };
    },

    mounted() {
        axios
            .get(`/vote-sessions/${this.$route.params.session_id}`)
            .then((response) => {
                let session = response.data.data;
                this.session = session.session;
                this.vote_datetime_start = session.vote_datetime_start;
                this.vote_datetime_end = session.vote_datetime_end;

                session.candidate_categories.forEach(async (x) => {
                    x.candidates.forEach(async (y, index) => {
                        if (y.image !== null && y.image !== "") {
                            x.candidates[index].image = await this.getImage(
                                y.image
                            );
                        }
                    });
                });
                this.candidate_categories = session.candidate_categories;
            });
    },

    methods: {
        onRowExpand(event) {
            this.$toast.add({
                severity: "info",
                summary: "Product Expanded",
                detail: event.data.name,
                life: 3000,
            });
        },
        onRowCollapse(event) {
            this.$toast.add({
                severity: "success",
                summary: "Product Collapsed",
                detail: event.data.name,
                life: 3000,
            });
        },
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
    },
};
</script>

<style lang="scss" scoped>
.gap {
    height: 5rem;
}
.p-0 {
    padding: 0rem !important;
}
// .col-12 {
//     padding-right: 0rem !important;
//     padding-left: 0rem !important;
// }
// .p-inputtext {
//     padding-left: 2rem;
//     padding-right: 2rem;
// }
</style>
