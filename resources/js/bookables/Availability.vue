<template>
    <div>
        <h6 class="text-uppercase font-weight-holder">
            check availability:
            <transition name="fade">
                <span v-if="hasAvailability" class="text-success font-weight-bold font-italic"> AVAILABLE</span>
                <span v-if="noAvailability" class="text-danger font-weight-bold font-italic"> NOT AVAILABLE</span>
            </transition>
        </h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="label">From</label>
                <VueDatePicker v-model="StartDate"
                               :class="[{'is-invalid':errorFor('to')}]"
                               placeholder="Start date"
                               :color="color"
                               class="dateColor"
                               :allowed-dates="allowedStartDate"
                ></VueDatePicker>
                <validation-errors :errors="errorFor('from')"></validation-errors>
            </div>

            <div class="form-group col-md-6">
                <label class="label">To</label>
                <VueDatePicker v-model="EndDate"
                               :class="[{'is-invalid':errorFor('to')}]"
                               placeholder="End date"
                               :color="color"
                               class="dateColor"
                               :allowed-dates="allowedEndDate"
                ></VueDatePicker>
                <validation-errors :errors="errorFor('to')"></validation-errors>
            </div>

            <button class="btn btn-block btn-success" :disabled="loading" @click="check()" style="margin: 6px;">
                <span v-if="!loading">Check!</span>
                <span v-else>
                    <i class="fas fa-cog fa-spin"></i> Checking...
                </span>
            </button>
        </div>
    </div>
</template>

<script>
    import {is422} from "../shared/utils/response";
    import Datepicker from 'vuejs-datepicker';
    export default {
        components:{Datepicker},
        data(){
            return{
                StartDate:new Date(),
                EndDate:null,
                loading:false,
                status:null,
                error:null,
                classObject: {
                    'btn-warning': false,
                    'btn-success': false
                },
                customDate:new Date(),
                color: '#4f88ff',
            }
        },
        created() {
            this.getTheme
        },
        methods:{
            async check(){
                this.loading = true
                this.error = null
                this.$store.commit('setLastSearch',{from:this.StartDate,to:this.EndDate})
                try{
                    this.status = (await axios.get(`/api/bookables/${this.$route.params.id}/availability?from=${this.StartDate}&to=${this.EndDate}`)).status;
                    this.$emit("availability",this.hasAvailability);
                }catch (e) {
                    if (is422(e)){
                        this.error = e.response.data.errors;
                    }
                    this.status = e.response.status;
                }
                this.loading = false;
            },
            errorFor(field){
                return this.hasError && this.error[field] ? this.error[field] : null;
            },
            allowedStartDate: StartDate => {
                var date = new Date();
                date.setDate(date.getDate() - 1);
                return new Date(StartDate).valueOf() > date;
            },
            allowedEndDate(EndDate){

                var date = new Date(this.StartDate);
                date.setDate(date.getDate() - 1);

                return new Date(EndDate).valueOf() >  date;
            },
        },
        computed:{
            hasError(){
                return this.status === 422 && this.error !== null;
            },
            hasAvailability(){
                return this.status === 200;
            },
            noAvailability(){
                return this.status === 404;
            },
        },
        watch:{
            getTheme(){
                const activeTheme = localStorage.getItem("user-theme");
                console.log(activeTheme);
                if (activeTheme === "light-theme") {
                    this.classObject["btn-success"] = true
                    this.classObject["btn-warning"] = false
                } else {
                    this.classObject["btn-success"] = false
                    this.classObject["btn-warning"] = true
                }
            }
        }
    }
</script>

<style scoped>
    label{
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: bolder;
    }

    .invalid-feedback{
        color: #b22222;
    }


    .custom__button {
        text-transform: capitalize;
        padding: 8px;
        background-color: #2d2b55;
    }

</style>
