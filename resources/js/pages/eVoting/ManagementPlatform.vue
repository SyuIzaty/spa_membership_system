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
                    <div
                        class="orders-subtable"
                        style="
                            display: flex;
                            flex-direction: column;
                            width: 100%;
                        "
                    >
                        <h5 class="pt-2">
                            Programme Categories for {{ slotProps.data.name }}
                        </h5>
                        <DataTable
                            :value="slotProps.data.programme_categories"
                            class="p-datatable-striped"
                            style="width: 100%"
                        >
                            <Column field="id" header="Id" sortable></Column>
                            <Column
                                field="name"
                                header="Name"
                                sortable
                            ></Column>
                            <Column header="programmes">
                                <template #body="slotProps">
                                    <div style="max-width: 10rem">
                                        <span
                                            v-for="(
                                                programme, index
                                            ) in slotProps.data.programmes"
                                            :key="programme.id"
                                            >{{ programme.code
                                            }}{{
                                                slotProps.data.programmes
                                                    .length > 1 &&
                                                index !==
                                                    slotProps.data.programmes
                                                        .length -
                                                        1
                                                    ? ", "
                                                    : null
                                            }}</span
                                        >
                                    </div>
                                </template>
                            </Column>

                            <Column
                                header="Action"
                                :headerStyle="{ width: '25%' }"
                            >
                                <template #body="slotProps">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        style="align-self: center"
                                        @click="
                                            editProgrammeCategory(
                                                slotProps.data,
                                                slotProps.index
                                            )
                                        "
                                    >
                                        <i class="ni ni-note"></i>
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        style="align-self: center"
                                        @click="
                                            removeProgrammeCategory(
                                                slotProps.data
                                            )
                                        "
                                    >
                                        <i class="ni ni-close"></i>
                                    </button>
                                </template>
                            </Column>
                        </DataTable>
                        <h5 class="pt-5">
                            Candidates for {{ slotProps.data.name }}
                        </h5>
                        <DataTable
                            :value="slotProps.data.candidates"
                            class="p-datatable-striped"
                            style="width: 100%"
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
                                :headerStyle="{ width: '12%' }"
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
                                :headerStyle="{ width: '20%' }"
                                sortable
                            ></Column>
                            <Column
                                field="tagline"
                                header="Tagline"
                                :headerStyle="{ width: '33%' }"
                            ></Column>
                            <Column
                                header="Action"
                                :headerStyle="{ width: '27%' }"
                            >
                                <template #body="slotProps">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        style="align-self: center"
                                        @click="editCandidate(slotProps.data)"
                                    >
                                        <i class="ni ni-note"></i>
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        style="align-self: center"
                                        @click="
                                            removeCandidate(
                                                slotProps.data,
                                                slotProps.index
                                            )
                                        "
                                    >
                                        <i class="ni ni-trash"></i>
                                    </button>
                                </template>
                            </Column>
                        </DataTable>

                        <button
                            type="submit"
                            class="btn btn-primary align-self-lg-end mt-4"
                            @click="addCandidate(slotProps.data.index)"
                        >
                            Register New Candidate
                        </button>
                    </div>
                </template>
            </DataTable>

            <Dialog
                v-if="
                    selectedProgrammeCategory &&
                    selectedProgrammeCategory !== null
                "
                :header="
                    selectedProgrammeCategory
                        ? `${selectedProgrammeCategory.name}`
                        : null
                "
                :visible.sync="displayProgrammeCategoryDetails"
                :maximizable="true"
                :modal="true"
            >
                <!-- Dialog must have default content -->
                <h3>Programmes</h3>
                <ol>
                    <li
                        v-for="programme in selectedProgrammeCategory.programmes"
                        :key="programme.id"
                    >
                        {{ `(${programme.code}) ${programme.name}` }}
                    </li>
                </ol>
                <template #footer>
                    <Button
                        :disabled="is_loading_update"
                        label="Close"
                        @click="closeProgrammeCategoryDetails"
                        class="p-button-text"
                    />
                </template>
            </Dialog>
            <Dialog
                v-if="selectedCandidate && selectedCandidate !== null"
                :header="
                    selectedCandidate
                        ? `${selectedCandidate.students_name} (${selectedCandidate.students_id})`
                        : null
                "
                :visible.sync="displayCandidateDetails"
                :maximizable="true"
                :modal="true"
            >
                <picture-input
                    ref="pictureInput"
                    @change="onChangeUpdateStudentImage"
                    width="200"
                    height="257"
                    margin="16"
                    size="5"
                    :prefill="
                        selectedCandidate.image &&
                        selectedCandidate.image !== ''
                            ? selectedCandidate.image
                            : null
                    "
                    buttonClass="btn btn-primary"
                    :customStrings="{
                        upload: '<h1>Bummer!</h1>',
                        drag: 'Drag a jpeg/png here or click here to browse an image',
                    }"
                >
                </picture-input>
                <h3>Tagline</h3>
                <Textarea
                    v-model="selectedCandidate.tagline"
                    :autoResize="true"
                    rows="5"
                    cols="50"
                />
                <template #footer>
                    <Button
                        :disabled="is_loading_update"
                        label="No"
                        icon="pi pi-times"
                        @click="closeCandidateDetails"
                        class="p-button-text"
                    />
                    <Button
                        :disabled="is_loading_update"
                        label="Update"
                        icon="pi pi-check"
                        @click="updateCandidateDetails"
                        autofocus
                    />
                </template>
            </Dialog>

            <Dialog
                header="Register Candidate"
                :visible.sync="displayCandidateStore"
                :maximizable="true"
                :modal="true"
            >
                <div style="display: flex; flex-direction: column" class="mb-4">
                    <label for="student_id"><h3>Student ID</h3></label>
                    <InputText
                        :class="{ 'mb-4': !error.newStudent_id.status }"
                        id="student_id"
                        v-model="newStudent.id"
                        optionLabel="student"
                    />
                    <span
                        ><small
                            v-if="error.newStudent_id.status"
                            class="text-danger mb-4"
                            >{{
                                error.newStudent_id.message
                                    ? error.newStudent_id.message
                                    : "Student id must have 10 characters!"
                            }}</small
                        ></span
                    >
                    <label for="student_id"><h3>Name</h3></label>

                    <span
                        class="p-input-icon-right"
                        style="display: flex; flex-direction: column"
                    >
                        <i
                            class="pi pi-spin pi-spinner"
                            v-if="is_loading_find_student"
                        />
                        <InputText
                            :disabled="true"
                            type="text"
                            id="student_name"
                            v-model="newStudent.name"
                            optionLabel="student"
                        />
                    </span>
                </div>
                <picture-input
                    ref="pictureInput2"
                    @change="onChangeNewStudentImage"
                    width="200"
                    height="257"
                    margin="16"
                    size="5"
                    buttonClass="btn btn-primary"
                    :customStrings="{
                        upload: '<h1>Bummer!</h1>',
                        drag: 'Drag a jpeg/png here or click here to browse an image',
                    }"
                >
                </picture-input>
                <h3 class="mt-4">Tagline</h3>
                <Textarea
                    v-model="newStudent.tagline"
                    :autoResize="true"
                    rows="5"
                    cols="50"
                />
                <template #footer>
                    <Button
                        label="No"
                        icon="pi pi-times"
                        @click="closeCandidateStore"
                        class="p-button-text"
                    />
                    <Button
                        :disabled="
                            error.newStudent_id.status && newStudent.id !== ''
                        "
                        label="Register"
                        icon="pi pi-check"
                        @click="storeCandidate"
                        autofocus
                    />
                </template>
            </Dialog>
            <ConfirmDialog></ConfirmDialog>
        </div>
    </div>
