$(document).ready(function () {
    var increment = 0;
    // Existing
    var appended = [];

    if(existing)
    {
        existing.forEach(function(ele){
        if(appended.indexOf(ele.qualifications.id) == -1)
        {
            if(ele.qualifications.qualification_code == "SPM")
              {
                spmdefault = false;
              }

            addQualification(ele.qualifications.qualification_code,ele.qualifications.id);
            appended.push(ele.qualifications.id);
        }

          var letter = "addRow" + firstLetterUpper(ele.qualifications.qualification_code);

          eval(letter + "('"+ele.id+"','"+ele.subject+"','"+ele.grade_id+"')")
        });
    }

    //diploma, bachelor, matric
    if(existingcgpa)
    {
        existingcgpa.forEach(function(ele){
            if(appended.indexOf(ele.qualifications.id) == -1)
            {
              let data = [ele.id, ele.applicant_study, ele.applicant_major, ele.applicant_year, ele.applicant_cgpa];
              addQualification(ele.qualifications.qualification_code,ele.qualifications.id,data);
              appended.push(ele.qualifications.id);
            }
        });
    }

    $(document).on('click', '.tambah-qualification', function(e) {
        e.preventDefault();
         var x = $("#qualificationselect :selected").text();
         var xval = $("#qualificationselect :selected").val();
         addQualification(x,xval);
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


function firstLetterUpper(text)
{
    var trim = text.replace(/\s/g, "");
    return trim.substr(0,1).toUpperCase() + trim.substr(1).toLowerCase();
}

function addQualification(x,xval,data=null){
    var myid = data ? data[0] : 0;
    var mystudy = data ? data[1] : "";
    var mymajor = data ? data[2] : "";
    var myyear = data ? data[3] : "";
    var mycgpa = data ? data[4] : "";

    $("#qualification option[value="+xval+"]").remove();
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
                        <h5 class="mb-4">Sijil Pelajaran Malaysia</h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                        <button type="button" class="btn btn-primary btn-sm float-right" id="addspmrow" onclick="addRowSpm();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                        <button type="button" class="btn btn-danger float-right btn-sm mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="spm_type" value="'+xval+'">\
                        <table class="table table-bordered" id="spm-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_spm[]" value="0">\
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
                                    <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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

                if(spmdefault)
                {
                    mandatorySub.forEach(function(e){
                        addRowSpm(0,e,1);
                    });
                }
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
                        <h5 class="mb-4">UEC</h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                        <button class="btn btn-primary float-right btn-sm" id="adduecrow" onclick="addRowUec();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                        <button type="button" class="btn btn-danger float-right btn-sm mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="uec_type" value="'+xval +'">\
                        <table class="table table-bordered" id="uec-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_uec[]" value="0">\
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
                                    <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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
                        <h5 class="mb-4">Sijil Tinggi Pelajaran Malaysia</h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                         <button class="btn btn-primary btn-sm float-right" id="addstpmrow" onclick="addRowStpm();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                         <button type="button" class="btn btn-danger btn-sm float-right mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="stpm_type" value="'+xval +'">\
                        <table class="table table-bordered" id="stpm-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_stpm[]" value="0">\
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
                                    <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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
                        <h5 class="mb-4">O Level </h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                        <button class="btn btn-primary float-right btn-sm" id="addolevelrow" onclick="addRowOlevel();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                        <button type="button" class="btn btn-danger float-right btn-sm mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="olevel_type" value="'+xval+'">\
                        <table class="table table-bordered" id="olevel-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_olevel[]" value="0">\
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
                                    <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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
                        <h5 class="mb-4">A Level</h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                        <button class="btn btn-primary float-right btn-sm" id="addalevelrow" onclick="addRowAlevel();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                        <button type="button" class="btn btn-danger float-right btn-sm mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="alevel_type" value="'+xval+'">\
                        <table class="table table-bordered" id="alevel-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_alevel[]" value="0">\
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
                                    <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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
                        <h5 class="mb-4">Sijil Tinggi Agama Malaysia </h5>\
                        <div id="existfile'+xval+'" class="mb-2">\
                        </div>\
                        <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                        <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                        <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                        <button class="btn btn-primary float-right btn-sm" id="addstamrow" onclick="addRowStam();return false;"><i class="fal fa-plus"></i> Add Subject</button>\
                        <button type="button" class="btn btn-danger float-right btn-sm mr-2" data-type="qualification" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <input type="hidden" name="stam_type" value="' +xval +'">\
                        <table class="table table-bordered" id="stam-table">\
                            <thead>\
                                <th>Subject Name</th>\
                                <th>Result</th>\
                                <th></th>\
                        </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_stam[]" value="0">\
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
                                   <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
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
        else if (x == "Bachelor Degree") {
            var el = document.getElementById("bachelor-field");
            if (el != null) {
                alert("Bachelor Degree qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper bachelor-field" id="bachelor-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Bachelor Degree </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                    <input type="hidden" name="bachelor_type" value="' +xval +'">\
                        <table class="table table-bordered" id="bachelor-table">\
                            <tr>\
                                <td>University / College *</td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="bachelor_study" value="'+mystudy+'" placeholder="University / College" required onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_bachelor" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Programme / Major</td>\
                                <td colspan="3"><input type="text" class="form-control" value="'+mymajor+'" name="bachelor_major" placeholder="Programme / Major" onkeyup="this.value = this.value.toUpperCase();"></td>\
                            </tr>\
                            <tr>\
                                <td>Graduation Year</td>\
                                <td><input type="text" class="form-control" value="'+myyear+'" name="bachelor_year"></td>\
                                <td>CGPA</td>\
                                <td>\
                                    <input type="text" class="form-control" placeholder="CGPA" value="'+mycgpa+'" name="bachelor_cgpa" id="" required>\
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
                    <div id="existfile'+xval+'"class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger float-right btn-sm" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="diploma-table">\
                            <tr>\
                                <td>University / College<input type="hidden" name="diploma_type" value="' +
                        xval +
                        '">\
                                </td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="diploma_study" value="'+mystudy+'" required placeholder="University / College" onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_diploma" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Programme / Major</td>\
                                <td colspan="3"><input type="text" class="form-control" name="diploma_major" value="'+mymajor+'" placeholder="Programme / Major" onkeyup="this.value = this.value.toUpperCase();" required ></td>\
                            </tr>\
                            <tr>\
                            <td>Graduation Year</td>\
                            <td><input type="text" class="form-control" name="diploma_year" value="'+myyear+'" placeholder="Graduation Year" required></td>\
                            <td>CGPA</td>\
                            <td><input type="text" class="form-control" placeholder="CGPA" name="diploma_cgpa" value="'+mycgpa+'" id="" required></td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "SVM") {
            var el = document.getElementById("svm-field");
            if (el != null) {
                alert("Sijil Vokasional Malaysia qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper svm-field" id="svm-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Sijil Vokasional Malaysia </h5>\
                    <div id="existfile'+xval+'"class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger float-right btn-sm" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="svm-table">\
                            <tr>\
                                <td>University / College<input type="hidden" name="svm_type" value="' +
                        xval +
                        '">\
                                </td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="svm_study" value="'+mystudy+'" required placeholder="University / College" onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_svm" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Course</td>\
                                <td colspan="3"><input type="text" class="form-control" name="svm_major" value="'+mymajor+'" placeholder="Course" onkeyup="this.value = this.value.toUpperCase();" required ></td>\
                            </tr>\
                            <tr>\
                            <td>Graduation Year</td>\
                            <td><input type="text" class="form-control" name="svm_year" value="'+myyear+'" placeholder="Graduation Year" required></td>\
                            <td>CGPA</td>\
                            <td><input type="text" class="form-control" placeholder="CGPA" name="svm_cgpa" value="'+mycgpa+'" id="" required></td>\
                            </tr>\
                        </table>\
                    </div>\
                </div>'
                );
                fieldWrapper.append(fName);
                $(".content").append(fieldWrapper);
            }
        }
        else if (x == "APEL") {
            var el = document.getElementById("apel-field");
            if (el != null) {
                alert("Accreditation of Prior Experiental Learning qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper apel-field" id="apel-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Accreditation of Prior Experiental Learning </h5>\
                    <div id="existfile'+xval+'"class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger float-right btn-sm" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="svm-table">\
                            <tr>\
                                <td>University / College<input type="hidden" name="apel_type" value="' +
                        xval +
                        '">\
                                </td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="apel_study" value="'+mystudy+'" required placeholder="University / College" onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_apel" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Course</td>\
                                <td colspan="3"><input type="text" class="form-control" name="apel_major" value="'+mymajor+'" placeholder="Course" onkeyup="this.value = this.value.toUpperCase();" required ></td>\
                            </tr>\
                            <tr>\
                            <td>APEL T</td>\
                            <td><input type="number" class="form-control" placeholder="Example: 4" name="apel_cgpa" value="'+mycgpa+'" id="" required></td>\
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
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="matriculation-table">\
                            <tr>\
                                <td>Kolej Matrikulasi *</td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="matriculation_study" value="'+mystudy+'" required placeholder="Kolej Matrikulasi" onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_matriculation" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Graduation Year</td>\
                                <td><input type="text" class="form-control" value="'+myyear+'" name="matriculation_year"></td>\
                                <td>CGPA</td>\
                                <td><input type="hidden" name="matriculation_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CGPA" value="'+mycgpa+'" name="matriculation_cgpa" id="" required>\
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
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="muet-table">\
                            <thead>\
                                <th>MUET</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_muet" value="'+myid+'">\
                                <input type="hidden" name="muet_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="MUET BAND" value="'+mycgpa+'" name="muet_cgpa" id="" required>\
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
        else if (x == "SKM") {
            var el = document.getElementById("skm-field");
            if (el != null) {
                alert("SKM qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper skm-field" id="skm-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Sijil Kemahiran Malaysia </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="skm-table">\
                            <thead>\
                                <th>SKM Level</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_skm" value="'+myid+'">\
                                <input type="hidden" name="skm_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="SkM Level" value="'+mycgpa+'" name="skm_cgpa" id="" required>\
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
        else if (x == "MQF") {
            var el = document.getElementById("mqf-field");
            if (el != null) {
                alert("MQF qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper mqf-field" id="mqf-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">MQF </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="mqf-table">\
                            <thead>\
                                <th>MQF Level</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_mqf" value="'+myid+'">\
                                <input type="hidden" name="mqf_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="MQF Level" value="'+mycgpa+'" name="mqf_cgpa" id="" required>\
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
        else if (x == "KKM") {
            var el = document.getElementById("kkm-field");
            if (el != null) {
                alert("KKM qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper mqf-field" id="kkm-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">Kolej Komuniti Malaysia </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i>Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="kkm-table">\
                            <thead>\
                                <th>KKM Level</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_kkm" value="'+myid+'">\
                                <input type="hidden" name="kkm_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="KKM Level" value="'+mycgpa+'" name="kkm_cgpa" id="" required>\
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
        else if (x == "ICAEW") {
            var el = document.getElementById("icaew-field");
            if (el != null) {
                alert("ICAEW qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper icaew-field" id="icaew-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">ICAEW </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="icaew-table">\
                            <thead>\
                                <th>ICAEW</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_icaew" value="'+myid+'">\
                                <input type="hidden" name="icaew_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="ICAEW" value="'+mycgpa+'" name="icaew_cgpa" id="" required>\
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
        else if (x == "IELTS") {
            var el = document.getElementById("ielts-field");
            if (el != null) {
                alert("IELTS qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper ielts-field" id="ielts-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">IELTS </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="ielts-table">\
                            <thead>\
                                <th>IELTS</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_ielts" value="'+myid+'">\
                                <input type="hidden" name="ielts_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="IELTS BAND" value="'+mycgpa+'" name="ielts_cgpa" id="" required>\
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
        else if (x == "TOEFL") {
            var el = document.getElementById("toefl-field");
            if (el != null) {
                alert("TOEFL qualifications already added!");
            } else {
                var fieldWrapper = $(
                    '<div class="fieldwrapper toefl-field" id="toefl-field"/>'
                );
                var fName = $(
                    '<hr class="mt-2 mb-3"><div class="row">\
                    <div class="col-12">\
                    <h5 class="mb-4">TOEFL </h5>\
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="toefl-table">\
                            <thead>\
                                <th>TOEFL</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_toefl" value="'+myid+'">\
                                <input type="hidden" name="toefl_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="TOEFL BAND" value="'+mycgpa+'" name="toefl_cgpa" id="" required>\
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
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="foundation-table">\
                            <tr>\
                            <td>University / College<input type="hidden" name="foundation_type" value="' +
                        xval +
                        '">\
                                </td>\
                                <td colspan="3">\
                                <input type="text" class="form-control" name="foundation_study" value="'+mystudy+'" required placeholder="University / College" onkeyup="this.value = this.value.toUpperCase();">\
                                <input type="hidden" name="exist_foundation" value="'+myid+'">\
                                </td>\
                            </tr>\
                            <tr>\
                                <td>Programme / Major</td>\
                                <td colspan="3"><input type="text" class="form-control" name="foundation_major" value="'+mymajor+'" placeholder="Major" required onkeyup="this.value = this.value.toUpperCase();"></td>\
                            </tr>\
                            <tr>\
                            <td>Graduation Year</td>\
                            <td><input type="text" class="form-control" name="foundation_year" value="'+myyear+'" placeholder="Graduation Year" required></td>\
                            <td>CGPA</td>\
                            <td><input type="text" class="form-control" placeholder="CGPA" name="foundation_cgpa" value="'+mycgpa+'" id="" required></td>\
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
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="sace-table">\
                            <thead>\
                                <th>ATAR</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_sace" value="'+myid+'">\
                                <input type="hidden" name="sace_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="ATAR" name="sace_cgpa" value="'+mycgpa+'" id="" required>\
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
                    <div id="existfile'+xval+'" class="mb-2">\
                    </div>\
                    <input type="hidden" name="filetype[]" value="'+xval+'"/>\
                    <input type="file" name="file[]" accept="application/pdf, image/png, image/jpg"/>\
                    <p class="text-danger">** Upload PDF / Image (PNG, JPG, JPEG)</p>\
                    <button type="button" class="btn btn-danger btn-sm float-right" data-type="academic" onclick="Delete(this,'+xval+')"><i class="fal fa-trash"></i> Delete Qualification</button>\
                    </div>\
                </div>\
                <div class="row mt-4">\
                    <div class="col-md-12">\
                        <table class="table table-bordered" id="cat-table">\
                            <thead>\
                                <th>CAT</th>\
                            </thead>\
                            <tr>\
                                <td>\
                                <input type="hidden" name="exist_cat" value="'+myid+'">\
                                <input type="hidden" name="cat_type" value="' +
                        xval +
                        '">\
                                    <input type="text" class="form-control" placeholder="CAT" name="cat_cgpa" value="'+mycat+'" id="" required>\
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


        if(myfiles[xval])
        {
            console.log('In')
            $('#existfile'+xval).append(`<a href="${publicpath}/qualificationfile/${myfiles[xval][0].file_name}/Download">View Uploaded File</a> `);
            // $('#existfile'+xval).append(`<a href="${publicpath}/qualificationfile/${myfiles[xval][0].file_name}/View" target="_blank">View</a> | <a href="${publicpath}/qualificationfile/${myfiles[xval][0].file_name}/Download">Download</a> `);
        }
}

var spmsub = [];
function addRowSpm(id = null, sub = null,grade = null) {
    var myid = id ? id : 0;
    if(id !== null)
    {
        $('#spm-table tbody').empty()
    }

    var rowCount = $('#spm-table tr').length;
    var subCode = "";

    let spmlistarr = [];
    var Showbuttons = `<button value="-" data-type="result" onclick="Delete(this,${myid})" class="btn btn-danger btn-sm float-right remove">Delete</button>`;

    for (let i = 0; i < listSPM.length; i++) {

        if(listSPM[i][0] && spmsub.indexOf(listSPM[i][0]) == -1)
        spmlistarr.push(
            '<option value="' +
                listSPM[i][0] +
                '">' +
                listSPM[i][1] +
                "</option>"
        );
        if(sub && listSPM[i][0] == sub)
        {
            var subCode = listSPM[i][1];
        }

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

    if( mandatorySub.indexOf(sub) !== -1 )
    {
      Showbuttons = "";
      spmlistarr = [`<option value="${sub}">${subCode}</option`];
    }

    var markup =
        '<tr>\
            <td>\
                <input type="hidden" name="exist_spm[]" value="'+myid+'">\
                <select class="form-control" id="spm_subject'+rowCount+'" name="spm_subject[]">' +
        spmlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="spm_grade_id'+rowCount+'" name="spm_grade_id[]">' +
        spmgredlistarr.toString() +
        '</select>\
            </td>\
            <td>'+ Showbuttons +'</td>\
        </tr>';
    $("#spm-table tr:last").after(markup);

    if(sub && grade)
    {
        spmsub.push(sub);
        $("#spm_subject"+rowCount).val(sub);
        $("#spm_grade_id"+rowCount).val(grade);
    }
}

var stamsub = [];
function addRowStam(id = null, sub = null,grade = null) {

    var myid = id ? id : 0;

    if(id)
    {
        $('#stam-table tbody').empty()
    }

    var rowCount = $('#stam-table tr').length;

    let stamlistarr = [];
    for (let i = 0; i < listSTAM.length; i++) {
        if(stamsub.indexOf(listSTAM[i][0]) == -1)
        {
            stamlistarr.push(
                '<option value="' +
                    listSTAM[i][0] +
                    '">' +
                    listSTAM[i][1] +
                    "</option>"
            );
        }
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
                <input type="hidden" name="exist_stam[]" value="'+myid+'">\
                <select class="form-control" id="stam_subject'+rowCount+'" name="stam_subject[]">' +
        stamlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="stam_grade_id'+rowCount+'" name="stam_grade_id[]">' +
        stamgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#stam-table tr:last").after(markup);
    if(sub && grade)
    {
        stamsub.push(sub);
        $("#stam_subject"+rowCount).val(sub);
        $("#stam_grade_id"+rowCount).val(grade);
    }
}

var uecsub = [];
function addRowUec(id = null, sub = null,grade = null) {

    var myid = id ? id : 0;
    if(id)
    {
        $('#uec-table tbody').empty()
    }

    var rowCount = $('#uec-table tr').length;

    let ueclistarr = [];
    for (let i = 0; i < listUEC.length; i++) {
        if(uecsub.indexOf(listUEC[i][0]) == -1)
        {
            ueclistarr.push(
                '<option value="' +
                    listUEC[i][0] +
                    '">' +
                    listUEC[i][1] +
                    "</option>"
            );
        }
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
            <input type="hidden" name="exist_uec[]" value="'+myid+'">\
                <select class="form-control" id="uec_subject'+rowCount+'" name="uec_subject[]">' +
        ueclistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="uec_grade_id'+rowCount+'" name="uec_grade_id[]">' +
        uecgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#uec-table tr:last").after(markup);
    if(sub && grade)
    {
        uecsub.push(sub);
        $("#uec_subject"+rowCount).val(sub);
        $("#uec_grade_id"+rowCount).val(grade);
    }
}

var stpmsub = [];
function addRowStpm(id = null, sub = null,grade = null) {

    var myid = id ? id : 0;

    if(id)
    {
        $('#stpm-table tbody').empty()
    }

    var rowCount = $('#stpm-table tr').length;

    let stpmlistarr = [];
    for (let i = 0; i < listSTPM.length; i++) {
        if(stpmsub.indexOf(listSTPM[i][0]) == -1)
        {
            stpmlistarr.push(
                '<option value="' +
                    listSTPM[i][0] +
                    '">' +
                    listSTPM[i][1] +
                    "</option>"
            );
        }
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
            <input type="hidden" name="exist_stpm[]" value="'+myid+'">\
                <select class="form-control" id="stpm_subject'+rowCount+'" name="stpm_subject[]">' +
        stpmlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="stpm_grade_id'+rowCount+'" name="stpm_grade_id[]">' +
        stpmgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
               <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#stpm-table tr:last").after(markup);
    if(sub && grade)
    {
        $("#stpm_subject"+rowCount).val(sub);
        $("#stpm_grade_id"+rowCount).val(grade);
    }
}


var alevelsub = [];
function addRowAlevel(id = null, sub = null,grade = null) {
    var myid = id ? id : 0;
    if(id)
    {
        $('#alevel-table tbody').empty()
    }

    var rowCount = $('#alevel-table tr').length;

    let alevellistarr = [];
    for (let i = 0; i < listALEVEL.length; i++) {
        if(alevelsub.indexOf(listALEVEL[i][0]) == -1)
        {
            alevellistarr.push(
                '<option value="' +
                    listALEVEL[i][0] +
                    '">' +
                    listALEVEL[i][1] +
                    "</option>"
            );
        }
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
            <input type="hidden" name="exist_alevel[]" value="'+myid+'">\
                <select class="form-control" id="alevel_subject'+rowCount+'" name="alevel_subject[]">' +
        alevellistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="alevel_grade_id'+rowCount+'" name="alevel_grade_id[]">' +
        alevelgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#alevel-table tr:last").after(markup);
    if(sub && grade)
    {
        alevelsub.push(sub);
        $("#alevel_subject"+rowCount).val(sub);
        $("#alevel_grade_id"+rowCount).val(grade);
    }
}

var olevelsub = [];
function addRowOlevel(id = null, sub = null,grade = null) {
    var myid = id ? id : 0;
    if(id)
    {
        $('#olevel-table tbody').empty()
    }

    var rowCount = $('#olevel-table tr').length;

    let olevellistarr = [];
    for (let i = 0; i < listOLEVEL.length; i++) {
        if(olevelsub.indexOf(listOLEVEL[i][0]) == -1)
        {
            olevellistarr.push(
                '<option value="' +
                    listOLEVEL[i][0] +
                    '">' +
                    listOLEVEL[i][1] +
                    "</option>"
            );
        }
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
            <input type="hidden" name="exist_olevel[]" value="'+myid+'">\
                <select class="form-control" id="olevel_subject'+rowCount+'" name="olevel_subject[]">' +
        olevellistarr.toString() +
        '</select>\
            </td>\
            <td>\
                <select class="form-control" id="olevel_grade_id'+rowCount+'" name="olevel_grade_id[]">' +
        olevelgredlistarr.toString() +
        '</select>\
            </td>\
            <td>\
               <button value="-" data-type="result" onclick="Delete(this,'+myid+')" class="btn btn-danger btn-sm float-right remove">\
                    Delete\
                </button>\
            </td>\
        </tr>';
    $("#olevel-table tr:last").after(markup);
    if(sub && grade)
    {
        olevelsub.push(sub);
        $("#olevel_subject"+rowCount).val(sub);
        $("#olevel_grade_id"+rowCount).val(grade);
    }
}



