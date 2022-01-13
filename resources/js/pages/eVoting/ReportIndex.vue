<template>
    <div>
        <center class="mb-5">
            <img src="../../assets/logo_primary_2.png" style="height: 100px" />
        </center>
        <h4 class="mb-5" style="text-align: center">
            <b>Campus General Election Report</b>
        </h4>
        <Fieldset legend="Kumpulan Teknikal Jepun (KTJ)" :toggleable="false">
            The story begins as Don Vito Corleone, the head of a New York Mafia
            family, oversees his daughter's wedding. His beloved son Michael has
            just come home from the war, but does not intend to become part of
            his father's business. Through Michael's life the nature of the

            <Divider align="left" type="dashed">
                <b>General Information</b>
            </Divider>
            Total Students: 1000 persons<br />
            Total Turnout: 800 persons (80%)

            <Divider align="left" type="dashed">
                <b>Candidate Information</b>
            </Divider>
            Candidate 1: Nur Arif Husaini Bin Norwaza, 25 (Klang)
            <div class="row" style="justify-content: space-around">
                <table class="col-12 col-md-5 my-3">
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Gender
                        </th>
                        <td>Male</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Phone
                        </th>
                        <td>013-636 2353</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Email
                        </th>
                        <td>chemist.arif.husaini@gmail.com</td>
                    </tr>
                </table>
                <table class="col-12 col-md-5 my-3">
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Program
                        </th>
                        <td>
                            Foundation of Information and Communication
                            Technology (ICT)
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Semester
                        </th>
                        <td>6 (Total Semester: 7)</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            CGPA/Point
                        </th>
                        <td>3.61</td>
                    </tr>
                </table>
            </div>
            Candidate 2: Syazwani Binti Kamarul, 25 (KL)
            <div class="row" style="justify-content: space-around">
                <table class="col-12 col-md-5 my-3">
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Gender
                        </th>
                        <td>Female</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Phone
                        </th>
                        <td>013-636 2353</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Email
                        </th>
                        <td>chemist.arif.husaini@gmail.com</td>
                    </tr>
                </table>
                <table class="col-12 col-md-5 my-3">
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Program
                        </th>
                        <td>
                            Foundation of Information and Communication
                            Technology (ICT)
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            Semester
                        </th>
                        <td>6 (Total Semester: 7)</td>
                    </tr>
                    <tr>
                        <th class="bg-primary text-white" style="width: 20%">
                            CGPA/Point
                        </th>
                        <td>3.61</td>
                    </tr>
                </table>
            </div>
            <Divider align="left" type="dashed">
                <b>Result</b>
            </Divider>
            The result of the election is as listed below,
            <ol>
                <li>
                    <b>
                        Nur Arif Husaini Bin Norwaza:
                        <span class="text-success"> 100 Vote </span></b
                    >
                    (80% Male, 20% Female)
                </li>
                <li>
                    <b>
                        Syazwani Binti Kamarul:
                        <span class="text-success"> 80 Vote </span></b
                    >
                    (20% Male, 80% Female)
                </li>
            </ol>
        </Fieldset>
    </div>
</template>

<script>
import Fieldset from "primevue/fieldset";
import Divider from "primevue/divider";
export default {
    name: "ReportIndex",
    components: { Fieldset, Divider },
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