</template>

<script>
import ConfirmDialog from "primevue/confirmdialog";
import Textarea from "primevue/textarea";
import PictureInput from "vue-picture-input";
import InputNumber from "primevue/inputnumber";
import InputText from "primevue/inputtext";
import Calendar from "primevue/calendar";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import moment from "moment";
export default {
    name: "ManagementPlatform",
    components: {
        Calendar,
        InputText,
        DataTable,
        Column,
        Dialog,
        Button,
        PictureInput,
        Textarea,
        InputNumber,
        ConfirmDialog,
    },
    data() {
        return {
            newStudent: {
                voting_session_id: null,
                id: "",
                name: "",
                tagline: "",
            },
            selectedStudent: null,
            students: [],
            displayCandidateDetails: false,
            session: "",
            vote_datetime_start: null,
            vote_datetime_end: null,
            candidate_categories: [],
            expandedRows: [],
            selectedCandidate: null,
            selectedProgrammeCategory: null,
            displayCandidateStore: false,
            displayProgrammeCategoryDetails: false,
            tagline: null,
            completionImage: null,
            is_loading_update: false,
            is_loading_find_student: false,
            candidate_category_registration_index: null,
            error: {
                newStudent_id: { status: false, message: null },
            },
        };
    },

    watch: {
        "newStudent.id": function (newVal) {
            if (newVal.length === 10) {
                this.is_loading_find_student = true;
                this.error.newStudent_id.status = false;
                this.error.newStudent_id.message = null;
                console.log("find student with id:" + newVal);

                axios
                    .get(`/students/${newVal}`)
                    .then((response) => {
                        this.is_loading_find_student = false;
                        console.log(response.data.message);
                        if (response.data.success) {
                            let student = response.data.data;
                            this.newStudent.id = student.students_id;
                            this.newStudent.name = student.students_name;
                            this.error.newStudent_id.status = false;
                            this.error.newStudent_id.message = null;
                        }
                    })
                    .catch((error) => {
                        this.is_loading_find_student = false;
                        this.newStudent.name = null;
                        this.error.newStudent_id.status = true;
                        this.error.newStudent_id.message =
                            error.response.data.message;
                    });
            } else {
                this.error.newStudent_id.status = true;
                console.log("Student id must have length of 10 characters");
            }
        },
    },

    mounted() {
        this.newStudent.voting_session_id = this.$route.params.session_id;
        axios
            .get(`/vote-sessions/${this.$route.params.session_id}`)
            .then((response) => {
                let session = response.data.data;
                this.session = session.session;
                this.vote_datetime_start = moment(
                    String(session.vote_datetime_start)
                ).format("DD-MM-YYYY HH:mm");
                this.vote_datetime_end = moment(
                    String(session.vote_datetime_end)
                ).format("DD-MM-YYYY HH:mm");

                session.candidate_categories.forEach(async (x) => {
                    x.candidates.forEach(async (y, index) => {
                        if (y.image !== null && y.image !== "") {
                            x.candidates[index].image = await this.getImage(
                                y.image
                            );
                        }
                    });
                });
                this.candidate_categories = session.candidate_categories.map(
                    (x, index) => {
                        x.candidates = x.candidates.map((y) => {
                            return { ...y, candidate_category_index: index };
                        });
                        x.programme_categories = x.programme_categories.map(
                            (y) => {
                                return {
                                    ...y,
                                    candidate_category_index: index,
                                    candidate_category_id: x.id,
                                };
                            }
                        );
                        return { ...x, index: index };
                    }
                );
            });
    },

    methods: {
        storeCandidate() {
            console.log(this.newStudent);
            axios
                .post(`/candidate-relevant/add`, this.newStudent)
                .then(async (response) => {
                    let candidate = response.data.data;
                    candidate.candidate_category_index =
                        this.candidate_category_registration_index;

                    if (candidate.image !== null && candidate.image !== "") {
                        candidate.image = await this.getImage(candidate.image);
                    }
                    this.candidate_categories[
                        this.candidate_category_registration_index
                    ].candidates.push(candidate);
                    this.closeCandidateStore();
                })
                .catch((error) => {
                    this.is_loading_find_student = false;
                    this.newStudent.name = null;
                    this.error.newStudent_id.status = true;
                    this.error.newStudent_id.message =
                        error.response.data.message;
                });
        },
        onChangeUpdateStudentImage(image) {
            if (image) {
                console.log("Picture loaded.");
                this.completionImage = image;
            } else {
                console.log(
                    "FileReader API not supported: use the <form>, Luke!"
                );
            }
        },

        onChangeNewStudentImage(image) {
            if (image) {
                console.log("Picture loaded.");
                this.newStudent.image = image;
            } else {
                console.log(
                    "FileReader API not supported: use the <form>, Luke!"
                );
            }
        },
        openProgrammeCategoryDetails() {
            this.displayProgrammeCategoryDetails = true;
        },
        openCandidateDetails() {
            this.displayCandidateDetails = true;
        },
        openCandidateStore() {
            this.displayCandidateStore = true;
        },
        closeProgrammeCategoryDetails() {
            this.displayProgrammeCategoryDetails = false;
        },
        closeCandidateDetails() {
            this.completionImage = null;
            this.displayCandidateDetails = false;
        },
        closeCandidateStore() {
            this.completionImage = null;
            this.displayCandidateStore = false;
        },
        updateCandidateDetails() {
            this.is_loading_update = true;
            axios
                .post("/candidate-relevant/update", {
                    payload: {
                        student_id: this.selectedCandidate.student_id,
                        voting_session_id: this.$route.params.session_id,
                        image: this.completionImage,
                        tagline: this.selectedCandidate.tagline,
                    },
                })
                .then((response) => {
                    console.log(response);
                    this.is_loading_update = false;
                    if (this.completionImage !== null) {
                        this.selectedCandidate.image = this.completionImage;
                    }
                    this.closeCandidateDetails();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: "Fail to submit vote.",
                        life: 3000,
                    });
                    this.is_loading_update = false;
                    this.closeCandidateDetails();
                });
        },
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

        editProgrammeCategory(programme_category, index) {
            this.selectedProgrammeCategory = programme_category;
            console.log("edit");
            this.openProgrammeCategoryDetails();
        },
        editCandidate(candidate) {
            console.log(candidate);
            this.selectedCandidate = candidate;
            this.openCandidateDetails();
        },
        removeProgrammeCategory(programme_category) {
            this.$confirm.require({
                message: `Do you want to drop this programme category from this voting? (${programme_category.name})`,
                header: "Drop Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    // student_id: this.selectedCandidate.student_id,
                    // voting_session_id: this.$route.params.session_id,
                    axios
                        .delete(
                            `/candidate-category-programme-category/${programme_category.candidate_category_id}/${programme_category.id}`
                        )
                        .then((response) => {
                            console.log(response);
                            let temp_candidate_category =
                                this.candidate_categories[
                                    programme_category.candidate_category_index
                                ];

                            temp_candidate_category.programme_categories =
                                temp_candidate_category.programme_categories.filter(
                                    (x) => {
                                        // console.log(
                                        //     x.candidate_category_id,
                                        //     "===",
                                        //     programme_category.candidate_category_id
                                        // );
                                        // console.log(
                                        //     x.id,
                                        //     "===",
                                        //     programme_category.id
                                        // );
                                        return !(
                                            x.candidate_category_id ===
                                                programme_category.candidate_category_id &&
                                            x.id === programme_category.id
                                        );
                                    }
                                );
                        })
                        .catch((error) => {
                            console.log(error);
                            // this.newStudent.name = null;
                            // this.error.newStudent_id.status = true;
                            // this.error.newStudent_id.message =
                            //     error.response.data.message;
                        });
                    this.$toast.add({
                        severity: "info",
                        summary: "Confirmed",
                        detail: "Remove candidate",
                        life: 3000,
                    });
                },
                reject: () => {
                    console.log("reject");
                },
            });
        },
        removeCandidate(candidate) {
            this.$confirm.require({
                message: `Do you want to remove this candidate? (${candidate.students_name})`,
                header: "Remove Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    // student_id: this.selectedCandidate.student_id,
                    // voting_session_id: this.$route.params.session_id,
                    axios
                        .delete(
                            `/candidate-relevant/${candidate.student_id}/${this.$route.params.session_id}`
                        )
                        .then((response) => {
                            let temp_candidate_category =
                                this.candidate_categories[
                                    candidate.candidate_category_index
                                ];

                            temp_candidate_category.candidates =
                                temp_candidate_category.candidates.filter(
                                    (x) => {
                                        return !(
                                            x.student_id ===
                                                candidate.student_id &&
                                            x.voting_session_id ===
                                                parseInt(
                                                    this.$route.params
                                                        .session_id
                                                )
                                        );
                                    }
                                );
                        })
                        .catch((error) => {
                            console.log(error);
                            this.is_loading_find_student = false;
                            this.newStudent.name = null;
                            this.error.newStudent_id.status = true;
                            this.error.newStudent_id.message =
                                error.response.data.message;
                        });
                    this.$toast.add({
                        severity: "info",
                        summary: "Confirmed",
                        detail: "Remove candidate",
                        life: 3000,
                    });
                },
                reject: () => {
                    console.log("reject");
                },
            });
        },
        addCandidate(index) {
            this.candidate_category_registration_index = index;
            this.openCandidateStore();
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
.p-inputtextarea {
    width: 100%;
}
.p-datatable-table {
    width: 100% !important;
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
