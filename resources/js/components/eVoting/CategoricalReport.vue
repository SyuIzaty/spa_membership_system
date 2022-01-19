<template>
    <div>
        <Fieldset :legend="custom_name" :toggleable="false">
            {{ description }}

            <Divider align="left" type="dashed">
                <b>General Information</b>
            </Divider>
            Total Students: {{ total_students }} persons<br />
            Total Turnouts: {{ total_turnouts }} persons ({{
                Math.round(
                    ((total_turnouts / total_students) * 100 + Number.EPSILON) *
                        100
                ) / 100
            }}%)<br />
            Total Not Turnouts: {{ total_not_turnouts }} persons ({{
                Math.round(
                    ((total_not_turnouts / total_students) * 100 +
                        Number.EPSILON) *
                        100
                ) / 100
            }}%)

            <Divider align="left" type="dashed">
                <b>Candidate Information</b>
            </Divider>

            <div v-if="candidates.length > 0">
                <div
                    v-for="(candidate, index) in candidates"
                    :key="candidate.id"
                >
                    Candidate {{ index + 1 }}: {{ candidate.name }}
                    {{ candidate.age !== null ? ", " + candidate.age : null }}
                    {{
                        candidate.origin !== null
                            ? `(${candidate.origin})`
                            : null
                    }}
                    <div class="row" style="justify-content: space-around">
                        <table class="col-12 col-md-5 my-3">
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 20%"
                                >
                                    Gender
                                </th>
                                <td>
                                    {{
                                        candidate.gender !== null
                                            ? candidate.gender
                                            : "-"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 20%"
                                >
                                    Phone
                                </th>
                                <td>
                                    {{
                                        candidate.phone !== null
                                            ? candidate.phone
                                            : "-"
                                    }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 20%"
                                >
                                    Email
                                </th>
                                <td>
                                    {{
                                        candidate.email !== null
                                            ? candidate.email
                                            : "-"
                                    }}
                                </td>
                            </tr>
                        </table>
                        <table class="col-12 col-md-5 my-3">
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 35%"
                                >
                                    Program
                                </th>
                                <td>
                                    {{ candidate.programme }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 35%"
                                >
                                    Semester
                                </th>
                                <td>
                                    {{ candidate.current_semester }}
                                    <!-- (Total
                                Semester: {{ candidate.total_semester }}) -->
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="bg-primary text-white"
                                    style="width: 35%"
                                >
                                    Student ID
                                </th>
                                <td>{{ candidate.student_id }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center" v-else>There is no candidates</div>
            <Divider align="left" type="dashed">
                <b>Result</b>
            </Divider>

            <div v-if="candidates.length > 0">
                The result of the election is as listed below,
                <ol>
                    <li v-for="candidate in candidates" :key="candidate.id">
                        <b>
                            {{ candidate.name }}:
                            <span class="text-success">
                                {{ candidate.total_vote }} Vote
                            </span></b
                        >
                        <!-- (80% Male, 20% Female) -->
                    </li>
                </ol>
            </div>
            <div class="text-center" v-else>There is no candidates</div>
        </Fieldset>
    </div>
</template>

<script>
import Fieldset from "primevue/fieldset";
import Divider from "primevue/divider";
export default {
    name: "CategoricalReport",
    components: { Fieldset, Divider },
    props: {
        name: {
            type: String,
            required: true,
            default: "",
        },
        description: {
            type: String,
            required: true,
            default: "",
        },
        total_students: {
            type: Number,
            required: true,
            default: 0,
        },
        total_turnouts: {
            type: Number,
            required: true,
            default: 0,
        },
        total_not_turnouts: {
            type: Number,
            required: true,
            default: 0,
        },
        programme_categories_name: {
            type: Array,
            required: true,
            default: () => {},
        },
        candidates: {
            type: Array,
            required: true,
            default: () => {},
        },
    },
    computed: {
        custom_name() {
            var name = this.name + " (";
            const count_programme_category =
                this.programme_categories_name.length;
            this.programme_categories_name.forEach((x, index) => {
                name += x;
                if (index < count_programme_category - 1) {
                    name += " & ";
                }
            });
            name += ")";
            return name;
        },
    },
};
</script>

<style lang="scss" scoped>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td,
th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
