$(document).ready(function () {
    var increment = 0;
    $(".tambah-qualification").click(function (e) {
        e.preventDefault();

        var x = $("#qualification :selected").text();
        var xval = $("#qualification :selected").val();
        if (x == "SPM") {
            let spmlistarr = [];
            for (let i = 0; i < listSPM.length; i++) {
                spmlistarr.push(
                    '<option value="' +
                        listSPM[i][0] +
                        '">' +
                        listSPM[i][1] +
                        "</option>"
                );
            }
            let spmgredlistarr = [];
            for (let i = 0; i < listGradeSPM.length; i++) {
                spmgredlistarr.push(
                    '<option value="' +
                        listGradeSPM[i][0] +
                        '">' +
                        listGradeSPM[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("spm-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper spm-field" id="spm-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Pelajaran Malaysia <button class="btn btn-primary float-right" id="addspmrow" onclick="addRow();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="spm-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="spm_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="spm_subject[]" required>' +
                        spmlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="spm_grade_id[]" required>' +
                        spmgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                        Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }

        else if (x == 'UEC'){
            let ueclistarr = [];
            for (let i =0; i < listUEC.length; i++){
                ueclistarr.push(
                    '<option value="' +
                        listUEC[i][0] +
                        '">' +
                        listUEC[i][1] +
                        "</option>"
                );
            }
            let uecgredlistarr = [];
            for (let i = 0; i < listGradeUEC.length; i++) {
                uecgredlistarr.push(
                    '<option value="' +
                        listGradeUEC[i][0] +
                        '">' +
                        listGradeUEC[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("uec-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper uec-field" id="uec-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">UEC <button class="btn btn-primary float-right" id="adduecrow" onclick="addRowUec();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="uec-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="uec_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="uec_subject[]" required>' +
                        ueclistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="uec_grade_id[]" required>' +
                        uecgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                       Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }

        else if(x == 'STPM'){
            let stpmlistarr = [];
            for (let i = 0; i < listSTPM.length; i++) {
                stpmlistarr.push(
                    '<option value="' +
                        listSTPM[i][0] +
                        '">' +
                        listSTPM[i][1] +
                        "</option>"
                );
            }
            let stpmgredlistarr = [];
            for (let i = 0; i < listGradeSTPM.length; i++) {
                stpmgredlistarr.push(
                    '<option value="' +
                        listGradeSTPM[i][0] +
                        '">' +
                        listGradeSTPM[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("stpm-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper stpm-field" id="stpm-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Tinggi Pelajaran Malaysia <button class="btn btn-primary float-right" id="addstpmrow" onclick="addRowStpm();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="stpm-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="stpm_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="stpm_subject[]" required>' +
                        stpmlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="stpm_grade_id[]" required>' +
                        stpmgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                       Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }

        else if (x == 'O Level') {
            let olevellistarr = [];
            for (let i =0; i < listOLEVEL.length; i++) {
                olevellistarr.push(
                    '<option value="' +
                        listOLEVEL[i][0] +
                        '">' +
                        listOLEVEL[i][1] +
                        "</option>"
                )
            }
            let olevelgredlistarr = [];
            for (let i = 0; i < listGradeOLEVEL.length; i++) {
                olevelgredlistarr.push(
                    '<option value="' +
                        listGradeOLEVEL[i][0] +
                        '">' +
                        listGradeOLEVEL[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("olevel-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper olevel-field" id="olevel-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">O Level <button class="btn btn-primary float-right" id="addolevelrow" onclick="addRowOlevel();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="olevel-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="olevel_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="olevel_subject[]" required>' +
                        olevellistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="olevel_grade_id[]" required>' +
                        olevelgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                       Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }

        else if (x == 'A Level') {
            let alevellistarr = [];
            for (let i = 0; i < listALEVEL.length; i++) {
                alevellistarr.push(
                    '<option value="' +
                        listALEVEL[i][0] +
                        '">' +
                        listALEVEL[i][1] +
                        "</option>"
                )
            }
            let alevelgredlistarr = [];
            for (let i = 0; i < listGradeALEVEL.length; i++) {
                alevelgredlistarr.push(
                    '<option value="' +
                        listGradeALEVEL[i][0] +
                        '">' +
                        listGradeALEVEL[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("alevel-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper alevel-field" id="alevel-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Tinggi Agama Malaysia <button class="btn btn-primary float-right" id="addalevelrow" onclick="addRowAlevel();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="alevel-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="alevel_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="alevel_subject[]" required>' +
                        alevellistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="alevel_grade_id[]" required>' +
                        alevelgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                       Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }

        else if (x == "STAM") {
            let stamlistarr = [];
            for (let i = 0; i < listSTAM.length; i++) {
                stamlistarr.push(
                    '<option value="' +
                        listSTAM[i][0] +
                        '">' +
                        listSTAM[i][1] +
                        "</option>"
                );
            }
            let stamgredlistarr = [];
            for (let i = 0; i < listGradeSTAM.length; i++) {
                stamgredlistarr.push(
                    '<option value="' +
                        listGradeSTAM[i][0] +
                        '">' +
                        listGradeSTAM[i][1] +
                        "</option>"
                );
            }
            var el2 = document.getElementById("stam-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper stam-field" id="stam-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Tinggi Agama Malaysia <button class="btn btn-primary float-right" id="addspmrow" onclick="addRowStam();return false;">Add Subject</button></h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="stam-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                    <input type="hidden" name="stam_type" value="' +
                        xval +
                        '">\
                                    <select class="form-control" name="stam_subject[]" required>' +
                        stamlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <select class="form-control" name="stam_grade_id[]" required>' +
                        stamgredlistarr.toString() +
                        '</select>\
                                </td>\
                                <td>\
                                    <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                                       Delete\
                                    </button>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "Bachelor") {
            var el = document.getElementById("bachelor-field");
            if (el != null) {
                alert("Bachelor qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper bachelor-field" id="bachelor-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Bachelor </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="bachelor-table">\
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="bachelor_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CGPA" name="bachelor_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "Diploma") {
            var el = document.getElementById("diploma-field");
            if (el != null) {
                alert("Diploma qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper diploma-field" id="diploma-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Diploma </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="diploma-table">\
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="diploma_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CGPA" name="diploma_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "Matriculation") {
            var el = document.getElementById("matriculation-field");
            if (el != null) {
                alert("Matriculation qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper matriculation-field" id="matriculation-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Matriculation </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="matriculation-table">\
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="matriculation_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CGPA" name="matriculation_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "MUET") {
            var el = document.getElementById("muet-field");
            if (el != null) {
                alert("MUET qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper muet-field" id="muet-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">MUET </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="muet-table">\
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="muet_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CGPA" name="muet_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "Foundation") {
            var el = document.getElementById("foundation-field");
            if (el != null) {
                alert("Foundation qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper foundation-field" id="foundation-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Foundation </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="foundation-table">\
                            <tr>\
                            <td>University / College</td><td><input type="text" class="form-control" name="foundation_study" required placeholder="University / College"></td>\
                            </tr>\
                            <tr>\
                            <td>Duration of Study</td><td><input type="number" class="form-control" name="foundation_year" placeholder="Duration of Study"></td>\
                            </tr>\
                            <tr>\
                            <td>\
                            <p>Major</p>\
                            <input type="hidden" name="foundation_type" value="' +
                        xval +
                        '">\
                            <input type="text" class="form-control" name="foundation_major" placeholder="Major" required>\
                            </td>\
                            <td>\
                            <p>CGPA</p>\
                        <input type="text" class="form-control" placeholder="CGPA" name="foundation_cgpa" id="" required>\
                            </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "SACE") {
            var el = document.getElementById("sace-field");
            if (el != null) {
                alert("SACE qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper sace-field" id="sace-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">SACE </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="sace-table">\
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="sace_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="SACE" name="sace_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "CAT") {
            var el = document.getElementById("cat-field");
            if (el != null) {
                alert("CAT qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper cat-field" id="cat-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Certified Accounting Technician </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="cat-table">\
                            <thead>\
                                <th>CAT</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="cat_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CAT" name="cat_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
    });
    $("#addspmrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
    $("#addstamrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
    $("#adduecrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
    $("#addstpmrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
    $("#addalevelrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
    $("#addolevelrow").click(function (e) {
        e.preventDefault();
        console.log("enter");
    });
});

function addRow() {
    let spmlistarr = [];
    for (let i = 0; i < listSPM.length; i++) {
        spmlistarr.push(
            '<option value="' +
                listSPM[i][0] +
                '">' +
                listSPM[i][1] +
                "</option>"
        );
    }
    let spmgredlistarr = [];
    for (let i = 0; i < listGradeSPM.length; i++) {
        spmgredlistarr.push(
            '<option value="' +
                listGradeSPM[i][0] +
                '">' +
                listGradeSPM[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="spm_subject[]">' +
        spmlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="spm_grade_id[]">' +
        spmgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                   Delete\
                </button>\
            </td>\
        </tr>';
    $("#spm-table tr:last").after(markup);
}

function addRowStam() {
    let stamlistarr = [];
    for (let i = 0; i < listSTAM.length; i++) {
        stamlistarr.push(
            '<option value="' +
                listSTAM[i][0] +
                '">' +
                listSTAM[i][1] +
                "</option>"
        );
    }
    let stamgredlistarr = [];
    for (let i = 0; i < listGradeSTAM.length; i++) {
        stamgredlistarr.push(
            '<option value="' +
                listGradeSTAM[i][0] +
                '">' +
                listGradeSTAM[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="stam_subject[]">' +
        stamlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="stam_grade_id[]">' +
        stamgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#stam-table tr:last").after(markup);
}

function addRowUec() {
    let ueclistarr = [];
    for (let i = 0; i < listUEC.length; i++) {
        ueclistarr.push(
            '<option value="' +
                listUEC[i][0] +
                '">' +
                listUEC[i][1] +
                "</option>"
        );
    }
    let uecgredlistarr = [];
    for (let i = 0; i < listGradeUEC.length; i++) {
        uecgredlistarr.push(
            '<option value="' +
                listGradeUEC[i][0] +
                '">' +
                listGradeUEC[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="uec_subject[]">' +
        ueclistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="uec_grade_id[]">' +
        uecgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#uec-table tr:last").after(markup);
}

function addRowStpm() {
    let stpmlistarr = [];
    for (let i = 0; i < listSTPM.length; i++) {
        stpmlistarr.push(
            '<option value="' +
                listSTPM[i][0] +
                '">' +
                listSTPM[i][1] +
                "</option>"
        );
    }
    let stpmgredlistarr = [];
    for (let i = 0; i < listGradeSTPM.length; i++) {
        stpmgredlistarr.push(
            '<option value="' +
                listGradeSTPM[i][0] +
                '">' +
                listGradeSTPM[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="stpm_subject[]">' +
        stpmlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="stpm_grade_id[]">' +
        stpmgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#stpm-table tr:last").after(markup);
}


function addRowAlevel() {
    let alevellistarr = [];
    for (let i = 0; i < listALEVEL.length; i++) {
        alevellistarr.push(
            '<option value="' +
                listALEVEL[i][0] +
                '">' +
                listALEVEL[i][1] +
                "</option>"
        );
    }
    let alevelgredlistarr = [];
    for (let i = 0; i < listGradeALEVEL.length; i++) {
        alevelgredlistarr.push(
            '<option value="' +
                listGradeALEVEL[i][0] +
                '">' +
                listGradeALEVEL[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="alevel_subject[]">' +
        alevellistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="alevel_grade_id[]">' +
        alevelgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#alevel-table tr:last").after(markup);
}

function addRowOlevel() {
    let olevellistarr = [];
    for (let i = 0; i < listOLEVEL.length; i++) {
        olevellistarr.push(
            '<option value="' +
                listOLEVEL[i][0] +
                '">' +
                listOLEVEL[i][1] +
                "</option>"
        );
    }
    let olevelgredlistarr = [];
    for (let i = 0; i < listGradeOLEVEL.length; i++) {
        olevelgredlistarr.push(
            '<option value="' +
                listGradeOLEVEL[i][0] +
                '">' +
                listGradeOLEVEL[i][1] +
                "</option>"
        );
    }

    var markup =
        '<tr>\
            <td>\
                <select class="form-control" name="olevel_subject[]">' +
        olevellistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" name="olevel_grade_id[]">' +
        olevelgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" onclick="$(this).parent().parent().remove();" class="btn btn-danger btn-md float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#olevel-table tr:last").after(markup);
}



