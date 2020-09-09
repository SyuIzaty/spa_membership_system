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
            // console.log();
            var el2 = document.getElementById("spm-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
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
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper spm-field" id="spm-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Pelajaran Malaysia </h5>\
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
        }else if (x == "Diploma") {
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
        }else if (x == "MUET") {
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
                    <h5 class="mb-4">Muet </h5>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="muet-table">\
                            <thead>\
                                <th>Band</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="muet_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="MUET" name="muet_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }else if (x == "Matriculation") {
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
                                    <input type="text" class="form-control" placeholder="Matriculation" name="matriculation_cgpa" id="" required>\
                                </td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }else if (x == "Foundation") {
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
                            <thead>\
                                <th>CGPA</th>\
                            </thead>\
                            <tr>\
                                <td><input type="hidden" name="foundation_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="Foundation" name="foundation_cgpa" id="" required>\
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
            // console.log();
            var el2 = document.getElementById("stam-field");
            if (el2 != null) {
                // alert("spm qualifications already added!");
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
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper stam-field" id="stam-field"/>'
                );

                var fName = $(
                    '<hr class="mt-2 mb-3">\
                <div class="row">\
                    <div class="col-12">\
                        <h5 class="mb-4">Sijil Tinggi Agama Malaysia </h5>\
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
    });
});
