<template>
    <div style="padding: 1.25rem" class="d-none d-md-block">
        <h6 class="text-uppercase font-weight-bolder pt-5">Review List</h6>

        <div v-if="!reviews">Reviews is loading...</div>

        <div v-else>
            <div class="border-bottom" v-for="(review , index) in reviews" :key="index">
                <div class="row pt-4">
                    <div class="col-md-6 reviewItem">
                        Ali rezaii
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <star-rating class="fa-lg" :value="review.rating">{{ review.rating }}</star-rating>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 reviewItem">{{ review.created_at }}</div>
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12 reviewItem">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                reviews:null
            }
        },
        created() {
            axios.get(`/api/bookables/${this.$route.params.id}/reviews`)
            .then(res => {
                this.reviews = res.data.data
            });
        }
    }
</script>
