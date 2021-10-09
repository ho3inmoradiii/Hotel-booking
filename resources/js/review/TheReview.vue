<template>
    <div>
        <the-success v-if="success">
            You have left a review, thank you very much.
        </the-success>
        <fatal-error v-if="error"></fatal-error>
        <div class="row" v-if="!success && !error">
            <div
                :class="[{'col-md-4':twoColumn},
            {'d-none':oneColumn}]"
            >
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading...</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link :to="{name:'bookable',params:{id:booking.bookable.bookable_id}}">
                                    {{ booking.bookable.title }}
                                </router-link>
                            </p>
                            <p>From {{ booking.from }} To {{ booking.to }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                :class="[{'col-md-8':twoColumn},
            {'col-md-12':oneColumn}]"
            >
                <div v-if="loading">
                    Loading...
                </div>
                <div v-else>
                    <div v-if="alreadyReviewed">
                        You have already left a review for this booking
                    </div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted">Select the star rating</label>
                            <star-rating class="fa-3x" v-model="review.rating"></star-rating>
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted">Select the star rating</label>
                            <textarea class="form-control"
                                      id="content"
                                      cols="30"
                                      rows="10"
                                      v-model="review.content"
                                      :class="[{'is-invalid':errorFor('content')}]"
                            ></textarea>
                            <validation-errors :errors="errorFor('content')"></validation-errors>
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" @click.prevent="submit" :disabled="sending">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {is404,is422} from "../shared/utils/response";
    import validationError from "../shared/mixins/validationError";

    export default {
        mixins:[validationError],
        data(){
            return{
                review:{
                    id:null,
                    rating:5,
                    content:null
                },
                existingReview:null,
                loading:false,
                booking:null,
                error:false,
                sending:false,
                success:false
            }
        },
        created() {
            this.review.id = this.$route.params.id;
            this.loading=true;
            axios.get(`/api/reviews/${this.review.id}`)
            .then(res => this.existingReview = res.data.data)
            .catch(error => {
                if (is404(error)){
                    return axios.get(`/api/booking-by-review/${this.review.id}`)
                    .then(response => {
                        this.booking = response.data.data;
                    }).catch(err => {
                        this.error = !is404(err);
                        });
                }
            }).then(() => (this.loading = false))
        },
        computed:{
            alreadyReviewed(){
                return this.hasReview || !this.hasBooking;
            },
            hasReview(){
                return this.existingReview !== null;
            },
            hasBooking(){
                return this.booking !== null;
            },
            oneColumn(){
                return !this.loading && this.alreadyReviewed
            },
            twoColumn(){
                return this.loading || !this.alreadyReviewed
            }
        },
        methods:{
            submit(){
                this.errors = null;
                this.sending = true;
                this.success = false;
                console.log(this.review)
                axios.post('/api/reviews',this.review)
                .then(res => {
                    this.success = (res.status === 201)
                })
                .catch(error => {
                    if(is422(error)){
                        const errors = error.response.data.errors;
                        if (errors["content"] && _.size(errors) === 1){
                            this.errors = errors;
                        }
                        return;
                    }
                    this.error = true;
                })
                .then(() => (this.sending = false))
            },
        }
    }
</script>


