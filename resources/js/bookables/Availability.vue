<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-holder">
            check availability:
            <transition name="fade">
                <span v-if="hasAvailability" class="text-success font-weight-bold font-italic"> AVAILABLE</span>
                <span v-if="noAvailability" class="text-danger font-weight-bold font-italic"> NOT AVAILABLE</span>
            </transition>
        </h6>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input
                    type="text"
                    id="from"
                    name="from"
                    class="form-control form-control-sm"
                    placeholder="Start date"
                    v-model="StartDate"
                    @keyup.enter="check"
                    :class="[{'is-invalid':errorFor('from')}]"
                >
                <validation-errors :errors="errorFor('from')"></validation-errors>
            </div>

            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input
                    type="text"
                    id="to"
                    name="to"
                    class="form-control form-control-sm"
                    placeholder="End date"
                    v-model="EndDate"
                    @keyup.enter="check"
                    :class="[{'is-invalid':errorFor('to')}]"
                >
                <validation-errors :errors="errorFor('to')"></validation-errors>
            </div>

            <button class="btn btn-secondary btn-block" :disabled="loading" @click="check">
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
    export default {
        data(){
            return{
                StartDate:null,
                EndDate:null,
                loading:false,
                status:null,
                error:null
            }
        },
        created() {
            console.log(this.StartDate)
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
            }
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
            }
        }
    }
</script>

<style scoped>
    label{
        font-size: 0.7rem;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }

    .invalid-feedback{
        color: #b22222;
    }
</style>
