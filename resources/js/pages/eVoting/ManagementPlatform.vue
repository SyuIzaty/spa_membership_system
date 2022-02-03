<template>
    <div>
        <Toast
            position="top-right"
            :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
        />
        <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3 text-center">Session</div>
            <InputText v-model="session" class="col-12 col-lg-10" />
        </div>
        <div class="row pt-5 px-5 align-items-center">
            <div class="col-12 col-lg-2 h3 text-center">From</div>
            <!-- <Calendar
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_start"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_start"
            /> -->
            <input
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_start"
                v-model="vote_datetime_start"
                type="datetime-local"
                name="vote_datetime_start"
            />
            <div class="col-12 col-lg-2 h3 text-center">To</div>
            <!-- <Calendar
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_end"
                :minDate="new Date()"
                :manualInput="false"
                dateFormat="dd-mm-yy"
                :showTime="true"
                v-model="vote_datetime_end"
            /> -->

            <input
                class="col-12 col-lg-4 p-0"
                id="vote_datetime_end"
                v-model="vote_datetime_end"
                type="datetime-local"
                name="vote_datetime_end"
            />
        </div>

        <div
            class="row pt-5 px-5 align-items-center justify-content-center justify-content-lg-start"
        >
            <div class="col-12 col-lg-2 h3 text-center">Active</div>
            <InputSwitch v-model="is_active" />
        </div>

        <div class="row pt-5 px-5 align-items-center justify-content-end">
            <button
                type="submit"
                class="btn btn-success"
                style="align-self: center"
                @click="editSessionDetails()"
            >
                Save
            </button>
        </div>

        <div class="row p-5">
            <DataTable
                class="col-12 p-datatable-striped"
                :value="candidate_categories"
                :expandedRows.sync="expandedRows"
                dataKey="id"
                responsiveLayout="scroll"
                @row-expand="onRowExpand"
                @row-collapse="onRowCollapse"
                :loading="is_loading_candidate_categories"
            >
                <template #empty> No records found. </template>
                <template #header>
                    <div class="table-header-container">
                        <h1>Candidate Categories</h1>
                    </div>
                </template>
                <Column :expander="true" :headerStyle="{ width: '3rem' }" />
                <Column field="name" header="Name" sortable></Column>

                <Column header="Action" :headerStyle="{ width: '25%' }">
                    <template #body="slotProps">
                        <button
                            type="submit"
                            class="btn btn-primary"
                            style="align-self: center"
                            @click="
                                editCandidateCategory(
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
                                removeCandidateCategory(
                                    slotProps.data,
                                    slotProps.index
                                )
                            "
                        >
                            <i class="ni ni-close"></i>
                        </button>
                    </template>
                </Column>
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

                        <button
                            type="submit"
                            class="btn btn-primary align-self-lg-end mt-4"
                            @click="addProgrammeCategory(slotProps.data.index)"
                        >
                            Add a Programme Category
                        </button>
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
            <button
                type="submit"
                class="btn btn-primary align-self-lg-end mt-4"
                style="width: 100%"
                @click="openCreateCandidateCategory()"
            >
                Create New Category
            </button>
            <Dialog
                header="Create Candidate Category"
                :visible.sync="displayCreateCandidateCategory"
                :modal="true"
                ><div style="display: flex; flex-direction: column">
                    <label for="name"><h3>Candidate Category Name</h3></label>
                    <InputText
                        id="name"
                        v-model="new_candidate_category.name"
                    />
                </div>
                <template #footer>
                    <Button
                        label="Close"
                        icon="pi pi-times"
                        @click="closeCreateCandidateCategory"
                        class="p-button-text"
                    />
                    <Button
                        label="Update"
                        icon="pi pi-check"
                        @click="storeCandidateCategory"
                        autofocus
                    />
                </template>
            </Dialog>
            <Dialog
                header="Edit Candidate Category"
                :visible.sync="displayEditCandidateCategory"
                :modal="true"
                ><div style="display: flex; flex-direction: column">
                    <label for="name"><h3>Candidate Category Name</h3></label>
                    <InputText
                        id="name"
                        v-model="selected_candidate_category.name"
                    />
                </div>
                <template #footer>
                    <Button
                        label="Close"
                        icon="pi pi-times"
                        @click="closeCandidateCategory"
                        class="p-button-text"
                    />
                    <Button
                        label="Update"
                        icon="pi pi-check"
                        @click="updateCandidateCategory"
                        autofocus
                    />
                </template>
            </Dialog>
            <Dialog
                header="Add Programme Category"
                :visible.sync="displayProgrammeCategoryStore"
                :maximizable="true"
                :modal="true"
                contentStyle="
                min-height:25rem;
                min-width:25rem;
                display:flex;
                flex-direction:column;
                justify-content:space-around;
                padding:1rem 1rem 1rem 1rem;"
            >
                <Button
                    v-for="(
                        programme_category, index
                    ) in filtered_programme_categories"
                    :key="programme_category.id"
                    @click="
                        addProgrammeCategoryToCandidateCategory(
                            programme_category,
                            index
                        )
                    "
                >
                    {{ programme_category.short_name }} -
                    {{ truncateString(programme_category.name, 75) }}
                </Button>
                <div
                    v-if="filtered_programme_categories.length === 0"
                    style="text-align: center"
                >
                    No available category
                </div>
            </Dialog>
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
                contentStyle="min-height:25rem;"
            >
                <!-- Dialog must have default content -->
                <h3>Programmes</h3>
                <ol>
                    <li
                        v-for="programme in selectedProgrammeCategory.programmes"
                        :key="programme.id"
                    >
                        {{
                            `(${programme.code}) ${truncateString(
                                programme.name,
                                75
                            )}`
                        }}

                        <i
                            @click="
                                dropRevertProgramme(
                                    programme.id,
                                    programme.programme_category_id
                                )
                            "
                            :class="{
                                'ni ni-close text-danger':
                                    programme.programme_category_id !== null,
                                'ni ni-action-undo text-success':
                                    programme.programme_category_id === null,
                            }"
                            style="cursor: pointer"
                        ></i>
                    </li>
                    <li v-if="programmes.length > 0">
                        <Dropdown
                            v-model="selectedProgramme"
                            :options="programmes"
                            optionLabel="code"
                            :filter="true"
                            placeholder="Select a Programme"
                            :showClear="false"
                            @change="addProgramme($event)"
                        >
                            <template #value="slotProps">
                                <span>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div>
                                    {{ slotProps.option.code }} -
                                    {{
                                        truncateString(
                                            slotProps.option.name,
                                            40
                                        )
                                    }}
                                </div>
                            </template>
                        </Dropdown>
                    </li>
                </ol>
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
import Dropdown from "primevue/dropdown";
import InputSwitch from "primevue/inputswitch";
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
        Dropdown,
        InputSwitch,
    },
    data() {
        return {
            newStudent: {
                voting_session_id: null,
                id: "",
                name: "",
                tagline: "",
            },
            is_active: false,
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
            selectedNewProgrammeCategory: null,
            selectedProgramme: null,
            programmes: [],
            programme_categories: [],
            displayEditCandidateCategory: false,
            displayCandidateStore: false,
            displayProgrammeCategoryDetails: false,
            tagline: null,
            completionImage: null,
            is_loading_update: false,
            is_loading_find_student: false,
            is_loading_candidate_categories: false,
            candidate_category_index: null,
            candidate_category_registration_index: null,
            displayProgrammeCategoryStore: false,
            displayCreateCandidateCategory: false,
            error: {
                newStudent_id: { status: false, message: null },
                category: { name: false },
            },
            selected_candidate_category: {
                name: "",
            },
            new_candidate_category: {
                name: "",
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
    computed: {
        filtered_programme_categories() {
            // this.candidate_categories[candidate_category_index];
            console.log("Params:", Number(this.$route.params.session_id));
            return this.programme_categories.filter((x) =>
                x.candidate_category_programme_category_s.find(
                    (y) =>
                        y.candidate_category.voting_session_id ===
                        Number(this.$route.params.session_id)
                )
                    ? false
                    : true
            );
        },
    },
    mounted() {
        this.newStudent.voting_session_id = Number(
            this.$route.params.session_id
        );
        this.is_loading_candidate_categories = true;
        axios
            .get(`/e-voting/programme-categories`)
            .then((response) => {
                this.programme_categories = response.data.data;
            })
            .catch((error) => {
                console.log(error);
            });
        axios
            .get(`/vote-sessions/${Number(this.$route.params.session_id)}`)
            .then((response) => {
                let session = response.data.data;
                this.session = session.session;
                this.vote_datetime_start = moment(
                    String(session.vote_datetime_start)
                ).format("YYYY-MM-DDTHH:mm");
                this.vote_datetime_end = moment(
                    String(session.vote_datetime_end)
                ).format("YYYY-MM-DDTHH:mm");
                this.is_active = session.is_active === 1 ? true : false;

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
                this.is_loading_candidate_categories = false;
            })
            .catch((err) => {
                console.log(err);
                this.is_loading_candidate_categories = false;
            });
    },

    methods: {
        openCreateCandidateCategory() {
            this.displayCreateCandidateCategory = true;
        },
        closeCreateCandidateCategory() {
            this.displayCreateCandidateCategory = false;
        },
        storeCandidateCategory() {
            axios
                .post(`/e-voting/candidate-category`, {
                    name: this.new_candidate_category.name,
                    voting_session_id: Number(this.$route.params.session_id),
                })
                .then((response) => {
                    this.candidate_categories.push({
                        ...response.data.data,
                        index: this.candidate_categories.length,
                    });

                    this.$toast.add({
                        severity: "success",
                        summary: "Submitted",
                        detail: "Candidate category updated successfully",
                        life: 3000,
                    });
                    this.is_loading = false;
                    this.closeCreateCandidateCategory();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: "Fail to update candidate category.",
                        life: 3000,
                    });
                    this.is_loading = false;
                });
        },
        updateCandidateCategory() {
            this.is_loading = true;

            let candidate_category =
                this.candidate_categories[this.candidate_category_index];
            axios
                .post(`/e-voting/candidate-category/${candidate_category.id}`, {
                    name: this.selected_candidate_category.name,
                })
                .then((response) => {
                    candidate_category.name =
                        this.selected_candidate_category.name;
                    this.$toast.add({
                        severity: "success",
                        summary: "Submitted",
                        detail: "Candidate category updated successfully",
                        life: 3000,
                    });
                    this.is_loading = false;
                    this.closeCandidateCategory();
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: "Fail to update candidate category.",
                        life: 3000,
                    });
                    this.is_loading = false;
                });
            console.log("Update Candidate Category");
        },
        closeCandidateCategory() {
            this.displayEditCandidateCategory = false;
        },
        editCandidateCategory(data, index) {
            this.displayEditCandidateCategory = true;
            this.selected_candidate_category.name = data.name;
            this.candidate_category_index = index;
            console.log("Edit Candidate Category");
        },
        removeCandidateCategory(data, index) {
            console.log("Remove Candidate Category");
            this.$confirm.require({
                message: `Do you want to drop this candidate category from this session? (${data.name})`,
                header: "Drop Confirmation",
                icon: "pi pi-info-circle",
                acceptClass: "p-button-danger",
                accept: () => {
                    // student_id: this.selectedCandidate.student_id,
                    // voting_session_id: Number(this.$route.params.session_id),
                    axios
                        .delete(`/e-voting/candidate-category/${data.id}`)
                        .then((response) => {
                            console.log(response);
                            this.candidate_categories.splice(index, 1);
                            this.$toast.add({
                                severity: "success",
                                summary: "Drop Candidate Category",
                                detail: "Candidate category has been dropped successfully",
                                life: 3000,
                            });
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toast.add({
                                severity: "error",
                                summary: "Error Message",
                                detail: "Fail to drop candidate category.",
                                life: 3000,
                            });
                        });
                    this.$toast.add({
                        severity: "info",
                        summary: "Confirmed",
                        detail: "Unattached Programme Category",
                        life: 3000,
                    });
                },
                reject: () => {
                    console.log("reject");
                },
            });
        },
        editSessionDetails() {
            console.log("edit session");
            let session_id = Number(this.$route.params.session_id);
            axios
                .post(`/e-voting/session/${session_id}`, {
                    session: this.session,
                    vote_datetime_start: moment(
                        String(this.vote_datetime_start),
                        "YYYY-MM-DD HH:mm"
                    ).format("YYYY-MM-DD HH:mm:ss"),
                    vote_datetime_end: moment(
                        String(this.vote_datetime_end),
                        "YYYY-MM-DD HH:mm"
                    ).format("YYYY-MM-DD HH:mm:ss"),

                    is_active: this.is_active ? 1 : 0,
                })
                .then((response) => {
                    this.$toast.add({
                        severity: "success",
                        summary: "Updated!",
                        detail: "The session details have been updated!",
                        life: 3000,
                    });
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error Message",
                        detail: "Failed to update session details",
                        life: 3000,
                    });
                });
        },
        addProgrammeCategoryToCandidateCategory(programme_category, index) {
            axios
                .post(`/e-voting/candidate-categories-programme-categories`, {
                    programme_category_id: programme_category.id,
                    candidate_category_id:
                        this.candidate_categories[this.candidate_category_index]
                            .id,
                })
                .then((response) => {
                    console.log(response);
                    let programme_category_res = response.data.data;
                    let programme_categories_temp =
                        this.candidate_categories[this.candidate_category_index]
                            .programme_categories;
                    programme_categories_temp.push({
                        ...programme_category_res,
                        candidate_category_id:
                            this.candidate_categories[
                                this.candidate_category_index
                            ].id,
                        candidate_category_index: this.candidate_category_index,
                        // programme_categories_temp.length,
                    });

                    this.filtered_programme_categories.splice(index, 1);
                    this.displayProgrammeCategoryStore = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        truncateString(input, maxCharacters) {
            if (input.length > maxCharacters) {
                return input.substring(0, maxCharacters) + "...";
            }
            return input;
        },
        addProgramme($event) {
            let programme_temp = $event.value;
            if (programme_temp.programme_category_id !== null) {
                const programme_name = this.programme_categories.find(
                    (x) => x.id === programme_temp.programme_category_id
                ).name;
                this.$confirm.require({
                    message: `This programme is currently under the programme category with id ${programme_temp.id} (${programme_name}).\n
                Are you sure to change it to programme category with id ${this.selectedProgrammeCategory.id} (${this.selectedProgrammeCategory.name})?`,
                    header: "Change programme category confirmation",
                    icon: "pi pi-info-circle",
                    acceptClass: "p-button-danger",
                    accept: () => {
                        axios
                            .post(`/e-voting/programmes/${programme_temp.id}`, {
                                programme_category_id:
                                    this.selectedProgrammeCategory.id,
                            })
                            .then((response) => {
                                console.log(response.data.data);
                                let programme = response.data.data;
                                this.candidate_categories[
                                    this.selectedProgrammeCategory
                                        .candidate_category_index
                                ].programme_categories
                                    .find((x) => {
                                        return (
                                            x.id ===
                                            this.selectedProgrammeCategory.id
                                        );
                                    })
                                    .programmes.push(programme);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },
                    reject: () => {
                        this.selectedProgramme = null;
                        console.log("reject");
                    },
                });
            } else {
                axios
                    .post(`/e-voting/programmes/${programme_temp.id}`, {
                        programme_category_id:
                            this.selectedProgrammeCategory.id,
                    })
                    .then((response) => {
                        console.log(response.data.data);
                        let programme = response.data.data;
                        this.candidate_categories[
                            this.selectedProgrammeCategory
                                .candidate_category_index
                        ].programme_categories
                            .find((x) => {
                                return (
                                    x.id === this.selectedProgrammeCategory.id
                                );
                            })
                            .programmes.push(programme);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        dropRevertProgramme(programme_id, programme_category_id) {
            let payload_programme_category_id =
                programme_category_id !== null
                    ? null
                    : this.selectedProgrammeCategory.id;
            axios
                .post(`/e-voting/programmes/${programme_id}`, {
                    programme_category_id: payload_programme_category_id,
                })
                .then((response) => {
                    let programme = response.data.data;
                    this.candidate_categories[
                        this.selectedProgrammeCategory.candidate_category_index
                    ].programme_categories
                        .find((x) => {
                            return programme_category_id !== null
                                ? x.id === programme_category_id
                                : x.id === this.selectedProgrammeCategory.id;
                        })
                        .programmes.find(
                            (x) => x.id === programme.id
                        ).programme_category_id =
                        programme.programme_category_id;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        storeCandidate() {
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
        openProgrammeCategoryStore() {
            this.displayProgrammeCategoryStore = true;
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
        closeProgrammeCategoryStore() {
            this.displayProgrammeCategoryStore = false;
        },
        updateCandidateDetails() {
            this.is_loading_update = true;
            axios
                .post("/candidate-relevant/update", {
                    payload: {
                        student_id: this.selectedCandidate.student_id,
                        voting_session_id: Number(
                            this.$route.params.session_id
                        ),
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
                summary: "Category Expanded",
                detail: event.data.name,
                life: 3000,
            });
        },
        onRowCollapse(event) {
            this.$toast.add({
                severity: "info",
                summary: "Category Collapsed",
                detail: event.data.name,
                life: 3000,
            });
        },

        editProgrammeCategory(programme_category, index) {
            this.selectedProgrammeCategory = programme_category;
            console.log("edit");
            if (this.programmes.length === 0) {
                axios
                    .get("/e-voting/programmes")
                    .then((response) => {
                        this.programmes = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
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
                    // voting_session_id: Number(this.$route.params.session_id),
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

                            let temp_programme_category =
                                this.programme_categories.find(
                                    (x) => x.id === programme_category.id
                                );
                            temp_programme_category.candidate_category_programme_category_s.length = 0;
                            this.filtered_programme_categories.push(
                                temp_programme_category
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
                        detail: "Unattached Programme Category",
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
                    // voting_session_id: Number(this.$route.params.session_id),
                    axios
                        .delete(
                            `/candidate-relevant/${
                                candidate.student_id
                            }/${Number(this.$route.params.session_id)}`
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
        addProgrammeCategory(index) {
            this.candidate_category_index = index;
            this.openProgrammeCategoryStore();
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
.p-dialog {
    min-width: 50%;
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
