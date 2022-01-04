<template>
    <div class="card" style="width:100%; height:100%;">
        <div
            class="card-candidate"
            style="
            display:flex;
            flex-direction:row;
            position: absolute;"
        >
            <figure
                style="
                height: 100%;
                width: 40%;
                min-width: 35%;
                position: relative;"
            >
                <img
                    style="width:100%; height:100%; object-fit: cover;backface-visibility: hidden;"
                    src="../../../assets/profile_1.jpg"
                />
            </figure>
            <div
                class="custom-flex-column"
                style="
                padding: 1rem;justify-content: space-around;"
            >
                <div class="custom-flex-column" style="height:auto;">
                    <div style="text-align:start; font-size:0.8rem;">
                        {{ name }}
                    </div>
                    <div style="text-align:start; font-size:0.8rem;">
                        Faculty of Accounting
                    </div>
                </div>
                <div class="py-2">
                    "Maju Mahasiswa Untuk Negara"
                </div>
                <div
                    style="
                    display:flex;
                    width: 100%;
                    justify-content: flex-end;"
                >
                    <section title=".squaredTwo">
                        <!-- .squaredTwo -->
                        <div class="squaredTwo">
                            <input
                                type="checkbox"
                                value="None"
                                :id="'squaredTwo' + id"
                                name="check"
                            />
                            <label :for="'squaredTwo' + id"></label>
                        </div>
                        <!-- end .squaredTwo -->
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CandidateDetailsCard",
    props: {
        name: { type: String, required: true, default: "" },
        id: { type: String, required: true, default: "" }
    }
};
</script>

<style lang="scss" scoped>
figure {
    margin: 0;
}
.card-candidate {
    cursor: pointer;
    position: absolute;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    height: 100%;
    border: 1px solid rgba(255, 255, 255, 0.18);
    top: 50%;
    transform: translateY(-50%);
    overflow: hidden;
}
.custom-flex-column {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    height: 100%;
    width: 100%;
}

/* .squaredTwo */
.squaredTwo {
    width: 28px;
    height: 28px;
    position: relative;
    background: #fcfff4;
    background: #b3bead;
    box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
    label {
        width: 20px;
        height: 20px;
        cursor: pointer;
        position: absolute;
        left: 4px;
        top: 4px;
        background: #979ba1;
        &:after {
            content: "";
            width: 13px;
            height: 8px;
            position: absolute;
            top: 4px;
            left: 4px;
            border: 3px solid #fcfff4;
            border-top: none;
            border-right: none;
            background: transparent;
            opacity: 0;
            transform: rotate(-45deg);
        }
        &:hover::after {
            opacity: 0.3;
        }
    }
    input[type="checkbox"] {
        visibility: hidden;
        &:checked + label:after {
            opacity: 1;
        }
    }
}
</style>
